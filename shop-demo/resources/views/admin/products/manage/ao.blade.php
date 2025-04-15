@extends('layouts.app')

@section('content')
    <h1>Quản lý sản phẩm Áo</h1>

    @if($products->isEmpty())
        <p>Không có sản phẩm nào trong danh mục Áo.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price) }} VND</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}">Sửa</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
