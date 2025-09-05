@extends('user.layouts.client')

@section('content')
@include('user.partials.popup')
@include('user.partials.toast')
<section class="relative lg:py-24 py-16">
    <div class="container relative">
        <div class="grid grid-cols-1 mt-14">
            <h3 class="text-3xl leading-normal font-semibold">Sản phẩm</h3>
        </div><!--end grid-->

        <div class="relative mt-3">
            <ul class="tracking-[0.5px] mb-0 inline-block">
                <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500">
                    <a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180">
                    <i class="mdi mdi-chevron-right"></i>
                </li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5 ltr:rotate-0 rtl:rotate-180">
                    <a href="#" class="hover:text-orange-500">Sản phẩm</a>
                </li>
            </ul>
        </div><!--end relative-->
    </div><!--end container-->

    <div class="container relative mt-8">
        <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6">
            <!-- Filter Sidebar -->
            @include('user.partials.filter')

            <!-- Product List -->
            <div class="lg:col-span-9 md:col-span-8">
                <div class="md:flex justify-between items-center mb-6">
                    <span class="font-semibold">
                        Hiển thị {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} 
                        trên tổng số {{ $products->total() }} sản phẩm
                    </span>

                    <div class="md:flex items-center">
                        <label class="font-semibold md:me-2">Sắp xếp theo:</label>
                        <select name="sort" onchange="this.form.submit()" form="filterForm"
                                class="form-select form-input md:w-36 w-full md:mt-0 mt-1 py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                    @forelse($products as $product)
                        @php
                            // Lấy biến thể đầu tiên có sẵn của sản phẩm
                            $firstVariant = $product->variants->first();
                            
                            if (!$firstVariant) {
                                continue; // Bỏ qua sản phẩm không có biến thể
                            }
                            
                            $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                            $imageUrl = $thumbnail ? asset('storage/' . $thumbnail->url) : asset('assets/user/images/shop/default-product.jpg');
                            
                            // Lấy các thuộc tính để hiển thị
                            $attributes = $firstVariant->variantAttributeValues->map(function($vav) {
                                return $vav->attribute->name . ': ' . $vav->attributeValue->value;
                            })->implode(', ');
                            
                            $status = $firstVariant?->status;

                            $isOutOfStock = $firstVariant && (
                            ($status && $status->code === 'out_of_stock' && $status->type === 'product_variant')
                            || $firstVariant->quantity == 0
                            );
                        @endphp
                        <div class="group">
                            <div class="relative overflow-hidden rounded-md shadow dark:shadow-gray-800">
                                <img src="{{ $imageUrl }}" class="group-hover:scale-110 duration-500 w-full h-64 object-cover" alt="{{ $product->name }}">
                                
                                <div class="absolute top-4 end-4">
                                    <a href="{{ route('products.show', $firstVariant->id) }}" class="size-10 inline-flex items-center justify-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow">
                                        <i data-feather="eye" class="size-4"></i>
                                    </a>
                                </div>
                                
                                @if($firstVariant->quantity <= 0)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="text-white font-semibold">Hết hàng</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('products.show', $firstVariant->id) }}" class="h5 text-lg font-semibold hover:text-orange-500">{{ $product->name }}</a>
                                
                                @if($product->brand)
                                    <p class="text-slate-400 mt-1">{{ $product->brand->name }}</p>
                                @endif
                                
                                @if($attributes)
                                    <p class="text-sm text-slate-500 mt-1">{{ $attributes }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-red-600 font-semibold text-lg">{{ number_format($firstVariant->price) }}₫</span>
                                    
                                    @php
                                        $ratings = $product->ratings ?? collect();
                                        $averageRating = round($ratings->avg('rating') ?? 0, 1);
                                        $totalRatings = $ratings->count();
                                    @endphp

                                    <ul class="font-medium text-amber-400 list-none">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li class="inline">
                                                <i class="mdi mdi-star{{ $i <= round($averageRating) ? '' : '-outline' }}"></i>
                                            </li>
                                        @endfor
                                        @if ($totalRatings > 0)
                                            <li class="inline text-slate-400 ms-1">{{ $averageRating }} ({{ $totalRatings }})</li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="mt-3">
                                    @if(!$isOutOfStock)
                                        <a href="{{ route('products.show', $firstVariant->id) }}" 
                                           class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-slate-900 text-white w-full rounded-md hover:bg-slate-800 transition-colors">
                                            Xem Chi Tiết
                                        </a>
                                    @else
                                        <button disabled class="py-2 px-5 inline-block font-semibold tracking-wide align-middle duration-500 text-base text-center bg-gray-400 text-white w-full rounded-md cursor-not-allowed">
                                            Hết hàng
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <i data-feather="package" class="size-16 mx-auto text-gray-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm</h3>
                            <p class="text-gray-500">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                        </div>
                    @endforelse
                </div>

                <!-- Phân trang tùy chỉnh -->
                @if($products->hasPages())
                <div class="grid md:grid-cols-12 grid-cols-1 mt-6">
                    <div class="md:col-span-12 text-center">
                        <div class="custom-pagination">
                            <!-- Nút Previous -->
                            @if($products->currentPage() > 1)
                                <a href="{{ $products->previousPageUrl() }}" class="pagination-btn pagination-prev">
                                    <i class="mdi mdi-chevron-left"></i>
                                    Trước
                                </a>
                            @else
                                <span class="pagination-btn pagination-disabled">
                                    <i class="mdi mdi-chevron-left"></i>
                                    Trước
                                </span>
                            @endif

                            <!-- Số trang -->
                            <div class="pagination-numbers">
                                @php
                                    $currentPage = $products->currentPage();
                                    $lastPage = $products->lastPage();
                                    $startPage = max(1, $currentPage - 2);
                                    $endPage = min($lastPage, $currentPage + 2);
                                    
                                    // Đảm bảo hiển thị ít nhất 5 trang nếu có thể
                                    if ($endPage - $startPage < 4) {
                                        if ($startPage == 1) {
                                            $endPage = min($lastPage, $startPage + 4);
                                        } else {
                                            $startPage = max(1, $endPage - 4);
                                        }
                                    }
                                @endphp

                                <!-- Trang đầu -->
                                @if($startPage > 1)
                                    <a href="{{ $products->url(1) }}" class="pagination-number">1</a>
                                    @if($startPage > 2)
                                        <span class="pagination-dots">...</span>
                                    @endif
                                @endif

                                <!-- Các trang giữa -->
                                @for($i = $startPage; $i <= $endPage; $i++)
                                    @if($i == $currentPage)
                                        <span class="pagination-number pagination-active">{{ $i }}</span>
                                    @else
                                        <a href="{{ $products->url($i) }}" class="pagination-number">{{ $i }}</a>
                                    @endif
                                @endfor

                                <!-- Trang cuối -->
                                @if($endPage < $lastPage)
                                    @if($endPage < $lastPage - 1)
                                        <span class="pagination-dots">...</span>
                                    @endif
                                    <a href="{{ $products->url($lastPage) }}" class="pagination-number">{{ $lastPage }}</a>
                                @endif
                            </div>

                            <!-- Nút Next -->
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="pagination-btn pagination-next">
                                    Sau
                                    <i class="mdi mdi-chevron-right"></i>
                                </a>
                            @else
                                <span class="pagination-btn pagination-disabled">
                                    Sau
                                    <i class="mdi mdi-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@if (!Auth::check())
<div id="popup-login-required" class="fixed inset-0 z-[10000] bg-black bg-opacity-60 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-md shadow-lg max-w-md w-full popup-box">
        <h2 class="text-lg font-semibold text-slate-800 dark:text-white mb-2">Yêu cầu đăng nhập</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-4">Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded bg-orange-500 text-white font-semibold">Đăng nhập</a>
            <button onclick="document.getElementById('popup-login-required').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-gray-800">Đóng</button>
        </div>
    </div>
</div>
@endif
<style>
.custom-toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    min-width: 260px;
    max-width: 360px;
    background-color: #16a34a;
    color: #fff;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    animation: slideIn 0.3s ease-out;
    font-size: 14px;
    line-height: 1.4;
    transition: opacity 0.4s ease-out;
}
.toast-icon {
    width: 20px;
    height: 20px;
    stroke: #fff;
}
.toast-message {
    flex: 1;
    font-weight: 600;
}
.toast-close {
    background: transparent;
    border: none;
    color: #fff;
    cursor: pointer;
}
.toast-close-icon {
    width: 16px;
    height: 16px;
    stroke: #fff;
}
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    background-color: #a3e635;
    animation: progressBar 4s linear forwards;
    width: 100%;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(50%); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes progressBar {
    from { width: 100%; }
    to { width: 0%; }
}

