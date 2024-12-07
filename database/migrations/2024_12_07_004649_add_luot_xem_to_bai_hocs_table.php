<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bai_hocs', function (Blueprint $table) {
            if (!Schema::hasColumn('bai_hocs', 'luot_xem')) {
                $table->integer('luot_xem')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('bai_hocs', function (Blueprint $table) {
            $table->dropColumn('luot_xem');
        });
    }
};