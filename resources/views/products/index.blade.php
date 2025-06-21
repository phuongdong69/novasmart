@extends('layouts.app')

@section('title', 'Danh sách sản phẩm')

@section('content')
<h2 class="my-4">Sản phẩm mới nhất</h2>

<div class="row">
    @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5>{{ $product->name }}</h5>
                    <p>{{ number_format($product->price, 0, ',', '.') }} đ</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection
