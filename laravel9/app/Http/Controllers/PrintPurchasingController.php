<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use DateTime;
use Illuminate\Http\Request;

class PrintPurchasingController extends Controller
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
        $purchasing = Purchasing::with('detail_purchasing')->findOrFail($id);
        
        // Format dates
        $tanggal = new DateTime($purchasing->tanggal);
        $rencana_bayar = new DateTime($purchasing->rencana_bayar);
        
        // Generate Roman numerals for month
        $bulanRomawi = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulan = $bulanRomawi[$tanggal->format('n') - 1];
        $tahun = $tanggal->format('y');
        
        // Pakai nomor dokumen yang sudah tersimpan (format 001/MOI-PCH/VII/2026)
        $nomor_dokumen = $purchasing->nomor_dokumen;

        // Currency symbol mapping
        $currency_symbols = [
            'USD' => '$',
            'EUR' => '€',
            'CNY' => '¥',
            'IDR' => 'Rp'
        ];
        
        $currency_symbol = $currency_symbols[$purchasing->mata_uang] ?? 'Rp';

        // return view('vendor.filament.pembayaran.printpembayaran', compact(
        //     'purchasing',
        //     'nomor_dokumen',
        //     'currency_symbol',
        //     'tanggal',
        //     'rencana_bayar'
        // ));
        return view('purchasing.print_1', compact(
            'purchasing',
            'nomor_dokumen',
            'currency_symbol',
            'tanggal',
            'rencana_bayar'
            
        ));
    }
}
