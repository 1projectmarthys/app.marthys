@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-6 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl h-16 w-16 flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 mb-1">Formulir Data Karyawan</h1>
                    <p class="text-gray-500">Lengkapi informasi dengan teliti dan akurat</p>
                </div>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
               

                <!-- Section: Data Pribadi -->
                <!-- Section: Data Pribadi -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Data Pribadi</h2>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Contoh: Budi Santoso">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_kelamin" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="tempat_lahir" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: Jakarta">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_lahir" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="agama" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: Islam, Kristen, Hindu, Budha">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Pernikahan <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="">Pilih status</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Cerai">Cerai</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Golongan Darah
                                </label>
                                <input type="text" name="golongan_darah"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="A / B / O / AB">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Kontak & Identitas -->
                <div class="p-6 sm:p-8 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Kontak & Identitas</h2>
                    </div>
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nik" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="3174XXXXXXXXXXXX">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    No HP (Aktif) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_hp" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="081234567890">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email (Aktif) <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="nama@email.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap (Sesuai KTP) <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                placeholder="Jl. Melati No. 10 RT 01 RW 02, Kelurahan Mawar"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kecamatan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kecamatan" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Cilandak">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kabupaten/Kota <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kabupaten" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jakarta Selatan">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="provinsi" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="DKI Jakarta">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Pos <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode_pos" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="12345">
                            </div>
                        </div>
                    </div>
                </div>


               <!-- Section: Informasi Tambahan -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Tambahan</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No Rekening BCA
                            </label>
                            <input type="text" name="no_rekening_bca"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="1234567890">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                NPWP
                            </label>
                            <input type="text" name="npwp"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="12.345.678.9-012.345">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ukuran Seragam
                            </label>
                            <input type="text" name="ukuran_seragam"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="S, M, L, XL">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No Kartu Keluarga (KK)
                            </label>
                            <input type="text" name="no_kk"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="3174XXXXXXXXXXXX">
                        </div>
                    </div>
                </div>


               <!-- Section: Data Keluarga -->
                <div class="p-6 sm:p-8 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Data Keluarga</h2>
                    </div>
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap Ayah <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_ayah" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Suyono Bin Slamet">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap Ibu <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_ibu" required
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Siti Aminah">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Istri/Suami
                                </label>
                                <input type="text" name="nama_istri_suami"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jika sudah menikah">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Lahir Istri/Suami
                                </label>
                                <input type="date" name="tgl_lahir_istri_suami"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Anak
                            </label>
                            <input type="number" name="jumlah_anak" min="0"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="0">
                        </div>

                        <!-- Data Anak -->
                        <div class="mt-6 p-5 bg-blue-50 border border-blue-200 rounded-xl">
                            <label class="block text-sm font-semibold text-gray-900 mb-4">Data Anak</label>
                            <div id="anak-container" class="space-y-3"></div>
                            <button type="button" onclick="tambahAnak()"
                                class="mt-4 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                                + Tambah Data Anak
                            </button>
                        </div>
                    </div>
                </div>

               <!-- Section: Kontak Darurat -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-red-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Kontak Darurat</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kontak Darurat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_kontak_darurat" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Siti Aminah">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Hubungan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="hubungan_kontak_darurat" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Ibu Kandung">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                No HP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_hp_kontak_darurat" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="081234567890">
                        </div>
                    </div>
                </div>

                 <!-- Section: Pendidikan -->
                <div class="p-6 sm:p-8 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Riwayat Pendidikan</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pendidikan Terakhir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pendidikan_terakhir" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="SMA, D3, S1, S2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Institusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_institusi" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Universitas Indonesia">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jurusan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="jurusan" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Teknik Informatika">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Lulus <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tahun_lulus" required
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="2022">
                        </div>
                    </div>
                </div>
               
                <!-- Section: Pengalaman Kerja -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Pengalaman Kerja</h2>
                    </div>
                    <div class="p-5 bg-blue-50 border border-blue-200 rounded-xl">
                        <div id="pengalaman-container" class="space-y-4"></div>
                        <button type="button" onclick="tambahPengalaman()"
                            class="mt-4 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                            + Tambah Pengalaman Kerja
                        </button>
                    </div>
                </div>

                <!-- Section: Kesehatan -->
                <div class="p-6 sm:p-8 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-green-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Informasi Kesehatan</h2>
                    </div>
                    
                    <!-- Riwayat Sakit -->
                    <div class="mb-6 p-5 bg-green-50 border border-green-200 rounded-xl">
                        <label class="block text-sm font-semibold text-gray-900 mb-4">Riwayat Sakit</label>
                        <div id="riwayat-container" class="space-y-3"></div>
                        <button type="button" onclick="tambahRiwayat()"
                            class="mt-4 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
                            + Tambah Riwayat Sakit
                        </button>
                    </div>

                    <!-- Detail Kesehatan -->
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Riwayat Penyakit Kronis
                                </label>
                                <select name="riwayat_penyakit_kronis"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Penyakit Kronis
                                </label>
                                <input type="text" name="jenis_penyakit"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jika ada">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pernah Dirawat Inap (2 Tahun Terakhir)
                                </label>
                                <select name="pernah_dirawat_inap"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Alasan Dirawat
                                </label>
                                <input type="text" name="alasan_dirawat_inap"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Alasan">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Dirawat
                            </label>
                            <input type="date" name="tgl_dirawat_inap"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sedang Pengobatan Rutin
                                </label>
                                <select name="sedang_pengobatan_rutin"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Obat & Dosis
                                </label>
                                <input type="text" name="nama_obat_dosis"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jika ada">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Mengalami Cedera Berat
                                </label>
                                <select name="mengalami_cedera_berat"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan Cedera
                                </label>
                                <input type="text" name="cedera_berat_keterangan"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jika ada">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Cedera
                            </label>
                            <input type="date" name="tgl_cedera_berat"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Pernah Operasi Besar
                                </label>
                                <select name="pernah_operasi_besar"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Operasi
                                </label>
                                <input type="text" name="jenis_operasi"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Jika ada">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Operasi
                            </label>
                            <input type="text" name="tahun_operasi"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                placeholder="Contoh: 2020">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tinggi Badan (cm)
                                </label>
                                <input type="number" name="tinggi_badan"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: 170">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Berat Badan (kg)
                                </label>
                                <input type="number" name="berat_badan"
                                    class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: 65">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section: Dokumen -->
                <div class="p-6 sm:p-8 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xl font-bold text-gray-900">Dokumen Pendukung</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kartu Keluarga (KK)
                            </label>
                            <input type="file" name="file_kk" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                KTP
                            </label>
                            <input type="file" name="file_ktp" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ijazah
                            </label>
                            <input type="file" name="file_ijazah" accept=".jpg,.jpeg,.png,.pdf"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>
                <!-- Section: Pesan & Persetujuan -->
                <div class="p-6 sm:p-8 bg-gray-50">
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pesan dan Kesan
                            </label>
                            <textarea name="pesan_kesan" rows="4"
                                class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                                placeholder="Tuliskan pesan dan kesan Anda (opsional)"></textarea>
                        </div>
                        
                        <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <input type="checkbox" name="persetujuan" value="1" required 
                                class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="text-sm text-gray-700 leading-relaxed">
                                Saya menyatakan bahwa data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>. Saya memahami bahwa pemberian informasi yang tidak akurat dapat berakibat pada tindakan administratif.
                            </label>
                        </div>

                        <button type="submit" 
                            class="w-full py-4 px-6 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-base rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Data Karyawan
                        </button>
                    </div>
                </div>

                
            </form>
        </div>
    </div>
