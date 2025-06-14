@extends('layouts.app')

@section('content')
<h2>Chi tiết Voucher</h2>
<p><strong>Code:</strong> {{ $voucher->code }}</p>
<p><strong>Loại:</strong> {{ $voucher->discount_type }}</p>
<p><strong>Giá trị:</strong> {{ $voucher->discount_value }}</p>
<p><strong>Hết hạn:</strong> {{ $voucher->expiry_date }}</p>
<p><strong>Số lượng:</strong> {{ $voucher->quantity }}</p>
<a href="{{ route('vouchers.index') }}">Quay lại</a>
@endsection
