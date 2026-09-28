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
        Schema::create('masterpenagihans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dokumen');
            $table->string('nomor_dokumen')->unique();
            $table->string('nama_customer');
            $table->string('alamat_customer');
            $table->string('kode_customer');
            $table->decimal('total_tagihan', 50, 2)->default(0.00);
            $table->string('keterangan_lengkap');
            $table->string('status_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masterpenagihans');
    }
};
