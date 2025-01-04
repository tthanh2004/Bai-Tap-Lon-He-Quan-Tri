@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Chi Tiết Khách Hàng</h1>

    <div class="card">
        <div class="card-header">
            {{ $hang->tenhang }}
        </div>
        <div class="card-body">
            <p><strong>Mã Khách Hàng:</strong> {{ $hang->mahang }}</p>
            <p><strong>Địa Chỉ:</strong> {{ $hang->diachi }}</p>
        </div>
    </div>

    <a href="{{ route('hang.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
</div>
@endsection
