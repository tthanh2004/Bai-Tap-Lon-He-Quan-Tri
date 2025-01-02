<section class="mb-5">
    <header class="mb-4">
        <h2 class="h4">
            {{ __('Thông Tin Cá Nhân') }}
        </h2>

        <p class="text-muted">
            {{ __("Cập nhật thông tin cá nhân và địa chỉ email của bạn.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <!-- Tên -->
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Tên') }}</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                   class="form-control @error('name') is-invalid @enderror" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                   class="form-control @error('email') is-invalid @enderror" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-warning">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button form="send-verification" class="btn btn-link p-0 ms-2">
                            {{ __('Nhấn vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2" role="alert">
                            {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Nút Submit -->
        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary me-3">
                {{ __('Lưu') }}
            </button>

            @if (session('status') === 'profile-updated')
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
