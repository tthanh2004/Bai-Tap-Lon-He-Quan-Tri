<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HoaDonController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các hóa đơn.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedKhachHang = $request->input('khachhang');
        $selectedNhanVien = $request->input('nhanvien');

        // Khởi tạo query với eager loading
        $query = HoaDon::with(['khachhang', 'nhanvien']);

        // Thêm điều kiện tìm kiếm nếu có
        if ($search) {
            $query->where('mahoadon', 'like', "%$search%")
                ->orWhereHas('khachhang', function ($q) use ($search) {
                    $q->where('hotenkh', 'like', "%$search%");
                })
                ->orWhereHas('nhanvien', function ($q) use ($search) {
                    $q->where('hoten', 'like', "%$search%");
                });
        }

        // Thêm điều kiện lọc theo khách hàng nếu có
        if ($selectedKhachHang) {
            $query->where('idkhachhang', $selectedKhachHang);
        }

        // Thêm điều kiện lọc theo nhân viên nếu có
        if ($selectedNhanVien) {
            $query->where('idnhanvien', $selectedNhanVien);
        }

        // Lấy dữ liệu với phân trang
        $hoadons = $query->orderBy('ngaylaphoadon', 'desc')->paginate(10);

        // Giữ lại từ khóa tìm kiếm và lọc trong phân trang
        $hoadons->appends([
            'search' => $search,
            'khachhang' => $selectedKhachHang,
            'nhanvien' => $selectedNhanVien,
        ]);

        // Lấy danh sách tất cả khách hàng và nhân viên để populate vào dropdown
        $khachhangs = KhachHang::all();
        $nhanviens = NhanVien::all();

        // Truyền dữ liệu đến view
        return view('hoadon.list', [
            'hoadons' => $hoadons,
            'search' => $search,
            'selectedKhachHang' => $selectedKhachHang,
            'selectedNhanVien' => $selectedNhanVien,
            'khachhangs' => $khachhangs,
            'nhanviens' => $nhanviens,
        ]);
    }

    /**
     * Hiển thị form tạo hóa đơn mới.
     */
    public function create()
    {
        $khachhangs = KhachHang::all();
        $nhanviens = NhanVien::all();
        return view('hoadon.create', compact('khachhangs', 'nhanviens'));
    }

    /**
     * Lưu hóa đơn mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'mahoadon' => 'required|unique:hoadon,mahoadon',
            'idkhachhang' => 'required|exists:khachhang,makhachhang',
            'idnhanvien' => 'required|exists:nhanvien,manhanvien',
            'ngaylaphoadon' => 'required|date',
            'sudungTTD' => 'required|boolean',
            'tongtien' => 'required|numeric|min:0',
        ]);

        HoaDon::create($validated);

        return redirect()->route('hoadon.index')->with('success', 'Đã thêm hóa đơn mới thành công.');
    }

    /**
     * Hiển thị chi tiết một hóa đơn.
     */
    public function show(HoaDon $hoadon)
    {
        $hoadon->load(['khachhang', 'nhanvien', 'chitiethoadon']);
        return view('hoadon.show', compact('hoadon'));
    }

    /**
     * Hiển thị form chỉnh sửa hóa đơn.
     */
    public function edit(HoaDon $hoadon)
    {
        $khachhangs = KhachHang::all();
        $nhanviens = NhanVien::all();
        return view('hoadon.edit', compact('hoadon', 'khachhangs', 'nhanviens'));
    }

    /**
     * Cập nhật hóa đơn trong cơ sở dữ liệu.
     */
    public function update(Request $request, HoaDon $hoadon)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'mahoadon' => 'required|unique:hoadon,mahoadon,' . $hoadon->mahoadon . ',mahoadon',
            'idkhachhang' => 'required|exists:khachhang,makhachhang',
            'idnhanvien' => 'required|exists:nhanvien,manhanvien',
            'ngaylaphoadon' => 'required|date',
            'sudungTTD' => 'required|boolean',
            'tongtien' => 'required|numeric|min:0',
        ]);

        $hoadon->update($validated);

        return redirect()->route('hoadon.index')->with('success', 'Đã cập nhật hóa đơn thành công.');
    }

    /**
     * Xóa một hóa đơn khỏi cơ sở dữ liệu.
     */
    public function destroy(HoaDon $hoadon)
    {
        $hoadon->delete();
        return redirect()->route('hoadon.index')->with('success', 'Đã xóa hóa đơn thành công.');
    }
}
