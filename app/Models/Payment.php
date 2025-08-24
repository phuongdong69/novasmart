<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
    'status_id', 'payment_method', 'amount', 'transaction_code', 'note'
];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
