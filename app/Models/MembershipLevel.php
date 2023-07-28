<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'card_codes_quota',
        'validity_period',
        'price',
        'discount', // 新增的折扣字段
        'description',
    ];

}
