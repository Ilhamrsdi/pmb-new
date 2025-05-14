<?php

use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\Admin\Alur\AlurPendaftaranController;
use App\Http\Controllers\Admin\Atribut_gambar\AtributGambarController;
use App\Http\Controllers\Admin\Berkas\SettingBerkasController;

// Global Controller
use App\Http\Controllers\Admin\CicilanPenurunanUKT\CicilanUktPenurunanController;
use App\Http\Controllers\Admin\Gelombang\GelombangController;
// Admin Controller

use App\Http\Controllers\Admin\Golongan_UKT\GolonganUKTController;
use App\Http\Controllers\Admin\Golongan_UKT\PendaftarUKTController;
use App\Http\Controllers\Admin\Golongan_UKT\UKTController;
use App\Http\Controllers\Admin\Jurusan\JurusanController;
use App\Http\Controllers\Admin\Laporan\LaporanController;
use App\Http\Controllers\Admin\Pendaftar\CamabaAccController;
use App\Http\Controllers\Admin\Pendaftar\CamabaSdhBlmUKTController;
use App\Http\Controllers\Admin\Pendaftar\ExcelController;
use App\Http\Controllers\Admin\Pendaftar\MabaAttributController;
use App\Http\Controllers\Admin\Pendaftar\MabaUKTController;
use App\Http\Controllers\Admin\Pendaftar\PendaftarController;
use App\Http\Controllers\Admin\Pendaftar\SoalTesMabaController;
use App\Http\Controllers\Admin\Pendaftar\TesMabaController;
use App\Http\Controllers\Admin\Pengumuman\PengumumanController;
use App\Http\Controllers\Admin\PesanSiaran\PesanSiaranController;
use App\Http\Controllers\Admin\Prodi\ProdiController;
use App\Http\Controllers\Admin\Prodi_lain\ProdiLainController;
use App\Http\Controllers\Admin\Transaksi\TransaksiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenerateNimController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Pendaftar\BerkasPendukungController;

// Pendaftar Controller
use App\Http\Controllers\Pendaftar\BuktiController;
use App\Http\Controllers\Pendaftar\KelengkapanDataController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Pendaftar;

// Import UserController
use Illuminate\Support\Facades\Artisan;
// GenerateNim Controller
use Illuminate\Support\Facades\Auth;
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

Route::post('/cek_va_ukt', [DashboardController::class, 'CekUKT']);
Route::get('/', [App\Http\Controllers\LandingController::class, 'index']);
Route::get('/get-prodi', [LandingController::class, 'getProdiByGelombang'])->name('get-prodi');
Route::get('/get-program-studi-2', [LandingController::class, 'getProgramStudi2']);

Route::get('/pengumuman/{id}', [App\Http\Controllers\LandingController::class, 'pengumuman']);
Route::post('/cekkode', [App\Http\Controllers\LandingController::class, 'cekkode']);
Route::get('/cektemplate', function () {
    return view('ui-cards');
});

Auth::routes([]);

// Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::group(['prefix' => 'error'], function () {
    Route::get('404', function () {
        return view('error.404');
    })->name('error-404');
    Route::get('500', function () {
        return view('error.500');
    })->name('error-500');
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    return "App optimized";
});

// Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware([Admin::class, 'auth'])->prefix('admin')->group(function () {
    // Pendaftar
    Route::get('/export-pendaftar', [PendaftarController::class, 'exportPendaftar'])->name('pendaftar.export');
    Route::resource('pendaftar', PendaftarController::class);
    Route::get('/access-logs', [AccessLogController::class, 'index'])->name('access-logs.index');
    Route::delete('/access-logs/{id}', [AccessLogController::class, 'destroy'])->name('access-logs.destroy');
    Route::post('/access-logs/delete-all', [AccessLogController::class, 'deleteAll'])->name('access-logs.delete-all');

    // Route untuk update status pendaftaran
    Route::post('/pendaftar/update-status', [PendaftarController::class, 'updateStatus'])->name('pendaftar.update-status');
    Route::post('/pendaftar/update-status-pendaftar', [PendaftarController::class, 'updateStatusPendaftar'])->name('pendaftar.update-status-pendaftar');
    // Route untuk update status pembayaran
    Route::post('/camaba-ukt/update-status', [CamabaSdhBlmUKTController::class, 'updateStatus'])->name('camaba-ukt.update-status');

    Route::post('pendaftar-excel', [ExcelController::class, 'import'])->name('import.pendaftar');
    Route::post('ukt-excel', [ExcelController::class, 'import_ukt'])->name('import.ukt');
    Route::get('camaba/export-excel', [MabaUKTController::class, 'exportToExcel'])->name('camaba.export-excel');

    Route::put('/status-ujian/{id}', [CamabaAccController::class, 'statusujian'])->name('status-ujian.update');
    Route::put('/status-ujian/update-selected', [CamabaAccController::class, 'updateSelected'])->name('status-ujian.update.selected');

    Route::resource('camaba-acc', CamabaAccController::class);

    Route::resource('camaba-ukt', CamabaSdhBlmUKTController::class);
    Route::resource('maba-ukt', MabaUKTController::class);
    Route::resource('tes-maba', TesMabaController::class);
    Route::resource('pengumuman', PengumumanController::class);

    Route::get('/soal-tes-maba/{id}', [SoalTesMabaController::class, 'show'])->name('soal-tes-maba.show');
    Route::post('/soal-tes-maba-add', [SoalTesMabaController::class, 'store'])->name('soal-tes-maba-add.store');

    Route::get('/maba-attribut', [MabaAttributController::class, 'index'])->name('maba-attribut.index');
    Route::get('/maba-attribut-pdf/{id}', [MabaAttributController::class, 'pdf'])->name('maba-attribut.pdf');
    Route::post('/maba-attribut-kaos/{id}', [MabaAttributController::class, 'updateKaos'])->name('maba-attribut.kaos');
    Route::post('/maba-attribut-topi/{id}', [MabaAttributController::class, 'updateTopi'])->name('maba-attribut.topi');
    Route::post('/maba-attribut-almamater/{id}', [MabaAttributController::class, 'updateAlmamater'])->name('maba-attribut.almamater');
    Route::post('/maba-attribut-jas/{id}', [MabaAttributController::class, 'updateJasLab'])->name('maba-attribut.jas');
    Route::post('/maba-attribut-baju-lapangan/{id}', [MabaAttributController::class, 'updateBajuLapangan'])->name('maba-attribut.baju-lapangan');

    Route::resource('atribut-gambars', App\Http\Controllers\Admin\Atribut_gambar\AtributGambarController::class);

    // // Route untuk menampilkan daftar atribut gambar
    // Route::get('/maba-attribut/atribut-gambars', [AtributGambarController::class, 'index'])->name('atribut-gambars.index');

    // // Route untuk menampilkan form tambah atribut gambar
    // Route::get('atribut-gambars/create', [AtributGambarController::class, 'create'])->name('atribut-gambars.create');

    // // Route untuk menyimpan atribut gambar
    // Route::post('/maba-attribut/atribut-gambars', [AtributGambarController::class, 'store'])->name('atribut-gambars.store');

    // // Route untuk menampilkan form edit atribut gambar
    // Route::get('/maba-attribut/atribut-gambars/{atributGambar}/edit', [AtributGambarController::class, 'edit'])->name('atribut-gambars.edit');

    // // Route untuk update atribut gambar
    // Route::put('/maba-attribut/atribut-gambars/{atributGambar}', [AtributGambarController::class, 'update'])->name('atribut-gambars.update');

    // // Route untuk menghapus atribut gambar
    // Route::delete('maba-attribut/atribut-gambars/{atributGambar}', [AtributGambarController::class, 'destroy'])->name('atribut-gambars.destroy');

    Route::resource('gelombang', GelombangController::class);
    Route::post('transaksi_berkas_gelombang', [TransaksiController::class, 'BerkasGelombang'])->name('transaksis.berkas_gelombang');
    Route::post('/gelombang/{id}/set-prodi-lain', [GelombangController::class, 'setProdiLain'])->name('gelombang.setProdiLain');
    Route::post('transaksi_prodi_gelombang', [TransaksiController::class, 'ProdiLain'])->name('transaksis.prodi_lain');

    Route::resource('jurusan', JurusanController::class);
    Route::get('sync/jurusan', [JurusanController::class, 'sync'])->name('jurusan.sync');
    Route::resource('prodi', ProdiController::class);
    Route::get('sync/prodi', [ProdiController::class, 'sync'])->name('prodi.sync');

    Route::resource('prodi-lain', ProdiLainController::class);

    Route::resource('settingberkas', SettingBerkasController::class);

    // Golongan & UKT
    Route::resource('golongan-ukt', GolonganUKTController::class);
    Route::resource('ukt', UKTController::class);

    Route::get('listPendaftar/{id}', [PendaftarUKTController::class, 'listPendaftar'])->name('listPendaftar.ukt');
    Route::post('pendaftarCreateUKT', [PendaftarUKTController::class, 'pendaftarCreateUKT'])->name('pendaftarCreateUKT.ukt');
    Route::post('pendaftarDeleteUKT/', [PendaftarUKTController::class, 'pendaftarDeleteUKT'])->name('pendaftarDeleteUKT.ukt');

    // Laporan
    Route::get('laporan/laporan-penerimaan', [LaporanController::class, 'laporan_penerimaan'])->name('laporanPenerimaan');
    Route::get('laporan/laporan-pembayaran', [LaporanController::class, 'laporan_pembayaran'])->name('laporanPembayaran');
    Route::get('laporan/grafik-provinsi', [LaporanController::class, 'grafik_provinsi'])->name('grafikProvinsi');
    Route::get('laporan/grafik-prodi', [LaporanController::class, 'grafik_prodi'])->name('grafikProdi');

    // Alur Pendaftaran
    Route::get('lainnya/alur-pendaftaran', [AlurPendaftaranController::class, 'index'])->name('alurPendaftaran');
    Route::get('lainnya/alur-pendaftaran/create', [AlurPendaftaranController::class, 'create'])->name('alurPendaftaran.create');
    Route::post('lainnya/alur-pendaftaran', [AlurPendaftaranController::class, 'store'])->name('alurPendaftaran.store');
    Route::get('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'show'])->name('alurPendaftaran.show');
    Route::get('lainnya/alur-pendaftaran/{id}/edit', [AlurPendaftaranController::class, 'edit'])->name('alurPendaftaran.edit');
    Route::put('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'update'])->name('alurPendaftaran.update');
    Route::delete('lainnya/alur-pendaftaran/{id}', [AlurPendaftaranController::class, 'destroy'])->name('alurPendaftaran.destroy');

    // Cicilan UKT
    Route::get('lainnya/cicilan-ukt', [CicilanUktPenurunanController::class, 'index'])->name('cicilanUkt');
    Route::put('lainnya/cicilan-ukt/{id}', [CicilanUktPenurunanController::class, 'update'])->name('cicilanUkt.update');
    Route::delete('lainnya/cicilan-ukt/{id}', [CicilanUktPenurunanController::class, 'destroy'])->name('cicilanUkt.destroy');
    Route::put('lainnya/cicilan-ukt/update-status/{id}', [CicilanUktPenurunanController::class, 'updateStatus'])->name('cicilanUkt.updateStatus');
    Route::post('lainnya/cicilan-ukt/upload', [CicilanUktPenurunanController::class, 'upload'])->name('cicilanUkt.upload');

    // Pesan Siaran
    Route::get('pesan-siaran', [PesanSiaranController::class, 'index'])->name('pesanSiaran');
    Route::post('pesan-siaran/kirim', [PesanSiaranController::class, 'kirimPesan'])->name('admin.pesan-siaran.kirim');

                                                     // User Management
    Route::resource('users', UserController::class); // Add this line

    // Menampilkan daftar pendaftar dan melakukan generate NIM massal
    Route::get('/generate-nim', [GenerateNimController::class, 'index'])->name('generate-nim.index');
    Route::post('/generate-nim-massal', [GenerateNimController::class, 'generateNIMMassal'])->name('generate-nim.massal');
});

