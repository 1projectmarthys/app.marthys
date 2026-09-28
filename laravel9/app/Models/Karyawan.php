<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_lengkap', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama', 'status',
        'golongan_darah', 'nik', 'no_hp', 'email', 'alamat', 'kecamatan', 'kabupaten', 'provinsi',
        'kode_pos', 'no_rekening_bca', 'npwp', 'ukuran_seragam', 'no_kk', 'nama_ayah', 'nama_ibu',
        'nama_istri_suami', 'tgl_lahir_istri_suami', 'jumlah_anak', 'nama_kontak_darurat',
        'hubungan_kontak_darurat', 'no_hp_kontak_darurat', 'pendidikan_terakhir', 'nama_institusi',
        'jurusan', 'tahun_lulus', 'riwayat_penyakit_kronis', 'jenis_penyakit', 'pernah_dirawat_inap',
        'alasan_dirawat_inap', 'tgl_dirawat_inap', 'sedang_pengobatan_rutin', 'nama_obat_dosis',
        'mengalami_cedera_berat', 'cedera_berat_keterangan', 'tgl_cedera_berat', 'pernah_operasi_besar',
        'jenis_operasi', 'tahun_operasi', 'tinggi_badan', 'berat_badan', 'pesan_kesan', 'persetujuan',
        'file_kk', 'file_ktp', 'file_ijazah'
    ];

    public function pengalamanKerja()
    {
        return $this->hasMany(PengalamanKerja::class);
    }
    public function anak()
    {
        return $this->hasMany(Anak::class);
    }
    public function riwayatSakit()
    {
        return $this->hasMany(RiwayatSakit::class);
    }
}
