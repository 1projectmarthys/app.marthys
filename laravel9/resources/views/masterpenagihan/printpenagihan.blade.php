<!DOCTYPE html>
<html>
 <head>
  <title>Cetak Tanda Terima Tagihan</title>
  <style>
  @media print {
        @page {
            size: 210mm 297mm potrait; /* Ukuran kertas 9x11 inci */
            margin-top: 5mm; /* Atur margin sesuai kebutuhan */
            margin-left:0mm;
            margin-bottom:0mm;
            margin-right:1mm;
        }
  }
    
   body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            
            align-items: left;
        }
        .header img {
            width: 150px;
            height:55px;
            margin-top:10px;
        }
        .header .company-info {
            text-align: left;
        }
        .header .company-info p {
            margin: 0;
        }
        .invoice-info {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-info .bill-to {
            width: 60%;
        }
        .invoice-info .date-amount {
            width: 35%;
            text-align: right;
        }
        .invoice-info .date-amount .date,
        .invoice-info .date-amount .amount {
            background-color: #f4a261;
            padding: 10px;
            margin-bottom: 5px;
        }
        .invoice-title {
            text-align: center;
            margin: 20px 0;
        }
        .invoice-title h1 {
            margin: 0;
        }
        .invoice-title p {
            margin: 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-table th,
        .invoice-table td {
            border-top: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f4f4f4;
        }
        .total-amount {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        .total-amount .total {
            background-color: #f4a261;
            padding: 10px;
        }
        .footer {
            margin-top: 40px;
        }
        .footer p {
            margin: 5px 0;
        }
  </style>
 </head>
 <body>
    <div class="container">
     <div class="header" style="margin-top:10px">
        <img alt="Company Logo" height="100" src="{{ asset('image/logo.jpg') }}" width="100%" style="vertical-align: middle;"/>
        <div class="company-info" style="margin-left:15px">
            <p><strong>PT Marthys Orthopaedic Indonesia</strong></p>
            <p>Jl. Indrokilo Km 4.2 Bulukandang, Kecamatan Prigen,<br>
               Kabupaten Pasuruan, Jawa Timur, Indonesia 67157<br>
               Telp. 0343-6749282 | www.marthysorthopaedic.com | +6281 3218 0674
            </p>
        </div>
     </div>
   
     <br>
   
     <table style="width:100%">
         <tr>
             <td style="border-top:1px solid;width:60%;">
                 <strong><br>TAGIHAN KEPADA :</strong><br>
                 {{ $masterPenagihan->nama_customer }} <br>
                 {{ $masterPenagihan->alamat_customer }}<br>
                 <strong>({{ $masterPenagihan->keterangan_lengkap }})</strong><br>
             </td>
             <td style="background-color:#f2f2f2;border-top:1px solid;border-bottom:1px solid;width:40%;text-align:right;padding-right:10px">
                 <div style="font-size:18pt"><strong>TANDA TERIMA TAGIHAN</strong></div>
                 <div><strong>{{ $nomorDokumen }}</strong></div>
                 <div><strong>{{ date('d/m/Y', strtotime($masterPenagihan->tanggal_dokumen)) }}</strong></div>
             </td>
         </tr>
      </table>
    <br>
    <br>
    <br>
    <div>Dengan ini kami telah menerima dokumen asli berupa Invoice, Surat Jalan dan Faktur Pajak dengan rincian sebagai berikut :</div>
     <table class="invoice-table" id="detailTable">
         <thead>
             <tr>
                 <th>No.</th>
                 <th>Tgl. Invoice</th>
                 <th>No. Invoice</th>
                 <th>No. Faktur Pajak</th>
                 <th>Jumlah</th>
                 <th>Keterangan</th>
             </tr>
         </thead>
         <tbody>
              @foreach ($masterPenagihan->detail_penagihan as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ date('d-m-Y', strtotime($detail->tanggal)) }}</td>
                    <td>{{ $detail->no_faktur }}</td>
                    <td>{{ $detail->no_faktur_pajak }}</td>
                    <td>Rp {{ number_format($detail->jumlah, 2, ',', '.') }}</td>
                    <td>{{ $detail->keterangan }}</td>
                </tr>
              @endforeach
         </tbody>
     </table>

     <br>
     <br>
     <br>
     
     <table style="height:60px;float:right;margin-right:190px;">
         <tr>
             <td style="background-color:#f4a261;padding-right:20px;padding-left:20px;">
                 <strong>  TOTAL TAGIHAN  </strong>
             </td>
             <td style="border-right:1px solid">
             </td>
             <td style="padding-left:10px">
                <strong> {{ $formatRupiah }} </strong>
             </td>
         </tr>
     </table>

     <p><i>Terbilang: {{ $terbilangText }} Rupiah</i></p>

     <br>
     <br>
     <table style="width:100%;">
         <tr>
         <td style="width:100%;">
                <strong>Pembayaran Di Transfer Ke :</strong> <br>
                Bank BCA KCP Dharmahusada, Surabaya<br>
                A/N PT. Marthys Orthopaedic Indonesia<br>
                A/C 3880-358-005
            </td>
            </tr>
     </table>
     <br>
     <table style="width:100%; height:150px;">
         <tr >
             <td style="padding: 2px; border:1px solid; vertical-align:top;">
                  Tanggal : {{ \Carbon\Carbon::parse($masterPenagihan->tanggal_dokumen)->translatedFormat('d F Y') }}
             </td>
             <td style="padding: 2px; border:1px solid; vertical-align:top;">
                 Tanggal : 
             </td>
         </tr>
         
            <tr style="text-align: left;">
                <td style="padding: 2px; border:1px solid; vertical-align:top;">
                    Diserahkan Oleh,
                    <br>PT. MARTHYS ORTHOPAEDIC INDONESIA
                    <br><br><br><br><br>
                    (Alfiliary)
                </td>
                <td style="padding: 2px;  border:1px solid; vertical-align:top;">
                    Diterima Oleh,
                    <br>{{ $masterPenagihan->nama_customer }}
                    <br><br><br><br><br>
                    (____________________)
                </td>
            </tr>
        </table>
 </body>
</html>
<script>
    window.print();
</script>