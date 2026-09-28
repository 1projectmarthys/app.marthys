<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_anggaranop extends Model
{
    use HasFactory;
    protected $table = 'detail_anggaranops';
    protected $fillable = [
        'anggaranops_id',
        'keperluan',
        'keterangan',
        'jumlah',
    ];
    public function anggaranop()
    {
        return $this->belongsTo(anggaranop::class, 'anggaranops_id');
    }
}
