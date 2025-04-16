@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        border-left: 6px solid #007bff;
        padding-left: 12px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-6px);
    }

    .card img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        margin-bottom: 8px;
    }

    .card-text {
        font-size: 15px;
        margin-bottom: 12px;
    }

    .btn-outline-primary {
        border-radius: 8px;
    }
</style>

<div class="container py-5">
    {{-- 🌟 Sản phẩm nổi bật --}}
    <h3 class="section-title">🌟 Sản phẩm nổi bật</h3>
    <div class="row">
        @forelse($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
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
    <h3 class="section-title mt-5">🆕 Sản phẩm mới nhất</h3>
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
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
@endsection
