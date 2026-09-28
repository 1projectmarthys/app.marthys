<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class InternalTransfer extends Model
{
    use HasFactory;

    protected $table = 'internal_transfers';

    protected $casts = [
        'tanggal' => 'date',
        'rencana_bayar' => 'date',
    ];

    protected $fillable = [
        'nomor_dokumen',
        'tanggal',
        'rencana_bayar',
        'dari_bank',
        'norek_pengirim',
        'atasnama_pengirim',
        'ke_bank',
        'norek_penerima',
        'atasnama_penerima',
        'jumlah_transfer',
        'terbilang',
        'jenis_transfer',
        'jenis_transfer_lainnya',
        'note',
        'created_by',
    ];

    // Label jenis transfer untuk tampilan
    public static function jenisTransferOptions()
    {
        return [
            'operasional' => 'Pemenuhan Saldo Operasional',
            'deposito'    => 'Penempatan Deposito',
            'payroll'     => 'Kebutuhan Payroll',
            'kas_tunai'   => 'Penarikan Kas Tunai',
            'lainnya'     => 'Lainnya',
        ];
    }

    public function getJenisTransferLabelAttribute()
    {
        if ($this->jenis_transfer === 'lainnya') {
            return trim('Lainnya : ' . ($this->jenis_transfer_lainnya ?? ''));
        }

        return self::jenisTransferOptions()[$this->jenis_transfer] ?? '-';
    }

    protected static function boot()
    {
        parent::boot();

        // === Saat Membuat Data Baru ===
        static::creating(function ($model) {
            if (empty($model->tanggal)) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Tanggal wajib diisi sebelum menyimpan data.',
                ]);
            }

            try {
                $tanggal = Carbon::parse($model->tanggal);
            } catch (\Exception $e) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Format tanggal tidak valid.',
                ]);
            }

            $bulan = self::convertToRoman($tanggal->format('m'));
            $tahun = $tanggal->format('Y');

            DB::transaction(function () use ($model, $tanggal, $bulan, $tahun) {
                // Reset nomor tiap bulan
                $lastNumber = self::whereYear('tanggal', $tanggal->year)
                    ->whereMonth('tanggal', $tanggal->month)
                    ->selectRaw("MAX(CAST(SUBSTRING_INDEX(nomor_dokumen, '/', 1) AS UNSIGNED)) as max_number")
                    ->lockForUpdate()
                    ->value('max_number');

                $nextNumber = str_pad(($lastNumber ?? 0) + 1, 3, '0', STR_PAD_LEFT);

                // Format: 002/MOI-FIT/VII/2026
                $model->nomor_dokumen = "{$nextNumber}/MOI-FIT/{$bulan}/{$tahun}";
            });
        });

        // === Saat Update Data ===
        static::updating(function ($model) {
            // Nomor dokumen tidak boleh berubah
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

    /**
     * Ubah angka menjadi kata (Bahasa Indonesia) + "Rupiah".
     * Contoh: 50000000 -> "Lima Puluh Juta Rupiah"
     */
    public static function terbilang($angka)
    {
        $angka = (int) round((float) $angka);

        if ($angka === 0) {
            return 'Nol Rupiah';
        }

        $hasil = trim(self::terbilangHelper($angka));
        // Rapikan spasi ganda
        $hasil = preg_replace('/\s+/', ' ', $hasil);

        return ucwords($hasil) . ' Rupiah';
    }

    protected static function terbilangHelper($angka)
    {
        $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima',
                  'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($angka < 12) {
            return ' ' . $huruf[$angka];
        } elseif ($angka < 20) {
            return self::terbilangHelper($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            return self::terbilangHelper(intdiv($angka, 10)) . ' puluh' . self::terbilangHelper($angka % 10);
        } elseif ($angka < 200) {
            return ' seratus' . self::terbilangHelper($angka - 100);
        } elseif ($angka < 1000) {
            return self::terbilangHelper(intdiv($angka, 100)) . ' ratus' . self::terbilangHelper($angka % 100);
        } elseif ($angka < 2000) {
            return ' seribu' . self::terbilangHelper($angka - 1000);
        } elseif ($angka < 1000000) {
            return self::terbilangHelper(intdiv($angka, 1000)) . ' ribu' . self::terbilangHelper($angka % 1000);
        } elseif ($angka < 1000000000) {
            return self::terbilangHelper(intdiv($angka, 1000000)) . ' juta' . self::terbilangHelper($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return self::terbilangHelper(intdiv($angka, 1000000000)) . ' miliar' . self::terbilangHelper($angka % 1000000000);
        } else {
            return self::terbilangHelper(intdiv($angka, 1000000000000)) . ' triliun' . self::terbilangHelper($angka % 1000000000000);
        }
    }
}
