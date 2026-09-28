<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_anggaranhrdnoop extends Model
{
    use HasFactory;
    protected $table = 'detail_anggaranhrdnoops';
    protected $fillable = [
        'anggaranhrdnoop_id',
        'deksripsi',
        'qty',
        'harga',
        'jumlah',
        'keterangan',
    ];
    public function anggaranhrdnoop()
    {
        return $this->belongsTo(anggaranhrdnoop::class, 'anggaranhrdnoop_id');
    }   
}
