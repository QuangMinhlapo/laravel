@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh Mục: {{ $category->name }}</h1>
    <p>Mô tả: {{ $category->description }}</p>
    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Chỉnh Sửa</a>
    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Xóa</button>
    </form>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
