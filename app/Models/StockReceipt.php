<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_masters_id',
        'list_items',
        'groupid',
        'po_prefix',
        'po_number',
        'branch_code',
        'doc_prefix',
        'issued_to',
        'godown_name',
        'received_from',
        'product_name',
        'category',
        'vendor_company',
        'Item_Code',
        'user_code',
        'Qty',
        'user_qty',
        'Price',
        'User_Price',
        'Discount',
        'Tax',
        'SubTotal',
        'Ftotal',
        'UOM',
        'U_Desc',
        'notes',
        'created_on',
        'created_by',
        'po_type',
        'status',
        'cancelledBy',
        'cancelledOn',
        'Location',
        'Address_as',
        'Delivery_Address',
        'comment',
        'refernece_document_no',
        'reference_date',
        'user_prefix',
        'batch_number',
        'manu_date',
        'manu_name',
        'response_status',
        'Message',
        'LastSavedDocNo',
        'LastSavedCode'
    ];

    public function stockReceiptlistItems(){
        return $this->hasMany(StockReceiptListItem::class, 'stock_receipts_id');
    }

    public function setListItemAttribute($value){
        $this->attributes['list_item'] = json_encode($value);
    }

}
