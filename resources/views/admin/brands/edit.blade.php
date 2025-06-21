
@extends('admin.layouts.app')

@section('title')
Chỉnh sửa thương hiệu
@endsection

@section('content')
<div class="container">
    <h2>Chỉnh sửa thương hiệu</h2>
    <form method="POST" action="{{ route('brands.update', $brand->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="name" class="col-4 col-form-label">Tên thương hiệu</label>
            <div class="col-8">
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    value="{{ old('name', $brand->name) }}"
                    required
                />
            </div>
        </div>
        <div class="mb-3 row">
            <div class="offset-sm-4 col-sm-8">
                <button type="submit" class="btn btn-primary">
                    Lưu thay đổi
                </button>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </form>
</div>
@endsection