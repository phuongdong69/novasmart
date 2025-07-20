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
}
