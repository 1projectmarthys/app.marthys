<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetadataDokumenLegal extends Model
{
    protected $table = 'metadata_dokumen_legal';

    protected $fillable = [
    'pilihmodel_dokumen',
    'tipe_dokumen',
    'bentuk_singkat',
    'judul',
    'nomor',
    'nomor_laporan',
    'keterangan',
    'direct',
    'pihak_kedua',
    'tahun',
    'tanggal_ditetapkan',
    'tanggal_berakhir',
    'jangka_waktu',
    'merek',
    'lokasi_distribusi',
    'bidang',
    'status',
    'detail',
    ];

    public function details()
    {
        return $this->hasMany(DetailMetadataDokumenLegal::class);
    }
}
