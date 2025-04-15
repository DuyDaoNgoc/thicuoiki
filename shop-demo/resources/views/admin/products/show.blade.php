@extends('layouts.app')

@section('content')
<style>
    .product-details {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    .product-details h1 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #2c3e50;
        text-align: center;
    }

    .product-info {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .product-image {
        flex: 1 1 300px;
        text-align: center;
    }

    .product-image img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .product-meta {
        flex: 1 1 300px;
    }

    .product-meta p {
        margin-bottom: 10px;
        font-size: 1rem;
        color: #333;
    }

    .product-meta span {
        font-weight: bold;
        color: #555;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        color: #3498db;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="product-details">
    <h1>Chi tiết sản phẩm</h1>

    <div class="product-info">
        <div class="product-image">
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
            @else
                <p><em>Không có ảnh</em></p>
            @endif
        </div>
        <div class="product-meta">
            <p><span>Tên sản phẩm:</span> {{ $product->name }}</p>
            <p><span>Giá:</span> {{ number_format($product->price, 0, ',', '.') }} VND</p>
            <p><span>Tồn kho:</span> {{ $product->stock ?? 'Chưa cập nhật' }}</p>
            <p><span>Danh mục:</span> {{ $product->category->name ?? 'Không có' }}</p>
            <p><span>Ngày tạo:</span> {{ $product->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ $backUrl ?? route('admin.products.index') }}" class="back-link">← Quay lại trang trước</a>

</div>
@endsection
