<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhoaHoc;


class KhoaHocController extends Controller
{
    protected $pagesize;
    public function __construct( )
    {
        $this->pagesize = env('NUMBER_PER_PAGE','20');
        $this->middleware('auth');
        
    }
    public function index()
    {
        $func = "khoahoc_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }

        $active_menu="khoahoc_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Danh sách khóa học </li>';
        $khoahoc = KhoaHoc::orderBy('id','DESC')->paginate($this->pagesize);
        // categories
        return view('backend.khoahoc.index',compact('khoahoc','breadcrumb','active_menu'));

    }
    public function create()
    {
        $func = "khoahoc_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $data['active_menu']="khoahoc_list";
        $data['breadcrumb'] = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item  " aria-current="page"><a href="'.route('khoahoc.index').'">khóa học</a></li>
        <li class="breadcrumb-item active" aria-current="page"> tạo khóa học </li>';
        return view('backend.khoahoc.create', $data);
  
    }
    public function store(Request $request){
            // Xác thực dữ liệu nhập vào
        $request->validate([
            'ten_khoa_hoc' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mota' => 'required|string',
        ]);

        // Lấy tất cả dữ liệu từ yêu cầu
        $requestData = $request->all();

        $helpController = new \App\Http\Controllers\FilesController();
        $requestData['image'] = $helpController->store($request->file('image'));

        // Lưu dữ liệu vào cơ sở dữ liệu
        KhoaHoc::create($requestData);
        return redirect()->route('khoahoc.index')->with('thongbao', 'Tạo học phần thành công.');
    }

    public function edit(string $id)
    {
        $func = "khoahoc_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $khoahoc = KhoaHoc::findOrFail($id); // Lấy bản ghi theo ID
        $active_menu="khoahoc_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item  " aria-current="page"><a href="'.route('blog.index').'">khóa học</a></li>
        <li class="breadcrumb-item active" aria-current="page">sửa khóa học</li>';
        return view('backend.khoahoc.edit',compact('khoahoc','breadcrumb','active_menu'));
    }

    public function update(Request $request, $id)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
        'ten_khoa_hoc' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'mota' => 'required|string',
    ]);

    // Tìm bản ghi theo ID
    $khoahoc = KhoaHoc::findOrFail($id);

    // Lấy tất cả dữ liệu từ yêu cầu
    $requestData = $request->all();

    // Xử lý tệp hình ảnh nếu có
    // if ($request->hasFile('photo')) {
    //     // Xóa tệp hình ảnh cũ nếu tồn tại
    //     if (Storage::disk('public')->exists(str_replace('storage/', '', $module->photo))) {
    //         Storage::disk('public')->delete(str_replace('storage/', '', $module->photo));
    //     }

    //     // Lưu tệp hình ảnh mới
    //     $fileName = time() . '_' . $request->file('photo')->getClientOriginalName();
    //     $path = $request->file('photo')->storeAs('module', $fileName, 'public');
    //     $requestData['photo'] = '/storage/' . $path; // Cập nhật đường dẫn tệp tin trong dữ liệu
    // } else {
    //     // Nếu không có tệp hình ảnh mới, giữ nguyên đường dẫn tệp cũ
    //     $requestData['photo'] = $module->photo;
    // }
    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $khoahoc->update($requestData);
    return redirect()->route('khoahoc.index')->with('thongbao', 'Cập nhật học phần thành công.');
}

    public function destroy($id)
    {
        $module = KhoaHoc::findOrFail($id);
        // if (Storage::disk('public')->exists(str_replace('storage/', '', $module->path))) {
        //     Storage::disk('public')->delete(str_replace('storage/', '', $module->path));
        // }
        $module->delete();
        return redirect()->route('khoahoc.index')->with('thongbao', 'Xóa học phần thành công.');
    }
}