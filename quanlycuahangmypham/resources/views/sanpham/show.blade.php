@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Sản Phẩm</h1>

    <div class="card">
        <div class="card-header">
            {{ $sanpham->tensanpham }}
        </div>
        <div class="card-body">
            <p><strong>Mã Sản Phẩm:</strong> {{ $sanpham->masanpham }}</p>
            <p><strong>Hãng:</strong> {{ $sanpham->hang->tenhang ?? 'N/A' }}</p>
            <p><strong>Đơn Vị Tính:</strong> {{ $sanpham->donvitinh }}</p>
            <p><strong>Đơn Giá:</strong> {{ number_format($sanpham->dongia, 0, ',', '.') }} VND</p>
            <p><strong>Số Lượng Tồn:</strong> {{ $sanpham->soluongton }}</p>
            <p><strong>Ngày Tạo:</strong> {{ $sanpham->created_at->format('d/m/Y') }}</p>
            <p><strong>Ảnh Sản Phẩm:</strong></p>
            @if($sanpham->anhsanpham)
                <img src="{{ asset('storage/uploads/sanpham/' . $sanpham->anhsanpham) }}" alt="{{ $sanpham->tensanpham }}" width="150">
            @else
                <p>N/A</p>
            @endif
        </div>
    </div>

    <a href="{{ route('sanpham.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
