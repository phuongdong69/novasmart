<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'quantity',
        'expired_at',
        'status_id',
    ];

    protected $dates = ['expired_at'];

    // Quan hệ với bảng statuses
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
