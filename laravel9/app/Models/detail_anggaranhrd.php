<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_anggaranhrd extends Model
{
    use HasFactory;
    protected $table = 'detail_anggaranhrds';
    protected $fillable = [
        'anggaranhrd_id',
        'deksripsi',
        'qty',
        'harga',
        'jumlah',
        'keterangan',
    ];
    public function anggaranhrd()
    {
        return $this->belongsTo(anggaranhrd::class, 'anggaranhrd_id');
    }
}
