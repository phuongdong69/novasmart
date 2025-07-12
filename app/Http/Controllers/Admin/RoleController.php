<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Hiển thị danh sách roles
    public function index()
    {
        $roles = Role::with('users')
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('admin.roles.create');
    }

    // Lưu dữ liệu mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'description' => 'nullable',
        ]);

        Role::create($request->only('name', 'description'));

        return redirect()->route('admin.roles.index')->with('success', 'Thêm chức vụ thành công.');
    }

    // Hiển thị form sửa
    public function edit($id)
    {
        // Không cho phép sửa role đang gán cho chính user hiện tại
        if (auth()->user()->role_id == $id) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Bạn không thể sửa chức vụ của chính mình.');
        }

        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        // Không cho phép cập nhật role đang gán cho chính user hiện tại
        if (auth()->user()->role_id == $id) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Bạn không thể cập nhật chức vụ của chính mình.');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'description' => 'nullable',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->only('name', 'description'));

        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật chức vụ thành công.');
    }
}
