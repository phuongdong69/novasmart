<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderBy('type')->orderBy('priority')->get();
        return view('admin.statuses.index', compact('statuses'));
    }

    public function create()
    {
        return view('admin.statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:statuses,code',
            'type' => 'required|string',
            'color' => 'required|string',
            'priority' => 'required|integer',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);
        Status::create($data);
        return redirect()->route('admin.statuses.index')->with('success', 'Tạo trạng thái thành công');
    }

    public function edit(Status $status)
    {
        return view('admin.statuses.edit', compact('status'));
    }

    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:statuses,code,' . $status->id,
            'type' => 'required|string',
            'color' => 'required|string',
            'priority' => 'required|integer',
            'is_active' => 'boolean',
            'description' => 'nullable|string',
        ]);
        $status->update($data);
        return redirect()->route('admin.statuses.index')->with('success', 'Cập nhật trạng thái thành công');
    }

    public function destroy(Status $status)
    {
        $status->delete();
        return redirect()->route('admin.statuses.index')->with('success', 'Xóa trạng thái thành công');
    }
} 