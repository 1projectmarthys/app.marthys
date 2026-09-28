<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Cetak Pengajuan Pembayaran</title>
    <style>
        @media print {
            @page {
                size: 9in 5.4in landscape;
                margin-top: 5mm;
                margin-left: 0mm;
                margin-bottom: 0mm;
                margin-right: 9mm;
            }
            body {
                font-family: Arial, sans-serif;
                margin: 0;
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
            border-bottom: 0px solid #000;
            text-align: left;
           
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    
     {{-- <table  >
        <tr  >
            <td style="width:15%; vertical-align:middle; text-align:center;   ">
                <img src="" style="max-width:50%;vertical-align:middle; height:auto;">
            </td>
            <td style="width:50%; text-align:center;">
                <strong style="font-size:15pt">FORMULIR PENGAJUAN PEMBAYARAN</strong>
                
                <br>
                <strong style="font-size:15pt">OPERASIONAL OPERASIONAL PERUSAHAAN</strong>
                
            </td>
            <td style="vertical-align:middle;width:15%;"></td>
            
        </tr>
       
    </table> --}}
    <table style="width:100%; border-collapse:collapse; font-size:10pt;" border="1">
            <tr>
        
                <!-- KIRI -->
                <td rowspan="3" 
                    style="width:20%; text-align:center; vertical-align:middle; font-weight:bold; padding:6px;">
                    <img src="{{ asset('image/logo.jpg')}}" style="max-width:80%; vertical-align:middle; height:auto;">
                </td>
        
                <!-- TENGAH Judul 1 -->
                <td style="width:35%; text-align:center; vertical-align:middle; font-weight:bold; padding:4px; font-size:12pt;">
                    FORMULIR PENGAJUAN ANGGARAN HRD & GA 
                </td>
        
                <!-- LABEL KANAN -->
                <td style="width:20%; font-weight:bold; padding:4px; border:4px;"></td>
        
                <!-- VALUE KANAN -->
                {{-- <td style="width:15%; padding:4px;"></td> --}}
            </tr>
        
            <tr>
                <!-- TENGAH Judul 2 -->
                <td style="text-align:center; vertical-align:middle; font-weight:bold; padding:2px; font-size:12pt;">
                    NON OPERASIONAL PERUSAHAAN
                </td>
{{--         
                <td style="font-weight:bold; padding:4px;">Revisi</td>
                <td style="padding:4px;"></td> --}}
            </tr>
        
            <tr >
                <!-- Kolom Kosong Tengah -->
                {{-- <td style="padding:4px; border-top:none; border-bottom:none;"></td>
        
                <td style="font-weight:bold; padding:4px;">Tanggal Berlaku</td>
                <td style="padding:4px;"></td> --}}
            </tr>
        </table>
    {{-- <div style="margin-top: -10px;">
        <hr style="border: 1px solid #000; margin-top: -5px;">
        <hr style="border: 1px solid #000; margin-top: -5px">
    </div> --}}

    <table style="width: 100%; border-collapse: collapse; margin-top: -10px" border="0" >
        <tr>
            <td style="border: 0px solid; vertical-align:top; width: 25%; line-height: 0.6;">
                <p><strong>Nomor Pengajuan</strong></p>
                <p><strong>Tanggal</strong></p>
                <p><strong>Diajukan Oleh</strong></p>
                <p><strong>Perihal</strong></p>

            </td>
            <td style="border: 0px solid;vertical-align:top; width: 50%; line-height: 0.6;">
                <p>: {{$anggaranhrdnoop->nomor_dokumen}}</p>
                <p>: {{ \Carbon\Carbon::parse($anggaranhrdnoop->tanggal_anggaran)->translatedFormat('l, d / F / Y') }}</p>

                <p>: {{$anggaranhrdnoop->diajukan_oleh}}</p>
                <p>: {{$anggaranhrdnoop->perihal}}</p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 5%; line-height: 0.2;">
                <p><strong>Sifat</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 10%; line-height: 0.2; ">
                <p style="text-transform:capitalize">: {{$anggaranhrdnoop->sifat}}</p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 30%;"></td>
            <td style="border: 0px solid;vertical-align:top; width: 40%;"></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: -10px;" border="1">
        <thead >
            <tr >
                <th width="4%">No.</th>
                <th width="20%">Deskripsi</th>
                <th width="10">Qty</th>
                <th width="25">Nominal Satuan (Rp)</th>
                <th width="20%">Jumlah (Rp)</th>
                <th width="20%">Keterangan</th>
               
            </tr>
        </thead>
        <tbody>

            @foreach ($anggaranhrdnoop->detail_anggaranhrdnoop as $index => $item)
            <tr style="border:1px solid #000">

                <td>{{$index + 1}}</td>
                <td>{{$item->deksripsi}}</td>
                <td>{{number_format($item->qty, 0, ',', '.' )}}</td>
                <td>Rp {{number_format($item->harga, 0, ',', '.') }}</td>
                <td>Rp {{number_format($item->jumlah, 0, ',', '.')}}</td>
                <td>{{$item->keterangan}}</td>
                
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:center"><strong>Total</strong></td>
                {{-- <td>Rp</td> --}}
                <td colspan="2" style="border:1px solid #000;">Rp {{ number_format($anggaranhrdnoop->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p style="font-size: 11pt; margin: 25;">
        
        <br>
        <span style="font-size: 16pt;"></span> Lampiran : {{$anggaranhrdnoop->waktu_pelaksanaan}}  &nbsp;&nbsp;
      
    </p>
    @if ($anggaranhrdnoop->kolom == '3kolom')

             <table class="sign">
            <tr>
                <th style="width:15%;">Diajukan</th>
                <th style="width:15%;">Diketahui</th>
                <th style="width:15%;">Diverifikasi</th>
                <th style="width:15%;">Direview</th>
                <th style="width:15%;" colspan="2">Disetujui</th>
            </tr>
            <tr>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
            </tr>
            <tr>
                 <td style="width:15%;">PIC Dept.</td>
                <td style="width:15%;">Atasan Dept.</td>
                <td style="width:15%;">Finance</td>
                <td style="width:15%;">Manager FA</td>
                <td style="width:15%;">General Manager</td>
                <td style="width:15%;">Direktur Utama</td>
            </tr>
        </table>
    @elseif ($anggaranhrdnoop->kolom == '5kolom')
        
        <table class="sign">
            <tr>
                <th style="width:15%;">Diajukan</th>
                <th style="width:15%;">Diketahui</th>
                <th style="width:15%;">Diverifikasi</th>
                <th style="width:15%;">Direview</th>
                <th style="width:15%;" colspan="2">Disetujui</th>
            </tr>
            <tr>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
                <td class="space"></td>
            </tr>
            <tr>
                 <td style="width:15%;">PIC Dept.</td>
                <td style="width:15%;">Atasan Dept.</td>
                <td style="width:15%;">Finance</td>
                <td style="width:15%;">Manager FA</td>
                <td style="width:15%;">General Manager</td>
                <td style="width:15%;">Direktur Utama</td>
            </tr>
        </table>
    @else
        <p>Berapa Kolom Tanda Tangan</p>
    @endif

</body>
</html>

<script>
    window.print();
</script>