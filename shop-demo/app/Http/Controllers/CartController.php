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
    
        // Kiểm tra giỏ hàng và tính tổng giá trị
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

        // Tìm sản phẩm trong database
        $product = Product::findOrFail($productId);

        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm đã có trong giỏ chưa, nếu có thì tăng số lượng
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
    
        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }
    
        // Cập nhật lại giỏ hàng trong session
        session()->put('cart', $cart);
    
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
    }
    

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm tồn tại trong giỏ và xoá
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xoá khỏi giỏ hàng.');
    }

    public function buyNow(Request $request)
    {
        // Chức năng “mua ngay” - chuyển giỏ hàng thành 1 sản phẩm duy nhất
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        // Tìm sản phẩm
        $product = Product::findOrFail($productId);

        // Tạo giỏ hàng chỉ với sản phẩm đã chọn
        $cart = [
            $productId => [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
            ]
        ];

        // Lưu giỏ hàng vào session và chuyển đến trang thanh toán
        session()->put('cart', $cart);

        return redirect()->route('checkout')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng và bạn sẽ được chuyển đến thanh toán.');
    }
}