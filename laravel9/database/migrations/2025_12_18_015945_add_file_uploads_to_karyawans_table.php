<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('file_kk')->nullable()->after('persetujuan');
            $table->string('file_ktp')->nullable()->after('file_kk');
            $table->string('file_ijazah')->nullable()->after('file_ktp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['file_kk', 'file_ktp', 'file_ijazah']);
        });
    }
};
