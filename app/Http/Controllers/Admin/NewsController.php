<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('author');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_slug', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get unique categories for filter
        $categories = News::select('category_name', 'category_slug')
                         ->distinct()
                         ->whereNotNull('category_name')
                         ->get();

        return view('admin.news.index', compact('news', 'categories'));
    }

    public function create()
    {
        // Get existing categories for suggestions
        $categories = News::select('category_name', 'category_slug')
                         ->distinct()
                         ->whereNotNull('category_name')
                         ->get();

        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:2048',
            'category_name' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['category_slug'] = $request->category_name ? Str::slug($request->category_name) : null;
        $data['user_id'] = auth()->id();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/news', $filename);
            $data['featured_image'] = '/storage/news/' . $filename;
        }

        // Handle tags - convert JSON string to array
        if ($request->filled('tags')) {
            try {
                $tagsArray = json_decode($request->tags, true);
                if (is_array($tagsArray)) {
                    $data['tags'] = array_filter($tagsArray);
                } else {
                    $data['tags'] = null;
                }
            } catch (\Exception $e) {
                $data['tags'] = null;
            }
        } else {
            $data['tags'] = null;
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        // Get existing categories for suggestions
        $categories = News::select('category_name', 'category_slug')
                         ->distinct()
                         ->whereNotNull('category_name')
                         ->get();

        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:2048',
            'category_name' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['category_slug'] = $request->category_name ? Str::slug($request->category_name) : null;
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image && file_exists(public_path($news->featured_image))) {
                unlink(public_path($news->featured_image));
            }
            
            $file = $request->file('featured_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/news', $filename);
            $data['featured_image'] = '/storage/news/' . $filename;
        }

        // Handle tags - convert JSON string to array
        if ($request->filled('tags')) {
            try {
                $tagsArray = json_decode($request->tags, true);
                if (is_array($tagsArray)) {
                    $data['tags'] = array_filter($tagsArray);
                } else {
                    $data['tags'] = null;
                }
            } catch (\Exception $e) {
                $data['tags'] = null;
            }
        } else {
            $data['tags'] = null;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được xóa thành công.');
    }
} 