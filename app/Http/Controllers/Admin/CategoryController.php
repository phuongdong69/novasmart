<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục, có thể lọc theo từ khóa
    public function index(Request $request)
    {
        $query = Category::query();

        // Nếu có từ khóa tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('id', $keyword);
            });
        }

        // Phân trang danh sách danh mục
        $categories = $query->orderBy('id')->paginate(10)->withQueryString();

        // Trả về view hiển thị danh sách
        return view('admin.category.index', compact('categories'));
    }

    // Hiển thị form thêm mới danh mục
    public function create()
    {
        return view('admin.category.create');
    }

    // Lưu danh mục mới vào cơ sở dữ liệu
    public function store(CategoryRequest $request)
    {
        try {
            // Tạo mới danh mục từ dữ liệu hợp lệ
            Category::create($request->validated());
            return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thêm danh mục thành công.');
        }
    }

    // Đổi trạng thái hoạt động của danh mục
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status; // Đảo ngược trạng thái
        $category->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái danh mục.');
    }

    // Hiển thị form sửa danh mục
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    // Cập nhật thông tin danh mục
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Không cập nhật danh mục thành công.');
        }
    }

    // Xóa danh mục
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Đã xoá thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xoá danh mục.');
        }
    }
}
