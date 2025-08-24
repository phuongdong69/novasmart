<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_variant_id',
        'order_id',
        'order_detail_id',
        'rating',
        'status_id',
    ];

    // Người đánh giá
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sản phẩm biến thể
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Chi tiết đơn hàng (1-1)
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }
    public function comment()
    {
        return $this->hasOne(Comment::class, 'order_detail_id', 'order_detail_id')
                    ->where('user_id', $this->user_id);
    }

}
