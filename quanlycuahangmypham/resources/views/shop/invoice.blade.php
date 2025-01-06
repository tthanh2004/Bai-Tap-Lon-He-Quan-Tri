@extends('layouts.app')

@section('title', 'Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Hóa Đơn</h1>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Mã Hóa Đơn:</strong> {{ $hoadon->mahoadon }}
        </div>
        <div class="card-body">
            <p><strong>Khách Hàng:</strong> {{ $hoadon->khachhang->hotenkh }}</p>
            <p><strong>Nhân Viên:</strong> {{ $hoadon->nhanvien->hoten }}</p>
            <p><strong>Địa Chỉ Giao Hàng:</strong> {{ $request->address ?? 'Không có thông tin' }}</p>
            <p><strong>Ngày Lập Hóa Đơn:</strong> {{ $hoadon->ngaylaphoadon->format('d/m/Y H:i') }}</p>
            <p><strong>Sử Dụng Thẻ Tích Điểm:</strong> {{ $hoadon->sudungTTD ? 'Có' : 'Không' }}</p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ảnh Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Đơn Giá</th>
                <th>Số Lượng</th>
                <th>Giảm Giá (%)</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoadon->chitiethoadon as $ct)
                <tr>
                    <td>
                        @if(!empty($ct->sanpham->anhsanpham))
                            <img src="{{ asset('uploads/sanpham/' . $ct->sanpham->anhsanpham) }}" alt="{{ $ct->sanpham->tensanpham }}" width="50">
                        @else
                            <img src="{{ asset('uploads/sanpham/default.jpg') }}" alt="Default Image" width="50">
                        @endif
                    </td>
                    <td>{{ $ct->sanpham->tensanpham }}</td>
                    <td>{{ number_format($ct->sanpham->dongia, 0, ',', '.') }} VND</td>
                    <td>{{ $ct->soluongmua }}</td>
                    <td>{{ $ct->giamgia }}%</td>
                    <td>{{ number_format($ct->thanhtien, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-end"><strong>Tổng Tiền:</strong></td>
                <td><strong>{{ number_format($hoadon->tongtien, 0, ',', '.') }} VND</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- (Tùy chọn) Nút tải xuống PDF -->
    <a href="{{ route('shop.invoice.pdf', ['mahoadon' => $hoadon->mahoadon]) }}" class="btn btn-primary">Tải Xuống PDF</a>
</div>
@endsection
