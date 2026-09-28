{{-- filepath: resources/views/anggaranhrd/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Pengajuan Anggaran Operasional HRD
                </h2>
            </div>

            <form action="{{ route('anggaranhrd.update', $anggaranhrd->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal_anggaran" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_anggaran" id="tanggal_anggaran"
                                class="form-input @error('tanggal_anggaran') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('tanggal_anggaran', optional($anggaranhrd->tanggal_anggaran) ? \Carbon\Carbon::parse($anggaranhrd->tanggal_anggaran)->format('Y-m-d') : '') }}" required>
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
                                <option value="biasa" {{ old('sifat', $anggaranhrd->sifat) == 'biasa' ? 'selected' : ''}}>Biasa</option>
                                <option value="segera" {{ old('sifat', $anggaranhrd->sifat) == 'segera' ? 'selected' : ''}}>Segera</option>
                                <option value="urgent" {{ old('sifat', $anggaranhrd->sifat) == 'urgent' ? 'selected' : ''}}>Urgent</option>
                            </select>
                            @error('sifat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="diajukan_oleh" class="block text-sm font-medium text-gray-700 mb-1">Diajukan Oleh</label>
                        <div class="mt-1">
                            <input type="text" name="diajukan_oleh" id="diajukan_oleh"
                                class="form-input @error('diajukan_oleh') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('diajukan_oleh', $anggaranhrd->diajukan_oleh) }}">
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
                                value="{{ old('perihal', $anggaranhrd->perihal) }}">
                            @error('perihal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom  --}}
                    
                    <div>
                        <label for="kolom" class="block text-sm font-medium text-gray-700 mb-1">Kolom Tanda Tangan</label>
                        <select name="kolom" id="kolom" 
                            class="form-select">
                            <option value="3kolom" {{ old('kolom', $anggaranhrd->kolom) == '3kolom' ? 'selected' : '' }}>3kolom</option>
                            <option value="5kolom" {{ old('kolom', $anggaranhrd->kolom) == '5kolom' ? 'selected' : '' }}>5kolom</option>
                        </select>
                    </div>
                    <div>
                        <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Lampiran / Waktu Pelaksanaan</label>
                        <div class="mt-1">
                            <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan"
                                class="form-input @error('waktu_pelaksanaan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('waktu_pelaksanaan', $anggaranhrd->waktu_pelaksanaan) }}">
                            @error('waktu_pelaksanaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- series HRD --}}
                    <div>
                        <label for="serieshrd_id" class="block text-sm font-medium text-gray-700 mb-1">Series HRD</label>
                        <select name="serieshrd_id" id="serieshrd_id"
                            class="form-select @error('serieshrd_id') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" 
                            required>
                            <option value="serieshrd_id">-- Pilih Series HRD --</option>
                            @foreach($serieshrds as $serieshrd)
                                <option value="{{ $serieshrd->id }}" {{ old('serieshrd_id') == $serieshrd->id ? 'selected' : '' }}>
                                    {{ $serieshrd->kode_series }} 
                                </option>
                            @endforeach
                        </select>
                        @error('serieshrd_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:220px;">Deskripsi</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:200px;">Keterangan</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:90px;">Qty</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Nominal Satuan (Rp)</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Jumlah (Rp)</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    // gunakan relationship name yang ada di model; adjust jika namanya berbeda
                                    $details = old('detail', $anggaranhrd->detail_anggaranhrd ? $anggaranhrd->detail_anggaranhrd->toArray() : []);
                                @endphp

                                @if(count($details) > 0)
                                    @foreach($details as $i => $detail)
                                    <tr>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="hidden" name="detail[{{ $i }}][id]" value="{{ $detail['id'] ?? '' }}">
                                            <input type="text" name="detail[{{ $i }}][deksripsi]" class="form-input" required value="{{ old("detail.$i.deksripsi", $detail['deksripsi'] ?? '') }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[{{ $i }}][keterangan]" class="form-input" value="{{ old("detail.$i.keterangan", $detail['keterangan'] ?? '') }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[{{ $i }}][qty]" class="form-input text-right qty-input" required value="{{ old("detail.$i.qty", $detail['qty'] ?? 0) }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[{{ $i }}][harga]" class="form-input text-right harga-input" required value="{{ old("detail.$i.harga", $detail['harga'] ?? 0) }}">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[{{ $i }}][jumlah]" class="form-input text-right jumlah-output bg-gray-50" readonly value="{{ old("detail.$i.jumlah", ($detail['qty'] ?? 0) * ($detail['harga'] ?? 0)) }}">
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
                                            <input type="text" name="detail[0][deksripsi]" class="form-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[0][keterangan]" class="form-input">
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[0][qty]" class="form-input text-right qty-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="number" step="0.01" name="detail[0][harga]" class="form-input text-right harga-input" required>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <input type="text" name="detail[0][jumlah]" class="form-input text-right jumlah-output bg-gray-50" readonly>
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
                                class="form-input bg-gray-50 font-semibold text-lg" value="{{ number_format(old('total_harga', $anggaranhrd->total_harga ?? 0), 2, ',', '.') }}">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('anggaranhrd.index') }}"
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
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = {{ max(1, count(old('detail', $anggaranhrd->detail_anggaranhrd ? $anggaranhrd->detail_anggaranhrd->toArray() : []))) }};

    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }

    function calculateJumlah(row) {
        const qtyInput = row.querySelector('.qty-input');
        const hargaInput = row.querySelector('.harga-input');
        const jumlahOutput = row.querySelector('.jumlah-output');

        const qty = parseFloat(qtyInput?.value) || 0;
        const harga = parseFloat(hargaInput?.value) || 0;
        const jumlah = qty * harga;

        if (jumlahOutput) {
            jumlahOutput.value = jumlah ? formatCurrency(jumlah) : '';
        }
        return jumlah;
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#detail_table tbody tr').forEach(row => {
            total += calculateJumlah(row);
        });
        document.getElementById('total_harga').value = formatCurrency(total);
    }

    document.getElementById('add_row').addEventListener('click', function() {
        let tbody = document.querySelector('#detail_table tbody');
        let prototype = tbody.rows[0].cloneNode(true);

        // reset values and rewrite index numbers in names
        Array.from(prototype.querySelectorAll('input')).forEach(function(input) {
            // clear values
            if (input.classList.contains('jumlah-output')) input.value = '';
            else input.value = '';

            let name = input.getAttribute('name');
            if (name) {
                name = name.replace(/\[\d+\]/, '[' + rowCount + ']');
                input.setAttribute('name', name);
            }
        });

        tbody.appendChild(prototype);
        rowCount++;
        calculateTotal();
    });

    document.querySelector('#detail_table').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row') || e.target.closest('.delete-row')) {
            let rows = document.querySelectorAll('#detail_table tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotal();
            }
        }
    });

    document.querySelector('#detail_table').addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input') || e.target.classList.contains('harga-input')) {
            calculateTotal();
        }
    });

    // initial calculation
    calculateTotal();
});
</script>
@endpush
@endsection
