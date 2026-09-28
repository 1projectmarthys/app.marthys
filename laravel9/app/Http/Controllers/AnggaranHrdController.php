<?php

namespace App\Http\Controllers;

use App\Models\anggaranhrd;
use App\Models\detail_anggaranhrd;
use App\Models\serieshrd;
use Illuminate\Http\Request;

class AnggaranHrdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = anggaranhrd::with('detail_anggaranhrd');

        
        if($request->has('search') && !empty($request->search)){
        $search = $request->search;

            $query->where(function($q) use ($search){
                    $q->where('nomor_dokumen', 'like', "%{$search}" );
            })->orWhereHas('detail_anggaranhrd', function ($q) use ($search){
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


        $anggaranhrd = $query->orderBy('id', 'desc')->paginate(10);
        return view('anggaranhrd.index', compact('anggaranhrd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $serieshrds = serieshrd::all();
        return view('anggaranhrd.create', compact('serieshrds'));
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
        foreach( $request->detail as $item ){
            $total_harga += $item['qty'] * $item['harga'];
        }
        $anggaranhrd = anggaranhrd::create([
            'serieshrd_id' => $request->serieshrd_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'kolom' => $request->kolom,
            'sifat' => $request->sifat,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'total_harga' => $total_harga,
            'created_by' => auth()->user()->name,
        ]);
        foreach( $request->detail as $item ){
            $anggaranhrd->detail_anggaranhrd()->create([
                'deksripsi' => $item['deksripsi'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'jumlah' => $item['qty'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);

        }
        return redirect()->route('anggaranhrd.index')->with('success', 'Data anggaran HRD berhasil disimpan.'); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(anggaranhrd $anggaranhrd)
    {
        //
        $anggaranhrd->load('detail_anggaranhrd', 'serieshrd');
        $serieshrds = serieshrd::all();
        return view('anggaranhrd.show', compact('anggaranhrd', 'serieshrds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(anggaranhrd $anggaranhrd)
    {
        //
        $anggaranhrd->load('detail_anggaranhrd', 'serieshrd');
        $serieshrds = serieshrd::all();
        return view('anggaranhrd.edit', compact('anggaranhrd', 'serieshrds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, anggaranhrd $anggaranhrd)
    {
        //
        $details = $request->detail ?? [];
        //hitung total harga
        $total_harga = 0;
        foreach( $details as $item ){
            $total_harga += $item['qty'] * $item['harga'];
        }
        //update anggaranhrd
        $anggaranhrd->update([
            'serieshrd_id' => $request->serieshrd_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'kolom' => $request->kolom,
            'sifat' => $request->sifat,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'total_harga' => $total_harga,
            'created_by' => auth()->user()->name,

        ]);
        // ambil id detail yang sudah ada 
        $existingDetailIds = $anggaranhrd->detail_anggaranhrd()->pluck('id')->toArray();
        $submittedIds = collect($details)->pluck('id')->filter()->toArray();

        //hapus detail yang dihapus user
        $idsToDelete = array_diff($existingDetailIds, $submittedIds);
        if( !empty($idsToDelete) ){
            detail_anggaranhrd::destroy($idsToDelete);
        }

        //update atau buat detail baru
        foreach( $details as $item ){
            $jumlah = $item['qty'] * $item['harga'];

            if(!empty($item['id']) ){
                //update detail yang ada
                $detail = detail_anggaranhrd::find($item['id']);
                if( $detail ){
                    $detail->update([
                        'deksripsi' => $item['deksripsi'],
                        'qty' => $item['qty'],
                        'harga' => $item['harga'],
                        'jumlah' => $jumlah,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
            } else {
                //buat detail baru
                $anggaranhrd->detail_anggaranhrd()->create([
                    'deksripsi' => $item['deksripsi'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'jumlah' => $jumlah,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }
        }
        return redirect()->route('anggaranhrd.index')->with('success', 'Data anggaran HRD berhasil diperbarui.');

    }
   
    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggaranhrd $anggaranhrd)
    {
        //
        $anggaranhrd->delete();
        $anggaranhrd->detail_anggaranhrd()->delete();

        return redirect()->route('anggaranhrd.index')->with('success', 'Anggaran HRD berhasil dihapus.');
    }
}
