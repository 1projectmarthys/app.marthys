<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Pengajuan Pembayaran</title>
    <style>
        @media print {
            
            
        }
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 11pt; color: #000; }
        table { border-collapse: collapse; }
        /* ===== HEADER ===== */
        .header { display:flex; border-bottom: 1px solid #000; border-top:1px solid #000; padding-bottom: 8px; }
        .brand {width: 15%;display: flex;justify-content: center;align-items: center;}
        .brand img {max-width: 150px;max-height: 50px;width: auto;height: auto;display: block;}
        .title {width: 50%;display: flex;flex-direction: column;justify-content: center;align-items: center;text-align: center;}
        .title strong {font-size: 15pt;line-height: 1;}
        .title .star { color: #e8342a; }
        .meta { width: 35%; font-size: 10pt; }
        .meta table { width: 100%; }
        .meta td { padding: 2px 4px; border-bottom: 1px solid #000; }
        .meta td.lbl { width: 32%; font-weight: bold; }
        .meta td.val-red { color: #e8342a; }
        /* ===== VENDOR / INFO ===== */
        .vendor { width: 100%; border-bottom: 1px solid #000; margin-top: 2px; }
        .vendor td { padding: 2px 4px; font-size: 10pt; vertical-align: top; }
        .vendor td.lbl { width: 18%; font-weight: bold; }
        /* ===== ITEMS ===== */
        .items { width: 100%; margin-top: 6px; }
        .items th { border-bottom: 1px solid #000; text-align: left; padding: 6px 8px; font-size: 10pt; }
        .items td { border-bottom: 1px solid #ccc; padding: 6px 8px; font-size: 10pt; }
        .items .num, .items .amt { text-align: right; }
        .total { border-top: 1px solid #000; border-bottom: 1px solid #000; }
        .total td { padding: 8px; font-weight: bold; }
        /* ===== LAMPIRAN ===== */
        .lampiran { margin: 14px 0; font-size: 10pt; }
        .cb { display: inline-block; width: 12px; height: 12px; border: 1px solid #000;
              vertical-align: middle; margin: 0 4px 0 12px; }
        /* ===== TANDA TANGAN ===== */
        .sign { width: 100%; border: 1px solid #000; font-size: 10pt; }
        .sign th, .sign td { border: 1px solid #000; text-align: center; padding: 6px; }
        .sign .space { height: 70px; vertical-align: bottom; }
    </style>
</head>
<body>
   <tr>
        <td style="width: 100%; border-bottom: 1px solid #000; "></td>
    </tr>
    {{-- ===== HEADER ===== --}}
    <div class="header" style="">

        <div class="brand">
           
        </div>
        <div class="title">
            <strong>FORM PENGAJUAN PEMBAYARAN<br>LEGALITAS NON-PERUSAHAAN <span class="star">*</span></strong>
        </div>
        <div class="meta">
            <table>
                <tr>
                    <td class="lbl" style="border-bottom:none; border-top:none; text-transform:capitalize;">Nomor</td>
                    <td style="border-bottom:none; border-top:none; text-transform:capitalize;">: {{ $anggaranlegal->nomor_dokumen }}</td>
                </tr>
                <tr>
                    <td class="lbl" style="border-bottom:none; border-top:none; text-transform:capitalize;">Tanggal</td>
                    <td style="border-bottom:none; border-top:none; text-transform:capitalize;">: {{ \Carbon\Carbon::parse($anggaranlegal->tanggal_anggaran)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="lbl" style="border:none;">Sifat</td>
                    <td style="border-bottom:none; border-top:none; text-transform:capitalize;">: {{ $anggaranlegal->sifat }}</td>
                </tr>
            </table>
        </div>
    </div>
    {{-- ===== INFO PENGAJUAN ===== --}}
    <table class="vendor">
        <tr>
            <td class="lbl">Instansi</td>
            <td style="width:47%;">: {{ $anggaranlegal->diajukan_oleh }}</td>
            <td class="lbl" style="width:8%;">Note</td>
            <td>:</td>
        </tr>
        <tr>
            <td class="lbl">Perihal</td>
            <td>: {{ $anggaranlegal->perihal }}</td>

        </tr>
    </table>
    {{-- ===== TABEL ITEM ===== --}}
    <table class="items">
        <thead>
            <tr>
                <th style="width:4%;">No.</th>
                <th>Deskripsi</th>
                 <th style="width:18%;">Keterangan</th>
                <th class="amt" style="width:8%;">Qty</th>
                <th class="amt" style="width:18%;">Nominal Satuan (Rp)</th>
                <th class="amt" style="width:18%;">Jumlah (Rp)</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($anggaranlegal->detail_anggaranlegal as $index => $item)
            <tr>
                <td class="num">{{ $index + 1 }}</td>
                <td>{{ $item->deksripsi }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="num">{{ number_format($item->qty, 0, ',', '.') }}</td>
                <td class="amt">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td class="amt">Rp {{ number_format((($item->qty ?? 0) * ($item->harga ?? 0)), 0, ',', '.') }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- ===== TOTAL ===== --}}
    <table class="items total" style="margin-top:0;">
        <tr>
            <td style="text-align:right;">Total Pembayaran&nbsp;&nbsp;Rp</td>
            <td class="amt" style="width:18%;">{{ number_format($anggaranlegal->total_harga, 0, ',', '.') }}</td>
        </tr>
    </table>
    {{-- ===== LAMPIRAN ===== --}}
    <div class="lampiran">
        <strong>Lampiran :</strong>
        <span class="cb"></span> Invoice, SJ, FP, PO
        <span class="cb"></span> SPBB
        <span class="cb"></span> Kontrak / Perjanjian
        <span class="cb"></span> Lainnya : _________________________
    </div>
    {{-- ===== TANDA TANGAN ===== --}}
    
    
    @if($anggaranlegal->diterima == 'finance')
    <table class="sign">
        <tr>
            <th style="width:15%;">Diajukan</th>
            <th style="width:15%;">Diketahui</th>
            <th style="width:15%;">Diverifikasi</th>
            <th style="width:15%;">Direview</th>
            
        </tr>
        <tr>
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
        </tr>
    </table>
    
     @elseif($anggaranlegal->diterima == 'accounting')
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
            <td style="width:15%;">Wakil Direktur</td>
            <td style="width:15%;">Direktur Utama</td>
        </tr>
    </table>
    @endif
</body>
</html>
<script>
    window.print();
</script>