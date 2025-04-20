@extends('layouts.app')

@section('content')
<div class="custom-container">
    <h1 class="title">Danh sách đơn hàng</h1>

    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @elseif (isset($message))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
    @elseif ($orders->isEmpty())
        <div class="alert alert-warning">
            <p>Không có đơn hàng nào.</p>
        </div>
    @else
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ngày tạo</th>
                        <th>Ảnh</th> {{-- Nếu có --}}
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Tổng tiền</th>
                        <th>Ngày mua</th>
                        <th>Ngày giao</th>
                        <th>Người đặt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                {{-- Nếu bạn đã lưu ảnh trong cột `hinh_anh`, thay bằng $order->hinh_anh --}}
                                <img src="{{ $order->hinh_anh ?? '/images/default.png' }}" alt="Ảnh" width="60">
                            </td>
                            <td>{{ $order->ten_san_pham }}</td>
                            <td>{{ $order->size }}</td>
                            <td>{{ number_format($order->tong_tien, 0, ',', '.') }}đ</td>
                            <td>{{ \Carbon\Carbon::parse($order->ngay_mua)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->ngay_giao)->format('d/m/Y') }}</td>
                            <td>{{ $order->nguoi_dat }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

<style>
.custom-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.alert-warning, .alert-success {
    padding: 20px;
    background: #fff3cd;
    color: #856404;
    border-radius: 8px;
    border: 1px solid #ffeeba;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}

.table-wrapper {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 15px;
    background-color: #fafafa;
}

.table th, .table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e0e0e0;
    text-align: left;
}

.table th {
    background-color: #f5f5f5;
    color: #333;
    font-weight: 600;
}

.table tr:hover {
    background-color: #f0f8ff;
}

.table td img {
    border-radius: 5px;
}
</style>
