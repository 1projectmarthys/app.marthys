<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_penerima extends Model
{
    use HasFactory;

    protected $table = 'tb_penerima';
    protected $primaryKey = 'norek_penerima';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'norek_penerima',
        'nama_penerima',
        'alamat_penerima',
        'kota_penerima',
        'provinsi_penerima',
        'negara_penerima',
        'kodepos_penerima',
        'bank_penerima',
        'abank_penerima',
        'abank2_penerima',
        'kbank_penerima',
        'pbank_penerima',
        'nbank_penerima',
        'kpbank_penerima',
        'bank_status',
    ];
}
