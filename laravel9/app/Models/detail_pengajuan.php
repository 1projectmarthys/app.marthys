<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_pengajuan extends Model
{
    use HasFactory;
    protected $table = 'detail_pengajuan';
    protected $fillable = [
        'pengajuan_id',
        'uraian',
        'jumlah',
        'keterangan',
        'tanggal_dokumen',
    ];
    //relasi belongs to
    public function pengajuanPembayaran()
    {
        return $this->belongsTo(Pengajuanpembayaran::class, 'pengajuan_id');
    }
}
