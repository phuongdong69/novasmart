<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductThumbnail extends Model
{
    use HasFactory;

    protected $table = 'product_thumbnails';

    protected $fillable = [
        'product_id',
        'url',
        'product_variant_id',
        'is_primary',
        'sort_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
} 