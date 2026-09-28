@extends('layouts.app')

@section('content')

  
        <div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">

            {{-- HEADER --}}
            <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Metadata Dokumen Legal</h2>
            <p class="mt-1 text-sm text-gray-500">Sistem metadata untuk upload semua dokumen legal</p>
        </div>

        <a href="{{ route('dokumen-legal.create') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah Dokumen
        </a>
    </div>
            
             {{-- FILTER --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
        <form action="{{ route('dokumen-legal.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">


            {{-- Search --}}
            <input type="text" name="search"
                value="{{ request('search') }}"
                placeholder="Cari tipe/perihal..."
                class="border rounded-md px-3 py-2 text-sm">

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                Filter
            </button>
        </form>
    </div>
    
      <div class="bg-white shadow rounded-lg p-6">

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table  class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="ppx-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($dokumenLegals as $index => $dokumen)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                {{ $dokumen->bentuk_singkat }}
                            </td>
                             <td class="px-6 py-4 text-sm">
                                {{ $dokumen->nomor }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                            <a href="{{ route('dokumen-legal.preview', $dokumen->id) }}">
                                    {{ mb_strtoupper(strlen($dokumen->judul) > 50
                                        ? substr($dokumen->judul, 0, 50).'...' 
                                        : $dokumen->judul) }}
                                </a>
                            </td>

                            <td class="px-6 py-4 text-sm">
                              @php
                                $warna = match($dokumen->status) {
                                    'berlaku' => 'bg-green-100 text-green-800',
                                    'jadwal pembaharuan' => 'bg-yellow-100 text-yellow-800',
                                    'kadaluarsa' => 'bg-orange-100 text-orange-800',
                                    'putus' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                                @endphp

                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                                {{ strtoupper($dokumen->status) }}
                            </span>
                            </td>
                           

                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('dokumen-legal.edit', $dokumen->id) }}"
                                   class="text-yellow-600 hover:text-yellow-800">
                                    <i class="fas fa-edit"></i>
                                </a>
                                 <a href="{{ route('dokumen-legal.preview', $dokumen->id) }}"
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>

                                <form action="{{ route('dokumen-legal.destroy', $dokumen->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus dokumen ini?')"
                                  class="inline">
                            
                                @csrf
                                @method('DELETE')
                            
                                <button type="submit"
                                     class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                Data dokumen legal belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
  {{-- PAGINATION INFO --}}
        <div class="mt-4 flex justify-between items-center text-sm text-gray-700">
            <span>
                Menampilkan {{ $dokumenLegals->firstItem() ?? 0 }} - {{ $dokumenLegals->lastItem() ?? 0 }}
                dari {{ $dokumenLegals->total() }} data
            </span>

            {{-- Aktifkan jika pakai paginate --}}
            {{ $dokumenLegals->links() }} 
        </div>

        {{-- RESET --}}
        <div class="mt-4">
            <a href="{{ route('dokumen-legal.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium bg-white hover:bg-gray-50">
                <i class="fas fa-filter-circle-xmark mr-2"></i>
                Reset Filter
            </a>
        </div>
        </div>
    </div>
      
@endsection
