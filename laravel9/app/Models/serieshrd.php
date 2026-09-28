<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serieshrd extends Model
{
    use HasFactory;

    protected $table = 'serieshrds';
    protected $fillable = [
        'kode_series',
        'keterangan',
    ];

    public function anggaranhrd()
    {
        return $this->hasMany(anggaranhrd::class, 'serieshrd_id');
    }

}
