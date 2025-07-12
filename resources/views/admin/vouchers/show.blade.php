@extends('admin.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<h2>Chi tiết Voucher</h2>
<p><strong>Code:</strong> {{ $voucher->code }}</p>
<p><strong>Loại:</strong> {{ $voucher->discount_type }}</p>
<p><strong>Giá trị:</strong> {{ $voucher->discount_value }}</p>
<p><strong>Hết hạn:</strong> {{ $voucher->expiry_date }}</p>
<p><strong>Số lượng:</strong> {{ $voucher->quantity }}</p>
<a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-warning">Sửa</a>
<form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST">
<a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection
