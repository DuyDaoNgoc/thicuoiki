<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $user = Auth::user();
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = 0;

        // Xử lý mã giảm giá
        if ($request->filled('coupon_code') && $request->coupon_code === 'GIAM10') {
            $discount = $total * 0.1;
        }

        $finalTotal = $total - $discount;
        $dateBuy = Carbon::now();
        $dateShip = Carbon::now()->addDays(3);

        // Tính toán tỉ lệ chiết khấu cho từng món hàng
        $discountRate = $total > 0 ? $discount / $total : 0;

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $itemDiscount = $itemTotal * $discountRate;
            $itemFinal = $itemTotal - $itemDiscount;

            Order::create([
                'product_id' => $item['id'] ?? null,
                'ten_san_pham' => $item['name'],
                'hinh_anh' => $item['image'] ?? null,
                'size' => $item['size'] ?? 'M',
                'tong_tien' => $itemFinal,
                'ngay_mua' => $dateBuy,
                'ngay_giao' => $dateShip,
                'user_id' => $user?->id,
                'nguoi_dat' => $request->name,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.index')
            ->with('success', 'Đặt hàng thành công! Tổng tiền: ' . number_format($finalTotal, 0, ',', '.') . 'đ');
    }
}   