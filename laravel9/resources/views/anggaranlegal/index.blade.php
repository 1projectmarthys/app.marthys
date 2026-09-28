{{-- filepath: c:\laragon\www\laravel9new\resources\views\permintaanbarang\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Permintaan Anggaran Legal Non Operasional</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua permintaan Anggaran Legal</p>
        </div>
        <a href="{{ route('anggaranlegal.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Permintaan
        </a>
    </div>
{{-- Filter & Search --}}
<div class="grid grid-cols-1 gap-1 sm:grid-cols-2 mb-6">

<form action="{{ route('anggaranlegal.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">

    {{-- Label --}}
    

    {{-- Date Range Picker --}}
    <input type="text" id="dateRangePicker"
        class="border rounded-md px-3 py-2 text-sm"
        placeholder="Pilih rentang tanggal">

    {{-- Hidden backend --}}
    <input type="hidden" name="tanggal_awal" id="tanggal_awal">
    <input type="hidden" name="tanggal_akhir" id="tanggal_akhir">

    {{-- Search --}}
    <input type="text" name="search"
        value="{{ request('search') }}"
        placeholder="Cari nomor/perihal..."
        class="border rounded-md px-3 py-2 text-sm">

    {{-- Button --}}
    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
        Filter
    </button>

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
                        @forelse ($anggaranLegals as $permintaan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><a href="{{ route('anggaranlegal.show', $permintaan) }}">{{ $permintaan->nomor_dokumen }}</a></td>
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
                                        <a href="{{ route('anggaranlegal.show', $permintaan) }}"
                                            class="text-indigo-600 hover:text-indigo-900" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('anggaranlegal.edit', $permintaan) }}"
                                            class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a> 
                                        <a href="{{ route('anggaranlegal.print', $permintaan->id) }}"
                                            class="text-gray-600 hover:text-gray-900"
                                            target="_blank"
                                            title="Cetak">
                                           <i class="fas fa-print"></i>
                                        </a>
                                        <form action="{{ route('anggaranlegal.destroy', $permintaan) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                                 <i class="fas fa-trash"></i>
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
                        Menampilkan {{ $anggaranLegals->firstItem() ?? 0 }} - {{ $anggaranLegals->lastItem() ?? 0 }} dari {{ $anggaranLegals->total() }} data
                    </span>
                </div>
               <div>
                    {{ $anggaranLegals->links() }}
                </div> 
            </div>
            <div class="mb-4">
                <a href="{{ route('anggaranlegal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-filter-circle-xmark mr-2"></i>
                    Reset Filter
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
 flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: [
            "{{ request('tanggal_awal') }}",
            "{{ request('tanggal_akhir') }}"
        ],
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                document.getElementById('tanggal_awal').value = instance.formatDate(selectedDates[0], "Y-m-d");
                document.getElementById('tanggal_akhir').value = instance.formatDate(selectedDates[1], "Y-m-d");
            }
        }
    });

    document.querySelectorAll('.close-alert').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('div.rounded-md').remove();
        });
    });
});
</script>
@endpush

@endsection