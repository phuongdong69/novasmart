<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancellation extends Model
{
    protected $fillable = ['order_id', 'reason'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
