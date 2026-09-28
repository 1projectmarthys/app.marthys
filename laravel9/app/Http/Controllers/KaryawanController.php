<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Anak;
use App\Models\PengalamanKerja;
use App\Models\RiwayatSakit;

class KaryawanController extends Controller

{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    public function show(Karyawan $karyawan)
    {
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.create', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $rules = [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'status' => 'required',
            'nik' => 'required|unique:karyawans,nik,' . $karyawan->id,
            'no_hp' => 'required',
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'nama_kontak_darurat' => 'required',
            'hubungan_kontak_darurat' => 'required',
            'no_hp_kontak_darurat' => 'required',
            'pendidikan_terakhir' => 'required',
            'nama_institusi' => 'required',
            'jurusan' => 'required',
            'tahun_lulus' => 'required',
            'persetujuan' => 'required',
        ];

        $validated = $request->validate($rules);

        $data = $request->except(['anak', 'pengalaman', 'riwayat', 'file_kk', 'file_ktp', 'file_ijazah']);
        $namaFolder = preg_replace('/[^a-z0-9]+/i', '-', strtolower($request->nama_lengkap));
        $namaFolder = trim($namaFolder, '-');

        // Handle file uploads (replace if new file uploaded)
        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')
                ->storeAs(
                    'storage/uploads/kk/' . $namaFolder,
                    time().'_kk.'.$request->file('file_kk')->getClientOriginalExtension(),
                    'local'
                );
        }
        
        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')
                ->storeAs(
                    'storage/uploads/ktp/' . $namaFolder,
                    time().'_ktp.'.$request->file('file_ktp')->getClientOriginalExtension(),
                    'local'
                );
        }
        
        if ($request->hasFile('file_ijazah')) {
            $data['file_ijazah'] = $request->file('file_ijazah')
                ->storeAs(
                    'storage/uploads/ijazah/' . $namaFolder,
                    time().'_ijazah.'.$request->file('file_ijazah')->getClientOriginalExtension(),
                    'local'
                );
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate!');
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'status' => 'required',
            'nik' => 'required|unique:karyawans,nik',
            'no_hp' => 'required',
            'email' => 'required|email|unique:karyawans,email',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'kode_pos' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'nama_kontak_darurat' => 'required',
            'hubungan_kontak_darurat' => 'required',
            'no_hp_kontak_darurat' => 'required',
            'pendidikan_terakhir' => 'required',
            'nama_institusi' => 'required',
            'jurusan' => 'required',
            'tahun_lulus' => 'required',
            'persetujuan' => 'required',
        ];

        try {
            $data = $request->except(['anak', 'pengalaman', 'riwayat', 'file_kk', 'file_ktp', 'file_ijazah']);

            // Slugify nama_lengkap for folder name
            $namaFolder = preg_replace('/[^a-z0-9]+/i', '-', strtolower($request->nama_lengkap));
            $namaFolder = trim($namaFolder, '-');

            // // Handle file uploads with folder per karyawan
            // if ($request->hasFile('file_kk')) {
            //     $data['file_kk'] = $request->file('file_kk')->store('uploads/kk/' . $namaFolder, 'public');
            // }
            // if ($request->hasFile('file_ktp')) {
            //     $data['file_ktp'] = $request->file('file_ktp')->store('uploads/ktp/' . $namaFolder, 'public');
            // }
            // if ($request->hasFile('file_ijazah')) {
            //     $data['file_ijazah'] = $request->file('file_ijazah')->store('uploads/ijazah/' . $namaFolder, 'public');
            // }
            // Handle file uploads with folder per karyawan (Shared Hosting Safe)
            if ($request->hasFile('file_kk')) {
            
                $file = $request->file('file_kk');
                $filename = time().'_'.$file->getClientOriginalName();
            
                $folder = 'storage/uploads/kk/' . $namaFolder;
                $destination = public_path($folder);
            
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
            
                $file->move($destination, $filename);
            
                $data['file_kk'] = 'uploads/kk/' . $namaFolder . '/' . $filename;
            }
            
            if ($request->hasFile('file_ktp')) {
            
                $file = $request->file('file_ktp');
                $filename = time().'_'.$file->getClientOriginalName();
            
                $folder = 'storage/uploads/ktp/' . $namaFolder;
                $destination = public_path($folder);
            
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
            
                $file->move($destination, $filename);
            
                $data['file_ktp'] = 'uploads/ktp/' . $namaFolder . '/' . $filename;
            }
            
            if ($request->hasFile('file_ijazah')) {
            
                $file = $request->file('file_ijazah');
                $filename = time().'_'.$file->getClientOriginalName();
            
                $folder = 'storage/uploads/ijazah/' . $namaFolder;
                $destination = public_path($folder);
            
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
            
                $file->move($destination, $filename);
            
                $data['file_ijazah'] = 'uploads/ijazah/' . $namaFolder . '/' . $filename;
            }
            $karyawan = Karyawan::create($data);

            // Simpan data anak
            if ($request->has('anak')) {
                foreach ($request->anak as $anak) {
                    if (!empty($anak['nama'])) {
                        $karyawan->anak()->create($anak);
                    }
                }
            }

            // Simpan pengalaman kerja
            if ($request->has('pengalaman')) {
                foreach ($request->pengalaman as $pengalaman) {
                    if (!empty($pengalaman['nama_pt'])) {
                        $karyawan->pengalamanKerja()->create($pengalaman);
                    }
                }
            }

            // Simpan riwayat sakit
            if ($request->has('riwayat')) {
                foreach ($request->riwayat as $riwayat) {
                    if (!empty($riwayat['jenis_penyakit'])) {
                        $karyawan->riwayatSakit()->create($riwayat);
                    }
                }
            }

            return redirect()->back()->with('success', 'Data karyawan berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Redirect with input except file uploads
            return redirect()->back()->withInput($request->except(['file_kk','file_ktp','file_ijazah']))->withErrors($e->validator);
        }

    }

}