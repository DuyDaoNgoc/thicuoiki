<?php
// app/Http/Controllers/OrderTrackController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackController extends Controller
{
    public function index()
    {
        // Kiểm tra người dùng đã đăng nhập
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        // Lấy các đơn hàng của người dùng
        $orders = $user->orders ?? collect(); // Đảm bảo không bị null

        // Trả về view với đơn hàng và thông báo nếu cần
        return view('orders.index', [
            'orders' => $orders,
            'message' => $orders->isEmpty() ? 'No orders found.' : null,
        ]);
    }
}