<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSakit extends Model
{
    use HasFactory;
    protected $fillable = [
        'karyawan_id', 'jenis_penyakit', 'tanggal', 'keterangan'
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
