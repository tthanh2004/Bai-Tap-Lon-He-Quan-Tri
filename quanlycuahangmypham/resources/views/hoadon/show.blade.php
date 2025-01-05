@extends('layouts.app')

@section('title', 'Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Hóa Đơn</h1>

    <div class="card">
        <div class="card-header">
            Mã Hóa Đơn: {{ $hoadon->mahoadon }}
        </div>
        <div class="card-body">
            <p><strong>Khách Hàng:</strong> {{ $hoadon->khachhang->tenkhachhang ?? 'N/A' }}</p>
            <p><strong>Nhân Viên:</strong> {{ $hoadon->nhanvien->tennhanvien ?? 'N/A' }}</p>
            <p><strong>Ngày Lập Hóa Đơn:</strong> {{ $hoadon->ngaylaphoadon }}</p>
            <p><strong>Sử Dụng Thẻ Tích Điểm:</strong> {{ $hoadon->sudungTTD ? 'Có' : 'Không' }}</p>
            <p><strong>Tổng Tiền:</strong> {{ number_format($hoadon->tongtien, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <a href="{{ route('hoadon.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
