<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use App\Models\Serieslegal;

class AnggaranLegal extends Model
{
    use HasFactory;
    protected $table = 'anggaran_legals';
    protected $fillable = [
        'serieslegal_id',
        'nomor_dokumen',
        'tanggal_anggaran',
        'diajukan_oleh',
        'perihal',
        'sifat',
        'waktu_pelaksanaan',
        'diterima',
        'total_harga',
        'created_by',
         'file',
        
    ];
    public function serieslegal()
    {
        return $this->belongsTo(Serieslegal::class, 'serieslegal_id');
    }
    public function detail_anggaranlegal()
    {
        return $this->hasMany(detail_anggaranlegal::class, 'anggaranlegal_id');
    }
       protected static function boot()
{
    parent::boot();

    // === Saat Membuat Data Baru ===
    static::creating(function ($model) {
        // 🔒 Validasi: tanggal_anggaran wajib diisi
        if (empty($model->tanggal_anggaran)) {
            throw ValidationException::withMessages([
                'tanggal_anggaran' => 'tanggal_anggaran wajib diisi sebelum menyimpan data.',
            ]);
        }

        // ✅ Pastikan tanggal_anggaran valid
        try {
            $tanggal_anggaran = Carbon::parse($model->tanggal_anggaran);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'tanggal_anggaran' => 'Format tanggal_anggaran tidak valid.',
            ]);
        }

        // Ambil bulan dan tahun dari tanggal_anggaran input
        $bulan = self::convertToRoman($tanggal_anggaran->format('m'));
        $tahun = $tanggal_anggaran->format('Y');

        // Mengambil Series Legal untuk validasi nomor dokumen
        $serieslegal = Serieslegal::find($model->serieslegal_id);
        $kode_series = $serieslegal ? $serieslegal->kode_series : 'XX';

        // 🔁 Gunakan transaksi agar aman dari race condition
        DB::transaction(function () use ($model, $tanggal_anggaran, $bulan, $tahun, $kode_series) {

            // ⚠️ REVISI DI SINI — reset nomor hanya berdasarkan TAHUN, bukan bulan
            $lastNumber = self::whereYear('tanggal_anggaran', $tanggal_anggaran->year)
                ->selectRaw("MAX(CAST(SUBSTRING_INDEX(nomor_dokumen, '/', 1) AS UNSIGNED)) as max_number")
                ->lockForUpdate()
                ->value('max_number');

            // RESET saat tahun baru → karena $lastNumber akan null
            $nextNumber = str_pad(($lastNumber ?? 0) + 1, 3, '0', STR_PAD_LEFT);

            // Format nomor dokumen
            $model->nomor_dokumen = "{$nextNumber}/{$kode_series}/{$bulan}/{$tahun}";
        });
    });

        // === Saat Update Data ===
        static::updating(function ($model) {
        
            // Validasi tanggal_anggaran
            if (empty($model->tanggal_anggaran)) {
                throw ValidationException::withMessages([
                    'tanggal_anggaran' => 'tanggal_anggaran tidak boleh dikosongkan saat mengedit data.',
                ]);
            }
        
            // Parse tanggal baru
            try {
                $tanggal_anggaran = Carbon::parse($model->tanggal_anggaran);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'tanggal_anggaran' => 'Format tanggal_anggaran tidak valid.',
                ]);
            }
        
            // Ambil nomor urut lama (bagian pertama sebelum "/")
            $oldParts = explode('/', $model->getOriginal('nomor_dokumen'));
            $nomorUrut = $oldParts[0];
        
            // Ambil bulan & tahun baru
            $bulan = self::convertToRoman($tanggal_anggaran->format('m'));
            $tahun = $tanggal_anggaran->format('Y');
        
            // Ambil series baru
            $serieslegal = Serieslegal::find($model->serieslegal_id);
            $kode_series = $serieslegal ? $serieslegal->kode_series : 'XX';
        
            // Set nomor dokumen baru sesuai hasil edit
            $model->nomor_dokumen = "{$nomorUrut}/{$kode_series}/{$bulan}/{$tahun}";
        });

    }

    // 🔠 Konversi angka bulan ke romawi
    protected static function convertToRoman($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $map[(int)$month];
    }
}
