@extends('backend.layouts.master')
@section('content')
<div class="content">
@include('backend.layouts.notification')
    <h2 class="intro-y text-lg font-medium mt-10">
        Danh sách bài học
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{route('baihoc.create')}}" class="btn btn-primary shadow-md mr-2">Thêm bài học</a>
            
            {{-- <div class="hidden md:block mx-auto text-slate-500">Hiển thị trang {{$blogs->currentPage()}} trong {{$blogs->lastPage()}} trang</div> --}}
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <form action="{{route('blog.search')}}" method = "get">
                        @csrf
                        <input type="text" name="datasearch" class="ipsearch form-control w-56 box pr-10" placeholder="Search...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i> 
                    </form>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">TÊN BÀI HỌC</th>
                        <th class="whitespace-nowrap">VIDEO</th>
                        <th class=" whitespace-nowrap">KHÓA HỌC</th>
                        <th class=" whitespace-nowrap">TRẠNG THÁI</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach($baihoc as $item)
                    <tr class="intro-x">
                        <td>
                            <p target="_blank" href="" class="font-medium whitespace-nowrap">{{$item->ten_bai_hoc}}</p> 
                        </td>
                        <td class="w-40">
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <video 
                                        class="tooltip"
                                        width="100%"
                                        height="100%"
                                        controls
                                    >
                                        <source src="{{ $item->video }}" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ video.
                                    </video>
                                </div>
                            </div>
                        </td>
                        
                        <td>
                            @foreach ($khoahoc as $item2)
                                @if ($item2->id == $item->id_khoahoc)
                                    <p target="_blank" href="" class="font-medium whitespace-nowrap">{{$item2->ten_khoa_hoc}}</p> 
                                @endif
                            @endforeach
                        </td>
                        
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a href="{{route('baihoc.edit',$item->id)}}" class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <form action="{{route('baihoc.destroy',$item->id)}}" method = "post">
                                    @csrf
                                    @method('DELETE')
                                    <a class="flex items-center text-danger dltBtn" data-id="{{$item->id}}" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </form>
                               
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            
        </div>
    </div>
    <!-- END: HTML Table Data -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                {{-- {{$blogs->links('vendor.pagination.tailwind')}} --}}
            </nav>
           
        </div>
        <!-- END: Pagination -->
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/vendor/js/bootstrap-switch-button.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $('.dltBtn').click(function(e)
    {
        var form=$(this).closest('form');
        var dataID = $(this).data('id');
        e.preventDefault();
        Swal.fire({
            title: 'Bạn có chắc muốn xóa không?',
            text: "Bạn không thể lấy lại dữ liệu sau khi xóa",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, tôi muốn xóa!'
            }).then((result) => {
            if (result.isConfirmed) {
                // alert(form);
                form.submit();
                // Swal.fire(
                // 'Deleted!',
                // 'Your file has been deleted.',
                // 'success'
                // );
            }
        });
    });
</script>
<script>
    $(".ipsearch").on('keyup', function (e) {
        e.preventDefault();
        if (e.key === 'Enter' || e.keyCode === 13) {
           
            // Do something
            var data=$(this).val();
            var form=$(this).closest('form');
            if(data.length > 0)
            {
                form.submit();
            }
            else
            {
                  Swal.fire(
                    'Không tìm được!',
                    'Bạn cần nhập thông tin tìm kiếm.',
                    'error'
                );
            }
        }
    });
    $("[name='toogle']").change(function() {
        var mode = $(this).prop('checked');
        var id=$(this).val();
        $.ajax({
            url:"{{route('blog.status')}}",
            type:"post",
            data:{
                _token:'{{csrf_token()}}',
                mode:mode,
                id:id,
            },
            success:function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.msg,
                showConfirmButton: false,
                timer: 1000
                });
                console.log(response.msg);
            }
            
        });
  
});  
    
</script>
 
@endsection