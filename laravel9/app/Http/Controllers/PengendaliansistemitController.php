<?php

namespace App\Http\Controllers;

use App\Models\Pengendaliansistemit;
use Illuminate\Http\Request;

class PengendaliansistemitController extends Controller
{
    
    
    public function print(Request $request)
    {
        $tahun = $request->input('tahun');
        $nama = $request->input('nama');
        
        $records = Pengendaliansistemit::where('tahun', $tahun)
            ->where('nama', $nama)
            ->get()
            ->groupBy('bulan');

        return view('vendor.filament.it.pengendaliansistemprint', [
            'records' => $records,
            'tahun' => $tahun,
            'nama' => $nama,
            // Pastikan ini memiliki nilai
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengendaliansistemit  $pengendaliansistemit
     * @return \Illuminate\Http\Response
     */
    public function show(Pengendaliansistemit $pengendaliansistemit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengendaliansistemit  $pengendaliansistemit
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengendaliansistemit $pengendaliansistemit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengendaliansistemit  $pengendaliansistemit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengendaliansistemit $pengendaliansistemit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengendaliansistemit  $pengendaliansistemit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengendaliansistemit $pengendaliansistemit)
    {
        //
    }
}
