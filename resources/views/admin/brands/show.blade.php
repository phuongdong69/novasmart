@extends('layouts.main')

@section('title')
Chi tiết thương hiệu
@endsection

@section('content')
<div class="container">
    <h2>Chi tiết thương hiệu</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tên: {{ $brand->name }}</h5>

        </div>
    </div>
    <a href="{{ route('brands.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection