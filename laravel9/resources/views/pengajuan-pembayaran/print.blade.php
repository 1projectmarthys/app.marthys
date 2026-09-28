@extends('layouts.print')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-2xl font-bold">PENGAJUAN PEMBAYARANS</h1>
        <p class="text-sm text-gray-600">Nomor: {{ $pengajuan->nomor_dokumen }}</p>
    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-2 gap-8">
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Supplier:</h3>
                <p class="mt-1">{{ $pengajuan->nama_supplier }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Sumber Dana:</h3>
                <p class="mt-1">{{ $pengajuan->sumber_dana }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Mata Uang:</h3>
                <p class="mt-1">{{ $pengajuan->mata_uang }}</p>
            </div>
        </div>
        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Tanggal:</h3>
                <p class="mt-1">{{ $pengajuan->tanggal->format('d/m/Y') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Rencana Bayar:</h3>
                <p class="mt-1">{{ $pengajuan->rencana_bayar->format('d/m/Y') }}</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-700">Status:</h3>
                <p class="mt-1">{{ ucfirst($pengajuan->status_bayar) }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="mt-8">
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-4 py-2 border text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-4 py-2 border text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-2 border text-left text-xs font-medium text-gray-500 uppercase">No Faktur</th>
                    <th class="px-4 py-2 border text-left text-xs font-medium text-gray-500 uppercase">Jumblah</th>
                    <th class="px-4 py-2 border text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pengajuan->detail_pengajuan as $index => $detail)
                <tr>
                    <td class="px-4 py-2 border text-sm">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border text-sm">
    {{ \Carbon\Carbon::parse($detail->tanggal_dokumen)->format('d-m-Y') }}
</td>

                    <td class="px-4 py-2 border text-sm">{{ $detail->uraian }}</td>
                    <td class="px-4 py-2 border text-sm text-right">{{ number_format($detail->jumlah, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 border text-sm">{{ $detail->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-4 py-2 border text-sm font-medium text-right">Grand Total:</td>
                    <td class="px-4 py-2 border text-sm font-medium text-right">
                        {{ number_format($pengajuan->grand_total, 2, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border"></td>
                </tr>
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-4 py-2 border text-sm font-medium text-right">Potongan:</td>
                    <td class="px-4 py-2 border text-sm font-medium text-right text-red-600">
                        -{{ number_format($pengajuan->potongan_harga, 2, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border text-sm">{{ $pengajuan->keterangan_potong }}</td>
                </tr>
                <tr class="bg-gray-50">
                    <td colspan="3" class="px-4 py-2 border text-sm font-bold text-right">Total Bayar:</td>
                    <td class="px-4 py-2 border text-sm font-bold text-right">
                        {{ number_format($pengajuan->total_bayar, 2, ',', '.') }}
                    </td>
                    <td class="px-4 py-2 border"></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Signatures -->
    <div class="mt-16 grid grid-cols-3 gap-8">
        <div class="text-center">
            <p class="text-sm">Dibuat oleh,</p>
            <div class="mt-16">
                <p class="text-sm font-medium">(_________________)</p>
                <p class="text-sm text-gray-600">Staff Keuangan</p>
            </div>
        </div>
        <div class="text-center">
            <p class="text-sm">Diperiksa oleh,</p>
            <div class="mt-16">
                <p class="text-sm font-medium">(_________________)</p>
                <p class="text-sm text-gray-600">Manager Keuangan</p>
            </div>
        </div>
        <div class="text-center">
            <p class="text-sm">Disetujui oleh,</p>
            <div class="mt-16">
                <p class="text-sm font-medium">(_________________)</p>
                <p class="text-sm text-gray-600">Direktur</p>
            </div>
        </div>
    </div>
</div>
@endsection