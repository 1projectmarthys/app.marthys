<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artimatika extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'harga_satuan',
        'total_harga',
        'grand_total',
    ];
}
