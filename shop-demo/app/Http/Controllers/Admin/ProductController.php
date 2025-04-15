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

    public function manageAo()
    {
        return $this->getProductsByCategorySlug('ao', 'admin.products.manage.ao');
    }

    public function manageQuan()
    {
        return $this->getProductsByCategorySlug('quan', 'admin.products.manage.quan');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateProduct($request);

        if ($request->hasFile('image')) {
            $data['image'] = $this->handleImageUpload($request->file('image'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->back()->with('success', 'Xoá sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể xoá sản phẩm. Vui lòng thử lại!');
        }
    }

    public function show(Product $product, Request $request)
    {
        $backUrl = url()->previous();
        return view('admin.products.show', compact('product', 'backUrl'));
    }

    // ========================
    // Private helper functions
    // ========================

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