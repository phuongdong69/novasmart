@extends('admin.pages.body')
@section('title')
Trang Thêm Mới

@endsection
@section('content')
<div class="container">
    <form method="Post" action="{{route('brands.store')}}">
        @csrf

        <div class="mb-3 row">
            <label
                for="name"
                class="col-4 col-form-label">name</label>
            <div
                class="col-8">
                <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name" />
            </div>
        </div>



        <div class="mb-3 row">
            <div class="offset-sm-4 col-sm-8">
                <button type="submit" class="btn btn-primary">
                    Lưu
                </button>
            </div>
        </div>
    </form>
</div>

@endsection