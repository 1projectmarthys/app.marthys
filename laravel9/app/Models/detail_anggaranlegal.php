<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_anggaranlegal extends Model
{
    use HasFactory;
    protected $table = 'detail_anggaranlegals';
    protected $fillable = [
        'anggaranlegal_id',
        'deksripsi',
        'qty',
        'harga',
        'jumlah',
        'keterangan',
    ];
    public function anggaranlegal()
    {
        return $this->belongsTo(AnggaranLegal::class, 'anggaranlegal_id');
    }
    
}
