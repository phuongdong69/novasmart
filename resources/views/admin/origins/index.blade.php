<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

  @include('layouts.assets')
  @include('admin.sidebar')

  <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
    @include('admin.navbar')

    <div class="w-full px-6 py-6 mx-auto">
        
      <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
          <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
            
            <div class="p-6 pb-0 mb-0 border-b border-b-solid rounded-t-2xl border-b-slate-200 flex items-center justify-between">
                
              <h6 class="dark:text-white text-lg font-semibold">Bảng xuất xứ</h6>
              <a href="{{ route('admin.origins.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded">
                + Thêm mới
              </a>
            </div>
            @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if (session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
            <div class="flex-auto px-0 pt-0 pb-2">
              <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-collapse text-slate-500">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">ID</th>
                      <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Quốc gia</th>
                      <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Ngày tạo</th>
                      <th class="px-6 py-3 text-left uppercase text-xs font-bold text-slate-400">Thao tác</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    @forelse ($origins as $origin)
                      <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-3 whitespace-nowrap text-sm">{{ $origin->id }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-800">{{ $origin->country }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">{{ $origin->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm">
                          <a href="{{ route('admin.origins.edit', $origin->id) }}" class="text-blue-600 hover:underline mr-2">Sửa</a>
                          <form action="{{ route('admin.origins.destroy', $origin->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Xác nhận xoá?')" class="text-red-500 hover:underline">Xoá</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="4" class="text-center py-4 text-sm text-gray-500">Không có dữ liệu nguồn gốc.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>

                <!-- Phân trang -->
                <div class="mt-4 px-6 flex justify-center">
  {{ $origins->links('pagination::bootstrap-4') }}
</div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    @include('admin.footer')
  </main>

  @include('layouts.scripts')
</body>
