@extends('user.layouts.client')

@section('title', 'Danh sách sản phẩm')

@section('content')
<!-- Start Hero -->
<section class="relative table w-full py-20 lg:py-24 md:pt-28 bg-gray-50 dark:bg-slate-800">
    <div class="container relative">
        <div class="grid grid-cols-1 mt-14">
            <h3 class="text-3xl leading-normal font-semibold">Fashion</h3>
        </div>
        <div class="relative mt-3">
            <ul class="tracking-[0.5px] mb-0 inline-block">
                <li class="inline-block uppercase text-[13px] font-bold duration-500 ease-in-out hover:text-orange-500">
                    <a href="/">Cartzio</a>
                </li>
                <li class="inline-block text-base text-slate-950 dark:text-white mx-0.5">
                    <i class="mdi mdi-chevron-right"></i>
                </li>
                <li class="inline-block uppercase text-[13px] font-bold text-orange-500">Shop Grid</li>
            </ul>
        </div>
    </div>
</section>
<!-- End Hero -->

<!-- Start Product Grid -->
<section class="relative md:py-24 py-16">
    <div class="container relative">
        <div class="grid md:grid-cols-12 sm:grid-cols-2 grid-cols-1 gap-6">

            @include('user.partials.filter')

            <div class="lg:col-span-9 md:col-span-8">
                <div class="md:flex justify-between items-center mb-6">
                    <span class="font-semibold">
                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} items
                    </span>
                    <div class="md:flex items-center">
                        <label class="font-semibold md:me-2">Sort by:</label>
                        <select class="form-select md:w-36 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0">
                            <option value="">Featured</option>
                            <option value="">Price Low-High</option>
                            <option value="">Price High-Low</option>
                        </select>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                    @foreach ($products as $product)
                    @php
                    $variant = $product->variants->first();
                    $price = $variant?->price ?? 0;
                    $variantId = $variant?->id ?? null;

                    // Ưu tiên ảnh thumbnail chính
                    $thumbnail = $product->thumbnails->where('is_primary', true)->first();
                    $imageUrl = $thumbnail
                    ? asset('storage/' . $thumbnail->url)
                    : ($product->image
                    ? asset('storage/' . $product->image)
                    : asset('images/default-product.jpg'));
                    @endphp
                    <div class="group">
                        <div class="relative overflow-hidden shadow-sm dark:shadow-gray-800 group-hover:shadow-lg rounded-md duration-500">
                            <img
                                src="{{ $imageUrl }}"
                                class="w-full h-52 object-cover group-hover:scale-110 duration-500"
                                alt="{{ $product->name }}">

                            @if ($variantId)
                            <div class="absolute -bottom-20 group-hover:bottom-3 start-3 end-3 duration-500">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_variant_id" value="{{ $variantId }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="py-2 px-5 inline-block font-semibold text-base text-center bg-slate-900 text-white w-full rounded-md">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                            @endif

                            <ul class="list-none absolute top-[10px] end-4 opacity-0 group-hover:opacity-100 duration-500 space-y-1">
                                <li><a href="#" class="size-10 inline-flex items-center justify-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i class="mdi mdi-heart-outline"></i></a></li>
                                <li><a href="{{ route('user.products.index', $product->id) }}" class="size-10 inline-flex items-center justify-center rounded-full bg-white text-slate-900 hover:bg-slate-900 hover:text-white shadow"><i class="mdi mdi-eye-outline"></i></a></li>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('user.products.index', $product->id) }}" class="hover:text-orange-500 text-lg font-medium">{{ $product->name }}</a>
                            <div class="flex justify-between items-center mt-1">
                                <p>${{ number_format($price, 2) }}</p>
                                <ul class="font-medium text-amber-400 list-none">
                                    @for ($i = 0; $i < 5; $i++)
                                        <li class="inline"><i class="mdi mdi-star"></i></li>
                                        @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End -->
@endsection