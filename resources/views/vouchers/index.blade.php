@extends('layouts.app')

@section('content')
<h2>Danh sách Voucher</h2>

@if(session('success'))
<div style="color: green;">{{ session('success') }}</div>
@endif

<a href="{{ route('vouchers.create') }}" style="display:inline-block; margin-bottom: 20px;">
    <button>Thêm Voucher mới</button>
</a>

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    @foreach($vouchers as $voucher)
    <div style="border: 1px solid #ccc; border-radius: 8px; padding: 16px; width: 300px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);">
        <h3>{{ $voucher->code }}</h3>
        <p><strong>Loại giảm giá:</strong> {{ $voucher->discount_type == 'percentage' ? 'Phần trăm' : 'Cố định' }}</p>
        <p><strong>Giá trị:</strong>
            {{ $voucher->discount_type == 'percentage' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . ' VNĐ' }}
        </p>
        <p><strong>Hết hạn:</strong> {{ $voucher->expiry_date }}</p>
        <p><strong>Số lượng:</strong> {{ $voucher->quantity }}</p>
        <p><strong>Ngày tạo:</strong> {{ $voucher->created_at->format('d/m/Y') }}</p>

        <div class="btn-group" role="group">
            <a href="{{ route('vouchers.show', $voucher->id) }}" class="btn btn-sm btn-outline-secondary">Xem</a>
            <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-outline-success">Sửa</a>
            <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá voucher này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Xoá</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection