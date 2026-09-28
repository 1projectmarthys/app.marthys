<?php

namespace App\Http\Controllers;

use App\Models\anggaranop;
use App\Models\detail_anggaranop;
use Illuminate\Http\Request;

class AnggaranopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $anggaranops = anggaranop::with('detailAnggaranops')->get();
        $query = anggaranop::with('detailAnggaranops');
        // Filter tanggal awal
        if ($request->has('tanggal_awal') && $request->tanggal_awal) {
            $query->whereDate('tanggal_anggaran', '>=', $request->tanggal_awal);
        }

        // Filter tanggal akhir
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_anggaran', '<=', $request->tanggal_akhir);
        }

        // Search berdasarkan note
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('note', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        // Pagination (opsional, default 10 per halaman)
        $perPage = $request->input('per_page', 10);
        $anggaranops = $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();

        return view('anggaranoperasional.index', compact('anggaranops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('anggaranoperasional.create');
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
            'tanggal_anggaran' => 'required|date',
            'note' => 'nullable|string',
            'waktu_pelaksanaan' => 'required|string',
            'detail.*.keperluan' => 'required|string',
            'detail.*.keterangan' => 'nullable|string',
            'detail.*.jumlah' => 'required|numeric',
        ]);

        // Hitung total anggaran dari detail
        $total_anggaran = collect($request->detail)->sum('jumlah');

        $anggaranops = anggaranop::create([
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'note' => $request->note,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'jumlah_kolom' => $request->jumlah_kolom ?? '3kolom',
            'total_anggaran' => $total_anggaran,
        ]);

        foreach ($request->detail as $detail) {
            $anggaranops->detailAnggaranops()->create($detail);
        }

        return redirect()->route('anggaranoperasional.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\anggaranop  $anggaranop
     * @return \Illuminate\Http\Response
     */
    public function show(anggaranop $anggaranop)
    {
        $anggaranop->load('detailAnggaranops');
        return view('anggaranoperasional.show', compact('anggaranop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\anggaranop  $anggaranop
     * @return \Illuminate\Http\Response
     */
    public function edit(anggaranop $anggaranop)
    {
        $anggaranop->load('detailAnggaranops');
        return view('anggaranoperasional.edit', compact('anggaranop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\anggaranop  $anggaranop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, anggaranop $anggaranop)
    {
        $validated = $request->validate([
            'tanggal_anggaran' => 'required|date',
            'note' => 'nullable|string',
            'waktu_pelaksanaan' => 'required|string',
          
            'detail.*.id' => 'nullable|integer|exists:detail_anggaranops,id',
            'detail.*.keperluan' => 'required|string',
            'detail.*.keterangan' => 'nullable|string',
            'detail.*.jumlah' => 'required|numeric',
        ]);

        $total_anggaran = collect($request->detail)->sum('jumlah');

        $anggaranop->update([
            'tanggal_anggaran' => $request->tanggal_anggaran,
            'note' => $request->note,
            'waktu_pelaksanaan' => $request->waktu_pelaksanaan,
            'jumlah_kolom' => $request->jumlah_kolom?? '3kolom',
            'total_anggaran' => $total_anggaran,
        ]);

        // Update or create detail
        $detailIds = [];
        foreach ($request->detail as $detail) {
            if (isset($detail['id'])) {
                $detailModel = detail_anggaranop::find($detail['id']);
                $detailModel->update($detail);
                $detailIds[] = $detailModel->id;
            } else {
                $newDetail = $anggaranop->detailAnggaranops()->create($detail);
                $detailIds[] = $newDetail->id;
            }
        }
        // Hapus detail yang tidak ada di input
        $anggaranop->detailAnggaranops()->whereNotIn('id', $detailIds)->delete();

        return redirect()->route('anggaranoperasional.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\anggaranop  $anggaranop
     * @return \Illuminate\Http\Response
     */
    public function destroy(anggaranop $anggaranop)
    {
        $anggaranop->detailAnggaranops()->delete();
        $anggaranop->delete();
        return redirect()->route('anggaranoperasional.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Print the specified resource.
     *
     * @param  \App\Models\anggaranop  $anggaranop
     * @return \Illuminate\Http\Response
     */
    public function print(anggaranop $anggaranop)
    {
        $anggaranop->load('detailAnggaranops');
        return view('anggaranoperasional.print_1', compact('anggaranop'));
    }
}
