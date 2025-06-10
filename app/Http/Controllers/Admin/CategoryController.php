<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

   public function create()
{
    return view('admin.category.create');
}

public function store(CategoryRequest $request)
{
    
    
    
    try {
    Category::create($request->validated());
    return redirect()->route('categories.index')->with('success', 'Thêm danh mục thành công.');
} catch (\Exception $e) {
    return redirect()->route('categories.index')->with('error', 'Không thêm danh mục thành công.');
}
    
}
public function toggleStatus($id)
{
    $category = Category::findOrFail($id);
    $category->status = !$category->status; // Đảo ngược trạng thái
    $category->save();

    return redirect()->back()->with('success', 'Đã cập nhật trạng thái danh mục.');
}
   public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category')); 
    }

    public function update(CategoryRequest $request, $id)
    {
      try {
     $category = Category::findOrFail($id);
        $category->update($request->validated());
    return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công.');
} catch (\Exception $e) {
    return redirect()->route('categories.index')->with('error', 'Không cập nhật danh mục thành công.');
}
    }

    public function destroy(Category $category)
    {
        try {
    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Đã xoá thành công.');
} catch (\Exception $e) {
    return redirect()->route('categories.index')->with('error', 'Không thể xoá danh mục.');
}
    }
}
