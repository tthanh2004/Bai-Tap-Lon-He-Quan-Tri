@extends('layouts.app')

@section('title', 'Sửa Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Sửa Chi Tiết Hóa Đơn</h1>

    <!-- Form Sửa Chi Tiết Hóa Đơn -->
    <form action="{{ route('chitiethoadon.update', $chitiethoadon->idhoadon) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="idhoadon" class="form-label">Mã Hóa Đơn</label>
            <select name="idhoadon" id="idhoadon" class="form-select @error('idhoadon') is-invalid @enderror" required>
                <option value="">-- Chọn Hóa Đơn --</option>
                @foreach($hoadons as $hoadon)
                    <option value="{{ $hoadon->mahoadon }}" {{ old('idhoadon', $chitiethoadon->idhoadon) == $hoadon->mahoadon ? 'selected' : '' }}>
                        {{ $hoadon->mahoadon }} - {{ $hoadon->khachhang->tenkhachhang ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @error('idhoadon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idsanpham" class="form-label">Sản Phẩm</label>
            <select name="idsanpham" id="idsanpham" class="form-select @error('idsanpham') is-invalid @enderror" required>
                <option value="">-- Chọn Sản Phẩm --</option>
                @foreach($sanphams as $sanpham)
                    <option value="{{ $sanpham->masanpham }}" {{ old('idsanpham', $chitiethoadon->idsanpham) == $sanpham->masanpham ? 'selected' : '' }}>
                        {{ $sanpham->tensanpham }}
                    </option>
                @endforeach
            </select>
            @error('idsanpham')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="soluongmua" class="form-label">Số Lượng Mua</label>
            <input type="number" name="soluongmua" id="soluongmua" class="form-control @error('soluongmua') is-invalid @enderror" value="{{ old('soluongmua', $chitiethoadon->soluongmua) }}" min="1" required>
            @error('soluongmua')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="giamgia" class="form-label">Giảm Giá (%)</label>
            <input type="number" name="giamgia" id="giamgia" class="form-control @error('giamgia') is-invalid @enderror" value="{{ old('giamgia', $chitiethoadon->giamgia ?? 0) }}" min="0" max="100">
            @error('giamgia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="thanhtien" class="form-label">Thành Tiền</label>
            <input type="number" name="thanhtien" id="thanhtien" class="form-control @error('thanhtien') is-invalid @enderror" value="{{ old('thanhtien', $chitiethoadon->thanhtien) }}" min="0" required>
            @error('thanhtien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Cập Nhật</button>
        <a href="{{ route('chitiethoadon.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
