<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_pembayaraninternal extends Model
{
    use HasFactory;
    protected $table = 'detail_pembayaraninternals';
    protected $fillable = [
        'pembayaraninternal_id',
        'uraian',
        'jumlah',
        'keterangan',
        'tanggal_dokumen',
    ];
    //relasi belongs to
    public function pembayaraninternal()
    {
        return $this->belongsTo(pembayaraninternal::class, 'pembayaraninternal_id');
    }
}
