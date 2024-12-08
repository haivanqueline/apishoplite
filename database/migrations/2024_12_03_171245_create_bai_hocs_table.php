<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bai_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_bai_hoc');
            $table->text('mo_ta')->nullable();
            $table->foreignId('id_khoahoc')->constrained('khoa_hocs');
            $table->string('video')->nullable(); // đường dẫn đến file video
            $table->longText('noi_dung')->nullable(); // nội dung văn bản
            $table->json('tai_lieu')->nullable(); // tài liệu đính kèm
            $table->integer('thu_tu')->default(0);
            $table->integer('thoi_luong')->nullable(); // thời lượng tính bằng phút
            $table->integer('luot_xem')->default(0);
            $table->enum('trang_thai', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_hocs');
    }
};