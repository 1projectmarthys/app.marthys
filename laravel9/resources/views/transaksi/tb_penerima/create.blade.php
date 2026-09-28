@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tambah Data Penerima</h2>
        <form action="{{ route('tb_penerima.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="norek_penerima" class="block text-sm font-medium text-gray-700">No Rekening</label>
                    <input type="text" name="norek_penerima" id="norek_penerima" placeholder="No Rekening" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama_penerima" id="nama_penerima"  placeholder="Nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="alamat_penerima" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input type="text" name="alamat_penerima" id="alamat_penerima"  placeholder="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="kota_penerima" class="block text-sm font-medium text-gray-700">Kota</label>
                    <input type="text" name="kota_penerima" id="kota_penerima"  placeholder="Kota" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="provinsi_penerima" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" name="provinsi_penerima" id="provinsi_penerima"  placeholder="Provinsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="negara_penerima" class="block text-sm font-medium text-gray-700">Negara</label>
                    <input type="text" name="negara_penerima" id="negara_penerima"  placeholder="Negara" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="kodepos_penerima" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                    <input type="text" name="kodepos_penerima" id="kodepos_penerima"  placeholder="Kode Pos" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="bank_penerima" class="block text-sm font-medium text-gray-700">Bank</label>
                    <input type="text" name="bank_penerima" id="bank_penerima"  placeholder="Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="abank_penerima" class="block text-sm font-medium text-gray-700">Alamat Bank</label>
                    <input type="text" name="abank_penerima" id="abank_penerima"  placeholder="Alamat Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="abank2_penerima" class="block text-sm font-medium text-gray-700">Alamat Bank 2</label>
                    <input type="text" name="abank2_penerima" id="abank2_penerima"  placeholder="Alamat Bank 2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="kbank_penerima" class="block text-sm font-medium text-gray-700">Kode Bank</label>
                    <input type="text" name="kbank_penerima" id="kbank_penerima"  placeholder="Kode Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="pbank_penerima" class="block text-sm font-medium text-gray-700">Pemilik Bank</label>
                    <input type="text" name="pbank_penerima" id="pbank_penerima"  placeholder="Pemilik Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="nbank_penerima" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                    <input type="text" name="nbank_penerima" id="nbank_penerima"  placeholder="Nama Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="kpbank_penerima" class="block text-sm font-medium text-gray-700">Kode Pos Bank</label>
                    <input type="text" name="kpbank_penerima" id="kpbank_penerima"  placeholder="Kode Pos Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="bank_status" class="block text-sm font-medium text-gray-700">Status Bank</label>
                    <input type="text" name="bank_status" id="bank_status"  placeholder="Status Bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
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