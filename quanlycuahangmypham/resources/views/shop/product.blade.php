@extends('layouts.app')

@section('title', 'Chi Tiết Sản Phẩm')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $sanpham->tensanpham }}</h1>

    <div class="row">
        <div class="col-md-6">
            @if(!empty($sanpham->anhsanpham))
                <img src="{{ asset('uploads/sanpham/' . $sanpham->anhsanpham) }}" alt="{{ $sanpham->tensanpham }}" class="img-fluid">
            @else
                <img src="{{ asset('uploads/sanpham/default.jpg') }}" alt="Default Image" class="img-fluid">
            @endif
        </div>
        <div class="col-md-6">
            <h3>{{ number_format($sanpham->dongia, 0, ',', '.') }} VND</h3>
            <p><strong>Hãng:</strong> {{ $sanpham->hang->tenhang ?? 'N/A' }}</p>
            <p><strong>Đơn Vị Tính:</strong> {{ $sanpham->donvitinh }}</p>
            <p><strong>Số Lượng Tồn:</strong> {{ $sanpham->soluongton }}</p>

            @auth
                @if($sanpham->soluongton > 0)
                    <form action="{{ route('shop.cart.add', $sanpham->masanpham) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số Lượng</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $sanpham->soluongton }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Thêm Vào Giỏ Hàng</button>
                    </form>
                @else
                    <div class="alert alert-warning mt-3">
                        Sản phẩm hiện không còn hàng.
                    </div>
                @endif
            @else
                <div class="alert alert-info mt-3">
                    <a href="{{ route('login') }}">Đăng nhập</a> để thêm sản phẩm vào giỏ hàng.
                </div>
                <!-- Thêm thông báo -->
                <div id="alertMessage" class="mt-3"></div>
            @endauth
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToCartForm = document.getElementById('addToCartForm');
        const alertMessage = document.getElementById('alertMessage');

        if(addToCartForm){
            addToCartForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(addToCartForm);
                const url = addToCartForm.getAttribute('action');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success){
                        alertMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        // Cập nhật giỏ hàng nếu cần (ví dụ: cập nhật số lượng sản phẩm trong navbar)
                    } else {
                        alertMessage.innerHTML = `<div class="alert alert-danger">Có lỗi xảy ra.</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alertMessage.innerHTML = `<div class="alert alert-danger">Có lỗi xảy ra.</div>`;
                });
            });
        }
    });
</script>
@endsection
