<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        // Tính tổng giá trị giỏ hàng
        foreach ($cart as $productId => $item) {
            if (isset($item['id'])) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
        }

        return view('cart.index', compact('cart', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id, // thêm id vào để dùng ở view
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    public function buyNow(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        $product = Product::findOrFail($productId);

        $cart = [
            $productId => [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
            ]
        ];

        session()->put('cart', $cart);

        return redirect()->route('checkout')->with('success', 'Bạn đang mua ngay sản phẩm và sẽ được chuyển đến trang thanh toán.');
    }
}