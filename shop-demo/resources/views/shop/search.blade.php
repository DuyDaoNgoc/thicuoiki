@extends('layouts.app')

@section('content')
    <div class="search-results">
        <h1>Kết quả tìm kiếm: "{{ $query }}"</h1>
        
        @if($products->isEmpty())
            <p>Không có sản phẩm nào phù hợp với từ khóa "{{ $query }}".</p>
        @else
            <div class="products-list">
                @foreach($products as $product)
                    <div class="product-item">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ Str::limit($product->description, 100) }}</p>
                        <p class="price">{{ number_format($product->price) }} VND</p>
                        
                        <!-- New buttons for Buy and Add to Cart -->
                        <div class="product-actions">
                            <!-- Add product ID to the URL -->
                            <a href="{{ route('cart.index', ['id' => $product->id]) }}" class="add-to-cart-btn">Thêm vào giỏ hàng</a>
                            <a href="{{ route('checkout.index', ['id' => $product->id]) }}" class="buy-now-btn">Mua ngay</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

<style>
    .search-results {
        padding: 2rem;
        background-color: #f9fafb;
    }

    .products-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .product-item {
        background-color: white;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .product-item:hover {
        transform: translateY(-5px);
    }

    .product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #e5e7eb;
    }

    h3 {
        font-size: 1.2rem;
        margin: 10px;
        color: #333;
    }

    p {
        margin: 0 10px 10px;
        color: #555;
    }

    .price {
        font-size: 1.1rem;
        color: #e74c3c;
        font-weight: bold;
        margin: 10px;
    }

    .product-actions {
        display: flex;
        justify-content: space-between;
        margin: 10px;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        color: white;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn {
        background-color: #4CAF50;
    }

    .add-to-cart-btn:hover {
        background-color: #45a049;
    }

    .buy-now-btn {
        background-color: #007bff;
    }

    .buy-now-btn:hover {
        background-color: #0056b3;
    }

</style>
