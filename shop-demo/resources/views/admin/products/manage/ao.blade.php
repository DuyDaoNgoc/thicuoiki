@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <h1 class="title">Quản lý sản phẩm loại Áo</h1>

        <!-- Nút Thêm Sản Phẩm -->
        <div class="add-product-btn-container">
            <a href="{{ route('admin.products.create') }}" class="btn add-product">Thêm sản phẩm</a>
        </div>

        @if ($products->isEmpty())
            <div class="alert-warning">
                <p>Không có sản phẩm nào trong loại Áo.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="Hình ảnh" class="product-image">
                                    @else
                                        Không có ảnh
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                <td>{{ $product->stock ?? 'Không rõ' }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn info">Chi tiết</a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn warning">Chỉnh sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-form" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

<style>
    .custom-container {
        max-width: 1280px;
        margin: 40px auto;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 24px;
        color: #1f2937;
    }

    .alert-warning {
        background-color: #fff8e1;
        color: #b45309;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }

    .add-product-btn-container {
        text-align: right;
        margin-bottom: 20px;
    }

    .btn.add-product {
        background-color: #10b981;
        color: #fff;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .btn.add-product:hover {
        background-color: #059669;
    }

    .table-wrapper {
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }

    .custom-table th, .custom-table td {
        border: 1px solid #e5e7eb;
        padding: 14px 12px;
        text-align: center;
        color: #374151;
        vertical-align: middle;
    }

    .custom-table thead {
        background-color: #f3f4f6;
        font-weight: 600;
    }

    .product-image {
        width: 60px;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    }

    .actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    .btn {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .btn.info {
        background-color: #3b82f6;
        color: #fff;
    }

    .btn.warning {
        background-color: #facc15;
        color: #1f2937;
    }

    .btn.danger {
        background-color: #ef4444;
        color: #fff;
        border: none;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .inline-form {
        display: inline;
        margin-bottom: 0;
    }
</style>
