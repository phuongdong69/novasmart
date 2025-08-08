<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_variant_id',
        'order_id',
        'order_detail_id',
        'content',
    ];

    // Người bình luận
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rating()
    {
        return $this->hasOne(Rating::class, 'order_detail_id', 'order_detail_id')
            ->where('user_id', $this->user_id);
    }
    // Sản phẩm biến thể
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    
    // Đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Chi tiết đơn hàng (dòng sản phẩm)
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id');
    }

}
