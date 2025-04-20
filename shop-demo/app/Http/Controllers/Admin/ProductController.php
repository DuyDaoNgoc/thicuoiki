<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Lấy danh sách sản phẩm theo slug danh mục (dùng chung)
    protected function getProductsByCategorySlug($slug, $view)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return redirect()->route('admin.dashboard')->with('error', "Danh mục $slug không tồn tại.");
        }

        $products = Product::where('category_id', $category->id)->get();

        return view($view, compact('products'));
    }

    // Quản lý sản phẩm áo
    public function manageAo()
    {
        return $this->getProductsByCategorySlug('ao', 'admin.products.manage.ao');
    }

    // Quản lý sản phẩm quần
    public function manageQuan()
    {
        return $this->getProductsByCategorySlug('quan', 'admin.products.manage.quan');
    }

    // Hiển thị tất cả sản phẩm
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Hiển thị form tạo mới sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Lưu sản phẩm mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        // Xử lý tải ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        // Xử lý tải ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // Xoá sản phẩm
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->back()->with('success', 'Xoá sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xoá sản phẩm. Vui lòng thử lại!');
        }
    }

    // Hiển thị chi tiết sản phẩm cho admin
    public function showAdmin(Product $product, Request $request)
    {
        $backUrl = url()->previous();
        return view('admin.products.show', compact('product', 'backUrl'));
    }

    // Hiển thị chi tiết sản phẩm cho người dùng
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Đảm bảo đường dẫn view là đúng cho người dùng
        return view('shop.product-detail', compact('product'));
    }

    // Phương thức tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $products = Product::where('name', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->paginate(12);
        } else {
            $products = Product::paginate(12); // Nếu không có từ khóa, trả tất cả sản phẩm
        }

        return view('shop.search', compact('products', 'query'));
    }

    // Các hàm trợ giúp riêng tư
    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    }

    private function handleImageUpload($file)
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images'), $filename);
        return 'images/' . $filename;
    }
}