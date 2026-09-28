<?php

namespace App\Http\Controllers;

use App\Models\pembayaraninternal;
use DateTime;
use Illuminate\Http\Request;

class PrintPembayaranInternalController extends Controller
{
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pembayaraninternal = pembayaraninternal::with('detail_pembayaraninternal')->findOrFail($id);
        
        // Format dates
        $tanggal = new DateTime($pembayaraninternal->tanggal);
        $rencana_bayar = new DateTime($pembayaraninternal->rencana_bayar);
        
        // Generate Roman numerals for month
        $bulanRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulan = $bulanRomawi[$tanggal->format('n') - 1];
        $tahun = $tanggal->format('y');
        
        // Generate document number
        $nomor_dokumen = sprintf("%03d/MOI-FIN/FPP/%s/%s", $id, $bulan, $tahun);

        // Currency symbol mapping
        $currency_symbols = [
            'USD' => '$',
            'EUR' => '€',
            'CNY' => '¥',
            'IDR' => 'Rp'
        ];
        
        $currency_symbol = $currency_symbols[$pembayaraninternal->mata_uang] ?? 'Rp';

        // return view('vendor.filament.pembayaran.printpembayaran', compact(
        //     'pengajuan',
        //     'nomor_dokumen',
        //     'currency_symbol',
        //     'tanggal',
        //     'rencana_bayar'
        // ));
        return view('pembayaraninternal.print_1', compact(
            'pembayaraninternal',
            'nomor_dokumen',
            'currency_symbol',
            'tanggal',
            'rencana_bayar'
            
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
