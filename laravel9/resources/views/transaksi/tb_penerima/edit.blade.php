@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Edit Data Penerima</h2>
        <form action="{{ route('tb_penerima.update', $tb_penerima->norek_penerima) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="norek_penerima" class="block text-sm font-medium text-gray-700">No Rekening</label>
                <input type="text" name="norek_penerima" id="norek_penerima" value="{{ $tb_penerima->norek_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama_penerima" id="nama_penerima" value="{{ $tb_penerima->nama_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="alamat_penerima" class="block text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" name="alamat_penerima" id="alamat_penerima" value="{{ $tb_penerima->alamat_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="kota_penerima" class="block text-sm font-medium text-gray-700">Kota</label>
                <input type="text" name="kota_penerima" id="kota_penerima" value="{{ $tb_penerima->kota_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="provinsi_penerima" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <input type="text" name="provinsi_penerima" id="provinsi_penerima" value="{{ $tb_penerima->provinsi_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="negara_penerima" class="block text-sm font-medium text-gray-700">Negara</label>
                <input type="text" name="negara_penerima" id="negara_penerima" value="{{ $tb_penerima->negara_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="kodepos_penerima" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                <input type="text" name="kodepos_penerima" id="kodepos_penerima" value="{{ $tb_penerima->kodepos_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="bank_penerima" class="block text-sm font-medium text-gray-700">Bank</label>
                <input type="text" name="bank_penerima" id="bank_penerima" value="{{ $tb_penerima->bank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="abank_penerima" class="block text-sm font-medium text-gray-700">Alamat Bank</label>
                <input type="text" name="abank_penerima" id="abank_penerima" value="{{ $tb_penerima->abank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="abank2_penerima" class="block text-sm font-medium text-gray-700">Alamat Bank 2</label>
                <input type="text" name="abank2_penerima" id="abank2_penerima" value="{{ $tb_penerima->abank2_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="kbank_penerima" class="block text-sm font-medium text-gray-700">Kode Bank</label>
                <input type="text" name="kbank_penerima" id="kbank_penerima" value="{{ $tb_penerima->kbank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="pbank_penerima" class="block text-sm font-medium text-gray-700">Pemilik Bank</label>
                <input type="text" name="pbank_penerima" id="pbank_penerima" value="{{ $tb_penerima->pbank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="nbank_penerima" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                <input type="text" name="nbank_penerima" id="nbank_penerima" value="{{ $tb_penerima->nbank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="kpbank_penerima" class="block text-sm font-medium text-gray-700">Kode Pos Bank</label>
                <input type="text" name="kpbank_penerima" id="kpbank_penerima" value="{{ $tb_penerima->kpbank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div>
                <label for="bank_status" class="block text-sm font-medium text-gray-700">Status Bank</label>
                <input type="text" name="bank_status" id="bank_status" value="{{ $tb_penerima->bank_status }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection