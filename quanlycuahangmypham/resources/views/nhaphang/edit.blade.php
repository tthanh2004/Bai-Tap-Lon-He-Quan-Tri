@extends('layouts.app')

@section('title', 'Sửa Nhập Hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Sửa Nhập Hàng</h1>

    <!-- Form Sửa Nhập Hàng -->
    <form action="{{ route('nhaphang.update', $nhaphang->manhaphang) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="manhaphang" class="form-label">Mã Nhập Hàng</label>
            <input type="text" name="manhaphang" id="manhaphang" class="form-control @error('manhaphang') is-invalid @enderror" value="{{ old('manhaphang', $nhaphang->manhaphang) }}" required>
            @error('manhaphang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="idsanpham" class="form-label">Sản Phẩm</label>
            <select name="idsanpham" id="idsanpham" class="form-select @error('idsanpham') is-invalid @enderror" required>
                <option value="">-- Chọn Sản Phẩm --</option>
                @foreach($sanphams as $sanpham)
                    <option value="{{ $sanpham->masanpham }}" {{ old('idsanpham', $nhaphang->idsanpham) == $sanpham->masanpham ? 'selected' : '' }}>
                        {{ $sanpham->tensanpham }}
                    </option>
                @endforeach
            </select>
            @error('idsanpham')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="soluongnhap" class="form-label">Số Lượng Nhập</label>
            <input type="number" name="soluongnhap" id="soluongnhap" class="form-control @error('soluongnhap') is-invalid @enderror" value="{{ old('soluongnhap', $nhaphang->soluongnhap) }}" min="1" required>
            @error('soluongnhap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gianhap" class="form-label">Giá Nhập</label>
            <input type="number" name="gianhap" id="gianhap" class="form-control @error('gianhap') is-invalid @enderror" value="{{ old('gianhap', $nhaphang->gianhap) }}" min="0" required>
            @error('gianhap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="ngaynhap" class="form-label">Ngày Nhập</label>
            <input type="date" name="ngaynhap" id="ngaynhap" class="form-control @error('ngaynhap') is-invalid @enderror" value="{{ old('ngaynhap', $nhaphang->ngaynhap) }}" required>
            @error('ngaynhap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-primary" type="submit">Cập Nhật</button>
        <a href="{{ route('nhaphang.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
