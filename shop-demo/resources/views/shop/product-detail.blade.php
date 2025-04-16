@extends('layouts.app')

@section('content')
<style>.product-container {
    display: flex;
    gap: 40px;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    align-items: stretch;
}

.product-image {
    flex: 1;
    max-width: 100%;
    height: auto;
    max-height: 411px;
    object-fit: cover;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.product-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 20px 0;
}

.product-name {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.product-price {
    font-size: 1.4rem;
    color: #e91e63;
    margin-bottom: 20px;
}

.product-description {
    font-size: 1rem;
    color: #555;
    margin-bottom: 25px;
}

.form-inline {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: auto;
}

.form-inline select,
.form-inline input[type="number"] {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 100%;
    max-width: 300px;
}

.form-inline button {
    padding: 10px 20px;
    background-color: #4caf50;
    border: none;
    color: #fff;
    font-size: 1rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    width: fit-content;
}

.form-inline button:hover {
    background-color: #388e3c;
}

.form-inline button[name="buy_now"] {
    background-color: #ff5722;
}

.form-inline button[name="buy_now"]:hover {
    background-color: #e64a19;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin: 20px auto 10px 50px;
    padding: 10px 18px;
    background-color: #f0f0f0;
    color: #333;
    text-decoration: none;
    border-radius: 10px;
    font-size: 1rem;
    box-shadow: 2px 2px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.back-btn:hover {
    background-color: #ccc;
    transform: translateY(-2px);
}
@media (max-width: 768px) {
    .product-container {
        flex-direction: column;
        align-items: center;
    }

    .product-image {
        max-width: 100%;
        max-height: none;
    }

    .product-details {
        width: 100%;
        padding: 0;
    }
}


</style>

<a href="{{ url()->previous() }}" class="back-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.498.498 0 0 1-.106-.168.498.498 0 0 1 0-.378.498.498 0 0 1 .106-.168l4-4a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
    </svg>
    Trở về
</a>

<div class="product-container">
    <img src="{{ $product->image ? asset($product->image) : asset('images/no-image.png') }}" 
     class="product-image"
    alt="{{ $product->name }}">

    <div class="product-details">
        <div class="product-name">{{ $product->name }}</div>
        <div class="product-price">{{ number_format($product->price, 0, ',', '.') }}₫</div>
        <div class="product-description">{{ $product->description }}</div>

        <form action="{{ route('cart.add') }}" method="POST" class="form-inline">
            @csrf
          
            <input type="hidden" name="product_id" value="{{ $product->id }}">
 <div>
            
            <!-- Chọn size -->
            <select name="size" required>
                <option value="">Chọn size</option>
                <option value="S">Size S</option>
                <option value="M">Size M</option>
                <option value="L">Size L</option>
                <option value="XL">Size XL</option>
            </select>

            <!-- Số lượng -->
            <input type="number" name="quantity" value="1" min="1">
           </div>
<div>
         <button type="submit">Thêm vào giỏ</button>

            <!-- Nút mua -->
            <button type="submit" name="buy_now" value="1">Mua ngay</button>
</div>
            <!-- Nút thêm -->
       
        </form>
    </div>
</div>
@endsection
