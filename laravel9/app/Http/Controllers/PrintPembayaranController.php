<?php

namespace App\Http\Controllers;

use App\Models\Pengajuanpembayaran;
use DateTime;
use Illuminate\Http\Request;

class PrintPembayaranController extends Controller
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


    public function show($id)
    {
        $pengajuan = Pengajuanpembayaran::with('detail_pengajuan')->findOrFail($id);
        
        // Format dates
        $tanggal = new DateTime($pengajuan->tanggal);
        $rencana_bayar = new DateTime($pengajuan->rencana_bayar);
        
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
        
        $currency_symbol = $currency_symbols[$pengajuan->mata_uang] ?? 'Rp';

        // return view('vendor.filament.pembayaran.printpembayaran', compact(
        //     'pengajuan',
        //     'nomor_dokumen',
        //     'currency_symbol',
        //     'tanggal',
        //     'rencana_bayar'
        // ));
        return view('pengajuan-pembayaran.print_1', compact(
            'pengajuan',
            'nomor_dokumen',
            'currency_symbol',
            'tanggal',
            'rencana_bayar'
            
        ));
    }
}
