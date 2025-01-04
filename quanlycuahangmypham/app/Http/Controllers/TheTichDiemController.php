<?php

namespace App\Http\Controllers;

use App\Models\TheTichDiem;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TheTichDiemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Khởi tạo query
        $query = Thetichdiem::with('khachhang');

        // Thêm điều kiện tìm kiếm nếu có
        if ($search) {
            $query->where('mathetichdiem', 'like', "$search%")
                ->orWhere('idkhachhang', 'like', "$search%");
        }

        // Lấy dữ liệu với phân trang
        $thetichdiems = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Giữ lại từ khóa tìm kiếm trong phân trang
        $thetichdiems->appends(['search' => $search]);

        // Truyền dữ liệu đến view
        return view('thetichdiem.list', [
            'thetichdiems' => $thetichdiems,
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $khachhangs = KhachHang::all();
        return view('thetichdiem.create', compact('khachhangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'mathetichdiem'   => 'required|string|max:10|unique:thetichdiems,mathetichdiem',
            'diemtichluy'        => 'required|integer',
            'idkhachhang'        => 'required|string|max:255',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('thetichdiem.create')->withInput()->withErrors($validator);
        }

        Thetichdiem::create($request->all());
        return redirect()->route('thetichdiem.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(thetichdiem $thetichdiem)
    {
        return view('thetichdiem.show', compact('thetichdiem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(thetichdiem $thetichdiem)
    {
        $khachhangs = Khachhang::all();
        return view('thetichdiem.edit', compact('thetichdiem', 'khachhangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, thetichdiem $thetichdiem)
    {

        // Quy tắc xác thực
        $rules = [
            'mathetichdiem'   => 'required|string|max:10|unique:thetichdiems,mathetichdiem',
            'diemtichluy'        => 'required|integer',
            'idkhachhang'        => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('thetichdiem.edit', $thetichdiem->id)->withInput()->withErrors($validator);
        }

        $thetichdiem->update($request->all());

        return redirect()->route('thetichdiem.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(thetichdiem $thetichdiem)
    {
        $thetichdiem->delete();

        return redirect()->route('thetichdiem.index')->with('success', 'Course deleted successfully.');
    }
}
