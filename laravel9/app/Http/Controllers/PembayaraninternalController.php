<?php

namespace App\Http\Controllers;

use App\Models\pembayaraninternal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaraninternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = pembayaraninternal::query();
         // Filter data berdasarkan parameter request
        $query = pembayaraninternal::with('detail_pembayaraninternal');
        
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
        // $pembayaraninternals = $query->orderBy('created_at', 'desc')
        //     ->paginate(10)
        //     ->withQueryString();
        // Get per_page value from request or default to 10
        $perPage = $request->input('per_page', 10);
       
        $pembayaraninternals = $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        return view('pembayaraninternal.index', compact('pembayaraninternals'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
          // Data untuk dropdown mata uang
        $mataUangOptions = [
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'CNY' => 'CNY (Chinese Yuan)',
            'EUR' => 'EUR (Euro)',
            'JPY' => 'JPY (Japanese Yen)',
        ];
        return view('pembayaraninternal.create', compact('mataUangOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_supplier' => 'required|max:255',
            'sumber_dana' => 'required|max:255',
            'mata_uang' => 'required|in:IDR,USD,CNY,EUR,JPY',
            'rencana_bayar' => 'required|date',
            'kurs' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:pending,completed,processed',
            'tipe_pembayaran' => 'required|max:255',
            'detail_pembayaraninternal' => 'required|array|min:1',
            'detail_pembayaraninternal.*.tanggal_dokumen' => 'required|date',
            'detail_pembayaraninternal.*.uraian' => 'required|string|max:255',
            'detail_pembayaraninternal.*.jumlah' => 'required|numeric|min:0',
            'detail_pembayaraninternal.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'detail_pembayaraninternal.required' => 'Minimal harus ada satu detail pembayaraninternal',
            'detail_pembayaraninternal.min' => 'Minimal harus ada satu detail pembayaraninternal',
            'detail_pembayaraninternal.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);
        // Hitung grand total dari detail pembayaraninternal
        DB::beginTransaction();

            try {
                // Hitung grand total dalam mata uang asli
                $grandTotal = (float) collect($request->detail_pembayaraninternal)->sum('jumlah');
                
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
                
                $pembayaraninternal = new pembayaraninternal();
                $pembayaraninternal->tanggal = $request->tanggal;
                $pembayaraninternal->note = $request->note;
                $pembayaraninternal->nama_supplier = $request->nama_supplier;
                $pembayaraninternal->sumber_dana = $request->sumber_dana;
                $pembayaraninternal->mata_uang = $request->mata_uang;
                $pembayaraninternal->rencana_bayar = $request->rencana_bayar;
                $pembayaraninternal->kurs = $request->kurs;
                $pembayaraninternal->status_bayar = $request->status_bayar;
                $pembayaraninternal->tipe_pembayaran = $request->tipe_pembayaran;
                $pembayaraninternal->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
                $pembayaraninternal->tipe_potong = $request->tipe_potong ?? 'actual';
                $pembayaraninternal->keterangan_potong = $request->keterangan_potong;
                $pembayaraninternal->lampiran = $request->lampiran;
                $pembayaraninternal->potongan_harga = $potonganHarga;
                $pembayaraninternal->biaya_admin = $biayaAdmin; // Set biaya admin
                $pembayaraninternal->grand_total = $grandTotal; // Dalam mata uang asli
                $pembayaraninternal->total_bayar = $totalBayar; // Selalu dalam IDR
                $pembayaraninternal->save();

            // Simpan detail $pembayaraninternal
            foreach ($request->detail_pembayaraninternal as $detail) {
                $pembayaraninternal->detail_pembayaraninternal()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('pembayaraninternal.show', $pembayaraninternal->id)
                ->with('success', '$pembayaraninternal pembayaran berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating $pembayaraninternal pembayaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pembayaraninternal  $pembayaraninternal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,pembayaraninternal $pembayaraninternal)
    {
        //
         // Load detail $pembayaraninternal
        $pembayaraninternal->load('detail_pembayaraninternal');
        // Ambil semua query parameter (page, search, dll)
        $queryParams = $request->query();
        return view('pembayaraninternal.show', compact('pembayaraninternal', 'queryParams'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pembayaraninternal  $pembayaraninternal
     * @return \Illuminate\Http\Response
     */
    public function edit(pembayaraninternal $pembayaraninternal)
    {
        // Data untuk dropdown mata uang
        $mataUangOptions = [
            'IDR' => 'IDR (Indonesian Rupiah)',
            'USD' => 'USD (US Dollar)',
            'CNY' => 'CNY (Chinese Yuan)',
            'EUR' => 'EUR (Euro)',
            'JPY' => 'JPY (Japanese Yen)',
        ];
        
        // Load detail $pembayaraninternal
        $pembayaraninternal->load('detail_pembayaraninternal');
        
        return view('pembayaraninternal.edit', compact('pembayaraninternal', 'mataUangOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pembayaraninternal  $pembayaraninternal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pembayaraninternal $pembayaraninternal)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_supplier' => 'required|max:255',
            'sumber_dana' => 'required|max:255',
            'mata_uang' => 'required|in:IDR,USD,CNY,EUR,JPY',
            'rencana_bayar' => 'required|date',
            'kurs' => 'required|numeric|min:0',
            'status_bayar' => 'required|in:pending,completed,processed',
            'tipe_pembayaran'=> 'required|max:255',
            'detail_pembayaraninternal' => 'required|array|min:1',
            'detail_pembayaraninternal.*.tanggal_dokumen' => 'required|date',
            'detail_pembayaraninternal.*.uraian' => 'required|string|max:255',
            'detail_pembayaraninternal.*.jumlah' => 'required|numeric|min:0',
            'detail_pembayaraninternal.*.keterangan' => 'nullable|string|max:255',
            'biaya_admin' => 'nullable|numeric|min:0',
        ], [
            'detail_pembayaraninternal.required' => 'Minimal harus ada satu detail $pembayaraninternal',
            'detail_pembayaraninternal.min' => 'Minimal harus ada satu detail $pembayaraninternal',
            'detail_pembayaraninternal.*.jumlah.min' => 'Jumlah tidak boleh negatif',
            'kurs.min' => 'Nilai kurs tidak boleh negatif',
            'biaya_admin.min' => 'Nilai biaya admin tidak boleh negatif',
        ]);
        DB::beginTransaction();
        try {
             // Hitung grand total dalam mata uang asli
             $grandTotal = (float) collect($request->detail_pembayaraninternal)->sum('jumlah');
                
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
             
            // Update $pembayaraninternal pembayaran
            $pembayaraninternal->tanggal = $request->tanggal;
            $pembayaraninternal->note = $request->note;
            $pembayaraninternal->nama_supplier = $request->nama_supplier;
            $pembayaraninternal->sumber_dana = $request->sumber_dana;
            $pembayaraninternal->mata_uang = $request->mata_uang;
            $pembayaraninternal->rencana_bayar = $request->rencana_bayar;
            $pembayaraninternal->kurs = $request->kurs;
            $pembayaraninternal->status_bayar = $request->status_bayar;
            $pembayaraninternal->tipe_pembayaran = $request->tipe_pembayaran;
            $pembayaraninternal->jumlah_kolom = $request->jumlah_kolom ?? '3kolom';
            $pembayaraninternal->tipe_potong = $request->tipe_potong ?? 'actual';
            $pembayaraninternal->keterangan_potong = $request->keterangan_potong;
            $pembayaraninternal->lampiran = $request->lampiran;
            $pembayaraninternal->potongan_harga = $potonganHarga;
            $pembayaraninternal->biaya_admin = $biayaAdmin; 
            $pembayaraninternal->grand_total = $grandTotal;
            $pembayaraninternal->total_bayar = $totalBayar;
            $pembayaraninternal->save();

            // Hapus detail $pembayaraninternal lama
            $pembayaraninternal->detail_pembayaraninternal()->delete();
            
            // Buat detail $pembayaraninternal baru
            foreach ($request->detail_pembayaraninternal as $detail) {
                $pembayaraninternal->detail_pembayaraninternal()->create([
                    'tanggal_dokumen' => $detail['tanggal_dokumen'],
                    'uraian' => $detail['uraian'],
                    'jumlah' => $detail['jumlah'],
                    'keterangan' => $detail['keterangan'] ?? null
                ]);
            }

            DB::commit();
            return redirect()->route('pembayaraninternal.show', $pembayaraninternal->id)
                ->with('success', '$pembayaraninternal pembayaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating $pembayaraninternal pembayaran: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pembayaraninternal  $pembayaraninternal
     * @return \Illuminate\Http\Response
     */
    public function destroy(pembayaraninternal $pembayaraninternal)
    {
        //
            DB::beginTransaction();
        try {
            // Hapus detail $pembayaraninternal
            $pembayaraninternal->detail_pembayaraninternal()->delete();
            
            // Hapus $pembayaraninternal
            $pembayaraninternal->delete();
            
            DB::commit();
            return redirect()->route('pembayaraninternal.index')
                ->with('success', '$pembayaraninternal pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error deleting $pembayaraninternal pembayaran: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
      public function updateStatus(Request $request, pembayaraninternal $pembayaraninternal)
    {
        DB::beginTransaction();
        try {
            $pembayaraninternal->status_bayar = 'completed';
            $pembayaraninternal->save();
            
            DB::commit();
              $page = $request->input('page', 1);

        // Redirect kembali ke halaman pagination yang sama
        return redirect()
         ->back()
            // ->route('$pembayaraninternal-pembayaran.index', ['page' => $page])
                ->with('success', 'Status pembayaran berhasil diperbarui menjadi Completed');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating $pembayaraninternal status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage());
        }
    }
}
