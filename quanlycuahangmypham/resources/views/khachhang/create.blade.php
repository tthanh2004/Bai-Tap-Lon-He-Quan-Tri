@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm Nhân Viên Mới</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Lỗi!</strong> Hãy kiểm tra lại các trường dưới đây.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('khachhang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="makhachhang" class="form-label">Mã Nhân Viên</label>
            <input type="text" class="form-control" id="makhachhang" name="makhachhang" value="{{ old('makhachhang') }}" required>
        </div>

        <div class="mb-3">
            <label for="hotenkh" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="hotenkh" name="hotenkh" value="{{ old('hotenkh') }}" required>
        </div>

        <div class="mb-3">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <textarea class="form-control" id="diachi" name="diachi" rows="3" required>{{ old('diachi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="sodienthoai" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" id="sodienthoai" name="sodienthoai" value="{{ old('sodienthoai') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Khách Hàng</button>
    </form>
</div>
@endsection
