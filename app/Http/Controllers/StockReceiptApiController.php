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

    public function __construct()
    {
        $this->saveReceiptStockEndPoint = 'http://demo.logicerp.com/api/SaveReceiptStock';
        $username = 'LAdmin'; $password = '1';
        $this->credentials = base64_encode("$username:$password");   
    }

    public function index()
    {
        $stockReceipts = StockReceiptListItem::latest()->paginate(10);
        return view('stock-receipt.index', compact('stockReceipts'));
    }

    public function create()
    {
        $items = Product_MST::select('item_code', 'item_name', 'category')->distinct('item_code', 'item_name')->get();
        $location = BranchMaster::select('branchName')->where('branchCode', Auth::user()->ul)->first();
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
                'branch_code' => 2,
                'doc_prefix' => 'SR',
                'issued_to' => '',
                'godown_name' => 'MAIN',
                'received_from' => 'RKSS',
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

            $selectedColumns = ['itemCodeVal', 'lotNo', 'quantityVal', 'priceVal', 'finalAmount', 'mfgDateVal', 'expiryDate'];
            $filterlListItemApiData = array_map(function ($item) use ($selectedColumns) {
                $selectedItem = array_intersect_key($item, array_flip($selectedColumns));
                $renamedItem = array_combine(['ItemCode', 'LotNo', 'Quantity', 'Rate', 'Mrp', 'Manufacturing_Date', 'Expiry_Date'], $selectedItem);
                return $renamedItem;
            }, $listItemsArray);
            
            // Post Data To API 
            
            // foreach ($filterlListItemApiData as $filteredItemData) {
            //     $filteredItemData['LotNo'] = "CB-1";
            //     $requestData = [
            //         "Branch_Code" => 2,
            //         "Doc_Prefix" => "SR",
            //         "IssueTo" => "",
            //         "GodownName" => "MAIN",
            //         "ReceivedFrom" => "RKSS",
            //         "ListItems" => [$filteredItemData]
            //     ];

            //     $jsonRequestData = $requestData;
            //     $itemCode = $jsonRequestData['ListItems'][0]['ItemCode'];

            //     $response = Http::withHeaders([
            //         'Content-Type' => 'application/json', 
            //         'Authorization' => 'Basic ' . $this->credentials,
            //     ])->post($this->saveReceiptStockEndPoint, $jsonRequestData);
                
            //     foreach($listItemIds as $id){
            //         $istItem = StockReceiptListItem::where('stock_receipts_id', $stockReceipt->id)->where('item_code', $itemCode)->find($id);

            //         if($istItem !== null){
            //             $status = $response['Status'] == true ? true : false;
            //             $message = $response['Message'];
            //             $istItem->update(['Status' => $status, 'Message' => $message]);
            //             $allStatus[] = $response['Status'];
            //         }
            //     }

            //     $responseStatus = !in_array(false, $allStatus, true) ? 1 : 0;
            //     StockReceipt::find($stockReceipt->id)->update(['response_status' => $responseStatus]);
            // }

            // if ($response['Status'] == true) {
            //     return redirect()->route('stock-receipt.index')->with('success', $response['Message']);
            // } else {
            //     return redirect()->route('stock-receipt.index')->with('danger', $response['Message']);
            // }

            return redirect()->route('stock-receipt.index')->with('success', 'Data has been uploaded successfully');
            

        } catch (Exception $e) {
            throw $e;
            // return redirect()->route('stock-receipt.index')->with('danger', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function pushAllStock(){
        $stockReceipts = StockReceipt::where('branch_code', 2)->where('response_status', 0)->orWhereNull('response_status')->get();
        $listItems = StockReceiptListItem::whereIn('stock_receipts_id', $stockReceipts->pluck('id')->toArray())->where('Status', 0)->orWhereNull('Status')->get();
        $listItemArray = [];

        foreach($listItems as $item){
            $listItemArray[] = [
                'ItemCode' => $item->item_code,
                'LotNo' => $item->lot_no ?? 'CB-1',
                'Quantity' => $item->quantity,
                'Rate' => $item->rate,
                'Mrp' => $item->price,
                'Manufacturing_Date' => null,
                'Expiry_Date' => null
            ];

            $jsonRequestData = [
                "Branch_Code" => 2,
                "Doc_Prefix" => "SR",
                "IssueTo" => "",
                "GodownName" => "MAIN",
                "ReceivedFrom" => "RKSS",
                'ListItems' => $listItemArray
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
                $item->update(['Status' => 0, 'Message' => $response['Message']]);
            }       
        }
        return redirect()->route('stock-receipt.index')->with('danger', $response['Message']);
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
        
        if ($response['Status'] !== false && $response['LastSavedDocNo'] !== 0) {
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
        } else {
            return redirect()->route('edit.pushForm', ['id' => $listItemId])->with('danger', $response['Message']);
        }
    }
}
