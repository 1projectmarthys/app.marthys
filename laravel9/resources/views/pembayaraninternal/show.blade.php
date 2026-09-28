@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Detail Form Pembayaran Internal
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('print.pembayaraninternal', $pembayaraninternal->id) }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        target="_blank">
                        <i class="fas fa-print mr-2"></i>
                        Cetak
                    </a>
                    <a href="{{ route('pengajuan-pembayaran.index') . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '') }}" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor Dokumen</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->nomor_dokumen }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->tanggal->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Supplier</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->nama_supplier }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sumber Dana</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->sumber_dana }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mata Uang</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->mata_uang }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kurs</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($pembayaraninternal->kurs, 2, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Rencana Bayar</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pembayaraninternal->rencana_bayar->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @php
                                $statusClass = [
                                    'completed' => 'text-green-800 bg-green-100',
                                    'processed' => 'text-yellow-800 bg-yellow-100',
                                    'pending' => 'text-gray-800 bg-gray-100'
                                ][$pembayaraninternal->status_bayar] ?? 'text-gray-800 bg-gray-100';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($pembayaraninternal->status_bayar) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Detail Pengajuan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Faktur</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pembayaraninternal->detail_pembayaraninternal as $index => $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($detail->tanggal_dokumen)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->uraian }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($detail->jumlah, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Grand Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($pembayaraninternal->grand_total, 2, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Potongan:</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                    -{{ number_format($pembayaraninternal->potongan_harga, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pembayaraninternal->keterangan_potong }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-bold text-gray-900 text-right">Total Bayar:</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ number_format($pembayaraninternal->total_bayar, 2, ',', '.') }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection