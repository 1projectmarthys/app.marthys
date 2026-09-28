{{-- filepath: c:\laragon\www\laravel9new\resources\views\permintaanbarang\create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Permintaan Barang
                </h2>
            </div>

            <form action="{{ route('permintaanbarang.store') }}" method="POST" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <label for="tanggal_permintaan" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_permintaan" id="tanggal_permintaan" 
                                class="form-input @error('tanggal_permintaan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('tanggal_permintaan') }}" required>
                            @error('tanggal_permintaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="sifat" class="block text-sm font-medium text-gray-700">Sifat</label>
                        <div class="mt-1">
                            <input type="text" name="sifat" id="sifat" 
                                class="form-input @error('sifat') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('sifat') }}" required>
                            @error('sifat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <div class="mt-1">
                            <input type="text" name="keterangan" id="keterangan" 
                                class="form-input @error('keterangan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('keterangan') }}">
                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status Bayar</label>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Satuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][nama_barang]" class="form-input" required>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" name="detail[0][qty]" class="form-input qty-input" required>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][satuan]" class="form-input" required>
                                    </td>
                                    
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" name="detail[0][harga]" class="form-input harga-input" required>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][jumlah]" class="form-input jumlah-output bg-gray-50" readonly>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][keterangan]" class="form-input">
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Harga</label>
                        <div class="mt-1">
                            <input type="text" id="total_harga" name="total_harga" readonly 
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('permintaanbarang.index') }}" 
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