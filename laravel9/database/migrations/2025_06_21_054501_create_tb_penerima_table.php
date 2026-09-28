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
        Schema::create('tb_penerima', function (Blueprint $table) {
            $table->id('norek_penerima');
            $table->string('nama_penerima', 99);
            $table->string('alamat_penerima', 99);
            $table->string('kota_penerima', 99);
            $table->string('provinsi_penerima', 99);
            $table->string('negara_penerima', 99);
            $table->string('kodepos_penerima', 10);
            $table->string('bank_penerima', 50);
            $table->string('abank_penerima', 99);
            $table->string('abank2_penerima', 99);
            $table->string('kbank_penerima', 99);
            $table->string('pbank_penerima', 99);
            $table->string('nbank_penerima', 99);
            $table->string('kpbank_penerima', 99);
            $table->string('bank_status', 20);
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
        Schema::dropIfExists('tb_penerima');
    }
};
