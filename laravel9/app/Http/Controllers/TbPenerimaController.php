<?php

namespace App\Http\Controllers;

use App\Models\tb_penerima;
use Illuminate\Http\Request;

class TbPenerimaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penerima = tb_penerima::all();
        return view('transaksi.tb_penerima.index', compact('penerima'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transaksi.tb_penerima.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
              
            'norek_penerima' => 'required',
            'nama_penerima' => 'required',
            'alamat_penerima' => 'required',
            'kota_penerima' => 'required',
            'provinsi_penerima' => 'required',
            'negara_penerima' => 'required',
            'kodepos_penerima' => 'required',
            'bank_penerima' => 'required',
            'abank_penerima' => 'required',
            'abank2_penerima' => 'required',
            'kbank_penerima' => 'required',
            'pbank_penerima' => 'required',
            'nbank_penerima' => 'required',
            'kpbank_penerima' => 'required',
            'bank_status' => 'required'
        ]);

        tb_penerima::create($request->all());
        return redirect()->route('tb_penerima.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tb_penerima  $tb_penerima
     * @return \Illuminate\Http\Response
     */
    public function show(tb_penerima $tb_penerima) 
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tb_penerima  $tb_penerima
     * @return \Illuminate\Http\Response
     */
    public function edit(tb_penerima $tb_penerima)
    {
        return view('transaksi.tb_penerima.edit', compact('tb_penerima'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tb_penerima  $tb_penerima
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tb_penerima $tb_penerima)
    {
        $request->validate([
            
            'norek_penerima' => 'required',
            'nama_penerima' => 'required',
            'alamat_penerima' => 'required',
            'kota_penerima' => 'required',
            'provinsi_penerima' => 'required',
            'negara_penerima' => 'required',
            'kodepos_penerima' => 'required',
            'bank_penerima' => 'required',
            'abank_penerima' => 'required',
            'abank2_penerima' => 'required',
            'kbank_penerima' => 'required',
            'pbank_penerima' => 'required',
            'nbank_penerima' => 'required',
            'kpbank_penerima' => 'required',
            'bank_status' => 'required'
        ]);

        $tb_penerima->update($request->all());
        return redirect()->route('tb_penerima.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tb_penerima  $tb_penerima
     * @return \Illuminate\Http\Response
     */
    public function destroy(tb_penerima $tb_penerima)
    {
        $tb_penerima->delete();
        return redirect()->route('tb_penerima.index')->with('success', 'Data berhasil dihapus.');
    }
}
