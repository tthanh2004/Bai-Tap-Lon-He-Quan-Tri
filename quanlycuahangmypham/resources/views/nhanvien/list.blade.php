@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Nhân Viên</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('nhanvien.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm nhân viên..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>


    <a href="{{ route('nhanvien.create') }}" class="btn btn-success mb-3">Thêm Nhân Viên Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Họ Tên</th>
                <th>Giới Tính</th>
                <th>Ngày Sinh</th>
                <th>Địa Chỉ</th>
                <th>Số Điện Thoại</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nhanvien as $nv)
                <tr>
                    <td>{{ $nv->manhanvien }}</td>
                    <td>{{ $nv->hoten }}</td>
                    <td>{{ $nv->gioitinh }}</td>
                    <td>{{ \Carbon\Carbon::parse($nv->ngaysinh)->format('d/m/Y') }}</td>
                    <td>{{ $nv->diachi }}</td>
                    <td>{{ $nv->sodienthoai }}</td>
                    <td>
                        <a href="{{ route('nhanvien.show', $nv) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('nhanvien.edit', $nv) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('nhanvien.destroy', $nv) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Không có dữ liệu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân Trang -->
    {!! $nhanvien->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
@endsection
