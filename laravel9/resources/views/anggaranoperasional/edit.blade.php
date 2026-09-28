@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Anggaran Operasional
                </h2>
            </div>

            <form action="{{ route('anggaranoperasional.update', $anggaranop->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <label for="tanggal_anggaran" class="block text-sm font-medium text-gray-700">Tanggal Anggaran</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal_anggaran" id="tanggal_anggaran"
                                class="form-input @error('tanggal_anggaran') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('tanggal_anggaran', $anggaranop->tanggal_anggaran) }}" required>
                            @error('tanggal_anggaran')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="waktu_pelaksanaan" class="block text-sm font-medium text-gray-700">Waktu Pelaksanaan</label>
                        <div class="mt-1">
                            <input type="text" name="waktu_pelaksanaan" id="waktu_pelaksanaan"
                                class="form-input @error('waktu_pelaksanaan') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('waktu_pelaksanaan', $anggaranop->waktu_pelaksanaan) }}" required>
                            @error('waktu_pelaksanaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <div class="mt-1">
                            <input type="text" name="note" id="note"
                                class="form-input @error('note') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ old('note', $anggaranop->note) }}">
                            @error('note')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="jumlah_kolom" class="block text-sm font-medium text-gray-700">Kolom Tanda Tangan</label>
                        <select name="jumlah_kolom" id="jumlah_kolom"
                            class="form-select">
                            <option value="3kolom" {{ old('jumlah_kolom', $anggaranop->jumlah_kolom) == '3kolom' ? 'selected' : '' }}>3kolom</option>
                            <option value="5kolom" {{ old('jumlah_kolom', $anggaranop->jumlah_kolom) == '5kolom' ? 'selected' : '' }}>5kolom</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Detail Anggaran</h3>
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($anggaranop->detailAnggaranops as $i => $detail)
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="hidden" name="detail[{{ $i }}][id]" value="{{ $detail->id }}">
                                        <input type="text" name="detail[{{ $i }}][keperluan]" class="form-input" value="{{ $detail->keperluan }}" required>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[{{ $i }}][keterangan]" class="form-input" value="{{ $detail->keterangan }}">
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" name="detail[{{ $i }}][jumlah]" class="form-input jumlah-input" value="{{ $detail->jumlah }}" required>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Anggaran</label>
                        <div class="mt-1">
                            <input type="text" id="total_anggaran" name="total_anggaran" readonly
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('anggaranoperasional.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = {{ count($anggaranop->detailAnggaranops) }};
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#detail_table tbody tr').forEach(row => {
            const jumlah = parseFloat(row.querySelector('.jumlah-input').value) || 0;
            total += jumlah;
        });
        document.getElementById('total_anggaran').value = formatCurrency(total);
    }
    document.getElementById('add_row').addEventListener('click', function() {
        let tbody = document.querySelector('#detail_table tbody');
        let newRow = tbody.rows[0].cloneNode(true);
        Array.from(newRow.querySelectorAll('input')).forEach(function(input) {
            if (input.type === 'hidden') {
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
        if (e.target.classList.contains('jumlah-input')) {
            calculateTotal();
        }
    });
    calculateTotal();
});
</script>
@endpush
@endsection
