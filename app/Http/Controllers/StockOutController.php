<?php

namespace App\Http\Controllers;

use App\Models\ItemMaster;
use App\Models\StockOut;
use App\Models\StockReceiptListItem;
use Exception;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index()
    {
        $stockOuts = StockOut::with('stockReceiptListItem')->latest()->paginate(10);
        return view('stock-out.index', compact('stockOuts'));
    }
    public function create()
    {
        $items = ItemMaster::select('item_code', 'item_name', 'category')->distinct('item_code', 'item_name')->get();
        return view('stock-out.create', compact('items'));
    }

    public function store(Request $request)
    {
        try {
            $listItems = $request->input('listItems');
            $listItemsArray = json_decode($listItems, true);
            if (count($listItemsArray) > 0) {
                foreach ($listItemsArray as $item) {
                    $itemDetails = StockReceiptListItem::select('id', 'item_code')->where('item_name', $item['itemNameVal'])->where('batch_number', $item['batcheNoVal'])->first();

                    if ($itemDetails) {
                        StockOut::create([
                            'stock_receipt_list_id' => $itemDetails->id,
                            'item_code' => $itemDetails->item_code,
                            'item_name' => $item['itemNameVal'],
                            'batch_number' => $item['batcheNoVal'],
                            'quantity' => $item['quantityVal'],
                            'quantity_2' => $item['quantity2Val'],
                            'manufacturing_date' => isset($item['mfgDateVal']) && ($date = \DateTime::createFromFormat('d/m/Y', $item['mfgDateVal'])) ? $date->format('Y-m-d') : null,
                        ]);
                    } else {
                        return redirect()->back()->with('Item details not found for ' . $item['itemNameVal'] . ' and batch ' . $item['batcheNoVal']);
                    }
                }
                return redirect()->route('stock-out.index')->with('success', 'Data has been uploaded successfully');
            }
        } catch (Exception $e) {
            return redirect()->route('stock-out.index')->with('danger', 'Whoops! an error occurred: ' . $e->getMessage());
        }
    }

    public function getItemDetails($itemName)
    {
        $items = StockReceiptListItem::select('id', 'item_code', 'item_name', 'batch_number', 'mfg_date', 'quantity')->where('item_name', $itemName)->get();
        return response()->json(['success' => 'true', 'itemName' => $items]);
    }

    public function filter(Request $request){
        $stockOuts = StockOut::with('stockReceiptListItem');

        if(isset($request->batchNumber) && $request->batchNumber !== ''){
            $stockOuts = $stockOuts->where('batch_number', $request->batchNumber);
        }
        
        $stockOuts = $stockOuts->latest()->paginate(25);
        return view('stock-out.list', compact('stockOuts'));
    }

    public function search(Request $request){
        $search = $request->search;
        $stockOuts = StockOut::with('stockReceiptListItem')->where('item_name', 'LIKE', '%' . $search . '%')->orWhere('item_code', 'LIKE', '%' . $search . '%')->latest()->paginate(25);
        return view('stock-out.list', compact('stockOuts'));
    }
}
