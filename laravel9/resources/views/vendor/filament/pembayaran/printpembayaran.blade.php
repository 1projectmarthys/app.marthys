


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
            border: 1px solid #000;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top:10px">
        <div class="header" style="display: flex; align-items: center; justify-content: space-between;">
            <img src="{{ asset('image/logo.jpg') }}" alt="Logo" style="width: 150px; height: auto;">
        </div>
        <div class="header" style="display: flex; align-items: center; justify-content: space-between;">
            <p style="flex-grow: 1; text-align: center; margin-top:-60px; font-size: 20pt; font-weight: bold;">FORMULIR PENGAJUAN PEMBAYARAN</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; border: 0;margin-top:-30px">
            <tr>
                <td style="border: 0px solid; vertical-align:top;">
                    <p><strong> Nomor Dokumen</p>
                    <p>Tanggal</strong></p>
                </td>
                <td style="border: 0px solid;vertical-align:top;">
                    <p>:</p>
                    <p>:</p>
                </td>
                <td style="border: 0px solid;vertical-align:top;">
                    <p>{{ $nomor_dokumen }}</p>
                    <p>{{ $tanggal->format('d F Y') }}</p>
                </td>
                <td style="border: 0px solid;vertical-align:top;">
                    <p><strong>Nama Supplier</p>
                    <p>Sumber Dana</p>
                    <p>Rencana Bayar</p></strong>
                </td>
                <td style="border: 0px solid;vertical-align:top;">
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </td>
                <td style="border: 0px solid;vertical-align:top;">
                    <p>{{ $pengajuan->nama_supplier }}</p>
                    <p>{{ $pengajuan->sumber_dana }}</p>
                    <p>{{ $rencana_bayar->format('d F Y') }}</p> 
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px;">
            <thead>
                <tr>
                    <th width="10%">Tgl. Dok</th>
                    <th width="30%">No. Dok</th>
                    <th width="40%">Uraian</th>
                    <th width="30%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan->detail_pengajuan as $detail)
                <tr>
                    <td>{{ $detail->tanggal_dokumen }}</td>
                    <td>{{ $detail->uraian }}</td>
                    <td>{{ $detail->keterangan }}</td>
                    <td>{{ $currency_symbol }} {{ number_format($detail->jumlah, 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td>Total</td>
                    <td>{{ $currency_symbol }} {{ number_format($pengajuan->grand_total, 2, ',', '.') }}</td>
                </tr>
                @if(!empty($pengajuan->keterangan_potong))
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td>{{ $pengajuan->keterangan_potong }}</td>
                    <td>{{ $currency_symbol }} {{ number_format($pengajuan->potongan_harga, 2, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td>Total Bayar</td>
                    <td>{{ $currency_symbol }} {{ number_format($pengajuan->total_bayar, 2, ',', '.') }}</td>
                </tr>
                @if($pengajuan->mata_uang !== 'IDR')
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td>Estimasi Kurs</td>
                    <td>Rp {{ number_format($pengajuan->kurs, 2, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="border:0px" colspan="2"></td>
                    <td>Total Bayar (IDR)</td>
                    <td>Rp {{ number_format($pengajuan->total_bayar * $pengajuan->kurs, 2, ',', '.') }}</td>
                </tr>
                @endif
            </tfoot>
        </table>

        <br>
        @if($pengajuan->jumlah_kolom === "3kolom")
            <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
                <tr>
                    <td style="border: 0px solid black; width: 10%;">Dibuat Oleh,</td>
                    <td style="border: 0px solid black; width: 10%;">Mengetahui,</td>
                    <td style="border: 0px solid black; width: 10%;">Menyetujui,</td>
                </tr>
                <tr>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(Sherren Cynthia Immelda)</td>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(I Nyoman Madya P.)</td>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(Dr. I Ketut Martiana, Sp.OT)</td>
                </tr>
            </table>
        @else
            <table style="border-collapse: collapse; width: 100%; font-size: 11pt">
                <tr>
                    <td style="border: 0px solid black; width: 10%;">Dibuat Oleh,</td>
                    <td style="border: 0px solid black; width: 10%;">Dicek Oleh,</td>
                    <td style="border: 0px solid black; width: 10%;">Mengetahui,</td>
                    <td style="border: 0px solid black; width: 10%;">Menyetujui,</td>
                </tr>
                <tr>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(Aidatul Hikmah)</td>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(Sherren Cynthia Immelda)</td>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(I Nyoman Madya P.)</td>
                    <td style="border: 0px solid black; height: 40px;"><br><br><br>(Dr. I Ketut Martiana, Sp.OT)</td>
                </tr>
            </table>
        @endif
    </div>
</body>
</html>
<script>
    window.print();
</script>