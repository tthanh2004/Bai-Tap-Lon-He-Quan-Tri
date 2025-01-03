@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Nhân Viên</h1>

    <div class="card">
        <div class="card-header">
            {{ $nhanvien->hoten }}
        </div>
        <div class="card-body">
            <p><strong>Mã Nhân Viên:</strong> {{ $nhanvien->manhanvien }}</p>
            <p><strong>Giới Tính:</strong> {{ $nhanvien->gioitinh }}</p>
            <p><strong>Ngày Sinh:</strong> {{ \Carbon\Carbon::parse($nhanvien->ngaysinh)->format('d/m/Y') }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $nhanvien->diachi }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $nhanvien->sodienthoai }}</p>
        </div>
    </div>

    <a href="{{ route('nhanvien.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
