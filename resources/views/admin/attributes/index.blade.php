@extends('admin.pages.body')
@section('title')
Trang Thương Hiệu
@endsection
@section('content')
<a class="btn btn-primary mb-3" href="{{route('admin.brands.create')}}">Thêm Mới</a>
<div class="table-responsive">
    <table class="table table-primary">
        <thead>
            <tr>
      
                <th scope="col">Name</th>
               
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $brand )
            <tr class="">
                <td scope="row">{{$loop->index+1}}</td>

                <td scope="row">{{$brand->name}}</td>
                <td>
                    <a class="btn btn-warning" href="{{route('admin.brands.edit',$brand->id)}}">Sửa</a>
                     <a class="btn btn-success" href="{{route('admin.brands.show',$brand->id)}}">Xem Chi Tiết</a>
                    <form action="{{route('brands.destroy',$brand->id)}}" method="post" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection