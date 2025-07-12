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
    
    protected $with = ['status', 'variantAttributeValues'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantAttributeValues()
    {
        return $this->hasMany(VariantAttributeValue::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'variant_attribute_values')
                   ->withPivot('attribute_value_id');
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
