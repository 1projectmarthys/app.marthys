{{-- filepath: c:\laragon\www\laravel9new\resources\views\hrd\anggaranoperasional\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">
            <div class="mb-8 border-b border-gray-200 pb-4 flex items-center justify-between">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Daftar Anggaran Operasional
                </h2>
                <a href="{{ route('anggaranoperasional.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Anggaran
                </a>
            </div>
            @if(session('success'))
                <div class="mb-4 text-green-700 bg-green-100 rounded-lg p-4">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Filter & Search -->
           <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-6">
                {{-- Search by note/nomor dokumen --}}
                <form action="{{ route('anggaranoperasional.index') }}" method="GET" class="relative w-full md:w-64 lg:w-96">
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
                            placeholder="Cari catatan atau nomor dokumen...">
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
                <form action="{{ route('anggaranoperasional.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm">
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
                <form action="{{ route('anggaranoperasional.index') }}" method="GET" class="relative w-full md:w-64 lg:w-72" id="dateFilterForm2">
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
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nomor Dokumen</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Waktu Pelaksanaan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total Anggaran</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($anggaranops as $item)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->nomor_dokumen }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_anggaran)->format('d-m-Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $item->waktu_pelaksanaan }}</td>
                            <td class="px-4 py-3 whitespace-nowrap font-semibold text-green-700">
                                Rp {{ number_format($item->total_anggaran, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex  space-x-2">
                                <a href="{{ route('anggaranoperasional.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('anggaranoperasional.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('anggaranoperasional.print', $item->id) }}"
                                            class="text-gray-600 hover:text-gray-900"
                                            target="_blank"
                                            title="Cetak">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                </a>
                                <form action="{{ route('anggaranoperasional.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
              <!-- Pagination -->
            <div class="mt-4 flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-700">
                        Menampilkan {{ $anggaranops->firstItem() ?? 0 }} - {{ $anggaranops->lastItem() ?? 0 }} dari {{ $anggaranops->total() }} data
                    </span>
                </div>
                <div>
                    {{ $anggaranops->links() }}
                </div>
            </div>
            <div class="mb-4">
                <a href="{{ route('anggaranoperasional.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-filter-circle-xmark mr-2"></i>
                    Reset Filter
                </a>
            </div>
        </div>
    </div>
</div>
@endsection