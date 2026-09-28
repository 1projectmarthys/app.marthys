@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 w-full mx-auto">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">

            {{-- HEADER --}}
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Dokumen Legal
                </h2>
            </div>

            {{-- FORM --}}
            <form action="{{ route('dokumen-legal.update', $dokumen->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-8">
                @csrf
                @method('PUT')
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

                <div id="form_dokumen">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">

                        {{-- Tipe Dokumen --}}
                        <div data-field="tipe_dokumen">
                            <label class="block text-sm font-medium text-gray-700" id="label_tipe_dokumen">Tipe Dokumen</label>
                            <input type="text" name="tipe_dokumen" id="tipe_dokumen" class="form-input" value="{{ $dokumen->tipe_dokumen }}">
                        </div>

                        {{-- Bentuk Singkat --}}
                        <div data-field="bentuk_singkat">
                            <label class="block text-sm font-medium text-gray-700">Bentuk Singkat</label>
                            <input type="text" id="bentuk_singkat" name="bentuk_singkat" class="form-input bg-gray-100" value="{{ $dokumen->bentuk_singkat }}" readonly>
                        </div>

                        {{-- Judul --}}
                        <div data-field="judul">
                            <label class="block text-sm font-medium text-gray-700">Judul</label>
                            <input type="text" name="judul" class="form-input" value="{{ $dokumen->judul }}">
                        </div>

                        {{-- Nomor --}}
                        <div data-field="nomor">
                            <label class="block text-sm font-medium text-gray-700" id="label_nomor">Nomor Dokumen</label>
                            <input type="text" name="nomor" class="form-input" value="{{ $dokumen->nomor }}">
                        </div>

                        {{-- Nomor Laporan --}}
                        <div data-field="nomor_laporan">
                            <label class="block text-sm font-medium text-gray-700" id="label_nomor_laporan">Nomor Laporan</label>
                            <input type="text" name="nomor_laporan" class="form-input" value="{{ $dokumen->nomor_laporan }}">
                        </div>

                        {{-- Keterangan / Nilai --}}
                        <div data-field="keterangan">
                            <label class="block text-sm font-medium text-gray-700" id="label_keterangan">Nilai</label>
                            <input type="text" name="keterangan" class="form-input" value="{{ $dokumen->keterangan }}">
                        </div>

                        {{-- Pembuat / Pemilik --}}
                        <div data-field="direct">
                            <label class="block text-sm font-medium text-gray-700" id="label_direct">Direct</label>
                            <input type="text" name="direct" class="form-input" value="{{ $dokumen->direct }}">
                        </div>

                        {{-- Pihak Kedua --}}
                        <div data-field="pihak_kedua">
                            <label class="block text-sm font-medium text-gray-700" id="label_pihak_kedua">Pihak Kedua</label>
                            <input type="text" name="pihak_kedua" class="form-input" value="{{ $dokumen->pihak_kedua }}">
                        </div>

                        {{-- Tahun --}}
                        <div data-field="tahun">
                            <label class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" name="tahun" class="form-input" value="{{ $dokumen->tahun }}">
                        </div>

                        {{-- Tanggal Ditetapkan --}}
                        <div data-field="tanggal_ditetapkan">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-input" value="{{ $dokumen->tanggal_ditetapkan }}">
                        </div>

                        {{-- Tanggal Berakhir --}}
                        <div data-field="tanggal_berakhir">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-input" value="{{ $dokumen->tanggal_berakhir }}">
                        </div>

                        {{-- Jangka Waktu --}}
                        <div data-field="jangka_waktu">
                            <label class="block text-sm font-medium text-gray-700">Jangka Waktu</label>
                            <input type="text" name="jangka_waktu" class="form-input" value="{{ $dokumen->jangka_waktu }}">
                        </div>

                        {{-- Merek --}}
                        <div data-field="merek">
                            <label class="block text-sm font-medium text-gray-700">Merek</label>
                            <input type="text" name="merek" class="form-input" value="{{ $dokumen->merek }}">
                        </div>

                        {{-- Lokasi Distribusi --}}
                        <div data-field="lokasi_distribusi">
                            <label class="block text-sm font-medium text-gray-700">Lokasi Distribusi</label>
                            <input type="text" name="lokasi_distribusi" class="form-input" value="{{ $dokumen->lokasi_distribusi }}">
                        </div>

                        {{-- Status --}}
                        <div data-field="status">
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <input type="text" class="form-input bg-gray-100" value="{{ $dokumen->status }}" readonly>
                        </div>

                        {{-- Bidang --}}
                        <div data-field="bidang">
                            <label class="block text-sm font-medium text-gray-700">Bidang</label>
                            <input type="text" name="bidang" class="form-input" value="{{ $dokumen->bidang }}">
                        </div>

                    </div>
                </div>

              

                  <div class="mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-800">Upload File</h3>
                        <button type="button" id="add_row" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Baris
                        </button>
                    </div>
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200" id="detail_table">
                           <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">File</th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-600 uppercase">Keterangan</th>
                                    <th class="px-2 py-3 text-center text-xs font-medium text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach ($dokumen->details as $detail)
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                       <input type="file" name="detail[0][file]" class="form-input" ><br>
                                      @if($detail->file)
    <button 
        type="button" 
        onclick="openPreview('{{ asset('storage/'.$detail->file) }}')" 
        class="text-blue-600 underline hover:text-blue-800">
        
        {{ Str::limit(basename($detail->file), 30, '...') }}
    </button>
