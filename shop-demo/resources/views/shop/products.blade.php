@extends('layouts.app')

@section('content')
<div class="category-nav">
    <button class="category-button" onclick="loadProducts('ao')">Áo</button>
    <button class="category-button" onclick="loadProducts('quan')">Quần</button>
</div>

<div id="product-list">
    @foreach($products as $product)
        <div class="product-card">
            <div class="product-image">
                <img src="{{ $product->image ? asset($product->image) : asset('images/no-image.png') }}" 
                class="card-img-top" 
                alt="{{ $product->name }}">
            </div>
            <h2 class="product-title">
                <a href="{{ route('product.show', $product->id) }}" class="product-link">
                    {{ $product->name }}
                </a>
            </h2>
            <p class="product-price">{{ number_format($product->price, 0, ',', '.') }} đ</p>

            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="add-to-cart-button">Thêm vào giỏ hàng</button>
            </form>
        </div>
    @endforeach
</div>
<script>
    function loadProducts(category) {
        // Gửi yêu cầu AJAX để tải sản phẩm theo danh mục
        fetch(`/products/${category}`)
            .then(response => response.json())
            .then(data => {
                // Cập nhật lại danh sách sản phẩm
                let productList = document.getElementById('product-list');
                productList.innerHTML = '';

                if (data.products.length > 0) {
                    data.products.forEach(product => {
                        let productCard = `
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="${product.image ? '/images/' + product.image : '/images/no-image.png'}" class="card-img-top" alt="${product.name}">
                                </div>
                                <h2 class="product-title">
                                    <a href="/product/${product.id}" class="product-link">${product.name}</a>
                                </h2>
                                <p class="product-price">${product.price} đ</p>
                                <form action="/cart/add" method="POST" class="add-to-cart-form">
                                    <input type="hidden" name="product_id" value="${product.id}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="add-to-cart-button">Thêm vào giỏ hàng</button>
                                </form>
                            </div>
                        `;
                        productList.innerHTML += productCard;
                    });
                } else {
                    productList.innerHTML = '<p>Không có sản phẩm nào.</p>';
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>

@endsection

<style>
    /* Container chung */
/* ===== Layout Container ===== */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* ===== Header ===== */
.shop-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.shop-header h1 {
    font-size: 2rem;
    font-weight: bold;
}

.shop-back-button {
    display: flex;
    align-items: center;
    color: #007bff;
    font-size: 1rem;
    text-decoration: none;
}

.shop-back-button .icon {
    width: 16px;
    height: 16px;
    margin-right: 8px;
}

/* ===== Category Navigation ===== */
.category-nav {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 30px;
}

.category-button {
    background-color: #f8f9fa;
    color: #333;
    border: 1px solid #ddd;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.category-button:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

/* ===== Product Grid ===== */
#product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}

/* ===== Product Card ===== */
.product-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    padding: 15px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
}

/* ===== Product Image ===== */
.product-image img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

/* ===== Product Title ===== */
.product-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 12px 0;
}

.product-link {
    text-decoration: none;
    color: #212529;
    transition: color 0.3s;
}

.product-link:hover {
    color: #007bff;
}

/* ===== Product Price ===== */
.product-price {
    font-size: 1rem;
    color: #666;
    margin-bottom: 20px;
}

/* ===== Add to Cart ===== */
.add-to-cart-form {
    display: flex;
    justify-content: center;
}

.add-to-cart-button {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.add-to-cart-button:hover {
    background-color: #218838;
}

/* ===== Pagination ===== */
.pagination {
    margin-top: 30px;
    text-align: center;
}

.pagination a {
    color: #007bff;
    text-decoration: none;
    margin: 0 5px;
    font-size: 1rem;
    transition: text-decoration 0.2s;
}

.pagination a:hover {
    text-decoration: underline;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .category-nav {
        flex-direction: column;
        align-items: center;
    }

    #product-list {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }

    .add-to-cart-button {
        width: 100%;
    }
}


</style>