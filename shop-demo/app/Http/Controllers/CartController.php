<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session('cart', []);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'totalPrice'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:10',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $size = $request->input('size', 'M'); // 👈 mặc định size M

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        $image = $product->image ?? 'default-product.jpg';

        // 👇 tạo key riêng biệt theo id + size
        $cartKey = $productId . '_' . $size;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $image,
                'size' => $size,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|string|max:10',
        ]);

        $productId = $request->input('product_id');
        $size = $request->input('size');
        $quantity = $request->input('quantity');

        $cartKey = $productId . '_' . $size;

        $cart = session()->get('cart', []);
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }

    // Xoá sản phẩm khỏi giỏ
    public function remove($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    // Mua ngay
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string|max:10',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $size = $request->input('size', 'M');

        $product = Product::findOrFail($productId);
        $image = $product->image ?? 'default-product.jpg';

        $cartKey = $productId . '_' . $size;

        $cart = [
            $cartKey => [
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $image,
                'size' => $size,
            ]
        ];

        session()->put('cart', $cart);

        return redirect()->route('checkout')->with('success', 'Mua ngay thành công. Vui lòng thanh toán.');
    }
}