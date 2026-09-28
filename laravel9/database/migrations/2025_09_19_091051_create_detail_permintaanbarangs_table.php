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
        Schema::create('detail_permintaanbarangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaanbarang_id'); // Foreign key ke tabel permintaanbarang
            $table->string('nama_barang');
            $table->decimal('qty', 50, 2);
            $table->string('satuan');
            $table->decimal('harga', 50, 2);
            $table->decimal('jumlah', 50, 2);
            $table->string('keterangan')->nullable();

            // Menambahkan foreign key constraint
            $table->foreign('permintaanbarang_id')->references('id')->on('permintaanbarangs')->onDelete('cascade');
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
        Schema::dropIfExists('detail_permintaanbarangs');
    }
};
