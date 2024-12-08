<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('magv')->unique(); // Thêm trường magv
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('degree')->nullable();
            $table->text('biography')->nullable();
            $table->string('faculty')->nullable();  // Thêm trường Khoa
            $table->string('major')->nullable();    // Thêm trường Chuyên ngành
            $table->string('specialization')->nullable(); // Thêm trường Chuyên môn
            $table->unsignedBigInteger('user_id')->nullable(); // Thêm trường user_id
            // Khóa ngoại đến bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
