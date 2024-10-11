<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Khách Hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        <style>
    body {
        background-color: #f8f9fa; /* Màu nền nhẹ cho trang */
    }

    .container {
        background-color: #ffffff; /* Màu nền trắng cho container */
        border-radius: 8px; /* Bo góc cho container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
        padding: 20px; /* Khoảng cách bên trong container */
    }

    h1, h3 {
        color: #343a40; /* Màu chữ tối cho tiêu đề */
        margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
    }

    .product-image {
        width: 100%; /* Đảm bảo ảnh sẽ chiếm toàn bộ chiều rộng của thẻ cha */
        height: 250px; /* Đặt chiều cao cố định cho ảnh */
        object-fit: cover; /* Cắt hoặc thu nhỏ ảnh để phù hợp với khung */
        border-radius: 8px 8px 0 0; /* Bo góc trên cho ảnh */
    }

    .card {
        border: none; /* Không viền cho card */
        transition: transform 0.3s; /* Hiệu ứng chuyển động khi hover */
    }

    .card:hover {
        transform: scale(1.05); /* Tăng kích thước card khi hover */
    }

    .btn-primary {
        background-color: #007bff; /* Màu nền cho nút */
        border: none; /* Không viền cho nút */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Màu nền khi hover */
    }
</style>

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Chào Mừng Đến Với Trang Dashboard Khách Hàng</h1>
        <p class="text-center">Tại đây, bạn có thể xem sản phẩm và quản lý giỏ hàng của mình.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mb-4">Xem Tất Cả Sản Phẩm</a>
        <h3>Sản Phẩm</h3>
        <div class="row mt-5">

            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top product-image" alt="Image of {{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p><strong>Giá:</strong> {{ number_format($product->price) }} VND</p>
                            <p><strong>Số lượng:</strong> {{ $product->quantity }}</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Thêm vào Giỏ Hàng</button>
                            </form>
                            {{-- <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Xem Chi Tiết</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
