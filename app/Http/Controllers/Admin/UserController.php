<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use App\Models\StatusLog;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['role', 'status']);

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phoneNumber', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }

        $users = $query->latest()->paginate(10);

        $roles = Role::all();
        $statuses = Status::active()->where('type', 'user')->get();

        return view('admin.users.index', compact('users', 'roles', 'statuses'));
    }

    public function create()
    {
        $roles = Role::all();
        $statuses = Status::all(); // nếu muốn cho admin chọn trạng thái ban đầu
        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phoneNumber' => 'required|digits:10|unique:users,phoneNumber',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ], [
            'required' => ':attribute không được để trống',
            'email' => 'Email không đúng định dạng',
            'unique' => ':attribute đã tồn tại',
            'digits' => ':attribute phải gồm 10 chữ số',
            'confirmed' => 'Xác nhận mật khẩu không khớp',
            'exists' => ':attribute không hợp lệ',
        ], [
            'name' => 'Họ tên',
            'email' => 'Email',
            'phoneNumber' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            'role_id' => 'Vai trò',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phoneNumber' => $validated['phoneNumber'],
                'password' => bcrypt($validated['password']),
                'role_id' => $validated['role_id'],
                'status_id' => 12, // mặc định đang hoạt động
            ]);

            return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi tạo tài khoản. Vui lòng thử lại.'])->withInput();
        }
    }

    public function edit($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        if ($currentUser->role_id == $user->role_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa người dùng có cùng vai trò!');
        }

        $roles = Role::all();
        $statuses = Status::all();

        return view('admin.users.edit', compact('user', 'roles', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        if ($currentUser->role_id == $user->role_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền cập nhật người dùng có cùng vai trò!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phoneNumber' => [
                'required',
                'digits:10',
                Rule::unique('users', 'phoneNumber')->ignore($user->id),
            ],
            'status_id' => 'nullable|exists:statuses,id',
        ], [
            'name.required' => 'Họ tên không được để trống.',
            'name.string' => 'Họ tên phải là chuỗi ký tự.',
            'name.max' => 'Họ tên không được vượt quá :max ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',

            'phoneNumber.required' => 'Số điện thoại không được để trống.',
            'phoneNumber.digits' => 'Số điện thoại phải gồm 10 chữ số.',
            'phoneNumber.unique' => 'Số điện thoại đã tồn tại.',

            'status_id.exists' => 'Trạng thái không hợp lệ.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;

        if ($currentUser->role->name === 'admin' && $request->filled('status_id')) {
            if ($user->status_id != $request->status_id) {
                // ✅ Ghi log thay đổi trạng thái
                StatusLog::create([
                    'loggable_type' => User::class,
                    'loggable_id' => $user->id,
                    'status_id' => $request->status_id,
                    'user_id' => auth()->id(),
                    'note' => 'Cập nhật trạng thái bởi admin',
                ]);
            }

            $user->status_id = $request->status_id;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
    }
    public function statusLogs($id)
    {
        $user = User::findOrFail($id);
        $logs = $user->statusLogs()->with('status', 'user')->latest()->get();

        return view('admin.users.status_logs', compact('user', 'logs'));
    }
}
