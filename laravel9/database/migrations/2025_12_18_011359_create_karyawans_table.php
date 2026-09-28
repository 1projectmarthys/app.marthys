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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->enum('status', ['Belum Menikah', 'Menikah', 'Cerai']);
            $table->string('golongan_darah')->nullable();
            $table->string('nik', 20)->unique();
            $table->string('no_hp', 20);
            $table->string('email')->unique();
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('kode_pos', 10);
            $table->string('no_rekening_bca', 30)->nullable();
            $table->string('npwp', 30)->nullable();
            $table->string('ukuran_seragam', 10)->nullable();
            $table->string('no_kk', 30)->nullable();
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('nama_istri_suami')->nullable();
            $table->date('tgl_lahir_istri_suami')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('nama_kontak_darurat');
            $table->string('hubungan_kontak_darurat');
            $table->string('no_hp_kontak_darurat', 20);
            $table->string('pendidikan_terakhir');
            $table->string('nama_institusi');
            $table->string('jurusan');
            $table->string('tahun_lulus', 4);
            $table->boolean('riwayat_penyakit_kronis')->default(false);
            $table->string('jenis_penyakit')->nullable();
            $table->boolean('pernah_dirawat_inap')->default(false);
            $table->string('alasan_dirawat_inap')->nullable();
            $table->date('tgl_dirawat_inap')->nullable();
            $table->boolean('sedang_pengobatan_rutin')->default(false);
            $table->string('nama_obat_dosis')->nullable();
            $table->boolean('mengalami_cedera_berat')->default(false);
            $table->string('cedera_berat_keterangan')->nullable();
            $table->date('tgl_cedera_berat')->nullable();
            $table->boolean('pernah_operasi_besar')->default(false);
            $table->string('jenis_operasi')->nullable();
            $table->string('tahun_operasi', 4)->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->text('pesan_kesan')->nullable();
            $table->boolean('persetujuan')->default(false);
            $table->string('file_kk')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ijazah')->nullable();
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
        Schema::dropIfExists('karyawans');
    }
};
