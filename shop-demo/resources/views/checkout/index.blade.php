<!-- resources/views/checkout/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thanh toán</h1>
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <!-- Trường thông tin người mua -->
        <div>
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>
        </div>

        <button type="submit">Xác nhận thanh toán</button>
    </form>
</div>
@endsection
