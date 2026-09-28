<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_anggaranlegalop extends Model
{
    use HasFactory;
    protected $table = 'detail_anggaranlegalops';
    protected $fillable = [
        'anggaranlegalop_id',
        'tanggal',
        'deksripsi',
        'qty',
        'harga',
        'jumlah',
        'keterangan',
    ];
    public function anggaranlegalop()
    {
        return $this->belongsTo(AnggaranLegalOp::class, 'anggaranlegalop_id');
    }
}
