<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_name',
        'category_slug',
        'tags',
        'user_id',
        'status',
        'published_at',
        'views',
        'is_featured',
        'is_active'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'views' => 'integer',
        'tags' => 'array',
    ];

    // Relationship với User (tác giả)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope để lấy bài viết đã publish (cho trang user)
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('is_active', true);
    }

    // Scope để lấy bài viết nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope để lấy bài viết theo category
    public function scopeByCategory($query, $categorySlug)
    {
        return $query->where('category_slug', $categorySlug);
    }

    // Tăng lượt xem
    public function incrementViews()
    {
        $this->increment('views');
    }
} 