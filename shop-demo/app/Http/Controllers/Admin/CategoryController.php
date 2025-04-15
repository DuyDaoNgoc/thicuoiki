<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các danh mục.
     */
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả các category từ cơ sở dữ liệu
        return view('admin.categories.index', compact('categories')); // Trả về view danh sách category
    }

    /**
     * Hiển thị form tạo mới danh mục.
     */
    public function create()
    {
        return view('admin.categories.create'); // Hiển thị form tạo mới category
    }

    /**
     * Lưu danh mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories', // Kiểm tra tính duy nhất của slug
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Hiển thị chi tiết một danh mục.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        return view('admin.categories.show', compact('category')); // Trả về view chi tiết category
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        return view('admin.categories.edit', compact('category')); // Hiển thị form chỉnh sửa
    }

    /**
     * Cập nhật thông tin danh mục.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id, // Kiểm tra tính duy nhất của slug
        ], [
            'name.required' => 'Tên danh mục là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
        ]);

        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    /**
     * Xóa danh mục khỏi cơ sở dữ liệu.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id); // Tìm danh mục theo ID

        // Kiểm tra xem danh mục có sản phẩm nào hay không
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                             ->with('error', 'Không thể xóa danh mục vì có sản phẩm thuộc danh mục này.');
        }

        $category->delete(); // Xóa danh mục

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã bị xóa!');
    }
}