@extends('layouts.app')

@section('title', 'Thêm Hóa Đơn Mới')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm Hóa Đơn Mới</h1>

    <!-- Form Thêm Hóa Đơn -->
    <form action="{{ route('hoadon.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="mahoadon" class="form-label">Mã Hóa Đơn</label>
            <input type="text" name="mahoadon" id="mahoadon" class="form-control @error('mahoadon') is-invalid @enderror" value="{{ old('mahoadon') }}" required>
            @error('mahoadon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idkhachhang" class="form-label">Khách Hàng</label>
            <select name="idkhachhang" id="idkhachhang" class="form-select @error('idkhachhang') is-invalid @enderror" required>
                <option value="">-- Chọn Khách Hàng --</option>
                @foreach($khachhangs as $khachhang)
                    <option value="{{ $khachhang->makhachhang }}" {{ old('idkhachhang') == $khachhang->makhachhang ? 'selected' : '' }}>
                        {{ $khachhang->tenkhachhang }}
                    </option>
                @endforeach
            </select>
            @error('idkhachhang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idnhanvien" class="form-label">Nhân Viên</label>
            <select name="idnhanvien" id="idnhanvien" class="form-select @error('idnhanvien') is-invalid @enderror" required>
                <option value="">-- Chọn Nhân Viên --</option>
                @foreach($nhanviens as $nhanvien)
                    <option value="{{ $nhanvien->manhanvien }}" {{ old('idnhanvien') == $nhanvien->manhanvien ? 'selected' : '' }}>
                        {{ $nhanvien->tennhanvien }}
                    </option>
                @endforeach
            </select>
            @error('idnhanvien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ngaylaphoadon" class="form-label">Ngày Lập Hóa Đơn</label>
            <input type="date" name="ngaylaphoadon" id="ngaylaphoadon" class="form-control @error('ngaylaphoadon') is-invalid @enderror" value="{{ old('ngaylaphoadon', date('Y-m-d')) }}" required>
            @error('ngaylaphoadon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sudungTTD" class="form-label">Sử Dụng Thẻ Tích Điểm</label>
            <select name="sudungTTD" id="sudungTTD" class="form-select @error('sudungTTD') is-invalid @enderror" required>
                <option value="">-- Chọn --</option>
                <option value="1" {{ old('sudungTTD') == '1' ? 'selected' : '' }}>Có</option>
                <option value="0" {{ old('sudungTTD') == '0' ? 'selected' : '' }}>Không</option>
            </select>
            @error('sudungTTD')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tongtien" class="form-label">Tổng Tiền</label>
            <input type="number" name="tongtien" id="tongtien" class="form-control @error('tongtien') is-invalid @enderror" value="{{ old('tongtien') }}" min="0" required>
            @error('tongtien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success" type="submit">Thêm Hóa Đơn</button>
        <a href="{{ route('hoadon.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
