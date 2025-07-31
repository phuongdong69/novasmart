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
        'status_code',
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

    /**
     * Lấy status theo status_code (type: order)
     */
    public function getStatusByCode()
    {
        return \App\Models\Status::findByCodeAndType($this->status_code, 'order');
    }

    /**
     * Lấy badge/trạng thái hiển thị từ status_code (bảng statuses)
     */
    public function getStatusDisplay()
    {
        $status = $this->getStatusByCode();
        if ($status) {
            return $status->getDisplayAttribute();
        }
        return '<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">Không xác định</span>';
    }
}
