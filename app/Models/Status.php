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

    // Scope to get statuses by type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope to get statuses ordered by priority
    public function scopeOrdered($query)
    {
        return $query->orderBy('priority');
    }

    // Get status by code and type
    public static function findByCodeAndType($code, $type)
    {
        return static::where('code', $code)->where('type', $type)->first();
    }

    // Get all statuses for a specific type
    public static function getByType($type)
    {
        return static::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->get();
    }

    // Get status options for select dropdown
    public static function getOptionsByType($type)
    {
        return static::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->pluck('name', 'code')
                    ->toArray();
    }

    // Get status with color for display
    public function getDisplayAttribute()
    {
        return '<span class="px-2 py-1 text-xs rounded" style="background:' . ($this->color ?: '#eee') . ';color:#222;" title="' . e($this->description) . '">' . e($this->name) . '</span>';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'status_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'status_id');
    }
}
