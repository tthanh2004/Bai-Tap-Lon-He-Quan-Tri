<?php

namespace App\Http\Controllers;

use App\Models\khachhang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class khachhangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = khachhang::query();

        if ($search) {
            $query->where('makhachhang', 'like', "$search%")
                ->orWhere('hotenkh', 'like', "$search%");
        }

        $khachhangs = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('khachhang.list', [
            'khachhang' => $khachhangs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('khachhang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'makhachhang'   => 'required|string|max:10|unique:khachhang,makhachhang',
            'hotenkh'        => 'required|string|max:255',
            'diachi'       => 'required|string|max:500',
            'sodienthoai'  => 'required|string|max:20|regex:/^[0-9\s\-()+]+$/',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('khachhang.create')->withInput()->withErrors($validator);
        }

        // Lưu dữ liệu vào bảng Courses
        $khachhang = new KhachHang();
        $khachhang->makhachhang  = $request->makhachhang;
        $khachhang->hotenkh       = $request->hotenkh;
        $khachhang->diachi     = $request->diachi;
        $khachhang->sodienthoai = $request->sodienthoai;


        $khachhang->save();

        return redirect()->route('khachhang.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(khachhang $khachhang)
    {
        return view('khachhang.show', compact('khachhang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(khachhang $khachhang)
    {
        return view('khachhang.edit', compact('khachhang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, khachhang $khachhang)
    {

        // Quy tắc xác thực
        $rules = [
            'makhachhang'   => 'required|string|max:10|unique:khachhang,makhachhang',
            'hotenkh'        => 'required|string|max:255',
            'diachi'       => 'required|string|max:500',
            'sodienthoai'  => 'required|string|max:20|regex:/^[0-9\s\-()+]+$/',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('khachhang.edit', $khachhang->id)->withInput()->withErrors($validator);
        }

        // Cập nhật thông tin khóa học
        $khachhang->makhachhang  = $request->makhachhang;
        $khachhang->hotenkh       = $request->hotenkh;
        $khachhang->diachi      = $request->diachi;
        $khachhang->sodienthoai = $request->sodienthoai;

        $khachhang->save();

        return redirect()->route('khachhang.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(khachhang $khachhang)
    {
        $khachhang->delete();

        return redirect()->route('khachhang.index')->with('success', 'Course deleted successfully.');
    }
}
