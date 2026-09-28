@extends('layouts.app')

@section('content')
<div class="mx-auto px-4 py-8">
    <div class="bg-gradient-to-br from-gray-100 to-gray-200 shadow-lg rounded-xl">
        <div class="px-8 py-6">

            {{-- HEADER --}}
            <div class="mb-8 border-b border-gray-200 pb-4">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Dokumen Legal
                </h2>
            </div>

            {{-- FORM --}}
            <form action="{{ route('dokumen-legal.store') }}"
                  method="POST"
                 enctype="multipart/form-data"
                  class="space-y-8">
                @csrf
                 <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-1">
                {{-- Pilih Model Dokumen --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Pilih Model Dokumen
                    </label>
            
                    <select name="pilihmodel_dokumen"
                     id="model_dokumen"
                            class="form-input w-full ">
                        <option value="">-- Pilih Model --</option>
                        <option value="model1">Model 1 : PKS, AKTA,SPK,MOU,IL,IB,DE</option>
                        <option value="model2">Model 2 : SUPEN</option>
                        <option value="model3">Model 3 : ISO, CPB</option>
                        <option value="model4">Model 4 : SNI, ASTM</option>
                        <option value="model5">Model 5 : IZIN EDAR</option>
                        <option value="model6">Model 6 : TKDN, BMP</option>
                        <option value="model7">Model 7 : HAKI, LEGALITAS PT, PP RUJUKAN</option>
                    </select>
                </div>
                </div>
                
                <div id="form_dokumen" class="hidden">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
              
                    

                    {{-- Tipe Dokumen --}}
                        <div data-field="tipe_dokumen">
                            <label class="block text-sm font-medium text-gray-700" id="label_tipe_dokumen">
                                Tipe Dokumen
                            </label>
                        
                            <select name="tipe_dokumen"
                                    id="tipe_dokumen"
                                    class="form-input">
                                <option value="">-- Pilih Tipe Dokumen --</option>
                            </select>
                        </div>
                        
                        
                    {{-- Bentuk Singkat --}}
                    <div data-field="bentuk_singkat">
                        <label class="block text-sm font-medium text-gray-700">
                            Bentuk Singkat
                        </label>
                    
                       <input type="text" id="bentuk_singkat" name="bentuk_singkat" readonly>
                    </div>

                    {{-- Judul --}}
                    <div data-field="judul">
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul"
                            class="form-input"
                            value="{{ old('judul') }}">
                    </div>

                    {{-- Nomor --}}
                    <div data-field="nomor">
                        <label class="block text-sm font-medium text-gray-700"id="label_nomor">Nomor Dokumen</label>
                        <input type="text" name="nomor"
                            class="form-input"
                            value="{{ old('nomor') }}">
                    </div>
                    
                      {{-- Nomor --}}
                    <div data-field="nomor_laporan">
                        <label class="block text-sm font-medium text-gray-700"id="label_nomor_laporan">Nomor Laporan</label>
                        <input type="text" name="nomor_laporan"
                            class="form-input"
                            value="{{ old('nomor_laporan') }}">
                    </div>
                    
                     {{-- Nomor --}}
                    <div data-field="keterangan">
                        <label class="block text-sm font-medium text-gray-700"id="label_keterangan">Nilai</label>
                        <input type="text" name="keterangan"
                            class="form-input"
                            value="{{ old('keterangan') }}">
                    </div>

                    {{-- Pembuat --}}
                    <div data-field="direct">
                        <label class="block text-sm font-medium text-gray-700" id="label_direct"></label>
                        <input type="text" name="direct"
                            class="form-input"
                            value="{{ old('direct') }}">
                    </div>
                    
                     {{-- Pihak Kedua/Instansi/Distributor --}}
                    <div data-field="pihak_kedua">
                        <label class="block text-sm font-medium text-gray-700" id="label_pihak_kedua">
                            
                             </label>
                        <input type="text" name="pihak_kedua"
                            class="form-input"
                            value="{{ old('pihak_kedua') }}">
                    </div>
                    
                   
                    {{-- Tahun --}}
                    <div data-field="tahun">
                        <label class="block text-sm font-medium text-gray-700">Tahun</label>
                        <input type="number" name="tahun"
                            class="form-input"
                            value="{{ old('tahun') }}">
                    </div>

                    {{-- Tanggal Ditetapkan --}}
                    <div data-field="tanggal_ditetapkan">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Ditetapkan</label>
                       <input type="date"
                           name="tanggal_ditetapkan"
                           id="tanggal_ditetapkan"
                           class="form-input"
                           value="{{ old('tanggal_ditetapkan') }}">
                    </div>

                    {{-- Tanggal Berakhir --}}
                    <div data-field="tanggal_berakhir">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Berakhir</label>
                       <input type="date"
                               name="tanggal_berakhir"
                               id="tanggal_berakhir"
                               class="form-input"
                               value="{{ old('tanggal_berakhir') }}">
                    </div>

                    {{-- Jangka Waktu --}}
                    <div data-field="jangka_waktu">
                        <label class="block text-sm font-medium text-gray-700">Jangka Waktu</label>
                        <input type="text" name="jangka_waktu"
                            class="form-input"
                            value="{{ old('jangka_waktu') }}">
                    </div>
                       {{-- Merek --}}
                    <div data-field="merek">
                        <label class="block text-sm font-medium text-gray-700">Merek</label>
                        <input type="text" name="merek"
                            class="form-input"
                            value="{{ old('merek') }}">
                    </div>
                    
                     {{-- Lokasi Distribusi --}}
                    <div data-field="lokasi_distribusi">
                        <label class="block text-sm font-medium text-gray-700">Lokasi Distribusi</label>
                        <input type="text" name="lokasi_distribusi"
                            class="form-input"
                            value="{{ old('lokasi_distribusi') }}">
                    </div>

                    {{-- Status --}}
                    <div data-field="status">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                      <input type="text" class="form-input bg-gray-100" value="Otomatis" disabled>
                    </div>

                    {{-- Bidang --}}
                    <div data-field="bidang">
                        <label class="block text-sm font-medium text-gray-700">Bidang</label>
                        <input type="text" name="bidang"
                            class="form-input"
                            value="{{ old('bidang') }}">
                    </div>
                    
                  

        
       
                </div> </div>


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
                                <tr>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                       <input type="file" name="detail[0][file]" class="form-input" required>
                                    </td>
                                   
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <input type="text" name="detail[0][keterangan]" class="form-input">
                                       
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap">
                                        <button type="button" class="text-red-600 hover:text-red-900 delete-row">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
        
                


                {{-- ACTION --}}
                <div class="flex justify-end space-x-4 mt-8 pt-4 border-t border-gray-200">
                    <a href="{{ route('dokumen-legal.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300
                               rounded-lg shadow-sm text-sm font-medium text-gray-700
                               bg-white hover:bg-gray-50">
                        Kembali
                    </a>
                
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent
                               rounded-lg shadow-sm text-sm font-semibold text-white
                               bg-blue-600 hover:bg-blue-700 focus:outline-none
                               focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>


            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===============================
    // ELEMENTS
    // ===============================
    const modelSelect = document.getElementById('model_dokumen');
    const formDokumen = document.getElementById('form_dokumen');
    const fields = document.querySelectorAll('[data-field]');

    const tipeDokumenSelect = document.getElementById('tipe_dokumen');
    const labelTipeDokumen = document.getElementById('label_tipe_dokumen');
    const bentukSingkat = document.getElementById('bentuk_singkat');
    const labelDirect = document.getElementById('label_direct');
    const labelPihakKedua = document.getElementById('label_pihak_kedua');
    const labelNomor = document.getElementById('label_nomor');
    const labelNomorLaporan = document.getElementById('label_nomor_laporan');
    const labelKeterangan = document.getElementById('label_keterangan');

    const tglMulai = document.getElementById('tanggal_ditetapkan');
    const tglAkhir = document.getElementById('tanggal_berakhir');
    const jangkaWaktu = document.querySelector('input[name="jangka_waktu"]');

    const addRowBtn = document.getElementById('add_row');
    const tableBody = document.querySelector('#detail_table tbody');

    // ===============================
    // MAPPING OPTIONS TIPE DOKUMEN
    // ===============================
    const tipeOptions = {
        'model1': [
            { value: 'PKS', text: 'PKS' },
            { value: 'AKTA', text: 'AKTA' },
            { value: 'SPK', text: 'SPK' },
            { value: 'MoU', text: 'MoU' },
            { value: 'Izin Lingkungan', text: 'Izin Lingkungan' },
            { value: 'Izin Bangunan', text: 'Izin Bangunan' },
            { value: 'Dokumen Evaluasi', text: 'Dokumen Evaluasi' }
        ],
        'model2': [
            { value: 'Surat Penunjukan', text: 'Surat Penunjukan' }
        ],
        'model3': [
            { value: 'ISO', text: 'ISO' },
            { value: 'CPB', text: 'CPB' }
        ],
        'model4': [
            { value: 'SNI', text: 'SNI' },
            { value: 'ASTM', text: 'ASTM' }
        ],
        'model5': [
            { value: 'Izin Edar', text: 'Izin Edar' }
        ],
        'model6': [
            { value: 'TKDN', text: 'TKDN' },
            { value: 'BMP', text: 'BMP' }
        ],
        'model7': [
            { value: 'HAKI', text: 'HAKI' },
            { value: 'LEGALITAS PT', text: 'LEGALITAS PT' },
            { value: 'PP Rujukan', text: 'PP Rujukan' }
        ]
    };

    // ===============================
    // MAPPING BENTUK SINGKAT
    // ===============================
    const mappingBentuk = {
        'PKS': 'PKS',
        'AKTA': 'AKTA',
        'SPK': 'SPK',
        'MoU': 'MOU',
        'Izin Lingkungan': 'IL',
        'Izin Bangunan': 'IMB',
        'Dokumen Evaluasi': 'DE',
        'Surat Penunjukan': 'SUPEN',
        'ISO': 'ISO',
        'CPB': 'CPB',
        'SNI': 'SNI',
        'ASTM': 'ASTM',
        'Izin Edar': 'IE',
        'TKDN': 'TKDN',
        'BMP': 'BMP',
        'HAKI': 'HAKI',
        'LEGALITAS PT': 'LEGALITAS PT',
        'PP Rujukan': 'PP Rujukan',
    };

    // ===============================
    // HIDE ALL
    // ===============================
    function hideAllFields() {
        fields.forEach(f => f.classList.add('hidden'));
    }

    function show(list) {
        list.forEach(name => {
            const el = document.querySelector(`[data-field="${name}"]`);
            if (el) el.classList.remove('hidden');
        });
    }

    // INIT
    hideAllFields();
    formDokumen.classList.add('hidden');

    // ===============================
    // MODEL CHANGE
    // ===============================
    modelSelect.addEventListener('change', function () {
        hideAllFields();
        bentukSingkat.value = '';
        tipeDokumenSelect.innerHTML = '<option value="">-- Pilih Tipe Dokumen --</option>';

        if (!this.value) {
            formDokumen.classList.add('hidden');
            return;
        }

        formDokumen.classList.remove('hidden');

        // Set options for tipe_dokumen
        if (tipeOptions[this.value]) {
            tipeOptions[this.value].forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.value;
                option.textContent = opt.text;
                tipeDokumenSelect.appendChild(option);
            });
        }

        // Show fields and set labels based on model
        if (this.value === 'model1') {
            show([
                'tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang'
            ]);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Pihak Kedua/Instansi';
        }

        if (this.value === 'model2') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct','pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','merek','lokasi_distribusi','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Distributor';
        }

        if (this.value === 'model3') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'pihak_kedua','tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pemilik';
            labelPihakKedua.textContent = 'Instansi';
        }
        
        if (this.value === 'model4') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            // pihak_kedua hidden
        }
        
        if (this.value === 'model5') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','keterangan','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
             labelNomor.textContent = 'Nomor AKD';
             labelKeterangan.textContent = 'Keterangan';
          
        }
        
        if (this.value === 'model6') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','nomor_laporan','keterangan','direct',
                'tahun','tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            labelPihakKedua.textContent = 'Pihak Kedua/Instansi';
            labelNomor.textContent = 'Nomor Sertifikat';
            labelKeterangan.textContent = 'Nilai';
            
        }
         if (this.value === 'model7') {
            show(['tipe_dokumen','bentuk_singkat','judul','nomor','direct',
                'tanggal_ditetapkan','tanggal_berakhir',
                'jangka_waktu','status','bidang']);
            labelDirect.textContent = 'Pembuat';
            // pihak_kedua hidden
        }
    });

    // ===============================
    // AUTO BENTUK SINGKAT
    // ===============================
    tipeDokumenSelect.addEventListener('change', function () {
        bentukSingkat.value = mappingBentuk[this.value] ?? '';
    });

    // ===============================
    // AUTO JANGKA WAKTU
    // ===============================
  function hitungJangkaWaktu() {
    if (!tglMulai.value || !tglAkhir.value) {
        jangkaWaktu.value = '';
        return;
    }

    const start = new Date(tglMulai.value);
    const end = new Date(tglAkhir.value);

    let totalBulan = (end.getFullYear() - start.getFullYear()) * 12;
    totalBulan += end.getMonth() - start.getMonth();

    if (end.getDate() < start.getDate()) totalBulan--;
    if (totalBulan < 0) totalBulan = 0;

    // Konversi ke tahun
    let tahun = Math.floor(totalBulan / 12);
    let bulan = totalBulan % 12;

    if (tahun > 0 && bulan > 0) {
        jangkaWaktu.value = tahun + " tahun " + bulan + " bulan";
    } 
    else if (tahun > 0) {
        jangkaWaktu.value = tahun + " tahun";
    } 
    else {
        jangkaWaktu.value = totalBulan + " bulan";
    }
}

    tglMulai.addEventListener('change', hitungJangkaWaktu);
    tglAkhir.addEventListener('change', hitungJangkaWaktu);

    // ===============================
    // ADD ROW FILE
    // ===============================
    let rowCount = tableBody.querySelectorAll('tr').length;

    addRowBtn.addEventListener('click', function () {

        const newRow = tableBody.rows[0].cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';

            if (input.type === 'file') {
                input.name = `detail[${rowCount}][file]`;
            } else {
                input.name = `detail[${rowCount}][keterangan]`;
            }
        });

        tableBody.appendChild(newRow);
        rowCount++;
    });

    // ===============================
    // DELETE ROW
    // ===============================
    tableBody.addEventListener('click', function (e) {
        if (e.target.closest('.delete-row')) {
            if (tableBody.rows.length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });

});


</script>
@endpush




@endsection
