@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Khách Hàng</h1>

    <div class="card">
        <div class="card-header">
            {{ $khachhang->hotenkh }}
        </div>
        <div class="card-body">
            <p><strong>Mã Khách Hàng:</strong> {{ $khachhang->makhachhang }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $khachhang->diachi }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $khachhang->sodienthoai }}</p>
        </div>
    </div>

    <a href="{{ route('khachhang.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
