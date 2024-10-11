<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); // Thêm middleware cho tất cả các phương thức
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all(); // Lấy toàn bộ danh mục
        return view('admin.categories.index', compact('categories')); // Trả về view danh sách danh mục
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create'); // Trả về view tạo danh mục
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|max:255',
            // 'description' => 'nullable|string',
        ]);

        Category::create($request->all()); // Lưu danh mục mới
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $category = Category::findOrFail($id); // Tìm danh mục theo ID
        return view('admin.categories.edit', compact('category')); // Trả về view sửa danh mục
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
        //
        $request->validate([
            'name' => 'required|max:255',
            // 'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all()); // Cập nhật danh mục
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete(); // Xóa danh mục
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
    }
}
