@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Danh Sách Sản Phẩm</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('sanpham.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm mã sản phẩm hoặc tên sản phẩm..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    <a href="{{ route('sanpham.create') }}" class="btn btn-success mb-3">Thêm Sản Phẩm Mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Hãng</th>
                <th>Đơn Vị Tính</th>
                <th>Đơn Giá</th>
                <th>Số Lượng Tồn</th>
                <th>Ảnh Sản Phẩm</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sanpham as $sp)
                <tr>
                    <td>{{ $sp->masanpham }}</td>
                    <td>{{ $sp->tensanpham }}</td>
                    <td>{{ $sp->hang->tenhang ?? 'N/A' }}</td>
                    <td>{{ $sp->donvitinh }}</td>
                    <td>{{ number_format($sp->dongia, 0, ',', '.') }} VND</td>
                    <td>{{ $sp->soluongton }}</td>
                    <td>
                        @if (!empty($sp->anhsanpham))
                            <img width="50" src="{{ asset('uploads/sanpham/'.$sp->anhsanpham) }}" alt="{{ $sp->tensanpham }}">
                        @endif
                    </td>
                    <td>{{ $sp->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('sanpham.show', $sp->masanpham) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('sanpham.edit', $sp->masanpham) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('sanpham.destroy', $sp->masanpham) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
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
    {!! $sanpham->withQueryString()->links('pagination::bootstrap-5') !!}
</div>
@endsection
