<?php

namespace App\Http\Controllers;

use App\Models\permintaanbarang;
use App\Models\detail_permintaanbarang;
use Illuminate\Http\Request;

class PermintaanbarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    $query = permintaanbarang::with('detail_permintaanbarangs');

    // Filter berdasarkan detail barang
    if($request->has('search') && !empty($request->search)){
        $search = $request->search;

        $query->where(function($q) use ($search){
                $q->where('nomor_dokumen', 'like', "%{$search}" );
        })->orWhereHas('detail_permintaanbarangs', function ($q) use ($search){
                $q->where('nama_barang', 'like', "%{$search}%");
        });
    }
    // Filter tanggal awal
    if ($request->filled('tanggal_awal')) {
        $query->whereDate('tanggal_permintaan', '>=', $request->tanggal_awal);
    }

    // Filter tanggal akhir
    if ($request->filled('tanggal_akhir')) {
        $query->whereDate('tanggal_permintaan', '<=', $request->tanggal_akhir);
    }

    // Search by keterangan, nomor dokumen, atau sifat
    // if ($request->filled('search')) {
    //     $query->where(function($q) use ($request) {
    //         $q->where('keterangan', 'like', '%' . $request->search . '%')
    //           ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%')
    //           ->orWhere('sifat', 'like', '%' . $request->search . '%');
    //     });
    // }

    // Pagination (opsional)
    $permintaanbarangs = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('permintaanbarang.index', compact('permintaanbarangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permintaanbarang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_permintaan' => 'required|date',
            'sifat' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
            'detail.*.nama_barang' => 'required|string',
            'detail.*.qty' => 'required|numeric',
            'detail.*.satuan' => 'required|string',
            'detail.*.harga' => 'required|numeric',
            'detail.*.keterangan' => 'nullable|string',
        ]);

        $total_harga = 0;
        foreach ($request->detail as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }

        $permintaanbarang = permintaanbarang::create([
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'sifat' => $request->sifat,
            'keterangan' => $request->keterangan,
            'total_harga' => $total_harga,
            'status' => $request->status,
            'created_by' => auth()->user()->name,
        ]);

        foreach ($request->detail as $item) {
            $jumlah = $item['qty'] * $item['harga'];
            $permintaanbarang->detail_permintaanbarangs()->create([
                'nama_barang' => $item['nama_barang'],
                'qty' => $item['qty'],
                'satuan' => $item['satuan'],
                'harga' => $item['harga'],
                'jumlah' => $jumlah,
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('permintaanbarang.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\permintaanbarang  $permintaanbarang
     * @return \Illuminate\Http\Response
     */
    public function show(permintaanbarang $permintaanbarang)
    {
        $permintaanbarang->load('detail_permintaanbarangs');
        return view('permintaanbarang.show', compact('permintaanbarang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\permintaanbarang  $permintaanbarang
     * @return \Illuminate\Http\Response
     */
    public function edit(permintaanbarang $permintaanbarang)
    {
        $permintaanbarang->load('detail_permintaanbarangs');
        return view('permintaanbarang.edit', compact('permintaanbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\permintaanbarang  $permintaanbarang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, permintaanbarang $permintaanbarang)
    {
        $validated = $request->validate([
            'tanggal_permintaan' => 'required|date',
            'sifat' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
            'detail.*.id' => 'nullable|integer|exists:detail_permintaanbarangs,id',
            'detail.*.nama_barang' => 'required|string',
            'detail.*.qty' => 'required|numeric',
            'detail.*.satuan' => 'required|string',
            'detail.*.harga' => 'required|numeric',
            'detail.*.keterangan' => 'nullable|string',
        ]);

        $total_harga = 0;
        foreach ($request->detail as $item) {
            $total_harga += $item['qty'] * $item['harga'];
        }

        $permintaanbarang->update([
            'tanggal_permintaan' => $request->tanggal_permintaan,
            'sifat' => $request->sifat,
            'keterangan' => $request->keterangan,
            'total_harga' => $total_harga,
            'status' => $request->status,
        ]);

        // Sync detail items
        $existingIds = $permintaanbarang->detail_permintaanbarangs()->pluck('id')->toArray();
        $submittedIds = collect($request->detail)->pluck('id')->filter()->toArray();

        // Delete removed details
        $toDelete = array_diff($existingIds, $submittedIds);
        if ($toDelete) {
            detail_permintaanbarang::destroy($toDelete);
        }

        // Update or create details
        foreach ($request->detail as $item) {
            $jumlah = $item['qty'] * $item['harga'];
            if (isset($item['id'])) {
                $detail = detail_permintaanbarang::find($item['id']);
                $detail->update([
                    'nama_barang' => $item['nama_barang'],
                    'qty' => $item['qty'],
                    'satuan' => $item['satuan'],
                    'harga' => $item['harga'],
                    'jumlah' => $jumlah,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            } else {
                $permintaanbarang->detail_permintaanbarangs()->create([
                    'nama_barang' => $item['nama_barang'],
                    'qty' => $item['qty'],
                    'satuan' => $item['satuan'],
                    'harga' => $item['harga'],
                    'jumlah' => $jumlah,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('permintaanbarang.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\permintaanbarang  $permintaanbarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(permintaanbarang $permintaanbarang)
    {
        $permintaanbarang->detail_permintaanbarangs()->delete();
        $permintaanbarang->delete();
        return redirect()->route('permintaanbarang.index')->with('success', 'Data berhasil dihapus');
    }
}
