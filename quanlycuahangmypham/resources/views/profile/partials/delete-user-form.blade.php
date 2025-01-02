<section class="mb-5">
    <header class="mb-4">
        <h2 class="h4 text-danger">
            {{ __('Xóa Tài Khoản') }}
        </h2>

        <p class="text-muted">
            {{ __('Khi xóa tài khoản, tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn. Vui lòng chắc chắn trước khi thực hiện hành động này.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <!-- Nút Xóa -->
        <div class="mt-3">
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản?')">
                {{ __('Xóa Tài Khoản') }}
            </button>
        </div>
    </form>
</section>
