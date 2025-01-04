@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Khách Hàng</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('hang.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm khách hàng..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>


    <a href="{{ route('hang.create') }}" class="btn btn-success mb-3">Thêm Khách Hàng Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã KH</th>
                <th>Họ Tên</th>
                <th>Địa Chỉ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hang as $nv)
                <tr>
                    <td>{{ $nv->mahang }}</td>
                    <td>{{ $nv->tenhang }}</td>
                    <td>{{ $nv->diachi }}</td>
                    <td>
                        <a href="{{ route('hang.show', $nv) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('hang.edit', $nv) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('hang.destroy', $nv) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">Xóa</button>
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
    {!! $hang->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
@endsection
