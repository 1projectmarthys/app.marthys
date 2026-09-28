{{-- filepath: resources/views/permintaanbarang/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Permintaan Anggaran Legal</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua permintaan Anggaran Legal</p>
        </div>

        <a href="{{ route('anggaranlegalop.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Permintaan
        </a>
    </div>

    {{-- FILTER --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
        <form action="{{ route('anggaranlegalop.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">

            {{-- Date Range --}}
            <input type="text" id="dateRangePicker"
                class="border rounded-md px-3 py-2 text-sm"
                placeholder="Pilih rentang tanggal">

            <input type="hidden" name="tanggal_awal" id="tanggal_awal">
            <input type="hidden" name="tanggal_akhir" id="tanggal_akhir">

            {{-- Search --}}
            <input type="text" name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor/perihal..."
                class="border rounded-md px-3 py-2 text-sm">

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                Filter
            </button>
        </form>
    </div>

    {{-- CARD TABLE --}}
    <div class="bg-white shadow rounded-lg p-6">

        {{-- ALERT --}}
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <button type="button" class="close-alert text-green-600 hover:bg-green-100 p-1 rounded">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="permintaanTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sifat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Perihal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($anggaranlegalop as $permintaan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm"  ><a href="{{ route('anggaranlegalop.show', $permintaan) }}">{{ $permintaan->nomor_dokumen }}</a></td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($permintaan->tanggal_anggaran)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $permintaan->sifat }}</td>
                            <td class="px-6 py-4 text-sm">
                                Rp {{ number_format($permintaan->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $permintaan->perihal }}</td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">

                                    {{-- VIEW --}}
                                    <a href="{{ route('anggaranlegalop.show', $permintaan) }}"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('anggaranlegalop.edit', $permintaan) }}"
                                       class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- PRINT --}}
                                    <a href="{{ route('anggaranlegalop.print', $permintaan->id) }}"
                                       target="_blank"
                                       class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('anggaranlegalop.destroy', $permintaan) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Yakin hapus data ini?')"
                                            class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>Tidak ada data permintaan barang</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION INFO --}}
        <div class="mt-4 flex justify-between items-center text-sm text-gray-700">
            <span>
                Menampilkan {{ $anggaranlegalop->firstItem() ?? 0 }} - {{ $anggaranlegalop->lastItem() ?? 0 }}
                dari {{ $anggaranlegalop->total() }} data
            </span>

            {{-- Aktifkan jika pakai paginate --}}
            {{ $anggaranlegalop->links() }} 
        </div>

        {{-- RESET --}}
        <div class="mt-4">
            <a href="{{ route('anggaranlegalop.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium bg-white hover:bg-gray-50">
                <i class="fas fa-filter-circle-xmark mr-2"></i>
                Reset Filter
            </a>
        </div>

    </div>
</div>

{{-- SCRIPTS --}}
@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

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

    document.querySelectorAll('.close-alert').forEach(btn => {
        btn.addEventListener('click', function () {
            this.parentElement.parentElement.remove();
        });
    });

});
</script>
@endpush

@endsection
