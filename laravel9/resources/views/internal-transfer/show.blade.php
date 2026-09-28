@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-xl">
        <div class="px-6 py-5 sm:px-8 flex items-center justify-between border-b border-gray-200">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Internal Transfer</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $transfer->nomor_dokumen }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('internal-transfer.print', $transfer->id) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-print mr-2"></i> Cetak
                </a>
                <a href="{{ route('internal-transfer.edit', $transfer->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('internal-transfer.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="px-6 py-6 sm:px-8">
            <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nomor Dokumen</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $transfer->nomor_dokumen }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tanggal</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($transfer->tanggal)->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Rencana Bayar</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($transfer->rencana_bayar)->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Jenis Transfer</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $transfer->jenis_transfer_label }}</dd>
                </div>
            </dl>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mt-8">
                <div class="border border-gray-200 rounded-lg p-5">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Rekening Pengirim</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex"><dt class="w-32 text-gray-500">Dari Bank</dt><dd class="text-gray-900">{{ $transfer->dari_bank }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">No. Rekening</dt><dd class="text-gray-900">{{ $transfer->norek_pengirim }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Atas Nama</dt><dd class="text-gray-900">{{ $transfer->atasnama_pengirim }}</dd></div>
                    </dl>
                </div>
                <div class="border border-gray-200 rounded-lg p-5">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Rekening Penerima</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex"><dt class="w-32 text-gray-500">Ke Bank</dt><dd class="text-gray-900">{{ $transfer->ke_bank }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">No. Rekening</dt><dd class="text-gray-900">{{ $transfer->norek_penerima }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Atas Nama</dt><dd class="text-gray-900">{{ $transfer->atasnama_penerima }}</dd></div>
                    </dl>
                </div>
            </div>

            <div class="mt-8 bg-gray-50 rounded-lg p-5">
                <dl class="grid grid-cols-1 gap-y-3">
                    <div class="flex items-baseline">
                        <dt class="w-40 text-sm font-medium text-gray-500">Jumlah Transfer</dt>
                        <dd class="text-lg font-bold text-gray-900">Rp {{ number_format($transfer->jumlah_transfer, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex items-baseline">
                        <dt class="w-40 text-sm font-medium text-gray-500">Terbilang</dt>
                        <dd class="text-sm italic text-gray-700">{{ $transfer->terbilang }}</dd>
                    </div>
                    <div class="flex items-baseline">
                        <dt class="w-40 text-sm font-medium text-gray-500">Note</dt>
                        <dd class="text-sm text-gray-700" style="white-space: pre-line;">{{ $transfer->note ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
