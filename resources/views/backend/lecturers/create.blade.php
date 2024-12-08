@extends('backend.layouts.master')
@section('content')

<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Thêm Giảng viên
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <form action="{{ route('lecturers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="magv" class="form-label">Mã Giảng viên <span class="text-danger">*</span></label>
                    <input type="text" name="magv" id="magv" class="form-control" placeholder="Nhập mã giảng viên" required>
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Tên Giảng viên <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên giảng viên" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Nhập số điện thoại" required>
                </div>

                <div class="mb-4">
                    <label for="faculty" class="form-label">Khoa</label>
                    <input type="text" name="faculty" id="faculty" class="form-control" placeholder="Nhập tên khoa">
                </div>

                <div class="mb-4">
                    <label for="major" class="form-label">Chuyên ngành</label>
                    <input type="text" name="major" id="major" class="form-control" placeholder="Nhập chuyên ngành">
                </div>

                <div class="mb-4">
                    <label for="degree" class="form-label">Học vị</label>
                    <select name="degree" id="degree" class="form-select">
                        <option value="">Chọn học vị</option>
                        <option value="Cử nhân">Cử nhân</option>
                        <option value="Thạc sĩ">Thạc sĩ</option>
                        <option value="Tiến sĩ">Tiến sĩ</option>
                        <option value="Giáo sư">Giáo sư</option>
                    </select>
                </div>

                <div class="mt-5 text-right">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('lecturers.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
