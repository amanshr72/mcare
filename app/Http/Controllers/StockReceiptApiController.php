<?php

namespace App\Http\Controllers;

use App\Models\BranchMaster;
use App\Models\ItemMaster;
use App\Models\PoProductMst;
use App\Models\PoVendorMst;
use App\Models\Product_MST;
use App\Models\StockReceipt;
use App\Models\StockReceiptListItem;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StockReceiptApiController extends Controller
{
    protected $saveReceiptStockEndPoint;
    protected $credentials;
    protected $branchCode;
    protected $godownName;
    protected $docPrefix;

    public function __construct()
    {   
        // Live API
        // $this->saveReceiptStockEndPoint = 'http://logicapi.logicerp.in/ModiCare/SaveReceiptStock';
        // $username = 'ModiCareApi'; $password = 'ModiApi@$#';
        // Demo API
        $this->saveReceiptStockEndPoint = 'http://demo.logicerp.com/api/SaveReceiptStock';
        $username = 'LAdmin'; $password = '1';
        $this->credentials = base64_encode("$username:$password");  
        
        $this->middleware(function ($request, $next) {
            $this->branchCode = Auth::user()->ul ?? 2;  
            $this->godownName = "MATERIALS";  
            $this->docPrefix = "MTR";  
            return $next($request);
        });
        
    }

    public function index()
    {
        $stockReceipts = StockReceiptListItem::latest()->paginate(10);
        return view('stock-receipt.index', compact('stockReceipts'));
    }

    public function create()
    {   
        $items = Product_MST::select('item_code', 'item_name', 'category')->distinct('item_code', 'item_name')->get();
        $location = BranchMaster::select('branchName')->where('branchCode', $this->branchCode)->first();
        return view('stock-receipt.create', compact('items', 'location'));
    }

    public function store(Request $request)
    {
        try {            
            $listItemsArray = json_decode($request->input('listItems'), true);
            
            if ($listItemsArray) {
                foreach ($listItemsArray as $item) {
                    $itemCode[] = $item['itemCodeVal'];
                }
            } else {
                return redirect()->route('stock-receipt.create')->with('danger', 'Ensure at least one item is added to the list., Please try again');
            }

            $stockReceipt = StockReceipt::create([
                'user_id' => Auth::user()->id,
                'Item_Code' => json_encode($itemCode),
                'vendor_company' => $request->vendor_name,
                'location' => $request->location,
                'reference_document_no' => $request->refrence_document_no,
                'reference_date' => $request->refrence_date,
                'user_prefix' => $request->user_prefix,
                'branch_code' => $this->branchCode,
                'doc_prefix' => $this->docPrefix,
                'issued_to' => '',
                'godown_name' => $this->godownName,
                'received_from' => $request->refrence_document_no,  /* Logic for serialization writen in Model */
            ]);

            if (count($listItemsArray) > 0) {
                foreach ($listItemsArray as $item) {
                    $mfgDate = $item['mfgDateVal'] !== '' ? $item['mfgDateVal'] : null;
                    $listItem = StockReceiptListItem::create([
                        'item_masters_id' => ItemMaster::select('id', 'item_code')->where('item_code', $item['itemCodeVal'])->value('id'),
                        'stock_receipts_id' => $stockReceipt->id,
                        'item_name' => $item['itemNameVal'],
                        'item_code' => $item['itemCodeVal'],
                        'lot_no' => null,
                        'quantity' => $item['quantityVal'],
                        'price' => $item['priceVal'],
                        'final_amount' => $item['finalAmount'],
                        'mfg_date' => $mfgDate,
                        'mfg_name' => $item['mfgNameVal'],
                        'expiry_date' => null,
                        'batch_number' => $item['batcheNoVal'],
                    ]);
                    $listItemIds[] = $listItem->id;
                }
            }

            return redirect()->route('stock-receipt.index')->with('success', 'Data has been uploaded successfully');

        } catch (Exception $e) {
            throw $e;
            // return redirect()->route('stock-receipt.index')->with('danger', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function pushAllStock(){
        $stockReceipts = StockReceipt::where('branch_code', $this->branchCode)->where('response_status', 0)->orWhereNull('response_status')->get();
        $listItems = StockReceiptListItem::with('stockReceipt')->whereIn('stock_receipts_id', $stockReceipts->pluck('id')->toArray())->where('Status', 0)->orWhereNull('Status')->get();
        $listItemArray = [];
        $allStatusTrue = true;

        foreach($listItems as $item){
            $listItemArray = [
                'ItemCode' => $item->item_code,
                'LotNo' => $item->lot_no ?? 'CB-1',
                'Quantity' => $item->quantity,
                'Rate' => $item->rate,
                'Mrp' => $item->price,
                'Manufacturing_Date' => null,
                'Expiry_Date' => null
            ];
            
            $jsonRequestData = [
                "Branch_Code" => $this->branchCode,
                "Doc_Prefix" => $this->docPrefix,
                "IssueTo" => "",
                "GodownName" => $this->godownName,
                "ReceivedFrom" => $item->stockReceipt->received_from,
                'ListItems' => [$listItemArray]
            ];
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json', 
                'Authorization' => 'Basic ' . $this->credentials,
            ])->post($this->saveReceiptStockEndPoint, $jsonRequestData);
    
            if($response['Status']){
                $item->update([
                    'Status' => true,
                    'Message' => $response['Message'],
                    'LastSavedDocNo' => $response['LastSavedDocNo'],
                    'LastSavedCode' => $response['LastSavedCode'],
                ]);
            }else{
                $allStatusTrue = false;
                $errMsg[] = '<strong>Warning! for ItemCode: ' . $item->item_code . '</strong>, ' . $response['Message'];
                $item->update(['Status' => 0, 'Message' =>  $response['Message']]);
            }
        }

        return redirect()->route('stock-receipt.index')->with(
            $allStatusTrue ? 'success' : 'pushAllStockError',
            $allStatusTrue ? 'All stocks processed successfully.' : $errMsg
        );
    }

    public function getItemDetails($itemName)
    {
        $item = Product_MST::select('item_code', 'basic_rate', 'batch_number')->where('item_name', $itemName)->first();
        $batchDetails = StockReceiptListItem::select('batch_number', 'mfg_date', 'mfg_name')->where('item_code', $item->item_code)->get();
        return response()->json(['success' => 'true', 'item' => $item, 'batchDetails' => $batchDetails]);
    }

    public function filter(Request $request)
    {
        $batchNumber = $request->batchNumber;
        $vendorName = $request->vendorName;
        $stockReceipts = StockReceiptListItem::query();

        if (isset($batchNumber) && $batchNumber !== '') {
            $stockReceipts = $stockReceipts->where('batch_number', $batchNumber);
        }

        if (isset($vendorName) && $vendorName !== '') {
            $stockReceipts = $stockReceipts->where('vendor_name', $vendorName);
        }

        $stockReceipts = $stockReceipts->latest()->paginate(25);
        return view('stock-receipt.list', compact('stockReceipts'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $stockReceipts = StockReceiptListItem::where('item_name', 'LIKE', '%' . $search . '%')->orWhere('item_code', 'LIKE', '%' . $search . '%')->latest()->paginate(25);
        return view('stock-receipt.list', compact('stockReceipts'));
    }

    public function pushStockList(){
        $stockReceipts = StockReceiptListItem::where('Status', 0)->orWhere('Status', Null)->latest()->paginate(10);
        return view('stock-receipt.push-list', compact('stockReceipts'));
    }

    public function pushStockEditForm(String $id){
        $stock = StockReceiptListItem::findOrFail($id);
        return view('stock-receipt.push-form', compact('stock'));
    }

    public function pushStockUpdate(Request $request)
    {
        $stockReceipt = StockReceipt::select('id', 'branch_code', 'doc_prefix', 'issued_to', 'godown_name', 'received_from')->find($request->fk_id);
        $listItemId = $request->id;

        $listItemArray[] = [
            'ItemCode' => $request->item_code,
            'LotNo' => $request->lot_no ?? 'CB-1',
            'Quantity' => $request->quantity,
            'Rate' => $request->rate,
            'Mrp' => $request->price,
            'Manufacturing_Date' => null,
            'Expiry_Date' => null
        ];
        
        $jsonRequest = [
            "Branch_Code" => $stockReceipt->branch_code,
            "Doc_Prefix" => $stockReceipt->doc_prefix,
            "IssueTo" => $stockReceipt->issued_to,
            "GodownName" => $stockReceipt->godown_name,
            "ReceivedFrom" => $stockReceipt->received_from,
            "ListItems" => $listItemArray
        ];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $this->credentials,
        ])->post($this->saveReceiptStockEndPoint, $jsonRequest);
        
        if($response['Status'] !== false) {
            StockReceiptListItem::find($listItemId)->update([
                'item_code' => $request->item_code,
                'lot_no' => $request->lot_no,
                'quantity' => $request->quantity,
                'rate' => $request->rate,
                'price' => $request->price,
                'mfg_date' => $request->mfg_date,
                'expiry_date' => $request->expiry_date,
                'Status' => true,
                'Message' => $response['Message'],
                'LastSavedDocNo' => $response['LastSavedDocNo'],
                'LastSavedCode' => $response['LastSavedCode'],
            ]);

            return redirect()->route('view.pushList')->with('success', 'Stock successfully pushed again.');
        }else{
            StockReceiptListItem::find($listItemId)->update(['Message' => $response['Message']]);
            return redirect()->route('edit.pushForm', ['id' => $listItemId])->with('danger', $response['Message']);
        }
    }
}
