@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-gray-100  shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tambah Transaksi</h2>
        <form action="{{ route('data-transfer.store') }}" method="POST" class="space-y-6">
            @csrf
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Penerima</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Pilih Penerima</label>
                    <select id="nama_penerima" name="nama_penerima" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                        <option value="" disabled selected>Pilih Penerima</option>
                        @foreach ($penerima as $item)
                            <option 
                                value="{{ $item->nama_penerima }}" 
                                data-norek="{{ $item->norek_penerima }}"
                                data-alamat="{{ $item->alamat_penerima }}"
                                data-kota="{{ $item->kota_penerima }}"
                                data-provinsi="{{ $item->provinsi_penerima }}"
                                data-negara="{{ $item->negara_penerima }}"
                                data-kodepos="{{ $item->kodepos_penerima }}"
                                data-bank="{{ $item->bank_penerima }}"
                                data-abank="{{ $item->abank_penerima }}"
                                data-abank2="{{ $item->abank2_penerima }}"
                                data-kbank="{{ $item->kbank_penerima }}"
                                data-pbank="{{ $item->pbank_penerima }}"
                                data-nbank="{{ $item->nbank_penerima }}"
                                data-kpbank="{{ $item->kpbank_penerima }}">
                                {{ $item->nama_penerima }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="norek_penerima" class="block text-sm font-medium text-gray-700">Nomor Rekening Penerima</label>
                    <input type="text" id="norek_penerima" name="norek_penerima" placeholder="Masukkan nomor rekening" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="alamat_penerima" class="block text-sm font-medium text-gray-700">Alamat Penerima</label>
                    <input type="text" id="alamat_penerima" name="alamat_penerima" placeholder="Masukkan alamat penerima" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="alamat2_penerima" class="block text-sm font-medium text-gray-700">Alamat 2 Penerima</label>
                    <input type="text" id="alamat2_penerima" name="alamat2_penerima" placeholder="Opsional" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="kota_penerima" class="block text-sm font-medium text-gray-700">Kota Penerima</label>
                    <input type="text" id="kota_penerima" name="kota_penerima" placeholder="Masukkan kota penerima" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="provinsi_penerima" class="block text-sm font-medium text-gray-700">Provinsi Penerima</label>
                    <input type="text" id="provinsi_penerima" name="provinsi_penerima" placeholder="Masukkan provinsi penerima" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="negara_penerima" class="block text-sm font-medium text-gray-700">Negara Penerima</label>
                    <input type="text" id="negara_penerima" name="negara_penerima" placeholder="Masukkan negara penerima" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="kodepos_penerima" class="block text-sm font-medium text-gray-700">Kode Pos Penerima</label>
                    <input type="text" id="kodepos_penerima" name="kodepos_penerima" placeholder="Masukkan kode pos" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Bank Penerima</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label for="bank_penerima" class="block text-sm font-medium text-gray-700">Bank Penerima</label>
                    <input type="text" id="bank_penerima" name="bank_penerima" placeholder="Masukkan nama bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="abank_penerima" class="block text-sm font-medium text-gray-700">Alamat Bank Penerima</label>
                    <input type="text" id="abank_penerima" name="abank_penerima" placeholder="Masukkan alamat bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="abank2_penerima" class="block text-sm font-medium text-gray-700">Alamat 2 Bank Penerima</label>
                    <input type="text" id="abank2_penerima" name="abank2_penerima" placeholder="Opsional" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="kbank_penerima" class="block text-sm font-medium text-gray-700">Kota Bank Penerima</label>
                    <input type="text" id="kbank_penerima" name="kbank_penerima" placeholder="Masukkan kota bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="pbank_penerima" class="block text-sm font-medium text-gray-700">Provinsi Bank Penerima</label>
                    <input type="text" id="pbank_penerima" name="pbank_penerima" placeholder="Masukkan provinsi bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="nbank_penerima" class="block text-sm font-medium text-gray-700">Negara Bank Penerima</label>
                    <input type="text" id="nbank_penerima" name="nbank_penerima" placeholder="Masukkan negara bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="kpbank_penerima" class="block text-sm font-medium text-gray-700">Kode Pos Bank Penerima</label>
                    <input type="text" id="kpbank_penerima" name="kpbank_penerima" placeholder="Masukkan kode pos bank" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Transfer</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
               
                <div>
                    <label for="tujuan_transaksi" class="block text-sm font-medium text-gray-700">Tujuan Transaksi</label>
                    <input type="text" id="tujuan_transaksi" name="tujuan_transaksi" placeholder="Masukkan tujuan transaksi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="berita_transaksi" class="block text-sm font-medium text-gray-700">Berita Transaksi</label>
                    <input type="text" id="berita_transaksi" name="berita_transaksi" placeholder="Masukkan berita transaksi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="sumber_dana" class="block text-sm font-medium text-gray-700">Sumber Dana</label>
                    <input type="text" id="sumber_dana" name="sumber_dana" placeholder="Masukkan sumber dana" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="tunai" class="block text-sm font-medium text-gray-700">Tunai</label>
                    <input type="text" id="tunai" name="tunai" placeholder="Masukkan Tunai" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="tabungan" class="block text-sm font-medium text-gray-700">Tabungan</label>
                    <input type="text" id="tabungan" name="tabungan" placeholder="Cek Tabungan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
                <div>
                    <label for="cek_bca" class="block text-sm font-medium text-gray-700">Cek BCA</label>
                    <input type="text" id="cek_bca" name="cek_bca" placeholder="Cek BCA" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" >
                </div>
              
            </div>
            
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Jumlah Transfer</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="mata_uang" class="block text-sm font-medium text-gray-700">Mata Uang</label>
                    <select id="mata_uang" name="mata_uang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="IDR" {{ old('mata_uang', 'USD') == 'IDR' ? 'selected' : '' }}>IDR</option>
                        <option value="USD" {{ old('mata_uang', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('mata_uang', 'USD') == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="CNY" {{ old('mata_uang', 'USD') == 'CNY' ? 'selected' : '' }}>CNY</option>
                    </select>
                </div>
                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input 
                        type="number" 
                        id="jumlah" 
                        name="jumlah" 
                        step="0.001"
                        placeholder="Masukkan jumlah"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                </div>
                <div>
                    <label for="provisi" class="block text-sm font-medium text-gray-700">Provisi</label>
                    <input type="text" id="provisi" name="provisi" placeholder="Masukkan Provinsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="biaya" class="block text-sm font-medium text-gray-700">Biaya</label>
                    <input type="text" id="biaya" name="biaya" placeholder="Masukkan Biaya" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
<script>
    document.getElementById('nama_penerima').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        document.getElementById('norek_penerima').value = selectedOption.getAttribute('data-norek') || '';
        document.getElementById('alamat_penerima').value = selectedOption.getAttribute('data-alamat') || '';
        document.getElementById('kota_penerima').value = selectedOption.getAttribute('data-kota') || '';
        document.getElementById('provinsi_penerima').value = selectedOption.getAttribute('data-provinsi') || '';
        document.getElementById('negara_penerima').value = selectedOption.getAttribute('data-negara') || '';
        document.getElementById('kodepos_penerima').value = selectedOption.getAttribute('data-kodepos') || '';
        document.getElementById('bank_penerima').value = selectedOption.getAttribute('data-bank') || '';
        document.getElementById('abank_penerima').value = selectedOption.getAttribute('data-abank') || '';
        document.getElementById('abank2_penerima').value = selectedOption.getAttribute('data-abank2') || '';
        document.getElementById('kbank_penerima').value = selectedOption.getAttribute('data-kbank') || '';
        document.getElementById('pbank_penerima').value = selectedOption.getAttribute('data-pbank') || '';
        document.getElementById('nbank_penerima').value = selectedOption.getAttribute('data-nbank') || '';
        document.getElementById('kpbank_penerima').value = selectedOption.getAttribute('data-kpbank') || '';
    });
</script>
@endsection