{{-- filepath: c:\laragon\www\laravel9new\resources\views\permintaanbarang\print_1.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Cetak Permintaan Barang</title>
    <style>
        @media print {
            @page {
                size: 9in 5.4in landscape; /* Ukuran kertas 9x11 inci */
                margin-top: 5mm; /* Atur margin sesuai kebutuhan */
                margin-left:0mm;
                margin-bottom:0mm;
                margin-right:9mm;
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
            /* border-bottom: 1px solid #000; */
            border: 1px solid #000;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table >
        <tr>
            <td style="width:15%; vertical-align:middle; text-align:center;border:0px solid">
                <img src="" style="max-width:50%;vertical-align:middle; height:auto;">
            </td>
            <td style="width:50%; border:0px solid; text-align:center;">
                <strong style="font-size:15pt">FORM PERMINTAAN BARANG & PEMBAYARAN</strong>
                <br>
            <strong style="font-size:10pt; text-transform:uppercase">{{$permintaanbarang->keterangan}}</strong>
            </td>
            <td style="vertical-align:middle;width:15%; border:0px"></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: -10px" border="0" >
        <tr>
            <td style="border: 0px solid; vertical-align:top; width: 10%; line-height: 0.2;">
                <p><strong>No</strong></p>
                <p><strong>Tanggal</strong></p>
                <p><strong>Sifat</strong></p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 20%; line-height: 0.2;">
                <p>: {{ $permintaanbarang->nomor_dokumen }}</p>
                <p>: {{ \Carbon\Carbon::parse($permintaanbarang->tanggal_permintaan)->format('d/m/Y') }}</p>
                <p>: {{ $permintaanbarang->sifat }}</p>
            </td>
            <td style="border: 0px solid;vertical-align:top; width: 30%;"></td>
            <td style="border: 0px solid;vertical-align:top; width: 40%;"></td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: -10px;" >
        <thead style="border-top:1px solid #000">
            <tr >
                <th width="5%" style="text-align: center" >No.</th>
                <th width="20%" style="text-align: center">NAMA BARANG</th>
                <th width="12%" style="text-align: center" >QTY</th>
                <th width="15%" colspan="1" style="text-align: center" >HARGA</th>
                <th width="15%" colspan="1" style="text-align: center" >JUMLAH</th>
                <th width="15%" s>KETERANGAN</th>
            </tr>
        </thead>
        <tbody style="border-top:1px solid #000">
            @foreach($permintaanbarang->detail_permintaanbarangs as $i => $detail)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $detail->nama_barang }}</td>
                <td>{{ number_format($detail->qty, 0, ',', '.') }} {{ $detail->satuan }}</td>
                {{-- <td>Rp</td> --}}
                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                {{-- <td>Rp</td> --}}
                <td>Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                <td >{{ $detail->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:center"><strong>Total</strong></td>
                {{-- <td>Rp</td> --}}
                <td style="border:1px solid #000;" >Rp {{ number_format($permintaanbarang->total_harga, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>


       <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
            <tr>
                <td style="border: 0px solid black; width: 10%;">Dibuat Oleh,</td>
                <td style="border: 0px solid black; width: 10%;">Dicek Oleh,</td>
                <td style="border: 0px solid black; width: 10%;">Mengetahui,</td>
                <td style="border: 0px solid black; width: 10%;">Menyetujui,</td>
                
            </tr>
            <tr>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>{{$permintaanbarang->created_by}}  </td>
           
                <td style="border: 0px solid black; height: 40px; "><br><br><br>Sherren C I, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Erik Istanti</td>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>I Nyoman Madya P.</td>
                <td style="border: 0px solid black; height: 40px; "><br><br><br>Dr. I Ketut Martiana, Sp.OT</td>
            </tr>
            <!-- Tambahkan baris tambahan sesuai kebutuhan -->
        </table>
</body>
</html>

<script>
    window.print();
</script>