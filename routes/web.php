<?php

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NPAController;
use App\Models\detailIndikatorKegiatan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SasaranProgram;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LunasController;
use App\Http\Controllers\SuratController;
use App\Imports\PembayaranTagihansImport;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PemangkuController;
use App\Http\Controllers\VerifiedController;
use App\Http\Controllers\MisiRpjmdController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelunasanController;
use App\Http\Controllers\PembayaranPelanggan;
use App\Http\Controllers\PenetapanController;
use App\Http\Controllers\VisiRpjmdController;
use App\Http\Controllers\CekTagihanController;
use App\Http\Controllers\LaporanIkuController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KategoriOpdController;
use App\Http\Controllers\SubKegiatanController;
use App\Http\Controllers\TargetKerjaController;
use App\Http\Controllers\TujuanRpjmdController;
use App\Http\Controllers\VisiRenstraController;
use App\Http\Controllers\CapaianKerjaController;
use App\Http\Controllers\HistoryEmailController;
use App\Http\Controllers\HistoryPesanController;
use App\Http\Controllers\IndikatorOpdController;
use App\Http\Controllers\LaporanLakipController;
use App\Http\Controllers\PaguAnggaranController;
use App\Http\Controllers\SasaranRpjmdController;
use App\Http\Controllers\detailProgramController;
use App\Http\Controllers\IndikatorOpd2Controller;
use App\Http\Controllers\KategoriReviuController;
use App\Http\Controllers\PohonKerjaOpdController;
use App\Http\Controllers\setting\DendaController;
use App\Http\Controllers\TemplateEmailController;
use App\Http\Controllers\TemplatePesanController;
use App\Http\Controllers\TujuanRenstraController;
use App\Http\Controllers\CascadingRpjmdController;
use App\Http\Controllers\ChecklistReviuController;
use App\Http\Controllers\detailKegiatanController;
use App\Http\Controllers\LaporanRenstraController;
use App\Http\Controllers\SasaranProgramController;
use App\Http\Controllers\SasaranRenstraController;
use App\Http\Controllers\UnitOrganisasiController;
use App\Http\Controllers\PembayaranTelatController;
use App\Http\Controllers\SasaranKegiatanController;
use App\Http\Controllers\CascadingRenstraController;
use App\Http\Controllers\DataPosyanduController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\IndikatorProgramController;
use App\Http\Controllers\KategoriIndustriController;
use App\Http\Controllers\DetailSubKegiatanController;
use App\Http\Controllers\IndikatorKegiatanController;
use App\Http\Controllers\RealisasiAnggaranController;
use App\Http\Controllers\TagihanPemasanganController;
use App\Http\Controllers\LaporanKeselarasanController;
use App\Http\Controllers\ProgramDanKegiatanController;
use App\Http\Controllers\sasaranSubKegiatanController;
use App\Http\Controllers\IndikatorPemerintahController;
use App\Http\Controllers\PembayaranPelangganController;
use App\Http\Controllers\indikatorSubKegiatanController;
use App\Http\Controllers\LaporanMonevAnggaranController;
use App\Http\Controllers\PembayaranPemasanganController;
use App\Http\Controllers\PohonKerjaPemerintahController;
use App\Http\Controllers\detailIndikatorProgramController;
use App\Http\Controllers\detailIndikatorKegiatanController;
use App\Http\Controllers\LaporanPenetapanKinerjaController;
use App\Http\Controllers\LaporanPengukuranKinerjaController;
use App\Http\Controllers\LaporanPerjanjianKinerjaController;
use App\Http\Controllers\DetailIndikatorSubKegiatanController;
use App\Http\Controllers\DiabetesController;
use App\Http\Controllers\HipertensiController;
use App\Http\Controllers\IbuHamilDanBersalinController;
use App\Http\Controllers\JaringanPuskesmasController;
use App\Http\Controllers\JumlahPendudukController;
use App\Http\Controllers\KelahiranController;
use App\Http\Controllers\KeperawatanController;
use App\Http\Controllers\KesehatanBalitaController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanRencanaKinerjaTahunanController;
use App\Http\Controllers\NeonatalController;
use App\Http\Controllers\OdgjController;
use App\Http\Controllers\PelayananLansiaController;
use App\Http\Controllers\PelayananProduktifController;
use App\Http\Controllers\PesertaDidikController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SaranaPelayananController;
use App\Http\Controllers\SaranaProduksiController;
use App\Http\Controllers\TenagaMedisController;
use App\Http\Controllers\TuberkulosisController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\DetailWilayahController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PengelolaProgramController;
use App\Http\Controllers\SasaranIbuHamilController;
use App\Http\Controllers\ObatEsensialController;
use App\Http\Controllers\KelompokUmurController;
use App\Http\Controllers\MelekHurufController;
use App\Http\Controllers\FasilitasKesehatanController;
use App\Http\Controllers\GawatDaruratSatuController;
use App\Http\Controllers\AngkaKematianController;
use App\Http\Controllers\IndikatorKinerjaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\VaksinController;
use App\Http\Controllers\JaminanKesehatanController;
use App\Http\Controllers\JumlahKematianIbuController;
use App\Http\Controllers\PenyebabKematianIbuController;
use App\Http\Controllers\ImunBumilController;
use App\Http\Controllers\WusTidakHamilController;
use App\Http\Controllers\WusHamilController;
use App\Http\Controllers\TtdController;
use App\Http\Controllers\PusController;
use App\Http\Controllers\Pus4TController;
use App\Http\Controllers\KbBersalinController;
use App\Http\Controllers\KomplikasiBidanController;
use App\Http\Controllers\KomplikasiNeonatalController;
use App\Http\Controllers\KematianNeonatalController;
use App\Http\Controllers\PenyebabKematianNeonatalController;
use App\Http\Controllers\PenyebabKematianBalitaController;
use App\Http\Controllers\BblrPrematurController;
use App\Http\Controllers\DeteksiDiniHepatitisBPIBController;
use App\Http\Controllers\ImdAsiController;
use App\Http\Controllers\PelayananBalitaController;
use App\Http\Controllers\BalitaBcgController;
use App\Http\Controllers\BayiImunisasiController;
use App\Http\Controllers\BadutaImunisasiController;
use App\Http\Controllers\BalitaVitaController;
use App\Http\Controllers\TimbangController;
use App\Http\Controllers\StatusGiziController;
use App\Http\Controllers\GigiController;
use App\Http\Controllers\GigiAnakController;
use App\Http\Controllers\CatinController;
use App\Http\Controllers\ObatTuberkulosisController;
use App\Http\Controllers\OdhivController;
use App\Http\Controllers\ResumeController;
use App\Models\BadutaImunisasi;
use App\Http\Controllers\Table63Controller;
use App\Http\Controllers\Table64Controller;
use App\Http\Controllers\Table65Controller;
use App\Http\Controllers\Table66Controller;
use App\Http\Controllers\Table67Controller;
use App\Http\Controllers\Table68Controller;
use App\Http\Controllers\Table69Controller;
use App\Http\Controllers\Table70Controller;
use App\Http\Controllers\Table71Controller;
use App\Http\Controllers\Table72Controller;
use App\Http\Controllers\Table73Controller;
use App\Http\Controllers\Table74Controller;
use App\Http\Controllers\Table77Controller;
use App\Http\Controllers\Table82Controller;
use App\Http\Controllers\Table83Controller;
use App\Http\Controllers\Table84Controller;
use App\Http\Controllers\Table85Controller;
use App\Http\Controllers\Table86Controller;
use App\Http\Controllers\Table87Controller;
use App\Models\Diabetes;
use App\Models\JumlahKematianIbu;
use App\Models\kategoriOpd;
use App\Models\PelayananLansia;
use App\Models\PelayananProduktif;
use App\Models\UnitKerja;
use App\Models\UnitOrganisasi;

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

