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
        Schema::create('detail_anggaranops', function (Blueprint $table) {
            $table->id();   
            $table->unsignedBigInteger('anggaranops_id'); // Foreign key ke tabel anggaranops
            $table->string('keperluan');
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 50, 2);
            
            $table->foreign('anggaranops_id')->references('id')->on('anggaranops')->onDelete('cascade'); 
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
        Schema::dropIfExists('detail_anggaranops');
    }
};
