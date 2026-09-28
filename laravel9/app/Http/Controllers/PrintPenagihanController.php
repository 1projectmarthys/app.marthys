<?php

namespace App\Http\Controllers;

use App\Models\Masterpenagihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintPenagihanController extends Controller
{
    public function print($id)
    {
        // Ambil data master penagihan berdasarkan ID
        $masterPenagihan = Masterpenagihan::with('detail_penagihan')->findOrFail($id);

        // Get current month and year from tanggal_dokumen
        $tanggal = $masterPenagihan->tanggal_dokumen;
        $currentMonth = date('m', strtotime($tanggal));
        $currentYear = date('Y', strtotime($tanggal));

        // Count documents for current month and year
        $lastIdForMonth = Masterpenagihan::whereRaw("DATE_FORMAT(tanggal_dokumen, '%m-%Y') = ?", [date('m-Y', strtotime($tanggal))])
            ->where('id', '<=', $masterPenagihan->id)
            ->count();

        // Format ID with leading zeros
        $idPadded = str_pad($lastIdForMonth, 2, '0', STR_PAD_LEFT);

        // Get Roman numeral for month
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulan = $bulanRomawi[(int)$currentMonth];
        
        // Create document number
        $nomorDokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$currentYear}";

        // Format total tagihan
        $totalTagihan = $masterPenagihan->total_tagihan;
        $formatRupiah = "Rp " . number_format($totalTagihan, 2, ',', '.');

        // Calculate terbilang text
        $terbilangText = $this->terbilang($totalTagihan);

        // Kirim data ke view dengan semua variabel yang diperlukan
        return view('masterpenagihan.printpenagihan', compact(
            'masterPenagihan', 
            'nomorDokumen', 
            'formatRupiah', 
            'terbilangText'
        ));
    }

    public function printkwitansi($id)
    {
        // Ambil data master penagihan berdasarkan ID
        $masterPenagihan = Masterpenagihan::with('detail_penagihan')->findOrFail($id);

        // Get current month and year from tanggal_dokumen
        $tanggal = $masterPenagihan->tanggal_dokumen;
        $currentMonth = date('m', strtotime($tanggal));
        $currentYear = date('Y', strtotime($tanggal));

        // Count documents for current month and year
        $lastIdForMonth = Masterpenagihan::whereRaw("DATE_FORMAT(tanggal_dokumen, '%m-%Y') = ?", [date('m-Y', strtotime($tanggal))])
            ->where('id', '<=', $masterPenagihan->id)
            ->count();

        // Format ID with leading zeros
        $idPadded = str_pad($lastIdForMonth, 2, '0', STR_PAD_LEFT);

        // Get Roman numeral for month
        $bulanRomawi = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        $bulan = $bulanRomawi[(int)$currentMonth];
        
        // Create document numbers
        $nomorDokumen = "{$idPadded}/MOI-TTT/{$bulan}/{$currentYear}";
        $nomorDokumen2 = "{$idPadded}/MOI-KWT/{$bulan}/{$currentYear}";

        // Format total tagihan
        $totalTagihan = $masterPenagihan->total_tagihan;
        $formatRupiah = "Rp " . number_format($totalTagihan, 2, ',', '.');

        // Calculate terbilang text
        $terbilangText = $this->terbilang($totalTagihan);

        // Format tanggal untuk tampilan Indonesia
        $tanggalIndo = Carbon::parse($tanggal)->translatedFormat('d F Y');

        // Kirim data ke view dengan semua variabel yang diperlukan
        return view('masterpenagihan.kwitansipenagihan', compact(
            'masterPenagihan', 
            'nomorDokumen',
            'nomorDokumen2', 
            'formatRupiah', 
            'terbilangText',
            'tanggalIndo'
        ));
    }

    // Helper function to convert numbers to words
    private function terbilang($angka) 
    {
        $angka = (int)$angka;
        $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        
        if ($angka < 12) {
            return $huruf[$angka];
        } elseif ($angka < 20) {
            return $this->terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return $this->terbilang(floor($angka / 10)) . ' Puluh ' . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'Seratus ' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilang(floor($angka / 100)) . ' Ratus ' . $this->terbilang($angka % 100);
        } elseif ($angka < 1000000) {
            return $this->terbilang(floor($angka / 1000)) . ' Ribu ' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang(floor($angka / 1000000)) . ' Juta ' . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return $this->terbilang(floor($angka / 1000000000)) . ' Miliar ' . $this->terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            return $this->terbilang(floor($angka / 1000000000000)) . ' Triliun ' . $this->terbilang($angka % 1000000000000);
        } else {
            return 'Angka terlalu besar';
        }
    }
}
