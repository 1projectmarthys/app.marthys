<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MetadataDokumenLegal;
use App\Models\DetailMetadataDokumenLegal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MetadataDokumenLegalController extends Controller
{
    /* =======================
     * INDEX
     * ======================= */
  public function index(Request $request)
{
    // Update status dokumen
    $dokumenLegals = MetadataDokumenLegal::all();

    foreach ($dokumenLegals as $dokumen) {
        $statusBaru = $this->hitungStatus($dokumen->tanggal_berakhir);
        if ($dokumen->status !== $statusBaru) {
            $dokumen->update(['status' => $statusBaru]);
        }
    }

    // Query utama
    $query = MetadataDokumenLegal::query();

    // Search filter
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($q) use ($search) {
            $q->where('tipe_dokumen', 'like', "%{$search}%")
              ->orWhere('judul', 'like', "%{$search}%");
        });
    }

    // Pagination + sorting
    $dokumenLegals = $query->orderBy('id', 'desc')
                           ->paginate(10)
                           ->withQueryString();

    return view('dokumen_legal.index', compact('dokumenLegals'));
}
      

    /* =======================
     * CREATE
     * ======================= */
     
    public function create()
    {
        return view('dokumen_legal.create');
    }

    /* =======================
     * STORE
     * ======================= */
public function store(Request $request)
{ 
 
    $request->validate([
        'tipe_dokumen' => 'required',
        
        
        'detail' => 'required|array|min:1',
        'detail.*.file' => 'required|mimes:pdf,doc,docx,png|max:10420',
        'detail.*.keterangan' => 'nullable|string',
    ]);
    
  $bulan = null;

if ($request->tanggal_ditetapkan && $request->tanggal_berakhir) {

    $start = Carbon::parse($request->tanggal_ditetapkan);
    $end   = Carbon::parse($request->tanggal_berakhir);

    $bulan = $start->diffInMonths($end);

    if ($end->day < $start->day) {
        $bulan--;
    }

    if ($bulan < 0) {
        $bulan = 0;
    }
}

DB::transaction(function () use ($request, $bulan) {

    $status = $this->hitungStatus($request->tanggal_berakhir);

    $dokumen = MetadataDokumenLegal::create([
        'pilihmodel_dokumen'   => $request->pilihmodel_dokumen,
    'tipe_dokumen'          => $request->tipe_dokumen,
    'judul'                 => $request->judul,
    'nomor'                 => $request->nomor,
    'nomor_laporan'         => $request->nomor_laporan,
    'keterangan'            => $request->keterangan,
    'direct'                => $request->direct,
    'pihak_kedua'            => $request->pihak_kedua,
    'bentuk_singkat'         => $request->bentuk_singkat,
    'tahun'                 => $request->tahun,
    'tanggal_ditetapkan'    => $request->tanggal_ditetapkan,
    'tanggal_berakhir'      => $request->tanggal_berakhir,
    'jangka_waktu'           => $request->jangka_waktu,
    'bidang'                => $request->bidang,
    'merek'                 => $request->merek,
    'lokasi_distribusi'      => $request->lokasi_distribusi,
    'status'                => $status,
    ]);



        // =====================
        // SIMPAN FILE DETAIL
        // =====================
        $destination = base_path('../storage/dokumen_legal');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        foreach ($request->detail as $item) {

            $file = $item['file'];
            $filename = time().'_'.uniqid().'_'.$file->getClientOriginalName();
            $file->move($destination, $filename);

            $dokumen->details()->create([
                'file' => 'dokumen_legal/'.$filename,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }
    });

    return redirect()
        ->route('dokumen-legal.index')
        ->with('success', 'Dokumen legal berhasil disimpan');
}

    /* =======================
     * PREVIEW
     * ======================= */
    public function preview($id)
    {
        $dokumen = MetadataDokumenLegal::with('details')->findOrFail($id);
        return view('dokumen_legal.preview', compact('dokumen'));
    }

    /* =======================
     * EDIT
     * ======================= */
    public function edit($id)
    {
        $dokumen = MetadataDokumenLegal::with('details')->findOrFail($id);
        return view('dokumen_legal.edit', compact('dokumen'));
    }

    /* =======================
     * UPDATE
     * ======================= */
public function update(Request $request, $id)
{
    $dokumen = MetadataDokumenLegal::with('details')->findOrFail($id);

    $request->validate([
        'tanggal_berakhir' => 'nullable|date|after_or_equal:tanggal_ditetapkan',
        'detail' => 'nullable|array',
        'detail.*.file' => 'nullable|mimes:pdf,doc,docx|max:10420',
        'detail.*.keterangan' => 'nullable|string',
    ]);

    // =====================
    // UPDATE HEADER
    // =====================
    $data = $request->except('detail');
    $data['status'] = $this->hitungStatus($request->tanggal_berakhir);
    $dokumen->update($data);

    if ($request->has('detail')) {

        $destination = base_path('../storage/dokumen_legal');
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        foreach ($request->detail as $index => $item) {

            // AMBIL DETAIL LAMA BERDASARKAN INDEX
            $detail = $dokumen->details[$index] ?? null;

            // =====================
            // UPDATE KETERANGAN
            // =====================
            if ($detail) {
                $detail->update([
                    'keterangan' => $item['keterangan'] ?? $detail->keterangan,
                ]);
            }

            // =====================
            // JIKA ADA FILE BARU
            // =====================
            if (isset($item['file'])) {

                // HAPUS FILE LAMA
                if ($detail && $detail->file) {
                    $oldFile = base_path('../storage/' . $detail->file);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                $file = $item['file'];
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move($destination, $filename);

                if ($detail) {
                    $detail->update([
                        'file' => 'dokumen_legal/' . $filename,
                    ]);
                } else {
                    $dokumen->details()->create([
                        'file' => 'dokumen_legal/' . $filename,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);
                }
            }
        }
    }

    return redirect()
        ->route('dokumen-legal.index')
        ->with('success', 'Dokumen berhasil diperbarui');
}

 /* =======================
     * HITUNG STATUS
     * ======================= */
    private function hitungStatus($tanggalBerakhir)
    {
        if (!$tanggalBerakhir) return 'berlaku';

        $hari = Carbon::now()->diffInDays(Carbon::parse($tanggalBerakhir), false);

        if ($hari <= 1) return 'putus';
        if ($hari <= 10) return 'kadaluarsa';
        if ($hari <= 60) return 'jadwal pembaharuan';

        return 'berlaku';
    }

    /* =======================
     * DESTROY
     * ======================= */
    public function destroy($id)
    {
        $dokumen = MetadataDokumenLegal::with('details')->findOrFail($id);

        foreach ($dokumen->details as $detail) {
            if ($detail->file) {
                $filePath = base_path('../storage/'.$detail->file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $detail->delete();
        }

        $dokumen->delete();

        return redirect()->route('dokumen-legal.index')
            ->with('success', 'Dokumen berhasil dihapus');
    }

   
}
