@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
    <div class="bg-white rounded-xl shadow-md p-4 mb-6 w-full max-w-5xl">
        <form method="GET" class="flex flex-wrap gap-2 items-end">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm tên, email, SĐT..." class="border border-gray-200 rounded-lg px-3 py-2 w-[160px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition text-sm" />
            <select name="role_id" class="border border-gray-200 rounded-lg px-3 py-2 w-[120px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition text-sm">
                <option value="">-- Vai trò --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(request('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 w-[120px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition text-sm">
                <option value="">-- Trạng thái --</option>
                <option value="1" @if(request('status')==='1') selected @endif>Hoạt động</option>
                <option value="0" @if(request('status')==='0') selected @endif>Tạm khóa</option>
            </select>
            <input type="date" name="created_from" value="{{ request('created_from') }}" class="border border-gray-200 rounded-lg px-3 py-2 w-[140px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition text-sm" placeholder="Từ ngày" />
            <input type="date" name="created_to" value="{{ request('created_to') }}" class="border border-gray-200 rounded-lg px-3 py-2 w-[140px] focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition text-sm" placeholder="Đến ngày" />
            <button class="flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition font-semibold shadow w-[110px] justify-center ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" /></svg>
                Tìm kiếm
            </button>
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition font-semibold shadow w-[110px] justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Thêm mới
            </a>
        </form>
    </div>
    @if(session('success'))
        <div id="toast-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow transition-all duration-300">{{ session('success') }}</div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) toast.style.display = 'none';
            }, 2500);
        </script>
    @endif
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">SĐT</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vai trò</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lịch sử trạng thái</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ngày tạo</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->phone ?? $user->phoneNumber ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $user->role->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('admin.users.update_status', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <select name="status_id" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                    @foreach(\App\Models\Status::where('type', 'user')->where('is_active', 1)->orderBy('sort_order')->get() as $status)
                                        <option value="{{ $status->id }}" @if($user->status_id == $status->id) selected @endif>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            @if($user->status && is_object($user->status))
                                <span style="background:{{ $user->status->color }};color:#fff;padding:2px 8px;border-radius:4px">
                                    {{ $user->status->name }}
                                </span>
                            @else
                                <span class="text-gray-400">Chưa có trạng thái</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.users.status_logs', $user) }}" class="text-blue-500">Xem lịch sử</a>
                        </td>
                        <td class="px-4 py-2">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">Xem</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá user này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Không có người dùng nào phù hợp.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->appends(request()->except('page'))->links() }}</div>
@endsection 