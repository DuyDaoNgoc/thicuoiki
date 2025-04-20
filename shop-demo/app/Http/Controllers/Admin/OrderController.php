<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Sử dụng model Order
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng.
     */
    public function index()
    {
        // Lấy tất cả đơn hàng và kèm theo dữ liệu người dùng liên quan
        $orders = Order::with('user')->latest()->get();

        // Kiểm tra xem có đơn hàng không
        if ($orders->isEmpty()) {
            // Trả về thông báo nếu không có đơn hàng
            return view('orders.index', ['orders' => [], 'message' => 'Không có đơn hàng nào.']);
        }

        // Truyền $orders vào view
        return view('orders.index', compact('orders'));
    }

    /**
     * Cập nhật trạng thái đơn hàng.
     */
    public function updateStatus($id, Request $request)
    {
        // Tìm đơn hàng theo ID
        $order = Order::findOrFail($id);

        // Validate trạng thái mới
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled', // trạng thái hợp lệ
        ]);

        // Cập nhật trạng thái
        $order->update([
            'status' => $request->status,
        ]);

        // Trả về thông báo thành công
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * Xem chi tiết đơn hàng.
     */
    public function show($id)
    {
        // Lấy chi tiết đơn hàng theo ID
        $order = Order::with('user')->findOrFail($id);

        // Trả về view chi tiết đơn hàng
        return view('orders.show', compact('order'));
    }

    /**
     * Xóa đơn hàng.
     */
    public function destroy($id)
    {
        // Xóa đơn hàng theo ID
        $order = Order::findOrFail($id);
        $order->delete();

        // Trả về thông báo thành công
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa!');
    }
}