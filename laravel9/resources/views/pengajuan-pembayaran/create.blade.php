@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Pengajuan Pembayaran
                </h2>
            </div>

            <form action="{{ route('pengajuan-pembayaran.store') }}" method="POST" class="space-y-8">
                @csrf
                <div>
                    <label for="tipe_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pembayaran:</label>
                    <select name="tipe_pembayaran" id="tipe_pembayaran" 
                        class="form-select @error('tipe_pembayaran') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                        required>
                        <option value="Form Pengajuan Pembayaran" {{ old('tipe_pembayaran') == 'Form Pengajuan Pembayaran' ? 'selected' : '' }}>FORMULIR PENGAJUAN PEMBAYARAN</option>
                        <option value="Form Internal Transfer" {{ old('tipe_pembayaran') == 'Form Internal Transfer' ? 'selected' : '' }}>FORMULIR PENGAJUAN OPERAN</option>
                    </select>
                    @error('tipe_pembayaran')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal" id="tanggal" 
                                class="form-input @error('tanggal') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="nama_supplier" class="block text-sm font-medium text-gray-700 mb-1">Nama Supplier</label>
                        <div class="mt-1">
                            <input type="text" name="nama_supplier" id="nama_supplier" 
                                class="form-input @error('nama_supplier') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('nama_supplier') }}" required>
                            @error('nama_supplier')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="sumber_dana" class="block text-sm font-medium text-gray-700 mb-1">Sumber Dana</label>
                        <div class="mt-1">
                            <input type="text" name="sumber_dana" id="sumber_dana" 
                                class="form-input @error('sumber_dana') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('sumber_dana') }}" required>
                            @error('sumber_dana')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="mata_uang" class="block text-sm font-medium text-gray-700 mb-1">Mata Uang</label>
                            <select name="mata_uang" id="mata_uang" 
                                class="form-select @error('mata_uang') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" 
                                required>
                                <option value="IDR" {{ old('mata_uang') == 'IDR' ? 'selected' : '' }}>IDR</option>
                                <option value="USD" {{ old('mata_uang') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="CNY" {{ old('mata_uang') == 'CNY' ? 'selected' : '' }}>CNY</option>
                                <option value="EUR" {{ old('mata_uang') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            </select>
                            @error('mata_uang')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kurs" class="block text-sm font-medium text-gray-700 mb-1">Kurs</label>
                            <div class="mt-1">
                                <input type="number" step="0.01" name="kurs" id="kurs" 
                                    class="form-input @error('kurs') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                    value="{{ old('kurs', 1) }}" required>
                                @error('kurs')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="rencana_bayar" class="block text-sm font-medium text-gray-700 mb-1">Rencana Bayar</label>
                        <div class="mt-1">
                            <input type="date" name="rencana_bayar" id="rencana_bayar" 
                                class="form-input @error('rencana_bayar') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                                value="{{ old('rencana_bayar') }}" required>
                            @error('rencana_bayar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Note</label>
                        <div class="mt-1">
                            <textarea name="note" id="note" rows="2"
                                class="form-textarea @error('note') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="Catatan tambahan (opsional)">{{ old('note') }}</textarea>
                            @error('note')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="status_bayar" class="block text-sm font-medium text-gray-700 mb-1">Status Bayar</label>
                        <select name="status_bayar" id="status_bayar" 
                            class="form-select @error('status_bayar') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror" 
                            required>
                            <option value="pending" {{ old('status_bayar') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processed" {{ old('status_bayar') == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="completed" {{ old('status_bayar') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status_bayar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Detail Pengajuan</h3>
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
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:160px;">Tanggal</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:180px;">No Faktur</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:170px;">Jumlah</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="min-width:220px;">Keterangan</th>
                                    <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width:70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="date" name="detail_pengajuan[0][tanggal_dokumen]" 
                                            class="form-input" required>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="text" name="detail_pengajuan[0][uraian]" 
                                            class="form-input" required>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="number" step="0.01" name="detail_pengajuan[0][jumlah]" 
                                            class="form-input text-right jumlah-input" required>
                                    </td>
                                    <td class="px-4 py-3 align-middle">
                                        <input type="text" name="detail_pengajuan[0][keterangan]" 
                                            class="form-input">
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
                  <div>
                 
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                    <div class="mt-1">
                        <input type="text" name="lampiran" id="lampiran" 
                            class="form-input @error('lampiran') border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror" 
                            value="{{ old('lampiran') }}" >
                        @error('lampiran')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="jumlah_kolom" class="block text-sm font-medium text-gray-700 mb-1">Kolom Tanda Tangan</label>
                    <select name="jumlah_kolom" id="jumlah_kolom" 
                        class="form-select">
                        <option value="3kolom" {{ old('jumlah_kolom') == '3kolom' ? 'selected' : '' }}>3kolom</option>
                        <option value="4kolom" {{ old('jumlah_kolom') == '4kolom' ? 'selected' : '' }}>4kolom</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tipe_potong" class="block text-sm font-medium text-gray-700 mb-1">Tipe Potongan</label>
                        <select name="tipe_potong" id="tipe_potong" 
                            class="form-select">
                            <option value="actual" {{ old('tipe_potong') == 'actual' ? 'selected' : '' }}>Actual</option>
                            <option value="on_net_total" {{ old('tipe_potong') == 'on_net_total' ? 'selected' : '' }}>On Net Total</option>
                        </select>
                    </div>

                    <div>
                        <label for="potongan_harga" class="block text-sm font-medium text-gray-700 mb-1">Potongan Harga</label>
                        <div class="mt-1">
                            <input type="number" step="0.01" name="potongan_harga" id="potongan_harga" 
                                class="form-input" 
                                value="{{ old('potongan_harga', 0) }}">
                        </div>
                    </div>
                </div>
                <div>
                    <label for="biaya_admin" class="block text-sm font-medium text-gray-700 mb-1">Biaya Admin</label>
                    <div class="mt-1">
                        <input type="number" step="0.01" name="biaya_admin" id="biaya_admin" 
                            class="form-input" 
                            value="{{ old('biaya_admin', 0) }}">
                    </div>
                </div>
                <div>
                    <label for="keterangan_potong" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Potongan</label>
                    <div class="mt-1">
                        <textarea name="keterangan_potong" id="keterangan_potong" rows="2" 
                            class="form-input">{{ old('keterangan_potong') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <div class="w-full sm:w-80 bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grand Total</label>
                        <div class="mt-1">
                            <input type="text" id="grand_total" readonly 
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Potongan</label>
                        <div class="mt-1">
                            <input type="text" id="total_potongan" readonly 
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Bayar</label>
                        <div class="mt-1">
                            <input type="text" id="total_bayar" readonly 
                                class="form-input bg-gray-50 font-semibold text-lg">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('pengajuan-pembayaran.index') }}" 
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

    // Function to format number to currency
    // function formatCurrency(number) {
    //     return new Intl.NumberFormat('id-ID', {
    //         style: 'currency',
    //         currency: 'IDR',
    //         minimumFractionDigits: 2
    //     }).format(number);
    // }
    function formatCurrencyByType(number, currency) {
    const config = {
        'IDR': { locale: 'id-ID', currency: 'IDR' },
        'USD': { locale: 'en-US', currency: 'USD' },
        'CNY': { locale: 'zh-CN', currency: 'CNY' },
        'EUR': { locale: 'de-DE', currency: 'EUR' },
        'JPY': { locale: 'ja-JP', currency: 'JPY' }
    };
    
    return new Intl.NumberFormat(config[currency].locale, {
        style: 'currency',
        currency: config[currency].currency,
        minimumFractionDigits: 2
    }).format(number);
}
    // Function to calculate total
    function calculateTotals() {
    let total = 0;
    document.querySelectorAll('.jumlah-input').forEach(input => {
        total += parseFloat(input.value || 0);
    });

    const selectedCurrency = document.getElementById('mata_uang').value;
    const kurs = parseFloat(document.getElementById('kurs').value || 1);
    
    // Hitung dalam IDR jika bukan IDR
    const totalInIDR = selectedCurrency === 'IDR' ? total : total * kurs;
    
    const potonganHarga = parseFloat(document.getElementById('potongan_harga').value || 0);
    const tipePotongan = document.getElementById('tipe_potong').value;
    const biayaAdmin = parseFloat(document.getElementById('biaya_admin').value || 0); // Get biaya admin value

    // Hitung potongan dalam IDR
    let potonganValue;
    if (tipePotongan === 'on_net_total') {
        potonganValue = totalInIDR * (potonganHarga / 100);
    } else {
        potonganValue = potonganHarga;
    }

    // Total bayar selalu dalam IDR
    const totalSetelahPotongan = totalInIDR - potonganValue + biayaAdmin;

    // Display grand total in original currency
    document.getElementById('grand_total').value = formatCurrencyByType(total, selectedCurrency);
    
    // Display total_potongan and total_bayar always in IDR
    document.getElementById('total_potongan').value = formatCurrencyByType(potonganValue, 'IDR');
    document.getElementById('total_bayar').value = formatCurrencyByType(totalSetelahPotongan, 'IDR');
    
    // Add hidden input for form submission
    let hiddenTotalBayar = document.getElementById('hidden_total_bayar');
    if (!hiddenTotalBayar) {
        hiddenTotalBayar = document.createElement('input');
        hiddenTotalBayar.type = 'hidden';
        hiddenTotalBayar.name = 'total_bayar';
        hiddenTotalBayar.id = 'hidden_total_bayar';
        document.querySelector('form').appendChild(hiddenTotalBayar);
    }
    hiddenTotalBayar.value = totalSetelahPotongan; // Simpan nilai dalam IDR
}
document.getElementById('biaya_admin').addEventListener('input', calculateTotals);

    // Add new row
    document.getElementById('add_row').addEventListener('click', function() {
        let tbody = document.querySelector('#detail_table tbody');
        let newRow = tbody.insertRow();
        newRow.innerHTML = `
            <td class="px-4 py-3 align-middle">
                <input type="date" name="detail_pengajuan[${rowCount}][tanggal_dokumen]" 
                    class="form-input" required>
            </td>
            <td class="px-4 py-3 align-middle">
                <input type="text" name="detail_pengajuan[${rowCount}][uraian]" 
                    class="form-input" required>
            </td>
            <td class="px-4 py-3 align-middle">
                <input type="number" step="0.01" name="detail_pengajuan[${rowCount}][jumlah]" 
                    class="form-input text-right jumlah-input" required>
            </td>
            <td class="px-4 py-3 align-middle">
                <input type="text" name="detail_pengajuan[${rowCount}][keterangan]" 
                    class="form-input">
            </td>
            <td class="px-4 py-3 align-middle">
                <button type="button" class="delete-row inline-flex items-center justify-center w-8 h-8 rounded-md text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors" title="Hapus baris">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        rowCount++;
        calculateTotals();
    });

    // Delete row
    document.querySelector('#detail_table').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row') || e.target.closest('.delete-row')) {
            if (document.querySelectorAll('#detail_table tbody tr').length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            }
        }
    });

    // Calculate total when input changes
    document.querySelector('#detail_table').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah-input')) {
            calculateTotals();
        }
    });

    // Recalculate when kurs, potongan, or tipe potongan changes
    document.getElementById('kurs').addEventListener('input', calculateTotals);
    document.getElementById('potongan_harga').addEventListener('input', calculateTotals);
    document.getElementById('tipe_potong').addEventListener('change', calculateTotals);

    // Initialize calculations
    calculateTotals();
});
</script>
@endpush
@endsection