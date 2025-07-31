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
        'status_code',
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

    /**
     * Lấy status theo status_code (type: product)
     */
    public function getStatusByCode()
    {
        return \App\Models\Status::findByCodeAndType($this->status_code, 'product');
    }

    /**
     * Lấy badge/trạng thái hiển thị từ status_code (bảng statuses)
     */
    public function getStatusDisplay()
    {
        $status = $this->getStatusByCode();
        if ($status) {
            return $status->getDisplayAttribute();
        }
        return '<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">Không xác định</span>';
    }
}
