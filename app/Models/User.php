<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Role;
use App\Models\Cart;
use App\Models\Status;
use App\Models\StatusLog;

class User extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phoneNumber',
        'image_user',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Quan hệ: User thuộc về 1 Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Quan hệ: User có 1 giỏ hàng
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Quan hệ: User thuộc về 1 trạng thái (nếu bạn có bảng statuses)
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * Quan hệ: Các log trạng thái của user (dùng morphMany nếu bạn log nhiều loại model)
     */
    public function statusLogs(): MorphMany
    {
        return $this->morphMany(StatusLog::class, 'loggable');
    }

    /**
     * Cập nhật trạng thái cho User và ghi log
     */
    public function updateStatus($status_id, $user_id = null, $note = null)
    {
        $this->status_id = $status_id;
        $this->save();

        $this->statusLogs()->create([
            'status_id' => $status_id,
            'user_id'   => $user_id,
            'note'      => $note,
        ]);
    }
}
