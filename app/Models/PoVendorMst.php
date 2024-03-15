<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoVendorMst extends Model
{
    use HasFactory;

    protected $table = 'po_vendor_mst';

    protected $fillable = [
        'group_id',
        'vendor_id',
        'register_user_id',
        'contactPerson',
        'companyName',
        'department',
        'vendorType',
        'buyerEmail',
        'asstBuyerEmail',
        'vendorCode',
        'accountCode',
        'resPhoneNumber',
        'persNumber',
        'companyAddress',
        'companyAddress2',
        'companyAddress3',
        'companyNumber',
        'registered',
        'regDate',
        'gstNumber',
        'panNumber',
        'pinCodeId',
        'cityId',
        'stateId',
        'bankName',
        'bankAddress',
        'company_email',
        'status',
        'remarks',
        'advance',
        'payment_type',
        'in_days',
        'on_the_basic_of',
    ];
}
