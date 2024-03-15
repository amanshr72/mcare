<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_receipt_list_id',
        'item_name',
        'item_code',
        'batch_number',
        'quantity',
        'quantity_2',
        'manufacturing_date',
    ];

    public function stockReceiptListItem(){
        return $this->belongsTo(StockReceiptListItem::class, 'stock_receipt_list_id');
    }
}
