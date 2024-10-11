<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomController;
use App\Http\Controllers\OrderController;
/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Trang chính
Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [ProductController::class, 'dashboard'])->name('dashboard');
// Route cho đăng ký và đăng nhập
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Route cho sản phẩm
Route::resource('products', ProductController::class);

// Route cho danh mục
Route::resource('categories', CategoryController::class);

// Cấu hình middleware cho admin
Route::middleware(['admin'])->group(function () {
    // Các route chỉ dành cho admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Các route cho quản lý danh mục và sản phẩm chỉ dành cho admin
    Route::resource('admin/categories', CategoryController::class)->names('admin.categories');
    Route::resource('admin/products', ProductController::class)->names('admin.products');
});

 Route::get('/custom/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
// Route::get('/customer/dashboard', [CustomController::class, 'dashboard'])->name('customer.dashboard');


Route::get('users', [UserController::class, 'index'])->name('users.index');
//giỏ hang
Route::get('/cart', [CartController::class, 'index'])->name('custom.cart');
// Route thêm sản phẩm vào giỏ hàng
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// Route xóa sản phẩm khỏi giỏ hàng
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Route hiển thị giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/dashboard', [CustomController::class, 'dashboard'])->name('custom.dashboard');


// Route hiển thị dashboard
Route::get('/dashboard', [CustomerController::class, 'index'])->name('custom.dashboard');
//oder


// Hiển thị form đặt hàng
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

// Xử lý đơn hàng
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Hiển thị danh sách đơn hàng (nếu cần)
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

