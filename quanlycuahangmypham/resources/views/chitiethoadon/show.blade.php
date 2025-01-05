@extends('layouts.app')

@section('title', 'Chi Tiết Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Chi Tiết Hóa Đơn</h1>

    <div class="card">
        <div class="card-header">
            Mã Hóa Đơn: {{ $chitiethoadon->idhoadon }}
        </div>
        <div class="card-body">
            <p><strong>Sản Phẩm:</strong> {{ $chitiethoadon->sanpham->tensanpham ?? 'N/A' }}</p>
            <p><strong>Số Lượng Mua:</strong> {{ $chitiethoadon->soluongmua }}</p>
            <p><strong>Giảm Giá:</strong> {{ $chitiethoadon->giamgia ?? '0' }}%</p>
            <p><strong>Thành Tiền:</strong> {{ number_format($chitiethoadon->thanhtien, 0, ',', '.') }} VND</p>
        </div>
    </div>

    <a href="{{ route('chitiethoadon.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