// Route untuk halaman edit pendaftar
Route::middleware([Pendaftar::class, 'auth'])->prefix('pendaftar')->group(function () {
    Route::post('upload/bukti-bayar-pendaftaran', [BuktiController::class, 'upload_bukti_pendaftaran'])->name('upload-bukti-pendaftaran');
    Route::get('/ujian/{id}', [SoalTesMabaController::class, 'index'])->name('pendaftar.ujian.index');
    Route::post('/store-answers', [SoalTesMabaController::class, 'storeAnswers'])->name('storeAnswers');
    Route::post('ujian/result', [SoalTesMabaController::class, 'result'])->name('pendaftar.ujian.result');
    Route::post('upload/bukti-bayar-ukt', [BuktiController::class, 'upload_bukti_ukt'])->name('upload-bukti-ukt');
    Route::get('keringanan-ukt', [UKTController::class, 'formKeringanan'])->name('pendaftar.keringanan-ukt.form');
    Route::post('keringanan-ukt/ajukan', [UKTController::class, 'ajukanKeringanan'])->name('pendaftar.keringanan-ukt.ajukan');

    // Route untuk pengajuan pencicilan UKT
    Route::get('pencicilan-ukt', [DashboardController::class, 'formPencicilan'])->name('pendaftar.pencicilan-ukt.form');
    Route::post('/pencicilan-ukt/ajukan', [DashboardController::class, 'ajukanPencicilan'])->name('pendaftar.pencicilan-ukt.ajukan');

    // Route untuk kelengkapan data pendaftar
    // Kelengkapan Data Dasar
    Route::get('kelengkapan-data/{id}', [KelengkapanDataController::class, 'edit'])
        ->name('kelengkapan-data.edit'); // Menampilkan form edit kelengkapan data dasar

    Route::put('kelengkapan-data/{id}', [KelengkapanDataController::class, 'update'])
        ->name('kelengkapan-data.update'); // Mengupdate kelengkapan data dasar

    Route::get('get/kecamatan/{id}', [KelengkapanDataController::class, 'get_kecamatan'])
        ->name('get_kecamatan.show');

    Route::get('get/kabupaten/{id}', [KelengkapanDataController::class, 'get_kabupaten'])
        ->name('get_kabupaten.show');
    // Kelengkapan Data Lanjutan
    Route::get('kelengkapan-data-lanjutan/{id}', [KelengkapanDataController::class, 'index'])
        ->name('kelengkapan-data.lanjutan.index'); // Menampilkan form kelengkapan data lanjutan

    Route::put('kelengkapan-data-lanjutan/{id}', [KelengkapanDataController::class, 'updateLanjutan'])
        ->name('kelengkapan-data.lanjutan.update'); // Mengupdate kelengkapan data lanjutan

    Route::get('bukti/{id}', [BuktiController::class, 'show'])->name('bukti.show');
    Route::get('bukti/bukt-pendaftaran/{id}', [BuktiController::class, 'buktiPendaftaran'])->name('bukti.bukti-pendaftaran');
    Route::get('bukti/kartu-ujian/{id}', [BuktiController::class, 'kartuUjian'])->name('bukti.kartu-ujian');
    Route::get('/generate-pdf', [PdfController::class, 'generatePDF'])->name('generate-pdf');

});

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::post('/xendit/callback', [RegisterController::class, 'xenditCallback']);
