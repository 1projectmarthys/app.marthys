@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Form Internal Transfer
                </h2>
            </div>

            <form action="{{ route('internal-transfer.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- Info umum --}}
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="form-input @error('tanggal') border-red-300 @enderror"
                            value="{{ old('tanggal') }}" required>
                        @error('tanggal')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="rencana_bayar" class="block text-sm font-medium text-gray-700 mb-1">Rencana Bayar</label>
                        <input type="date" name="rencana_bayar" id="rencana_bayar"
                            class="form-input @error('rencana_bayar') border-red-300 @enderror"
                            value="{{ old('rencana_bayar') }}" required>
                        @error('rencana_bayar')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Rekening --}}
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="bg-white rounded-lg shadow-sm p-5">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">Rekening Pengirim</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="dari_bank" class="block text-sm font-medium text-gray-700 mb-1">Dari Bank</label>
                                <input type="text" name="dari_bank" id="dari_bank"
                                    class="form-input @error('dari_bank') border-red-300 @enderror"
                                    value="{{ old('dari_bank') }}" required>
                                @error('dari_bank')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="norek_pengirim" class="block text-sm font-medium text-gray-700 mb-1">No. Rekening</label>
                                <input type="text" name="norek_pengirim" id="norek_pengirim"
                                    class="form-input @error('norek_pengirim') border-red-300 @enderror"
                                    value="{{ old('norek_pengirim') }}" required>
                                @error('norek_pengirim')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="atasnama_pengirim" class="block text-sm font-medium text-gray-700 mb-1">Atas Nama</label>
                                <input type="text" name="atasnama_pengirim" id="atasnama_pengirim"
                                    class="form-input @error('atasnama_pengirim') border-red-300 @enderror"
                                    value="{{ old('atasnama_pengirim') }}" required>
                                @error('atasnama_pengirim')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-5">
                        <h3 class="text-base font-semibold text-gray-800 mb-4">Rekening Penerima</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="ke_bank" class="block text-sm font-medium text-gray-700 mb-1">Ke Bank</label>
                                <input type="text" name="ke_bank" id="ke_bank"
                                    class="form-input @error('ke_bank') border-red-300 @enderror"
                                    value="{{ old('ke_bank') }}" required>
                                @error('ke_bank')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="norek_penerima" class="block text-sm font-medium text-gray-700 mb-1">No. Rekening</label>
                                <input type="text" name="norek_penerima" id="norek_penerima"
                                    class="form-input @error('norek_penerima') border-red-300 @enderror"
                                    value="{{ old('norek_penerima') }}" required>
                                @error('norek_penerima')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="atasnama_penerima" class="block text-sm font-medium text-gray-700 mb-1">Atas Nama</label>
                                <input type="text" name="atasnama_penerima" id="atasnama_penerima"
                                    class="form-input @error('atasnama_penerima') border-red-300 @enderror"
                                    value="{{ old('atasnama_penerima') }}" required>
                                @error('atasnama_penerima')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jumlah & jenis --}}
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="jumlah_transfer" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Transfer (Rp)</label>
                        <input type="number" step="0.01" min="0" name="jumlah_transfer" id="jumlah_transfer"
                            class="form-input text-right @error('jumlah_transfer') border-red-300 @enderror"
                            value="{{ old('jumlah_transfer') }}" required
                            oninput="document.getElementById('terbilang_preview').textContent = terbilangID(this.value);">
                        @error('jumlah_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-2 text-sm text-gray-500 italic" id="terbilang_preview"></p>
                    </div>
                    <div>
                        <label for="jenis_transfer" class="block text-sm font-medium text-gray-700 mb-1">Jenis Transfer</label>
                        <select name="jenis_transfer" id="jenis_transfer"
                            class="form-select @error('jenis_transfer') border-red-300 @enderror" required
                            onchange="document.getElementById('lainnya_wrap').style.display = this.value === 'lainnya' ? 'block' : 'none';">
                            <option value="">-- Pilih Jenis Transfer --</option>
                            @foreach($jenisOptions as $key => $label)
                                <option value="{{ $key }}" {{ old('jenis_transfer') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('jenis_transfer')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

                        <div id="lainnya_wrap" class="mt-3" style="display: {{ old('jenis_transfer') == 'lainnya' ? 'block' : 'none' }};">
                            <label for="jenis_transfer_lainnya" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Lainnya</label>
                            <input type="text" name="jenis_transfer_lainnya" id="jenis_transfer_lainnya"
                                class="form-input @error('jenis_transfer_lainnya') border-red-300 @enderror"
                                value="{{ old('jenis_transfer_lainnya') }}">
                            @error('jenis_transfer_lainnya')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Note --}}
                <div>
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                    <textarea name="note" id="note" rows="2"
                        class="form-textarea @error('note') border-red-300 @enderror"
                        placeholder="Catatan tambahan (opsional)">{{ old('note') }}</textarea>
                    @error('note')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('internal-transfer.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview terbilang di sisi browser (sinkron dengan logika PHP di server)
    function terbilangID(angka) {
        angka = Math.floor(Math.abs(parseFloat(angka) || 0));
        if (angka === 0) return '';
        const huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        function h(n) {
            if (n < 12) return ' ' + huruf[n];
            else if (n < 20) return h(n - 10) + ' belas';
            else if (n < 100) return h(Math.floor(n / 10)) + ' puluh' + h(n % 10);
            else if (n < 200) return ' seratus' + h(n - 100);
            else if (n < 1000) return h(Math.floor(n / 100)) + ' ratus' + h(n % 100);
            else if (n < 2000) return ' seribu' + h(n - 1000);
            else if (n < 1000000) return h(Math.floor(n / 1000)) + ' ribu' + h(n % 1000);
            else if (n < 1000000000) return h(Math.floor(n / 1000000)) + ' juta' + h(n % 1000000);
            else if (n < 1000000000000) return h(Math.floor(n / 1000000000)) + ' miliar' + h(n % 1000000000);
            else return h(Math.floor(n / 1000000000000)) + ' triliun' + h(n % 1000000000000);
        }
        let s = h(angka).replace(/\s+/g, ' ').trim();
        s = s.replace(/\b\w/g, c => c.toUpperCase());
        return 'Terbilang: ' + s + ' Rupiah';
    }
</script>
@endpush
@endsection
