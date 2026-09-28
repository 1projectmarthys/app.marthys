<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaraninternal extends Model
{
    use HasFactory;
    protected $table = 'pembayaraninternals';
    protected $casts = [
        'tanggal' => 'date',
        'rencana_bayar' => 'date',
    ];

    protected $fillable = [
        'tanggal',
        'note',
        'nomor_dokumen',
        'nama_supplier',
        'grand_total',
        'sumber_dana',
        'rencana_bayar',
        'tipe_potong',
        'keterangan_potong',
        'lampiran',
        'potongan_harga',
        'biaya_admin',
        'total_bayar',
        'jumlah_kolom',
        'kurs',
        'mata_uang',
        'status_bayar',
        'tipe_pembayaran'
    ];
    //relasi one to many
    public function detail_pembayaraninternal()
    {
        return $this->hasMany(detail_pembayaraninternal::class, 'pembayaraninternal_id');
    }

    public function getTotalPotonganAttribute()
    {
        if ($this->tipe_potong == 'on_net_total') {
            return $this->grand_total * ($this->potongan_harga / 100);
        }
        return $this->potongan_harga;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // Ambil bulan dan tahun saat ini
            $bulan = self::convertToRoman(now()->format('m')); // Bulan dalam format Romawi
            $tahun = now()->format('Y'); // Tahun saat ini
    
            // Hitung jumlah dokumen yang sudah ada untuk bulan dan tahun ini
            $lastIdForMonth = self::whereRaw("DATE_FORMAT(tanggal, '%m-%Y') = ?", [now()->format('m-Y')])
                ->count();
    
            // Tambahkan 1 untuk nomor dokumen baru
            $idPadded = str_pad($lastIdForMonth + 1, 2, '0', STR_PAD_LEFT); // ID dengan padding nol (contoh: 001, 002)
    
            // Buat nomor dokumen
            $model->nomor_dokumen = "{$idPadded}/MOI-FIT/{$bulan}/{$tahun}";
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
