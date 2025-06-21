<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'thumbnails';

    // The primary key for the model.
    protected $primaryKey = 'id';

    // The attributes that are mass assignable.
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'url',
        'is_primary',
        'sort_order'
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the product that owns the thumbnail.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the thumbnail.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}