</div>

<script>
function tambahAnak() {
    let container = document.getElementById('anak-container');
    let idx = container.children.length;
    let html = `
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-white border border-gray-200 rounded-lg group hover:border-blue-300 transition-colors">
            <input type="text" name="anak[${idx}][nama]" 
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                placeholder="Nama Anak">
            <div class="flex gap-2">
                <input type="date" name="anak[${idx}][tanggal_lahir]" 
                    class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                <button type="button" onclick="hapusBaris(this)" 
                    class="px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors text-sm font-medium" 
                    title="Hapus">
                    ×
                </button>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function tambahPengalaman() {
    let container = document.getElementById('pengalaman-container');
    let idx = container.children.length;
    let html = `
        <div class="p-4 bg-white border border-gray-200 rounded-lg group hover:border-blue-300 transition-colors">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                <input type="text" name="pengalaman[${idx}][nama_pt]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Nama PT">
                <input type="text" name="pengalaman[${idx}][jenis_perusahaan]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Jenis Perusahaan">
                <input type="text" name="pengalaman[${idx}][jabatan_awal]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Jabatan Awal">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                <input type="text" name="pengalaman[${idx}][jabatan_akhir]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Jabatan Akhir">
                <input type="date" name="pengalaman[${idx}][tanggal_awal_kerja]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Tanggal Awal">
                <input type="date" name="pengalaman[${idx}][tanggal_akhir_kerja]" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Tanggal Akhir">
            </div>
            <div class="flex gap-2">
                <input type="text" name="pengalaman[${idx}][alasan_berakhir_kerja]" 
                    class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Alasan Berakhir">
                <button type="button" onclick="hapusBaris(this)" 
                    class="px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors text-sm font-medium" 
                    title="Hapus">
                    ×
                </button>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function tambahRiwayat() {
    let container = document.getElementById('riwayat-container');
    let idx = container.children.length;
    let html = `
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 bg-white border border-gray-200 rounded-lg group hover:border-green-300 transition-colors">
            <input type="text" name="riwayat[${idx}][jenis_penyakit]" 
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                placeholder="Jenis Penyakit">
            <input type="date" name="riwayat[${idx}][tanggal]" 
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
            <div class="flex gap-2">
                <input type="text" name="riwayat[${idx}][keterangan]" 
                    class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm" 
                    placeholder="Keterangan">
                <button type="button" onclick="hapusBaris(this)" 
                    class="px-3 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors text-sm font-medium" 
                    title="Hapus">
                    ×
                </button>
            </div>
        </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function hapusBaris(btn) {
    let row = btn.closest('.group');
    if(row) row.remove();
}
</script>
<style>
.input-tw {
    @apply w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50 transition shadow-sm;
}
</style>
@endsection
