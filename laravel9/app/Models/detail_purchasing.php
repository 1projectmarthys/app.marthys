<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_purchasing extends Model
{
    use HasFactory;

    protected $table = 'detail_purchasing';

    protected $fillable = [
        'purchasing_id',
        'uraian',
        'jumlah',
        'keterangan',
        'tanggal_dokumen',
    ];

    // relasi belongs to
    public function purchasing()
    {
        return $this->belongsTo(Purchasing::class, 'purchasing_id');
    }
}
