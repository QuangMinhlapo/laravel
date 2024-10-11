<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class CartController extends Controller
{
    //
    public function add(Product $product)
    {
        // Kiểm tra xem sản phẩm có tồn tại trong cơ sở dữ liệu
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Sản phẩm không tồn tại.');
        }

        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        // Cập nhật giỏ hàng vào session
        session()->put('cart', $cart);

        // Thêm thông báo thành công
        session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng!');

        return redirect()->route('cart.index'); // Quay lại trang giỏ hàng
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = session()->get('cart');

        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm khỏi giỏ hàng
            session()->put('cart', $cart);

            // Thêm thông báo thành công
            session()->flash('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        } else {
            // Thêm thông báo lỗi nếu sản phẩm không có trong giỏ hàng
            session()->flash('error', 'Sản phẩm không có trong giỏ hàng!');
        }

        return redirect()->route('cart.index'); // Quay lại trang giỏ hàng
    }

    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        // Tính toán tổng tiền
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // Kiểm tra giỏ hàng có trống không
        if (empty($cart)) {
            return view('custom.cart')->with('message', 'Giỏ hàng của bạn đang trống.');
        }

        return view('custom.cart', compact('cart', 'totalPrice')); // Trả về view giỏ hàng
    }
}
