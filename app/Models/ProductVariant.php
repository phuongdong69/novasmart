<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'status_id',
        'sku',
        'price',
        'quantity',
    ];
    
    protected $with = ['status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function variantAttributeValues()
    {
        return $this->hasMany(VariantAttributeValue::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Thumbnail linked via product_thumbnails.product_variant_id
     */
    public function thumbnail()
    {
        return $this->hasOne(ProductThumbnail::class, 'product_variant_id');
    }

    public function thumbnailUrl()
    {
        $thumb = $this->thumbnail;
        return $thumb ? asset('storage/' . $thumb->url) : asset('assets/images/placeholder.png');
    }
        public function imageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('assets/images/placeholder.png');
    }
}
