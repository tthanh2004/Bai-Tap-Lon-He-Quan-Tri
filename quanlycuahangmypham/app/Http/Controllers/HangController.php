<?php

namespace App\Http\Controllers;

use App\Models\Hang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Hang::query();

        if ($search) {
            $query->where('mahang', 'like', "$search%")
                ->orWhere('tenhang', 'like', "$search%");
        }

        $hang = $query->orderBy('created_at', 'DESC')->paginate(10);

        return view('hang.list', [
            'hang' => $hang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'mahang'   => 'required|string|max:10|unique:hang,mahang',
            'tenhang'        => 'required|string|max:255',
            'diachi'       => 'required|string|max:500',
        ];

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('hang.create')->withInput()->withErrors($validator);
        }

        // Lưu dữ liệu vào bảng Courses
        $Hang = new Hang();
        $Hang->mahang  = $request->mahang;
        $Hang->tenhang       = $request->tenhang;
        $Hang->diachi      = $request->diachi;

        $Hang->save();

        return redirect()->route('hang.index')->with('success', 'Course added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hang $hang)
    {
        return view('hang.show', compact('hang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hang $hang)
    {
        return view('hang.edit', compact('hang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hang $hang)
    {

        // Quy tắc xác thực
        $rules = [
            'mahang'   => 'required|string|max:10|unique:hang,mahang',
            'tenhang'        => 'required|string|max:255',
            'diachi'       => 'required|string|max:500',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('hang.edit', $hang->id)->withInput()->withErrors($validator);
        }

        // Cập nhật thông tin khóa học
        $hang->mahang  = $request->mahang;
        $hang->tenhang       = $request->tenhang;
        $hang->diachi      = $request->diachi;

        $hang->save();

        return redirect()->route('hang.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hang $hang)
    {
        $hang->delete();

        return redirect()->route('hang.index')->with('success', 'Course deleted successfully.');
    }
}
