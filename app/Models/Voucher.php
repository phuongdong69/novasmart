<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'expiry_date',
        'quantity',
    ];
    public function getIsExpiredAttribute()
    {
        return now()->gt($this->expiry_date);
    }

}


