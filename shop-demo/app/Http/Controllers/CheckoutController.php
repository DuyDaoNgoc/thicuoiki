<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'coupon_code' => 'nullable|string',
        ]);

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = 0;

        // Giảm giá
        if ($request->filled('coupon_code')) {
            if ($request->coupon_code === 'GIAM10') {
                $discount = $total * 0.1;
            }
        }

        $finalTotal = $total - $discount;

        // TODO: Lưu đơn hàng vào DB nếu cần

        // Xoá giỏ hàng
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công! Tổng tiền: ' . number_format($finalTotal, 0, ',', '.') . ' đ');
    }
}