<?php
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterpenagihanController;
use App\Http\Controllers\PengendaliansistemitController;
use App\Http\Controllers\PrintPembayaranController;
use App\Http\Controllers\PrintPenagihanController;
use App\Http\Controllers\PengajuanPembayaranController;
use App\Http\Controllers\TbPenerimaController;
use App\Http\Controllers\DataTransferController;
use App\Http\Controllers\PrintPermintaanBarangController;
use App\Http\Controllers\AnggaranopController;
use App\Http\Controllers\AnggaranHrdController;
use App\Http\Controllers\PembayaraninternalController;
use App\Http\Controllers\PrintAnggaranLegalController;
use App\Http\Controllers\PrintAnggaranLegalopController;
use App\Http\Controllers\PrintAnggaranhrdnoop;
use App\Http\Controllers\MetadataDokumenLegalController;
use App\Http\Controllers\AnggaranLegalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    Route::get('/karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');

// Custom Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root to login if not authenticated
Route::get('/', function () {
    return redirect()->route('login');
});

    // Existing routes for public access
    Route::get('pengendalian-sistem/print', [PengendaliansistemitController::class, 'print'])
        ->name('pengendalian-sistem.print');
    
    Route::get('/print-penagihan/{id}', [PrintPenagihanController::class, 'print'])->name('print.penagihan');
    Route::get('/print-kwitansi/{id}', [PrintPenagihanController::class, 'printkwitansi'])->name('print.kwitansi');


