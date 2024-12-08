<?php

// app/Http/Controllers/Api/ApiLecturerController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use Illuminate\Http\Request;

class APILecturerController extends Controller
{
    // Phương thức để lấy tất cả giảng viên
    public function index()
    {
        // Lấy tất cả giảng viên từ cơ sở dữ liệu
        $lecturers = Lecturer::all();

        // Trả về dữ liệu giảng viên dưới dạng JSON
        return response()->json($lecturers, 200);
    }

    // Phương thức để lấy giảng viên theo ID
    public function show($id)
    {
        // Tìm giảng viên theo ID
        $lecturer = Lecturer::find($id);

        // Kiểm tra nếu không tìm thấy giảng viên
        if (!$lecturer) {
            return response()->json(['error' => 'Lecturer not found'], 404);
        }

        // Trả về dữ liệu giảng viên dưới dạng JSON
        return response()->json($lecturer, 200);
    }
}
