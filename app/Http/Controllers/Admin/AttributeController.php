<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Hiển thị danh sách tất cả thuộc tính
     */
    public function index(Request $request)
    {
        $query = Attribute::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('id', $keyword);
            });
        }

        $attributes = $query->latest()->paginate(10)->withQueryString();
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Hiển thị form tạo mới thuộc tính
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Lưu mới thuộc tính vào database
     */
    public function store(StoreAttributeRequest $request)
    {
        try {
            $attribute = Attribute::create($request->validated());
            return redirect()->route('admin.attributes.index')
                ->with('success', 'Thuộc tính đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Không thể tạo thuộc tính. Vui lòng thử lại.');
        }
    }

    /**
     * Hiển thị chi tiết thuộc tính
     */
    public function show(Attribute $attribute)
    {
        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Hiển thị form chỉnh sửa thuộc tính
     */
    public function edit(Attribute $attribute)
    {
        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Cập nhật thuộc tính
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        try {
            $attribute->update($request->validated());
            return redirect()->route('admin.attributes.index')
                ->with('success', 'Thuộc tính đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Không thể cập nhật thuộc tính. Vui lòng thử lại.');
        }
    }

    /**
     * Xóa thuộc tính
     */
    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->delete();
            return redirect()->route('admin.attributes.index')
                ->with('success', 'Thuộc tính đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Không thể xóa thuộc tính. Vui lòng thử lại.');
        }
    }


}
