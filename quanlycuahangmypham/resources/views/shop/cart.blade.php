@extends('layouts.app')

@section('title', 'Giỏ Hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Giỏ Hàng Của Bạn</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($cart)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Đơn Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $item)
                    @php
                        $total += $item['sanpham']->dongia * $item['quantity'];
                    @endphp
                    <tr id="sanpham-{{ $item['sanpham']->masanpham }}">
                        <td>
                            @if(!empty($item['sanpham']->anhsanpham))
                                <img src="{{ asset('uploads/sanpham/' . $item['sanpham']->anhsanpham) }}" alt="{{ $item['sanpham']->tensanpham }}" width="50">
                            @else
                                <img src="{{ asset('uploads/sanpham/default.jpg') }}" alt="Default Image" width="50">
                            @endif
                        </td>
                        <td>{{ $item['sanpham']->tensanpham }}</td>
                        <td>{{ number_format($item['sanpham']->dongia, 0, ',', '.') }} VND</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['sanpham']->dongia * $item['quantity'], 0, ',', '.') }} VND</td>
                        <td>
                            <form action="{{ route('shop.cart.remove', $item['sanpham']->masanpham) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn loại bỏ sản phẩm này khỏi giỏ hàng?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng Tiền:</strong></td>
                    <td colspan="2"><strong>{{ number_format($total, 0, ',', '.') }} VND</strong></td>
                </tr>
            </tbody>
        </table>

        @auth
            <a href="{{ route('shop.checkout') }}" class="btn btn-primary">Thanh Toán</a>
        @else
            <div class="alert alert-info">
                <a href="{{ route('login') }}">Đăng nhập</a> để tiến hành thanh toán.
            </div>
        @endauth
    @else
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống.
        </div>
    @endif
</div>
@endsection
