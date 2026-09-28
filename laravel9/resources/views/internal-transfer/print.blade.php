<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Form Internal Transfer - {{ $transfer->nomor_dokumen }}</title>
    <style>
        @media print {
           
            .no-print { display: none !important; }
        }

        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 24px;
        }
        table { border-collapse: collapse; }
        .sheet { width: 100%; max-width: 1050px; margin: 0 auto; }

        /* ===== HEADER ===== */
        .top { width: 100%; margin-bottom: 14px; }
        .top td { vertical-align: middle; padding: 0; }
        .brand img { height: 52px; width: auto; }
        .brand-fallback { font-weight: bold; font-size: 16pt; line-height: 1; }
        .brand-fallback small { display: block; font-size: 7pt; letter-spacing: 3px; background: #f0a500; color: #000; padding: 2px 6px; width: max-content; margin-top: 2px; }
        .doc-title { text-align: center; font-size: 22pt; font-weight: bold; line-height: 1.05; }

        .meta { font-size: 11pt; }
        .meta td { padding: 1px 3px; white-space: nowrap; }
        .meta td:first-child { width: 118px; }

        /* ===== REKENING ===== */
        .rek-wrap { width: 100%; margin-top: 4px; }
        .rek-wrap > tbody > tr > td { width: 50%; vertical-align: top; padding: 0; }
        .rek-wrap > tbody > tr > td:first-child { padding-right: 12px; }

        .rek { width: 100%; border: 1px solid #000; font-size: 11pt; }
        .rek th, .rek td { border: 1px solid #000; padding: 5px 10px; }
        .rek th { text-align: center; font-weight: bold; }
        .rek td:first-child { width: 42%; }

        /* ===== JUMLAH ===== */
        .jumlah { width: 100%; margin-top: 16px; font-size: 12pt; }
        .jumlah td { border: 1px solid #000; padding: 6px 10px; }
        .jumlah td.lbl { width: 160px; }

        /* ===== BAWAH: JENIS + NOTE/TTD ===== */
        .bottom { width: 100%; margin-top: 20px; }
        .bottom > tbody > tr > td { vertical-align: top; padding: 0; }
        .bottom > tbody > tr > td.left { width: 34%; padding-right: 18px; }

        .jenis-title { margin-bottom: 8px; }
        .jenis-item { margin: 7px 0; }
        .cb {
            display: inline-block; width: 14px; height: 14px;
            border: 1px solid #000; margin-right: 10px; vertical-align: -2px;
            text-align: center; line-height: 13px; font-size: 11px;
        }
        .lainnya-line { border-bottom: 1px solid #000; display: inline-block; min-width: 160px; }

        .note-line { margin-bottom: 8px; }

        .sign { width: 100%; font-size: 11pt; }
        .sign th, .sign td { border: 1px solid #000; text-align: center; padding: 5px; }
        .sign .space { height: 62px; }

        .print-btn {
            display: inline-block; margin-bottom: 18px; padding: 8px 16px;
            background: #1a56db; color: #fff; border: none; border-radius: 6px;
            font-size: 12px; cursor: pointer;
        }
    </style>
</head>
<body>
 

    <div class="sheet">
        {{-- ===== HEADER ===== --}}
        <table class="top">
            <tr>
                <td class="brand" style="width:230px;">
                    <img src="{{ asset('image/logo.png') }}" alt="marthys"
                         onerror="this.style.display='none';document.getElementById('brandfb').style.display='block';">
                    <div id="brandfb" class="brand-fallback" style="display:none;">
                        marthys<small>ORTHOPAEDICS</small>
                    </div>
                </td>
                <td class="doc-title">FORM INTERNAL<br>TRANSFER</td>
                <td style="width:300px;">
                    <table class="meta">
                        <tr><td>Nomor</td><td>: {{ $transfer->nomor_dokumen }}</td></tr>
                        <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($transfer->tanggal)->format('d/m/Y') }}</td></tr>
                        <tr><td>Rencana Bayar</td><td>: {{ \Carbon\Carbon::parse($transfer->rencana_bayar)->format('d/m/Y') }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ===== REKENING PENGIRIM & PENERIMA ===== --}}
        <table class="rek-wrap">
            <tr>
                <td>
                    <table class="rek">
                        <tr><th colspan="2">Rekening Pengirim</th></tr>
                        <tr><td>Dari Bank</td><td>: {{ $transfer->dari_bank }}</td></tr>
                        <tr><td>No. Rekening</td><td>: {{ $transfer->norek_pengirim }}</td></tr>
                        <tr><td>Atas Nama</td><td>: {{ $transfer->atasnama_pengirim }}</td></tr>
                    </table>
                </td>
                <td>
                    <table class="rek">
                        <tr><th colspan="2">Rekening Penerima</th></tr>
                        <tr><td>Ke Bank</td><td>: {{ $transfer->ke_bank }}</td></tr>
                        <tr><td>No. Rekening</td><td>: {{ $transfer->norek_penerima }}</td></tr>
                        <tr><td>Atas Nama</td><td>: {{ $transfer->atasnama_penerima }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ===== JUMLAH TRANSFER & TERBILANG ===== --}}
        <table class="jumlah">
            <tr>
                <td class="lbl">Jumlah Transfer</td>
                <td>: Rp {{ number_format($transfer->jumlah_transfer, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="lbl">Terbilang</td>
                <td>: {{ $transfer->terbilang }}</td>
            </tr>
        </table>

        {{-- ===== JENIS TRANSFER + NOTE/TTD ===== --}}
        <table class="bottom">
            <tr>
                <td class="left">
                    <div class="jenis-title">Jenis Transfer :</div>
                    @foreach(\App\Models\InternalTransfer::jenisTransferOptions() as $key => $label)
                        @if($key === 'lainnya')
                            <div class="jenis-item">
                                <span class="cb">{!! $transfer->jenis_transfer === 'lainnya' ? '&#10003;' : '' !!}</span>
                                Lainnya :
                                <span class="lainnya-line">{{ $transfer->jenis_transfer === 'lainnya' ? $transfer->jenis_transfer_lainnya : '' }}</span>
                            </div>
                        @else
                            <div class="jenis-item">
                                <span class="cb">{!! $transfer->jenis_transfer === $key ? '&#10003;' : '' !!}</span>
                                {{ $label }}
                            </div>
                        @endif
                    @endforeach
                </td>
                <td>
                    <div class="note-line">Note : {{ $transfer->note }}</div>
                    <table class="sign">
                        <tr>
                            <th style="width:16%;">Diajukan</th>
                            <th style="width:16%;">Diverifikasi</th>
                            <th style="width:16%;">Diperiksa</th>
                            <th colspan="2">Disetujui</th>
                        </tr>
                        <tr>
                            <td class="space"></td>
                            <td class="space"></td>
                            <td class="space"></td>
                            <td class="space" style="width:26%;"></td>
                            <td class="space" style="width:26%;"></td>
                        </tr>
                        <tr>
                            <td>Finance</td>
                            <td>Accounting</td>
                            <td>Manager FA</td>
                            <td>Wakil Direktur</td>
                            <td>Direktur Utama</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
