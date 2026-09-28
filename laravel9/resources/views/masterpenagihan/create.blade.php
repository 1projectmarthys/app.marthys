@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Penagihan
                </h2>
            </div>

            <form action="{{ route('masterpenagihan.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- First grid section -->
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div class="mb-4">
                        <label for="nomor_dokumen" class="block text-sm font-medium text-gray-700">Nomor Dokumen</label>
                        <div class="mt-1">
                            <input type="text" id="nomor_dokumen" name="nomor_dokumen" 
                                class="form-input bg-gray-50 block w-full" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_dokumen" class="block text-sm font-medium text-gray-700">Tanggal Dokumen</label>
                        <div class="mt-1">
                            <input type="date" id="tanggal_dokumen" name="tanggal_dokumen" 
                                class="form-input @error('tanggal_dokumen') border-red-300 text-red-900 placeholder-red-300 @enderror " 
                                value="{{ old('tanggal_dokumen') }}" required>
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
                                class="form-select @error('nama_customer') border-red-300 text-red-900 @enderror " required>
                                <option value="">Pilih Customer</option>
                                <option value="PT. Darmawangsa Medical Supplies">PT. Darmawangsa Medical Supplies</option>
                                <option value="PT. Avia Dinamika Mandiri">PT. Avia Dinamika Mandiri</option>
                                <option value="PT. Trinusa Darma Satha">PT. Trinusa Darma Satha</option>
                                <option value="PT. Syaharani">PT. Syaharani</option>
                                <option value="PT. Karunia Abadi Indonesia">PT. Karunia Abadi Indonesia</option>
                                <option value="PT. Multi Axis Surgical">PT. Multi Axis Surgical</option>
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
                                class="form-select @error('alamat_customer') border-red-300 text-red-900 @enderror block w-full" required>
                                <option value="">Pilih Alamat</option>
                                <option value="Jl. Comal No.8, Keputran, Kec. Tegalsari">Jl. Comal No.8, Keputran, Kec. Tegalsari - PT. Darmawangsa Medical Supplies</option>
                                <option value="Jl. Pesona Alam Gunung Anyar S-6 Surabaya">Jl. Pesona Alam Gunung Anyar S-6 Surabaya - PT. Avia Dinamika Mandiri</option>
                                <option value="JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI">JL. TUKAD BARITO TIMUR NO. 8, DENPASAR- BALI - PT. Trinusa Darma Satha</option>
                                <option value="Jl. Panjang Jiwo Permai IV No. 33 Surabaya">Jl. Panjang Jiwo Permai IV No. 33 Surabaya - PT. Syaharani</option>
                                <option value="JL. Dukuh Kupang timur VII / 36 Surabaya">JL. Dukuh Kupang timur VII / 36 Surabaya - PT. Karunia Abadi Indonesia</option>
                                <option value="Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya">Jl. Arief Rahman Hakim 138-142 Perumahan Regency 21 Blok E/2 Surabaya - PT. MULTI AXIS SURGICAL</option>
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
                                class="form-input @error('kode_customer') border-red-300 text-red-900 @enderror " required>
                            @error('kode_customer')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="status_bayar" class="block text-sm font-medium text-gray-700">Status Bayar</label>
                        <div class="mt-1">
                            <select id="status_bayar" name="status_bayar" 
                                class="form-select @error('status_bayar') border-red-300 text-red-900 @enderror " required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="canceled">Canceled</option>
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
                            class="form-input @error('keterangan_lengkap') border-red-300 text-red-900 placeholder-red-300 @enderror block w-full">{{ old('keterangan_lengkap') }}</textarea>
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
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baris
                        </button>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200" id="detail_table">
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
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="date" name="detail_penagihan[0][tanggal]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[0][no_faktur]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[0][no_faktur_pajak]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{--  --}}
                                        {{-- <div class="flex items-center space-x-2">
                                            <label for="rupiah" class="flex-shrink-0">Rp.</label>
                                             <input type="number" id="rupiah" step="0.01" name="detail_penagihan[0][jumlah]" 
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md jumlah-input" required>        
                                                
                                        </div>                                    --}}
                                        <div class="flex items-center space-x-2">
                                            <label for="jumlah_display" class="flex-shrink-0">Rp.</label>
                                            <input type="text" id="jumlah_display" 
                                                class="rupiah-format shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" 
                                                required>
                                            <input type="hidden" name="detail_penagihan[0][jumlah]" id="jumlah_asli">
                                        </div>
                                    </td>
                                   
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="text" name="detail_penagihan[0][keterangan]" 
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total Section -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-8">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Tagihan</label>
                        <div class="mt-1">
                            <input type="text" id="total_tagihan" name="total_tagihan" 
                                class="form-input bg-gray-50 font-semibold text-lg" readonly>
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
   
    const displayInput = document.getElementById('jumlah_display');
    const hiddenInput = document.getElementById('jumlah_asli');

 
		/* Fungsi formatRupiah */
	
    // Function to format number to currency
    function formatCurrency(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2
        }).format(number);
    }
    displayInput.addEventListener('input', function () {
        let raw = displayInput.value.replace(/[^,\d]/g, '');
        let formatted = formatRupiah(raw);
        displayInput.value = formatted;

        // Simpan angka asli tanpa titik/koma di hidden input
        hiddenInput.value = raw.replace(/[^0-9]/g, '');
    });

    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        
    }
    // Fungsi untuk mengkonversi format rupiah ke angka
    function parseRupiah(rupiahStr) {
            if (!rupiahStr) return 0;
            return parseInt(rupiahStr.replace(/\./g, '').replace(/[^0-9]/g, '')) || 0;
    }
     // Initialize format rupiah untuk semua input jumlah
     function initRupiahFormat() {
        document.querySelectorAll('.rupiah-format').forEach(function(input) {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/[^\d]/g, '');
                this.value = formatRupiah(value);

                // Simpan nilai asli ke input hidden
                let hiddenInput = this.parentElement.querySelector('#jumlah_asli');
                if (hiddenInput) {
                    hiddenInput.value = parseRupiah(this.value);
                }

                calculateTotal();
            });

            // Initialize jika sudah ada nilai
            if (input.value) {
                input.value = formatRupiah(input.value);
                let hiddenInput = input.parentElement.querySelector('#jumlah_asli');
                if (hiddenInput) {
                    hiddenInput.value = parseRupiah(input.value);
                }
            }
        });
    }
    // Function to calculate total
    // function calculateTotal() {
    //     let total = 0;
    //     document.querySelectorAll('.jumlah-input').forEach(input => {
    //         total += parseFloat(input.value || 0);
    //     });
    //     document.getElementById('total_tagihan').value = formatCurrency(total);
       
    // }
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('#jumlah_asli').forEach(hiddenInput => {
            total += parseInt(hiddenInput.value || '0');
        });
        document.getElementById('total_tagihan').value = formatRupiah(total.toString());
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
                <div class="flex items-center space-x-2">
                    <label for="jumlah_display" class="flex-shrink-0">Rp.</label>
                    <input type="text" id="jumlah_display" 
                        class="rupiah-format shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                    <input type="hidden" name="detail_penagihan[${rowCount}][jumlah]" id="jumlah_asli">
                </div>
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
        initRupiahFormat();
        calculateTotal();
    });

    // <td class="px-6 py-4 whitespace-nowrap">
            //     <input type="number" step="0.01" name="detail_penagihan[${rowCount}][jumlah]" 
            //         class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md jumlah-input" required>
      

            // </td>
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

    // Initialize rupiah format untuk input awal
    initRupiahFormat();

    // Initialize calculations
    calculateTotal();
});
</script>
@endpush
@endsection