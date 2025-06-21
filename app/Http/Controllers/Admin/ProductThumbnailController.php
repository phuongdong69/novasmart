<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\product_thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductThumbnailController extends Controller
{
    public function index()
    {
        $thumbnails = product_thumbnail::all();
        return view('admin.product_thumbnail.index', compact('thumbnails'));
    }

    public function create()
    {
        return view('admin.product_thumbnail.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'product_variant_id' => 'required|integer',
            'url' => 'required|image',
            'is_primary' => 'required|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        if ($request->hasFile('url')) {
            $data['url'] = $request->file('url')->store('uploads/products/thumbnails', 'public');
        }
        product_thumbnail::create($data);
        return redirect()->route('admin.product_thumbnail.index')->with('success', 'Thêm ảnh thành công!');
    }

    public function edit($id)
    {
        $thumbnail = product_thumbnail::findOrFail($id);
        return view('admin.product_thumbnail.edit', compact('thumbnail'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'product_variant_id' => 'required|integer',
            'url' => 'nullable|image',
            'is_primary' => 'required|boolean',
            'sort_order' => 'nullable|integer',
        ]);
        $thumbnail = product_thumbnail::findOrFail($id);
        if ($request->hasFile('url')) {
            // Xóa ảnh cũ nếu có
            if ($thumbnail->url && Storage::disk('public')->exists($thumbnail->url)) {
                Storage::disk('public')->delete($thumbnail->url);
            }
            $data['url'] = $request->file('url')->store('uploads/products/thumbnails', 'public');
        } else {
            unset($data['url']);
        }
        $thumbnail->update($data);
        return redirect()->route('admin.product_thumbnail.index')->with('success', 'Cập nhật ảnh thành công!');
    }
} 