{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome to MyApp')

@section('welcome')
    <div class="welcome-container d-flex flex-column align-items-center justify-content-center vh-100 text-center">
        <h1 class="mb-4">Chào Mừng Bạn Đến Với Trang Web Của Chúng Tôi!</h1>
        <p class="mb-4">Chúng tôi rất vui được gặp bạn. Hãy đăng nhập hoặc đăng ký để tiếp tục.</p>
        <div>
            <!-- Login Button -->
            <a href="{{ route('login') }}" class="btn btn-primary btn-custom me-2">
                <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
            </a>
            <!-- Register Button -->
            <a href="{{ route('register') }}" class="btn btn-success btn-custom">
                <i class="fas fa-user-plus me-1"></i> Đăng Ký
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .welcome-container {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 90%;
        }
        .btn-custom {
            min-width: 150px;
            font-size: 1rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Optional: Add any JavaScript if needed for the welcome page
    </script>
@endpush
