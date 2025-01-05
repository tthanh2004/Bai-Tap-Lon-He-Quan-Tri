@extends('layouts.app')

@section('title', 'Quản Lý Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Hóa Đơn</h1>

    <!-- Thông Báo Thành Công / Lỗi -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form Tìm Kiếm và Lọc -->
    <form action="{{ route('hoadon.index') }}" method="GET" class="mb-3">
        <div class="row g-2">
            <!-- Tìm Kiếm Theo Mã Hóa Đơn hoặc Tên Khách Hàng/Nhân Viên -->
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm hóa đơn..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Tìm</button>
                </div>
            </div>

            <!-- Lọc Theo Khách Hàng -->
            <div class="col-md-4">
                <select name="khachhang" id="khachhang" class="form-select">
                    <option value="">-- Tất cả Khách Hàng --</option>
                    @foreach($khachhangs as $khachhang)
                        <option value="{{ $khachhang->makhachhang }}" {{ request('khachhang') == $khachhang->makhachhang ? 'selected' : '' }}>
                            {{ $khachhang->hotenkh }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Lọc Theo Nhân Viên -->
            <div class="col-md-4">
                <select name="nhanvien" id="nhanvien" class="form-select">
                    <option value="">-- Tất cả Nhân Viên --</option>
                    @foreach($nhanviens as $nhanvien)
                        <option value="{{ $nhanvien->manhanvien }}" {{ request('nhanvien') == $nhanvien->manhanvien ? 'selected' : '' }}>
                            {{ $nhanvien->hoten }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>


    <!-- Nút Thêm Hóa Đơn Mới -->
    <a href="{{ route('hoadon.create') }}" class="btn btn-primary mb-3">Thêm Hóa Đơn Mới</a>

    @if($hoadons->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Hóa Đơn</th>
                    <th>Tên Khách Hàng</th>
                    <th>Tên Nhân Viên</th>
                    <th>Ngày Lập Hóa Đơn</th>
                    <th>Sử Dụng Thẻ Tích Điểm</th>
                    <th>Tổng Tiền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hoadons as $hoadon)
                    <tr>
                        <td>{{ $hoadon->mahoadon }}</td>
                        <td>{{ $hoadon->khachhang->hotenkh ?? 'N/A' }}</td>
                        <td>{{ $hoadon->nhanvien->hoten ?? 'N/A' }}</td>
                        <td>{{ $hoadon->ngaylaphoadon }}</td>
                        <td>{{ $hoadon->sudungTTD ? 'Có' : 'Không' }}</td>
                        <td>{{ number_format($hoadon->tongtien, 0, ',', '.') }} VND</td>
                        <td>
                            <a href="{{ route('hoadon.show', $hoadon->mahoadon) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('hoadon.edit', $hoadon->mahoadon) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('hoadon.destroy', $hoadon->mahoadon) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân Trang -->
        {!! $hoadons->withQueryString()->links('pagination::bootstrap-5') !!}
    @else
        <div class="alert alert-info">
            Không có dữ liệu hóa đơn.
        </div>
    @endif
</div>
@endsection
