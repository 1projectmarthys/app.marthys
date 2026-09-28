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
        Schema::create('anggaran_legals', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen');
            $table->unsignedBigInteger('serieslegal_id');
            $table->foreign('serieslegal_id')->references('id')->on('serieslegals')->onDelete('cascade');
            $table->date('tanggal_anggaran');
            $table->text('diajukan_oleh')->nullable();
            $table->string('perihal')->nullable();
            $table->enum('sifat', ['biasa', 'segera', 'urgent'])->default('biasa');
            $table->string('waktu_pelaksanaan')->nullable();
            $table->enum('diterima', ['finance', 'accounting'])->default('accounting');
            $table->decimal('total_harga', 50, 2);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('anggaran_legals');
    }
};
