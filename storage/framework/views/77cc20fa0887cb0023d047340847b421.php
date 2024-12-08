
<?php $__env->startSection('content'); ?>

<div class="content">
    <h2 class="intro-y text-lg font-medium mt-10">
        Chỉnh sửa Giảng viên
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <form action="<?php echo e(route('lecturers.update', $lecturer->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-4">
                    <label for="magv" class="form-label">Mã Giảng viên <span class="text-danger">*</span></label>
                    <input type="text" name="magv" id="magv" class="form-control" value="<?php echo e($lecturer->magv); ?>" readonly>
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Tên Giảng viên <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo e($lecturer->name); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo e($lecturer->email); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo e($lecturer->phone_number); ?>" required>
                </div>

                <div class="mb-4">
                    <label for="faculty" class="form-label">Khoa</label>
                    <input type="text" name="faculty" id="faculty" class="form-control" value="<?php echo e($lecturer->faculty); ?>">
                </div>

                <div class="mb-4">
                    <label for="major" class="form-label">Chuyên ngành</label>
                    <input type="text" name="major" id="major" class="form-control" value="<?php echo e($lecturer->major); ?>">
                </div>

                <div class="mb-4">
                    <label for="degree" class="form-label">Học vị</label>
                    <select name="degree" id="degree" class="form-select">
                        <option value="" <?php echo e($lecturer->degree == '' ? 'selected' : ''); ?>>Chọn học vị</option>
                        <option value="Cử nhân" <?php echo e($lecturer->degree == 'Cử nhân' ? 'selected' : ''); ?>>Cử nhân</option>
                        <option value="Thạc sĩ" <?php echo e($lecturer->degree == 'Thạc sĩ' ? 'selected' : ''); ?>>Thạc sĩ</option>
                        <option value="Tiến sĩ" <?php echo e($lecturer->degree == 'Tiến sĩ' ? 'selected' : ''); ?>>Tiến sĩ</option>
                        <option value="Giáo sư" <?php echo e($lecturer->degree == 'Giáo sư' ? 'selected' : ''); ?>>Giáo sư</option>
                    </select>
                </div>

                <div class="mt-5 text-right">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="<?php echo e(route('lecturers.index')); ?>" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laravel\shoplite-main\resources\views/backend/lecturers/edit.blade.php ENDPATH**/ ?>