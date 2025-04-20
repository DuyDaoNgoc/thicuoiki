@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <h1 class="title">Danh sách Sản Phẩm</h1>

        @if(session('success'))
            <div class="alert-success">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="add-product-btn-container">
            <a href="{{ route('admin.products.create') }}" class="btn add-product">+ Thêm sản phẩm</a>
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
                                        <span class="no-image">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 0, ',', '.') }}₫</td>
                                <td>{{ $product->stock ?? 'Không rõ' }}</td>
                                <td class="actions">
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn info">Chi tiết</a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn warning">Chỉnh sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-form">
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
            padding: 30px;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-warning {
            background-color: #fef3c7;
            color: #92400e;
            padding: 16px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            margin-top: 20px;
        }

        .add-product-btn-container {
            margin-bottom: 20px;
            text-align: right;
        }

        .btn.add-product {
            background-color: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn.add-product:hover {
            background-color: #1e40af;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .custom-table th, .custom-table td {
            padding: 12px 16px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .no-image {
            color: #6b7280;
            font-style: italic;
        }

        .actions .btn {
            display: inline-block;
            margin: 2px 4px;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn.info {
            background-color: #38bdf8;
            color: white;
        }

        .btn.warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn.danger {
            background-color: #ef4444;
            color: white;
            border: none;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .inline-form {
            display: inline;
        }
    </style>

