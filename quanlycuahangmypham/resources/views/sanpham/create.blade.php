@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm Sản Phẩm Mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="masanpham" class="form-label">Mã Sản Phẩm</label>
            <input type="text" name="masanpham" class="form-control" id="masanpham" value="{{ old('masanpham') }}" required>
        </div>
        <div class="mb-3">
            <label for="idhang" class="form-label">Hãng</label>
            <select name="idhang" id="idhang" class="form-select" required>
                <option value="">Chọn Hãng</option>
                @foreach($hangs as $hang)
                    <option value="{{ $hang->mahang }}" {{ old('idhang') == $hang->mahang ? 'selected' : '' }}>{{ $hang->tenhang }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tensanpham" class="form-label">Tên Sản Phẩm</label>
            <input type="text" name="tensanpham" class="form-control" id="tensanpham" value="{{ old('tensanpham') }}" required>
        </div>
        <div class="mb-3">
            <label for="donvitinh" class="form-label">Đơn Vị Tính</label>
            <input type="text" name="donvitinh" class="form-control" id="donvitinh" value="{{ old('donvitinh') }}" required>
        </div>
        <div class="mb-3">
            <label for="dongia" class="form-label">Đơn Giá</label>
            <input type="number" name="dongia" class="form-control" id="dongia" value="{{ old('dongia') }}" min="0" step="1000" required>
        </div>
        <div class="mb-3">
            <label for="soluongton" class="form-label">Số Lượng Tồn</label>
            <input type="number" name="soluongton" class="form-control" id="soluongton" value="{{ old('soluongton') }}" min="0" required>
        </div>
        <div class="mb-3">
            <label for="anhsanpham" class="form-label">Ảnh Sản Phẩm</label>
            <input type="file" name="anhsanpham" class="form-control" id="anhsanpham" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
    </form>
</div>
@endsection
