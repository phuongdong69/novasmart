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
        $roles = Role::with('users') // Load luôn danh sách user thuộc role
            ->orderBy('id', 'desc')
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
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'description' => 'nullable',
        ]);

        $role = Role::findOrFail($id);
        $role->update($request->only('name', 'description'));

        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật chức vụ thành công.');
    }
}
