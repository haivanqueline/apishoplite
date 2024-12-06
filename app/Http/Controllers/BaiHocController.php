<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BaiHoc;
use App\Models\KhoaHoc;


class BaiHocController extends Controller
{
    protected $pagesize;
    public function __construct( )
    {
        $this->pagesize = env('NUMBER_PER_PAGE','20');
        $this->middleware('auth');
        
    }
    public function index(){
        $func = "baihoc_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $active_menu="baihoc_list";
        $breadcrumb = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Danh sách bài học</li>';
        $baihoc = BaiHoc::orderBy('id','DESC')->paginate($this->pagesize);
        $khoahoc = KhoaHoc::all();

        return view('backend.baihoc.index',compact('khoahoc','baihoc','breadcrumb','active_menu'));
    }
    public function create()
    {
        $func = "baihoc_list";
        if(!$this->check_function($func))
        {
            return redirect()->route('unauthorized');
        }
        $khoahoc = KhoaHoc::all();
        $data['active_menu']="baihoc_list";
        $data['breadcrumb'] = '
        <li class="breadcrumb-item"><a href="#">/</a></li>
        <li class="breadcrumb-item  " aria-current="page"><a href="'.route('khoahoc.index').'">bài học</a></li>
        <li class="breadcrumb-item active" aria-current="page"> tạo bài học </li>';
        return view('backend.baihoc.create', $data, compact('khoahoc'));
  
    }
    public function store(Request $request){
        // Xác thực dữ liệu nhập vào
    $request->validate([
        'ten_bai_hoc' => 'required|string|max:255',
        'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // Các định dạng video và kích thước tối đa (100MB)
        'id_khoahoc' => 'required|string',
    ]);

    // Lấy tất cả dữ liệu từ yêu cầu
    $requestData = $request->all();

    $helpController = new \App\Http\Controllers\FilesController();
    $requestData['video'] = $helpController->store($request->file('video'));

    // Lưu dữ liệu vào cơ sở dữ liệu
    BaiHoc::create($requestData);
    return redirect()->route('baihoc.index')->with('thongbao', 'Tạo học phần thành công.');
}

public function edit(string $id)
{
    $func = "baihoc_list";
    if(!$this->check_function($func))
    {
        return redirect()->route('unauthorized');
    }
    $baihoc = BaiHoc::findOrFail($id); // Lấy bản ghi theo ID
    $khoahoc = KhoaHoc::all();

    $active_menu="baihoc_list";
    $breadcrumb = '
    <li class="breadcrumb-item"><a href="#">/</a></li>
    <li class="breadcrumb-item  " aria-current="page"><a href="'.route('blog.index').'">bài học</a></li>
    <li class="breadcrumb-item active" aria-current="page">sửa bài học</li>';
    return view('backend.baihoc.edit',compact('khoahoc','baihoc','breadcrumb','active_menu'));
}

public function update(Request $request, $id)
{
    // Xác thực dữ liệu nhập vào
    $request->validate([
        'ten_bai_hoc' => 'required|string|max:255',
        'video' => 'required|mimes:mp4,mov,avi,wmv|max:102400', // Các định dạng video và kích thước tối đa (100MB)
        'id_khoahoc' => 'required|string',
    ]);

    $baihoc = BaiHoc::findOrFail($id);

    // Lấy tất cả dữ liệu từ yêu cầu
    $requestData = $request->all();

    $helpController = new \App\Http\Controllers\FilesController();
    $requestData['video'] = $helpController->store($request->file('video'));

    $baihoc->update($requestData);
    return redirect()->route('baihoc.index')->with('thongbao', 'Cập nhật học phần thành công.');
}

    public function destroy($id)
    {
        $module = BaiHoc::findOrFail($id);
        $module->delete();
        return redirect()->route('baihoc.index')->with('thongbao', 'Xóa bài học thành công.');
    }
}