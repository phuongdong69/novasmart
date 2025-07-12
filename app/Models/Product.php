<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Các trường có thể gán hàng loạt cho Product
     */
    protected $fillable = [
        'brand_id',
        'origin_id',
        'category_id',
        'status_id',
        'name',
        'description',
    ];
    
    protected $with = ['status'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function thumbnails()
    {
        return $this->hasMany(ProductThumbnail::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function statusLogs()
    {
        return $this->morphMany(StatusLog::class, 'loggable');
    }
    public function updateStatus($status_id, $user_id = null, $note = null)
    {
        $this->status_id = $status_id;
        $this->save();
        $this->statusLogs()->create([
            'status_id' => $status_id,
            'user_id' => $user_id,
            'note' => $note,
        ]);
    }
}
