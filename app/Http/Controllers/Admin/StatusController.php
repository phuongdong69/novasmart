<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $rules = [
            'name'        => ['required','string','max:255'],
            'code'        => [
                'required','string','max:100',
                Rule::unique('statuses', 'code')
                    ->where(fn($q) => $q->where('type', $request->type)),
            ],
            'type'        => ['required','string','max:100'],
            'color'       => ['required','string','max:50','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'priority'    => ['required','integer','min:0'],
            'description' => ['nullable','string','max:1000'],
        ];

        $messages = [
            'required' => ':attribute là bắt buộc.',
            'string'   => ':attribute phải là chuỗi ký tự.',
            'max'      => ':attribute không được vượt quá :max ký tự.',
            'integer'  => ':attribute phải là số nguyên.',
            'min'      => ':attribute phải lớn hơn hoặc bằng :min.',
            'unique'   => ':attribute đã tồn tại với loại trạng thái này.',
            'regex'    => ':attribute không đúng định dạng mã màu hợp lệ (ví dụ: #00ff00).',
        ];

        $attributes = [
            'name'        => 'Tên trạng thái',
            'code'        => 'Mã trạng thái',
            'type'        => 'Loại trạng thái',
            'color'       => 'Màu hiển thị',
            'priority'    => 'Thứ tự ưu tiên',
            'description' => 'Mô tả',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $data['is_active'] = $request->boolean('is_active', true);

        Status::create($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Tạo trạng thái thành công');
    }

    /**
     * Cập nhật trạng thái
     */
    public function update(Request $request, Status $status)
    {
        $rules = [
            'name'        => ['required','string','max:255'],
            'code'        => [
                'required','string','max:100',
                Rule::unique('statuses', 'code')
                    ->ignore($status->id)
                    ->where(fn($q) => $q->where('type', $request->type)),
            ],
            'type'        => ['required','string','max:100'],
            'color'       => ['required','string','max:50','regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'priority'    => ['required','integer','min:0'],
            'description' => ['nullable','string','max:1000'],
        ];

        $messages = [
            'required' => ':attribute là bắt buộc.',
            'string'   => ':attribute phải là chuỗi ký tự.',
            'max'      => ':attribute không được vượt quá :max ký tự.',
            'integer'  => ':attribute phải là số nguyên.',
            'min'      => ':attribute phải lớn hơn hoặc bằng :min.',
            'unique'   => ':attribute đã tồn tại với loại trạng thái này.',
            'regex'    => ':attribute không đúng định dạng mã màu hợp lệ (ví dụ: #00ff00).',
        ];

        $attributes = [
            'name'        => 'Tên trạng thái',
            'code'        => 'Mã trạng thái',
            'type'        => 'Loại trạng thái',
            'color'       => 'Màu hiển thị',
            'priority'    => 'Thứ tự ưu tiên',
            'description' => 'Mô tả',
        ];

        $data = $request->validate($rules, $messages, $attributes);

        $data['is_active'] = $request->boolean('is_active', $status->is_active);

        $status->update($data);

        return redirect()->route('admin.statuses.index')->with('success', 'Cập nhật trạng thái thành công');
    }

    /**
     * Trang chỉnh sửa trạng thái
     */
    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
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
