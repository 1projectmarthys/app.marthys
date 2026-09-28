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
        Schema::create('detail_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengajuan_id'); // Foreign key ke tabel pengajuan
            $table->string('uraian', 255); // Kolom uraian
            $table->decimal('jumlah', 50, 2); // Kolom jumlah dengan presisi 50,2
            $table->text('keterangan')->nullable(); // Kolom keterangan
            $table->date('tanggal_dokumen')->nullable(); 
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('pengajuan_id')->references('id')->on('pengajuanpembayarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pengajuan');
    }
};
