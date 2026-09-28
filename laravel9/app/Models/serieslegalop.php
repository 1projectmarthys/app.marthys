<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serieslegalop extends Model
{
    use HasFactory;
    protected $table = 'serieslegalops';
    protected $fillable = [
        'kode_series',
        'keterangan',
    ];
    public function anggaranlegalop()
    {
        return $this->hasMany(AnggaranLegalOp::class, 'anggaranlegalop_id');
    }
}
