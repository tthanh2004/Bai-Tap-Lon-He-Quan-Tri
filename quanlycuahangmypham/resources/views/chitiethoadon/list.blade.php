@extends('layouts.app')

@section('title', 'Quản Lý Chi Tiết Hóa Đơn')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Chi Tiết Hóa Đơn</h1>

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

    <!-- Nút Thêm Chi Tiết Hóa Đơn Mới -->
    <a href="{{ route('chitiethoadon.create') }}" class="btn btn-primary mb-3">Thêm Chi Tiết Hóa Đơn Mới</a>

    @if($chitiethoadons->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã Hóa Đơn</th>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng Mua</th>
                    <th>Giảm Giá (%)</th>
                    <th>Thành Tiền</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chitiethoadons as $cthd)
                    <tr>
                        <td>{{ $cthd->id }}</td>
                        <td>{{ $cthd->idhoadon }}</td>
                        <td>{{ $cthd->sanpham->tensanpham ?? 'N/A' }}</td>
                        <td>{{ $cthd->soluongmua }}</td>
                        <td>{{ $cthd->giamgia ?? '0' }}%</td>
                        <td>{{ number_format($cthd->thanhtien, 0, ',', '.') }} VND</td>
                        <td>
                            <a href="{{ route('chitiethoadon.show', $cthd->id) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('chitiethoadon.edit', $cthd->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('chitiethoadon.destroy', $cthd->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa không?');">
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
        {!! $chitiethoadons->withQueryString()->links('pagination::bootstrap-5') !!}
    @else
        <div class="alert alert-info">
            Không có dữ liệu chi tiết hóa đơn.
        </div>
    @endif
</div>
@endsection
