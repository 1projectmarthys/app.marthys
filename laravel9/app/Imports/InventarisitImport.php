<?php

namespace App\Imports;

use App\Models\Inventarisit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InventarisitImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Inventarisit([
            'nama_barang' => $row['nama_barang'],
            'spesifikasi_barang' => $row['spesifikasi_barang'],
            'tahun' => $row['tahun'],
            'jumlah' => $row['jumlah'],
            'kondisi_barang' => $row['kondisi_barang'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}