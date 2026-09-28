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
        Schema::create('anggaranops', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen');
            $table->date('tanggal_anggaran');
            $table->string('note')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->enum('jumlah_kolom', ['3kolom', '5kolom'])->default('3kolom');
            $table->decimal('total_anggaran', 50, 2);


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
        Schema::dropIfExists('anggaranops');
    }
};
