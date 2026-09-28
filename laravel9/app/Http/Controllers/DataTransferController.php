<?php

namespace App\Http\Controllers;

use App\Models\data_transfer;
use App\Models\tb_penerima;
use Illuminate\Http\Request;

class DataTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataTransfers = data_transfer::all();
        return view('transaksi.masterTransaksi.index', compact('dataTransfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
    $dataTransfer = data_transfer::findOrFail($id);
    return view('transaksi.masterTransaksi.print-dataTransfer', compact('dataTransfer'));
    }
    public function create()
    {
        // return view('transaksi.masterTransaksi.create');

        //tb_penerima 
        $penerima = tb_penerima::all(); // Ambil semua data dari tabel tb_penerima
        return view('transaksi.masterTransaksi.create', compact('penerima'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'norek_penerima' => 'nullable',
            'nama_penerima' => 'nullable',
            'alamat_penerima' => 'nullable',
            'alamat2_penerima' => 'nullable',
            'kota_penerima' => 'nullable',
            'provinsi_penerima' => 'nullable',
            'negara_penerima' => 'nullable',
            'kodepos_penerima' => 'nullable',
            'bank_penerima' => 'nullable',
            'abank_penerima' => 'nullable',
            'abank2_penerima' => 'nullable',
            'kbank_penerima' => 'nullable',
            'pbank_penerima' => 'nullable',
            'nbank_penerima' => 'nullable',
            'kpbank_penerima' => 'nullable',
            'tujuan_transaksi' => 'nullable',
            'berita_transaksi' => 'nullable',
            'sumber_dana' => 'nullable',
            'tunai' => 'nullable',
            'tabungan' => 'nullable',
            'cek_bca' => 'nullable',
            'mata_uang' => 'nullable|in:IDR,USD,EUR,CNY',
            'jumlah' => 'nullable|numeric',
            'provisi' => 'nullable',
            'biaya' => 'nullable',
            // Add other validation rules as needed
        ]);

        data_transfer::create($validated);
        return redirect()->route('data-transfer.index')->with('success', 'Data created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\data_transfer  $data_transfer
     * @return \Illuminate\Http\Response
     */
    public function show(data_transfer $data_transfer)
    {
        return view('transaksi.masterTransaksi.show', compact('data_transfer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\data_transfer  $data_transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(data_transfer $data_transfer)
    {
        return view('transaksi.masterTransaksi.edit', compact('data_transfer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\data_transfer  $data_transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, data_transfer $data_transfer)
    {
        $validated = $request->validate([
            'norek_penerima' => 'nullable',
            'nama_penerima' => 'nullable',
            'alamat_penerima' => 'nullable',
            'alamat2_penerima' => 'nullable',
            'kota_penerima' => 'nullable',
            'provinsi_penerima' => 'nullable',
            'negara_penerima' => 'nullable',
            'kodepos_penerima' => 'nullable',
            'bank_penerima' => 'nullable',
            'abank_penerima' => 'nullable',
            'abank2_penerima' => 'nullable',
            'kbank_penerima' => 'nullable',
            'pbank_penerima' => 'nullable',
            'nbank_penerima' => 'nullable',
            'kpbank_penerima' => 'nullable',
            'tujuan_transaksi' => 'nullable',
            'berita_transaksi' => 'nullable',
            'sumber_dana' => 'nullable',
            'tunai' => 'nullable',
            'tabungan' => 'nullable',
            'cek_bca' => 'nullable',
            'mata_uang' => 'nullable|in:IDR,USD,EUR,CNY',
            'jumlah' => 'nullable|numeric',
            'provisi' => 'nullable',
            'biaya' => 'nullable',
            // Add other validation rules as needed
        ]);

        $data_transfer->update($validated);
        return redirect()->route('data-transfer.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\data_transfer  $data_transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(data_transfer $data_transfer)
    {
        $data_transfer->delete();
        return redirect()->route('data-transfer.index')->with('success', 'Data deleted successfully.');
    }
}
