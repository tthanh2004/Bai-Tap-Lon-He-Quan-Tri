<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = NhanVien::query();

        if ($search) {
            $query->where('manhanvien', 'like', "$search%")
                ->orWhere('hoten', 'like', "$search%");
        }

        $nhanviens = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('nhanvien.list', [
            'nhanvien' => $nhanviens,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nhanvien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'manhanvien'   => 'required|string|max:10|unique:nhanviens,manhanvien',
            'hoten'        => 'required|string|max:255',
            'gioitinh'     => 'required|in:Nam,Nữ,Khác',
            'ngaysinh'     => 'required|date|before:today',
            'diachi'       => 'required|string|max:500',
            'sodienthoai'  => 'required|string|max:20|regex:/^[0-9\s\-()+]+$/',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('nhanvien.create')->withInput()->withErrors($validator);
        }

        // Lưu dữ liệu vào bảng Courses
        $nhanvien = new NhanVien();
        $nhanvien->manhanvien  = $request->manhanvien;
        $nhanvien->hoten       = $request->hoten;
        $nhanvien->gioitinh    = $request->gioitinh;
        $nhanvien->ngaysinh    = $request->ngaysinh;
        $nhanvien->diachi      = $request->diachi;
        $nhanvien->sodienthoai = $request->sodienthoai;


        $nhanvien->save();

        return redirect()->route('nhanvien.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NhanVien $nhanvien)
    {
        return view('nhanvien.show', compact('nhanvien'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NhanVien $nhanvien)
    {
        return view('nhanvien.edit', compact('nhanvien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NhanVien $nhanvien)
    {

        // Quy tắc xác thực
        $rules = [
            'manhanvien'   => 'required|string|max:10|unique:nhanviens,manhanvien',
            'hoten'        => 'required|string|max:255',
            'gioitinh'     => 'required|in:Nam,Nữ,Khác',
            'ngaysinh'     => 'required|date|before:today',
            'diachi'       => 'required|string|max:500',
            'sodienthoai'  => 'required|string|max:20|regex:/^[0-9\s\-()+]+$/',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('nhanvien.edit', $nhanvien->id)->withInput()->withErrors($validator);
        }

        // Cập nhật thông tin khóa học
        $nhanvien->manhanvien  = $request->manhanvien;
        $nhanvien->hoten       = $request->hoten;
        $nhanvien->gioitinh    = $request->gioitinh;
        $nhanvien->ngaysinh    = $request->ngaysinh;
        $nhanvien->diachi      = $request->diachi;
        $nhanvien->sodienthoai = $request->sodienthoai;

        $nhanvien->save();

        return redirect()->route('nhanvien.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanVien $nhanvien)
    {
        $nhanvien->delete();

        return redirect()->route('nhanvien.index')->with('success', 'Course deleted successfully.');
    }
}
