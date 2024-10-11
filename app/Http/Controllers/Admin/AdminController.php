<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Sử dụng middleware để phân quyền chỉ cho phép admin truy cập.
     */
    public function __construct()
    {
        $this->middleware('admin'); // Middleware này sẽ kiểm tra nếu người dùng có role là admin
    }

    /**
     * Trang quản trị chính cho Admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard'); // Trả về view admin/dashboard.blade.php
    }

    /**
     * Quản lý danh mục sản phẩm.
     */
    public function manageCategories()
    {
        // Thêm logic xử lý cho quản lý danh mục
        return view('categories.index'); // Trả về view admin/categories/index.blade.php
    }

    /**
     * Quản lý sản phẩm.
     */
    public function manageProducts()
    {
        // Thêm logic xử lý cho quản lý sản phẩm
        return view('products.index'); // Trả về view admin/products/index.blade.php
    }

    /**
     * Quản lý người dùng.
     */
    public function manageUsers()
    {
        // Thêm logic xử lý cho quản lý người dùng
        return view('users.index'); // Trả về view admin/users/index.blade.php
    }
}

