<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReceiptListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_masters_id',
        'stock_receipts_id',
        'item_code',
        'vendor_name',
        'item_name',
        'available_stock',
        'batch_number',
        'branch_code',
        'tax',
        'tax_amount',
        'gross_amount',
        'final_amount',
        'lot_no',
        'quantity',
        'rate',
        'price',
        'mfg_date',
        'mfg_name',
        'expiry_date',
        'Status',
        'Message',
        'LastSavedDocNo',
        'LastSavedCode',
    ];

    public function stockReceipt(){
        return $this->belongsTo(StockReceipt::class, 'stock_receipts_id');
    }

    public function stockOut(){
        return $this->hasOne(StockOut::class, 'stock_receipt_list_id');
    }
}
