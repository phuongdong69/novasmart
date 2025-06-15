<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\OriginRequest;
use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\Request;

class Origincontroller extends Controller
{
    // Hiển thị danh sách các xuât xứ, phân trang 
    public function index()
{
    $keyword = request('keyword');

    $origins = Origin::when($keyword, function ($query, $keyword) {
        return $query->where('country', 'like', "%$keyword%")
                     ->orWhere('id', $keyword); 
    })
    ->orderBy('id')
    ->paginate(10);

    return view('admin.origins.index', compact('origins'));
}

    // Hiển thị form thêm xuât xứ
    public function create()
    {
        return view('admin.origins.create');
    }

    // lưu xuât xứ vào database
    public function store(OriginRequest $request)
    {
        try {
            // Lưu dữ liệu đã được xác thực
            Origin::create($request->validated());

            // Quay lại danh sách với thông báo thành công
            return redirect()->route('admin.origins.index')->with('success', 'Thêm xuât xứ thành công.');
        } catch (\Exception $e) {
            // Trường hợp lỗi
            return redirect()->route('admin.origins.index')->with('error', 'Không thêm xuât xứ thành công.');
        }
    }

    // Hiển thị form xuât xứ 
    public function edit($id)
    {
        $origin = Origin::findOrFail($id);
        return view('admin.origins.edit', compact('origin'));
    }

    //cập nhật xuât xứ
    public function update(OriginRequest $request, $id)
    {
        try {
            $origin = Origin::findOrFail($id);

            $origin->update($request->validated());

            return redirect()->route('admin.origins.index')->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.origins.index')->with('error', 'Cập nhật không thành công.');
        }
    }

    //  Xoá xuất xứ    
    public function destroy($id)
    {
        try {
            $origin = Origin::findOrFail($id);
            $origin->delete();

            return redirect()->route('admin.origins.index')->with('success', 'Đã xoá thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.origins.index')->with('error', 'Đã xoá không thành công.');
        }
    }
}
