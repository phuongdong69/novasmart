<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with(['role']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        if ($request->filled('status_code')) {
            $query->where('status_code', $request->status_code);
        }

        $users = $query->orderBy('id', 'desc')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $statuses = Status::getByType('user');
        return view('admin.users.create', compact('roles', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'status_code' => 'required|string',
            'gender' => 'nullable|string|in:male,female,other',
            'birthday' => 'nullable|date',
            'phoneNumber' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'image_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);

        // Handle image upload
        if ($request->hasFile('image_user')) {
            $imagePath = $request->file('image_user')->store('users', 'public');
            $data['image_user'] = $imagePath;
        }

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Thêm người dùng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with(['role', 'status'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $statuses = Status::getByType('user');
        return view('admin.users.edit', compact('user', 'roles', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $user = User::findOrFail($id);

            // Debug: Log the request data
            Log::info('User update request:', $request->all());

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
                'status_code' => 'required|string',
                'gender' => 'nullable|string|in:male,female,other',
                'birthday' => 'nullable|date',
                'phoneNumber' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'image_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Get all validated data plus additional fields
            $data = $validator->validated();
            
            // Add additional fields that might not be in validation
            $additionalFields = ['gender', 'birthday', 'phoneNumber', 'address'];
            foreach ($additionalFields as $field) {
                if ($request->has($field) && $request->input($field) !== null) {
                    $data[$field] = $request->input($field);
                }
            }
            
            // Debug: Log the validated data
            Log::info('Validated data:', $data);

            // Handle password
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            // Handle image upload
            if ($request->hasFile('image_user')) {
                // Delete old image if exists
                if ($user->image_user && file_exists(storage_path('app/public/' . $user->image_user))) {
                    unlink(storage_path('app/public/' . $user->image_user));
                }
                
                // Store new image
                $imagePath = $request->file('image_user')->store('users', 'public');
                $data['image_user'] = $imagePath;
                
                Log::info('Image uploaded:', ['path' => $imagePath]);
            } else {
                unset($data['image_user']);
            }

            // Debug: Log the final data to be updated
            Log::info('Final data to update:', $data);

            $result = $user->update($data);
            
            // Debug: Log the update result
            Log::info('Update result:', ['success' => $result, 'user_id' => $id]);

            // Force refresh the user data
            $user->refresh();
            
            // Clear any cached data
            cache()->forget('users');
            
            return redirect()->route('admin.users.index')
                ->with('success', 'Cập nhật người dùng thành công!')
                ->with('debug', 'User ID: ' . $id . ', Updated: ' . $user->updated_at);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}
