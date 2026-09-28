<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Cetak Pengajuan Pembayaran</title>
    <style>
    @media print {
        @page {
            size: 9in 5.4in landscape; /* Ukuran kertas 9x11 inci */
            margin-top: 5mm; /* Atur margin sesuai kebutuhan */
            margin-left:0mm;
            margin-bottom:0mm;
            margin-right:1mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Hapus margin untuk cetak */
        }
    }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: left;
            margin: 0;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #000;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    @if($pembayaraninternal)
    <table>
        <tr style="width:100%">
            
            {{-- <td style="width:45%; border-bottom:1px solid">
                <strong style="font-size:20pt">FORM PENGAJUAN PEMBAYARAN</strong>
            </td> --}}
            <td style="width:50%; border-bottom:1px solid">
                <strong style="font-size:25pt">{{ strtoupper($pembayaraninternal->tipe_pembayaran) }}</strong>
                {{-- <strong style="font-size:20pt">FORM PENGAJUAN INTERNAL</strong> --}}
            </td>
            <td style="vertical-align:middle;width:15%;border-left:1px solid;">
                <p><strong>Nomor Dokumen</strong></p>
                <p><strong>Tanggal</strong></p>
                <p><strong>Note</strong></p>
            </td>
            <td style="vertical-align:middle;width:25%;">
                <p>:{{ $pembayaraninternal->nomor_dokumen }}</p>
                <p>:{{ $tanggal->format('d F Y') }}</p>
                <p>:{{$pembayaraninternal->note }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 0;margin-top:-10px">
        <tr>
            <td style="border: 0px solid; vertical-align:top;">
                <p><strong>Metode Pembayaran</strong></p>
                <p><strong>Rencana Bayar</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top;">
                <p>:</p>
                <p>:</p>
            </td>
            <td style="border: 0px solid;vertical-align:top;">
                <p>{{ $pembayaraninternal->sumber_dana }}</p>
                <p>{{ $rencana_bayar->format('d F Y') }}</p>
            </td>
            <td style="border: 0px solid;vertical-align:top;">
                <p><strong>Nama Vendor</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top;">
                <p>:</p>
            </td>
            <td style="border: 0px solid;vertical-align:top;">
                <p>{{ $pembayaraninternal->nama_supplier }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: -10px;">
        @if($pembayaraninternal->mata_uang !== 'IDR')
        <!-- Extended header for foreign currency (USD, etc.) -->
        <thead style="border-top:1px solid">
            <tr>
                <th width="2%">No.</th>
                <th width="20%">No. Dok</th>
                <th width="30%">Uraian</th>
                <th width="10%">CRY</th>
                <th width="10%">Amount</th>
                <th width="10%">Kurs</th>
                <th width="35%" colspan="2">Jumlah</th>
            </tr>
        </thead>
        @else
        <!-- Standard header for IDR -->
        <thead style="border-top:1px solid">
            <tr>
                <th width="2%">No.</th>
                <th width="30%">No. Dok</th>
                <th width="36%">Uraian</th>
                <th width="0%" colspan="2">Jumlah</th>
            </tr>
        </thead>
        @endif
        <tbody>
            @foreach($pembayaraninternal->detail_pembayaraninternal as $index => $detail)
            @if($pembayaraninternal->mata_uang !== 'IDR')
            <!-- Row format for foreign currency -->
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->uraian }}</td>
                <td>{{ $detail->keterangan }}</td>
                <td>{{ $pembayaraninternal->mata_uang }}</td>
                <td>{{ number_format($detail->jumlah, 2, ',', '.') }}</td>
                <td>{{ number_format($pembayaraninternal->kurs, 2, ',', '.') }}</td>
                <td>Rp <span>{{ number_format($detail->jumlah * $pembayaraninternal->kurs, 2, ',', '.') }}</span></td>
                <!--<td>{{ number_format($detail->jumlah * $pembayaraninternal->kurs, 2, ',', '.') }}</td>-->
            </tr>
            @else
            <!-- Standard row format for IDR -->
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->uraian }}</td>
                <td>{{ $detail->keterangan }}</td>
                <td>{{ $currency_symbol }} <span>{{ number_format($detail->jumlah, 2, ',', '.') }}</span> </td>
                <td></td>
            </tr>
            @endif
            @endforeach
            <!--@if($pembayaraninternal->biaya_admin > 0)-->
            <!--<tr>-->
            <!--    <td>{{ count($pembayaraninternal->detail_pembayaraninternal) + 3 }}</td>-->
            <!--    <td></td>-->
            <!--    <td colspan="4">Admin Bank</td>-->
            <!--    <td    >Rp</td>-->
            <!--    <td>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</td>-->
            <!--</tr>-->
            <!--@endif-->
            @if($pembayaraninternal->biaya_admin > 0)
                @if($pembayaraninternal->mata_uang !== 'IDR')
                    <!-- Format untuk mata uang asing -->
                    <tr>
                        <td>{{ count($pembayaraninternal->detail_pembayaraninternal) + 3 }}</td>
                        <td></td>
                        <td colspan="4">Admin Bank</td>
                        <td>Rp <span>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</span> </td>
                        <!--<td>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</td>-->
                       
                    </tr>
                @else
                    <!-- Format untuk IDR -->
                    <tr>
                        <td>{{ count($pembayaraninternal->detail_pembayaraninternal) + 3 }}</td>
                        <td></td>
                        <td colspan="">Admin Bank</td>
                        <td>Rp <span>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</span></td>
                        <!--<td>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</td>-->
                    </tr>
                @endif
            @endif
        </tbody>
        <tfoot>
            {{-- @if($pembayaraninternal->mata_uang !== 'IDR')
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td  style="text-align:right" >Total</td>
                    <td>{{ $currency_symbol }} </td>
                    <td>  {{ number_format($pembayaraninternal->grand_total, 2, ',', '.') }}</td>
                </tr>
            @endif --}}

            @if($pembayaraninternal->keterangan_potong > 0 )
            <tr>
                <td style="border:0px" colspan="2"></td>
                <td style="text-align:right"  >{{ $pembayaraninternal->keterangan_potong }}</td>
                <td> {{ $currency_symbol }} <span>{{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</span></td>
                <!--<td> {{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</td>-->
            </tr>
            @endif
            @if($pembayaraninternal->biaya_admin > 0)
                @if($pembayaraninternal->mata_uang !== 'IDR')
                     Format untuk mata uang asing 
                    <tr>
                        <td style="border:0px" colspan="5"></td>
                        <td style="text-align:right" >{{ $pembayaraninternal->keterangan_potong }}</td>
                        <td>Rp <span>{{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</span></td>
                        <!--<td> {{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</td>-->
                    </tr>
                @else
                     Format untuk IDR 
                    <tr>
                        <td style="border:0px" colspan="2"></td>
                        <td style="text-align:right" >{{ $pembayaraninternal->keterangan_potong }}</td>
                        <td>{{ $currency_symbol }} <Span>{{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</Span> </td>
                        <!--<td> {{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</td>-->
                    </tr>
                @endif
            @endif
            {{-- @if($pembayaraninternal->biaya_admin > 0)
            <tr>
                <td style="border:0px" colspan="2"></td>
                <td style="text-align:right">Admin Bank</td>
                <td>Rp</td>
                <td>{{ number_format($pembayaraninternal->biaya_admin, 2, ',', '.') }}</td>
            </tr>
            @endif --}}

            @if($pembayaraninternal->mata_uang === 'IDR')
            <!-- <tr>-->
            <!--        <td style="border:0px" colspan="2"></td>-->
            <!--        <td style="text-align:right" >{{ $pembayaraninternal->keterangan_potong}}</td>-->
            <!--        <td>{{ $currency_symbol }}</td>-->
            <!--        <td> {{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</td>-->
            <!--</tr>-->
            <tr style="font-weight: bold">
                <td style="border:2px" colspan="2"></td>
                <td  style="text-align:right" >Total Bayar </td>
                <td>{{ $currency_symbol }}  <span>{{ number_format($pembayaraninternal->total_bayar, 2, ',', '.') }}</span> </td>
                <td></td>
                <!--<td> Rp {{ number_format($pembayaraninternal->total_bayar, 2, ',', '.') }}</td>-->
            </tr>
            @elseif($pembayaraninternal->mata_uang !== '' )
               @if($pembayaraninternal->potongan_harga > 0)
                    <tr>
                        <td style="border:0px" colspan="5"></td>
                        {{-- <td  style="text-align:right" >Potongan Harga</td> --}}
                        <td style="text-align:right">{{ $pembayaraninternal->keterangan_potong}}</td>
                        {{-- <td>{{ $currency_symbol }}</td> --}}
                        <td>Rp <span>{{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</span></td>
                        <!--<td> {{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}</td>-->
                    </tr>
                @endif
            {{-- <tr>
                <td style="border:0px" colspan="2"></td>
                <td  style="text-align:right">Total Bayar</td>
                <td>{{ $currency_symbol }}</td>
                <td> {{ number_format($pembayaraninternal->total_bayar, 2, ',', '.') }}</td>
            </tr> --}}
            {{-- <tr>
                <td style="border:0px" colspan="2"></td>
                <td  style="text-align:right" >Estimasi Kurs</td>
                <td>Rp</td>
                <td> {{ number_format($pembayaraninternal->kurs, 2, ',', '.') }}</td>
            </tr> --}}
           
            <tr style="font-weight: bold;">
                <td style="border:2px" colspan="5"></td>
                <td style="text-align:right " >Total Bayar (IDR)</td>
                <td>Rp <span>{{ number_format($pembayaraninternal->total_bayar , 2, ',', '.') }}</span></td>
                <!--<td> {{ number_format($pembayaraninternal->total_bayar , 2, ',', '.') }}</td>-->
            </tr>
            @endif
        </tfoot>
    </table>

    <body>
        
<!--<table width="100%" style="border:0px">-->
<!--    <tr>-->
<!--        <td width="100%"style="border:0px"colspan="3">-->
<!--            Lampiran-->
<!--        </td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td style="border:0px" width="5%">☐</td>-->
<!--        <td style="border:0px" width="25%">Invoice, SJ, FP, PO</td>-->
<!--        <td style="border:0px" width="70%"></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td style="border:0px" width="5%">☐</td>-->
<!--        <td style="border:0px" width="25%">SPBB</td>-->
<!--        <td style="border:0px" width="70%"></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td  style="border:0px" width="5%">☐</td>-->
<!--        <td  style="border:0px" width="25%">Kontrak/Perjanjian</td>-->
<!--        <td style="border:0px" width="70%"></td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td  style="border:0px" width="5%">☐</td>-->
<!--        <td  style="border:0px" width="25%">Lainnya :_________</td>-->
<!--        <td style="border:0px" width="70%"></td>-->
<!--    </tr>-->
    
<!--</table>        -->
    <!--<p style="font-size: 11pt; margin: 25;">-->
    <!--    Lampiran:-->
    <!--    <br>-->
    <!--    <span style="font-size: 16pt;">☐</span> Invoice, SJ, FP, PO,&nbsp;&nbsp;-->
    <!--    <br>-->
    <!--    <span style="font-size: 16pt;">☐</span> SPBB,&nbsp;&nbsp;-->
    <!--    <br>-->
    <!--    <span style="font-size: 16pt;">☐</span> Kontrak / Perjanjian,&nbsp;&nbsp;-->
    <!--    <br>-->
    <!--    <span style="font-size: 16pt;">☐</span> Lainnya: ___________-->
    <!--</p>-->
    <!-- <p style="font-size: 11pt; margin: 30;">-->
    <!-- Lampiran : -->
    <!--    <br>-->
    <!--    <span style="font-size: 16pt;">☐</span> Invoice, SJ, FP, PO,&nbsp;&nbsp;-->
      
    <!--    <span style="font-size: 16pt;">☐</span> SPBB,&nbsp;&nbsp;-->
       
    <!--    <span style="font-size: 16pt;">☐</span> Kontrak / Perjanjian,&nbsp;&nbsp;-->
    
    <!--    <span style="font-size: 16pt;">☐</span> Lainnya: ___________-->
    <!--</p>   -->
    <p style="font-size: 11pt; margin: 25;">
        Lampiran : 
        <br>
        <span style="font-size: 16pt;">☐</span> Invoice, SJ, FP, PO&nbsp;&nbsp;
      
        <span style="font-size: 16pt;">☐</span> SPBB&nbsp;&nbsp;
       
        <span style="font-size: 16pt;">☐</span> Kontrak / Perjanjian&nbsp;&nbsp;
    
        @if ($pembayaraninternal)
            @if (!empty($pembayaraninternal->lampiran))
                <span style="font-size: 16pt;">☐</span> Lainnya : {{ $pembayaraninternal->lampiran }}
            @else
                <span style="font-size: 16pt;">☐</span> Lainnya: ___________
            @endif
        @endif
    </p>
    @if($pembayaraninternal->jumlah_kolom === '3kolom')
    <!-- 3-column signature table -->
    <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
        <tr>
            <td style="border: 0px solid black; width: 33.33%;">Dibuat Oleh,</td>
            <td style="border: 0px solid black; width: 33.33%;">Mengetahui,</td>
            <td style="border: 0px solid black; width: 33.33%;">Menyetujui,</td>
        </tr>
        <tr>
            <td style="border: 0px solid black; height: 40px;"><br><br><br>(Sherren Cynthia I)</td>
            <td style="border: 0px solid black; height: 40px;"><br><br><br>(I Nyoman Madya P.)</td>
            <td style="border: 0px solid black; height: 40px;"><br><br><br>(Dr. I Ketut Martiana, Sp.OT)</td>
        </tr>
    </table>
    @else
    <!-- 4-column signature table (default) -->
    <!--<table style="border-collapse: collapse; width: 100%; font-size: 11pt">-->
    <!--    <tr>-->
    <!--        <td style="border: 0px solid black; width: 25%;">Dibuat Oleh,</td>-->
    <!--        <td style="border: 0px solid black; width: 25%;">Dicek Oleh,</td>-->
    <!--        <td style="border: 0px solid black; width: 25%; text-align:center" colspan="2">Mengetahui Oleh,</td>-->
    <!--        <td style="border: 0px solid black; width: 25%; text-align:center" colspan="2">Menyetujui Oleh,</td>-->
            
    <!--    </tr>-->
    <!--    <tr>-->
    <!--        <td style="border: 0px solid black; height: 40px;"><br><br><br>(Elza Zanuarika)</td>-->
    <!--        <td style="border: 0px solid black; height: 40px;"><br><br><br>(Sherren Cynthia Immelda)</td>-->
    <!--        <td style="border: 0px solid black; height: 40px;"><br><br><br>(I Nyoman Madya P.)</td>-->
    <!--        <td style="border: 0px solid black; height: 40px;"><br><br><br>(Dr. I Ketut Martiana, Sp.OT)</td>-->
    <!--    </tr>-->
    <!--</table>-->
        <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
            <tr>
                <td style="border: 0px solid black; width: 10%;">Dibuat Oleh,</td>
                <td style="border: 0px solid black; width: 10%;">Dicek Oleh,</td>
                <td style="border: 0px solid black; width: 10%;">Mengetahui,</td>
                <td style="border: 0px solid black; width: 10%;">Menyetujui,</td>
                
            </tr>
            <tr>
                <td style="border: 0px solid black; height: 40px; text-decoration: overline;"><br><br><br>Elza Zanuarika</td>
                <td style="border: 0px solid black; height: 40px; text-decoration: overline;"><br><br><br>Sherren Cynthia I</td>
                <td style="border: 0px solid black; height: 40px; text-decoration: overline;"><br><br><br>I Nyoman Madya P.</td>
                <td style="border: 0px solid black; height: 40px; text-decoration: overline;"><br><br><br>Dr. I Ketut Martiana, Sp.OT</td>
            </tr>
            <!-- Tambahkan baris tambahan sesuai kebutuhan -->
        </table>
    @endif
    @else
        <p>Data tidak ditemukan.</p>
    @endif
</body>
</html>

<script>
    window.print();
</script>