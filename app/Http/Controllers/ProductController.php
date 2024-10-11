<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin'); // Thêm middleware cho tất cả các phương thức
    }
    public function index()
    {
        // Lấy tất cả sản phẩm từ cơ sở dữ liệu, kèm theo thông tin danh mục
        $products = Product::with('category')->get();
        // Trả về view hiển thị danh sách sản phẩm
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Lấy danh sách danh mục để hiển thị trong form tạo sản phẩm
        $categories = Category::all();
        // Trả về view hiển thị form tạo sản phẩm
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Chuẩn bị dữ liệu
        $data = $request->all();
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName; // Lưu đường dẫn hình ảnh
        }

        // Lưu sản phẩm
        Product::create($data);


        // Điều hướng về trang danh sách sản phẩm kèm thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Hiển thị thông tin chi tiết sản phẩm (có thể bổ sung nếu cần)
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Lấy sản phẩm theo ID và danh sách danh mục
        $product = Product::findOrFail($id);
        $categories = Category::all();

        // Trả về view hiển thị form chỉnh sửa sản phẩm
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ
            if ($product->image) {
                $oldImagePath = public_path('images/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName; // Cập nhật đường dẫn hình ảnh
        }

        $product->update($data);
        // Điều hướng về trang danh sách sản phẩm kèm thông báo thành công
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lấy sản phẩm theo ID và xóa khỏi cơ sở dữ liệu
        $product = Product::findOrFail($id);

        // Xóa hình ảnh nếu có
        if ($product->image) {
            $oldImagePath = public_path('images/' . $product->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        $product->delete();

        // Điều hướng về trang danh sách sản phẩm kèm thông báo thành công
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
