<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengendaliansistemit extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengontrol',
        'nama',
        'bulan',
        'tahun',
        'backup_data_tanggal',
        'backup_data_checked',
        'antivirus_update_tanggal',
        'antivirus_update_checked',
        'troubleshooting_tanggal',
        'troubleshooting_checked',
        'defragment_tanggal',
        'defragment_checked',
        'keterangan',
    ];
    protected $casts = [
        'has_keterangan' => 'boolean',
    ];
}