Route::get('/test-import', function(){
    $import = new PembayaranTagihansImport;
    Excel::import($import, 'kubar_import.xlsx');
    dd($import->results);
});

$ctrl = "\App\Http\Controllers";
Route::get('/', [HomeController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::get("home-page", [HomeController::class, 'homepage'])->name("home-page");

Route::get('/dashboard', [HomeController::class,'index'])->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function()use($ctrl){
    Route::resource('program', ProgramController::class);
    Route::post('/import_program', [ProgramController::class, 'import']);
    Route::get('/export_program', [ProgramController::class, 'export']);

    Route::resource('user', UserController::class);
    Route::resource('log', LogController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('antrian', AntrianController::class);
    Route::resource('sasaran_ibu_hamil', SasaranIbuHamilController::class);
    Route::resource('resume', ResumeController::class);
    Route::post('user/logout', [UserController::class,'logout'])->name('user.logout');
    // Route::resource('pelanggan', PelangganController::class);
    Route::post('pelanggan/get_data', [PelangganController::class,'data'])->name('pelanggan.data');

    //export excel
    Route::get('/pelunasan/exportTemplate', [PelunasanController::class, 'exportTemplateView']);
    Route::post('/pelunasan/exportTemplate', [PelunasanController::class, 'exportTemplate']);

    Route::get('/pelunasan/importExcel', [PelunasanController::class, 'importExcelView']);
    Route::post('/pelunasan/importExcel', [PelunasanController::class, 'importExcel']);
    Route::post('/pelunasan/delete', [PelunasanController::class, 'delete']);

    Route::get('/pelunasan/ajaxGetPelanggan/{upt_id}', [PelunasanController::class, 'ajaxGetPelanggan']);

    Route::post('/import', [ImportController::class, 'import'])->name('import');
    Route::post('/import_sasaran_ibu_hamil', [SasaranIbuHamilController::class, 'import'])->name('import_sasaran_ibu_hamil');
    Route::get('/import/preview', [ImportController::class, 'showPreview'])->name('import.preview');
    Route::post('/import/confirm', [ImportController::class, 'confirmImport'])->name('import.confirm');
    Route::get('/IbuHamil/report', [IbuHamilDanBersalinController::class, 'report'])->name('IbuHamil.report');
    Route::get('/neonatal/report', [NeonatalController::class, 'report'])->name('neonatal.report');
    Route::get('/neonatal/excel', [NeonatalController::class, 'exportExcel'])->name('neonatal.excel');
    Route::get('/IbuHamil/excel', [IbuHamilDanBersalinController::class, 'exportExcel'])->name('IbuHamil.excel');
    Route::get('/Kelahiran/excel', [KelahiranController::class, 'exportExcel'])->name('Kelahiran.excel');
    Route::get('/KesehatanBalita/excel', [KesehatanBalitaController::class, 'exportExcel'])->name('KesehatanBalita.excel');
    Route::get('/PesertaDidik/excel', [PesertaDidikController::class, 'exportExcel'])->name('PesertaDidik.excel');
    Route::get('/PelayananProduktif/excel', [PelayananProduktifController::class, 'exportExcel'])->name('PelayananProduktif.excel');
    Route::get('/PelayananLansia/excel', [PelayananLansiaController::class, 'exportExcel'])->name('PelayananLansia.excel');
    Route::get('/Tuberkulosis/excel', [TuberkulosisController::class, 'exportExcel'])->name('Tuberkulosis.excel');
    Route::get('/Hipertensi/excel', [HipertensiController::class, 'exportExcel'])->name('Hipertensi.excel');
    Route::get('/Diabetes/excel', [DiabetesController::class, 'exportExcel'])->name('Diabetes.excel');
    Route::get('/Kunjungan/excel', [KunjunganController::class, 'exportExcel'])->name('Kunjungan.excel');
    Route::get('/Odgj/excel', [OdgjController::class, 'exportExcel'])->name('Odgj.excel');
    Route::get('/KematianIbu/excel', [JumlahKematianIbuController::class, 'exportExcel'])->name('KematianIbu.excel');
    Route::get('/PenyebabKematianIbu/excel', [PenyebabKematianIbuController::class, 'exportExcel'])->name('PenyebabKematianIbu.excel');
    Route::get('/ImunBumil/excel', [ImunBumilController::class, 'exportExcel'])->name('ImunBumil.excel');
    Route::get('/WusTidakHamil/excel', [WusTidakHamilController::class, 'exportExcel'])->name('WusTidakHamil.excel');
    Route::get('/WusHamil/excel', [WusHamilController::class, 'exportExcel'])->name('WusHamil.excel');
    Route::get('/Ttd/excel', [TtdController::class, 'exportExcel'])->name('Ttd.excel');
    Route::get('/Pus/excel', [PusController::class, 'exportExcel'])->name('Pus.excel');
    Route::get('/Pus4T/excel', [Pus4TController::class, 'exportExcel'])->name('Pus4T.excel');
    Route::get('/KbBersalin/excel', [KbBersalinController::class, 'exportExcel'])->name('KbBersalin.excel');
    Route::get('/KomplikasiBidan/excel', [KomplikasiBidanController::class, 'exportExcel'])->name('KomplikasiBidan.excel');
    Route::get('/KomplikasiNeonatal/excel', [KomplikasiNeonatalController::class, 'exportExcel'])->name('KomplikasiNeonatal.excel');
    Route::get('/KematianNeonatal/excel', [KematianNeonatalController::class, 'exportExcel'])->name('KematianNeonatal.excel');
    Route::get('/PenyebabKematianNeonatal/excel', [PenyebabKematianNeonatalController::class, 'exportExcel'])->name('PenyebabKematianNeonatal.excel');
    Route::get('/PenyebabKematianBalita/excel', [PenyebabKematianBalitaController::class, 'exportExcel'])->name('PenyebabKematianBalita.excel');
    Route::get('/BblrPrematur/excel', [BblrPrematurController::class, 'exportExcel'])->name('BblrPrematur.excel');
    Route::get('/ImdAsi/excel', [ImdAsiController::class, 'exportExcel'])->name('ImdAsi.excel');
    Route::get('/PelayananBalita/excel', [PelayananBalitaController::class, 'exportExcel'])->name('PelayananBalita.excel');
    Route::get('/BalitaBcg/excel', [BalitaBcgController::class, 'exportExcel'])->name('BalitaBcg.excel');
    Route::get('/BayiImunisasi/excel', [BayiImunisasiController::class, 'exportExcel'])->name('BayiImunisasi.excel');
    Route::get('/BadutaImunisasi/excel', [BadutaImunisasiController::class, 'exportExcel'])->name('BadutaImunisasi.excel');
    Route::get('/BalitaVita/excel', [BalitaVitaController::class, 'exportExcel'])->name('BalitaVita.excel');
    Route::get('/Timbang/excel', [TimbangController::class, 'exportExcel'])->name('Timbang.excel');
    Route::get('/StatusGizi/excel', [StatusGiziController::class, 'exportExcel'])->name('StatusGizi.excel');
    Route::get('/Gigi/excel', [GigiController::class, 'exportExcel'])->name('Gigi.excel');
    Route::get('/GigiAnak/excel', [GigiAnakController::class, 'exportExcel'])->name('GigiAnak.excel');
    Route::get('/Catin/excel', [CatinController::class, 'exportExcel'])->name('Catin.excel');
    Route::get('/ObatTuberkulosis/excel', [ObatTuberkulosisController::class, 'exportExcel'])->name('ObatTuberkulosis.excel');
    Route::get('/Odhiv/excel', [OdhivController::class, 'exportExcel'])->name('Odhiv.excel');
    Route::get('/DeteksiDiniHepatitisBPIB/excel', [DeteksiDiniHepatitisBPIBController::class, 'exportExcel'])->name('DeteksiDiniHepatitisBPIB.excel');
    Route::get('/Table63/excel', [Table63Controller::class, 'exportExcel'])->name('Table63.excel');
    Route::get('/Table64/excel', [Table64Controller::class, 'exportExcel'])->name('Table64.excel');
    Route::get('/Table65/excel', [Table65Controller::class, 'exportExcel'])->name('Table65.excel');
    Route::get('/Table66/excel', [Table66Controller::class, 'exportExcel'])->name('Table66.excel');
    Route::get('/Table67/excel', [Table67Controller::class, 'exportExcel'])->name('Table67.excel');
    Route::get('/Table68/excel', [Table68Controller::class, 'exportExcel'])->name('Table68.excel');
    Route::get('/Table69/excel', [Table69Controller::class, 'exportExcel'])->name('Table69.excel');
    Route::get('/Table70/excel', [Table70Controller::class, 'exportExcel'])->name('Table70.excel');
    Route::get('/Table71/excel', [Table71Controller::class, 'exportExcel'])->name('Table71.excel');
    Route::get('/neonatal/add', [NeonatalController::class, 'add'])->name('neonatal.add');
    Route::get('/IbuHamilDanBersalin/add', [IbuHamilDanBersalinController::class, 'add'])->name('IbuHamilDanBersalin.add');
    Route::get('/Kelahiran/add', [KelahiranController::class, 'add'])->name('Kelahiran.add');
    Route::get('/KesehatanBalita/add', [KesehatanBalitaController::class, 'add'])->name('KesehatanBalita.add');
    Route::get('/PesertaDidik/add', [PesertaDidikController::class, 'add'])->name('PesertaDidik.add');
    Route::get('/PelayananProduktif/add', [PelayananProduktifController::class, 'add'])->name('PelayananProduktif.add');
    Route::get('/PelayananLansia/add', [PelayananLansiaController::class, 'add'])->name('PelayananLansia.add');
    Route::get('/Tuberkulosis/add', [TuberkulosisController::class, 'add'])->name('Tuberkulosis.add');
    Route::get('/Hipertensi/add', [HipertensiController::class, 'add'])->name('Hipertensi.add');
    Route::get('/Diabetes/add', [DiabetesController::class, 'add'])->name('Diabetes.add');
    Route::get('/Kunjungan/add', [KunjunganController::class, 'add'])->name('Kunjungan.add');
    Route::get('/Odgj/add', [OdgjController::class, 'add'])->name('Odgj.add');
    Route::get('/JumlahKematianIbu/add', [JumlahKematianIbuController::class, 'add'])->name('JumlahKematianIbu.add');
    Route::get('/PenyebabKematianIbu/add', [PenyebabKematianIbuController::class, 'add'])->name('PenyebabKematianIbu.add');
    Route::get('/ImunBumil/add', [ImunBumilController::class, 'add'])->name('ImunBumil.add');
    Route::get('/WusTidakHamil/add', [WusTidakHamilController::class, 'add'])->name('WusTidakHamil.add');
    Route::get('/WusHamil/add', [WusHamilController::class, 'add'])->name('WusHamil.add');
    Route::get('/Ttd/add', [TtdController::class, 'add'])->name('Ttd.add');
    Route::get('/Pus/add', [PusController::class, 'add'])->name('Pus.add');
    Route::get('/KomplikasiBidan/add', [KomplikasiBidanController::class, 'add'])->name('KomplikasiBidan.add');
    Route::get('/KomplikasiNeonatal/add', [KomplikasiNeonatalController::class, 'add'])->name('KomplikasiNeonatal.add');
    Route::get('/KematianNeonatal/add', [KomplikasiNeonatalController::class, 'add'])->name('KematianNeonatal.add');
    Route::get('/PenyebabKematianNeonatal/add', [PenyebabKematianNeonatalController::class, 'add'])->name('PenyebabKematianNeonatal.add');
    Route::get('/PenyebabKematianBalita/add', [PenyebabKematianBalitaController::class, 'add'])->name('PenyebabKematianBalita.add');
    Route::get('/BblrPrematur/add', [BblrPrematurController::class, 'add'])->name('BblrPrematur.add');
    Route::get('/ImdAsi/add', [ImdAsiController::class, 'add'])->name('ImdAsi.add');
    Route::get('/PelayananBalita/add', [PelayananBalitaController::class, 'add'])->name('PelayananBalita.add');
    Route::get('/BalitaBcg/add', [BalitaBcgController::class, 'add'])->name('BalitaBcg.add');
    Route::get('/BayiImunisasi/add', [BayiImunisasiController::class, 'add'])->name('BayiImunisasi.add');
    Route::get('/BadutaImunisasi/add', [BadutaImunisasiController::class, 'add'])->name('BadutaImunisasi.add');
    Route::get('/BalitaVita/add', [BalitaVitaController::class, 'add'])->name('BalitaVita.add');
    Route::get('/Timbang/add', [TimbangController::class, 'add'])->name('Timbang.add');
    Route::get('/StatusGizi/add', [StatusGiziController::class, 'add'])->name('StatusGizi.add');
    Route::get('/Gigi/add', [GigiController::class, 'add'])->name('Gigi.add');
    Route::get('/GigiAnak/add', [GigiAnakController::class, 'add'])->name('GigiAnak.add');
    Route::get('/Catin/add', [CatinController::class, 'add'])->name('Catin.add');
    Route::get('/ObatTuberkulosis/add', [ObatTuberkulosisController::class, 'add'])->name('ObatTuberkulosis.add');
    Route::get('/Odhiv/add', [OdhivController::class, 'add'])->name('Odhiv.add');
    Route::get('/DeteksiDiniHepatitisBPIB/add', [DeteksiDiniHepatitisBPIBController::class, 'add'])->name('DeteksiDiniHepatitisBPIB.add');
    Route::get('/Table63/add', [Table63Controller::class, 'add'])->name('Table63.add');
    Route::get('/Table64/add', [Table64Controller::class, 'add'])->name('Table64.add');
    Route::get('/Table65/add', [Table65Controller::class, 'add'])->name('Table65.add');
    Route::get('/Table66/add', [Table66Controller::class, 'add'])->name('Table66.add');
    Route::get('/Table67/add', [Table67Controller::class, 'add'])->name('Table67.add');
    Route::get('/Table68/add', [Table68Controller::class, 'add'])->name('Table68.add');
    Route::get('/Table69/add', [Table69Controller::class, 'add'])->name('Table69.add');
    Route::get('/Table70/add', [Table70Controller::class, 'add'])->name('Table70.add');
    Route::get('/Table71/add', [Table71Controller::class, 'add'])->name('Table71.add');
    Route::get('/Table72/add', [Table72Controller::class, 'add'])->name('Table72.add');
    Route::get('/Table73/add', [Table73Controller::class, 'add'])->name('Table73.add');
    Route::get('/Table74/add', [Table74Controller::class, 'add'])->name('Table74.add');
    Route::get('/Table77/add', [Table77Controller::class, 'add'])->name('Table77.add');
    Route::get('/Table82/add', [Table82Controller::class, 'add'])->name('Table82.add');
    Route::get('/Table83/add', [Table83Controller::class, 'add'])->name('Table83.add');
    Route::get('/Table84/add', [Table84Controller::class, 'add'])->name('Table84.add');
    Route::get('/Table85/add', [Table85Controller::class, 'add'])->name('Table85.add');
    Route::get('/Table86/add', [Table86Controller::class, 'add'])->name('Table86.add');
    Route::get('/Table86/add', [Table87Controller::class, 'add'])->name('Table87.add');
    Route::get('/kesehatan_balita/report', [KesehatanBalitaController::class, 'report'])->name('kesehatan_balita.report');
    Route::get('/peserta_didik/report', [PesertaDidikController::class, 'report'])->name('peserta_didik.report');
    Route::get('/pelayanan_lansia/report', [PelayananLansiaController::class, 'report'])->name('pelayanan_lansia.report');
    Route::get('/pelayanan_produktif/report', [PelayananProduktifController::class, 'report'])->name('pelayanan_produktif.report');
    Route::get('/tuberkulosis/report', [TuberkulosisController::class, 'report'])->name('tuberkulosis.report');
    Route::get('/hipertensi/report', [HipertensiController::class, 'report'])->name('hipertensi.report');
    Route::get('/diabetes/report', [DiabetesController::class, 'report'])->name('diabetes.report');
    Route::get('/kunjungan/report', [KunjunganController::class, 'report'])->name('kunjungan.report');
    Route::get('/odgj/report', [OdgjController::class, 'report'])->name('odgj.report');


    Route::resource('pembayaran_telat', PembayaranTelatController::class);
    Route::resource('history_pesan', HistoryPesanController::class);
    Route::resource('history_email', HistoryEmailController::class);
    Route::resource('kategori_industri', KategoriIndustriController::class);
    Route::resource('pelunasan', PelunasanController::class);

    Route::resource('kategori_opd', KategoriOpdController::class);
    Route::post('/import_kategori_opd', [KategoriOpdController::class, 'import']);
    Route::get('/export_kategori_opd', [KategoriOpdController::class, 'export']);

    Route::resource('unit_organisasi', UnitOrganisasiController::class);
    Route::post('/import_unit_organisasi', [UnitOrganisasiController::class, 'import']);
    Route::get('/export_unit_organisasi', [UnitOrganisasiController::class, 'export']);

    Route::resource('jabatan', JabatanController::class);
    Route::post('/import_jabatan', [JabatanController::class, 'import']);
    Route::get('/export_jabatan', [JabatanController::class, 'export']);

    Route::resource('kegiatan', KegiatanController::class);
    Route::post('/import_kegiatan', [KegiatanController::class, 'import']);
    Route::get('/export_kegiatan', [KegiatanController::class, 'export']);

    Route::resource('sub_kegiatan', SubKegiatanController::class);
    Route::post('/import_sub_kegiatan', [SubKegiatanController::class, 'import']);
    Route::get('/export_sub_kegiatan', [SubKegiatanController::class, 'export']);

    Route::resource('sasaran_sub_kegiatan', sasaranSubKegiatanController::class);
    Route::resource('indikator_sub_kegiatan', indikatorSubKegiatanController::class);
    Route::resource('IbuHamil', IbuHamilDanBersalinController::class);
    Route::resource('unit_kerja', UnitKerjaController::class);
    Route::resource('desa', DesaController::class);
    Route::resource('kelahiran', KelahiranController::class);
    Route::resource('neonatal', NeonatalController::class);
    Route::resource('kesehatan_balita', KesehatanBalitaController::class);
    Route::resource('jumlah_penduduk', JumlahPendudukController::class);
    Route::resource('peserta_didik', PesertaDidikController::class);
    Route::resource('pelayanan_produktif', PelayananProduktifController::class);
    Route::resource('pelayanan_lansia', PelayananLansiaController::class);
    Route::resource('tuberkulosis', TuberkulosisController::class);
    Route::resource('hipertensi', HipertensiController::class);
    Route::resource('diabetes', DiabetesController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::resource('odgj', OdgjController::class);
    Route::resource('rumah_sakit', RumahSakitController::class);
    Route::resource('jaringan_puskesmas', JaringanPuskesmasController::class);
    Route::resource('sarana_pelayanan', SaranaPelayananController::class);
    Route::resource('sarana_produksi', SaranaProduksiController::class);
    Route::resource('data_posyandu', DataPosyanduController::class);
    Route::resource('tenaga_medis', TenagaMedisController::class);
    Route::resource('keperawatan', KeperawatanController::class);
    Route::resource('verifikasi', VerifikasiController::class);

    Route::resource('DetailWilayah', DetailWilayahController::class);
    Route::post('/import_DetailWilayah', [DetailWilayahController::class, 'import']);
    Route::get('/export_DetailWilayah', [DetailWilayahController::class, 'export']);


    Route::resource('pengelola_program', PengelolaProgramController::class);

    Route::resource('ObatEsensial', ObatEsensialController::class);
    Route::post('/import_ObatEsensial', [ObatEsensialController::class, 'import']);
    Route::get('/export_ObatEsensial', [ObatEsensialController::class, 'export']);

    Route::resource('KelompokUmur', KelompokUmurController::class);
    Route::post('/import_KelompokUmur', [KelompokUmurController::class, 'import']);
    Route::get('/export_KelompokUmur', [KelompokUmurController::class, 'export']);

    Route::resource('MelekHuruf', MelekHurufController::class);
    Route::post('/import_MelekHuruf', [MelekHurufController::class, 'import']);
    Route::get('/export_MelekHuruf', [MelekHurufController::class, 'export']);


    Route::resource('FasilitasKesehatan', FasilitasKesehatanController::class);
    Route::post('/import_FasilitasKesehatan', [FasilitasKesehatanController::class, 'import']);
    Route::get('/export_FasilitasKesehatan', [FasilitasKesehatanController::class, 'export']);

    Route::resource('GawatDaruratSatu', GawatDaruratSatuController::class);
    // Route::post('/import_GawatDaruratSatu', [GawatDaruratSatuController::class, 'import']);
    Route::get('/export_GawatDaruratSatu', [GawatDaruratSatuController::class, 'export']);

    Route::resource('AngkaKematian', AngkaKematianController::class);
    Route::post('/import_AngkaKematian', [AngkaKematianController::class, 'import']);
    Route::get('/export_AngkaKematian', [AngkaKematianController::class, 'export']);

    Route::resource('IndikatorKinerja', IndikatorKinerjaController::class);
    Route::post('/import_IndikatorKinerja', [IndikatorKinerjaController::class, 'import']);
    Route::get('/export_IndikatorKinerja', [IndikatorKinerjaController::class, 'export']);


    Route::resource('Obat', ObatController::class);
    Route::post('/import_Obat', [ObatController::class, 'import']);
    Route::get('/export_Obat', [ObatController::class, 'export']);


    Route::post('ObatNew', [ObatController::class, 'ObatNew'])->name('ObatNew');

    Route::resource('Vaksin', VaksinController::class);
    Route::post('/import_Vaksin', [VaksinController::class, 'import']);
    Route::get('/export_Vaksin', [VaksinController::class, 'export']);


    Route::post('VaksinNew', [VaksinController::class, 'VaksinNew'])->name('VaksinNew');

    Route::resource('JaminanKesehatan', JaminanKesehatanController::class);
    Route::post('/import_JaminanKesehatan', [JaminanKesehatanController::class, 'import']);
    Route::get('/export_JaminanKesehatan', [JaminanKesehatanController::class, 'export']);

    Route::resource('JumlahKematianIbu', JumlahKematianIbuController::class);
    Route::resource('PenyebabKematianIbu', PenyebabKematianIbuController::class);
    Route::resource('ImunBumil', ImunBumilController::class);
    Route::resource('WusTidakHamil', WusTidakHamilController::class);
    Route::resource('WusHamil', WusHamilController::class);
    Route::resource('Ttd', TtdController::class);
    Route::resource('Pus', PusController::class);
    Route::resource('Pus4T', Pus4TController::class);
    Route::resource('KbBersalin', KbBersalinController::class);
    Route::resource('KomplikasiBidan', KomplikasiBidanController::class);
    Route::resource('KomplikasiNeonatal', KomplikasiNeonatalController::class);
    Route::resource('KematianNeonatal', KematianNeonatalController::class);
    Route::resource('PenyebabKematianNeonatal', PenyebabKematianNeonatalController::class);
    Route::resource('PenyebabKematianBalita', PenyebabKematianBalitaController::class);
    Route::resource('BblrPrematur', BblrPrematurController::class);
    Route::resource('ImdAsi', ImdAsiController::class);
    Route::resource('PelayananBalita', PelayananBalitaController::class);
    Route::resource('BalitaBcg', BalitaBcgController::class);
    Route::resource('BayiImunisasi', BayiImunisasiController::class);
    Route::resource('BadutaImunisasi', BadutaImunisasiController::class);
    Route::resource('BalitaVita', BalitaVitaController::class);
    Route::resource('Timbang', TimbangController::class);
    Route::resource('StatusGizi', StatusGiziController::class);
    Route::resource('Gigi', GigiController::class);
    Route::resource('GigiAnak', GigiAnakController::class);
    Route::resource('Catin', CatinController::class);
    Route::resource('ObatTuberkulosis', ObatTuberkulosisController::class);
    Route::resource('Odhiv', OdhivController::class);

    Route::resource('DeteksiDiniHepatitisBPIB', DeteksiDiniHepatitisBPIBController::class);
    Route::resource('table_63', Table63Controller::class);
    Route::resource('table_64', Table64Controller::class);
    Route::resource('table_65', Table65Controller::class);
    Route::resource('table_66', Table66Controller::class);
    Route::resource('table_67', Table67Controller::class);
    Route::resource('table_68', Table68Controller::class);
    Route::resource('table_69', Table69Controller::class);
    Route::resource('table_70', Table70Controller::class);

    Route::resource('table_71', Table71Controller::class);
    Route::resource('table_72', Table72Controller::class);
    Route::resource('table_73', Table73Controller::class);
    Route::resource('table_74', Table74Controller::class);
    Route::resource('table_77', Table77Controller::class);

    Route::resource('table_82', Table82Controller::class);
    Route::resource('table_83', Table83Controller::class);
    Route::resource('table_84', Table84Controller::class);
    Route::resource('table_85', Table85Controller::class);
    Route::resource('table_86', Table86Controller::class);
    Route::resource('table_87', Table87Controller::class);


    Route::post('JaminanNew', [JaminanKesehatanController::class, 'JaminanNew'])->name('JaminanNew');
    Route::get('api/jabatan/{id}', [JabatanController::class, 'api']);
    Route::get('api/unit_kerja', [UnitKerjaController::class, 'api']);
    Route::get('api/sasaran_ibu_hamil/{id}', [SasaranIbuHamilController::class, 'api']);
    Route::get('apiAcc/sasaran_ibu_hamil/{id}', [SasaranIbuHamilController::class, 'apiAcc']);
    Route::get('apiReject/sasaran_ibu_hamil/{id}', [SasaranIbuHamilController::class, 'apiReject']);
    Route::post('apiCapaian/sasaran_ibu_hamil/{id}', [SasaranIbuHamilController::class, 'apiCapaian']);
    Route::get('api/desa', [DesaController::class, 'api']);
    Route::get('apiEdit/unit_kerja/{id}', [UnitKerjaController::class, 'apiEdit']);
    Route::post('upload/neonatal/', [NeonatalController::class, 'upload']);
    Route::post('upload/IbuHamil/', [IbuHamilDanBersalinController::class, 'upload']);
    Route::post('upload/wus_tidak_hamil/', [WusTidakHamilController::class, 'upload']);
    Route::post('upload/general/', [FileController::class, 'upload']);
    Route::post('lock/general/', [FileController::class, 'lock'])->name('general.lock');
    Route::post('lock/general2/', [FileController::class, 'lock2'])->name('general2.lock');
    Route::post('lock/wus_tidak_hamil/', [WusHamilController::class, 'lock'])->name('wus_hamil.lock');
    Route::get('neonatal/detail_desa/{id}', [NeonatalController::class, 'detail_desa']);
    Route::get('IbuHamil/detail_desa/{id}', [IbuHamilDanBersalinController::class, 'detail_desa']);
    Route::get('wus_tidak_hamil/detail_desa/{id}', [WusTidakHamilController::class, 'detail_desa']);
    Route::get('wus_hamil/detail_desa/{id}', [WusHamilController::class, 'detail_desa']);
    Route::get('general/detail_desa/{id}', [FileController::class, 'detail_desa']);
    Route::get('general2/detail_desa/{id}', [FileController::class, 'detail_desa2']);
    Route::get('apiEdit/desa/{id}', [DesaController::class, 'apiEdit']);
    Route::get('apiEdit/pengelola_program/{id}', [PengelolaProgramController::class, 'apiEdit']);
    Route::get('apiEdit/IbuHamil/{id}', [IbuHamilDanBersalinController::class, 'apiEdit']);
    Route::post('apiLock/IbuHamil', [IbuHamilDanBersalinController::class, 'apiLock'])->name('IbuHamil.lock');
    Route::post('apiLock/Kelahiran', [KelahiranController::class, 'apiLock'])->name('Kelahiran.lock');
    Route::post('apiLock/neonatal', [NeonatalController::class, 'apiLock'])->name('Neonatal.lock');
    Route::post('apiLock/wus_tidak_hamil', [WusTidakHamilController::class, 'lock'])->name('wus_tidak_hamil.lock');
    Route::post('apiLockUpload/neonatal', [NeonatalController::class, 'apiLockUpload'])->name('Neonatal.lock_upload');
    Route::post('apiLockUpload/neonatal', [WusTidakHamilController::class, 'apiLockUpload'])->name('wus_tidak_hamil.lock_upload');
    Route::post('apiLockUpload/wus_tidak_hamil', [FileController::class, 'apiLockUpload'])->name('general.lock_upload');
    Route::post('apiLockUpload/IbuHamil', [IbuHamilDanBersalinController::class, 'apiLockUpload'])->name('IbuHamil.lock_upload');
    Route::post('apiLock/resume', [ResumeController::class, 'apiLock'])->name('resume.lock');
    Route::post('apiLock/kesehatanBalita', [KesehatanBalitaController::class, 'apiLock'])->name('KesehatanBalita.lock');
    Route::post('apiLock/PesertaDidik', [PesertaDidikController::class, 'apiLock'])->name('PesertaDidik.lock');
    Route::post('apiLock/PelayananProduktif', [PelayananProduktifController::class, 'apiLock'])->name('PelayananProduktif.lock');
    Route::post('apiLock/PelayananLansia', [PelayananLansiaController::class, 'apiLock'])->name('PelayananLansia.lock');
    Route::post('apiLock/Tuberkulosis', [TuberkulosisController::class, 'apiLock'])->name('Tuberkulosis.lock');
    Route::post('apiLock/Hipertensi', [HipertensiController::class, 'apiLock'])->name('Hipertensi.lock');
    Route::post('apiLock/Diabetes', [DiabetesController::class, 'apiLock'])->name('Diabetes.lock');
    Route::post('apiLock/Kunjungan', [KunjunganController::class, 'apiLock'])->name('Kunjungan.lock');
    Route::post('apiLock/Odgj', [OdgjController::class, 'apiLock'])->name('Odgj.lock');
    Route::get('api/pemangku/{id}', [PemangkuController::class, 'api']);
    Route::get('apiEdit/jabatan/{id}', [JabatanController::class, 'apiEdit']);
    Route::get('apiEdit/biomedika/{id}', [KategoriOpdController::class, 'apiEdit']);
    Route::get('apiEdit/kesehatanMasyarakat/{id}', [UnitOrganisasiController::class, 'apiEdit']);
    Route::get('apiEdit/penunjang/{id}', [KegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/program/{id}', [ProgramController::class, 'apiEdit']);
    Route::get('apiEdit/sasaranProgram/{id}', [SasaranProgramController::class, 'apiEdit']);
    Route::get('apiEdit/sasaranKegiatan/{id}', [SasaranKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/sasaran_sub_kegiatan/{id}', [SasaranSubKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/indikatorProgram/{id}', [IndikatorProgramController::class, 'apiEdit']);
    Route::get('apiEdit/indikatorKegiatan/{id}', [IndikatorKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/indikator_sub_kegiatan/{id}', [indikatorSubKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/kegiatan/{id}', [KegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/sub_kegiatan/{id}', [SubKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/visi_rpjmd/{id}', [VisiRpjmdController::class, 'apiEdit']);
    Route::get('apiEdit/misi_rpjmd/{id}', [MisiRpjmdController::class, 'apiEdit']);
    Route::get('apiEdit/tujuan_rpjmd/{id}', [TujuanRpjmdController::class, 'apiEdit']);
    Route::get('apiEdit/sasaran_rpjmd/{id}', [SasaranRpjmdController::class, 'apiEdit']);
    Route::get('apiEdit/visi_renstra/{id}', [VisiRenstraController::class, 'apiEdit']);
    Route::get('apiEdit/tujuan_renstra/{id}', [TujuanRenstraController::class, 'apiEdit']);
    Route::get('apiEdit/sasaran_renstra/{id}', [SasaranRenstraController::class, 'apiEdit']);
    Route::get('apiEdit/misi_renstra/{id}', [VisiRenstraController::class, 'apiEditMisi']);
    Route::get('apiEdit/merujuk_rpjmd/{id}', [VisiRenstraController::class, 'apiEditRpjmd']);
    Route::get('apiEdit/tidak_merujuk_rpjmd/{id}', [VisiRenstraController::class, 'apiEditNonRpjmd']);
    Route::get('apiEdit/indikator_pemerintah/{id}', [IndikatorPemerintahController::class, 'apiEdit']);
    Route::get('apiEdit/indikator_opd/{id}', [IndikatorOpdController::class, 'apiEdit']);
    Route::get('apiEdit/detail_indikator_program/{id}', [detailIndikatorProgramController::class, 'apiEdit']);
    Route::get('apiEdit/detail_indikator_kegiatan/{id}', [detailIndikatorKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/detail_indikator_sub_kegiatan/{id}', [DetailIndikatorSubKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/program_kegiatan/{id}', [ProgramDanKegiatanController::class, 'apiEdit']);
    Route::get('apiEdit/pagu_anggaran/{id}', [PaguAnggaranController::class, 'apiEdit']);
    Route::get('apiEdit/target_kerja_pemerintah/{id}', [TargetKerjaController::class, 'apiEdit']);
    Route::get('apiEdit/target_kerja_opd/{id}', [TargetKerjaController::class, 'apiEditOpd']);
    Route::get('apiEdit/hasilSasaran/{id}', [LaporanKeselarasanController::class, 'apihasilSasaran']);
    Route::get('apiEdit/indikatorOpdBerkualitas/{id}', [LaporanKeselarasanController::class, 'apiIndikatorOpdBerkualitas']);
    Route::get('apiEdit/indikatorPemerintahBerkualitas/{id}', [LaporanKeselarasanController::class, 'apiIndikatorPemerintahBerkualitas']);
    Route::get('apiEdit/ikurenstra/{id}', [LaporanKeselarasanController::class, 'ikurenstra']);
    Route::get('apiSasaran/sasaran_kegiatan/{id}', [ProgramDanKegiatanController::class, 'apiSasaranKegiatan']);
    Route::get('apiSasaran/sasaran_sub_kegiatan/{id}', [ProgramDanKegiatanController::class, 'apiSasaranSubKegiatan']);
    Route::get('apiSasaran/sasaran_program/{id}', [ProgramDanKegiatanController::class, 'apiSasaran']);
    Route::get('apiKegiatan/program_kegiatan/{id}', [ProgramDanKegiatanController::class, 'apiKegiatan']);
    Route::get('apiProgram/kegiatan/{id}', [KegiatanController::class, 'apiProgram']);
    Route::get('apiKegiatan/sub_kegiatan/{id}', [SubKegiatanController::class, 'apiKegiatan']);
    Route::get('home/filterTahun/{id}', [HomeController::class, 'filterTahun']);
    Route::get('apiKegiatan/sub_kegiatan_detail/{id}', [ProgramDanKegiatanController::class, 'apiSubKegiatan']);
    // Route::get('neonatal/neonatalExcel', [NeonatalController::class, 'exportExcel'])->name("neonatal.excel");
    Route::resource('indikatorProgram', IndikatorProgramController::class);
    Route::resource('detail_indikator_program', detailIndikatorProgramController::class);
    Route::resource('detail_indikator_kegiatan', detailIndikatorKegiatanController::class);
    Route::resource('detail_indikator_sub_kegiatan', DetailIndikatorSubKegiatanController::class);
    Route::resource('detail_kegiatan', detailKegiatanController::class);
    Route::resource('detail_program', detailProgramController::class);
    Route::resource('detail_sub_kegiatan', DetailSubKegiatanController::class);
    Route::resource('indikator_pemerintah', IndikatorPemerintahController::class);
    Route::resource('indikator_opd', IndikatorOpdController::class);
    Route::resource('program_dan_kegiatan', ProgramDanKegiatanController::class);
    Route::resource('target_kerja', TargetKerjaController::class);
    Route::resource('capaian_kerja', CapaianKerjaController::class);
    Route::resource('pagu_anggaran', PaguAnggaranController::class);
    Route::resource('realisasi_anggaran', RealisasiAnggaranController::class);
    Route::resource('cascading_rpjmd', CascadingRpjmdController::class);
    Route::resource('cascading_renstra', CascadingRenstraController::class);
    Route::resource('pohon_kerja_pemerintah', PohonKerjaPemerintahController::class);
    Route::resource('pohon_kerja_opd', PohonKerjaOpdController::class);
    Route::resource('laporan_keselarasan', LaporanKeselarasanController::class);
    Route::resource('laporan_renstra', LaporanRenstraController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('indikatorKegiatan', IndikatorKegiatanController::class);
    Route::resource('sasaranProgram', SasaranProgramController::class);
    Route::resource('sasaranKegiatan', SasaranKegiatanController::class);
    Route::resource('visi_rpjmd', VisiRpjmdController::class);
    Route::resource('misi_rpjmd', MisiRpjmdController::class);
    Route::resource('visi_renstra', VisiRenstraController::class);
    Route::resource('tujuan_renstra', TujuanRenstraController::class);
    Route::resource('sasaran_renstra', SasaranRenstraController::class);
    Route::resource('tujuan_rpjmd', TujuanRpjmdController::class);
    Route::resource('sasaran_rpjmd', SasaranRpjmdController::class);
    Route::resource('jenis-denda',DendaController::class);
    Route::resource('pemangku', PemangkuController::class);
    Route::post('/import_pemangku', [PemangkuController::class, 'import']);

    Route::resource('verified', VerifiedController::class);

    Route::post('va/{id}', [TagihanController::class, 'va'])->name('req.va');
    Route::post('qris/{id}', [TagihanController::class, 'qris']);

    // Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('profile', [ProfileController::class,'index'])->name('profile.index');
    Route::post('profile/update', [ProfileController::class,'update'])->name('profile.update');

    Route::get('total', [LaporanController::class, 'total'])->name('laporan.total');
    Route::get('kirim_pesan/{id}', [HistoryPesanController::class,'kirim_pesan'])->name('kirim_pesan');
    Route::get('kirim_pesan_terlambat', [HistoryPesanController::class, 'kirim_pesan_terlambat'])->name('kirim_pesan_terlambat');
    Route::group(['prefix'=>'datatable','as'=>'datatable.'],function()use($ctrl){
        Route::get('user',[UserController::class,'datatable'])->name('user');
        Route::get('pelanggan',[PelangganController::class,'datatable'])->name('pelanggan');
        Route::get('upt_daerah', [KategoriOpdController::class,'datatable'])->name('upt_daerah');
        Route::get('pemangku', [PemangkuController::class, 'datatable'])->name('pemangku');
        Route::get('laporan_perjanjian_kinerja', [LaporanPerjanjianKinerjaController::class, 'datatable'])->name('laporan_perjanjian_kinerja');
        Route::get('jabatan', [JabatanController::class,'datatable'])->name('jabatan');
        Route::get('keselarasan', [LaporanKeselarasanController::class,'datatable'])->name('keselarasan');
        Route::get('jenis-denda',[DendaController::class,'datatable'])->name('jenis_denda');
        Route::get("antrian", [AntrianController::class, 'datatable'])->name("antrian");
        Route::get("template_email", [TemplateEmailController::class, 'datatable'])->name("template_email");
        Route::get("history_email", [HistoryEmailController::class, 'datatable'])->name("history_email");
        Route::get("log", [LogController::class, 'datatable'])->name("log");
        Route::get("surat", [SuratController::class, 'datatable'])->name("surat");
        Route::get("lunas", [LunasController::class, 'datatable'])->name("lunas");
        Route::get("penetapan", [PenetapanController::class, 'datatable'])->name("penetapan");
        Route::get("program", [ProgramController::class, 'datatable'])->name("program");
        Route::get("kegiatan", [KegiatanController::class, 'datatable'])->name("kegiatan");
        Route::get("sub_kegiatan", [SubKegiatanController::class, 'datatable'])->name("sub_kegiatan");
        Route::get("visi_rpjmd", [VisiRpjmdController::class, 'datatable'])->name("visi_rpjmd");
        Route::get("jabatan", [JabatanController::class, 'datatable'])->name("jabatan");
        Route::get("PembayaranPelanggan", [PembayaranPelangganController::class, 'datatable'])->name("PembayaranPelanggan");
    });

    Route::group(['prefix'=>'cek_tagihan','as'=>'cek_tagihan.'],function()use($ctrl){
        Route::get('tagihan',[CekTagihanController::class,'tagihan'])->name('tagihan');
        Route::get('tagihan_pemasangan',[CekTagihanController::class,'tagihan_pemasangan'])->name('tagihan_pemasangan');
    });

    Route::group(['prefix'=>'laporan','as'=>'laporan.'],function()use($ctrl){
        Route::get('pembayaran',[LaporanController::class,'pembayaran'])->name('pembayaran');
        Route::get('pembayaran_pemasangan',[LaporanController::class,'pembayaran_pemasangan'])->name('pembayaran_pemasangan');
        Route::get('pelanggan',[LaporanController::class,'pelanggan'])->name('pelanggan');
        Route::get('tagihan',[LaporanController::class,'tagihan'])->name('tagihan');
        Route::get('kategori',[LaporanController::class,'kategori'])->name('kategori');
        Route::get('tagihan_pemasangan',[LaporanController::class,'tagihan_pemasangan'])->name('tagihan_pemasangan');
    });



});

require __DIR__.'/auth.php';
