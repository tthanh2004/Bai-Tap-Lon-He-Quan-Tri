@extends('layouts.app')

@section('title', 'Chỉnh Sửa Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Chi Tiết Hóa Đơn</h1>

    <form action="{{ route('chitiethoadon.update', $chitiethoadon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="idhoadon" class="form-label">Mã Hóa Đơn</label>
            <select name="idhoadon" id="idhoadon" class="form-select" required>
                <option value="">-- Chọn Mã Hóa Đơn --</option>
                @foreach($hoadons as $hoadon)
                    <option value="{{ $hoadon->mahoadon }}" {{ old('idhoadon', $chitiethoadon->idhoadon) == $hoadon->mahoadon ? 'selected' : '' }}>
                        {{ $hoadon->mahoadon }}
                    </option>
                @endforeach
            </select>
            @error('idhoadon')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idsanpham" class="form-label">Mã Sản Phẩm</label>
            <select name="idsanpham" id="idsanpham" class="form-select" required>
                <option value="">-- Chọn Mã Sản Phẩm --</option>
                @foreach($sanphams as $sanpham)
                    <option value="{{ $sanpham->masanpham }}" {{ old('idsanpham', $chitiethoadon->idsanpham) == $sanpham->masanpham ? 'selected' : '' }}>
                        {{ $sanpham->masanpham }} - {{ $sanpham->tensanpham }}
                    </option>
                @endforeach
            </select>
            @error('idsanpham')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="soluongmua" class="form-label">Số Lượng Mua</label>
            <input type="number" name="soluongmua" id="soluongmua" class="form-control" value="{{ old('soluongmua', $chitiethoadon->soluongmua) }}" required>
            @error('soluongmua')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="giamgia" class="form-label">Giảm Giá (%)</label>
            <input type="number" name="giamgia" id="giamgia" class="form-control" value="{{ old('giamgia', $chitiethoadon->giamgia) }}" min="0" max="100" step="0.01">
            @error('giamgia')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="thanhtien" class="form-label">Thành Tiền (VND)</label>
            <input type="number" name="thanhtien" id="thanhtien" class="form-control" value="{{ old('thanhtien', $chitiethoadon->thanhtien) }}" required>
            @error('thanhtien')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="{{ route('chitiethoadon.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
