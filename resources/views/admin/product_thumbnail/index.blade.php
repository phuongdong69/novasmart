@extends('admin.pages.body')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách Product Thumbnails</h1>
        <a href="{{ route('admin.product_thumbnail.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Thêm mới</a>
    </div>
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product Variant ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ảnh</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ảnh chính</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Thứ tự</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hành động</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($thumbnails as $thumbnail)
                    <tr>
                        <td class="px-4 py-2">{{ $thumbnail->id }}</td>
                        <td class="px-4 py-2">{{ $thumbnail->product_id }}</td>
                        <td class="px-4 py-2">{{ $thumbnail->product_variant_id }}</td>
                        <td class="px-4 py-2">
                            @if($thumbnail->url)
                                <img src="{{ asset('storage/' . $thumbnail->url) }}" alt="Thumbnail" class="h-16 w-16 object-cover rounded border">
                            @else
                                <span class="text-gray-400 italic">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded {{ $thumbnail->is_primary ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $thumbnail->is_primary ? 'Có' : 'Không' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $thumbnail->sort_order }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.product_thumbnail.edit', $thumbnail->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500 transition">Sửa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 