@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Penagihan
                </h2>
            </div>

            <form action="{{ route('masterpenagihan.update', $masterpenagihan->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                        <div class="mt-1">
                            <input type="text" id="nomor_dokumen" name="nomor_dokumen" 
                                class="form-input bg-gray-50 " 
                                value="{{ $masterpenagihan->nomor_dokumen }}" readonly>
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_dokumen" class="block text-sm font-medium text-gray-700">Tanggal Dokumen</label>
                        <div class="mt-1">
                            <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('tanggal_dokumen') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ $masterpenagihan->tanggal_dokumen }}" required>
                            @error('tanggal_dokumen')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="nama_customer" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                        <div class="mt-1">
                            <select id="nama_customer" name="nama_customer" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('nama_customer') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                required>
                                <option value="">Pilih Customer</option>
                                <option value="PT. Darmawangsa Medical Supplies" {{ $masterpenagihan->nama_customer == 'PT. Darmawangsa Medical Supplies' ? 'selected' : '' }}>PT. Darmawangsa Medical Supplies</option>
                                <option value="PT. Avia Dinamika Mandiri" {{ $masterpenagihan->nama_customer == 'PT. Avia Dinamika Mandiri' ? 'selected' : '' }}>PT. Avia Dinamika Mandiri</option>
                                <option value="PT. Trinusa Darma Satha" {{ $masterpenagihan->nama_customer == 'PT. Trinusa Darma Satha' ? 'selected' : '' }}>PT. Trinusa Darma Satha</option>
                                <option value="PT. Syaharani" {{ $masterpenagihan->nama_customer == 'PT. Syaharani' ? 'selected' : '' }}>PT. Syaharani</option>
                                <option value="PT. Karunia Abadi Indonesia" {{ $masterpenagihan->nama_customer == 'PT. Karunia Abadi Indonesia' ? 'selected' : '' }}>PT. Karunia Abadi Indonesia</option>
                                <option value="PT. Multi Axis Surgical" {{ $masterpenagihan->nama_customer == 'PT. Multi Axis Surgical' ? 'selected' : '' }}>PT. Multi Axis Surgical</option>
                            </select>
                            @error('nama_customer')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="alamat_customer" class="block text-sm font-medium text-gray-700">Alamat Customer</label>
                        <div class="mt-1">
                            <select id="alamat_customer" name="alamat_customer" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('alamat_customer') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                required>
                                <option value="">Pilih Alamat</option>
                                <option value="Jl. Comal No.8, Keputran, Kec. Tegalsari" {{ $masterpenagihan->alamat_customer == 'Jl. Comal No.8, Keputran, Kec. Tegalsari' ? 'selected' : '' }}>Jl. Comal No.8, Keputran, Kec. Tegalsari - PT. Darmawangsa Medical Supplies</option>
                                <option value="Jl. Pesona Alam Gunung Anyar S-6 Surabaya" {{ $masterpenagihan->alamat_customer == 'Jl. Pesona Alam Gunung Anyar S-6 Surabaya' ? 'selected' : '' }}>Jl. Pesona Alam Gunung Anyar S-6 Surabaya - PT. Avia Dinamika Mandiri</option>
                                <option value="JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI" {{ $masterpenagihan->alamat_customer == 'JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI' ? 'selected' : '' }}>JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI - PT. Trinusa Darma Satha</option>
                                <option value="Jl. Panjang Jiwo Permai IV No. 33 Surabaya" {{ $masterpenagihan->alamat_customer == 'Jl. Panjang Jiwo Permai IV No. 33, Surabaya' ? 'selected' : '' }}>Jl. Panjang Jiwo Permai IV No. 33 Surabaya - PT. Syaharani</option>
                                <option value="JL. Dukuh Kupang timur VII / 36 Surabaya" {{ $masterpenagihan->alamat_customer == 'JL. Dukuh Kupang timur VII / 36 Surabaya' ? 'selected' : '' }}>JL. Dukuh Kupang timur VII / 36 Surabaya - PT. Karunia Abadi Indonesia</option>
                                <option value="Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya" {{ $masterpenagihan->alamat_customer == 'Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya' ? 'selected' : '' }}>Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya - PT. MULTI AXIS SURGICAL</option>
                            </select>
                            @error('alamat_customer')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="kode_customer" class="block text-sm font-medium text-gray-700">Kode Customer</label>
                        <div class="mt-1">
                            <input type="text" id="kode_customer" name="kode_customer" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('kode_customer') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                value="{{ $masterpenagihan->kode_customer }}" required>
                            @error('kode_customer')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="status_bayar" class="block text-sm font-medium text-gray-700">Status Bayar</label>
                        <div class="mt-1">
                            <select id="status_bayar" name="status_bayar" 
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status_bayar') border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500 @enderror"
                                required>
                                <option value="pending" {{ $masterpenagihan->status_bayar == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $masterpenagihan->status_bayar == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $masterpenagihan->status_bayar == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            @error('status_bayar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="keterangan_lengkap" class="block text-sm font-medium text-gray-700">Keterangan Lengkap</label>
                    <div class="mt-1">
                        <textarea id="keterangan_lengkap" name="keterangan_lengkap" rows="3"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('keterangan_lengkap') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror">{{ $masterpenagihan->keterangan_lengkap }}</textarea>
                        @error('keterangan_lengkap')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detail Table Section -->
                <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Detail Penagihan</h3>
                        <button type="button" id="add_row" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200" id="detail_table" data-row-count="{{ count($masterpenagihan->detail_penagihan) }}">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Faktur</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Faktur Pajak</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($masterpenagihan->detail_penagihan as $index => $detail)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="date" name="detail_penagihan[{{ $index }}][tanggal]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            value="{{ $detail->tanggal }}" required>
                                        <input type="hidden" name="detail_penagihan[{{ $index }}][id]" value="{{ $detail->id }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[{{ $index }}][no_faktur]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            value="{{ $detail->no_faktur }}" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[{{ $index }}][no_faktur_pajak]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            value="{{ $detail->no_faktur_pajak }}" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="number" step="0.01" name="detail_penagihan[{{ $index }}][jumlah]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md jumlah-input"
                                            value="{{ $detail->jumlah }}" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[{{ $index }}][keterangan]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                            value="{{ $detail->keterangan }}">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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

                <!-- Total Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Tagihan</label>
                        <div class="mt-1">
                            <input type="text" id="total_tagihan_display" 
                                class="form-input bg-gray-50 font-semibold text-lg" 
                                value="{{ number_format($masterpenagihan->total_tagihan, 2, ',', '.') }}" readonly>
                            <input type="hidden" id="total_tagihan" name="total_tagihan" value="{{ $masterpenagihan->total_tagihan }}">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('masterpenagihan.index') }}" 
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
    let rowCount = parseInt(document.getElementById('detail_table').dataset.rowCount);

    // Function to format number to currency for display
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }

    // Function to calculate total
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.jumlah-input').forEach(input => {
            total += parseFloat(input.value || 0);
        });
        
        // Update the display value
        document.getElementById('total_tagihan_display').value = formatCurrency(total);
        
        // Set the actual value for submission
        document.getElementById('total_tagihan').value = total;
    }

    // Add new row
    document.getElementById('add_row').addEventListener('click', function() {
        let tbody = document.querySelector('#detail_table tbody');
        let newRow = tbody.insertRow();
        newRow.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="date" name="detail_penagihan[${rowCount}][tanggal]" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="text" name="detail_penagihan[${rowCount}][no_faktur]" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="text" name="detail_penagihan[${rowCount}][no_faktur_pajak]" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="number" step="0.01" name="detail_penagihan[${rowCount}][jumlah]" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md jumlah-input" required>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="text" name="detail_penagihan[${rowCount}][keterangan]" 
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        rowCount++;
        calculateTotal();
    });

    // Delete row
    document.querySelector('#detail_table').addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row') || e.target.closest('.delete-row')) {
            if (document.querySelectorAll('#detail_table tbody tr').length > 1) {
                e.target.closest('tr').remove();
                calculateTotal();
            }
        }
    });

    // Calculate total when input changes
    document.querySelector('#detail_table').addEventListener('input', function(e) {
        if (e.target.classList.contains('jumlah-input')) {
            calculateTotal();
        }
    });

    // Customer data mapping
    const customerData = {
        'PT. Darmawangsa Medical Supplies': {
            address: 'Jl. Comal No.8, Keputran, Kec. Tegalsari',
            code: 'DMS-001'
        },
        'PT. Avia Dinamika Mandiri': {
            address: 'Jl. Pesona Alam Gunung Anyar S-6 Surabaya',
            code: 'ADM-001'
        },
        'PT. Trinusa Darma Satha': {
            address: 'JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI',
            code: 'TDS-001'
        },
        'PT. Syaharani': {
            address: 'Jl. Panjang Jiwo Permai IV No. 33 Surabaya',
            code: 'SYH-001'
        },
        'PT. Karunia Abadi Indonesia': {
            address: 'JL. Dukuh Kupang timur VII / 36 Surabaya',
            code: 'KAI-001'
        },
        'PT. Multi Axis Surgical': {
            address: 'Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya',
            code: 'MAS-001'
        }
    };

    // Update address and code when customer changes
    document.getElementById('nama_customer').addEventListener('change', function() {
        const selectedCustomer = this.value.trim();
        const customerInfo = customerData[selectedCustomer];
        
        if (customerInfo) {
            document.getElementById('alamat_customer').value = customerInfo.address;
            document.getElementById('kode_customer').value = customerInfo.code;
        }
    });

    // Initialize calculations
    calculateTotal();
});
</script>
@endpush
@endsection