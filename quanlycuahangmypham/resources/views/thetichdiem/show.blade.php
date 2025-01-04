@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Thẻ Tích Điểm</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            {{ $thetichdiem->mathetichdiem }}
        </div>
        <div class="card-body">
            <p><strong>Mã Thẻ Tích Điểm:</strong> {{ $thetichdiem->mathetichdiem }}</p>
            <p><strong>Điểm Tích Lũy:</strong> {{ $thetichdiem->diemtichluy }}</p>
            <p><strong>Khách Hàng:</strong> 
                @if($thetichdiem->khachhang)
                    {{ $thetichdiem->khachhang->hotenkh }} ({{ $thetichdiem->khachhang->makhachhang }})
                @else
                    N/A
                @endif
            </p>
            <p><strong>Ngày Tạo:</strong> {{ $thetichdiem->created_at->format('d/m/Y') }}</p>
            <p><strong>Ngày Cập Nhật:</strong> {{ $thetichdiem->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <a href="{{ route('thetichdiem.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
    <a href="{{ route('thetichdiem.edit', $thetichdiem->mathetichdiem) }}" class="btn btn-warning mt-3">Sửa Thẻ Tích Điểm</a>
</div>
@endsection
