<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\detail_penagihan;
class Masterpenagihan extends Model
{
    use HasFactory;

    
    protected $table = 'masterpenagihans';

 
    protected $fillable = [
        'tanggal_dokumen',
        'nomor_dokumen',
        'nama_customer',
        'alamat_customer',
        'kode_customer',
        'total_tagihan',
        'keterangan_lengkap',
        'status_bayar',
    ];
    public $timestamps = false;

    //relasi one to many 
    public function detail_penagihan()
    {
        return $this->hasMany(detail_penagihan::class, 'penagihan_id');
    }
  
    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::creating(function ($model) {
    //         // Ambil bulan dan tahun saat ini
    //         $bulan = self::convertToRoman(now()->format('m')); // Bulan dalam format Romawi
    //         $tahun = now()->format('Y'); // Tahun saat ini
    
    //         // Hitung jumlah dokumen yang sudah ada untuk bulan dan tahun ini
    //         $lastIdForMonth = self::whereRaw("DATE_FORMAT(tanggal_dokumen, '%m-%Y') = ?", [now()->format('m-Y')])
    //             ->count();
    
    //         // Tambahkan 1 untuk nomor dokumen baru
    //         $idPadded = str_pad($lastIdForMonth + 1, 2, '0', STR_PAD_LEFT); // ID dengan padding nol (contoh: 001, 002)
    
    //         // Buat nomor dokumen
    //         $model->nomor_dokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$tahun}";
    //     });
    
    //     // static::created(function ($model) {
    //     //     // Pastikan nomor_dokumen diisi setelah ID tersedia
    //     //     if (!$model->nomor_dokumen) {
    //     //         $idPadded = str_pad($model->id, 3, '0', STR_PAD_LEFT); // ID dengan padding nol
    //     //         $bulan = self::convertToRoman(now()->format('m')); // Bulan dalam format Romawi
    //     //         $tahun = now()->format('Y');
    //     //         $model->nomor_dokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$tahun}";
    //     //         $model->save();
    //     //     }
    //     // });
    // }
    
    /**
     * Convert month number to Roman numeral.
     *
     * @param int $month
     * @return string
     */
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        // Gunakan tanggal dokumen dari model untuk bulan dan tahun
        if (!empty($model->tanggal_dokumen)) {
            $docDate = new \DateTime($model->tanggal_dokumen);
            $month = $docDate->format('m');
            $year = $docDate->format('Y');
        } else {
            // Fallback ke tanggal saat ini jika tanggal dokumen tidak tersedia
            $month = now()->format('m');
            $year = now()->format('Y');
        }

        // Konversi bulan ke format Romawi berdasarkan bulan dari tanggal dokumen
        $bulan = self::convertToRoman($month);
        
        // Hitung jumlah dokumen yang sudah ada untuk bulan dan tahun ini
        $lastIdForMonth = self::whereRaw("DATE_FORMAT(tanggal_dokumen, '%m-%Y') = ?", ["{$month}-{$year}"])
            ->count();

        // Tambahkan 1 untuk nomor dokumen baru
        $idPadded = str_pad($lastIdForMonth + 1, 2, '0', STR_PAD_LEFT); // ID dengan padding nol (contoh: 01, 02)

        // Buat nomor dokumen dengan bulan yang benar dari tanggal dokumen
        $model->nomor_dokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$year}";
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
