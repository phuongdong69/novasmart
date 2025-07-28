<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::ordered()->get();
        return view('admin.slideshows.index', compact('slideshows'));
    }

    public function create()
    {
        return view('admin.slideshows.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('slideshows', 'public');
            $data['image'] = $imagePath;
        }

        Slideshow::create($data);

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow đã được tạo thành công!');
    }

    public function edit(Slideshow $slideshow)
    {
        return view('admin.slideshows.edit', compact('slideshow'));
    }

    public function update(Request $request, Slideshow $slideshow)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($slideshow->image) {
                Storage::disk('public')->delete($slideshow->image);
            }
            
            $imagePath = $request->file('image')->store('slideshows', 'public');
            $data['image'] = $imagePath;
        }

        $slideshow->update($data);

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow đã được cập nhật thành công!');
    }

    public function destroy(Slideshow $slideshow)
    {
        if ($slideshow->image) {
            Storage::disk('public')->delete($slideshow->image);
        }
        
        $slideshow->delete();

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow đã được xóa thành công!');
    }
} 