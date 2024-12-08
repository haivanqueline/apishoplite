@extends('backend.layouts.master')
@section('content')

<div class="content">
    @include('backend.layouts.notification')
    <h2 class="intro-y text-lg font-medium mt-10">
        Danh sách Giảng viên
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('lecturers.create') }}" class="btn btn-primary shadow-md mr-2">Thêm Giảng viên</a>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <!-- Tìm kiếm, nếu có -->
                </div>
            </div>
        </div>

        <!-- Bắt đầu: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Mã GV</th>
                        <th class="whitespace-nowrap">Tên</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="text-center whitespace-nowrap">Số điện thoại</th>
                        <th class="whitespace-nowrap">Khoa</th>
                        <th class="whitespace-nowrap">Chuyên ngành</th>
                        <th class="text-center whitespace-nowrap">Học vị</th>
                        <th class="text-center whitespace-nowrap">Người dùng</th> <!-- Cột thêm user_id -->
                        <th class="text-center whitespace-nowrap">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lecturers as $lecturer)
                    <tr class="intro-x">
                        <td>{{ $lecturer->magv }}</td>
                        <td>{{ $lecturer->name }}</td>
                        <td>{{ $lecturer->email }}</td>
                        <td class="text-center">{{ $lecturer->phone_number }}</td>
                        <td>{{ $lecturer->faculty }}</td>
                        <td>{{ $lecturer->major }}</td>
                        <td class="text-center">{{ $lecturer->degree }}</td>
                        <td class="text-center">{{ $lecturer->user ? $lecturer->user->name : 'Chưa có người dùng' }}</td> <!-- Hiển thị tên người dùng liên kết -->
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a href="{{ route('lecturers.edit', $lecturer->id) }}" class="flex items-center mr-3"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <form action="{{ route('lecturers.destroy', $lecturer->id) }}" method="post" style="display:inline-block;">
                                    @csrf
                                    @method('delete')
                                    <a class="flex items-center text-danger dltBtn" data-id="{{ $lecturer->id }}" href="javascript:;"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Kết thúc: Data List -->

        <!-- Bắt đầu: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                {{ $lecturers->links('vendor.pagination.tailwind') }}
            </nav>
        </div>
        <!-- Kết thúc: Pagination -->
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Xác nhận xóa
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            e.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc muốn xóa không?',
                text: "Bạn không thể hoàn tác sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, xóa nó!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
