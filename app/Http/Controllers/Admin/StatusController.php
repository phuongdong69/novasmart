<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Danh sách trạng thái (với tìm kiếm và lọc theo loại)
     */
    public function index(Request $request)
    {
        $query = Status::query();

        // Tìm kiếm theo tên hoặc mã
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('code', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo loại trạng thái
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Lấy danh sách trạng thái (có phân trang)
        $statuses = $query->latest()->paginate(10)->withQueryString();

        // Lấy danh sách loại trạng thái (unique)
        $types = Status::distinct()->pluck('type')->filter()->values();

        return view('admin.statuses.index', compact('statuses', 'types'));
    }

    /**
     * Trang tạo trạng thái
     */
    public function create()
    {
        return view('admin.statuses.create');
    }

    /**
     * Lưu trạng thái mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:statuses,code',
            'type' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'priority' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // Mặc định là kích hoạt
        $data['is_active'] = true;

        Status::create($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Tạo trạng thái thành công');
    }

    /**
     * Trang chỉnh sửa trạng thái
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    /**
     * Cập nhật trạng thái
     */
    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:statuses,code,' . $status->id,
            'type' => 'required|string|max:100',
            'color' => 'required|string|max:20',
            'priority' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $status->update($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Cập nhật trạng thái thành công');
    }

    /**
     * Xoá trạng thái
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('admin.statuses.index')->with('success', 'Xoá trạng thái thành công');
    }
}
