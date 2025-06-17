@extends('layouts.body')

@section('content')
    <div class="container-fluid pt-24 py-4"> {{-- Thêm pt-24 để tránh navbar đè lên --}}
        <h3 class="mb-4">Trang quản trị</h3>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h6 class="mb-2">👤 Người dùng</h6>
                    <h4>{{ $userCount }}</h4>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h6 class="mb-2">🛡️ Chức vụ</h6>
                    <h4>{{ $roleCount }}</h4>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h6 class="mb-2">📁 Danh mục (Category)</h6>
                    <h4>{{ $categoryCount }}</h4>
                </div>
            </div>
            {{-- Nếu muốn hiện Origin thì bỏ comment dưới đây --}}
            {{-- <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h6 class="mb-2">🌍 Xuất xứ (Origin)</h6>
                    <h4>{{ $originCount }}</h4>
                </div>
            </div> --}}
            {{-- <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3">
                    <h6 class="mb-2">🏷️ Thương hiệu (Brand)</h6>
                    <h4>{{ $brandCount }}</h4>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
