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
        Schema::create('internal_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->unique();
            $table->date('tanggal');
            $table->date('rencana_bayar');

            // Rekening Pengirim
            $table->string('dari_bank');
            $table->string('norek_pengirim');
            $table->string('atasnama_pengirim');

            // Rekening Penerima
            $table->string('ke_bank');
            $table->string('norek_penerima');
            $table->string('atasnama_penerima');

            // Nominal
            $table->decimal('jumlah_transfer', 50, 2)->default(0);
            $table->text('terbilang')->nullable();

            // Jenis transfer: operasional | deposito | payroll | kas_tunai | lainnya
            $table->string('jenis_transfer')->nullable();
            $table->string('jenis_transfer_lainnya')->nullable();

            $table->text('note')->nullable();
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
        Schema::dropIfExists('internal_transfers');
    }
};
