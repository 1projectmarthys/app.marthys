@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Edit Transaksi</h2>
        <form action="{{ route('data-transfer.update', $data_transfer->id_transaksi) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="norek_penerima" class="block text-sm font-medium text-gray-700">Nomor Rekening Penerima</label>
                <input type="text" id="norek_penerima" name="norek_penerima" value="{{ $data_transfer->norek_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                <input type="text" id="nama_penerima" name="nama_penerima" value="{{ $data_transfer->nama_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="alamat_penerima" class="block text-sm font-medium text-gray-700">Alamat Penerima</label>
                <input type="text" id="alamat_penerima" name="alamat_penerima" value="{{ $data_transfer->alamat_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="alamat2_penerima" class="block text-sm font-medium text-gray-700">Alamat 2 Penerima</label>
                <input type="text" id="alamat2_penerima" name="alamat2_penerima" value="{{ $data_transfer->alamat2_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label for="kota_penerima" class="block text-sm font-medium text-gray-700">Kota Penerima</label>
                <input type="text" id="kota_penerima" name="kota_penerima" value="{{ $data_transfer->kota_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="provinsi_penerima" class="block text-sm font-medium text-gray-700">Provinsi Penerima</label>
                <input type="text" id="provinsi_penerima" name="provinsi_penerima" value="{{ $data_transfer->provinsi_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="negara_penerima" class="block text-sm font-medium text-gray-700">Negara Penerima</label>
                <input type="text" id="negara_penerima" name="negara_penerima" value="{{ $data_transfer->negara_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="kodepos_penerima" class="block text-sm font-medium text-gray-700">Kode Pos Penerima</label>
                <input type="text" id="kodepos_penerima" name="kodepos_penerima" value="{{ $data_transfer->kodepos_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="bank_penerima" class="block text-sm font-medium text-gray-700">Bank Penerima</label>
                <input type="text" id="bank_penerima" name="bank_penerima" value="{{ $data_transfer->bank_penerima }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="tujuan_transaksi" class="block text-sm font-medium text-gray-700">Tujuan Transaksi</label>
                <input type="text" id="tujuan_transaksi" name="tujuan_transaksi" value="{{ $data_transfer->tujuan_transaksi }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="sumber_dana" class="block text-sm font-medium text-gray-700">Sumber Dana</label>
                <input type="text" id="sumber_dana" name="sumber_dana" value="{{ $data_transfer->sumber_dana }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
              <div>
                    <label for="mata_uang" class="block text-sm font-medium text-gray-700">Mata Uang</label>
                    <select id="mata_uang" name="mata_uang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="IDR" {{ old('mata_uang', 'USD') == 'IDR' ? 'selected' : '' }}>IDR</option>
                        <option value="USD" {{ old('mata_uang', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('mata_uang', 'USD') == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="CYN" {{ old('mata_uang', 'USD') == 'CYN' ? 'selected' : '' }}>CYN</option>
                    </select>
                </div>
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" value="{{ $data_transfer->jumlah }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" >
            </div>
            <div>
                <label for="provisi" class="block text-sm font-medium text-gray-700">Provisi</label>
                <input type="text" id="provisi" name="provisi" value="{{ $data_transfer->provisi }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
            <div>
                <label for="biaya" class="block text-sm font-medium text-gray-700">Biaya</label>
                <input type="text" id="biaya" name="biaya" value="{{ $data_transfer->biaya }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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