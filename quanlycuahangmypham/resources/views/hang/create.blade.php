
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm Hãng Mới</h1>

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

    <form action="{{ route('hang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="mahang" class="form-label">Mã Hãng</label>
            <input type="text" class="form-control" id="mahang" name="mahang" value="{{ old('mahang') }}" required>
        </div>

        <div class="mb-3">
            <label for="tenhang" class="form-label">Tên Hãng</label>
            <input type="text" class="form-control" id="tenhang" name="tenhang" value="{{ old('tenhang') }}" required>
        </div>

        <div class="mb-3">
            <label for="diachi" class="form-label">Địa Chỉ</label>
            <textarea class="form-control" id="diachi" name="diachi" rows="3" required>{{ old('diachi') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Khách Hàng</button>
    </form>
</div>
@endsection
