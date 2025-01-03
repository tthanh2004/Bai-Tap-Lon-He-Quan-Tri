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

    <form action="{{ route('nhanvien.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="manhanvien" class="form-label">Mã Nhân Viên</label>
            <input type="text" class="form-control" id="manhanvien" name="manhanvien" value="{{ old('manhanvien') }}" required>
        </div>

        <div class="mb-3">
            <label for="hoten" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="hoten" name="hoten" value="{{ old('hoten') }}" required>
        </div>

        <div class="mb-3">
            <label for="gioitinh" class="form-label">Giới Tính</label>
            <select class="form-select" id="gioitinh" name="gioitinh" required>
                <option value="">Chọn giới tính</option>
                <option value="Nam" {{ old('gioitinh') == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gioitinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                <option value="Khác" {{ old('gioitinh') == 'Khác' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ngaysinh" class="form-label">Ngày Sinh</label>
            <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" value="{{ old('ngaysinh') }}" required>
        </div>

        <div class="mb-3">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <textarea class="form-control" id="diachi" name="diachi" rows="3" required>{{ old('diachi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="sodienthoai" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" id="sodienthoai" name="sodienthoai" value="{{ old('sodienthoai') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Nhân Viên</button>
    </form>
</div>
@endsection
