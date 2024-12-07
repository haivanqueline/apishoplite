<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('khoa_hocs', function (Blueprint $table) {
            // Thêm cột created_by nếu chưa có
            if (!Schema::hasColumn('khoa_hocs', 'created_by')) {
                $table->foreignId('created_by')->nullable()->constrained('users')->after('trang_thai');
            }
        });
    }

    public function down(): void
    {
        Schema::table('khoa_hocs', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
        });
    }
};