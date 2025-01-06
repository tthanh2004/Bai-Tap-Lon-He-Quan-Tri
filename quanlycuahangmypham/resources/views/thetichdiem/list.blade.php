@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Thẻ Tích Điểm</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('thetichdiem.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm thẻ tích điểm hoặc tên khách hàng..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <a href="{{ route('thetichdiem.create') }}" class="btn btn-success mb-3">Thêm Thẻ Tích Điểm Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Thẻ</th>
                <th>Điểm Tích Lũy</th>
                <th>Khách Hàng</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
           @forelse($thetichdiems as $thetichdiem)
                <tr>
                    <td>{{ $thetichdiem->mathetichdiem }}</td>
                    <td>{{ $thetichdiem->diemtichluy }}</td>
                    <td>{{ $thetichdiem->khachhang->hotenkh ?? 'N/A' }}</td>
                    <td>{{ $thetichdiem->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('thetichdiem.show', $thetichdiem->mathetichdiem) }}" class="btn btn-info btn-sm">Xem</a>
                         <a href="{{ route('thetichdiem.edit', $thetichdiem->mathetichdiem) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('thetichdiem.destroy', $thetichdiem->mathetichdiem) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa thẻ này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Không có dữ liệu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân Trang -->
    {!! $thetichdiems->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
@endsection
