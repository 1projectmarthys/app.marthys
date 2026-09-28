@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Preview Dokumen Legal</h2>

                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @php
                        echo match($dokumen->status) {
                            'berlaku' => 'bg-green-100 text-green-800',
                            'jadwal pembaharuan' => 'bg-yellow-100 text-yellow-800',
                            'kadaluarsa' => 'bg-orange-100 text-orange-800',
                            'putus' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                "> {{ strtoupper($dokumen->status) }} </span>
            </div>

            {{-- MODEL DOKUMEN (LOCKED) --}}
            <div class="mb-6">
                <label class="text-sm font-semibold text-gray-700">Model Dokumen</label>
                <select class="form-input w-full bg-gray-100" disabled>
                    <option value="model1" {{ $dokumen->pilihmodel_dokumen=='model1'?'selected':'' }}>Model 1</option>
                    <option value="model2" {{ $dokumen->pilihmodel_dokumen=='model2'?'selected':'' }}>Model 2</option>
                    <option value="model3" {{ $dokumen->pilihmodel_dokumen=='model3'?'selected':'' }}>Model 3</option>
                    <option value="model4" {{ $dokumen->pilihmodel_dokumen=='model4'?'selected':'' }}>Model 4</option>
                    <option value="model5" {{ $dokumen->pilihmodel_dokumen=='model5'?'selected':'' }}>Model 5</option>
                    <option value="model6" {{ $dokumen->pilihmodel_dokumen=='model6'?'selected':'' }}>Model 6</option>
                    <option value="model7" {{ $dokumen->pilihmodel_dokumen=='model7'?'selected':'' }}>Model 7</option>
                </select>
                <p class="text-xs text-red-600">Model dokumen dikunci dan tidak dapat diubah</p>
            </div>

            {{-- METADATA GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8" id="meta_container">

                {{-- INFORMASI DOKUMEN --}}
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Informasi Dokumen</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between" data-field="tipe_dokumen">
                            <dt class="text-gray-500" id="label_tipe_dokumen">Tipe Dokumen</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->tipe_dokumen }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="bentuk_singkat">
                            <dt class="text-gray-500" id="label_bentuk_singkat">Bentuk Singkat</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->bentuk_singkat }}</dd>
                        </div>
                        
                        <div class="flex justify-between" data-field="judul">
                            <dt class="text-gray-500" id="label_judul">Judul</dt>
                            <dd class="font-medium text-gray-800" style="text-align:right">{{ $dokumen->judul }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="nomor">
                            <dt class="text-gray-500" id="label_nomor">Nomor</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->nomor }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="nomor_laporan">
                            <dt class="text-gray-500"id="label_nomor_laporan">Nomor Laporan</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->nomor_laporan }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="keterangan">
                            <dt class="text-gray-500"id="label_keterangan">Keterangan</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->keterangan }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="direct">
                            <dt class="text-gray-500" id="label_direct">Pembuat / Pemilik</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->direct }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="pihak_kedua">
                            <dt class="text-gray-500" id="label_pihak_kedua">Pihak Kedua / Distributor</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->pihak_kedua }}</dd>
                        </div>
                        
                        <div class="flex justify-between" data-field="merek">
                            <dt class="text-gray-500" id="label_merek">Merek</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->merek }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="lokasi_distribusi">
                            <dt class="text-gray-500" id="label_lokasi_distribusi">Lokasi Distribusi</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->lokasi_distribusi }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="bidang">
                            <dt class="text-gray-500" id="label_bidang">Bidang</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->bidang }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- MASA BERLAKU --}}
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Masa Berlaku</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between" data-field="tahun">
                            <dt class="text-gray-500" id="label_tahun">Tahun</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->tahun }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="tanggal_ditetapkan">
                            <dt class="text-gray-500" id="label_tanggal_ditetapkan">Tanggal Ditetapkan</dt>
                            <dd class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($dokumen->tanggal_ditetapkan)->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="tanggal_berakhir">
                            <dt class="text-gray-500" id="label_tanggal_berakhir">Tanggal Berakhir</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->tanggal_berakhir ? \Carbon\Carbon::parse($dokumen->tanggal_berakhir)->format('d M Y') : '-' }}</dd>
                        </div>
                        <div class="flex justify-between" data-field="jangka_waktu">
                            <dt class="text-gray-500" id="label_jangka_waktu">Jangka Waktu</dt>
                            <dd class="font-medium text-gray-800">{{ $dokumen->jangka_waktu }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- FILE PREVIEW TABLE --}}
            <div class="overflow-x-auto bg-white rounded-lg shadow mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dokumen->details as $detail)
                        <tr>
                            <td class="px-6 py-4">
                               @if($detail->file)
                                    <button 
                                        type="button" 
                                        onclick="openPreview('{{ asset('storage/'.$detail->file) }}')" 
                                        class="text-blue-600 underline hover:text-blue-800">
                                        
                                        {{ Str::limit(basename($detail->file), 70, '...') }}
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $detail->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- MODAL PREVIEW --}}
            <div id="fileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-left justify-left">
                <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 h-[100vh] relative">
                    <div class="flex justify-left items-center px-4 py-2 border-b">
                        <h3 class="font-semibold text-gray-700">Preview Dokumen</h3>
                        <button onclick="closePreview()" class="text-gray-500 hover:text-red-600 text-xl">&times;</button>
                    </div>
                    <div class="p-4 h-full">
                        <iframe id="filePreview" src="" class="w-full h-full border rounded"></iframe>
                    </div>
                </div>
            </div>

            {{-- ACTION BUTTON --}}
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('dokumen-legal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Kembali</a>
                <a href="{{ route('dokumen-legal.edit', $dokumen->id) }}" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700">Edit</a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>


// ================= PREVIEW MODAL =================
function openPreview(url) {
    document.getElementById('filePreview').src = url;
    document.getElementById('fileModal').classList.remove('hidden');
}
function closePreview() {
    document.getElementById('filePreview').src = '';
    document.getElementById('fileModal').classList.add('hidden');
}

// ================= DYNAMIC FIELD VIEW BASED ON MODEL =================
document.addEventListener('DOMContentLoaded', function () {
    

    const labelTipeDokumen = document.getElementById('label_tipe_dokumen');
    const labelDirect = document.getElementById('label_direct');
    const labelPihakKedua = document.getElementById('label_pihak_kedua');
    const labelNomor = document.getElementById('label_nomor');
    const labelNomorLaporan = document.getElementById('label_nomor_laporan');
    const labelKeterangan = document.getElementById('label_keterangan');
    const model = "{{ $dokumen->pilihmodel_dokumen }}";
    const fields = document.querySelectorAll('[data-field]');

    function hideAll() { fields.forEach(f => f.classList.add('hidden')); }
    function show(list) {
        list.forEach(name => {
            const el = document.querySelector(`[data-field=\"${name}\"]`);
            if (el) el.classList.remove('hidden');
        });
    }

    hideAll();

    if (model === 'model1') {
            show([
                'tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang'
            ]);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Pihak Kedua/Instansi';
        }

        if (model === 'model2') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct','pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','merek','lokasi_distribusi','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Distributor';
        }

        if (model === 'model3') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pemilik';
            labelPihakKedua.textContent = 'Instansi';
        }
        
        if (model === 'model4') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            // pihak_kedua hidden
        }
        
        if (model === 'model5') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','keterangan','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
             labelNomor.textContent = 'Nomor AKD';
             labelKeterangan.textContent = 'Keterangan';
          
        }
        
        if (model === 'model6') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','nomor_laporan','keterangan','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Pihak Kedua/Instansi';
            labelNomor.textContent = 'Nomor Sertifikat';
            labelKeterangan.textContent = 'Nilai';
            
        }
         if (model === 'model7') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            // pihak_kedua hidden
        }
});
</script>
@endpush