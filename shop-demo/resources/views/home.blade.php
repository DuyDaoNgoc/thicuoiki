@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 p-4">
           

            {{-- 🌟 Sản phẩm nổi bật --}}
            <h3 class="mt-4">🌟 Sản phẩm nổi bật</h3>
            <div class="row">
                @forelse($featuredProducts as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Chưa có sản phẩm nổi bật.</p>
                @endforelse
            </div>

            {{-- 🆕 Sản phẩm mới nhất --}}
            <h3 class="mt-5">🆕 Sản phẩm mới nhất</h3>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover mb-2">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-outline-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Chưa có sản phẩm nào.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
