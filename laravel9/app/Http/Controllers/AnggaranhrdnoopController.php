<?php

namespace App\Http\Controllers;

use App\Models\anggaranhrdnoop;
use App\Models\detail_anggaranhrdnoop;
use App\Models\serieshrd;
use Illuminate\Http\Request;

class AnggaranhrdnoopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = anggaranhrdnoop::with('detail_anggaranhrdnoop');

        if($request->has('search') && !empty($request->search)){
            $search = $request->search;

                $query->where(function($q) use ($search){
                        $q->where('nomor_dokumen', 'like', "%{$search}" );
                })->orWhereHas('detail_anggaranhrdnoop', function ($q) use ($search){
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

        $anggaranhrdnoop = $query->orderBy('id', 'desc')->paginate(10);
        return view('anggaranhrdnoop.index', compact('anggaranhrdnoop'));
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
        return view('anggaranhrdnoop.create', compact('serieshrds'));
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
        $anggaranhrd = anggaranhrdnoop::create([
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
            $anggaranhrd->detail_anggaranhrdnoop()->create([
                'deksripsi' => $item['deksripsi'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'jumlah' => $item['qty'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);

        }
        return redirect()->route('anggaranhrdnoop.index')->with('success', 'Data anggaran HRD NOOP berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\anggaranhrdnoop  $anggaranhrdnoop
     * @return \Illuminate\Http\Response
     */
    public function show(anggaranhrdnoop $anggaranhrdnoop)
    {
        //
        $anggaranhrdnoop->load('detail_anggaranhrdnoop', 'serieshrd');
        $serieshrds = serieshrd::all();
        return view('anggaranhrdnoop.show', compact('anggaranhrdnoop', 'serieshrds'));      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\anggaranhrdnoop  $anggaranhrdnoop
     * @return \Illuminate\Http\Response
     */
    public function edit(anggaranhrdnoop $anggaranhrdnoop)
    {
        //
        $anggaranhrdnoop->load('detail_anggaranhrdnoop', 'serieshrd');
        $serieshrds = serieshrd::all();
        return view('anggaranhrdnoop.edit', compact('anggaranhrdnoop','serieshrds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\anggaranhrdnoop  $anggaranhrdnoop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, anggaranhrdnoop $anggaranhrdnoop)
    {
        //
         //
        $details = $request->detail ?? [];
        //hitung total harga
        $total_harga = 0;
        foreach( $details as $item ){
            $total_harga += $item['qty'] * $item['harga'];
        }
        //update anggaranhrd
        $anggaranhrdnoop->update([
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
        $existingDetailIds = $anggaranhrdnoop->detail_anggaranhrdnoop()->pluck('id')->toArray();
        $submittedIds = collect($details)->pluck('id')->filter()->toArray();

        //hapus detail yang dihapus user
        $idsToDelete = array_diff($existingDetailIds, $submittedIds);
        if( !empty($idsToDelete) ){
            detail_anggaranhrdnoop::destroy($idsToDelete);
        }

        //update atau buat detail baru
        foreach( $details as $item ){
            $jumlah = $item['qty'] * $item['harga'];

            if(!empty($item['id']) ){
                //update detail yang ada
                $detail = detail_anggaranhrdnoop::find($item['id']);
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
                $anggaranhrdnoop->detail_anggaranhrdnoop()->create([
                    'deksripsi' => $item['deksripsi'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'jumlah' => $jumlah,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }
        }
        return redirect()->route('anggaranhrdnoop.index')->with('success', 'Data anggaran HRD NOOP berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\anggaranhrdnoop  $anggaranhrdnoop
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggaranhrdnoop $anggaranhrdnoop)
    {
        //
        $anggaranhrdnoop->delete();
        $anggaranhrdnoop->detail_anggaranhrdnoop()->delete();
        return redirect()->route('anggaranhrdnoop.index')->with('success', 'Data anggaran HRD NOOP berhasil dihapus.'); 
    }
}
