<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('detail_anggaranlegalops', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('anggaranlegalop_id');
        });

        // qty & jumlah tidak lagi dipakai di form, tapi kolomnya dipertahankan
        // agar data lama tetap utuh. Dibuat nullable + default 0 supaya insert
        // baru tanpa qty/jumlah tidak error.
        // Pakai raw SQL agar tidak butuh package doctrine/dbal.
        DB::statement('ALTER TABLE detail_anggaranlegalops MODIFY qty DECIMAL(8,2) NULL DEFAULT 0');
        DB::statement('ALTER TABLE detail_anggaranlegalops MODIFY jumlah DECIMAL(50,2) NULL DEFAULT 0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_anggaranlegalops', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
