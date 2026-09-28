{{-- filepath: c:\laragon\www\laravel9new\resources\views\anggaranhrdnoop\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Permintaan Anggaran HRD</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua permintaan Amggaran HRD</p>
        </div>
        <a href="{{ route('anggaranhrdnoop.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Permintaan
        </a>
    </div>
{{-- Filter & Search --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
    {{-- Search by keterangan/nomor dokumen --}}
    <form action="{{ route('anggaranhrdnoop.index') }}" method="GET" class="relative w-full md:w-64 lg:w-96">
        <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400 text-base sm:text-sm"></i>
            </div>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                class="block w-full pl-10 pr-4 py-2.5 sm:py-2
                    text-base sm:text-sm
                    border border-gray-300 rounded-md
                    placeholder-gray-400
                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                    transition duration-150 ease-in-out
                    hover:border-gray-400"
                placeholder="Cari keterangan atau nomor dokumen...">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button type="submit" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>
        @if(request('tanggal_awal'))
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
        @endif
        @if(request('tanggal_akhir'))
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        @endif
    </form>

    {{-- Filter tanggal awal --}}
    <form action="{{ route('anggaranhrdnoop.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm">
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
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('tanggal_akhir'))
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        @endif
        <button type="submit" class="hidden"></button>
    </form>

    {{-- Filter tanggal akhir --}}
    <form action="{{ route('anggaranhrdnoop.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm2">
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
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('tanggal_awal'))
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
        @endif
        <button type="submit" class="hidden"></button>
    </form>
</div>
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
      

            <div class="overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-200" id="permintaanTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                            {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Perihal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($anggaranhrdnoop as $permintaan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $permintaan->nomor_dokumen }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($permintaan->tanggal_anggaran)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $permintaan->sifat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">
                                    Rp {{ number_format($permintaan->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $permintaan->perihal }}
                                </td>
                                {{-- <td class="px-6 py-4 whitespace-nowrap"> --}}
                                    {{-- @php
                                        $statusClass = [
                                            'completed' => 'text-green-800 bg-green-100',
                                            'processed' => 'text-yellow-800 bg-yellow-100',
                                            'pending' => 'text-gray-800 bg-gray-100'
                                        ][$permintaan->status] ?? 'text-gray-800 bg-gray-100';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($permintaan->status) }}
                                    </span> --}}
                                {{-- </td> --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('anggaranhrdnoop.show', $permintaan) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('anggaranhrdnoop.edit', $permintaan) }}"
                                            class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a> 
                                        <a href="{{ route('anggaranhrdnoop.print', $permintaan->id) }}"
                                            class="text-gray-600 hover:text-gray-900"
                                            target="_blank"
                                            title="Cetak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('anggaranhrdnoop.destroy', $permintaan) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 whitespace-nowrap">
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>Tidak ada data permintaan barang</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-700">
                        Menampilkan {{ $anggaranhrdnoop->firstItem() ?? 0 }} - {{ $anggaranhrdnoop->lastItem() ?? 0 }} dari {{ $anggaranhrdnoop->total() }} data
                    </span>
                </div>
                {{-- <div>
                    {{ $anggaranhrdnoops->links() }}
                </div> --}}
            </div>
            <div class="mb-4">
                <a href="{{ route('anggaranhrdnoop.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-filter-circle-xmark mr-2"></i>
                    Reset Filter
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.close-alert').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('div.rounded-md').remove();
        });
    });
});
</script>
@endpush
@endsection