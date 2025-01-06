@extends('layouts.app')

@section('title', 'Cửa Hàng Sản Phẩm')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Cửa Hàng Sản Phẩm</h1>

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <!-- Thông Báo -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Danh Sách Sản Phẩm -->
    @if($sanpham->count())
        <div class="row">
            @foreach($sanpham as $sp)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="product-image-wrapper position-relative overflow-hidden">
                            <a href="{{ route('shop.product.show', $sp->masanpham) }}">
                                <img src="{{ !empty($sp->anhsanpham) ? asset('uploads/sanpham/' . $sp->anhsanpham) : asset('uploads/sanpham/default.jpg') }}" 
                                     class="card-img-top product-image" 
                                     alt="{{ $sp->tensanpham }}" 
                                     style="height: 200px; object-fit: cover;">
                            </a>
                            <!-- Overlay -->
                            <div class="overlay d-flex flex-column justify-content-center align-items-center">
                                <a href="{{ route('shop.product.show', $sp->masanpham) }}" class="btn btn-primary mb-2">Xem Chi Tiết</a>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $sp->tensanpham }}</h5>
                            <p class="card-text"><strong>Số Lượng Còn Lại:</strong> {{ $sp->soluongton }} {{ $sp->donvitinh }}</p>
                            <p class="card-text"><strong>{{ number_format($sp->dongia, 0, ',', '.') }} VND</strong></p>
                            <div class="mt-auto">
                                <form action="{{ route('shop.cart.add', $sp->masanpham) }}" method="POST" class="mt-3">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary btn-decrement" type="button">-</button>
                                        <input type="number" name="quantity" class="form-control text-center quantity-input" value="1" min="1" max="{{ $sp->soluongton }}">
                                        <button class="btn btn-outline-secondary btn-increment" type="button">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Thêm Vào Giỏ Hàng</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Phân Trang -->
        {!! $sanpham->withQueryString()->links('pagination::bootstrap-5') !!}

    @else
        <div class="alert alert-info text-center">
            Không tìm thấy sản phẩm nào.
        </div>
    @endif
</div>

<!-- Thêm script JavaScript để xử lý nút + và - -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy tất cả các cặp nút và input
        const decrementButtons = document.querySelectorAll('.btn-decrement');
        const incrementButtons = document.querySelectorAll('.btn-increment');
        const quantityInputs = document.querySelectorAll('.quantity-input');

        decrementButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                let input = quantityInputs[index];
                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
        });

        incrementButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                let input = quantityInputs[index];
                let currentValue = parseInt(input.value);
                let max = parseInt(input.getAttribute('max'));
                if (currentValue < max) {
                    input.value = currentValue + 1;
                }
            });
        });
    });
</script>

<!-- Thêm CSS cho hiệu ứng hover -->
<style>
    .product-image-wrapper {
        position: relative;
    }

    .product-image {
        transition: transform 0.3s ease;
    }

    .product-image-wrapper:hover .product-image {
        transform: scale(1.05);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .product-image-wrapper:hover .overlay {
        opacity: 1;
    }

    .overlay .btn {
        margin: 5px 0;
    }

    /* Thêm hiệu ứng cho card */
    .card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        transition: box-shadow 0.3s ease;
    }

    /* Tùy chỉnh thanh phân trang */
    .pagination {
        justify-content: center;
    }

    /* Tối ưu hóa responsive */
    @media (max-width: 768px) {
        .product-image-wrapper:hover .product-image {
            transform: scale(1);
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.8);
        }
    }
</style>
@endsection
