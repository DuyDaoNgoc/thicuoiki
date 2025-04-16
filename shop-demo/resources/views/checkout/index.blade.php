@extends('layouts.app')

@section('content')
<style>
    .checkout-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: #fdfdfd;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .checkout-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 24px;
        color: #333;
        text-align: center;
    }

    .checkout-section {
        margin-bottom: 30px;
    }

    .checkout-form label {
        display: block;
        font-weight: 600;
        color: #555;
        margin-bottom: 6px;
    }

    .checkout-form input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }

    .checkout-form input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
    }

    .checkout-form button {
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .checkout-form button:hover {
        background-color: #218838;
    }

    .checkout-form div {
        margin-bottom: 18px;
    }

    .product-list {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #fafafa;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px dashed #ccc;
        padding: 10px 0;
        align-items: center;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-name {
        font-weight: 500;
    }

    .total-price {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 20px;
        }

        .checkout-form input {
            font-size: 14px;
        }

        .checkout-form button {
            width: 100%;
        }
    }
</style>

<div class="checkout-container">
    <h1 class="checkout-title">Thanh toán</h1>

    <!-- SẢN PHẨM SẼ THANH TOÁN -->
    <div class="checkout-section">
        <h3>Sản phẩm</h3>
        <div class="product-list">
            @foreach ($cart as $item)
            <div class="product-item">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" width="100px" height="100px" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

                    <div class="product-name">{{ $item['name'] }} x {{ $item['quantity'] }}</div>
                </div>
                <div>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</div>
            </div>
        @endforeach
        
        </div>
        <div class="total-price">
            Tạm tính: {{ number_format($total, 0, ',', '.') }} đ
        </div>
    </div>

    <!-- FORM NGƯỜI MUA -->
    <form class="checkout-form" action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div>
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <!-- MÃ GIẢM GIÁ -->
        <div>
            <label for="coupon">Mã giảm giá:</label>
            <input type="text" id="coupon" name="coupon_code" placeholder="Nhập mã (nếu có)">
        </div>

        <button type="submit">Xác nhận thanh toán</button>
    </form>
</div>
@endsection
