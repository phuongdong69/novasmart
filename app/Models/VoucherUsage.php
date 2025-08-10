<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    use HasFactory;
    protected $table = 'voucher_usages';

    public $timestamps = false;
    protected $fillable = ['voucher_id', 'user_id', 'used_at'];
    public function voucher()
    {
        return $this->belongsTo(\App\Models\Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
