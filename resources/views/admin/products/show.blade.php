@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sản Phẩm: {{ $product->name }}</h1>
    <p>Mô tả: {{ $product->description }}</p>
    <p>Số lượng: {{ $product->quantity }}</p>
    <p>Giá: {{ $product->price }} VNĐ</p>
    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Chỉnh Sửa</a>
    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Xóa</button>
    </form>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