@endif
                                    </td>
                                   
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][keterangan]" class="form-input" value="{{ $detail->keterangan }}">
                                       
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap text-center">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-row"name=" hapus_file[]" value="{{ $detail->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-3/4 lg:w-2/3 h-[80vh] flex flex-col">

        <!-- HEADER -->
        <div class="flex justify-between items-center p-3 border-b">
            <h2 class="font-bold text-lg">Preview Dokumen</h2>
            <button onclick="closePreview()" class="text-red-600 text-xl">&times;</button>
        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-2">
            <iframe id="previewFrame" class="w-full h-full border rounded"></iframe>
        </div>

    </div>
</div>
                    </div>
                </div>
                

                {{-- ACTION --}}
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('dokumen-legal.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Kembali</a>

                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>

function openPreview(url){
    document.getElementById('previewFrame').src = url;
    document.getElementById('previewModal').classList.remove('hidden');
    document.getElementById('previewModal').classList.add('flex');
}

function closePreview(){
    document.getElementById('previewFrame').src = "";
    document.getElementById('previewModal').classList.add('hidden');
    document.getElementById('previewModal').classList.remove('flex');
}
document.addEventListener('DOMContentLoaded', function () {

   let tableBody = document.querySelector('#detail_table tbody');
    let addBtn = document.getElementById('add_row');

    // Hitung index awal dari data existing
    let rowIndex = tableBody.querySelectorAll('tr').length;

    // Tambah Baris
    addBtn.addEventListener('click', function () {
        let row = document.createElement('tr');

        row.innerHTML = `
            <td class="px-2 py-4 whitespace-nowrap">
                <input type="file" name="detail[${rowIndex}][file]" class="form-input" required>
            </td>

            <td class="px-2 py-4 whitespace-nowrap">
                <input type="text" name="detail[${rowIndex}][keterangan]" class="form-input">
            </td>

            <td class="px-2 py-4 whitespace-nowrap text-center">
                <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        tableBody.appendChild(row);
        rowIndex++;
    });

    // Hapus Baris (delegation)
    tableBody.addEventListener('click', function (e) {
        if (e.target.closest('.delete-row')) {
            let row = e.target.closest('tr');
            row.remove();
        }
    });


// Preview File Existing
function openPreview(url) {
    window.open(url, '_blank');
}



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

@endsection
