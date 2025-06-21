<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'origin_id',
        'category_id',
        'name',
        'description',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    // Quan hệ 1:N với ProductVariant (mỗi sản phẩm có nhiều biến thể)
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
