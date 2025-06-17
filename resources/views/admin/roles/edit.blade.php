@extends('layouts.body')

@section('content')
    <div class="container mt-4">
        <h4>Cập nhật chức vụ</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên chức vụ</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Ghi chú</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $role->description) }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Cập nhật</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection
