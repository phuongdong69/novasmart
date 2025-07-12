<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                  ->orWhere('email', 'like', "%$keyword%")
                  ->orWhere('phone', 'like', "%$keyword%")
                  ->orWhere('id', $keyword);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }
        $users = $query->with('status')->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $roles = \App\Models\Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|boolean',
            'role_id' => 'required|exists:roles,id',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Thêm user thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = \App\Models\Role::all();
        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|boolean',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật user thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xóa user thành công!');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'Đã cập nhật trạng thái user.');
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        $user->role_id = $data['role_id'];
        $user->save();
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Cập nhật vai trò thành công!');
    }

    /**
     * Hiển thị lịch sử thay đổi trạng thái của user
     */
    public function statusLogs($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $logs = $user->statusLogs()->with('status', 'loggable')->orderByDesc('created_at')->get();
        return view('admin.users.status_logs', compact('user', 'logs'));
    }

    /**
     * Cập nhật trạng thái cho user và ghi log
     */
    public function updateStatus(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'note' => 'nullable|string',
        ]);
        $user->updateStatus($request->status_id, auth()->id(), $request->note);
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}
