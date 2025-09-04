<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    use HasFactory;

    protected $table = 'product_returns';

    protected $fillable = [
        'order_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'reason',
        'status',
        'refund_amount',
        'return_type',
        'admin_notes',
        'processed_by',
        'processed_at'
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Accessors
    public function getCustomerNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }

    public function getCustomerEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->guest_email;
    }

    public function getIsGuestReturnAttribute()
    {
        return is_null($this->user_id);
    }
}
