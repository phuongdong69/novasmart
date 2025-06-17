@extends('layouts.admin')

@section('title', 'Thêm chức vụ mới')

@section('content')
    <div class="container-fluid">
        <div class="mb-3 d-flex justify-content-between">
            <h4 class="mb-0">Thêm chức vụ mới</h4>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Tên chức vụ</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Lưu lại</button>
        </form>
    </div>
@endsection
