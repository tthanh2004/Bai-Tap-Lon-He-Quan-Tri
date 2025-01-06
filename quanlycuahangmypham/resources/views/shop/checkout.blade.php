@extends('layouts.app')

@section('title', 'Thanh Toán')

@section('content')
<div class="container">
    <h1 class="mb-4">Thanh Toán</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cart)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ảnh Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Đơn Giá</th>
                    <th>Số Lượng</th>
                    <th>Thành Tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($cart as $item)
                    @php
                        $total += $item['sanpham']->dongia * $item['quantity'];
                    @endphp
                    <tr>
                        <td>
                            @if(!empty($item['sanpham']->anhsanpham))
                                <img src="{{ asset('uploads/sanpham/' . $item['sanpham']->anhsanpham) }}" alt="{{ $item['sanpham']->tensanpham }}" width="50">
                            @else
                                <img src="{{ asset('uploads/sanpham/default.jpg') }}" alt="Default Image" width="50">
                            @endif
                        </td>
                        <td>{{ $item['sanpham']->tensanpham }}</td>
                        <td>{{ number_format($item['sanpham']->dongia, 0, ',', '.') }} VND</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['sanpham']->dongia * $item['quantity'], 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng Tiền:</strong></td>
                    <td><strong id="original_total">{{ number_format($total, 0, ',', '.') }} VND</strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng Tiền Sau Khi Giảm:</strong></td>
                    <td><strong id="total_after_discount">{{ number_format($total, 0, ',', '.') }} VND</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Form Thông Tin Thanh Toán -->
        <form id="checkoutForm" action="{{ route('shop.checkout.process') }}" method="POST">
            @csrf
            <h3>Thông Tin Thanh Toán</h3>
            
            <!-- Chọn Khách Hàng -->
            <div class="mb-3">
                <label for="idkhachhang" class="form-label">Khách Hàng</label>
                <select name="idkhachhang" id="idkhachhang" class="form-control" required>
                    <option value="">-- Chọn Khách Hàng --</option>
                    @foreach($khachhangs as $khachhang)
                        <option value="{{ $khachhang->makhachhang }}" {{ old('idkhachhang') == $khachhang->makhachhang ? 'selected' : '' }}>
                            {{ $khachhang->makhachhang }} - {{ $khachhang->hotenkh }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Chọn Nhân Viên -->
            <div class="mb-3">
                <label for="idnhanvien" class="form-label">Nhân Viên</label>
                <select name="idnhanvien" id="idnhanvien" class="form-control" required>
                    <option value="">-- Chọn Nhân Viên --</option>
                    @foreach($nhanviens as $nhanvien)
                        <option value="{{ $nhanvien->manhanvien }}" {{ old('idnhanvien') == $nhanvien->manhanvien ? 'selected' : '' }}>
                            {{ $nhanvien->hoten }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Kiểm Tra Sử Dụng Thẻ Tích Điểm -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="use_point_card" name="use_point_card" value="1" {{ old('use_point_card') ? 'checked' : '' }}>
                <label class="form-check-label" for="use_point_card">Sử Dụng Thẻ Tích Điểm (Giảm 10%)</label>
            </div>

            <!-- Địa Chỉ Giao Hàng -->
            <div class="mb-3">
                <label for="address" class="form-label">Địa Chỉ Giao Hàng</label>
                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>

            <!-- Nút mở modal xác nhận -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">
                Hoàn Thành Đặt Hàng
            </button>

            <!-- Modal xác nhận -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Xác Nhận Đặt Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn đặt hàng không?</p>
                        <p><strong>Tổng Tiền:</strong> <span id="confirm_total">{{ number_format($total, 0, ',', '.') }} VND</span></p>
                        <p><strong>Giảm Giá:</strong> <span id="confirm_discount">0 VND</span></p>
                        <p><strong>Tổng Tiền Sau Khi Giảm:</strong> <span id="confirm_total_after_discount">{{ number_format($total, 0, ',', '.') }} VND</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Đặt Hàng</button>
                    </div>
                </div>
              </div>
            </div>
        </form>
    @else
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống.
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    let customerPoints = 0; // Biến lưu trữ số điểm hiện có
    let originalTotal = @json($total); // Sử dụng json_encode để đảm bảo an toàn

    document.getElementById('idkhachhang').addEventListener('change', function() {
        var makhachhang = this.value;
        if(makhachhang) {
            fetch('/api/khachhang/' + makhachhang + '/points')
                .then(response => response.json())
                .then(data => {
                    customerPoints = parseInt(data.total_points);
                    document.getElementById('current_points').innerText = customerPoints + ' điểm';

                    // Nếu thẻ tích điểm không được sử dụng, đảm bảo tổng sau giảm là tổng ban đầu
                    var usePointsCheckbox = document.getElementById('use_point_card');
                    if (!usePointsCheckbox.checked) {
                        document.getElementById('total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(originalTotal) + ' VND';
                        document.getElementById('confirm_discount').innerText = '0 VND';
                        document.getElementById('confirm_total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(originalTotal) + ' VND';
                    }
                })
                .catch(error => {
                    console.error('Error fetching points:', error);
                    customerPoints = 0;
                    document.getElementById('current_points').innerText = customerPoints + ' điểm';
                    alert('Không thể lấy số điểm hiện tại của khách hàng. Vui lòng thử lại sau.');
                });
        } else {
            customerPoints = 0;
            document.getElementById('current_points').innerText = customerPoints + ' điểm';

            // Nếu không chọn khách hàng, đảm bảo tổng sau giảm là tổng ban đầu
            document.getElementById('total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(originalTotal) + ' VND';
            document.getElementById('confirm_discount').innerText = '0 VND';
            document.getElementById('confirm_total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(originalTotal) + ' VND';
        }
    });

    document.getElementById('use_point_card').addEventListener('change', function() {
        var usePoints = this.checked;
        var discount = 0;
        var totalAfterDiscount = originalTotal;

        if(usePoints) {
            if(customerPoints >= 100) {
                discount = originalTotal * 0.10; // Giảm 10%
                totalAfterDiscount = originalTotal - discount;
            } else {
                alert('Bạn cần ít nhất 100 điểm để được giảm 10%.');
                this.checked = false;
            }
        }

        // Cập nhật tổng tiền sau khi giảm
        document.getElementById('total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(totalAfterDiscount) + ' VND';

        // Cập nhật thông tin trong modal
        document.getElementById('confirm_total').innerText = new Intl.NumberFormat('vi-VN').format(originalTotal) + ' VND';
        document.getElementById('confirm_discount').innerText = new Intl.NumberFormat('vi-VN').format(discount) + ' VND';
        document.getElementById('confirm_total_after_discount').innerText = new Intl.NumberFormat('vi-VN').format(totalAfterDiscount) + ' VND';
    });
</script>
@endsection
