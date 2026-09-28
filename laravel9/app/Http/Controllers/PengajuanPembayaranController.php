<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanpembayaran;
use App\Models\detail_pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PengajuanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        // Filter data berdasarkan parameter request
        $query = Pengajuanpembayaran::with('detail_pengajuan');
        
        // Filter status
        if ($request->has('status') && $request->status) {
            $query->where('status_bayar', $request->status);
        }
        
        // Filter tanggal
        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        
        // Filter supplier
        if ($request->has('supplier') && $request->supplier) {
            $query->where('nama_supplier', 'like', '%' . $request->supplier . '%');
        }
        
        // // Urutkan berdasarkan waktu terbaru
        // $pengajuans = $query->orderBy('created_at', 'desc')
        //     ->paginate(10)
        //     ->withQueryString();
        // Get per_page value from request or default to 10
        $perPage = $request->input('per_page', 10);
       
        $pengajuans = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        return view('pengajuan-pembayaran.index', compact('pengajuans'));
    }

    public function create()
    {
        // Data untuk dropdown mata uang
        $mataUangOptions = [
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'CNY' => 'CNY (Chinese Yuan)',
            'EUR' => 'EUR (Euro)',
            'JPY' => 'JPY (Japanese Yen)',
        ];
        
        return view('pengajuan-pembayaran.create', compact('mataUangOptions'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_supplier' => 'required|max:255',
            'sumber_dana' => 'required|max:255',
            'mata_uang' => 'required|in:IDR,USD,CNY,EUR,JPY',
            'rencana_bayar' => 'required|date',
            'note' => 'nullable|string|max:1000',
            'kurs' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:pending,completed,processed',
            'tipe_pembayaran' => 'required|max:255',
            'detail_pengajuan' => 'required|array|min:1',
            'detail_pengajuan.*.tanggal_dokumen' => 'required|date',
            'detail_pengajuan.*.uraian' => 'required|string|max:255',
            'detail_pengajuan.*.jumlah' => 'required|numeric|min:0',
            'detail_pengajuan.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi sebelum menyimpan data.',
            'detail_pengajuan.required' => 'Minimal harus ada satu detail pengajuan',
            'detail_pengajuan.min' => 'Minimal harus ada satu detail pengajuan',
            'detail_pengajuan.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);

        DB::beginTransaction();
            try {
                // Hitung grand total dalam mata uang asli
                $grandTotal = (float) collect($request->detail_pengajuan)->sum('jumlah');
                
                // Convert ke IDR jika bukan IDR
                $grandTotalIDR = $grandTotal;
                if ($request->mata_uang !== 'IDR') {
                    $grandTotalIDR = $grandTotal * $request->kurs;
                }
                
                // Hitung potongan dalam IDR
                $potonganHarga = (float) ($request->potongan_harga ?? 0);
                $totalPotongan = 0;
                
                if ($request->tipe_potong == 'on_net_total' && $potonganHarga > 0) {
                    $totalPotongan = $grandTotalIDR * ($potonganHarga / 100);
                } else {
                    $totalPotongan = $potonganHarga;
                }
                 // Get biaya admin
                $biayaAdmin = (float) ($request->biaya_admin ?? 0);

                // Total bayar selalu dalam IDR
                $totalBayar = $grandTotalIDR - $totalPotongan + $biayaAdmin;
                
                $pengajuan = new Pengajuanpembayaran();
                $pengajuan->tanggal = $request->tanggal;
                $pengajuan->nama_supplier = $request->nama_supplier;
                $pengajuan->sumber_dana = $request->sumber_dana;
                $pengajuan->mata_uang = $request->mata_uang;
                $pengajuan->rencana_bayar = $request->rencana_bayar;
                $pengajuan->note = $request->note;
                $pengajuan->kurs = $request->kurs;
                $pengajuan->status_bayar = $request->status_bayar;
                $pengajuan->tipe_pembayaran = $request->tipe_pembayaran;
                $pengajuan->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
                $pengajuan->tipe_potong = $request->tipe_potong ?? 'actual';
                $pengajuan->keterangan_potong = $request->keterangan_potong;
                $pengajuan->lampiran = $request->lampiran;
                $pengajuan->potongan_harga = $potonganHarga;
                $pengajuan->biaya_admin = $biayaAdmin; // Set biaya admin
                $pengajuan->grand_total = $grandTotal; // Dalam mata uang asli
                $pengajuan->total_bayar = $totalBayar; // Selalu dalam IDR
                $pengajuan->save();

            // Simpan detail pengajuan
            foreach ($request->detail_pengajuan as $detail) {
                $pengajuan->detail_pengajuan()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-pembayaran.show', $pengajuan->id)
                ->with('success', 'Pengajuan pembayaran berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating pengajuan pembayaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(Request $request, Pengajuanpembayaran $pengajuan)
    {
        // Load detail pengajuan
        $pengajuan->load('detail_pengajuan');
        // Ambil semua query parameter (page, search, dll)
        $queryParams = $request->query();
        return view('pengajuan-pembayaran.show', compact('pengajuan', 'queryParams'));
        
    }

    public function edit(Pengajuanpembayaran $pengajuan)
    {
        // Data untuk dropdown mata uang
        $mataUangOptions = [
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'CNY' => 'CNY (Chinese Yuan)',
            'EUR' => 'EUR (Euro)',
            'JPY' => 'JPY (Japanese Yen)',
        ];
        
        // Load detail pengajuan
        $pengajuan->load('detail_pengajuan');
        
        return view('pengajuan-pembayaran.edit', compact('pengajuan', 'mataUangOptions'));
    }

     public function update(Request $request, Pengajuanpembayaran $pengajuan)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_supplier' => 'required|max:255',
            'sumber_dana' => 'required|max:255',
            'mata_uang' => 'required|in:IDR,USD,CNY,EUR,JPY',
            'rencana_bayar' => 'required|date',
            'note' => 'nullable|string|max:1000',
            'kurs' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:pending,completed,processed',
            'tipe_pembayaran'=> 'required|max:255',
            'detail_pengajuan' => 'required|array|min:1',
            'detail_pengajuan.*.tanggal_dokumen' => 'required|date',
            'detail_pengajuan.*.uraian' => 'required|string|max:255',
            'detail_pengajuan.*.jumlah' => 'required|numeric|min:0',
            'detail_pengajuan.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'detail_pengajuan.required' => 'Minimal harus ada satu detail pengajuan',
            'detail_pengajuan.min' => 'Minimal harus ada satu detail pengajuan',
            'detail_pengajuan.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);

        DB::beginTransaction();
        try {
             // Hitung grand total dalam mata uang asli
             $grandTotal = (float) collect($request->detail_pengajuan)->sum('jumlah');
                
             // Convert ke IDR jika bukan IDR
             $grandTotalIDR = $grandTotal;
             if ($request->mata_uang !== 'IDR') {
                 $grandTotalIDR = $grandTotal * $request->kurs;
             }
             
             // Hitung potongan dalam IDR
             $potonganHarga = (float) ($request->potongan_harga ?? 0);
             $totalPotongan = 0;
             
             if ($request->tipe_potong == 'on_net_total' && $potonganHarga > 0) {
                 $totalPotongan = $grandTotalIDR * ($potonganHarga / 100);
             } else {
                 $totalPotongan = $potonganHarga;
             }
              // Get biaya admin
             $biayaAdmin = (float) ($request->biaya_admin ?? 0);

             // Total bayar selalu dalam IDR
             $totalBayar = $grandTotalIDR - $totalPotongan + $biayaAdmin;
             
            // Update pengajuan pembayaran
            $pengajuan->tanggal = $request->tanggal;
            $pengajuan->nama_supplier = $request->nama_supplier;
            $pengajuan->sumber_dana = $request->sumber_dana;
            $pengajuan->mata_uang = $request->mata_uang;
            $pengajuan->rencana_bayar = $request->rencana_bayar;
            $pengajuan->note = $request->note;
            $pengajuan->kurs = $request->kurs;
            $pengajuan->status_bayar = $request->status_bayar;
            $pengajuan->tipe_pembayaran = $request->tipe_pembayaran;
            $pengajuan->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
            $pengajuan->tipe_potong = $request->tipe_potong ?? 'actual';
            $pengajuan->keterangan_potong = $request->keterangan_potong;
            $pengajuan->lampiran = $request->lampiran;
            $pengajuan->potongan_harga = $potonganHarga;
            $pengajuan->biaya_admin = $biayaAdmin; 
            $pengajuan->grand_total = $grandTotal;
            $pengajuan->total_bayar = $totalBayar;
            $pengajuan->save();

            // Hapus detail pengajuan lama
            $pengajuan->detail_pengajuan()->delete();
            
            // Buat detail pengajuan baru
            foreach ($request->detail_pengajuan as $detail) {
                $pengajuan->detail_pengajuan()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-pembayaran.show', $pengajuan->id)
                ->with('success', 'Pengajuan pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating pengajuan pembayaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Pengajuanpembayaran $pengajuan)
    {
        DB::beginTransaction();
        try {
            // Hapus detail pengajuan
            $pengajuan->detail_pengajuan()->delete();
            
            // Hapus pengajuan
            $pengajuan->delete();
            
            DB::commit();
            return redirect()->route('pengajuan-pembayaran.index')
                ->with('success', 'Pengajuan pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting pengajuan pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Pengajuanpembayaran $pengajuan)
    {
        DB::beginTransaction();
        try {
            $pengajuan->status_bayar = 'completed';
            $pengajuan->save();
            
            DB::commit();
              $page = $request->input('page', 1);

        // Redirect kembali ke halaman pagination yang sama
        return redirect()
         ->back()
            // ->route('pengajuan-pembayaran.index', ['page' => $page])
                ->with('success', 'Status pembayaran berhasil diperbarui menjadi Completed');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating pengajuan status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage());
        }
    }

   
    
}