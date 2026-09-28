<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use App\Models\detail_purchasing;
use Carbon\Carbon;

class Purchasing extends Model
{
    use HasFactory;

    protected $table = 'purchasings';

    protected $casts = [
        'tanggal' => 'date',
        'rencana_bayar' => 'date',
    ];

    protected $fillable = [
        'tanggal',
        'nomor_dokumen',
        'nama_supplier',
        'grand_total',
        'sumber_dana',
        'rencana_bayar',
        'note',
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
        'tipe_pembayaran',
        'created_by',
    ];

    // relasi one to many
    public function detail_purchasing()
    {
        return $this->hasMany(detail_purchasing::class, 'purchasing_id');
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

        // === Saat Membuat Data Baru ===
        static::creating(function ($model) {
            // Validasi: tanggal wajib diisi
            if (empty($model->tanggal)) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Tanggal wajib diisi sebelum menyimpan data.',
                ]);
            }

            // Pastikan tanggal valid
            try {
                $tanggal = Carbon::parse($model->tanggal);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Format tanggal tidak valid.',
                ]);
            }

            $bulan = self::convertToRoman($tanggal->format('m'));
            $tahun = $tanggal->format('Y');

            // Transaksi agar aman dari race condition
            DB::transaction(function () use ($model, $tanggal, $bulan, $tahun) {
                // Nomor terakhir berdasarkan bulan & tahun (reset tiap bulan)
                $lastNumber = self::whereYear('tanggal', $tanggal->year)
                    ->whereMonth('tanggal', $tanggal->month)
                    ->selectRaw("MAX(CAST(SUBSTRING_INDEX(nomor_dokumen, '/', 1) AS UNSIGNED)) as max_number")
                    ->lockForUpdate()
                    ->value('max_number');

                $nextNumber = str_pad(($lastNumber ?? 0) + 1, 3, '0', STR_PAD_LEFT);

                // Format: 001/MOI-PCH/VII/2026
                $model->nomor_dokumen = "{$nextNumber}/MOI-PCH/{$bulan}/{$tahun}";
            });
        });

        // === Saat Update Data ===
        static::updating(function ($model) {
            // Cegah perubahan nomor_dokumen saat update
            if ($model->isDirty('nomor_dokumen')) {
                $model->nomor_dokumen = $model->getOriginal('nomor_dokumen');
            }

            if (empty($model->tanggal)) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Tanggal tidak boleh dikosongkan saat mengedit data.',
                ]);
            }
        });
    }

    // Konversi angka bulan ke romawi
    protected static function convertToRoman($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $map[(int) $month];
    }
}
