<?php

namespace App\Http\Controllers;

use App\Models\anggaranlegalop;
use App\Models\detail_anggaranlegalop;
use App\Models\serieslegalop;
use Illuminate\Http\Request;

class AnggaranlegalopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $query = anggaranlegalop::with('detail_anggaranlegalop', 'serieslegalop');

        if($request->has('search') && !empty($request->search)){
        $search = $request->search;

            $query->where(function($q) use ($search){
                    $q->where('nomor_dokumen', 'like', "%{$search}" );
            })->orWhereHas('detail_anggaranlegalop', function ($q) use ($search){
                    $q->where('deksripsi', 'like', "%{$search}%");
            });
        }
        // Filter tanggal awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_anggaran', '>=', $request->tanggal_awal);
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_anggaran', '<=', $request->tanggal_akhir);
        }

        $anggaranlegalop = $query->orderBy('id', 'desc')->paginate(10);
        return view('anggaranlegalop.index', compact('anggaranlegalop'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.create', compact('serieslegalops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $total_harga = 0;
        foreach ($request->detail as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }
        $anggaranlegal = anggaranlegalop::create([
            'serieslegalop_id' => $request->serieslegalop_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'sifat' => $request->sifat,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'diterima' => $request->diterima,
            'total_harga' => $total_harga,
            'created_by' => auth()->user()->name,
            
        ]);
        foreach ($request->detail as $item) {
            $jumlah = $item['qty'] * $item['harga'];
            $anggaranlegal->detail_anggaranlegalop()->create([
                'deksripsi' => $item['deksripsi'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'jumlah' => $jumlah,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }
        return redirect()->route('anggaranlegalop.index')->with('success', 'Anggaran Legal OP berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function show(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->load('detail_anggaranlegalop', 'serieslegalop');
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.show', compact('anggaranlegalop', 'serieslegalops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function edit(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->load('detail_anggaranlegalop', 'serieslegalop');
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.edit', compact('anggaranlegalop', 'serieslegalops'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, anggaranlegalop $anggaranlegalop)
    {
        //
        $details = $request->detail ?? [];

        // Hitung total harga
        $total_harga = 0;
        foreach ($details as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }

        // Update header
        $anggaranlegalop->update([
            'serieslegalop_id' => $request->serieslegal_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'sifat' => $request->sifat,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'diterima' => $request->diterima,
            'total_harga' => $total_harga,
        ]);

        // Ambil id detail yang sudah ada
        $existingIds  = $anggaranlegalop->detail_anggaranlegalop()->pluck('id')->toArray();
        $submittedIds = collect($details)->pluck('id')->filter()->toArray();

        // Hapus detail yang dihilangkan user
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            detail_anggaranlegalop::destroy($toDelete);
        }

        // Update atau create detail
        foreach ($details as $item) {
            $jumlah = $item['qty'] * $item['harga'];

            if (!empty($item['id'])) {
                // Update data lama
                $detail = detail_anggaranlegalop::find($item['id']);
                $detail->update([
                    'deksripsi' => $item['deksripsi'],
                    'qty'       => $item['qty'],
                    'harga'     => $item['harga'],
                    'jumlah'    => $jumlah,
                    'keterangan'=> $item['keterangan'] ?? null,
                ]);
            } else {
                // Tambah data baru
                $anggaranlegalop->detail_anggaranlegalop()->create([
                    'deksripsi' => $item['deksripsi'],
                    'qty'       => $item['qty'],
                    'harga'     => $item['harga'],
                    'jumlah'    => $jumlah,
                    'keterangan'=> $item['keterangan'] ?? null,
                ]);
            }
        }
        return redirect()->route('anggaranlegalop.index')->with('success', 'Anggaran Legal OP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->delete();
        $anggaranlegalop->detail_anggaranlegalop()->delete();

        return redirect()->route('anggaranlegalop.index')->with('success', 'Anggaran Legal OP berhasil dihapus.');  

    }
}
