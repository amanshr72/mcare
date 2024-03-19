<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchMaster extends Model
{
    use HasFactory;
    protected $table = 'm99branchmaster';

    protected $fillable = [
        'groupid',
        'userId',
        'UserType',
        'user_code',
        'branchCode',
        'branchName',
        'branch_short_name',
        'branch_group',
        'branch_tel_no.',
        'mobile_no.'
    ];

    public $timestamps = false;
}
