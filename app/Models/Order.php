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
        'name',
        'phoneNumber',
        'email',
        'address',
        'total_price',
        'order_code',
        'status_id', // Thay 'status' bằng 'status_id' để khớp với mối quan hệ
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

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function statusLogs()
    {
        return $this->morphMany(StatusLog::class, 'loggable');
    }

    public function updateStatus($statusId, $userId = null, $note = null)
    {
        // Kiểm tra xem statusId có hợp lệ không
        if (!Status::find($statusId)) {
            throw new \Exception("Status ID {$statusId} không tồn tại.");
        }

        $this->status_id = $statusId;
        $this->save();

        // Tạo log trạng thái
        $this->statusLogs()->create([
            'status_id' => $statusId,
            'user_id' => $userId,
            'note' => $note,
        ]);

        return $this;
    }
}