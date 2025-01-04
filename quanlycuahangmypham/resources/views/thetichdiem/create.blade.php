@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Thêm Thẻ Tích Điểm Mới</h1>

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

    <form action="{{ route('thetichdiem.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="mathetichdiem" class="form-label">Mã Thẻ Tích Điểm</label>
            <input type="text" class="form-control" id="mathetichdiem" name="mathetichdiem" value="{{ old('mathetichdiem') }}" required>
        </div>

        <div class="mb-3">
            <label for="idkhachhang" class="form-label">Khách Hàng</label>
            <select class="form-control" id="idkhachhang" name="idkhachhang" required>
                <option value="">-- Chọn Khách Hàng --</option>
                @foreach($khachhangs as $khachhang)
                    <option value="{{ $khachhang->makhachhang }}" {{ old('idkhachhang') == $khachhang->makhachhang ? 'selected' : '' }}>
                        {{ $khachhang->hotenkh }} ({{ $khachhang->makhachhang }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="diemtichluy" class="form-label">Điểm Tích Lũy</label>
            <input type="number" class="form-control" id="diemtichluy" name="diemtichluy" value="{{ old('diemtichluy') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Thẻ Tích Điểm</button>
    </form>
</div>
@endsection
