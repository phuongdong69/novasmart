<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'status_id',
        'discount_type',
        'discount_value',
        'expiry_date',
        'quantity',
    ];
    
    public function status()
{
    return $this->belongsTo(\App\Models\Status::class, 'status_id');
}
}


