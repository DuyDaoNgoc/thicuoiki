@extends('layouts.app')

@section('content')
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.2s;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #4CAF50;
            background: #f9fff9;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        .btn-secondary {
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            text-align: center;
            line-height: 38px;
        }

        .btn-secondary:hover {
            background-color: #bbb;
        }

        .image-preview {
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
    </style>

    <div class="form-container">
        <h1>Chỉnh sửa sản phẩm</h1>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group">
                <label for="stock">Tồn kho:</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}">
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục:</label>
                <select name="category_id" id="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="image">Ảnh sản phẩm mới:</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>

            @if ($product->image)
                <div class="form-group image-preview">
                    <label>Ảnh hiện tại:</label>
                    <img src="{{ asset($product->image) }}" alt="Hình ảnh" class="product-image">
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
@endsection
