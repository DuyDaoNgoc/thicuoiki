<!-- resources/views/admin/products/manage/default.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý {{ $category->name }}</title>
</head>
<body>
    <h1>Danh sách sản phẩm thuộc loại: {{ $category->name }}</h1>

    @if($products->count())
        <ul>
            @foreach($products as $product)
                <li>{{ $product->name }} - {{ number_format($product->price) }}₫</li>
            @endforeach
        </ul>
    @else
        <p>Chưa có sản phẩm nào trong danh mục này.</p>
    @endif
</body>
</html>
