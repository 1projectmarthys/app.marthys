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
        Schema::create('pembayaraninternals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->text('note')->nullable();
            $table->string('nomor_dokumen');
            $table->string('nama_supplier');
            $table->decimal('grand_total', 50, 2);
            $table->string('sumber_dana');
            $table->date('rencana_bayar');
            $table->enum('tipe_potong', ['actual', 'on_net_total'])->nullable();
            $table->text('keterangan_potong')->nullable();
            $table->string('lampiran')->nullable();
            $table->decimal('potongan_harga', 50, 2)->default(0)->nullable();
            $table->decimal('biaya_admin', 50, 2)->default(0)->nullable(); 
            $table->decimal('total_bayar', 50, 2);
            $table->enum('jumlah_kolom', ['3kolom', '4kolom'])->default('3kolom'); // Perubahan di sini
            $table->decimal('kurs', 50, 4)->default(1);
            $table->enum('mata_uang', ['IDR', 'USD', 'CNY'])->default('IDR');
            $table->enum('status_bayar', ['pending', 'processed', 'completed'])->default('pending');
            $table->string('tipe_pembayaran');
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
        Schema::dropIfExists('pembayaraninternals');
    }
};
