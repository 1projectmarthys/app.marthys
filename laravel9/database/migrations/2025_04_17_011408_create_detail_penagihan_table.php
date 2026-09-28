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
        Schema::create('detail_penagihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penagihan_id'); // Kolom penagihan_id
            $table->foreign('penagihan_id')->references('id')->on('masterpenagihans')->onDelete('cascade'); // Foreign key ke tabel penagihan
            $table->date('tanggal'); // Kolom tanggal
            $table->string('no_faktur', 99); // Kolom no faktur
            $table->string('no_faktur_pajak', 99); // Kolom no faktur pajak
            $table->decimal('jumlah', 50, 2); // Kolom jumlah dengan presisi 50,2
            $table->string('keterangan', 99); // Kolom keterangan
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
        Schema::dropIfExists('detail_penagihan');
    }
};
