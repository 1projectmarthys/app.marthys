<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\detail_purchasing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PurchasingController extends Controller
{
    public function index(Request $request)
    {
        // Filter data berdasarkan parameter request
        $query = Purchasing::with('detail_purchasing');
        
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
        // $purchasings = $query->orderBy('created_at', 'desc')
        //     ->paginate(10)
        //     ->withQueryString();
        // Get per_page value from request or default to 10
        $perPage = $request->input('per_page', 10);
       
        $purchasings = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        return view('purchasing.index', compact('purchasings'));
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
        
        return view('purchasing.create', compact('mataUangOptions'));
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
            'detail_purchasing' => 'required|array|min:1',
            'detail_purchasing.*.tanggal_dokumen' => 'required|date',
            'detail_purchasing.*.uraian' => 'required|string|max:255',
            'detail_purchasing.*.jumlah' => 'required|numeric|min:0',
            'detail_purchasing.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi sebelum menyimpan data.',
            'detail_purchasing.required' => 'Minimal harus ada satu detail purchasing',
            'detail_purchasing.min' => 'Minimal harus ada satu detail purchasing',
            'detail_purchasing.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);

        DB::beginTransaction();
            try {
                // Hitung grand total dalam mata uang asli
                $grandTotal = (float) collect($request->detail_purchasing)->sum('jumlah');
                
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
                
                $purchasing = new Purchasing();
                $purchasing->tanggal = $request->tanggal;
                $purchasing->nama_supplier = $request->nama_supplier;
                $purchasing->sumber_dana = $request->sumber_dana;
                $purchasing->mata_uang = $request->mata_uang;
                $purchasing->rencana_bayar = $request->rencana_bayar;
                $purchasing->note = $request->note;
                $purchasing->kurs = $request->kurs;
                $purchasing->status_bayar = $request->status_bayar;
                $purchasing->tipe_pembayaran = $request->tipe_pembayaran;
                $purchasing->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
                $purchasing->tipe_potong = $request->tipe_potong ?? 'actual';
                $purchasing->keterangan_potong = $request->keterangan_potong;
                $purchasing->lampiran = $request->lampiran;
                $purchasing->potongan_harga = $potonganHarga;
                $purchasing->biaya_admin = $biayaAdmin; // Set biaya admin
                $purchasing->grand_total = $grandTotal; // Dalam mata uang asli
                $purchasing->total_bayar = $totalBayar; // Selalu dalam IDR
                $purchasing->save();

            // Simpan detail purchasing
            foreach ($request->detail_purchasing as $detail) {
                $purchasing->detail_purchasing()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('purchasing.show', $purchasing->id)
                ->with('success', 'Purchasing berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating purchasing: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(Request $request, Purchasing $purchasing)
    {
        // Load detail purchasing
        $purchasing->load('detail_purchasing');
        // Ambil semua query parameter (page, search, dll)
        $queryParams = $request->query();
        return view('purchasing.show', compact('purchasing', 'queryParams'));
        
    }

    public function edit(Purchasing $purchasing)
    {
        // Data untuk dropdown mata uang
        $mataUangOptions = [
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'CNY' => 'CNY (Chinese Yuan)',
            'EUR' => 'EUR (Euro)',
            'JPY' => 'JPY (Japanese Yen)',
        ];
        
        // Load detail purchasing
        $purchasing->load('detail_purchasing');
        
        return view('purchasing.edit', compact('purchasing', 'mataUangOptions'));
    }

     public function update(Request $request, Purchasing $purchasing)
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
            'detail_purchasing' => 'required|array|min:1',
            'detail_purchasing.*.tanggal_dokumen' => 'required|date',
            'detail_purchasing.*.uraian' => 'required|string|max:255',
            'detail_purchasing.*.jumlah' => 'required|numeric|min:0',
            'detail_purchasing.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'detail_purchasing.required' => 'Minimal harus ada satu detail purchasing',
            'detail_purchasing.min' => 'Minimal harus ada satu detail purchasing',
            'detail_purchasing.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);

        DB::beginTransaction();
        try {
             // Hitung grand total dalam mata uang asli
             $grandTotal = (float) collect($request->detail_purchasing)->sum('jumlah');
                
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
             
            // Update purchasing
            $purchasing->tanggal = $request->tanggal;
            $purchasing->nama_supplier = $request->nama_supplier;
            $purchasing->sumber_dana = $request->sumber_dana;
            $purchasing->mata_uang = $request->mata_uang;
            $purchasing->rencana_bayar = $request->rencana_bayar;
            $purchasing->note = $request->note;
            $purchasing->kurs = $request->kurs;
            $purchasing->status_bayar = $request->status_bayar;
            $purchasing->tipe_pembayaran = $request->tipe_pembayaran;
            $purchasing->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
            $purchasing->tipe_potong = $request->tipe_potong ?? 'actual';
            $purchasing->keterangan_potong = $request->keterangan_potong;
            $purchasing->lampiran = $request->lampiran;
            $purchasing->potongan_harga = $potonganHarga;
            $purchasing->biaya_admin = $biayaAdmin; 
            $purchasing->grand_total = $grandTotal;
            $purchasing->total_bayar = $totalBayar;
            $purchasing->save();

            // Hapus detail purchasing lama
            $purchasing->detail_purchasing()->delete();
            
            // Buat detail purchasing baru
            foreach ($request->detail_purchasing as $detail) {
                $purchasing->detail_purchasing()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('purchasing.show', $purchasing->id)
                ->with('success', 'Purchasing berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating purchasing: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Purchasing $purchasing)
    {
        DB::beginTransaction();
        try {
            // Hapus detail purchasing
            $purchasing->detail_purchasing()->delete();
            
            // Hapus purchasing
            $purchasing->delete();
            
            DB::commit();
            return redirect()->route('purchasing.index')
                ->with('success', 'Purchasing berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting purchasing: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Purchasing $purchasing)
    {
        DB::beginTransaction();
        try {
            $purchasing->status_bayar = 'completed';
            $purchasing->save();
            
            DB::commit();
              $page = $request->input('page', 1);

        // Redirect kembali ke halaman pagination yang sama
        return redirect()
         ->back()
            // ->route('purchasing.index', ['page' => $page])
                ->with('success', 'Status pembayaran berhasil diperbarui menjadi Completed');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating purchasing status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage());
        }
    }

   
    
}