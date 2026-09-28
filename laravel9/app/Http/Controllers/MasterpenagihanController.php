<?php

namespace App\Http\Controllers;

use App\Models\Masterpenagihan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Terbilang;
use Illuminate\Support\Facades\Log;

class MasterpenagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Masterpenagihan::with('detail_penagihan');
        
        // Apply search filter
        // if ($request->has('search') && !empty($request->search)) {
        //     $search = $request->search;
        //     $query->where(function($q) use ($search) {
        //         $q->where('nomor_dokumen', 'like', "%{$search}%")
        //           ->orWhere('nama_customer', 'like', "%{$search}%")
        //           ->orWhere('kode_customer', 'like', "%{$search}%")
        //           ->orWhere('alamat_customer', 'like', "%{$search}%");
                  
        //     });
        // }
        if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
            
                $query->where(function($q) use ($search) {
                    $q->where('nomor_dokumen', 'like', "%{$search}%")
                      ->orWhere('nama_customer', 'like', "%{$search}%")
                      ->orWhere('kode_customer', 'like', "%{$search}%")
                      ->orWhere('alamat_customer', 'like', "%{$search}%");
                })->orWhereHas('detail_penagihan', function ($q) use ($search) {
                    $q->where('no_faktur', 'like', "%{$search}%");
                });
            }
        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status_bayar', $request->status);
        }
        
        // Apply date filter
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('tanggal_dokumen', $request->date);
        }
        
        // Set pagination
        $perPage = $request->input('per_page', 10);
        
        $masterpenaghihans = $query->orderBy('id', 'asc')
            ->paginate($perPage)
            ->appends($request->except('page'));
        
        return view('masterpenagihan.index', compact('masterpenaghihans'));
    }

    public function create()
    {
        return view('masterpenagihan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_dokumen' => 'required|date',
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'kode_customer' => 'required',
            'status_bayar' => 'required|in:pending,completed,canceled',
            'detail_penagihan' => 'required|array',
            'detail_penagihan.*.tanggal' => 'required|date',
            'detail_penagihan.*.no_faktur' => 'required',
            'detail_penagihan.*.no_faktur_pajak' => 'required',
            'detail_penagihan.*.jumlah' => 'required|numeric',
        ]);

        $masterpenagihan = new Masterpenagihan();
        $masterpenagihan->nomor_dokumen = 'PEN-' . date('YmdHis');
        $masterpenagihan->tanggal_dokumen = $request->tanggal_dokumen;
        $masterpenagihan->nama_customer = $request->nama_customer;
        $masterpenagihan->alamat_customer = $request->alamat_customer;
        $masterpenagihan->kode_customer = $request->kode_customer;
        $masterpenagihan->keterangan_lengkap = $request->keterangan_lengkap;
        $masterpenagihan->status_bayar = $request->status_bayar;
        $masterpenagihan->save();

        foreach ($request->detail_penagihan as $detail) {
            $masterpenagihan->detail_penagihan()->create([
                'tanggal' => $detail['tanggal'],
                'no_faktur' => $detail['no_faktur'],
                'no_faktur_pajak' => $detail['no_faktur_pajak'],
                'jumlah' => $detail['jumlah'],
                'keterangan' => $detail['keterangan'] ?? null,
            ]);
        }

        // Update total tagihan
        $total_tagihan = $masterpenagihan->detail_penagihan()->sum('jumlah');
        $masterpenagihan->total_tagihan = $total_tagihan;
        $masterpenagihan->save();
        // 'masterpenagihan.index'
        return redirect()->route('masterpenagihan.index')
            ->with('success', 'Data penagihan berhasil dibuat');
    }

    public function show(Masterpenagihan $masterpenagihan)
    {
        return view('masterpenagihan.show', compact('masterpenagihan'));
    }

    public function edit(Masterpenagihan $masterpenagihan)
    {
        // Load the detail_penagihan relationship
        $masterpenagihan->load('detail_penagihan');
        
        return view('masterpenagihan.edit', compact('masterpenagihan'));
    }

    public function update(Request $request, Masterpenagihan $masterpenagihan)
    {
        $request->validate([
            'tanggal_dokumen' => 'required|date',
            'nama_customer' => 'required',
            'alamat_customer' => 'required',
            'kode_customer' => 'required',
            'status_bayar' => 'required|in:pending,completed,canceled',
            'detail_penagihan' => 'required|array',
            'detail_penagihan.*.tanggal' => 'required|date',
            'detail_penagihan.*.no_faktur' => 'required',
            'detail_penagihan.*.no_faktur_pajak' => 'required',
            'detail_penagihan.*.jumlah' => 'required|numeric',
        ]);

        // Update main record
        $masterpenagihan->tanggal_dokumen = $request->tanggal_dokumen;
        $masterpenagihan->nama_customer = $request->nama_customer;
        $masterpenagihan->alamat_customer = $request->alamat_customer;
        $masterpenagihan->kode_customer = $request->kode_customer;
        $masterpenagihan->status_bayar = $request->status_bayar;
        $masterpenagihan->keterangan_lengkap = $request->keterangan_lengkap;
        
        // Delete all existing detail records
        $masterpenagihan->detail_penagihan()->delete();
        
        // Create new detail records
        foreach ($request->detail_penagihan as $detail) {
            $masterpenagihan->detail_penagihan()->create([
                'tanggal' => $detail['tanggal'],
                'no_faktur' => $detail['no_faktur'],
                'no_faktur_pajak' => $detail['no_faktur_pajak'],
                'jumlah' => $detail['jumlah'],
                'keterangan' => $detail['keterangan'] ?? null,
            ]);
        }
        
        // Update total tagihan
        $total_tagihan = $masterpenagihan->detail_penagihan()->sum('jumlah');
        $masterpenagihan->total_tagihan = $total_tagihan;
        $masterpenagihan->save();

        return redirect()
            ->route('masterpenagihan.index')
            ->with('success', 'Penagihan berhasil diperbarui');
    }

    public function destroy(Request $request, Masterpenagihan $masterpenagihan)
    {
        try {
            Log::info('Attempting to delete penagihan: ' . $masterpenagihan->id);
            log::info('Attempting to delete penagihan: ' . $masterpenagihan->id);
            
            // Delete related records first
            $detailCount = $masterpenagihan->detail_penagihan()->count();
            $deletedDetails = $masterpenagihan->detail_penagihan()->delete();
            Log::info("Detail deletion: {$detailCount} details found, {$deletedDetails} deleted");
            
            // Then delete the master record
            $deleted = $masterpenagihan->delete();
            Log::info("Master deletion result: " . ($deleted ? 'success' : 'failed'));

            if ($deleted) {
                return redirect()->route('masterpenagihan.index')
                    ->with('success', 'Data penagihan berhasil dihapus');
            } else {
                return redirect()->route('masterpenagihan.index')
                    ->with('error', 'Gagal menghapus data penagihan');
            }
        } catch (\Exception $e) {
            Log::error('Error deleting penagihan: ' . $e->getMessage());
            return redirect()->route('masterpenagihan.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function updateStatus(Masterpenagihan $masterpenagihan)
    {
        $masterpenagihan->status_bayar = 'completed';
        $masterpenagihan->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function print($id)
    {
        // Redirect to the PrintPenagihanController for printing functionality
        return app(PrintPenagihanController::class)->print($id);
    }

    public function printKwitansi($id)
    {
        // Redirect to the PrintPenagihanController for kwitansi printing
        return app(PrintPenagihanController::class)->printkwitansi($id);
    }
}