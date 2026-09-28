<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalamanKerja extends Model
{
    use HasFactory;
    protected $fillable = [
        'karyawan_id', 'nama_pt', 'jenis_perusahaan', 'jabatan_awal', 'jabatan_akhir', 'tanggal_awal_kerja', 'tanggal_akhir_kerja', 'alasan_berakhir_kerja'
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
