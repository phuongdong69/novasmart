<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = News::with('author');
        
        // Tìm kiếm theo tên tin tức
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        
        // Lọc theo tác giả
        if (request('author')) {
            $query->where('author_id', request('author'));
        }
        
        // Lọc theo trạng thái
        if (request('status')) {
            $query->where('status', request('status'));
        }
        
        // Lọc theo ngày xuất bản
        if (request('date')) {
            $query->whereDate('published_at', request('date'));
        }
        
        $news = $query->latest()->paginate(10);
        $authors = \App\Models\User::whereHas('news')->get();
        
        return view('admin.news.index', compact('news', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        try {
            $data = $request->validated();
            $data['author_id'] = auth()->id();

            // Xử lý upload hình ảnh
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news', 'public');
                $data['image'] = $imagePath;
            }

            // Tự động set ngày xuất bản khi status là published
            if ($data['status'] === 'published') {
                $data['published_at'] = now();
            }

            News::create($data);

            return redirect()->route('admin.news.index')
                ->with('success', 'Thêm tin tức thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Thêm tin tức không thành công! Vui lòng thử lại.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::with('author')->findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, string $id)
    {
        try {
            $news = News::findOrFail($id);
            $data = $request->validated();

            // Xử lý upload hình ảnh mới
            if ($request->hasFile('image')) {
                // Xóa hình ảnh cũ
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }
                
                $imagePath = $request->file('image')->store('news', 'public');
                $data['image'] = $imagePath;
            }

            // Tự động set ngày xuất bản khi status là published
            if ($data['status'] === 'published') {
                $data['published_at'] = now();
            }

            $news->update($data);

            return redirect()->route('admin.news.index')
                ->with('success', 'Chỉnh sửa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Chỉnh sửa không thành công! Vui lòng thử lại.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $news = News::findOrFail($id);
            
            // Xóa hình ảnh
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            $news->delete();

            return redirect()->route('admin.news.index')
                ->with('success', 'Đã xóa!');
        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')
                ->withErrors(['error' => 'Xóa tin tức không thành công! Vui lòng thử lại.']);
        }
    }

    /**
     * Toggle status của news
     */
    public function toggleStatus(string $id)
    {
        $news = News::findOrFail($id);
        
        if ($news->status === 'draft') {
            $news->update([
                'status' => 'published',
                'published_at' => now()
            ]);
            $message = 'Tin tức đã được xuất bản!';
        } else {
            $news->update([
                'status' => 'draft',
                'published_at' => null
            ]);
            $message = 'Tin tức đã được chuyển về bản nháp!';
        }

        return redirect()->route('admin.news.index')
            ->with('success', $message);
    }
}
