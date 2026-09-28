{{-- filepath: resources/views/anggaranlegalop/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Pengajuan Anggaran Operasional Legal
                </h2>
            </div>




            <form action="{{ route('anggaranlegalop.update', $anggaranlegalop->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal_anggaran" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_anggaran" id="tanggal_anggaran"
                                class="form-input @error('tanggal_anggaran') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('tanggal_anggaran', optional($anggaranlegalop->tanggal_anggaran) ? \Carbon\Carbon::parse($anggaranlegalop->tanggal_anggaran)->format('Y-m-d') : '') }}" required>
                            @error('tanggal_anggaran')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="sifat" class="block text-sm font-medium text-gray-700 mb-1">Sifat</label>
                        <div class="mt-1">
                            <select name="sifat" id="sifat"
                                class="form-select @error('sifat') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" required>
                                <option value="biasa" {{ old('sifat', $anggaranlegalop->sifat) == 'biasa' ? 'selected' : ''}}>Biasa</option>
                                <option value="segera" {{ old('sifat', $anggaranlegalop->sifat) == 'segera' ? 'selected' : ''}}>Segera</option>
                                <option value="urgent" {{ old('sifat', $anggaranlegalop->sifat) == 'urgent' ? 'selected' : ''}}>Urgent</option>
                            </select>
                            @error('sifat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="diajukan_oleh" class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
                        <div class="mt-1">
                            <input type="text" name="diajukan_oleh" id="diajukan_oleh"
                                class="form-input @error('diajukan_oleh') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('diajukan_oleh', $anggaranlegalop->diajukan_oleh) }}">
                            @error('diajukan_oleh')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="perihal" class="block text-sm font-medium text-gray-700 mb-1">Perihal</label>
                        <div class="mt-1">
                            <input type="text" name="perihal" id="perihal"
                                class="form-input @error('perihal') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('perihal', $anggaranlegalop->perihal) }}">
                            @error('perihal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                        <div class="mt-1">
                            <textarea name="note" id="note" rows="2"
                                class="form-textarea @error('note') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Catatan tambahan (opsional)">{{ old('note', $anggaranlegalop->note) }}</textarea>
                            @error('note')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="diterima" class="block text-sm font-medium text-gray-700 mb-1">Diterima</label>
                        <div class="mt-1">
                            <select name="diterima" id="diterima"
                                class="form-select @error('diterima') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" required>
                                <option value="finance" {{ old('diterima', $anggaranlegalop->diterima) == 'finance' ? 'selected' : ''}}>Finance</option>
                                <option value="accounting" {{ old('diterima', $anggaranlegalop->diterima) == 'accounting' ? 'selected' : ''}}>Accounting</option>
                            </select>
                            @error('diterima')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Lampiran / Waktu Pelaksanaan</label>
                        <div class="mt-1">
                            <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan"
                                class="form-input @error('waktu_pelaksanaan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('waktu_pelaksanaan', $anggaranlegalop->waktu_pelaksanaan) }}">
                            @error('waktu_pelaksanaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- series legal --}}
                    <div>
                        <label for="serieslegal_id" class="block text-sm font-medium text-gray-700 mb-1">Series Legal</label>
                        <select name="serieslegalop_id" id="serieslegalop_id"
                            class="form-select @error('serieslegal_id') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Series Legal --</option>
                            @foreach($serieslegalops as $series)
                                <option value="{{ $series->id }}"{{ old('serieslegalop_id', $anggaranlegalop->serieslegalop_id) == $series->id ? 'selected' : '' }}>
                                    {{ $series->kode_series }} - {{ $series->keterangan ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('serieslegal_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                  <div>
    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
        Lampiran
    </label>

    <div class="mt-1">
        <input type="file"
               name="file"
               id="file"
               class="form-input
                      @error('file')
                          border-red-300 text-red-900
                          placeholder-red-300
                          focus:ring-red-500 focus:border-red-500
                      @enderror">

        @if(!empty($anggaranlegalop->file))
            <p class="text-sm mt-1">
                File saat ini:
                <a href="{{ asset('../storage/'.$anggaranlegalop->file) }}"
                   class="text-blue-600 underline"
                   target="_blank">
                    Lihat
                </a>
            </p>
        @endif

        @error('file')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
                    </div>
                </div>

                {{-- detail table --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Detail Barang</h3>
                        <button type="button" id="add_row"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i> Tambah Baris
                        </button>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200" id="detail_table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:160px;">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:220px;">Deskripsi</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:220px;">Keterangan</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Harga (Rp)</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // gunakan relationship name yang ada di model; adjust jika namanya berbeda
                                    $details = old('detail', $anggaranlegalop->detail_anggaranlegalop ? $anggaranlegalop->detail_anggaranlegalop->toArray() : []);
                                @endphp

                                @if(count($details) > 0)
                                    @foreach($details as $i => $detail)
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="hidden" name="detail[{{ $i }}][id]" value="{{ $detail['id'] ?? '' }}">
                                            <input type="date" name="detail[{{ $i }}][tanggal]" class="form-input" required value="{{ old("detail.$i.tanggal", isset($detail['tanggal']) && $detail['tanggal'] ? \Carbon\Carbon::parse($detail['tanggal'])->format('Y-m-d') : '') }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[{{ $i }}][deksripsi]" class="form-input" required value="{{ old("detail.$i.deksripsi", $detail['deksripsi'] ?? '') }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[{{ $i }}][keterangan]" class="form-input" value="{{ old("detail.$i.keterangan", $detail['keterangan'] ?? '') }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[{{ $i }}][harga]" class="form-input text-right harga-input" required value="{{ old("detail.$i.harga", $detail['harga'] ?? 0) }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <button type="button" class="delete-row inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors" title="Hapus baris">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- default satu baris kosong --}}
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="date" name="detail[0][tanggal]" class="form-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[0][deksripsi]" class="form-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[0][keterangan]" class="form-input w-full">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[0][harga]" class="form-input text-right harga-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <button type="button" class="delete-row inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors" title="Hapus baris">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <div class="w-full sm:w-80 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Total Harga</label>
                        <div class="mt-1">
                            <input type="text" id="total_harga" name="total_harga" readonly
                                class="form-input bg-gray-50 font-semibold text-lg" value="{{ number_format((float) old('total_harga', $anggaranlegalop->total_harga ?? 0), 2, ',', '.') }}">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('anggaranlegalop.index') }}"
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
document.addEventListener('DOMContentLoaded', function () {

    let rowCount = document.querySelectorAll('#detail_table tbody tr').length;

    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }

    function calculateJumlah(row) {
        return parseFloat(row.querySelector('.harga-input')?.value) || 0;
    }

    function calculateTotal() {

        let total = 0;

        document.querySelectorAll('#detail_table tbody tr').forEach(row => {
            total += calculateJumlah(row);
        });

        document.getElementById('total_harga').value =
            formatCurrency(total);
    }

    // =========================
    // TAMBAH BARIS
    // =========================
    document.getElementById('add_row').addEventListener('click', function () {

        let tbody = document.querySelector('#detail_table tbody');

        let html = `
        <tr>
            <td class="px-4 py-3 align-middle">
                <input type="date"
                       name="detail[${rowCount}][tanggal]"
                       class="form-input"
                       required>
            </td>

            <td class="px-4 py-3 align-middle">
                <input type="text"
                       name="detail[${rowCount}][deksripsi]"
                       class="form-input"
                       required>
            </td>

            <td class="px-4 py-3 align-middle">
                <input type="text"
                    name="detail[${rowCount}][keterangan]"
                    class="form-input">
            </td>

            <td class="px-4 py-3 align-middle">
                <input type="number"
                       step="0.01"
                       name="detail[${rowCount}][harga]"
                       class="form-input text-right harga-input"
                       required>
            </td>

            <td class="px-4 py-3 align-middle text-center">
                <button type="button"
                        class="delete-row inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors" title="Hapus baris">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
        `;

        tbody.insertAdjacentHTML('beforeend', html);

        rowCount++;

        calculateTotal();
    });

    // =========================
    // HAPUS BARIS
    // =========================
    document.addEventListener('click', function(e){

        let btn = e.target.closest('.delete-row');

        if(!btn) return;

        let rows = document.querySelectorAll('#detail_table tbody tr');

        if(rows.length <= 1){
            alert('Minimal harus ada 1 baris detail');
            return;
        }

        btn.closest('tr').remove();

        calculateTotal();
    });

    // =========================
    // HITUNG OTOMATIS
    // =========================
    document.addEventListener('input', function(e){

        if(e.target.classList.contains('harga-input')){
            calculateTotal();
        }

    });

    // =========================
    // INITIAL LOAD
    // =========================
    calculateTotal();

});
</script>
@endpush
@endsection
