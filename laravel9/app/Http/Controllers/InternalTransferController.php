<?php

namespace App\Http\Controllers;

use App\Models\InternalTransfer;
use Illuminate\Http\Request;

class InternalTransferController extends Controller
{
    public function index(Request $request)
    {
        $query = InternalTransfer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_dokumen', 'like', "%{$search}%")
                    ->orWhere('atasnama_penerima', 'like', "%{$search}%")
                    ->orWhere('atasnama_pengirim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $internaltransfers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('internal-transfer.index', compact('internaltransfers'));
    }

    public function create()
    {
        $jenisOptions = InternalTransfer::jenisTransferOptions();

        return view('internal-transfer.create', compact('jenisOptions'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated['terbilang']  = InternalTransfer::terbilang($validated['jumlah_transfer']);
        $validated['created_by'] = auth()->user()->name ?? null;

        if ($validated['jenis_transfer'] !== 'lainnya') {
            $validated['jenis_transfer_lainnya'] = null;
        }

        $transfer = InternalTransfer::create($validated);

        return redirect()->route('internal-transfer.show', $transfer->id)
            ->with('success', 'Form Internal Transfer berhasil dibuat.');
    }

    public function show(InternalTransfer $internal_transfer)
    {
        return view('internal-transfer.show', ['transfer' => $internal_transfer]);
    }

    public function edit(InternalTransfer $internal_transfer)
    {
        $jenisOptions = InternalTransfer::jenisTransferOptions();

        return view('internal-transfer.edit', [
            'transfer'     => $internal_transfer,
            'jenisOptions' => $jenisOptions,
        ]);
    }

    public function update(Request $request, InternalTransfer $internal_transfer)
    {
        $validated = $this->validateData($request);

        $validated['terbilang'] = InternalTransfer::terbilang($validated['jumlah_transfer']);

        if ($validated['jenis_transfer'] !== 'lainnya') {
            $validated['jenis_transfer_lainnya'] = null;
        }

        $internal_transfer->update($validated);

        return redirect()->route('internal-transfer.show', $internal_transfer->id)
            ->with('success', 'Form Internal Transfer berhasil diperbarui.');
    }

    public function destroy(InternalTransfer $internal_transfer)
    {
        $internal_transfer->delete();

        return redirect()->route('internal-transfer.index')
            ->with('success', 'Form Internal Transfer berhasil dihapus.');
    }

    public function print($id)
    {
        $transfer = InternalTransfer::findOrFail($id);

        return view('internal-transfer.print', compact('transfer'));
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'tanggal'                => 'required|date',
            'rencana_bayar'          => 'required|date',
            'dari_bank'              => 'required|string|max:255',
            'norek_pengirim'         => 'required|string|max:255',
            'atasnama_pengirim'      => 'required|string|max:255',
            'ke_bank'                => 'required|string|max:255',
            'norek_penerima'         => 'required|string|max:255',
            'atasnama_penerima'      => 'required|string|max:255',
            'jumlah_transfer'        => 'required|numeric|min:0',
            'jenis_transfer'         => 'required|in:operasional,deposito,payroll,kas_tunai,lainnya',
            'jenis_transfer_lainnya' => 'nullable|string|max:255|required_if:jenis_transfer,lainnya',
            'note'                   => 'nullable|string|max:1000',
        ], [
            'jenis_transfer_lainnya.required_if' => 'Isi keterangan untuk jenis transfer "Lainnya".',
        ]);
    }
}
