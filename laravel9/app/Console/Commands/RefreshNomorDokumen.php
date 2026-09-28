<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Masterpenagihan;

class RefreshNomorDokumen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:nomor-dokumen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh nomor_dokumen for all existing records in masterpenagihans table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = Masterpenagihan::all();

        foreach ($records as $record) {
            // Gunakan tanggal_dokumen untuk mendapatkan bulan dan tahun
            if ($record->tanggal_dokumen) {
                $bulan = $this->convertToRoman(\Carbon\Carbon::parse($record->tanggal_dokumen)->format('m'));
                $tahun = \Carbon\Carbon::parse($record->tanggal_dokumen)->format('Y');
            } else {
                // Fallback ke tanggal saat ini jika tanggal_dokumen kosong
                $bulan = $this->convertToRoman(now()->format('m'));
                $tahun = now()->format('Y');
            }

            // Format ID dengan padding nol (contoh: 001, 002)
            $idPadded = str_pad($record->id, 3, '0', STR_PAD_LEFT);

            // Perbarui nomor_dokumen
            $record->nomor_dokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$tahun}";
            $record->save();
        }

        $this->info('Nomor dokumen has been refreshed for all records.');
        return 0;
    }

    /**
     * Convert month number to Roman numeral.
     *
     * @param int $month
     * @return string
     */
    protected function convertToRoman($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];

        return $map[(int) $month];
    }
}