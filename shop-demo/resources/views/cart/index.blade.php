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
    }

    .cart-table th {
        background-color: #f5f5f5;
        color: #444;
        font-weight: 600;
    }

    .cart-product {
        display: flex;
        align-items: center;
    }

    .cart-product img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 12px;
        border: 1px solid #ddd;
    }

    .cart-product a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .cart-product a:hover {
        text-decoration: underline;
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
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-remove:hover {
        text-decoration: underline;
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

    /* Responsive */
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
    <h1 class="cart-title">Giỏ Hàng</h1>

    @if(session('cart') && count(session('cart')) > 0)
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPrice = 0; @endphp
                @foreach(session('cart') as $productId => $item)
                    <tr>
                        <td>
                            <div class="cart-product">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                <a href="{{ route('product.detail', $productId) }}">{{ $item['name'] }}</a>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $productId }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       style="width: 60px; text-align: center; padding: 4px;">
                                <button type="submit" class="btn-update">Cập nhật</button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                        <td>
                            @php
                                $totalPriceItem = $item['price'] * $item['quantity'];
                                $totalPrice += $totalPriceItem;
                            @endphp
                            {{ number_format($totalPriceItem, 0, ',', '.') }} đ
                        </td>
                        <td>
                            <a href="{{ route('cart.remove', $productId) }}" class="btn-remove">Xoá</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-actions">
            <p class="cart-total">Tổng cộng: {{ number_format($totalPrice, 0, ',', '.') }} đ</p>
            <a href="{{ route('checkout') }}" class="btn-checkout">Tiến hành thanh toán</a>
        </div>
    @else
        <p class="cart-empty">Giỏ hàng của bạn đang trống.</p>
    @endif
</div>
@endsection
