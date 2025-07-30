<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_value',
        'usage_limit',
        'used',
        'start_date',
        'end_date',
        'user_id',
        'is_public',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_public' => 'boolean',
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_order_value' => 'decimal:2',
    ];
    
    public function status()
{
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status_id', 1); // Assuming status_id 1 is active
    }

    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now)
                    ->where('used', '<', 'usage_limit');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Methods
    public function isValid()
    {
        $now = Carbon::now();
        return $this->start_date <= $now && 
               $this->end_date >= $now && 
               $this->used < $this->usage_limit;
    }

    public function getStatusText()
    {
        $now = Carbon::now();
        
        // Chưa đến ngày bắt đầu
        if ($now < $this->start_date) {
            return 'Chưa gia hạn';
        }
        
        // Đã hết hạn
        if ($now > $this->end_date) {
            return 'Hết hạn';
        }
        
        // Đã hết lượt sử dụng
        if ($this->used >= $this->usage_limit) {
            return 'Hết lượt';
        }
        
        // Còn hiệu lực
        return 'Hiệu lực';
    }

    public function getStatusClass()
    {
        $now = Carbon::now();
        
        // Chưa đến ngày bắt đầu
        if ($now < $this->start_date) {
            return 'bg-yellow-100 text-yellow-800';
        }
        
        // Đã hết hạn hoặc hết lượt
        if ($now > $this->end_date || $this->used >= $this->usage_limit) {
            return 'bg-red-100 text-red-800';
        }
        
        // Còn hiệu lực
        return 'bg-green-100 text-green-800';
    }

    public function canBeUsedByUser($userId)
    {
        // Kiểm tra xem user đã dùng voucher này chưa
        $existingUsage = $this->usages()->where('user_id', $userId)->first();
        return !$existingUsage;
    }

    public function calculateDiscount($orderTotal)
    {
        if ($orderTotal < $this->min_order_value) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = ($orderTotal * $this->value) / 100;
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return $discount;
        } else {
            return min($this->value, $orderTotal);
        }
    }

    public function incrementUsage()
    {
        $this->increment('used');
    }

    public function decrementUsage()
    {
        $this->decrement('used');
}
}


