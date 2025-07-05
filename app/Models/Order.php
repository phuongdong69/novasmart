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
        'address',
        'email',
        'total_price',
        'order_code',
        'status',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function payment()
    // {
    //     return $this->belongsTo(Payment::class); // nếu bạn tạo bảng payments
    // }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function statusLogs()
    {
        return $this->morphMany(StatusLog::class, 'loggable');
    }

    /**
     * Cập nhật trạng thái cho Order và ghi log
     */
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
}
