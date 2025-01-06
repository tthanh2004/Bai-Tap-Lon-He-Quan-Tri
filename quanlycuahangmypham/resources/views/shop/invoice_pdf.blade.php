<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa Đơn {{ $hoadon->mahoadon }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header, .footer {
            text-align: center;
            position: fixed;
            width: 100%;
        }
        .header {
            top: -60px;
        }
        .footer {
            bottom: -60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 80px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .total {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Cửa Hàng Mỹ Phẩm XYZ</h2>
        <p>Địa chỉ: 789 Đường DEF, Quận 5, TP.HCM</p>
        <p>Số điện thoại: 0123456789</p>
    </div>

    <div class="footer">
        <p>© 2025 Cửa Hàng Mỹ Phẩm XYZ. Bảo lưu mọi quyền.</p>
    </div>

    <h3 style="text-align: center; margin-top: 40px;">HÓA ĐƠN BÁN HÀNG</h3>

    <p><strong>Mã Hóa Đơn:</strong> {{ $hoadon->mahoadon }}</p>
    <p><strong>Khách Hàng:</strong> {{ $hoadon->khachhang->hotenkh }}</p>
    <p><strong>Nhân Viên:</strong> {{ $hoadon->nhanvien->hoten }}</p>
    <p><strong>Địa Chỉ Giao Hàng:</strong> {{ $request->address ?? 'Không có thông tin' }}</p>
    <p><strong>Ngày Lập Hóa Đơn:</strong> {{ $hoadon->ngaylaphoadon->format('d/m/Y H:i') }}</p>
    <p><strong>Sử Dụng Thẻ Tích Điểm:</strong> {{ $hoadon->sudungTTD ? 'Có' : 'Không' }}</p>

    <table>
        <thead>
            <tr>
                <th>Ảnh Sản Phẩm</th>
                <th>Tên Sản Phẩm</th>
                <th>Đơn Giá</th>
                <th>Số Lượng</th>
                <th>Giảm Giá (%)</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hoadon->chitiethoadon as $ct)
                <tr>
                    <td>
                        @if(!empty($ct->sanpham->anhsanpham))
                            <img src="{{ public_path('uploads/sanpham/' . $ct->sanpham->anhsanpham) }}" alt="{{ $ct->sanpham->tensanpham }}" width="50">
                        @else
                            <img src="{{ public_path('uploads/sanpham/default.jpg') }}" alt="Default Image" width="50">
                        @endif
                    </td>
                    <td>{{ $ct->sanpham->tensanpham }}</td>
                    <td>{{ number_format($ct->sanpham->dongia, 0, ',', '.') }} VND</td>
                    <td>{{ $ct->soluongmua }}</td>
                    <td>{{ $ct->giamgia }}%</td>
                    <td>{{ number_format($ct->thanhtien, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="total"><strong>Tổng Tiền:</strong></td>
                <td><strong>{{ number_format($hoadon->tongtien, 0, ',', '.') }} VND</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
