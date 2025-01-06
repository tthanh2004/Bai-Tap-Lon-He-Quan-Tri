<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\HoaDon; // Đảm bảo viết hoa đúng
use App\Models\ChiTietHoaDon; // Đảm bảo viết hoa đúng
use App\Models\KhachHang; // Thêm nếu chưa có
use App\Models\NhanVien; // Thêm nếu chưa có
use App\Models\TheTichDiem; // Thêm nếu chưa có
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm cho cửa hàng người dùng.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Tìm kiếm sản phẩm
        $query = SanPham::with('hang');

        if ($search) {
            $query->where('masanpham', 'like', "%$search%")
                ->orWhere('tensanpham', 'like', "%$search%");
        }

        $sanpham = $query->orderBy('created_at', 'DESC')->paginate(12); // Hiển thị 12 sản phẩm mỗi trang

        return view('shop.index', compact('sanpham', 'search'));
    }

    /**
     * Hiển thị chi tiết sản phẩm.
     */
    public function show(SanPham $sanpham)
    {
        return view('shop.product', compact('sanpham'));
    }

    /**
     * Hiển thị giỏ hàng.
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        return view('shop.cart', compact('cart'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng.
     */
    public function addToCart(Request $request, SanPham $sanpham)
    {
        $quantity = $request->input('quantity', 1);

        $cart = Session::get('cart', []);

        if (isset($cart[$sanpham->masanpham])) {
            $cart[$sanpham->masanpham]['quantity'] += $quantity;
        } else {
            $cart[$sanpham->masanpham] = [
                'sanpham' => $sanpham,
                'quantity' => $quantity,
            ];
        }

        Session::put('cart', $cart);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng.']);
        }

        return redirect()->route('shop.cart')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    /**
     * Loại bỏ sản phẩm khỏi giỏ hàng.
     */
    public function removeFromCart(SanPham $sanpham)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$sanpham->masanpham])) {
            unset($cart[$sanpham->masanpham]);
            Session::put('cart', $cart);
            return redirect()->route('shop.cart')->with('success', 'Đã loại bỏ sản phẩm khỏi giỏ hàng.');
        }

        return redirect()->route('shop.cart')->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    /**
     * Hiển thị trang thanh toán.
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lấy danh sách khách hàng và nhân viên
        $khachhangs = \App\Models\KhachHang::all();
        $nhanviens = \App\Models\NhanVien::all();

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['sanpham']->dongia * $item['quantity'];
        }

        return view('shop.checkout', compact('cart', 'khachhangs', 'nhanviens', 'total'));
    }

    /**
     * Xử lý thanh toán.
     */
    public function processCheckout(Request $request)
    {
        // Xác thực thông tin thanh toán
        $request->validate([
            'idkhachhang'    => 'required|exists:khachhang,makhachhang',
            'idnhanvien'     => 'required|exists:nhanvien,manhanvien',
            'address'        => 'required|string|max:500',
            'use_point_card' => 'nullable|boolean',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Bắt đầu giao dịch
        DB::beginTransaction();

        try {
            // Lấy thông tin khách hàng và nhân viên
            $khachhang = KhachHang::findOrFail($request->idkhachhang);
            $nhanvien = NhanVien::findOrFail($request->idnhanvien);

            // Tính tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['sanpham']->dongia * $item['quantity'];
            }

            // Xử lý thẻ tích điểm
            $pointsUsed = 0;
            $totalAfterDiscount = $total;
            $discountPercentage = 0;

            if ($request->has('use_point_card') && $request->use_point_card) {
                // Giảm 10% nếu số điểm >= 100
                $totalPoints = $khachhang->theTichDiems()->sum('diemtichluy');

                if ($totalPoints >= 100) {
                    $discountPercentage = 10; // 10%
                    $discountAmount = ($discountPercentage / 100) * $total;
                    $totalAfterDiscount = $total - $discountAmount;

                    // Giảm điểm sau khi sử dụng
                    $pointsUsed = 100; // Giảm 100 điểm
                    $this->deductPoints($khachhang, $pointsUsed);
                } else {
                    // Nếu điểm không đủ, throw exception
                    throw new \Exception('Bạn cần ít nhất 100 điểm để được giảm 10%.');
                }
            }

            // Tạo mã hóa đơn mới (đảm bảo duy nhất)
            do {
                $mahoadon = 'HD' . time() . rand(1000, 9999);
            } while (HoaDon::where('mahoadon', $mahoadon)->exists());

            // Tạo hóa đơn mới
            $hoadon = HoaDon::create([
                'mahoadon'      => $mahoadon,
                'idkhachhang'   => $khachhang->makhachhang,
                'idnhanvien'    => $nhanvien->manhanvien,
                'ngaylaphoadon' => now(),
                'sudungTTD'     => $pointsUsed > 0 ? 1 : 0,
                'tongtien'      => $totalAfterDiscount,
                'address'       => $request->address, // Lưu địa chỉ giao hàng
            ]);

            // Tạo chi tiết hóa đơn
            foreach ($cart as $item) {
                $sanpham = $item['sanpham'];
                $quantity = $item['quantity'];
                $giamgia = 0; // Bạn có thể thêm logic giảm giá tại đây
                $thanhtien = ($sanpham->dongia * $quantity) - ($sanpham->dongia * $quantity * ($giamgia / 100));

                if ($sanpham->soluongton < $quantity) {
                    throw new \Exception('Số lượng sản phẩm ' . $sanpham->tensanpham . ' không đủ.');
                }

                // Giảm số lượng tồn kho
                $sanpham->soluongton -= $quantity;
                $sanpham->save();

                // Tạo chi tiết hóa đơn
                ChiTietHoaDon::create([
                    'idhoadon'     => $mahoadon,
                    'idsanpham'    => $sanpham->masanpham,
                    'soluongmua'   => $quantity,
                    'giamgia'      => $giamgia,
                    'thanhtien'    => $thanhtien,
                ]);
            }

            // Commit giao dịch
            DB::commit();

            // Xóa giỏ hàng sau khi thanh toán thành công
            Session::forget('cart');

            // Chuyển hướng đến trang hiển thị hóa đơn
            return redirect()->route('shop.invoice', ['mahoadon' => $mahoadon])->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            // Rollback giao dịch nếu có lỗi
            DB::rollBack();

            Log::error('Checkout failed: ' . $e->getMessage());

            return redirect()->route('shop.cart')->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }


    protected function deductPoints($khachhang, $pointsUsed)
    {
        // Lấy các thẻ tích điểm của khách hàng, sắp xếp theo ngày tạo (cũ trước)
        $theTichDiems = $khachhang->theTichDiems()->orderBy('created_at', 'asc')->get();

        $remainingPoints = $pointsUsed;

        foreach ($theTichDiems as $theDiem) {
            if ($remainingPoints <= 0) {
                break;
            }

            if ($theDiem->diemtichluy >= $remainingPoints) {
                $theDiem->diemtichluy -= $remainingPoints;
                $theDiem->save();
                $remainingPoints = 0;
            } else {
                $remainingPoints -= $theDiem->diemtichluy;
                $theDiem->diemtichluy = 0;
                $theDiem->save();
            }
        }
    }

    /**
     * Hiển thị chi tiết hóa đơn.
     */
    public function showInvoice($mahoadon)
    {
        // Lấy hóa đơn cùng với chi tiết hóa đơn, thông tin sản phẩm, khách hàng, nhân viên và thẻ tích điểm
        $hoadon = HoaDon::with([
            'chitiethoadon.sanpham',
            'khachhang.theTichDiems',
            'nhanvien'
        ])->where('mahoadon', $mahoadon)->firstOrFail();

        return view('shop.invoice', compact('hoadon'));
    }

    /**
     * Xuất hóa đơn dưới dạng PDF.
     */
    public function exportInvoicePdf($mahoadon)
    {
        // Lấy hóa đơn cùng với chi tiết hóa đơn và thông tin sản phẩm, khách hàng, nhân viên
        $hoadon = HoaDon::with(['chitiethoadon.sanpham', 'khachhang', 'nhanvien'])->where('mahoadon', $mahoadon)->firstOrFail();

        $pdf = PDF::loadView('shop.invoice_pdf', compact('hoadon'));

        // Tải xuống PDF với tên file là mahoadon.pdf
        return $pdf->download('HoaDon_' . $mahoadon . '.pdf');
    }

    /**
     * API để lấy số điểm của khách hàng.
     */
    public function getKhachHangPoints($makhachhang)
    {
        // Tìm khách hàng theo mã khách hàng
        $khachhang = KhachHang::with('theTichDiems')->findOrFail($makhachhang);

        // Tính tổng điểm từ tất cả các thẻ tích điểm của khách hàng
        $totalPoints = $khachhang->theTichDiems->diemtichluy;

        return response()->json(['total_points' => $totalPoints]);
    }
}
