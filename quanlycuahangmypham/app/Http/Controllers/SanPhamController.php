<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\Hang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SanPhamController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm với phân trang và tìm kiếm.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Khởi tạo query với quan hệ 'hang'
        $query = SanPham::with('hang');

        // Thêm điều kiện tìm kiếm nếu có
        if ($search) {
            $query->where('masanpham', 'like', "$search%")
                ->orWhere('tensanpham', 'like', "%$search%");
        }

        // Lấy dữ liệu với phân trang
        $sanpham = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Giữ lại từ khóa tìm kiếm trong phân trang
        $sanpham->appends(['search' => $search]);

        // Truyền dữ liệu đến view
        return view('sanpham.list', [
            'sanpham' => $sanpham,
            'search' => $search,
        ]);
    }

    /**
     * Hiển thị form tạo sản phẩm mới.
     */
    public function create()
    {
        // Lấy danh sách các hãng để lựa chọn
        $hangs = Hang::all();

        return view('sanpham.create', compact('hangs'));
    }

    /**
     * Lưu sản phẩm mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Quy tắc xác thực dữ liệu
        $rules = [
            'masanpham'    => 'required|string|max:10|unique:sanpham,masanpham',
            'idhang'       => 'required|string|max:10|exists:hang,mahang',
            'tensanpham'   => 'required|string|max:255',
            'donvitinh'    => 'required|string|max:50',
            'dongia'       => 'required|numeric|min:0',
            'soluongton'   => 'required|integer|min:0',
            'anhsanpham'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('sanpham.create')
                ->withInput()
                ->withErrors($validator);
        }

        // Xử lý upload hình ảnh nếu có
        if ($request->hasFile('anhsanpham')) {
            $image = $request->file('anhsanpham');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sanpham'), $imageName);
        } else {
            $imageName = 'default.jpg'; // Hoặc để null tùy theo yêu cầu
        }

        // Tạo sản phẩm mới
        SanPham::create([
            'masanpham'    => $request->masanpham,
            'idhang'       => $request->idhang,
            'tensanpham'   => $request->tensanpham,
            'donvitinh'    => $request->donvitinh,
            'dongia'       => $request->dongia,
            'soluongton'   => $request->soluongton,
            'anhsanpham'   => $imageName,
        ]);

        return redirect()->route('sanpham.index')
            ->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    /**
     * Hiển thị chi tiết sản phẩm.
     */
    public function show(SanPham $sanpham)
    {
        return view('sanpham.show', compact('sanpham'));
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm.
     */
    public function edit(SanPham $sanpham)
    {
        // Lấy danh sách các hãng để lựa chọn
        $hangs = Hang::all();

        return view('sanpham.edit', compact('sanpham', 'hangs'));
    }

    /**
     * Cập nhật sản phẩm trong cơ sở dữ liệu.
     */
    public function update(Request $request, SanPham $sanpham)
    {
        // Quy tắc xác thực dữ liệu
        $rules = [
            'masanpham'    => 'required|string|max:10|unique:sanpham,masanpham,' . $sanpham->masanpham . ',masanpham',
            'idhang'       => 'required|string|max:10|exists:hang,mahang',
            'tensanpham'   => 'required|string|max:255',
            'donvitinh'    => 'required|string|max:50',
            'dongia'       => 'required|numeric|min:0',
            'soluongton'   => 'required|integer|min:0',
            'anhsanpham'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('sanpham.edit', $sanpham->masanpham)
                ->withInput()
                ->withErrors($validator);
        }

        // Xử lý upload hình ảnh nếu có
        if ($request->hasFile('anhsanpham')) {
            // Xóa hình ảnh cũ nếu tồn tại và không phải là 'default.jpg'
            if ($sanpham->anhsanpham && $sanpham->anhsanpham != 'default.jpg') {
                Storage::delete('public/uploads/sanpham/' . $sanpham->anhsanpham);
            }

            $image = $request->file('anhsanpham');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sanpham'), $imageName);
        } else {
            $imageName = $sanpham->anhsanpham;
        }
        // Cập nhật sản phẩm
        $sanpham->update([
            'masanpham'    => $request->masanpham,
            'idhang'       => $request->idhang,
            'tensanpham'   => $request->tensanpham,
            'donvitinh'    => $request->donvitinh,
            'dongia'       => $request->dongia,
            'soluongton'   => $request->soluongton,
            'anhsanpham'   => $imageName,
        ]);

        return redirect()->route('sanpham.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Xóa sản phẩm khỏi cơ sở dữ liệu.
     */
    public function destroy(SanPham $sanpham)
    {
        // Xóa hình ảnh nếu tồn tại
        if ($sanpham->anhsanpham && $sanpham->anhsanpham != 'default.jpg') {
            Storage::delete(public_path('uploads/sanpham/' . $sanpham->anhsanpham));
        }

        // Xóa sản phẩm
        $sanpham->delete();

        return redirect()->route('sanpham.index')
            ->with('success', 'Sản phẩm đã được xóa thành công.');
    }
}
