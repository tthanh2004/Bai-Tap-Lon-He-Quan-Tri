@extends('layouts.app')

@section('title', 'Cửa Hàng Sản Phẩm')

@section('content')
<div class="container">
    <h1 class="mb-4">Cửa Hàng Sản Phẩm</h1>

    <!-- Form Tìm Kiếm -->
    <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($sanpham->count())
        <div class="row">
            @foreach($sanpham as $sp)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if(!empty($sp->anhsanpham))
                            <img src="{{ asset('uploads/sanpham/' . $sp->anhsanpham) }}" class="card-img-top" alt="{{ $sp->tensanpham }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('uploads/sanpham/default.jpg') }}" class="card-img-top" alt="Default Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $sp->tensanpham }}</h5>
                            <p class="card-text">{{ $sp->donvitinh }}</p>
                            <p class="card-text"><strong>{{ number_format($sp->dongia, 0, ',', '.') }} VND</strong></p>
                            <a href="{{ route('shop.product.show', $sp->masanpham) }}" class="btn btn-primary mt-auto">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Phân Trang -->
        <div class="d-flex justify-content-center">
            {!! $sanpham->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    @else
        <div class="alert alert-info">
            Không tìm thấy sản phẩm nào.
        </div>
    @endif
</div>
@endsection
