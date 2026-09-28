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
        Schema::create('detail_anggaranhrdnoops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggaranhrdnoop_id');
            $table->foreign('anggaranhrdnoop_id')->references('id')->on('anggaranhrdnoops')->onDelete('cascade');
            $table->text('deksripsi');
            $table->integer('qty');
            $table->bigInteger('harga');
            $table->bigInteger('jumlah');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('detail_anggaranhrdnoops');
    }
};
