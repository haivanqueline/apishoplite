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
        Schema::table('bai_hocs', function (Blueprint $table) {
            $table->integer('thu_tu')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('bai_hocs', function (Blueprint $table) {
            $table->integer('thu_tu')->change();
        });
    }
};
