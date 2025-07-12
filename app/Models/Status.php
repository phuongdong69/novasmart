<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'color',
        'priority',
        'is_active',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority' => 'integer'
    ];

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Relationship with product variants
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Relationship with attributes
    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    // Scope to get active status
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get status by code
    public static function getByCode($code)
    {
        return self::where('code', $code)->first();
    }
}
