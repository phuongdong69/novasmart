<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status_id'
    ];
    
    protected $with = ['status'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function variantAttributeValues()
    {
        return $this->hasManyThrough(VariantAttributeValue::class, AttributeValue::class);
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
