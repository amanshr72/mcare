<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserItemMaster extends Model
{
    use HasFactory;
    protected $table = 'user_item_master';

    protected $fillable = [
        'groupid',
        'user_id',
        'item_code',
        'user_code',
        'location',
        'vendor',
        'notes',
        'created_on',
        'created_by'
    ];

    public $timestamps = false;
}
