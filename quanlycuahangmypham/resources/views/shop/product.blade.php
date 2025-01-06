@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Sản Phẩm</h1>

    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                @if(!empty($sanpham->anhsanpham))
                    <img src="{{ asset('uploads/sanpham/' . $sanpham->anhsanpham) }}" class="img-fluid rounded-start" alt="{{ $sanpham->tensanpham }}">
                @else
                    <img src="{{ asset('uploads/sanpham/default.jpg') }}" class="img-fluid rounded-start" alt="Default Image">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $sanpham->tensanpham }}</h5>
                    <p class="card-text"><strong>Đơn Vị Tính:</strong> {{ $sanpham->donvitinh }}</p>
                    <p class="card-text"><strong>Đơn Giá:</strong> {{ number_format($sanpham->dongia, 0, ',', '.') }} VND</p>
                    <p class="card-text"><strong>Số Lượng Còn Lại:</strong> {{ $sanpham->soluongton }}</p>
                    <!-- Thêm mô tả sản phẩm nếu có -->
                    @if(!empty($sanpham->mota))
                        <p class="card-text"><strong>Mô Tả:</strong> {{ $sanpham->mota }}</p>
                    @endif
                    <!-- Thanh chọn số lượng -->
                    <form action="{{ route('shop.cart.add', $sanpham->masanpham) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group mb-3" style="max-width: 200px;">
                            <button class="btn btn-outline-secondary" type="button" id="button-minus">-</button>
                            <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $sanpham->soluongton }}">
                            <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Thêm Vào Giỏ Hàng</button>
                    </form>
                    <!-- Nút Quay Lại -->
                    <a href="{{ route('shop.index') }}" class="btn btn-secondary mt-2 w-100">Quay Lại</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm script JavaScript để xử lý nút + và - -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttonMinus = document.getElementById('button-minus');
        const buttonPlus = document.getElementById('button-plus');
        const quantityInput = document.getElementById('quantity');
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));

        buttonMinus.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        buttonPlus.addEventListener('click', function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        });
    });
</script>
@endsection
