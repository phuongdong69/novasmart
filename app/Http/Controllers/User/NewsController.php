<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::published()->with('author');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(12);
        
        // Get categories for filter
        $categories = News::select('category_name', 'category_slug')
                         ->distinct()
                         ->whereNotNull('category_name')
                         ->published()
                               ->get();

        return view('user.news.index', compact('news', 'categories'));
    }

    public function show($slug)
    {
        $news = News::published()->where('slug', $slug)->with('author')->firstOrFail();
        
        // Tăng lượt xem
        $news->incrementViews();
        
        return view('user.news.show', compact('news'));
    }
}
