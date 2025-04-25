@extends('layouts.app')

@section('content')
<style>
    .cart-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 24px;
        background: #fdfdfd;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .cart-title {
        font-size: 30px;
        font-weight: bold;
        margin-bottom: 24px;
        color: #333;
        text-align: center;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th, .cart-table td {
        padding: 14px 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        vertical-align: top;
    }

    .cart-table th {
        background-color: #f5f5f5;
        color: #444;
        font-weight: 600;
    }

    .cart-product {
        display: flex;
        align-items: flex-start;
    }

    .cart-product img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 12px;
        border: 1px solid #ddd;
    }

    .cart-product-info {
        display: flex;
        flex-direction: column;
    }

    .cart-product-info .product-name {
        font-weight: 500;
    }

    .cart-product-info .product-size {
        font-size: 14px;
        color: #555;
        margin-top: 4px;
    }

    .btn-update {
        background-color: #ffc107;
        border: none;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-update:hover {
        background-color: #e0a800;
    }

    .btn-remove {
        background-color: #dc3545;
        border: none;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-remove:hover {
        background-color: #c82333;
    }

    .cart-actions {
        margin-top: 28px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .cart-total {
        font-size: 22px;
        font-weight: bold;
        color: #222;
    }

    .btn-checkout {
        background: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 16px;
        transition: background 0.3s ease;
    }

    .btn-checkout:hover {
        background: #218838;
    }

    .cart-empty {
        text-align: center;
        padding: 60px 0;
        font-size: 18px;
        color: #777;
    }

    @media (max-width: 768px) {
        .cart-table th, .cart-table td {
            padding: 10px 6px;
            font-size: 14px;
        }

        .cart-product {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-product img {
            margin-bottom: 8px;
        }

        .cart-actions {
            flex-direction: column;
            align-items: flex-end;
        }

        .cart-total {
            text-align: right;
            width: 100%;
        }
    }
</style>

<div class="cart-container">
    <h2 class="cart-title">Giỏ hàng của bạn</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>
                            <div class="cart-product">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                <div class="cart-product-info">
                                    <span class="product-name">{{ $item['name'] }}</span>
                                    <span class="product-size">Size: {{ $item['size'] ?? 'Không có' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1">
                                <button type="submit" class="btn-update">Cập nhật</button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                        <td>
                            <a href="{{ route('cart.remove', $item['id']) }}" class="btn-remove" onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">Xoá</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-actions">
            <div class="cart-total">Tổng cộng: {{ number_format($totalPrice, 0, ',', '.') }} đ</div>
            <a href="{{ route('checkout.index') }}" class="btn-checkout">Tiến hành thanh toán</a>
        </div>
    @else
        <div class="cart-empty">Giỏ hàng của bạn đang trống.</div>
    @endif
</div>

@endsection
