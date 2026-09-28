<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_transfer extends Model
{
    use HasFactory;
    protected $table = 'data_transfer';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'norek_penerima',
        'nama_penerima',
        'alamat_penerima',
        'alamat2_penerima',
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
        'tujuan_transaksi',
        'berita_transaksi', 
        'sumber_dana',
        'tunai',
        'tabungan',
        'cek_bca',
        'mata_uang',
        'jumlah',
        'provisi',
        'biaya',
    ];
}
