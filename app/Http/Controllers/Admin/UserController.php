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
        $statuses = Status::all();
        return view('admin.users.create', compact('roles', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'phoneNumber' => 'required|digits:10|unique:users,phoneNumber',
            'password'    => 'required|string|min:6|confirmed',
            'role_id'     => 'required|exists:roles,id',
        ], [
            'required'  => ':attribute không được để trống',
            'email'     => 'Email không đúng định dạng',
            'unique'    => ':attribute đã tồn tại',
            'digits'    => ':attribute phải gồm 10 chữ số',
            'confirmed' => 'Xác nhận mật khẩu không khớp',
            'exists'    => ':attribute không hợp lệ',
            'min'       => ':attribute tối thiểu :min ký tự',
        ], [
            'name'        => 'Họ tên',
            'email'       => 'Email',
            'phoneNumber' => 'Số điện thoại',
            'password'    => 'Mật khẩu',
            'role_id'     => 'Vai trò',
        ]);

        User::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phoneNumber' => $validated['phoneNumber'],
            'password'    => bcrypt($validated['password']),
            'role_id'     => $validated['role_id'],
            'status_id'   => Status::where('type','user')->where('code','active')->value('id') ?? 12, // fallback
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công!');
    }

    public function edit($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        // Chặn sửa người cùng vai
        if ($currentUser->role_id == $user->role_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa người dùng có cùng vai trò!');
        }

        $roles = Role::all();
        $statuses = Status::active()->where('type','user')->get();

        return view('admin.users.edit', compact('user', 'roles', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);

        // Chặn sửa người cùng vai
        if ($currentUser->role_id == $user->role_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền cập nhật người dùng có cùng vai trò!');
        }

        // Validate chung
        $rules = [
            'name'        => ['required','string','max:255'],
            'email'       => ['required','email', Rule::unique('users','email')->ignore($user->id)],
            'phoneNumber' => ['required','digits:10', Rule::unique('users','phoneNumber')->ignore($user->id)],
            'status_id'   => ['nullable','exists:statuses,id'],
        ];
        $messages = [
            'required'        => ':attribute không được để trống.',
            'string'          => ':attribute phải là chuỗi ký tự.',
            'max'             => ':attribute không được vượt quá :max ký tự.',
            'email'           => 'Email không đúng định dạng.',
            'unique'          => ':attribute đã tồn tại.',
            'digits'          => ':attribute phải gồm :digits chữ số.',
            'exists'          => ':attribute không hợp lệ.',
        ];
        $attributes = [
            'name'        => 'Họ tên',
            'email'       => 'Email',
            'phoneNumber' => 'Số điện thoại',
            'status_id'   => 'Trạng thái',
            'role_id'     => 'Vai trò',
        ];

        // Nếu là admin → cho phép đổi vai trò
        if ($currentUser->role->name === 'admin') {
            $rules['role_id'] = ['required','exists:roles,id'];
        }

        $validated = $request->validate($rules, $messages, $attributes);

        // Chặn tự hạ quyền chính mình (nếu lỡ sửa bản thân)
        if ($currentUser->id === $user->id && isset($validated['role_id']) && $validated['role_id'] != $user->role_id) {
            return back()->withErrors(['role_id' => 'Bạn không thể thay đổi vai trò của chính mình.'])->withInput();
        }

        // Cập nhật thông tin cơ bản
        $user->name        = $validated['name'];
        $user->email       = $validated['email'];
        $user->phoneNumber = $validated['phoneNumber'];

        // Cập nhật trạng thái (và log)
        if ($currentUser->role->name === 'admin' && $request->filled('status_id')) {
            if ($user->status_id != $validated['status_id']) {
                StatusLog::create([
                    'loggable_type' => User::class,
                    'loggable_id'   => $user->id,
                    'status_id'     => $validated['status_id'],
                    'user_id'       => $currentUser->id,
                    'note'          => 'Cập nhật trạng thái bởi admin',
                ]);
                $user->status_id = $validated['status_id'];
            }
        }

        // Cập nhật vai trò (chỉ admin)
        if ($currentUser->role->name === 'admin' && isset($validated['role_id'])) {
            // (tuỳ chính sách: có thể chặn hạ quyền từ superadmin -> admin, v.v.)
            $user->role_id = $validated['role_id'];
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
