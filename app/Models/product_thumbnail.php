<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_thumbnail extends Model
{
    use HasFactory;

    protected $table = 'product_thumbnails';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'url',
        'is_primary',
        'sort_order',
    ];
} 