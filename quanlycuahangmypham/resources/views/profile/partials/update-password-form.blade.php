<section class="mb-5">
    <header class="mb-4">
        <h2 class="h4">
            {{ __('Đổi Mật Khẩu') }}
        </h2>

        <p class="text-muted">
            {{ __('Đảm bảo tài khoản của bạn an toàn bằng cách sử dụng một mật khẩu dài và ngẫu nhiên.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <!-- Mật Khẩu Hiện Tại -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Mật Khẩu Hiện Tại') }}</label>
            <input type="password" id="update_password_current_password" name="current_password"
                   class="form-control @error('current_password') is-invalid @enderror"
                   autocomplete="current-password" required>
            @error('current_password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Mật Khẩu Mới -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Mật Khẩu Mới') }}</label>
            <input type="password" id="update_password_password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   autocomplete="new-password" required>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Xác Nhận Mật Khẩu Mới -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Xác Nhận Mật Khẩu Mới') }}</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   autocomplete="new-password" required>
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Nút Submit và Thông Báo -->
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('Lưu') }}
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small"
                >
                    {{ __('Đã lưu.') }}
                </div>
            @endif
        </div>
    </form>
</section>
