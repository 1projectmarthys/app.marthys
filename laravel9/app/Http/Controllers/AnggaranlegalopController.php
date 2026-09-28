<?php

namespace App\Http\Controllers;

use App\Models\anggaranlegalop;
use App\Models\detail_anggaranlegalop;
use App\Models\serieslegalop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggaranlegalopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
        //

        $query = anggaranlegalop::with('detail_anggaranlegalop', 'serieslegalop');

        if($request->has('search') && !empty($request->search)){
        $search = $request->search;

            $query->where(function($q) use ($search){
                    $q->where('nomor_dokumen', 'like', "%{$search}" );
            })->orWhereHas('detail_anggaranlegalop', function ($q) use ($search){
                    $q->where('deksripsi', 'like', "%{$search}%");
            });
        }
        $query = anggaranlegalop::query();

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

$anggaranlegalop = $query->paginate(10)->withQueryString();
  $anggaranlegalop = $query->orderBy('id', 'desc')->paginate(10);
  return view('anggaranlegalop.index', compact('anggaranlegalop'));
}

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.create', compact('serieslegalops'));
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
        'note'                  => 'nullable|string|max:1000',
        'detail'                => 'required|array|min:1',
        'detail.*.tanggal'      => 'required|date',
        'detail.*.deksripsi'    => 'required|string',
        'detail.*.keterangan'   => 'nullable|string',
        'detail.*.harga'        => 'required|numeric',
    ]);

    // Upload file
$filePath = null;

if ($request->hasFile('file')) {
    $file = $request->file('file');

    $fileName = time().'_'.$file->getClientOriginalName();

     $destination = dirname(base_path()) . '/storage/anggaranlegalop';

    $file->move($destination, $fileName);

    $filePath = 'anggaranlegalop/'.$fileName;
}

        //
        $total_harga = 0;
        foreach ($request->detail as $item) {
            $total_harga += (float) ($item['harga'] ?? 0);
        }
       $anggaranlegalop = anggaranlegalop::create([
           'serieslegalop_id' => $request->serieslegalop_id,
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'sifat' => $request->sifat,
            'diajukan_oleh' => $request->diajukan_oleh,
            'perihal' => $request->perihal,
            'note' => $request->note,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'diterima' => $request->diterima,
            'total_harga' => $total_harga,
            'file'             => $filePath,
            'created_by' => auth()->user()->name,
            
        ]);
        foreach ($request->detail as $item) {
            $anggaranlegalop->detail_anggaranlegalop()->create([
                'tanggal' => $item['tanggal'] ?? null,
                'deksripsi' => $item['deksripsi'],
                'harga' => $item['harga'],
                'jumlah' => $item['harga'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }
        return redirect()->route('anggaranlegalop.index')->with('success', 'Anggaran Legal OP berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function show(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->load('detail_anggaranlegalop', 'serieslegalop');
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.show', compact('anggaranlegalop', 'serieslegalops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function edit(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->load('detail_anggaranlegalop', 'serieslegalop');
        $serieslegalops = serieslegalop::all();
        return view('anggaranlegalop.edit', compact('anggaranlegalop', 'serieslegalops'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, anggaranlegalop $anggaranlegalop)
{
    // ================= VALIDASI =================
    $request->validate([
        'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,jpg,png|max:10240',
        'note'                  => 'nullable|string|max:1000',
        'detail'                => 'required|array|min:1',
        'detail.*.tanggal'      => 'required|date',
        'detail.*.deksripsi'    => 'required|string',
        'detail.*.keterangan'   => 'nullable|string',
        'detail.*.harga'        => 'required|numeric',
    ]);

    // ================= HANDLE FILE =================
    $filePath = $anggaranlegalop->file; // default: pakai file lama

    if ($request->hasFile('file')) {

        // Hapus file lama (jika ada)
        if (
            $anggaranlegalop->file &&
            file_exists(public_path($anggaranlegalop->file))
        ) {
            unlink(public_path($anggaranlegalop->file));
        }

        // Upload file baru
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $destination = dirname(base_path()) . '/storage/anggaranlegalop';

        // Pastikan folder ada
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        // Simpan path relatif ke public
        $filePath = 'anggaranlegalop/' . $fileName;
    }

    // ================= DETAIL =================
    $details = $request->detail ?? [];

    // Hitung total harga
    $total_harga = 0;
    foreach ($details as $item) {
        $total_harga += (float) ($item['harga'] ?? 0);
    }

    // ================= UPDATE HEADER =================
    $anggaranlegalop->update([
        'serieslegalop_id'   => $request->serieslegalop_id,
        'tanggal_anggaran'  => $request->tanggal_anggaran,
        'sifat'             => $request->sifat,
        'diajukan_oleh'     => $request->diajukan_oleh,
        'perihal'           => $request->perihal,
        'note'              => $request->note,
        'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
        'diterima'          => $request->diterima,
        'total_harga'       => $total_harga,
        'file'              => $filePath,
        'created_by' => auth()->user()->name,
    ]);

    // ================= SINKRON DETAIL =================
    $existingIds  = $anggaranlegalop->detail_anggaranlegalop()->pluck('id')->toArray();
    $submittedIds = collect($details)->pluck('id')->filter()->toArray();

    // Hapus detail yang dihapus user
    $toDelete = array_diff($existingIds, $submittedIds);
    if (!empty($toDelete)) {
        detail_anggaranlegalop::destroy($toDelete);
    }

    // Update / Create detail
    foreach ($details as $item) {
        $payload = [
            'tanggal'   => $item['tanggal'] ?? null,
            'deksripsi' => $item['deksripsi'],
            'harga'     => $item['harga'] ?? 0,
            'jumlah'    => $item['harga'] ?? 0,
            'keterangan'=> $item['keterangan'] ?? null,
        ];

        if (!empty($item['id'])) {
            // Update data lama
            $detail = detail_anggaranlegalop::find($item['id']);
            if ($detail) {
                $detail->update($payload);
            }
        } else {
            // Tambah data baru
            $anggaranlegalop->detail_anggaranlegalop()->create($payload);
        }
    }

    return redirect()
        ->route('anggaranlegalop.index')
        ->with('success', 'Anggaran Legal OP berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\anggaranlegalop  $anggaranlegalop
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggaranlegalop $anggaranlegalop)
    {
        //
        $anggaranlegalop->delete();
        $anggaranlegalop->detail_anggaranlegalop()->delete();

        return redirect()->route('anggaranlegalop.index')->with('success', 'Anggaran Legal OP berhasil dihapus.');  

    }
}
