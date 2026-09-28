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
            border-bottom: 1px solid #000;
            text-align: left;
           
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    {{-- <table style=" " border="0">
        <tr style="width:100%">
            <td style="width:15%; vertical-align:middle; text-align:center;border-bottom:0px solid">
                <img src="{{ asset('image/pohon.png') }}" style="max-width:50%;vertical-align:middle; height:auto;">
            </td>
            <td style="width:50%; border-bottom:0px solid; text-align:center;">
                <strong style="font-size:15pt">FORM PERMINTAAN BARANG & PEMBAYARAN</strong>
                <br>
                <strong style="font-size:10pt">KEBUN KLATAAN</strong>
            </td>
            <td style="vertical-align:middle;width:15%;border-left:1px solid;">
                <p><strong>Nomor Dokumen</strong></p>
                <p><strong>Tanggal</strong></p>
            </td>
            <td style="vertical-align:middle;width:15%; border-bottom:0px">
                <p>: 12345/ABC/2025</p>
                <p>: 20 September 2025</p>
            </td>
        </tr>
    </table> --}}

    {{-- <table style="width: 100%; border-collapse: collapse; margin-top: -10px" border="0" >
        <tr >
            <td style="border: 0px solid; vertical-align:top; width: 10%; line-height: 0.2;">
                <p><strong>No</strong></p>
                <p><strong>Tanggal</strong></p>
                <p><strong>Sifat</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 20%; line-height: 0.2;">
                <p>: 01/FPB/IX/2025</p>
                <p>: 01/09/2025</p>
                <p>: Biasa</p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 30%;">
                <p><strong>Nama Vendor</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 40%;">
                <p>: PT Contoh Vendor</p>
            </td>
        </tr>
    </table> --}}
     <table>
        <tr style="width:100%">
            {{-- <td style="width:15%; vertical-align:middle; text-align:center;border-bottom:1px solid">
                <img src="{{ asset('image/logo.png') }}" style="max-width:100%;vertical-align:middle; height:auto;">
            </td> --}}
            <td style="width:45%; border-bottom:1px solid">
                <strong style="font-size:20pt">FORM PENGAJUAN ANGGARAN OPERASIONAL</strong>
            </td>
          
            <td style="vertical-align:middle;width:15%;border-left:1px solid;">
                <p><strong>Nomor Dokumen</strong></p>
                <p><strong>Tanggal</strong></p>
                <p><strong>Note</strong></p>
            </td>
            <td style="vertical-align:middle;width:25%;">
                <p>: {{ $anggaranop->nomor_dokumen }}</p>
                <p>: {{ \Carbon\Carbon::parse($anggaranop->tanggal_anggaran)->format('d F Y') }}</p>
                <p>: {{ $anggaranop->note }}</p>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: -10px;" border="1">
        <thead >
            <tr >
                <th width="5%">No.</th>
                <th width="30%">Uraian Keperluan</th>
           
                <th width="30%">Keterangan</th>
                <th width="20%" colspan="2">Jumlah</th>
               
            </tr>
        </thead>
        <tbody>

            @foreach($anggaranop->detailAnggaranops as $i => $detail)
            <tr style="border:1px solid #000">
                <td>{{ $i + 1 }}</td>
                <td>{{ $detail->keperluan }}</td>
                <td>{{ $detail->keterangan }}</td>
                <td>Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:center"><strong>Total Anggaran</strong></td>
                {{-- <td>Rp</td> --}}
                <td  style="border:1px solid #000">Rp {{ number_format($anggaranop->total_anggaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <p style="font-size: 11pt; margin: 25;">
        
        <br>
        <span style="font-size: 16pt;"></span> Rencana Waktu Pelaksanaan : {{$anggaranop->waktu_pelaksanaan}}  &nbsp;&nbsp;
      
    </p>
    {{-- jika 3kolom --}}
    @if($anggaranop->jumlah_kolom == '3kolom')
{{-- jika 3kolom --}}
   <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
            <tr>
                <td style="border: 0px solid black; width: 25%;">Dibuat Oleh,</td>
                <td style="border: 0px solid black; width: 25%;">Dicek Oleh,</td>
                <td style="border: 0px solid black; width: 20%;">Mengetahui,</td>
                {{-- <td style="border: 0px solid black; width: 10%;">Menyetujui,</td> --}}
                
            </tr>
            <tr>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>Yustiana</td>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>Erik Istanti</td>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>Sherren Cynthia I</td>
                {{-- <td style="border: 0px solid black; height: 40px; text-decoration: overline;"><br><br><br>Dr. I Ketut Martiana, Sp.OT</td> --}}
            </tr>
            <!-- Tambahkan baris tambahan sesuai kebutuhan -->
    </table>
    @else
    {{-- jika 4kolom --}}
 <table style="border-collapse: collapse; width: 100%; font-size: 11pt ">
    <tr>
        <td style="border: 0px solid black; width: 5%;">Dibuat Oleh,</td>
        <td style="border: 0px solid black; width: 17%;text-align: center;">Dicek Oleh,</td>
        <td style="border: 0px solid black; width: 10%;">Mengetahui,</td>
        <td style="border: 0px solid black; width: 10%;">Menyetujui,</td>
    </tr>
        <tr>
            <td style="border: 0px solid black; height: 40px;  ">
                <br><br><br>Yustiana
            </td>
            {{-- <td style="border: 1px solid black; height: 40px; text-decoration: overline; text-align: center;">
                <br><br><br>Erik Istanti, Sherren Cynthia I
            </td>
            --}}
            <td style="border: 0px solid black; height: 40px;text-align: center;">
                <br><br><br>
                Erik Istanti,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sherren Cynthia I
            </td>
            <td style="border: 0px solid black; height: 40px;  overline; ">
                <br><br><br>I Nyoman Madya P.
            </td>
            <td style="border: 0px solid black; height: 40px;  ">
                <br><br><br>Dr. I Ketut Martiana, Sp.OT
            </td>
        </tr>
    </table>
    @endif
</body>
</html>

<script>
    window.print();
</script>