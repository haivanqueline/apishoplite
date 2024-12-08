<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    // Hiển thị danh sách giảng viên
    public function index()
    {
        $active_menu = 'lecturers';
        $lecturers = Lecturer::paginate(10); // Phân trang 10 giảng viên mỗi trang
        return view('backend.lecturers.index', compact('lecturers', 'active_menu'));
    }

    // Hiển thị form tạo giảng viên mới
    public function create()
    {
        $active_menu = 'lecturers'; // Gán giá trị cho biến active_menu
        return view('backend.lecturers.create', compact('active_menu'));
    }

    // Hiển thị form chỉnh sửa giảng viên
    public function edit($id)
    {
        $active_menu = 'lecturers'; // Gán giá trị cho biến active_menu
        $lecturer = Lecturer::findOrFail($id); // Tìm giảng viên theo ID
        return view('backend.lecturers.edit', compact('lecturer', 'active_menu'));
    }

    // Xử lý thêm giảng viên mới
    public function store(Request $request)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
        'magv' => 'required|string|max:255|unique:lecturers',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:lecturers',
        'phone_number' => 'nullable|string',
        'degree' => 'nullable|string',
        'biography' => 'nullable|string',
        'faculty' => 'required|string|max:255',
        'major' => 'required|string|max:255',
        'specialization' => 'nullable|string|max:255',
    ]);

    // Tạo user cho giảng viên
    $user = User::create([
        'full_name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('phone_number')), // Mật khẩu là số điện thoại đã được mã hóa
        'role' => 'lecturer', // Vai trò giảng viên
        'status' => 'active', // Trạng thái người dùng
        'phone' => $request->input('phone_number'), // Số điện thoại của giảng viên
    ]);

    // Tạo giảng viên mới và gán user_id là ID của user vừa tạo
    $lecturer = Lecturer::create([
        'magv' => $request->input('magv'),
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone_number' => $request->input('phone_number'),
        'degree' => $request->input('degree'),
        'biography' => $request->input('biography'),
        'faculty' => $request->input('faculty'),
        'major' => $request->input('major'),
        'specialization' => $request->input('specialization'),
        'user_id' => $user->id,  // Gán user_id của giảng viên từ người dùng đã tạo
    ]);

    // Quay lại trang danh sách giảng viên
    return redirect()->route('lecturers.index')->with('success', 'Tạo giảng viên thành công!');
}


    // Xử lý cập nhật giảng viên
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu nhập vào
        $request->validate([
            'magv' => 'required|string|max:255|unique:lecturers,magv,' . $id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:lecturers,email,' . $id,
            'phone_number' => 'nullable|string',
            'degree' => 'nullable|string',
            'biography' => 'nullable|string',
            'faculty' => 'required|string|max:255',
            'major' => 'required|string|max:255',
            'specialization' => 'nullable|string|max:255',
        ]);

        // Tìm giảng viên theo ID
        $lecturer = Lecturer::findOrFail($id);

        // Tìm người dùng tương ứng với giảng viên
        $user = $lecturer->user;

        // Cập nhật thông tin giảng viên
        $lecturer->update($request->all());

        // Cập nhật thông tin người dùng
        if ($user) {
            $user->update([
                'full_name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone_number'), // Cập nhật số điện thoại
            ]);

            // Nếu số điện thoại thay đổi, cập nhật mật khẩu
            if ($user->phone !== $request->input('phone_number')) {
                $user->update([
                    'password' => Hash::make($request->input('phone_number')) // Mật khẩu là số điện thoại, đã mã hóa
                ]);
            }
        }

        // Quay lại trang danh sách giảng viên
        return redirect()->route('lecturers.index')->with('success', 'Cập nhật giảng viên thành công!');
    }

    // Xử lý xóa giảng viên
    public function destroy($id)
    {
        // Tìm giảng viên theo ID
        $lecturer = Lecturer::findOrFail($id);

        // Xóa giảng viên
        $lecturer->delete();

        // Quay lại trang danh sách giảng viên
        return redirect()->route('lecturers.index')->with('success', 'Giảng viên đã được xóa!');
    }
}
