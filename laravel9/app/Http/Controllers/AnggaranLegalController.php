<?php

namespace App\Http\Controllers;

use App\Models\AnggaranLegal;
use App\Models\detail_anggaranlegal;
use App\Models\Serieslegal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AnggaranLegalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = AnggaranLegal::with('detail_anggaranlegal', 'serieslegal');

        if($request->has('search') && !empty($request->search)){
        $search = $request->search;

            $query->where(function($q) use ($search){
                    $q->where('nomor_dokumen', 'like', "%{$search}" );
            })->orWhereHas('detail_anggaranlegal', function ($q) use ($search){
                    $q->where('deksripsi', 'like', "%{$search}%");
            });
        }
        
    $query = AnggaranLegal::query();

if ($request->tanggal_awal && $request->tanggal_akhir) {
    $query->whereBetween('tanggal_anggaran', [
        $request->tanggal_awal,
        $request->tanggal_akhir
    ]);
}

if ($request->search) {
    $query->where('nomor_dokumen', 'like', "%{$request->search}%")
          ->orWhere('perihal', 'like', "%{$request->search}%");
}

$anggaranLegals = $query->paginate(10)->withQueryString();
  $anggaranLegals = $query->orderBy('id', 'desc')->paginate(10);
  return view('anggaranlegal.index', compact('anggaranLegals'));
}

      
      
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $serieslegals = Serieslegal::all();
        return view('anggaranlegal.create', compact('serieslegals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
           // VALIDASI (opsional tapi disarankan)
    $request->validate([
        'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
    ]);

    // Upload file
$filePath = null;

if ($request->hasFile('file')) {
    $file = $request->file('file');

    $fileName = time().'_'.$file->getClientOriginalName();

     $destination = dirname(base_path()) . '/storage/anggaranlegal';

    $file->move($destination, $fileName);

    $filePath = 'anggaranlegal/'.$fileName;
    
    
}
        //
        $total_harga = 0;
        foreach ($request->detail as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }
        $anggaranlegal = AnggaranLegal::create([
            'serieslegal_id' => $request->serieslegal_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'sifat' => $request->sifat,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'diterima' => $request->diterima,
            'total_harga' => $total_harga,
            'created_by' => auth()->user()->name,
            'file'   => $filePath,
        ]);
        foreach ($request->detail as $item) {
            $jumlah = $item['qty'] * $item['harga'];
            $anggaranlegal->detail_anggaranlegal()->create([
                'deksripsi' => $item['deksripsi'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'jumlah' => $jumlah,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }

        // foreach ($request->series as $s) {
        //     $anggaranlegal->serieslegals()->create([
        //         'kode_series' => $s['kode_series'],
        //         'keterangan' => $s['keterangan'] ?? null,
        //     ]);
        // }

        return redirect()->route('anggaranlegal.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnggaranLegal  $anggaranLegal
     * @return \Illuminate\Http\Response
     */
    public function show(AnggaranLegal $anggaranlegal)
    {
        //
        $anggaranlegal->load('detail_anggaranlegal', 'serieslegal');
        $serieslegals = Serieslegal::all();
        return view('anggaranlegal.show', compact('anggaranlegal', 'serieslegals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnggaranLegal  $anggaranLegal
     * @return \Illuminate\Http\Response
     */
    public function edit(AnggaranLegal $anggaranlegal)
    {
        //
        $anggaranlegal->load('detail_anggaranlegal', 'serieslegal');
        $serieslegals = Serieslegal::all();
        return view('anggaranlegal.edit', compact('anggaranlegal', 'serieslegals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnggaranLegal  $anggaranLegal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnggaranLegal $anggaranlegal)
    {
        
         // ================= VALIDASI =================
    $request->validate([
        'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
    ]);

    // ================= HANDLE FILE =================
    $filePath = $anggaranlegal->file; // default: pakai file lama

    if ($request->hasFile('file')) {

        // Hapus file lama (jika ada)
        if (
            $anggaranlegal->file &&
            file_exists(public_path($anggaranlegal->file))
        ) {
            unlink(public_path($anggaranlegal->file));
        }

        // Upload file baru
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $destination = dirname(base_path()) . '/storage/anggaranlegal';

        // Pastikan folder ada
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        // Simpan path relatif ke public
        $filePath = 'anggaranlegal/' . $fileName;
    }
        //
        $details = $request->detail ?? [];

        // Hitung total harga
        $total_harga = 0;
        foreach ($details as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }

        // Update header
        $anggaranlegal->update([
            'serieslegal_id' => $request->serieslegal_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'sifat' => $request->sifat,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'diterima' => $request->diterima,
            'total_harga' => $total_harga,
            'file' =>$filePath,
            'created_by' => auth()->user()->name,
        ]);

        // Ambil id detail yang sudah ada
        $existingIds  = $anggaranlegal->detail_anggaranlegal()->pluck('id')->toArray();
        $submittedIds = collect($details)->pluck('id')->filter()->toArray();

        // Hapus detail yang dihilangkan user
        $toDelete = array_diff($existingIds, $submittedIds);
        if (!empty($toDelete)) {
            detail_anggaranlegal::destroy($toDelete);
        }

        // Update atau create detail
        foreach ($details as $item) {
            $jumlah = $item['qty'] * $item['harga'];

            if (!empty($item['id'])) {
                // Update data lama
                $detail = detail_anggaranlegal::find($item['id']);
                $detail->update([
                    'deksripsi' => $item['deksripsi'],
                    'qty'       => $item['qty'],
                    'harga'     => $item['harga'],
                    'jumlah'    => $jumlah,
                    'keterangan'=> $item['keterangan'] ?? null,
                ]);
            } else {
                // Tambah data baru
                $anggaranlegal->detail_anggaranlegal()->create([
                    'deksripsi' => $item['deksripsi'],
                    'qty'       => $item['qty'],
                    'harga'     => $item['harga'],
                    'jumlah'    => $jumlah,
                    'keterangan'=> $item['keterangan'] ?? null,
                ]);
            }
        }
        return redirect()->route('anggaranlegal.index')->with('success', 'Data berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnggaranLegal  $anggaranLegal
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnggaranLegal $anggaranlegal)
    {
        //
        $anggaranlegal->delete();
        $anggaranlegal->detail_anggaranlegal()->delete();
        $anggaranlegal->Serieslegal()->delete();
        return redirect()->route('anggaranlegal.index')->with('success', 'Data berhasil dihapus');
    }
}
