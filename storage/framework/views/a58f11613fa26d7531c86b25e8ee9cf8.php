
<?php $__env->startSection('content'); ?>

<div class="content">
    <?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <h2 class="intro-y text-lg font-medium mt-10">
        Danh sách Giảng viên
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="<?php echo e(route('lecturers.create')); ?>" class="btn btn-primary shadow-md mr-2">Thêm Giảng viên</a>
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
                    <?php $__currentLoopData = $lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="intro-x">
                        <td><?php echo e($lecturer->magv); ?></td>
                        <td><?php echo e($lecturer->name); ?></td>
                        <td><?php echo e($lecturer->email); ?></td>
                        <td class="text-center"><?php echo e($lecturer->phone_number); ?></td>
                        <td><?php echo e($lecturer->faculty); ?></td>
                        <td><?php echo e($lecturer->major); ?></td>
                        <td class="text-center"><?php echo e($lecturer->degree); ?></td>
                        <td class="text-center"><?php echo e($lecturer->user ? $lecturer->user->name : 'Chưa có người dùng'); ?></td> <!-- Hiển thị tên người dùng liên kết -->
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a href="<?php echo e(route('lecturers.edit', $lecturer->id)); ?>" class="flex items-center mr-3"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <form action="<?php echo e(route('lecturers.destroy', $lecturer->id)); ?>" method="post" style="display:inline-block;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('delete'); ?>
                                    <a class="flex items-center text-danger dltBtn" data-id="<?php echo e($lecturer->id); ?>" href="javascript:;"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <!-- Kết thúc: Data List -->

        <!-- Bắt đầu: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <?php echo e($lecturers->links('vendor.pagination.tailwind')); ?>

            </nav>
        </div>
        <!-- Kết thúc: Pagination -->
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laravel\shoplite-main\resources\views/backend/lecturers/index.blade.php ENDPATH**/ ?>