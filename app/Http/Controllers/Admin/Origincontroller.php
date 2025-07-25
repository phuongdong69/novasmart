<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\OriginRequest;
use App\Http\Controllers\Controller;
use App\Models\{Origin, Status};
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
        $data = $request->validated();

        // Gán mặc định status là "active"
        $data['status_id'] = Status::where('type', 'origin')->where('code', 'active')->value('id');

        Origin::create($data);

        return redirect()->route('admin.origins.index')->with('success', 'Thêm xuất xứ thành công.');
    } catch (\Exception $e) {
        return redirect()->route('admin.origins.index')->with('error', 'Không thêm xuất xứ thành công.');
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
    // Đổi trạng thái hoạt động của xuất xứ
    public function toggleStatus($id)
{
    $origin = Origin::findOrFail($id);
    $current = $origin->status->code ?? 'inactive';

    $newCode = $current === 'active' ? 'inactive' : 'active';

    $newStatusId = Status::where('type', 'Origin')->where('code', $newCode)->value('id');

    $origin->status_id = $newStatusId;
    $origin->save();

    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
}
}
