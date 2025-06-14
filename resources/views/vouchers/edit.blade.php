@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0">✏️ Cập nhật Voucher</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('vouchers.partials.form', ['voucher' => $voucher])

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary">← Quay lại</a>
                    <button type="submit" class="btn btn-primary">✔️ Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
