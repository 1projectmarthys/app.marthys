@php
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Pengendalian Sistem IT</title>
    <style>
        @media print {
            body { 
                margin: 0;
                font-family: 'Times New Roman', serif;
                font-size: 11px;
            }
            .header { 
                margin-bottom: 15px;
            }
            .logo { 
                width: 80px;
                float: left;
            }
            .logo img {
                width: 100%;
                height: auto;
            }
            .company-name {
                margin-left: 10px;
                font-size: 11px;
                font-weight: bold;
            }
            .doc-number {
                display: inline-block;
                border: 1px solid black;
                padding: 2px 4px;
                font-size: 10px;
                font-weight: bold;
            }
            .title {
                text-align: center;
                margin: 10px 0;
            }
            .title h1, .title h2 {
                margin: 5px 0;
                font-size: 14px;
            }
            table { 
                border-collapse: collapse; 
                width: 100%;
                margin-top: 5px;
            }
            th, td { 
                border: 1px solid black; 
                padding: 5px; 
                text-align: center; 
                font-size: 10px;
                vertical-align: middle;
            }
            th { 
                background-color: #f2f2f2;
                font-weight: bold;
            }
            td {
                padding: 8px 4px;
            }
            .user-info {
                margin-bottom: 10px;
                font-size: 11px;
            }
            .signature-img {
                width: 30px;
                height: auto;
            }
            @page { 
                size: A4 portrait;
                margin: 15mm;
                scale: 80%;
            }
        }
    </style>
</head>
<body>
    <div id="print-content">
        <div class="header">
            <table style="border: none;">
                <tr>
                    <td style="border: none; width: 70%; text-align: left;">
                        <div style="display: flex; align-items: center;">
                            <img src="{{ asset('image/logo.jpg') }}" alt="Logo" style="width: 80px; margin-right: 10px;">
                            <span class="company-name">PT. Marthys Orthopaedic Indonesia</span>
                        </div>
                    </td>
                    <td style="border: none; width: 30%; text-align: right;">
                        <div class="doc-number">MOI-FM-IT-01-02/A1</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="title">
            <h1>CEKLIST PENGENDALIAN SISTEM IT</h1>
            <h2>{{$tahun}}</h2>
        </div>

        <div class="user-info">USER : {{$nama}}</div>

        <table class="data">
            <tr>
                <th rowspan="2" style="width: 8%;">BULAN</th>
                <th colspan="2" style="width: 18%;">BACKUP DATA</th>
                <th colspan="2" style="width: 18%;">UPDATE ANTI VIRUS</th>
                <th colspan="2" style="width: 18%;">TROUBLE SHOOTING</th>
                <th colspan="2" style="width: 18%;">DEFRAGMENT</th>
                <th rowspan="2" style="width: 20%;">KETERANGAN</th>
            </tr>
            <tr>
                <th style="width: 9%;">TGL</th>
                <th style="width: 9%;">PARAF</th>
                <th style="width: 9%;">TGL</th>
                <th style="width: 9%;">PARAF</th>
                <th style="width: 9%;">TGL</th>
                <th style="width: 9%;">PARAF</th>
                <th style="width: 9%;">TGL</th>
                <th style="width: 9%;">PARAF</th>
            </tr>
            @foreach($months as $monthNumber => $monthName)
                <tr>
                    <td>{{ $monthName }}</td>
                    <td>{{ isset($records[$monthNumber][0]->backup_data_tanggal) ? \Carbon\Carbon::parse($records[$monthNumber][0]->backup_data_tanggal)->format('d/m/y') : '-' }}</td>
                    <td>
                        @if(isset($records[$monthNumber][0]->backup_data_checked) && $records[$monthNumber][0]->backup_data_checked)
                            <img class="signature-img" src="{{ asset('image/' . $records[$monthNumber][0]->pengontrol) }}" alt="Paraf">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ isset($records[$monthNumber][0]->antivirus_update_tanggal) ? \Carbon\Carbon::parse($records[$monthNumber][0]->antivirus_update_tanggal)->format('d/m/y') : '-' }}</td>
                    <td>
                        @if(isset($records[$monthNumber][0]->antivirus_update_checked) && $records[$monthNumber][0]->antivirus_update_checked)
                            <img class="signature-img" src="{{ asset('image/' . $records[$monthNumber][0]->pengontrol) }}" alt="Paraf">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ isset($records[$monthNumber][0]->troubleshooting_tanggal) ? \Carbon\Carbon::parse($records[$monthNumber][0]->troubleshooting_tanggal)->format('d/m/y') : '-' }}</td>
                    <td>
                        @if(isset($records[$monthNumber][0]->troubleshooting_checked) && $records[$monthNumber][0]->troubleshooting_checked)
                            <img class="signature-img" src="{{ asset('image/' . $records[$monthNumber][0]->pengontrol) }}" alt="Paraf">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ isset($records[$monthNumber][0]->defragment_tanggal) ? \Carbon\Carbon::parse($records[$monthNumber][0]->defragment_tanggal)->format('d/m/y') : '-' }}</td>
                    <td>
                        @if(isset($records[$monthNumber][0]->defragment_checked) && $records[$monthNumber][0]->defragment_checked)
                            <img class="signature-img" src="{{ asset('image/' . $records[$monthNumber][0]->pengontrol) }}" alt="Paraf">
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: left;">{{ $records[$monthNumber][0]->keterangan ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>