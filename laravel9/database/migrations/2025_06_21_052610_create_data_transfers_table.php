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
        Schema::create('data_transfer', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('norek_penerima', 99)->nullable();
            $table->string('nama_penerima', 99)->nullable();
            $table->string('alamat_penerima', 99)->nullable();
            $table->string('alamat2_penerima', 50)->nullable();
            $table->string('kota_penerima', 99)->nullable();
            $table->string('provinsi_penerima', 99)->nullable();
            $table->string('negara_penerima', 99)->nullable();
            $table->string('kodepos_penerima', 10)->nullable();
            $table->string('bank_penerima', 50)->nullable();
            $table->string('abank_penerima', 99)->nullable();
            $table->string('abank2_penerima', 99)->nullable();
            $table->string('kbank_penerima', 99)->nullable();
            $table->string('pbank_penerima', 99)->nullable();
            $table->string('nbank_penerima', 99)->nullable();
            $table->string('kpbank_penerima', 99)->nullable();
            $table->string('tujuan_transaksi', 99)->nullable();
            $table->string('berita_transaksi', 99)->nullable();
            $table->string('sumber_dana', 99)->nullable();
            $table->string('tunai', 99)->nullable();
            $table->string('tabungan', 99)->nullable();
            $table->string('cek_bca', 99)->nullable();
            $table->enum('mata_uang', ['IDR', 'USD', 'EUR', 'CNY'])->default('USD');
            $table->string('jumlah', 99)->nullable();
            $table->string('provisi', 99)->nullable();
            $table->string('biaya', 99)->nullable();
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
        Schema::dropIfExists('data_transfer');
    }
};
