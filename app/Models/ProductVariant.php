<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['sku', 'price', 'quantity', 'status', 'product_id'];

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
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }
}
