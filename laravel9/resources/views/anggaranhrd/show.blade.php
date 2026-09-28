@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            {{-- Header --}}
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Detail Anggaran HRD
                    </h2>
                </div>
                <a href="{{ route('anggaranhrd.print', $anggaranhrd->id) }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        target="_blank">
                        <i class="fas fa-print mr-2"></i>
                        Cetak
                    </a>
                <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                    <a href="{{ route('anggaranhrd.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md 
                        shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- Informasi Utama --}}
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor Dokumen</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->nomor_dokumen }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Anggaran</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($anggaranhrd->tanggal_anggaran)->translatedFormat('l, d F Y') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Series Legal</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $anggaranhrd->serieshrd->kode_series ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sifat</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->sifat }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Diajukan Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->diajukan_oleh }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Perihal</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->perihal }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Waktu Pelaksanaan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->waktu_pelaksanaan }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Diterima Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $anggaranhrd->diterima }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">
                            Rp {{ number_format($anggaranhrd->total_harga, 0, ',', '.') }}
                        </dd>
                    </div>

                </dl>
            </div>

            {{-- Detail List --}}
            <div class="mb-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Detail Anggaran</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($anggaranhrd->detail_anggaranhrd as $index => $detail)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->deksripsi }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->qty }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->keterangan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                                    Grand Total:
                                </td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                    Rp {{ number_format($anggaranhrd->total_harga, 0, ',', '.') }}
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