Route::middleware(['auth'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Pengajuan Pembayaran Routes
    Route::resource('pengajuan-pembayaran', PengajuanPembayaranController::class)->parameters([
        'pengajuan-pembayaran' => 'pengajuan'
    ]);
    Route::post('pengajuan-pembayaran/{pengajuan}/update-status', [PengajuanPembayaranController::class, 'updateStatus'])
        ->name('pengajuan-pembayaran.update-status');
    // Route::get('/pengajuan-pembayaran/{pengajuan}/edit', [PengajuanPembayaranController::class, 'edit'])->name('pengajuan-pembayaran.edit');
    // Route::put('/pengajuan-pembayaran/{pengajuan}', [PengajuanPembayaranController::class, 'update'])->name('pengajuan-pembayaran.update');
    Route::get('/print-pembayaran/{id}', [PrintPembayaranController::class, 'show'])->name('print.pembayaran');

    // Purchasing Routes
    Route::resource('purchasing', App\Http\Controllers\PurchasingController::class)->parameters([
        'purchasing' => 'purchasing'
    ]);
    Route::post('purchasing/{purchasing}/update-status', [App\Http\Controllers\PurchasingController::class, 'updateStatus'])
        ->name('purchasing.update-status');
    Route::get('/print-purchasing/{id}', [App\Http\Controllers\PrintPurchasingController::class, 'show'])->name('print.purchasing');

    // pembayaraninternal Routes
    Route::resource('pembayaraninternal', 'App\Http\Controllers\PembayaraninternalController')->parameters([
        'pembayaraninternal' => 'pembayaraninternal'
    ]);
    Route::post('pembayaraninternal/{pembayaraninternal}/update-status', [PembayaraninternalController::class, 'updateStatus'])
        ->name('pembayaraninternal.update-status');
    Route::get('/print-pembayaraninternal/{id}', [App\Http\Controllers\PrintPembayaranInternalController::class, 'show'])->name('print.pembayaraninternal');

    // Internal Transfer Routes
    Route::resource('internal-transfer', App\Http\Controllers\InternalTransferController::class)->parameters([
        'internal-transfer' => 'internal_transfer'
    ]);
    Route::get('/internal-transfer/{id}/print', [App\Http\Controllers\InternalTransferController::class, 'print'])->name('internal-transfer.print');


    // Masterpenagihan Routes
    Route::get('/masterpenagihan', [MasterpenagihanController::class, 'index'])->name('masterpenagihan.index');
    Route::get('/masterpenagihan/create', [MasterpenagihanController::class, 'create'])->name('masterpenagihan.create');
    Route::post('/masterpenagihan', [MasterpenagihanController::class, 'store'])->name('masterpenagihan.store');
    Route::get('/masterpenagihan/{masterpenagihan}', [MasterpenagihanController::class, 'show'])->name('masterpenagihan.show');
    Route::get('/masterpenagihan/{masterpenagihan}/edit', [MasterpenagihanController::class, 'edit'])->name('masterpenagihan.edit');
    Route::put('/masterpenagihan/{masterpenagihan}', [MasterpenagihanController::class, 'update'])->name('masterpenagihan.update');
    Route::delete('/masterpenagihan/{masterpenagihan}', [MasterpenagihanController::class, 'destroy'])->name('masterpenagihan.destroy');

    // Additional Masterpenagihan Routes
    Route::put('/masterpenagihan/{masterpenagihan}/status', [MasterpenagihanController::class, 'updateStatus'])->name('masterpenagihan.update-status');
    Route::get('/masterpenagihan/{id}/print', [MasterpenagihanController::class, 'print'])->name('print.penagihan');
    Route::get('/masterpenagihan/{id}/print-kwitansi', [MasterpenagihanController::class, 'printKwitansi'])->name('print.kwitansi');
    
    // Route for tb_penerima CRUD
    Route::resource('tb_penerima', TbPenerimaController::class);

    // Route for data_transfer CRUD
    Route::resource('data-transfer', DataTransferController::class);
    Route::get('/data-transfer/create', [DataTransferController::class, 'create'])->name('data-transfer.create');
    Route::get('/data-transfer/{id}/print', [DataTransferController::class, 'print'])->name('data-transfer.print');
   
    route::resource('permintaanbarang', 'App\Http\Controllers\PermintaanbarangController')->parameters([
    'permintaanbarang' => 'permintaanbarang'
    ]);
    Route::get('permintaanbarang/print/{id}', [PrintPermintaanBarangController::class, 'show'])->name('permintaanbarang.print');
   
    Route::resource('anggaranoperasional', \App\Http\Controllers\AnggaranopController::class)->parameters([
       'anggaranoperasional' => 'anggaranop'
    ]);
    Route::get('anggaranoperasional/{anggaranop}/print', [\App\Http\Controllers\AnggaranopController::class, 'print'])->name('anggaranoperasional.print');

   
   
    Route::view('/progres', 'progres')->name('progres');
    Route::view('/formdatakariyawan', 'formdatakariyawan')->name('formdatakariyawan');
    
     // Anggaran Legal Routes
    Route::resource('anggaranlegal', AnggaranLegalController::class)->parameters([
        'anggaranlegal' => 'anggaranlegal'
    ]);
    Route::get('/anggaranlegal/print/{id}', [PrintAnggaranLegalController::class, 'show'])->name('anggaranlegal.print');
    
    // Anggaran Legal OP Routes
    Route::resource('anggaranlegalop', 'App\Http\Controllers\AnggaranlegalopController')->parameters([
        'anggaranlegalop' => 'anggaranlegalop'
    ]);
    Route::get('/anggaranlegalop/print/{id}', [PrintAnggaranLegalopController::class, 'show'])->name('anggaranlegalop.print');   
    
        // Anggaran HRD Routes
    Route::resource('anggaranhrd', AnggaranHrdController::class)->parameters([
        'anggaranhrd' => 'anggaranhrd'
    ]);

    Route::get('/anggaranhrd/print/{id}', [App\Http\Controllers\PrintAnggaranHrdController::class, 'show'])->name('anggaranhrd.print');
    
    // Anggaran HRD No OP
    
    Route::resource('anggaranhrdnoop', 'App\Http\Controllers\AnggaranhrdnoopController')->parameters([
        'anggaranhrdnoop' => 'anggaranhrdnoop'
    ]);
    Route::get('/anggaranhrdnoop/print/{id}', [PrintAnggaranhrdnoop::class, 'show'])->name('anggaranhrdnoop.print'); 


    
        Route::get('/dokumen-legal/create', 
            [MetadataDokumenLegalController::class, 'create']
        )->name('dokumen-legal.create');
        
        Route::post('/dokumen-legal', 
            [MetadataDokumenLegalController::class, 'store']
        )->name('dokumen-legal.store');
        
        Route::resource('dokumen-legal', MetadataDokumenLegalController::class);
        Route::get('dokumen-legal/{id}/preview',
            [MetadataDokumenLegalController::class, 'preview']
        )->name('dokumen-legal.preview');
        Route::get('dokumen-legal/{id}/edit', [MetadataDokumenLegalController::class, 'edit'])->name('dokumen-legal.edit');

});