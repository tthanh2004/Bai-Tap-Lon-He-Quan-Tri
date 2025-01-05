@extends('layouts.app')

@section('title', 'Chi Tiết Nhập Hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Nhập Hàng</h1>

    <div class="card">
        <div class="card-header">
            Mã Nhập Hàng: {{ $nhaphang->manhaphang }}
        </div>
        <div class="card-body">
            <p><strong>Sản Phẩm:</strong> {{ $nhaphang->sanpham->tensanpham ?? 'N/A' }}</p>
            <p><strong>Số Lượng Nhập:</strong> {{ $nhaphang->soluongnhap }}</p>
            <p><strong>Giá Nhập:</strong> {{ number_format($nhaphang->gianhap, 0, ',', '.') }} VND</p>
            <p><strong>Ngày Nhập:</strong> {{ $nhaphang->ngaynhap }}</p>
        </div>
    </div>

    <a href="{{ route('nhaphang.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
