<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function attribute()
    {
        return $this->hasOneThrough(Attribute::class, AttributeValue::class, 'id', 'id', 'attribute_value_id', 'attribute_id');
    }
}
