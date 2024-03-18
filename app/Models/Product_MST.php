<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_MST extends Model
{
    use HasFactory;
    
    protected $table = 'Product_MST';

    protected $fillable = [
        'iem_id',
        'user_id',
        'group_id',
        'sr',
        'item_code',
        'item_code_pre',
        'item_name',
        'packaging',
        'item_desc',
        'uom',
        'size',
        'shade_name',
        'shade_code',
        'supplier_name',
        'supplier_short',
        'department',
        'category',
        'sub_category',
        'material',
        'brand',
        'gst_category',
        'active_inactive',
        'basic_rate',
        'per_rate',
        'sale_rate',
        'mrp',
        'hsn_code',
        'status',
        'unit_type',
        'rate_region',
        'uploaded_on',
        'checked_on',
        'approved_on',
        'updated_on',
        'updatedBy',
        'batch_number',
        'manu_date',
        'manu_name',
        'i_status',
    ];

    public $timestamps = false;
}