/* Custom Pagination Styles */
.custom-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
    margin: 20px 0;
}

.pagination-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 16px;
    background-color: #f8fafc;
    color: #475569;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.pagination-btn:hover {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.pagination-disabled {
    background-color: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
    border-color: #e2e8f0;
}

.pagination-disabled:hover {
    background-color: #f1f5f9;
    color: #94a3b8;
    transform: none;
    box-shadow: none;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: 4px;
    margin: 0 12px;
}

.pagination-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: #f8fafc;
    color: #475569;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.pagination-number:hover {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.pagination-active {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.pagination-dots {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    color: #94a3b8;
    font-weight: 500;
    font-size: 14px;
}

.pagination-info {
    margin-top: 16px;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .pagination-btn {
        background-color: #1e293b;
        color: #cbd5e1;
        border-color: #334155;
    }
    
    .pagination-btn:hover {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    
    .pagination-disabled {
        background-color: #0f172a;
        color: #64748b;
        border-color: #334155;
    }
    
    .pagination-number {
        background-color: #1e293b;
        color: #cbd5e1;
        border-color: #334155;
    }
    
    .pagination-number:hover {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    
    .pagination-dots {
        color: #64748b;
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .custom-pagination {
        gap: 4px;
    }
    
    .pagination-btn {
        padding: 8px 12px;
        font-size: 13px;
    }
    
    .pagination-number {
        width: 36px;
        height: 36px;
        font-size: 13px;
    }
    
    .pagination-dots {
        width: 36px;
        height: 36px;
        font-size: 13px;
    }
    
    .pagination-numbers {
        margin: 0 8px;
    }
}
</style>
<script src="{{ asset('assets/user/js/shop-cart.js') }}"></script>
@endsection
