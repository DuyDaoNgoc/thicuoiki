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
        $products = Product::latest()->take(8)->get(); // Lấy 8 sản phẩm mới nhất
        $featuredProducts = Product::where('is_featured', true)->take(4)->get(); // Lấy 4 sản phẩm nổi bật
        $categories = Category::all(); // Lấy tất cả danh mục

        // Thêm: quảng cáo còn hiệu lực
        $advertisements = Advertisement::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('home', compact('products', 'featuredProducts', 'categories', 'advertisements'));
    }

    // Trang chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('shop.product-detail', compact('product'));
    }

    // Danh sách sản phẩm theo danh mục
    public function category($id)
    {
        $category = Category::findOrFail($id); // Lấy danh mục theo ID
        $products = Product::where('category_id', $id)->get(); // Lấy sản phẩm theo danh mục
        return view('shop.category', compact('category', 'products'));
    }

    // Tìm kiếm sản phẩm (dành cho cả người dùng và admin)
    // ShopController.php

public function search(Request $request)
{
    // Lấy từ khóa tìm kiếm
    $query = $request->input('query');
    
    // Tìm kiếm sản phẩm trong bảng products
    $products = Product::where('name', 'like', '%' . $query . '%')->get();
 
    // Trả về kết quả tìm kiếm với từ khóa
    return view('shop.search', compact('products', 'query'));
}
// HomeController.php

public function allProducts()
{
    $products = Product::all(); // hoặc where() theo nhu cầu
    return view('shop.products', compact('products'));
}


}