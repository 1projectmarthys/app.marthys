<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permintaanbarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor_dokumen',
        'tanggal_permintaan',
        'sifat',
        'keterangan',
        'total_harga',
        'status',
        'created_by',
    ];
    public function detail_permintaanbarangs()
    {
        return $this->hasMany(detail_permintaanbarang::class);
    }
      protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Ambil bulan dan tahun saat ini
            $bulan = self::convertToRoman(now()->format('m')); // Bulan dalam format Romawi
            $tahun = now()->format('Y'); // Tahun saat ini

            // Hitung jumlah dokumen yang sudah ada untuk bulan dan tahun ini
            $lastIdForMonth = self::whereRaw("DATE_FORMAT(tanggal_permintaan, '%m-%Y') = ?", [now()->format('m-Y')])
                ->count();

            // Tambahkan 1 untuk nomor dokumen baru
            $idPadded = str_pad($lastIdForMonth + 1, 2, '0', STR_PAD_LEFT); // ID dengan padding nol (contoh: 001, 002)

            // Buat nomor dokumen
            $model->nomor_dokumen = "{$idPadded}/FPBP/{$bulan}/{$tahun}";
        });

    }

    protected static function convertToRoman($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
    
        return $map[(int) $month];
    }
}
