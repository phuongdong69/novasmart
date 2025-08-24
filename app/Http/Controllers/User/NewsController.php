<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Hiển thị danh sách tin tức
     */
    public function index()
    {
        $news = News::with('author')
            ->published()
            ->latest()
            ->paginate(9);

        return view('user.pages.news', compact('news'));
    }

    /**
     * Hiển thị chi tiết tin tức
     */
    public function show($slug)
    {
        $news = News::with(['author'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Lấy tin tức liên quan
        $relatedNews = News::with('author')
            ->published()
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return view('user.pages.news-detail', compact('news', 'relatedNews'));
    }
}
