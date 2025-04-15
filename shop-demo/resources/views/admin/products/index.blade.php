@extends('layouts.app')

@section('title', 'Danh sách sản phẩm')
<style>
    /* Reset cơ bản */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Vùng chính */
.product-container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.product-heading {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
}

/* Thông báo */
.alert {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

/* Bảng sản phẩm */
.product-table {
    width: 100%;
    border-collapse: collapse;
}

.product-table th, .product-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.product-table th {
    background-color: #3498db;
    color: #fff;
}

.product-table tr:hover {
    background-color: #f5f5f5;
}

/* Hình ảnh sản phẩm */
.product-image {
    width: 80px;
    height: auto;
    border-radius: 5px;
}

/* Hành động */
.action-buttons a {
    padding: 8px 12px;
    margin-right: 6px;
    text-decoration: none;
    font-size: 0.9rem;
    color: white;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.btn-view {
    background-color: #2ecc71;
}

.btn-view:hover {
    background-color: #27ae60;
}

.btn-edit {
    background-color: #f39c12;
}

.btn-edit:hover {
    background-color: #e67e22;
}

/* Responsive */
@media (max-width: 768px) {
    .product-container {
        padding: 15px;
    }

    .product-heading {
        font-size: 1.5rem;
    }

    .product-table th, .product-table td {
        font-size: 0.9rem;
        padding: 10px;
    }

    .product-image {
        width: 60px;
    }
}

</style>
@section('content')
    <div class="product-container">
        <h1 class="product-heading">Danh sách sản phẩm</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="product-table">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price) }}đ</td>
                        <td>{{ $product->stock ?? 0 }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="Hình ảnh" class="product-image">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                        <td>{{ $product->category->name ?? 'Không rõ' }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn-view">Xem</a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">Sửa</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Không có sản phẩm nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/products.css') }}">
@endpush
