<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\Hoadon;
use App\Models\ChiTietHoadon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('shop.checkout', compact('cart'));
    }

    /**
     * Xử lý thanh toán.
     */
    public function processCheckout(Request $request)
    {
        // Xác thực thông tin thanh toán
        $request->validate([
            'address' => 'required|string|max:500',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Bắt đầu giao dịch
        DB::beginTransaction();

        try {
            // Tính tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['sanpham']->dongia * $item['quantity'];
            }

            // Tạo mã hóa đơn mới (ví dụ: tự động tăng hoặc sử dụng UUID)
            $mahoadon = 'HD' . time(); // Ví dụ đơn giản, bạn có thể sử dụng UUID hoặc cách khác để tạo mã hóa đơn

            // Lấy idnhanvien từ người dùng đã đăng nhập (nếu có)
            $idnhanvien = Auth::user()->idnhanvien ?? null; // Điều chỉnh theo cấu trúc User của bạn

            // Tạo hóa đơn mới
            $hoadon = Hoadon::create([
                'mahoadon'      => $mahoadon,
                'idkhachhang'   => Auth::id(), // Giả sử 'idkhachhang' là 'user_id'
                'idnhanvien'    => Auth::id(),
                'ngaylaphoadon' => now(),
                'sudungTTD'     => true,
                'tongtien'      => $total,
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
                ChiTietHoadon::create([
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

            return redirect()->route('shop.index')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            // Rollback giao dịch nếu có lỗi
            DB::rollBack();

            return redirect()->route('shop.cart')->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }
    }
}
