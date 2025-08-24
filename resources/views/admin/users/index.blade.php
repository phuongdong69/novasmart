@extends('admin.layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="bg-white rounded-xl shadow p-6 mb-6 max-w-7xl w-full mx-auto">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm tên, email, SĐT..."
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-300 focus:border-indigo-500 transition text-sm w-full" />

            <select name="role_id"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-300 focus:border-indigo-500 transition text-sm w-full">
                <option value="">-- Vai trò --</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @if (request('role_id') == $role->id) selected @endif>
                        {{ $role->name }}</option>
                @endforeach
            </select>

            <select name="status_id"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-300 focus:border-indigo-500 transition text-sm w-full">
                <option value="">-- Trạng thái --</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" @if (request('status_id') == $status->id) selected @endif>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>


            <input type="date" name="created_from" value="{{ request('created_from') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-300 focus:border-indigo-500 transition text-sm w-full"
                placeholder="Từ ngày" />

            <input type="date" name="created_to" value="{{ request('created_to') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-indigo-300 focus:border-indigo-500 transition text-sm w-full"
                placeholder="Đến ngày" />

            <div class="flex gap-2">
                <button
                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4-4m0 0A7 7 0 104 4a7 7 0 0013 13z" />
                    </svg>
                    Tìm kiếm
                </button>
                <a href="{{ route('admin.users.create') }}"
                    class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-500 transition font-semibold text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Thêm mới
                </a>
            </div>
        </form>

        @if (session('success'))
            <div id="toast-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded shadow transition-all duration-300">
                {{ session('success') }}</div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) toast.style.display = 'none';
                }, 2500);
            </script>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Tên</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">SĐT</th>
                        <th class="px-4 py-3">Vai trò</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Ngày tạo</th>
                        <th class="px-4 py-3">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $user->id }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->phone ?? ($user->phoneNumber ?? '-') }}</td>
                            <td class="px-4 py-3">{{ $user->role->name ?? '-' }}</td>

                            <td class="px-4 py-3">
                                @if ($user->status)
                                    <span class="text-white text-xs font-semibold rounded px-2 py-1"
                                        style="background:{{ $user->status->color }}">
                                        {{ $user->status->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">Chưa có</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if (auth()->user()->role_id != $user->role_id)
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 text-xs">Sửa</a>
                                    @endif
                                    <a href="{{ route('admin.users.status_logs', $user) }}"
                                        class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 text-xs">Lịch
                                        sử</a>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">Không tìm thấy người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
@endsection
