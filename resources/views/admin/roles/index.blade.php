@extends('layouts.body')

@section('content')
<div class="container-fluid">

    <div class="mb-3 d-flex justify-content-between">
        <h4 class="mb-0">Danh sách chức vụ</h4>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">+ Thêm mới</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên chức vụ</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="btn btn-sm btn-danger">Xoá</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Không có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $roles->links('pagination::bootstrap-4') }}
    </div>

</div>
@endsection
