<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChiTietHoaDonController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các chi tiết hóa đơn.
     */
    public function index()
    {
        $chitiethoadons = ChiTietHoaDon::with(['hoadon', 'sanpham'])->orderBy('idhoadon', 'desc')->paginate(10);
        return view('chitiethoadon.list', compact('chitiethoadons'));
    }

    /**
     * Hiển thị form tạo chi tiết hóa đơn mới.
     */
    public function create()
    {
        $hoadons = HoaDon::all();
        $sanphams = SanPham::all();
        return view('chitiethoadon.create', compact('hoadons', 'sanphams'));
    }

    /**
     * Lưu chi tiết hóa đơn mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'idhoadon' => 'required|exists:hoadon,mahoadon',
            'idsanpham' => 'required|exists:sanpham,masanpham',
            'soluongmua' => 'required|integer|min:1',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'thanhtien' => 'required|numeric|min:0',
        ]);

        // Tạo chi tiết hóa đơn
        ChiTietHoaDon::create($validated);

        return redirect()->route('chitiethoadon.index')->with('success', 'Đã thêm chi tiết hóa đơn mới thành công.');
    }

    /**
     * Hiển thị chi tiết một chi tiết hóa đơn.
     */
    public function show(ChiTietHoaDon $chitiethoadon)
    {
        $chitiethoadon->load(['hoadon', 'sanpham']);
        return view('chitiethoadon.show', compact('chitiethoadon'));
    }

    /**
     * Hiển thị form chỉnh sửa chi tiết hóa đơn.
     */
    public function edit(ChiTietHoaDon $chitiethoadon)
    {
        $hoadons = HoaDon::all();
        $sanphams = SanPham::all();
        return view('chitiethoadon.edit', compact('chitiethoadon', 'hoadons', 'sanphams'));
    }

    /**
     * Cập nhật chi tiết hóa đơn trong cơ sở dữ liệu.
     */
    public function update(Request $request, ChiTietHoaDon $chitiethoadon)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'idhoadon' => 'required|exists:hoadon,mahoadon',
            'idsanpham' => 'required|exists:sanpham,masanpham',
            'soluongmua' => 'required|integer|min:1',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'thanhtien' => 'required|numeric|min:0',
        ]);

        // Cập nhật chi tiết hóa đơn
        $chitiethoadon->update($validated);

        return redirect()->route('chitiethoadon.index')->with('success', 'Đã cập nhật chi tiết hóa đơn thành công.');
    }

    /**
     * Xóa một chi tiết hóa đơn khỏi cơ sở dữ liệu.
     */
    public function destroy(ChiTietHoaDon $chitiethoadon)
    {
        $chitiethoadon->delete();
        return redirect()->route('chitiethoadon.index')->with('success', 'Đã xóa chi tiết hóa đơn thành công.');
    }
}
