<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CustomerController extends Controller
{

    public function index(){
        $products = Product::all();

        // Truyền dữ liệu sản phẩm sang view dashboard
        return view('custom.dashboard', compact('products'));
 }
//     public function dashboard()
// {
//     // Lấy danh sách tất cả sản phẩm từ database

// }

}
