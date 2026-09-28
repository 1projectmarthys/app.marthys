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
        Schema::create('anggaranhrdnoops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serieshrd_id');
            $table->foreign('serieshrd_id')->references('id')->on('serieshrds')->onDelete('cascade');
            $table->string('nomor_dokumen')->unique();
            $table->date('tanggal_anggaran');
            $table->string('diajukan_oleh');
            $table->string('perihal');
            $table->string('kolom');
            $table->string('sifat');
            $table->string('waktu_pelaksanaan');
            $table->bigInteger('total_harga');
            $table->string('created_by');
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
        Schema::dropIfExists('anggaranhrdnoops');
    }
};
