<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Masterpenagihan;
class detail_penagihan extends Model
{
    use HasFactory;
    protected $table = 'detail_penagihan';
    protected $fillable = [
        'penagihan_id',
        'tanggal',
        'no_faktur',
        'no_faktur_pajak',
        'jumlah',
        'keterangan',
    ];
    //relasi one to many
    public function masterpenagihan()
    {
        return $this->belongsTo(Masterpenagihan::class, 'penagihan_id');
    }
}

