@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">
    <!-- Page Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Pengajuan Pembayaran</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua pengajuan pembayaran</p>
        </div>
        <a href="{{ route('pengajuan-pembayaran.create') }}" 
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Pengajuan
        </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="close-alert inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                    <span class="sr-only">Dismiss</span>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
                <form action="{{ route('pengajuan-pembayaran.index') }}" method="GET" class="relative w-full md:w-64 lg:w-96">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-base sm:text-sm"></i>
                        </div>
                        <input type="text" 
                            id="searchInput" 
                            name="supplier"
                            value="{{ request('supplier') }}"
                            class="block w-full pl-10 pr-4 py-2.5 sm:py-2
                                text-base sm:text-sm
                                border border-gray-300 rounded-md
                                placeholder-gray-400
                                focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                transition duration-150 ease-in-out
                                hover:border-gray-400"
                            placeholder="Cari pengajuan..."
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="submit" class="text-gray-400 hover:text-gray-600">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Pass any existing filters -->
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('tanggal_awal'))
                        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    @endif
                    @if(request('tanggal_akhir'))
                        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    @endif
                </form>

                <form action="{{ route('pengajuan-pembayaran.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="statusFilterForm">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-filter text-gray-400 text-base sm:text-sm"></i>
                        </div>
                        <select id="statusFilter"
                            name="status" 
                            class="block w-full pl-10 pr-10 py-2.5 sm:py-2
                                text-base sm:text-sm
                                border border-gray-300 rounded-md
                                bg-white
                                focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                transition duration-150 ease-in-out
                                hover:border-gray-400
                                appearance-none"
                            onchange="document.getElementById('statusFilterForm').submit()">
                            <option value="" {{ !request('status') ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <!-- Pass any existing filters -->
                    @if(request('supplier'))
                        <input type="hidden" name="supplier" value="{{ request('supplier') }}">
                    @endif
                    @if(request('tanggal_awal'))
                        <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                    @endif
                    @if(request('tanggal_akhir'))
                        <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                    @endif
                </form>

                <div class="flex space-x-2">
                    <form action="{{ route('pengajuan-pembayaran.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar text-gray-400 text-base sm:text-sm"></i>
                            </div>
                            <input type="date" 
                                id="tanggal_awal" 
                                name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}"
                                class="block w-full pl-10 pr-4 py-2.5 sm:py-2
                                    text-base sm:text-sm
                                    border border-gray-300 rounded-md
                                    bg-white
                                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                    transition duration-150 ease-in-out
                                    hover:border-gray-400"
                                placeholder="Dari tanggal...">
                        </div>
                        <!-- Pass any existing filters -->
                        @if(request('supplier'))
                            <input type="hidden" name="supplier" value="{{ request('supplier') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('tanggal_akhir'))
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        @endif
                        <button type="submit" class="hidden"></button>
                    </form>

                    <form action="{{ route('pengajuan-pembayaran.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm2">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400 text-base sm:text-sm"></i>
                            </div>
                            <input type="date" 
                                id="tanggal_akhir" 
                                name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                                class="block w-full pl-10 pr-4 py-2.5 sm:py-2
                                    text-base sm:text-sm
                                    border border-gray-300 rounded-md
                                    bg-white
                                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                    transition duration-150 ease-in-out
                                    hover:border-gray-400"
                                placeholder="Sampai tanggal...">
                        </div>
                        <!-- Pass any existing filters -->
                        @if(request('supplier'))
                            <input type="hidden" name="supplier" value="{{ request('supplier') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('tanggal_awal'))
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        @endif
                        <button type="submit" class="hidden"></button>
                    </form> 
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <div class="mb-4 flex items-center">
                    <form action="{{ route('pengajuan-pembayaran.index') }}" method="GET" id="pageSizeForm">
                        <div class="relative inline-flex items-center">
                            <label for="pageSizeSelect" class="text-sm font-medium text-gray-700 mr-3">Tampilkan:</label>
                            <div class="relative">
                                <select id="pageSizeSelect" name="per_page" class="appearance-none bg-white pl-3 pr-10 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 transition-colors duration-200" onchange="document.getElementById('pageSizeForm').submit()">
                                    <option value="10" {{ request('per_page') == '10' || !request('per_page') ? 'selected' : '' }}>10 data</option>
                                    <!--<option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 data</option>-->
                                    <!--<option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 data</option>-->
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 data</option>
                                    <option value="999" {{ request('per_page') == '100' ? 'selected' : '' }}>Semua</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <span class="ml-3 text-sm text-gray-500">per halaman</span>
                        </div>
                        
                        <!-- Pass any existing filters -->
                        @if(request('supplier'))
                            <input type="hidden" name="supplier" value="{{ request('supplier') }}">
                        @endif
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        @if(request('tanggal_awal'))
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        @endif
                        @if(request('tanggal_akhir'))
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        @endif
                    </form>
                </div>
                <table class="min-w-full divide-y divide-gray-200" id="pengajuanTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="id">
                                <div class="flex items-center space-x-1">
                                    <span>No </span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="nomor_dokumen">
                                <div class="flex items-center space-x-1">
                                    <span>No. Dokumen</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="tanggal">
                                <div class="flex items-center space-x-1">
                                    <span>Tanggal</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="nama_supplier">
                                <div class="flex items-center space-x-1">
                                    <span>Supplier</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="total_bayar">
                                <div class="flex items-center space-x-1">
                                    <span>Total</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                          
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="status_bayar">
                                <div class="flex items-center space-x-1">
                                    <span>Status</span>
                                    <i class="fas fa-sort text-gray-400"></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($pengajuans as $pengajuan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pengajuan->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pengajuan->nomor_dokumen }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $pengajuan->tanggal->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0 bg-gray-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">
                                                {{ strtoupper(substr($pengajuan->nama_supplier, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $pengajuan->nama_supplier }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($pengajuan->total_bayar, 0, ',', '.') }}
                                </td>
                             
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{  route('pengajuan-pembayaran.show', [$pengajuan->id] + request()->query()) }}" 
                                        
                                            class="text-indigo-600 hover:text-indigo-900" 
                                            title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('pengajuan-pembayaran.edit', $pengajuan) }}" 
                                            class="text-yellow-600 hover:text-yellow-900"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <a href="{{ route('print.pembayaran', $pengajuan->id) }}"
                                            class="text-gray-600 hover:text-gray-900"
                                            target="_blank"
                                            title="Cetak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>

                                        @if($pengajuan->status_bayar != 'completed')
                                            <button type="button"
                                                class="text-green-600 hover:text-green-900 update-status-btn"
                                                data-id="{{ $pengajuan->id }}"
                                                title="Tandai Selesai">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                            
                                            <form id="update-form-{{ $pengajuan->id }}"
                                                action="{{ route('pengajuan-pembayaran.update-status', $pengajuan) }}"
                                                method="POST" class="hidden">
                                                @csrf
                                            </form>
                                        @endif
{{--                                         
                                        <button type="button"
                                            class="text-red-600 hover:text-red-900 delete-btn"
                                            data-id="{{ $pengajuan->id }}"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        <form id="delete-form-{{ $pengajuan->id }}"
                                            action="{{ route('pengajuan-pembayaran.destroy', $pengajuan) }}"
                                            method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form> --}}
                                    </div>
                                       <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = [
                                            'completed' => 'text-green-800 bg-green-100',
                                            'processed' => 'text-yellow-800 bg-yellow-100',
                                            'pending' => 'text-gray-800 bg-gray-100'
                                        ][$pengajuan->status_bayar] ?? 'text-gray-800 bg-gray-100';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($pengajuan->status_bayar) }}
                                    </span>
                                </td>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 whitespace-nowrap">
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Tidak ada data pengajuan pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center mt-4">
                <p class="text-sm text-gray-700">
                    Menampilkan {{ $pengajuans->firstItem() ?? 0 }} - {{ $pengajuans->lastItem() ?? 0 }} dari {{ $pengajuans->total() }} data
                </p>
                <div class="pagination-links">
                    {{ $pengajuans->links() }}
                </div>
            </div>

            <!-- Clear Filters Button -->
            <div class="mt-4">
                <a href="{{ route('pengajuan-pembayaran.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-filter-circle-xmark mr-2"></i>
                    Reset Filter
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit date filters when changed
    if (document.getElementById('tanggal_awal')) {
        document.getElementById('tanggal_awal').addEventListener('change', function() {
            document.getElementById('dateFilterForm').submit();
        });
    }
    
    if (document.getElementById('tanggal_akhir')) {
        document.getElementById('tanggal_akhir').addEventListener('change', function() {
            document.getElementById('dateFilterForm2').submit();
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
    tooltipTriggerList.forEach(element => {
        if (typeof tippy !== 'undefined') {
            new tippy(element, {
                content: element.getAttribute('title'),
                placement: 'top',
            });
            element.removeAttribute('title');
        }
    });

    const pageSizeSelect = document.getElementById('pageSizeSelect');
    if (pageSizeSelect) {
        // Set initial value from URL or default to 10
        const urlParams = new URLSearchParams(window.location.search);
        pageSizeSelect.value = urlParams.get('per_page') || '10';
        
        pageSizeSelect.addEventListener('change', function() {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('per_page', this.value);
            currentUrl.searchParams.set('page', '1'); // Reset to first page
            window.location.href = currentUrl.toString();
        });
    }

    // Close alert button
    document.querySelectorAll('.close-alert').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('div.rounded-md').remove();
        });
    });

    // Delete button handler
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        });
    });

    // Update status button handler
    document.querySelectorAll('.update-status-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Konfirmasi Status',
                text: 'Apakah Anda yakin ingin menandai pengajuan ini sebagai sudah dibayar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Tandai Selesai',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`update-form-${id}`).submit();
                }
            });
        });
    });

    // Sorting functionality
    const table = document.getElementById('pengajuanTable');
    if (table) {
        // Initialize sort directions for each column
        const sortDirections = {
            'id': null, 
            'nomor_dokumen': null,
            'tanggal': null,
            'nama_supplier': null,
            'total_bayar': null,
            'status_bayar': null
        };
        
        // Add click event listeners to sortable headers
        document.querySelectorAll('th[data-sort]').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-sort');
                
                // Reset all other column icons
                document.querySelectorAll('th[data-sort] i').forEach(icon => {
                    if (icon !== this.querySelector('i')) {
                        icon.className = 'fas fa-sort text-gray-400';
                    }
                });
                
                // Toggle sort direction
                if (sortDirections[column] === null) {
                    sortDirections[column] = true; // ascending
                } else {
                    sortDirections[column] = !sortDirections[column];
                }

                // Update the icon for this column
                const icon = this.querySelector('i');
                if (sortDirections[column] === true) {
                    icon.className = 'fas fa-sort-up text-indigo-600';
                } else {
                    icon.className = 'fas fa-sort-down text-indigo-600';
                }
                
                // Sort the table rows
                sortTableByColumn(table, column, sortDirections[column]);
            });
        });
        
        // Function to sort table
        function sortTableByColumn(table, column, asc) {
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            
            // Skip empty table or tables with "no data" message
            if (rows.length <= 1 && rows[0] && rows[0].querySelector('td[colspan]')) {
                return;
            }
            
            // Function to get cell values for comparison
            const getCellValue = (row, idx) => {
                const cell = row.querySelector(`td:nth-child(${idx + 1})`);
                if (!cell) return '';
                
                let value = cell.textContent.trim();
                
                // Handle numeric values
                if (column === 'id') {
                    return parseInt(value, 10);
                }
                
                // Handle currency values
                if (column === 'total_bayar') {
                    return parseFloat(value.replace(/[^\d.,]/g, '').replace(/\./g, '').replace(',', '.'));
                }
                
                // Handle date values
                if (column === 'tanggal') {
                    const parts = value.split('/');
                    // Convert DD/MM/YYYY to YYYY-MM-DD for proper comparison
                    if (parts.length === 3) {
                        return new Date(parts[2], parts[1] - 1, parts[0]).getTime();
                    }
                }
                
                return value;
            };
            
            // Get the column index
            const headerCells = table.querySelectorAll('th');
            let columnIdx = 0;
            
            for (let i = 0; i < headerCells.length; i++) {
                if (headerCells[i].getAttribute('data-sort') === column) {
                    columnIdx = i;
                    break;
                }
            }
            
            // Sort the rows
            const sortedRows = rows.sort((a, b) => {
                const aValue = getCellValue(a, columnIdx);
                const bValue = getCellValue(b, columnIdx);
                
                return asc 
                    ? (aValue > bValue ? 1 : aValue < bValue ? -1 : 0)
                    : (bValue > aValue ? 1 : bValue < aValue ? -1 : 0);
            });
            
            // Remove existing rows
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
            
            // Add sorted rows
            tbody.append(...sortedRows);
        }
    }
   
});
</script>
@endpush

@push('styles')
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<style>
    /* Tailwind CSS untuk Tippy.js tooltips */
    .tippy-box[data-animation=fade][data-state=hidden] {
        opacity: 0
    }
    [data-tippy-root] {
        max-width: calc(100vw - 10px)
    }
    .tippy-box {
        position: relative;
        background-color: #333;
        color: #fff;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.4;
        white-space: normal;
        outline: 0;
        transition-property: transform,visibility,opacity
    }
    .tippy-box[data-placement^=top]>.tippy-arrow {
        bottom: 0
    }
    .tippy-box[data-placement^=top]>.tippy-arrow:before {
        bottom: -7px;
        left: 0;
        border-width: 8px 8px 0;
        border-top-color: initial;
        transform-origin: center top
    }
</style>
@endpush
@endsection