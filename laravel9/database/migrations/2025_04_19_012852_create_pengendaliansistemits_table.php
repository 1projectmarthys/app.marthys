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
        Schema::create('pengendaliansistemits', function (Blueprint $table) {
            $table->id();
            $table->string('pengontrol', 255);
            $table->string('nama', 255);
            $table->integer('bulan');
            $table->integer('tahun');
            // Backup Data fields
            $table->date('backup_data_tanggal')->nullable();
            $table->boolean('backup_data_checked')->nullable();
            // Antivirus Update fields
            $table->date('antivirus_update_tanggal')->nullable();
            $table->boolean('antivirus_update_checked')->nullable();
            //troubleshooting
            $table->date('troubleshooting_tanggal')->nullable();
            $table->boolean('troubleshooting_checked')->nullable();
            //defragmentation
            $table->date('defragment_tanggal')->nullable();
            $table->boolean('defragment_checked')->nullable();
            // Add other fields as necessary
            $table->text('keterangan')->nullable(); // Kolom keterangan
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengendaliansistemits');
    }
};
