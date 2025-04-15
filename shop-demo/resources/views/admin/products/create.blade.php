@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Thêm sản phẩm</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
                <textarea id="description" name="description" class="mt-1 block w-full" required></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Giá sản phẩm</label>
                <input type="number" id="price" name="price" class="mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Ảnh sản phẩm</label>
                <input type="file" id="image" name="image" class="mt-1 block w-full" required>
            </div>

            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Thêm sản phẩm</button>
        </form>
    </div>
@endsection
