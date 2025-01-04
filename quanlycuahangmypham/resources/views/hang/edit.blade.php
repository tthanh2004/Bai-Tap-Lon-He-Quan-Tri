@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chỉnh Sửa Thông Tin Nhân Viên</h1>

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

    <form action="{{ route('hang.update', $hang) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="mahang" class="form-label">Mã Nhân Viên</label>
            <input type="text" class="form-control" id="mahang" name="mahang" value="{{ old('mahang', $hang->mahang) }}" required>
        </div>

        <div class="mb-3">
            <label for="tenhang" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="tenhang" name="tenhang" value="{{ old('tenhang', $hang->tenhang) }}" required>
        </div>

        <div class="mb-3">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <textarea class="form-control" id="diachi" name="diachi" rows="3" required>{{ old('diachi', $hang->diachi) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật Khách Hàng</button>
    </form>
</div>
@endsection
