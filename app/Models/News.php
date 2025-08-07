<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'excerpt',
        'status',
        'published_at',
        'author_id',
        'product_link'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationship với User (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope để lấy news đã publish
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
        // Bỏ điều kiện published_at để hiển thị tất cả bài published
        // ->where('published_at', '<=', now());
    }

    // Scope để lấy news theo thứ tự mới nhất
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Auto generate slug khi tạo title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // Get excerpt từ content nếu không có excerpt
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        return Str::limit(strip_tags($this->content), 150);
    }

    // Get image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/images/default-news.jpg');
    }
}
