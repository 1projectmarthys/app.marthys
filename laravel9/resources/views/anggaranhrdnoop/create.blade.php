{{-- filepath: c:\laragon\www\laravel9new\resources\views\permintaanbarang\create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Pengajuan Anggaran HRD Non Operasional
                </h2>
            </div>

            <form action="{{ route('anggaranhrdnoop.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal_anggaran" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_anggaran" id="tanggal_anggaran" 
                                class="form-input @error('tanggal_anggaran') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('tanggal_anggaran') }}" required>
                            @error('tanggal_anggaran')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                
                    <div>
                        <label for="sifat" class="block text-sm font-medium text-gray-700 mb-1">Sifat</label>
                        <div class="mt-1">
                            
                            <select name="sifat" id="sifat"
                                class="form-select @error('sifat') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" required
                                >
                                <option value="biasa" {{ old('sifat') == 'biasa' ? 'selected' : ''}} >Biasa</option>
                                <option value="segera" {{ old('sifat') == 'segera' ? 'selected' : ''}} >Segera</option>
                                 <option value="urgent" {{ old('sifat') == 'urgent' ? 'selected' : ''}} >Urgent</option>
                            </select>
                            @error('sifat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                    <label for="kolom" class="block text-sm font-medium text-gray-700 mb-1">Kolom Tanda Tangan</label>
                    <select name="kolom" id="kolom" 
                        class="form-select">
                        <option value="3kolom" {{ old('kolom') == '3kolom' ? 'selected' : '' }}>3kolom</option>
                        <option value="5kolom" {{ old('kolom') == '5kolom' ? 'selected' : '' }}>5kolom</option>
                    </select>
                </div>
                    <div>
                        <label for="diajukan_oleh" class="block text-sm font-medium text-gray-700 mb-1">Diajukan Oleh</label>
                        <div class="mt-1">
                            <input type="text" name="diajukan_oleh" id="diajukan_oleh" 
                                class="form-input @error('diajukan_oleh') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('diajukan_oleh') }}">
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
                                value="{{ old('perihal') }}">
                            @error('perihal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                  
                    <div>
                        <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                        <div class="mt-1">
                            <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan" 
                                class="form-input @error('waktu_pelaksanaan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('waktu_pelaksanaan') }}"required>
                            @error('waktu_pelaksanaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Bayar</label>
                        <select name="status" id="status" 
                            class="form-select @error('status') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" 
                            required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processed" {{ old('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> --}}
                    {{-- series legal --}}
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

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Detail Barang</h3>
                        <button type="button" id="add_row" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baris
                        </button>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200" id="detail_table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:220px;">Deskripsi</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:90px;">Qty</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Nominal Satuan (Rp)</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Jumlah (Rp)</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:200px;">Keterangan</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="text" name="detail[0][deksripsi]" class="form-input" required>
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
                                        <input type="text" name="detail[0][keterangan]" class="form-input">
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <button type="button" class="delete-row inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors" title="Hapus baris">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-end mt-8">
                    <div class="w-full sm:w-80 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Total Harga</label>
                        <div class="mt-1">
                            <input type="text" id="total_harga" name="total_harga" readonly 
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('anggaranhrdnoop.index') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = 1;
    
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }

    function calculateJumlah(row) {
        const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
        const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
        const jumlah = qty * harga;
        row.querySelector('.jumlah-output').value = jumlah ? formatCurrency(jumlah) : '';
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
        let newRow = tbody.rows[0].cloneNode(true);

        // Reset input values and update names
        Array.from(newRow.querySelectorAll('input')).forEach(function(input) {
            if (input.classList.contains('jumlah-output')) {
                input.value = '';
            } else {
                input.value = '';
            }
            let name = input.getAttribute('name');
            name = name.replace(/\[\d+\]/, '[' + rowCount + ']');
            input.setAttribute('name', name);
        });

        tbody.appendChild(newRow);
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

    // Initial calculation
    calculateTotal();
});
</script>
@endpush
@endsection