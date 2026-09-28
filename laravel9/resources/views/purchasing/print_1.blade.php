<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Purchasing</title>
    <style>
        @media print {
          /*  @page { size: A4 landscape; margin: 8mm; }*/
            body { margin: 0; }
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
        .items tfoot td { border-bottom: none; }
        .items tfoot tr.total-row td { border-top: 1px solid #000; font-weight: bold; }
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
    @if($purchasing)
    {{-- ===== HEADER ===== --}}
    <div class="header">
        <div class="brand">
            <img src="{{ asset('image/logo.jpg') }}" alt="marthys">
        </div>
        <div class="title">
            <strong>{{ strtoupper($purchasing->tipe_pembayaran) }} <span class="star">*</span></strong>
        </div>
        <div class="meta">
            <table>
                <tr>
                    <td class="lbl" style="border-bottom:none; border-top:none;">Nomor</td>
                    <td style="border-bottom:none; border-top:none;">: {{ $purchasing->nomor_dokumen }}</td>
                </tr>
                <tr>
                    <td class="lbl" style="border:none;">Tanggal</td>
                    <td style="border-bottom:none; border-top:none;">: {{ $tanggal->format('d F Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
    {{-- ===== INFO PURCHASING ===== --}}
    <table class="vendor">
        <tr>
            <td class="lbl">Metode Pembayaran</td>
            <td style="width:32%;">: {{ $purchasing->sumber_dana }}</td>
            <td class="lbl" style="width:14%;">Nama Vendor</td>
            <td>: {{ $purchasing->nama_supplier }}</td>
        </tr>
        <tr>
            <td class="lbl">Rencana Bayar</td>
            <td>: {{ $rencana_bayar->format('d F Y') }}</td>
            <td class="lbl">Note</td>
            <td>: {{ $purchasing->note }}</td>
        </tr>
    </table>
    {{-- ===== TABEL ITEM ===== --}}
    <table class="items">
        @if($purchasing->mata_uang !== 'IDR')
        {{-- Header untuk mata uang asing --}}
        <thead>
            <tr>
                <th style="width:2%;">No.</th>
                <th style="width:16%;">No. Dok</th>
                <th style="width:12%;">Tanggal</th>
                <th style="width:23%;">Uraian</th>
                <th style="width:5%;">CRY</th>
                <th class="amt" style="width:12%;">Amount</th>
                <th class="amt" style="width:8%;">Kurs</th>
                <th class="amt" colspan="2">Jumlah</th>
            </tr>
        </thead>
        @else
        {{-- Header untuk IDR --}}
        <thead>
            <tr>
                <th style="width:4%;">No.</th>
                <th style="width:20%;">No. Dok</th>
                <th style="width:15%;">Tanggal</th>
                <th>Uraian</th>
                <th class="amt" colspan="2">Jumlah</th>
            </tr>
        </thead>
        @endif
        <tbody>
            @foreach($purchasing->detail_purchasing as $index => $detail)
            @if($purchasing->mata_uang !== 'IDR')
            <tr>
                <td class="num">{{ $index + 1 }}</td>
                <td>{{ $detail->uraian }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal_dokumen)->format('d-m-Y') }}</td>
                <td>{{ $detail->keterangan }}</td>
                <td>{{ $purchasing->mata_uang }}</td>
                <td class="amt">{{ number_format($detail->jumlah, 2, ',', '.') }}</td>
                <td class="amt">{{ number_format($purchasing->kurs, 2, ',', '.') }}</td>
                <td class="amt" colspan="2">Rp {{ number_format($detail->jumlah * $purchasing->kurs, 2, ',', '.') }}</td>
            </tr>
            @else
            <tr>
                <td class="num">{{ $index + 1 }}</td>
                <td>{{ $detail->uraian }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->tanggal_dokumen)->format('d-m-Y') }}</td>
                <td>{{ $detail->keterangan }}</td>
                <td class="amt" colspan="2">{{ $currency_symbol }} {{ number_format($detail->jumlah, 2, ',', '.') }}</td>
            </tr>
            @endif
            @endforeach

            @if($purchasing->biaya_admin > 0)
                @if($purchasing->mata_uang !== 'IDR')
                    <tr>
                        <td class="num">{{ count($purchasing->detail_purchasing) + 3 }}</td>
                        <td></td>
                        <td colspan="4">Admin Bank</td>
                        <td class="amt" colspan="3">Rp {{ number_format($purchasing->biaya_admin, 2, ',', '.') }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="num">{{ count($purchasing->detail_purchasing) + 3 }}</td>
                        <td></td>
                        <td colspan="2">Admin Bank</td>
                        <td class="amt" colspan="2">Rp {{ number_format($purchasing->biaya_admin, 2, ',', '.') }}</td>
                    </tr>
                @endif
            @endif
        </tbody>
        <tfoot>
            @if($purchasing->keterangan_potong > 0)
            <tr>
                @if($purchasing->mata_uang !== 'IDR')
                <td colspan="6"></td>
                <td style="text-align:right;">{{ $purchasing->keterangan_potong }}</td>
                <td class="amt" colspan="2">Rp {{ number_format($purchasing->potongan_harga, 2, ',', '.') }}</td>
                @else
                <td colspan="3"></td>
                <td style="text-align:right;">{{ $purchasing->keterangan_potong }}</td>
                <td class="amt" colspan="2">{{ $currency_symbol }} {{ number_format($purchasing->potongan_harga, 2, ',', '.') }}</td>
                @endif
            </tr>
            @endif

            @if($purchasing->mata_uang === 'IDR')
            <tr class="total-row">
                <td colspan="3"></td>
                <td style="text-align:right;">Total Bayar</td>
                <td class="amt" colspan="2">{{ $currency_symbol }} {{ number_format($purchasing->total_bayar, 2, ',', '.') }}</td>
            </tr>
            @elseif($purchasing->mata_uang !== '')
                @if($purchasing->potongan_harga > 0)
                <tr>
                    <td colspan="6"></td>
                    <td style="text-align:right;">{{ $purchasing->keterangan_potong }}</td>
                    <td class="amt" colspan="2">Rp {{ number_format($purchasing->potongan_harga, 2, ',', '.') }}</td>
                </tr>
                @endif
            <tr class="total-row">
                <td colspan="6"></td>
                <td style="text-align:right;">Total Bayar (IDR)</td>
                <td class="amt" colspan="2">Rp {{ number_format($purchasing->total_bayar, 2, ',', '.') }}</td>
            </tr>
            @endif
        </tfoot>
    </table>
    {{-- ===== LAMPIRAN ===== --}}
    <div class="lampiran">
        <strong>Lampiran :</strong>
        <span class="cb"></span> Invoice, SJ, FP, PO
        <span class="cb"></span> SPBB
        <span class="cb"></span> Kontrak / Perjanjian
        @if (!empty($purchasing->lampiran))
            <span class="cb"></span> Lainnya : {{ $purchasing->lampiran }}
        @else
            <span class="cb"></span> Lainnya : _________________________
        @endif
    </div>
    {{-- ===== TANDA TANGAN ===== --}}
    @if($purchasing->jumlah_kolom === '3kolom')
        <table class="sign">
            <tr>
                <th style="width:16.6%;">Diajukan</th>
                <th style="width:16.6%;">Diketahui</th>
                <th style="width:16.6%;">Diverifikasi</th>
                <th style="width:16.6%;">Direview</th>
                <th style="width:33.3%;" colspan="2">Disetujui</th>
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
                <td><strong>PIC Dept</strong></td>
                <td><strong>Atasan Dept.</strong></td>
                <td><strong>Finance</strong></td>
                <td><strong>Manager FA</strong></td>
                <td><strong>General Manager</strong></td>
                <td><strong>Direktur Utama</strong></td>
            </tr>
        </table>
    @else
        <table class="sign">
           <tr>
                <th style="width:16.6%;">Diajukan</th>
                <th style="width:16.6%;">Diketahui</th>
                <th style="width:16.6%;">Diverifikasi</th>
                <th style="width:16.6%;">Direview</th>
                <th style="width:33.3%;" colspan="2">Disetujui</th>
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
                <td><strong>PIC Dept</strong></td>
                <td><strong>Atasan Dept.</strong></td>
                <td><strong>Finance</strong></td>
                <td><strong>Manager FA</strong></td>
                <td><strong>General Manager</strong></td>
                <td><strong>Direktur Utama</strong></td>
            </tr>
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