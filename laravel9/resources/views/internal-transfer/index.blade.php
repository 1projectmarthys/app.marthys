@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Form Internal Transfer</h2>
            <p class="mt-1 text-sm text-gray-500">Kelola semua form internal transfer</p>
        </div>
        <a href="{{ route('internal-transfer.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Transfer
        </a>
    </div>

    @if(session('success'))
        <div class="mt-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg mt-6">
        <div class="p-6">
            <form action="{{ route('internal-transfer.index') }}" method="GET" class="mb-4 flex gap-3 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nomor / atas nama..."
                    class="form-input w-full md:w-80">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nomor Dokumen</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dari &rarr; Ke</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($internaltransfers as $i => $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $internaltransfers->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $row->nomor_dokumen }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $row->dari_bank }} &rarr; {{ $row->ke_bank }}
                                    <div class="text-xs text-gray-400">{{ $row->atasnama_penerima }}</div>
                                </td>
                                <td class="px-4 py-3 text-sm text-right text-gray-900">Rp {{ number_format($row->jumlah_transfer, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <a href="{{ route('internal-transfer.show', $row->id) }}" class="text-blue-600 hover:text-blue-900 mx-1" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('internal-transfer.edit', $row->id) }}" class="text-amber-600 hover:text-amber-900 mx-1" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('internal-transfer.print', $row->id) }}" target="_blank" class="text-gray-600 hover:text-gray-900 mx-1" title="Cetak"><i class="fas fa-print"></i></a>
                                    <form action="{{ route('internal-transfer.destroy', $row->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Hapus form internal transfer ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 mx-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $internaltransfers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
