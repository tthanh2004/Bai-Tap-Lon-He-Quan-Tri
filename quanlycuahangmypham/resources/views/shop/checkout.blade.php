@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
<div class="container">
    <h1 class="mb-4">Thanh Toán</h1>

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
                    <tr>
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
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng Tiền:</strong></td>
                    <td><strong>{{ number_format($total, 0, ',', '.') }} VND</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Form Thông Tin Thanh Toán -->
        <form action="{{ route('shop.checkout.process') }}" method="POST">
            @csrf
            <h3>Thông Tin Thanh Toán</h3>
            <div class="mb-3">
                <label for="address" class="form-label">Địa Chỉ Giao Hàng</label>
                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>
            <!-- Bạn có thể thêm các trường thông tin khác như số điện thoại, phương thức thanh toán,... -->
            <button type="submit" class="btn btn-success">Hoàn Thành Đặt Hàng</button>
        </form>
    @else
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống.
        </div>
    @endif
</div>
@endsection
