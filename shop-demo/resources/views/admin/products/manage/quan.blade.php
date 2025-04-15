@extends('layouts.app')

@section('content')
    <div class="custom-container">
        <h1 class="title">Quản lý sản phẩm loại Quần</h1>

        @if ($products->isEmpty())
            <div class="alert-warning">
                <p>Không có sản phẩm nào trong loại Quần.</p>
            </div>
        @else
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
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

@push('styles')
<style>
    .custom-container {
        max-width: 960px;
        margin: 40px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .title {
        text-align: center;
        margin-bottom: 20px;
    }

    .alert-warning {
        background-color: #fff3cd;
        color: #856404;
        padding: 15px;
        border-radius: 6px;
        text-align: center;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    .custom-table th, .custom-table td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: center;
    }

    .custom-table thead {
        background-color: #eee;
    }

    .actions {
        display: flex;
        gap: 8px;
        justify-content: center;
        align-items: center;
    }

    .btn {
        padding: 6px 12px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        cursor: pointer;
        display: inline-block;
    }

    .btn.info {
        background-color: #17a2b8;
        color: white;
    }

    .btn.warning {
        background-color: #ffc107;
        color: black;
    }

    .btn.danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .inline-form {
        display: inline;
    }

    .btn:hover {
        opacity: 0.85;
    }
</style>
@endpush
