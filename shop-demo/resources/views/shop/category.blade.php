@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">
            Danh mục: {{ $category->name }}
        </h1>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    @if($product->image)
                    <img src="{{ $product->image ? asset($product->image) : asset('images/no-image.png') }}" 
                    class="card-img-top" 
                    alt="{{ $product->name }}">
               
                    @endif

                    <div class="flex-1">
                        <h2 class="text-lg font-semibold mb-1 text-gray-900">
                            <a href="{{ route('product.detail', $product->id) }}" class="hover:text-blue-600">
                                {{ $product->name }}
                            </a>
                        </h2>
                        <p class="text-red-600 font-bold text-md mb-3">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </p>
                    </div>

                    <div class="flex  mt-auto " style="gap: 10px">
                        {{-- Nút thêm vào yêu thích --}}
                        {{-- Nút xem chi tiết --}}
                        {{-- Nút thêm vào giỏ hàng --}}
                        <form action="{{ route('cart.add') }}" method="POST" class="w-1/2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded-md text-sm font-semibold transition" style="background: red">
                                🛒 Thêm
                            </button>
                        </form>

                        {{-- Nút mua ngay --}}
                        <form action="{{ route('checkout.buy') }}" method="POST" class="w-1/2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit"
                                class="w-full bg-rose-500 hover:bg-rose-600 text-white py-2 px-3 rounded-md text-sm font-semibold transition" style="background: gray">
                                ⚡ Mua
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Không có sản phẩm nào trong danh mục này.</p>
            @endforelse
        </div>
    </div>
@endsection
