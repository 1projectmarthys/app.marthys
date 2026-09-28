@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 max-w-2xl">
	<div class="mb-6 flex justify-between items-center">
		<h1 class="text-2xl font-bold">Detail Karyawan</h1>
		<a href="{{ route('karyawan.edit', $karyawan) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
	</div>
	<div class="bg-white rounded-lg shadow p-6">
		<div class="mb-4">
			<strong>Nama Lengkap:</strong> {{ $karyawan->nama_lengkap }}
		</div>
		<div class="mb-4">
			<strong>NIK:</strong> {{ $karyawan->nik }}
		</div>
		<div class="mb-4">
			<strong>Email:</strong> {{ $karyawan->email }}
		</div>
		<div class="mb-4">
			<strong>No HP:</strong> {{ $karyawan->no_hp }}
		</div>
		<div class="mb-4">
			<strong>Alamat:</strong> {{ $karyawan->alamat }}
		</div>
		<div class="mb-4">
			<strong>Kartu Keluarga (KK):</strong>
			@if($karyawan->file_kk)
				<a href="{{ asset('storage/'.$karyawan->file_kk) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
			@else
				<span class="text-gray-400">Belum upload</span>
			@endif
		</div>
		<div class="mb-4">
			<strong>KTP:</strong>
			@if($karyawan->file_ktp)
				<a href="{{ asset('storage/'.$karyawan->file_ktp) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
			@else
				<span class="text-gray-400">Belum upload</span>
			@endif
		</div>
		<div class="mb-4">
			<strong>Ijazah:</strong>
			@if($karyawan->file_ijazah)
				<a href="{{ asset('storage/'.$karyawan->file_ijazah) }}" target="_blank" class="text-blue-600 underline">Lihat File</a>
			@else
				<span class="text-gray-400">Belum upload</span>
			@endif
		</div>
		<a href="{{ route('karyawan.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Kembali</a>
	</div>
</div>
@endsection
