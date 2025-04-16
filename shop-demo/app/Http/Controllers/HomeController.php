<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Advertisement;

class HomeController extends Controller
{
    // Trang chủ
    public function index()
    {
        $products = Product::latest()->take(8)->get();
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();
        $categories = Category::all();

        // Thêm: quảng cáo còn hiệu lực
        $advertisements = Advertisement::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('home', compact('products', 'featuredProducts', 'categories', 'advertisements'));
    }

    // Trang chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.product-detail', compact('product'));
    }

    // Danh sách sản phẩm theo danh mục
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        return view('shop.category', compact('category', 'products'));
    }

    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $products = Product::where('name', 'like', "%$keyword%")->get();
        return view('shop.search', compact('products', 'keyword'));
    }

    // Danh sách tất cả sản phẩm
    public function allProducts()
    {
        $products = Product::paginate(12); // hoặc ->get() nếu không cần phân trang
        return view('shop.products', compact('products'));
    }
}