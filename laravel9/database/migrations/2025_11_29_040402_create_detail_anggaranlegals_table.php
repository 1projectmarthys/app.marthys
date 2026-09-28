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
        Schema::create('detail_anggaranlegals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggaranlegal_id'); // Kolom anggaranlegal_id
            $table->foreign('anggaranlegal_id')->references('id')->on('anggaran_legals')->onDelete('cascade'); // Foreign key ke tabel anggaran_legals
            $table->text('deksripsi');
            $table->decimal('qty');
            $table->decimal('harga', 50, 2);
            $table->decimal('jumlah', 50, 2);
            $table->string('keterangan')->nullable();

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
        Schema::dropIfExists('detail_anggaranlegals');
    }
};
