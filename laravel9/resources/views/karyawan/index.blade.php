@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
	<div class="flex justify-between items-center mb-6">
		<h1 class="text-2xl font-bold">Daftar Karyawan</h1>
		<a href="{{ route('karyawan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Tambah Karyawan</a>
	</div>
	@if(session('success'))
		<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
	@endif
	<div class="overflow-x-auto">
		<table class="min-w-full bg-white border border-gray-200 rounded-lg">
			<thead>
				<tr class="bg-gray-100">
					<th class="py-2 px-4 border-b">No</th>
					<th class="py-2 px-4 border-b">Nama Lengkap</th>
					<th class="py-2 px-4 border-b">NIK</th>
					<th class="py-2 px-4 border-b">Email</th>
					<th class="py-2 px-4 border-b">No HP</th>
					<th class="py-2 px-4 border-b">KK</th>
					<th class="py-2 px-4 border-b">KTP</th>
					<th class="py-2 px-4 border-b">Ijazah</th>
					<th class="py-2 px-4 border-b">Aksi</th>
				</tr>
			</thead>
			<tbody>
				@forelse($karyawans as $karyawan)
				<tr>
					<td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
					<td class="py-2 px-4 border-b">{{ $karyawan->nama_lengkap }}</td>
					<td class="py-2 px-4 border-b">{{ $karyawan->nik }}</td>
					<td class="py-2 px-4 border-b">{{ $karyawan->email }}</td>
					<td class="py-2 px-4 border-b">{{ $karyawan->no_hp }}</td>
					<td class="py-2 px-4 border-b">
						@if($karyawan->file_kk)
						<a href="{{ asset('storage/'.$karyawan->file_kk) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
						@else
						-
						@endif
					</td>
					<td class="py-2 px-4 border-b">
						@if($karyawan->file_ktp)
						<a href="{{ asset('storage/'.$karyawan->file_kk) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
						@else
						-
						@endif
					</td>
					<td class="py-2 px-4 border-b">
						@if($karyawan->file_ijazah)
						<a href="{{ asset('storage/'.$karyawan->file_ijazah) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
						@else
						-
						@endif
					</td>
					<td class="py-2 px-4 border-b flex gap-2">
						<a href="{{ route('karyawan.show', $karyawan) }}" class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">Show</a>
						<a href="{{ route('karyawan.edit', $karyawan) }}" class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="9" class="py-4 text-center text-gray-500">Belum ada data karyawan.</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection
