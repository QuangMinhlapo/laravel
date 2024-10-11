<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function create()
    {
        // Hiển thị giao diện đặt hàng
        return view('orders.create');
    }

    public function store(Request $request)
    {
        // Xử lý đặt hàng
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(), // Nếu có đăng nhập
            'total_price' => 0, // Cập nhật sau
            'status' => 'pending',
        ]);

        foreach ($request->products as $product) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product['id'];
            $orderItem->quantity = $product['quantity'];
            $orderItem->price = // Giá sản phẩm từ cơ sở dữ liệu
            $orderItem->save();
        }

        // Tính toán tổng giá trị đơn hàng
        $order->total_price = $order->orderItems()->sum('price');
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Đặt hàng thành công!');
    }
}

