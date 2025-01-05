<?php

namespace App\Http\Controllers;

use App\Models\NhapHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NhapHangController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các nhập hàng.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Khởi tạo query
        $query = NhapHang::with('sanpham');

        // Thêm điều kiện tìm kiếm nếu có
        if ($search) {
            $query->where('manhaphang', 'like', "$search%")
                ->orWhere('idsanpham', 'like', "$search%");
        }

        // Lấy dữ liệu với phân trang
        $nhaphangs = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Giữ lại từ khóa tìm kiếm trong phân trang
        $nhaphangs->appends(['search' => $search]);

        // Truyền dữ liệu đến view
        return view('nhaphang.list', [
            'nhaphangs' => $nhaphangs,
            'search' => $search,
        ]);
    }

    /**
     * Hiển thị form tạo nhập hàng mới.
     */
    public function create()
    {
        $sanphams = SanPham::all();
        return view('nhaphang.create', compact('sanphams'));
    }

    /**
     * Lưu nhập hàng mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'manhaphang' => 'required|unique:nhaphang,manhaphang',
            'idsanpham' => 'required|exists:sanpham,masanpham',
            'soluongnhap' => 'required|integer|min:1',
            'gianhap' => 'required|numeric|min:0',
            'ngaynhap' => 'required|date',
        ]);

        NhapHang::create($validated);

        return redirect()->route('nhaphang.index')->with('success', 'Đã thêm nhập hàng mới thành công.');
    }

    /**
     * Hiển thị chi tiết một nhập hàng.
     */
    public function show(NhapHang $nhaphang)
    {
        $nhaphang->load('sanpham');
        return view('nhaphang.show', compact('nhaphang'));
    }

    /**
     * Hiển thị form chỉnh sửa nhập hàng.
     */
    public function edit(NhapHang $nhaphang)
    {
        $sanphams = SanPham::all();
        return view('nhaphang.edit', compact('nhaphang', 'sanphams'));
    }

    /**
     * Cập nhật nhập hàng trong cơ sở dữ liệu.
     */
    public function update(Request $request, NhapHang $nhaphang)
    {
        // Xác thực dữ liệu nhập vào
        $validated = $request->validate([
            'manhaphang' => 'required|unique:nhaphang,manhaphang,' . $nhaphang->manhaphang . ',manhaphang',
            'idsanpham' => 'required|exists:sanpham,masanpham',
            'soluongnhap' => 'required|integer|min:1',
            'gianhap' => 'required|numeric|min:0',
            'ngaynhap' => 'required|date',
        ]);

        $nhaphang->update($validated);

        return redirect()->route('nhaphang.index')->with('success', 'Đã cập nhật nhập hàng thành công.');
    }

    /**
     * Xóa một nhập hàng khỏi cơ sở dữ liệu.
     */
    public function destroy(NhapHang $nhaphang)
    {
        $nhaphang->delete();
        return redirect()->route('nhaphang.index')->with('success', 'Đã xóa nhập hàng thành công.');
    }
}
