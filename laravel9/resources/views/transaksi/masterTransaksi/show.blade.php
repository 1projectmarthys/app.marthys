@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-gradient-to-br from-white to-gray-100 shadow-lg rounded-lg p-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">Detail Transaksi</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500">ID Transaksi</p>
                <p class="text-lg font-semibold text-gray-900">{{ $data_transfer->id_transaksi }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500">Nomor Rekening Penerima</p>
                <p class="text-lg font-semibold text-gray-900">{{ $data_transfer->norek_penerima }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500">Nama Penerima</p>
                <p class="text-lg font-semibold text-gray-900">{{ $data_transfer->nama_penerima }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <p class="text-sm font-medium text-gray-500">Jumlah</p>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($data_transfer->jumlah, 2, ',', '.') }}</p>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <a href="{{ route('data-transfer.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection