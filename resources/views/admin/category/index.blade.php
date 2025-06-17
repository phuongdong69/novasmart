@extends('admin.layouts.app')

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">





          <div class="mb-3 d-flex justify-content-between" style="margin: 20px;">
            <h4 class="mb-0">Danh sách danh mục</h4>

            <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Thêm mới</a>

          </div>

          @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif

          <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Tên danh mục</th>
                  <th>Trạng thái</th>
                  <th>Thời gian tạo</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $index => $category)
                <tr>
                  <td>{{ $category->id }}</td>
                  <td>{{ $category->name }}</td>
                  <td>
                    <form action="{{ route('admin.categories.toggleStatus', $category->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn btn-sm {{ $category->status ? 'btn-success' : 'btn-secondary' }}">
                        {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                      </button>
                    </form>
                  </td>
                  <td>{{ $category->created_at->format('d/m/Y') }}</td>
                  <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                      @csrf @method('DELETE')
                      <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="btn btn-sm btn-danger">Xoá</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">Không có danh mục nào.</td>
                </tr>
                @endforelse
              </tbody>
            </table>

          </div>
          <div class="mt-3 d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-4') }}
          </div>
        </div>

      </section>
    </div>

   
   