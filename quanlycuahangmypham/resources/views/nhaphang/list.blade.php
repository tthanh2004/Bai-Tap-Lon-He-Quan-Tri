@extends('layouts.app')

@section('title', 'Quản Lý Nhập Hàng')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Nhập Hàng</h1>

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

    <form action="{{ route('nhaphang.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm hàng đã nhập..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>


    <!-- Nút Thêm Nhập Hàng Mới -->
    <a href="{{ route('nhaphang.create') }}" class="btn btn-primary mb-3">Thêm Hàng Mới</a>

    @if($nhaphangs->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Nhập Hàng</th>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng Nhập</th>
                    <th>Giá Nhập</th>
                    <th>Ngày Nhập</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nhaphangs as $nhaphang)
                    <tr>
                        <td>{{ $nhaphang->manhaphang }}</td>
                        <td>{{ $nhaphang->sanpham->tensanpham ?? 'N/A' }}</td>
                        <td>{{ $nhaphang->soluongnhap }}</td>
                        <td>{{ number_format($nhaphang->gianhap, 0, ',', '.') }} VND</td>
                        <td>{{ $nhaphang->ngaynhap }}</td>
                        <td>
                            <a href="{{ route('nhaphang.show', $nhaphang->manhaphang) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('nhaphang.edit', $nhaphang->manhaphang) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('nhaphang.destroy', $nhaphang->manhaphang) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
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
        {!! $nhaphangs->withQueryString()->links('pagination::bootstrap-5') !!}
    @else
        <div class="alert alert-info">
            Không có dữ liệu nhập hàng.
        </div>
    @endif
</div>
@endsection
