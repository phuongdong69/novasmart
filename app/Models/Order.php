<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'voucher_id',
        'payment_id',
        'status_id',
        'name',
        'phoneNumber',
        'email',
        'address',
        'total_price',
        'order_code',
        'cancel_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function orderStatus()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function statusLogs()
    {
        return $this->morphMany(StatusLog::class, 'loggable');
    }
    public function cancellation()
    {
        return $this->hasOne(OrderCancellation::class);
    }
    public function updateStatus($status_id, $user_id = null, $note = null)
    {
        $this->status_id = $status_id;
        $this->save();
        $this->statusLogs()->create([
            'status_id' => $status_id,
            'user_id' => $user_id,
            'note' => $note,
        ]);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
