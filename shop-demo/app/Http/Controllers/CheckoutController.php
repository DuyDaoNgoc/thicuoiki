<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Hiển thị trang thanh toán
        return view('checkout.index'); // đảm bảo view này tồn tại
    }

    public function process(Request $request)
    {
        // Xử lý đơn hàng tại đây
        // Bạn có thể xử lý thông tin người mua, giỏ hàng, tính tổng tiền, lưu đơn, gửi email,...
        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }
}