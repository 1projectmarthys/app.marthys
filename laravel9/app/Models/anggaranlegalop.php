<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\serieslegalop;

class anggaranlegalop extends Model
{
    use HasFactory;
    protected $table = 'anggaranlegalops';
    protected $fillable = [
        'serieslegalop_id',
        'nomor_dokumen',
        'tanggal_anggaran',
        'diajukan_oleh',
        'perihal',
        'note',
        'sifat',
        'waktu_pelaksanaan',
        'diterima',
        'total_harga',
        'created_by',
           'file',
    ];
    public function serieslegalop()
    {
        return $this->belongsTo(serieslegalop::class, 'serieslegalop_id');
    }
    public function detail_anggaranlegalop()
    {
        return $this->hasMany(detail_anggaranlegalop::class, 'anggaranlegalop_id');
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
        $serieslegalop = serieslegalop::find($model->serieslegalop_id);
        $kode_series = $serieslegalop ? $serieslegalop->kode_series : 'XX';

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
            $model->nomor_dokumen = "{$nextNumber}/MOI-LEG/{$bulan}/{$tahun}";
        });
    });

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
    $series = serieslegalop::find($model->serieslegalop_id);
    $kode_series = $series ? $series->kode_series : 'XX';

    // Set nomor dokumen baru
    $model->nomor_dokumen = "{$nomorUrut}/MOI-LEG/{$kode_series}/{$bulan}/{$tahun}";
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
