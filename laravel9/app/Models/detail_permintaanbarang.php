<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_permintaanbarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'permintaanbarang_id',
        'nama_barang',
        'qty',
        'satuan',
        'harga',
        'jumlah',
        'keterangan',
    ];
    public function permintaanbarang()
    {
        return $this->belongsTo(permintaanbarang::class);
    }
}
