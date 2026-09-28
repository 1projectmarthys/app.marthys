<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    use HasFactory;
    protected $fillable = [
        'karyawan_id', 'nama', 'tanggal_lahir'
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
