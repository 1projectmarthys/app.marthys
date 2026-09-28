<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class anggaranhrdnoop extends Model
{
    use HasFactory;
    protected $table = 'anggaranhrdnoops';
    protected $fillable = [
        'serieshrd_id',
        'nomor_dokumen',
        'tanggal_anggaran',
        'diajukan_oleh',
        'perihal',
        'kolom',
        'sifat',
        'waktu_pelaksanaan',
        'total_harga',
        'created_by',
    ];

    public function detail_anggaranhrdnoop()
    {
        return $this->hasMany(detail_anggaranhrdnoop::class, 'anggaranhrdnoop_id');
    }
    
    public function serieshrd()
    {
        return $this->belongsTo(serieshrd::class, 'serieshrd_id');
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

        // Ambil bulan & tahun
        $bulan = self::convertToRoman($tanggal_anggaran->format('m'));
        $tahun = $tanggal_anggaran->format('Y');

        // Ambil kode series
        $serieshrd = serieshrd::find($model->serieshrd_id);
        $kode_series = $serieshrd ? $serieshrd->kode_series : 'XX';
        
        // 🔁 Gunakan transaksi agar aman dari race condition
        DB::transaction(function () use ($model, $tanggal_anggaran, $bulan, $tahun, $kode_series) {

            // Ambil nomor terakhir berdasarkan TAHUN saja (reset tiap tahun)
            $lastNumber = self::whereYear('tanggal_anggaran', $tanggal_anggaran->year)
                ->selectRaw("MAX(CAST(SUBSTRING_INDEX(nomor_dokumen, '/', 1) AS UNSIGNED)) as max_number")
                ->lockForUpdate()
                ->value('max_number');

            // Nomor naik, reset ke 01 jika tahun baru
            $nextNumber = str_pad(($lastNumber ?? 0) + 1, 3, '0', STR_PAD_LEFT);

            // Format nomor dokumen
            $model->nomor_dokumen = "{$nextNumber}/MOI-HRDGA/{$bulan}/{$tahun}";
        });
    });

        // === Saat Update Data ===
      
          static::updating(function ($model) {

            // Validasi tanggal
            if (empty($model->tanggal_anggaran)) {
                throw ValidationException::withMessages([
                    'tanggal_anggaran' => 'tanggal_anggaran tidak boleh dikosongkan saat mengedit data.',
                ]);
            }

            // Parse tanggal
            try {
                $tanggal_anggaran = Carbon::parse($model->tanggal_anggaran);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'tanggal_anggaran' => 'Format tanggal_anggaran tidak valid.',
                ]);
            }

            // Ambil bagian nomor urut dari nomor lama
            $oldParts = explode('/', $model->getOriginal('nomor_dokumen'));
            $nomorUrut = $oldParts[0]; // tetap sama

            // Ambil bulan & tahun baru
            $bulan = self::convertToRoman($tanggal_anggaran->format('m'));
            $tahun = $tanggal_anggaran->format('Y');

            // Ambil series baru
            $serieshrd = serieshrd::find($model->serieshrd_id);
            $kode_series = $serieshrd ? $serieshrd->kode_series : 'XX';

            // Set nomor dokumen baru
            $model->nomor_dokumen = "{$nomorUrut}/MOI/PSN/HRD-GA/{$kode_series}/{$bulan}/{$tahun}";
        });
    }

    // 🔠 Konversi angka bulan ke romawi
    protected static function convertToRoman($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $map[(int) $month];
    }
}
