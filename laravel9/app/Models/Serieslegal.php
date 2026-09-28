<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serieslegal extends Model
{
    use HasFactory;
    protected $table = 'serieslegals';
    protected $fillable = [
        'kode_series',
        'keterangan',
    ];
    public function anggaranlegal()
    {
        return $this->hasMany(AnggaranLegal::class, 'anggaranlegal_id');
    }
}
