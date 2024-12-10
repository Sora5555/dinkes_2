<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama', 'induk_opd_id', 'tipe', 'luas_wilayah', 'kelurahan', 'jumlah_penduduk', 'jumlah_rumah_tangga', 'kecamatan'
    ];

    public function User(){
        return $this->hasOne(User::class);
    }
    public function ObatEsensial(){
        return $this->hasOne(ObatEsensial::class);
    }
    public function DokterSpesialis(){
        return $this->hasMany(DokterSpesialis::class);
    }
    public function Dokter(){
        return $this->hasMany(Dokter::class);
    }
    public function DokterGigi(){
        return $this->hasMany(DokterGigi::class);
    }
    public function DokterGigiSpesialis(){
        return $this->hasMany(DokterGigiSpesialis::class);
    }
    public function Perawat(){
        return $this->hasMany(Perawat::class);
    }
    public function Bidan(){
        return $this->hasMany(Bidan::class);
    }
    public function TenagaKesehatanMasyarakat(){
        return $this->hasMany(TenagaKesehatanMasyarakat::class);
    }
    public function TenagaKesehatanLingkungan(){
        return $this->hasMany(TenagaKesehatanLingkungan::class);
    }
    public function TenagaGizi(){
        return $this->hasMany(TenagaGizi::class);
    }
    public function AhliLabMedik(){
        return $this->hasMany(AhliLabMedik::class);
    }

    public function TenagaTeknikBiomedik(){
        return $this->hasMany(TenagaTeknikBiomedik::class);
    }
    public function TenagaTeknikFarmasi(){
        return $this->hasMany(TenagaTeknisFarmasi::class);
    }
    public function TerapiFisik(){
        return $this->hasMany(TerapiFisik::class);
    }
    public function KeteknisanMedik(){
        return $this->hasMany(KeteknisanMedik::class);
    }
    public function Apoteker(){
        return $this->hasMany(Apoteker::class);
    }
    public function PejabatStruktural(){
        return $this->hasMany(PejabatStruktural::class);
    }
    public function TenagaPendidik(){
        return $this->hasMany(TenagaPendidik::class);
    }
    public function Manajemen(){
        return $this->hasMany(Manajemen::class);
    }
    public function Posyandu(){
        return $this->hasMany(Posyandu::class);
    }
    public function desa(){
        return $this->hasMany(Desa::class);
    }

    public function detail_desa(){
        return $this->hasMany(Desa::class);
    }
    public function k1($year = null){
        $desa = $this->Desa()->get();
        $k1 = 0;
        foreach ($desa as $key => $value) {
            # code...
            $k1 += $value->filterDesa($year)?$value->filterDesa($year)->k1:0;
        }
        return $k1;
    }
    public function check_lock($table){
        $lock = $table::first();
        return $lock->status;
    }
    public function k4($year = null){
        $desa = $this->Desa()->get();
        $k4 = 0;
        foreach ($desa as $key => $value) {
            # code...
            $k4 += $value->filterSasaranTahunDesa($year)?$value->filterSasaranTahunDesa($year)->total_capaian():0;
        }
        return $k4;
    }
    public function k6($year = null){
        $desa = $this->Desa()->get();
        $k6 = 0;
        foreach ($desa as $key => $value) {
            # code...
            $k6 += $value->filterDesa($year)?$value->filterDesa($year)->k6:0;
        }
        return $k6;
    }
    public function fasyankes($year = null){
        $desa = $this->Desa()->get();
        $fasyankes = 0;
        foreach ($desa as $key => $value) {
            # code...
            $fasyankes += $value->filterDesa($year)?$value->filterDesa($year)->fasyankes:0;
        }
        return $fasyankes;
    }
    public function kf1($year = null){
        $desa = $this->Desa()->get();
        $kf1 = 0;
        foreach ($desa as $key => $value) {
            # code...
            $kf1 += $value->filterDesa($year)?$value->filterDesa($year)->kf1:0;
        }
        return $kf1;
    }
    public function kf_lengkap($year = null){
        $desa = $this->Desa()->get();
        $kf_lengkap = 0;
        foreach ($desa as $key => $value) {
            # code...
            $kf_lengkap += $value->filterDesa($year)?$value->filterDesa($year)->kf_lengkap:0;
        }
        return $kf_lengkap;
    }
    public function vita($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterDesa($year)?$value->filterDesa($year)->vita:0;
        }
        return $vita;
    }
    public static function totalForAllUnitKerja($year = null, $namaFilter, $atribut)
    {
    // Fetch all unitKerja records
    $allUnitKerja = self::all();

    $total = 0;
    foreach ($allUnitKerja as $unit) {
        // Call the `admin_total` function on each unitKerja instance and add it to the total
        $total += $unit->admin_total($year, $namaFilter, $atribut);
    }

    return $total;
    }
    public static function totalAtribut($atribut)
    {
    // Fetch all unitKerja records
    $allUnitKerja = self::all();

    $total = 0;
    foreach ($allUnitKerja as $unit) {
        // Call the `admin_total` function on each unitKerja instance and add it to the total
        $total += $unit->$atribut;
    }

    return $total;
    }

    public function admin_total($year = null, $namaFilter, $atribut){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->$namaFilter($year)?$value->$namaFilter($year)->$atribut:0;
        }
        return $vita;
    }
    public function lahir_hidup_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKelahiran($year)?$value->filterKelahiran($year)->lahir_hidup_L:0;
        }
        return $vita;
    }
    public function lahir_hidup_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKelahiran($year)?$value->filterKelahiran($year)->lahir_hidup_P:0;
        }
        return $vita;
    }
    public function kn1_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->kn1_L:0;
        }
        return $vita;
    }
    public function kn1_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->kn1_P:0;
        }
        return $vita;
    }
    public function kn_lengkap_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->kn_lengkap_L:0;
        }
        return $vita;
    }
    public function kn_lengkap_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->kn_lengkap_P:0;
        }
        return $vita;
    }
    public function hipo_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->hipo_L:0;
        }
        return $vita;
    }
    public function hipo_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterNeonatal($year)?$value->filterNeonatal($year)->hipo_P:0;
        }
        return $vita;
    }
    public function balita_0_59($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_0_59:0;
        }
        return $vita;
    }
    public function balita_12_59($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_12_59:0;
        }
        return $vita;
    }
    public function balita_kia($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_kia:0;
        }
        return $vita;
    }
    public function balita_dipantau($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_dipantau:0;
        }
        return $vita;
    }
    public function balita_sdidtk($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_sdidtk:0;
        }
        return $vita;
    }
    public function balita_mtbs($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKesehatanBalita($year)?$value->filterKesehatanBalita($year)->balita_mtbs:0;
        }
        return $vita;
    }
    public function jumlah_kelas_1($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_kelas_1:0;
        }
        return $vita;
    }
    public function pelayanan_kelas_1($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_kelas_1:0;
        }
        return $vita;
    }
    public function jumlah_kelas_7($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_kelas_7:0;
        }
        return $vita;
    }
    public function pelayanan_kelas_7($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_kelas_7:0;
        }
        return $vita;
    }
    public function jumlah_kelas_10($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_kelas_10:0;
        }
        return $vita;
    }
    public function pelayanan_kelas_10($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_kelas_10:0;
        }
        return $vita;
    }
    public function jumlah_usia_dasar($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_usia_dasar:0;
        }
        return $vita;
    }
    public function pelayanan_usia_dasar($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_usia_dasar:0;
        }
        return $vita;
    }
    public function jumlah_sd($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_sd:0;
        }
        return $vita;
    }
    public function pelayanan_sd($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_sd:0;
        }
        return $vita;
    }
    public function jumlah_smp($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_smp:0;
        }
        return $vita;
    }
    public function pelayanan_smp($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_smp:0;
        }
        return $vita;
    }
    public function jumlah_sma($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->jumlah_sma:0;
        }
        return $vita;
    }
    public function pelayanan_sma($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPesertaDidik($year)?$value->filterPesertaDidik($year)->pelayanan_sma:0;
        }
        return $vita;
    }
    public function jumlah_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->jumlah_L:0;
        }
        return $vita;
    }
    public function jumlah_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->jumlah_P:0;
        }
        return $vita;
    }
    public function standar_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->standar_L:0;
        }
        return $vita;
    }
    public function standar_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->standar_P:0;
        }
        return $vita;
    }
    public function risiko_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->risiko_L:0;
        }
        return $vita;
    }
    public function risiko_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananProduktif($year)?$value->filterPelayananProduktif($year)->risiko_P:0;
        }
        return $vita;
    }
    public function jumlah_lansia_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananLansia($year)?$value->filterPelayananLansia($year)->jumlah_L:0;
        }
        return $vita;
    }
    public function jumlah_lansia_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananLansia($year)?$value->filterPelayananLansia($year)->jumlah_P:0;
        }
        return $vita;
    }
    public function standar_lansia_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananLansia($year)?$value->filterPelayananLansia($year)->standar_L:0;
        }
        return $vita;
    }
    public function standar_lansia_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterPelayananLansia($year)?$value->filterPelayananLansia($year)->standar_P:0;
        }
        return $vita;
    }
    public function terduga_kasus($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterTuberkulosis($year)?$value->filterTuberkulosis($year)->terduga_kasus:0;
        }
        return $vita;
    }
    public function kasus_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterTuberkulosis($year)?$value->filterTuberkulosis($year)->kasus_L:0;
        }
        return $vita;
    }
    public function kasus_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterTuberkulosis($year)?$value->filterTuberkulosis($year)->kasus_P:0;
        }
        return $vita;
    }
    public function kasus_LP($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterTuberkulosis($year)?$value->filterTuberkulosis($year)->kasus_LP:0;
        }
        return $vita;
    }
    public function kasus_anak($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterTuberkulosis($year)?$value->filterTuberkulosis($year)->kasus_anak:0;
        }
        return $vita;
    }
    public function jumlah_hipertensi_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterHipertensi($year)?$value->filterHipertensi($year)->jumlah_L:0;
        }
        return $vita;
    }
    public function jumlah_hipertensi_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterHipertensi($year)?$value->filterHipertensi($year)->jumlah_P:0;
        }
        return $vita;
    }
    public function pelayanan_hipertensi_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterHipertensi($year)?$value->filterHipertensi($year)->pelayanan_L:0;
        }
        return $vita;
    }
    public function pelayanan_hipertensi_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterHipertensi($year)?$value->filterHipertensi($year)->pelayanan_P:0;
        }
        return $vita;
    }
    public function jumlah_diabetes($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterDiabetes($year)?$value->filterDiabetes($year)->jumlah:0;
        }
        return $vita;
    }
    public function pelayanan_diabetes($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterDiabetes($year)?$value->filterDiabetes($year)->pelayanan:0;
        }
        return $vita;
    }
    public function skizo_0($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->skizo_0:0;
        }
        return $vita;
    }
    public function skizo_15($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->skizo_15:0;
        }
        return $vita;
    }
    public function skizo_60($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->skizo_60:0;
        }
        return $vita;
    }
    public function psiko_0($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->psiko_0:0;
        }
        return $vita;
    }
    public function psiko_15($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->psiko_15:0;
        }
        return $vita;
    }
    public function psiko_60($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->psiko_60:0;
        }
        return $vita;
    }
    public function jiwa_L($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKunjungan($year)?$value->filterKunjungan($year)->jiwa_L:0;
        }
        return $vita;
    }
    public function jiwa_P($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterKunjungan($year)?$value->filterKunjungan($year)->jiwa_P:0;
        }
        return $vita;
    }
    public function sasaran_odgj($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterOdgj($year)?$value->filterOdgj($year)->sasaran:0;
        }
        return $vita;
    }
    public function jumlah_ibu_hamil($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterDesa($year)?$value->filterDesa($year)->jumlah_ibu_hamil:0;
        }
        return $vita;
    }
    public function wus_tidak_hamil_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterWus($year, 0)){
                $status = $value->filterWus($year, 0)->status;
            }
        }
        return $status;
    }
    public function wus_hamil_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterWus($year, 1)){
                $status = $value->filterWus($year, 1)->status;
            }
        }
        return $status;
    }
    public function lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterDesa($year)){
                $status = $value->filterDesa($year)->status;
            }
        }
        return $status;
    }
    public function kelahiran_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKelahiran($year)){
                $status = $value->filterKelahiran($year)->status;
            }
        }
        return $status;
    }
    public function neonatal_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterNeonatal($year)){
                $status = $value->filterNeonatal($year)->status;
            }
        }
        return $status;
    }
    public function kesehatan_balita_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKesehatanBalita($year)){
                $status = $value->filterKesehatanBalita($year)->status;
            }
        }
        return $status;
    }
    public function peserta_didik_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPesertaDidik($year)){
                $status = $value->filterPesertaDidik($year)->status;
            }
        }
        return $status;
    }
    public function pelayanan_produktif_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPelayananProduktif($year)){
                $status = $value->filterPelayananProduktif($year)->status;
            }
        }
        return $status;
    }
    public function pelayanan_lansia_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPelayananLansia($year)){
                $status = $value->filterPelayananLansia($year)->status;
            }
        }
        return $status;
    }
    public function tuberkulosis_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterTuberkulosis($year)){
                $status = $value->filterTuberkulosis($year)->status;
            }
        }
        return $status;
    }
    public function hipertensi_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterHipertensi($year)){
                $status = $value->filterHipertensi($year)->status;
            }
        }
        return $status;
    }
    public function diabetes_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterDiabetes($year)){
                $status = $value->filterDiabetes($year)->status;
            }
        }
        return $status;
    }
    public function kunjungan_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKunjungan($year)){
                $status = $value->filterKunjungan($year)->status;
            }
        }
        return $status;
    }
    public function odgj_lock_get($year = null){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterOdgj($year)){
                $status = $value->filterOdgj($year)->status;
            }
        }
        return $status;
    }
    public function general_lock_get($year = null, $namaFilter){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->{$namaFilter}($year)){
                $status = $value->{$namaFilter}($year)->status;
            }
        }
        return $status;
    }
    public function general_lock_get2($year = null, $namaFilter){
        $desa = $this->Desa()->get();
        $status = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->{$namaFilter}($year, $value->id)){
                $status = $value->{$namaFilter}($year, $value->id)->status;
            }
        }
        return $status;
    }
    public function lock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterDesa($year)){
                    $value->filterDesa($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterDesa($year)){
                    $value->filterDesa($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function KelahiranLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterKelahiran($year)){
                    $value->filterKelahiran($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterKelahiran($year)){
                    $value->filterKelahiran($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function NeonatalLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterNeonatal($year)){
                    $value->filterNeonatal($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterNeonatal($year)){
                    $value->filterNeonatal($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function WusTidakHamilLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterWus($year, 0)){
                    $value->filterWus($year, 0)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterWus($year, 0)){
                    $value->filterWus($year, 0)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function WusHamilLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterWus($year, 1)){
                    $value->filterWus($year, 1)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterWus($year, 1)){
                    $value->filterWus($year, 1)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function KesehatanBalitaLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterKesehatanBalita($year)){
                    $value->filterKesehatanBalita($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterKesehatanBalita($year)){
                    $value->filterKesehatanBalita($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function PesertaDidikLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterPesertaDidik($year)){
                    $value->filterPesertaDidik($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterPesertaDidik($year)){
                    $value->filterPesertaDidik($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function PelayananProduktifLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterPelayananProduktif($year)){
                    $value->filterPelayananProduktif($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterPelayananProduktif($year)){
                    $value->filterPelayananProduktif($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function PelayananLansiaLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterPelayananLansia($year)){
                    $value->filterPelayananLansia($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterPelayananLansia($year)){
                    $value->filterPelayananLansia($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function TuberkulosisLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterTuberkulosis($year)){
                    $value->filterTuberkulosis($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterTuberkulosis($year)){
                    $value->filterTuberkulosis($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function HipertensiLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterHipertensi($year)){
                    $value->filterHipertensi($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterHipertensi($year)){
                    $value->filterHipertensi($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function DiabetesLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterDiabetes($year)){
                    $value->filterDiabetes($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterDiabetes($year)){
                    $value->filterDiabetes($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function KunjunganLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterKunjungan($year)){
                    $value->filterKunjungan($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterKunjungan($year)){
                    $value->filterKunjungan($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function OdgjLock($year = null, $status){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->filterOdgj($year)){
                    $value->filterOdgj($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->filterOdgj($year)){
                    $value->filterOdgj($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function GeneralLock($year = null, $status, $namaFilter){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->{$namaFilter}($year)){
                    $value->{$namaFilter}($year)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->{$namaFilter}($year)){
                    $value->{$namaFilter}($year)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function GeneralLock2($year = null, $status, $namaFilter){
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value) {
            # code...
            if($status == 1){
                if($value->{$namaFilter}($year, $value->id)){
                    $value->{$namaFilter}($year, $value->id)->update([
                        'status' => 1,
                    ]);
                } else {
                    continue;
                }
            } else {
                if($value->{$namaFilter}($year, $value->id)){
                    $value->{$namaFilter}($year, $value->id)->update([
                        'status' => 0,
                    ]);
                } else {
                    continue;
                }
            }
        }
        return 1;
    }
    public function jumlah_ibu_bersalin($year = null){
        $desa = $this->Desa()->get();
        $vita = 0;
        foreach ($desa as $key => $value) {
            # code...
            $vita += $value->filterDesa($year)?$value->filterDesa($year)->jumlah_ibu_bersalin:0;
        }
        return $vita;
    }

    public function kelahiran_per_desa($year = null){
        $desa = $this->Desa()->get();
        $lahir_hidup_L = 0;
        $lahir_mati_L = 0;
        $lahir_hidup_P = 0;
        $lahir_mati_P = 0;
        $lahir_hidup_LP = 0;
        $lahir_mati_LP = 0;
        $lahir_hidup_mati_LP = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKelahiran($year)){
                $lahir_hidup_L += $value->filterKelahiran($year)->lahir_hidup_L;
                $lahir_mati_L += $value->filterKelahiran($year)->lahir_mati_L;
                $lahir_hidup_P += $value->filterKelahiran($year)->lahir_hidup_P;
                $lahir_mati_P += $value->filterKelahiran($year)->lahir_mati_P;
                $lahir_hidup_LP += $value->filterKelahiran($year)->lahir_hidup_L + $value->filterKelahiran($year)->lahir_hidup_P;
                $lahir_mati_LP += $value->filterKelahiran($year)->lahir_mati_L + $value->filterKelahiran($year)->lahir_mati_P;
                $lahir_hidup_mati_LP += $value->filterKelahiran($year)->lahir_mati_L + $value->filterKelahiran($year)->lahir_mati_P + $value->filterKelahiran($year)->lahir_hidup_L + $value->filterKelahiran($year)->lahir_hidup_P;

            }
        }
        return compact('lahir_hidup_L', 'lahir_mati_L', 'lahir_hidup_P', 'lahir_mati_P', 'lahir_hidup_LP', 'lahir_mati_LP', 'lahir_hidup_mati_LP');
    }
    public function neonatal_per_desa($year = null){
        $desa = $this->Desa()->get();
        $kn1_L = 0;
        $kn1_P = 0;
        $jumlah_kn1_LP = 0;
        $persen_kn1_LP = 0;
        $kn_lengkap_P = 0;
        $kn_lengkap_L = 0;
        $jumlah_kn_lengkap_LP = 0;
        $persen_kn_lengkap_LP = 0;
        $hipo_L = 0;
        $hipo_P = 0;
        $jumlah_hipo_LP = 0;
        $persen_hipo_LP = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterNeonatal($year)){
                $kn1_L += $value->filterNeonatal($year)->kn1_L;
            $kn1_P += $value->filterNeonatal($year)->kn1_P;
            $kn_lengkap_L += $value->filterNeonatal($year)->kn_lengkap_L;
            $kn_lengkap_P += $value->filterNeonatal($year)->kn_lengkap_P;
            $hipo_L += $value->filterNeonatal($year)->hipo_L;
            $hipo_P += $value->filterNeonatal($year)->hipo_L;
            }


        }
        return compact('kn1_L', 'kn1_P', 'kn_lengkap_L', 'kn_lengkap_P', 'hipo_L', 'hipo_P');
    }
    public function kesehatan_balita_per_desa($year = null){
        $desa = $this->Desa()->get();
        $balita_0_59 = 0;
        $balita_12_59 = 0;
        $balita_kia = 0;
        $balita_dipantau = 0;
        $balita_sdidtk = 0;
        $balita_mtbs = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKesehatanBalita($year)){
                $balita_0_59 += $value->filterKesehatanBalita($year)->balita_0_59;
                $balita_12_59 += $value->filterKesehatanBalita($year)->balita_12_59;
                $balita_kia += $value->filterKesehatanBalita($year)->balita_kia;
                $balita_dipantau += $value->filterKesehatanBalita($year)->balita_dipantau;
                $balita_sdidtk += $value->filterKesehatanBalita($year)->balita_sdidtk;
                $balita_mtbs += $value->filterKesehatanBalita($year)->balita_mtbs;
            }


        }
        return compact('balita_0_59', 'balita_12_59', 'balita_kia', 'balita_dipantau', 'balita_sdidtk', 'balita_mtbs');
    }
    public function peserta_didik_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_kelas_1 = 0;
        $pelayanan_kelas_1 = 0;
        $jumlah_kelas_7 = 0;
        $pelayanan_kelas_7 = 0;
        $jumlah_kelas_10 = 0;
        $pelayanan_kelas_10 = 0;
        $jumlah_usia_dasar = 0;
        $pelayanan_usia_dasar = 0;
        $jumlah_sd = 0;
        $pelayanan_sd = 0;
        $jumlah_smp = 0;
        $pelayanan_smp = 0;
        $jumlah_sma = 0;
        $pelayanan_sma = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPesertaDidik($year)){
            $jumlah_kelas_1 += $value->filterPesertaDidik($year)->jumlah_kelas_1;
            $pelayanan_kelas_1 += $value->filterPesertaDidik($year)->pelayanan_kelas_1;
            $jumlah_kelas_7 += $value->filterPesertaDidik($year)->jumlah_kelas_7;
            $pelayanan_kelas_7 += $value->filterPesertaDidik($year)->pelayanan_kelas_7;
            $jumlah_kelas_10 += $value->filterPesertaDidik($year)->jumlah_kelas_10;
            $pelayanan_kelas_10 += $value->filterPesertaDidik($year)->pelayanan_kelas_10;
            $jumlah_usia_dasar += $value->filterPesertaDidik($year)->jumlah_usia_dasar;
            $pelayanan_usia_dasar += $value->filterPesertaDidik($year)->pelayanan_usia_dasar;
            $jumlah_sd += $value->filterPesertaDidik($year)->jumlah_sd;
            $pelayanan_sd += $value->filterPesertaDidik($year)->pelayanan_sd;
            $jumlah_smp += $value->filterPesertaDidik($year)->jumlah_smp;
            $pelayanan_smp += $value->filterPesertaDidik($year)->pelayanan_smp;
            $jumlah_sma += $value->filterPesertaDidik($year)->jumlah_sma;
            $pelayanan_sma += $value->filterPesertaDidik($year)->pelayanan_sma;

            }
        }
        return compact('jumlah_kelas_1', 'pelayanan_kelas_1', 'jumlah_kelas_7', 'pelayanan_kelas_7', 'jumlah_kelas_10', 'pelayanan_kelas_10', 'jumlah_usia_dasar', 'pelayanan_usia_dasar', 'jumlah_sd', 'pelayanan_sd', 'jumlah_smp', 'pelayanan_smp', 'jumlah_sma', 'pelayanan_sma');
    }
    public function pelayanan_produktif_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_L = 0;
        $jumlah_P = 0;
        $standar_L = 0;
        $standar_P = 0;
        $risiko_L = 0;
        $risiko_P = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPelayananProduktif($year)){
                $jumlah_L += $value->filterPelayananProduktif($year)->jumlah_L;
                $jumlah_P += $value->filterPelayananProduktif($year)->jumlah_P;
                $standar_L += $value->filterPelayananProduktif($year)->standar_L;
                $standar_P += $value->filterPelayananProduktif($year)->standar_P;
                $risiko_L += $value->filterPelayananProduktif($year)->risiko_L;
                $risiko_P += $value->filterPelayananProduktif($year)->risiko_P;
            }

        }
        return compact('jumlah_L', 'jumlah_P', 'standar_L', 'standar_P', 'risiko_L', 'risiko_P');
    }
    public function pelayanan_lansia_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_L = 0;
        $jumlah_P = 0;
        $standar_L = 0;
        $standar_P = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPelayananLansia($year)){
                $jumlah_L += $value->filterPelayananLansia($year)->jumlah_L;
                $jumlah_P += $value->filterPelayananLansia($year)->jumlah_P;
                $standar_L += $value->filterPelayananLansia($year)->standar_L;
                $standar_P += $value->filterPelayananLansia($year)->standar_P;
            }
        }
        return compact('jumlah_L', 'jumlah_P', 'standar_L', 'standar_P');
    }
    public function tuberkulosis_per_desa($year = null){
        $desa = $this->Desa()->get();
        $kasus_L = 0;
        $kasus_P = 0;
        $terduga_kasus = 0;
        $kasus_LP = 0;
        $kasus_anak = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterTuberkulosis($year)){
                $kasus_L += $value->filterTuberkulosis($year)->kasus_L;
                $kasus_P += $value->filterTuberkulosis($year)->kasus_P;
                $kasus_LP += $value->filterTuberkulosis($year)->kasus_LP;
                $terduga_kasus += $value->filterTuberkulosis($year)->terduga_kasus;
                $kasus_anak += $value->filterTuberkulosis($year)->kasus_anak;
            }
        }
        return compact('kasus_L', 'kasus_P', 'kasus_LP', 'terduga_kasus', 'kasus_anak');
    }
    public function hipertensi_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_L = 0;
        $jumlah_P = 0;
        $pelayanan_L = 0;
        $pelayanan_P = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterHipertensi($year)){
                $jumlah_L += $value->filterHipertensi($year)->jumlah_L;
            $jumlah_P += $value->filterHipertensi($year)->jumlah_P;
            $pelayanan_L += $value->filterHipertensi($year)->pelayanan_L;
            $pelayanan_P += $value->filterHipertensi($year)->pelayanan_P;
            }
        }
        return compact('jumlah_L', 'jumlah_P', 'pelayanan_L', 'pelayanan_P');
    }
    public function diabetes_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah = 0;
        $pelayanan = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterDiabetes($year)){
                $jumlah += $value->filterDiabetes($year)->jumlah;
                $pelayanan += $value->filterDiabetes($year)->pelayanan;
            }
        }
        return compact('jumlah', 'pelayanan');
    }
    public function kunjungan_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jalan_L = 0;
        $jalan_P = 0;
        $inap_L = 0;
        $inap_P = 0;
        $jiwa_L = 0;
        $jiwa_P = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKunjungan($year)){
                $jalan_L += $value->filterKunjungan($year)->jalan_L;
            $jalan_P += $value->filterKunjungan($year)->jalan_P;
            $inap_P += $value->filterKunjungan($year)->inap_P;
            $inap_L += $value->filterKunjungan($year)->inap_L;
            $jiwa_L += $value->filterKunjungan($year)->jiwa_L;
            $jiwa_P += $value->filterKunjungan($year)->jiwa_P;
            }
        }
        return compact('jalan_L', 'jalan_P', 'inap_L', 'inap_P', 'jiwa_L', 'jiwa_P',);
    }
    public function odgj_per_desa($year = null){
        $desa = $this->Desa()->get();
        $skizo_0 = 0;
        $skizo_15 = 0;
        $skizo_60 = 0;
        $psiko_0 = 0;
        $psiko_15 = 0;
        $psiko_60 = 0;
        $sasaran = 0;
        foreach ($desa as $key => $value) {
            # code...
            if($value->filterOdgj($year)){
                $skizo_0 += $value->filterOdgj($year)->skizo_0;
                $skizo_15 += $value->filterOdgj($year)->skizo_15;
                $skizo_60 += $value->filterOdgj($year)->skizo_60;
                $psiko_0 += $value->filterOdgj($year)->psiko_0;
                $psiko_15 += $value->filterOdgj($year)->psiko_15;
                $psiko_60 += $value->filterOdgj($year)->psiko_60;
                $sasaran += $value->filterOdgj($year)->sasaran;
            }
        }
        return compact('skizo_0', 'skizo_15', 'skizo_60', 'psiko_0', 'psiko_15', 'psiko_60', 'sasaran');
    }
    public function kematian_ibu_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_kematian_ibu_hamil = 0;
        $jumlah_kematian_ibu_bersalin = 0;
        $jumlah_kematian_ibu_nifas = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKematianIbu($year)){
                $jumlah_kematian_ibu_hamil += $value->filterKematianIbu($year)->jumlah_kematian_ibu_hamil;
                $jumlah_kematian_ibu_bersalin += $value->filterKematianIbu($year)->jumlah_kematian_ibu_bersalin;
                $jumlah_kematian_ibu_nifas += $value->filterKematianIbu($year)->jumlah_kematian_ibu_nifas;

            }
        }
        return compact('jumlah_kematian_ibu_hamil', 'jumlah_kematian_ibu_bersalin', 'jumlah_kematian_ibu_nifas',);
    }
    public function penyebab_kematian_ibu_per_desa($year = null){
        $desa = $this->Desa()->get();
        $perdarahan = 0;
        $gangguan_hipertensi = 0;
        $infeksi = 0;
        $kelainan_jantung = 0;
        $gangguan_autoimun = 0;
        $gangguan_cerebro = 0;
        $covid_19 = 0;
        $abortus = 0;
        $lain_lain = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterKematianIbu($year)){
                $perdarahan += $value->filterPenyebabKematianIbu($year)->perdarahan;
                $gangguan_hipertensi += $value->filterPenyebabKematianIbu($year)->gangguan_hipertensi;
                $infeksi += $value->filterPenyebabKematianIbu($year)->infeksi;
                $kelainan_jantung += $value->filterPenyebabKematianIbu($year)->kelainan_jantung;
                $gangguan_autoimun += $value->filterPenyebabKematianIbu($year)->gangguan_autoimun;
                $gangguan_cerebro += $value->filterPenyebabKematianIbu($year)->gangguan_cerebro;
                $covid_19 += $value->filterPenyebabKematianIbu($year)->covid_19;
                $abortus += $value->filterPenyebabKematianIbu($year)->abortus;
                $lain_lain += $value->filterPenyebabKematianIbu($year)->lain_lain;


            }
        }
        return compact('perdarahan', 'gangguan_hipertensi', 'infeksi', 'kelainan_jantung', 'gangguan_autoimun', 'gangguan_cerebro', 'covid_19', 'abortus', 'lain_lain');
    }
    public function ibu_hamil_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah_ibu_hamil = 0;
        $jumlah_ibu_bersalin = 0;
        $td1 = 0;
        $td2 = 0;
        $td3 = 0;
        $td4 = 0;
        $td5 = 0;
        $td2_plus = 0;
        $dapat_ttd = 0;
        $konsumsi_ttd = 0;
        $kondom = 0;
        $suntik = 0;
        $pil = 0;
        $mop = 0;
        $mow = 0;
        $implan = 0;
        $akdr = 0;
        $mal = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterDesa($year)){
                $jumlah_ibu_hamil += $value->filterDesa($year)->jumlah_ibu_hamil;
                $jumlah_ibu_bersalin += $value->filterDesa($year)->jumlah_ibu_bersalin;
                $td1 += $value->filterDesa($year)->td1;
                $td2 += $value->filterDesa($year)->td2;
                $td3 += $value->filterDesa($year)->td3;
                $td4 += $value->filterDesa($year)->td4;
                $td5 += $value->filterDesa($year)->td5;
                $td2_plus += $value->filterDesa($year)->td2_plus;
                $dapat_ttd += $value->filterDesa($year)->dapat_ttd;
                $konsumsi_ttd += $value->filterDesa($year)->konsumsi_ttd;
                $kondom += $value->filterDesa($year)->kondom;
                $pil += $value->filterDesa($year)->pil;
                $suntik += $value->filterDesa($year)->suntik;
                $mop += $value->filterDesa($year)->mop;
                $mow += $value->filterDesa($year)->mow;
                $akdr += $value->filterDesa($year)->akdr;
                $implan += $value->filterDesa($year)->implan;
                $mal += $value->filterDesa($year)->mal;



            }
        }
        return compact('jumlah_ibu_hamil', 'jumlah_ibu_bersalin', 'td1', 'td2', 'td3', 'td4', 'td5', 'td2_plus', 'konsumsi_ttd', 'dapat_ttd', 'kondom', 'akdr', 'suntik', 'pil', 'mop', 'mow', 'implan', 'mal', 'akdr');
    }
    public function wus_tidak_hamil_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah = 0;
        $td1 = 0;
        $td2 = 0;
        $td3 = 0;
        $td4 = 0;
        $td5 = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterWus($year, 0)){
                $jumlah += $value->filterWus($year, 0)->jumlah;
                $td1 += $value->filterWus($year, 0)->td1;
                $td2 += $value->filterWus($year, 0)->td2;
                $td3 += $value->filterWus($year, 0)->td3;
                $td4 += $value->filterWus($year, 0)->td4;
                $td5 += $value->filterWus($year, 0)->td5;



            }
        }
        return compact('jumlah', 'td1', 'td2', 'td3', 'td4', 'td5');
    }
    public function wus_hamil_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah = 0;
        $td1 = 0;
        $td2 = 0;
        $td3 = 0;
        $td4 = 0;
        $td5 = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterWus($year, 1)){
                $jumlah += $value->filterWus($year, 1)->jumlah;
                $td1 += $value->filterWus($year, 1)->td1;
                $td2 += $value->filterWus($year, 1)->td2;
                $td3 += $value->filterWus($year, 1)->td3;
                $td4 += $value->filterWus($year, 1)->td4;
                $td5 += $value->filterWus($year, 1)->td5;



            }
        }
        return compact('jumlah', 'td1', 'td2', 'td3', 'td4', 'td5');
    }
    public function pus_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah = 0;
        $kondom = 0;
        $suntik = 0;
        $pil = 0;
        $mop = 0;
        $mow = 0;
        $implan = 0;
        $akdr = 0;
        $mal = 0;
        $efek_samping = 0;
        $komplikasi = 0;
        $kegagalan = 0;
        $dropout = 0;
        $pus_4_t = 0;
        $pus_4_t_kb = 0;
        $pus_alki = 0;
        $pus_alki_kb = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPus($year)){
                $jumlah += $value->filterPus($year)->jumlah;
                $kondom += $value->filterPus($year)->kondom;
                $suntik += $value->filterPus($year)->suntik;
                $pil += $value->filterPus($year)->pil;
                $mop += $value->filterPus($year)->mop;
                $mow += $value->filterPus($year)->mow;
                $akdr += $value->filterPus($year)->akdr;
                $implan += $value->filterPus($year)->implan;
                $mal += $value->filterPus($year)->mal;
                $efek_samping += $value->filterPus($year)->efek_samping;
                $komplikasi += $value->filterPus($year)->komplikasi;
                $kegagalan += $value->filterPus($year)->kegagalan;
                $dropout += $value->filterPus($year)->dropout;
                $pus_4_t += $value->filterPus($year)->pus_4_t;
                $pus_4_t_kb += $value->filterPus($year)->pus_4_t_kb;
                $pus_alki += $value->filterPus($year)->pus_alki;
                $pus_alki_kb += $value->filterPus($year)->pus_alki_kb;
            }
        }
        return compact('jumlah', 'kondom', 'akdr', 'suntik', 'pil', 'mop', 'mow', 'implan', 'mal', 'efek_samping', 'komplikasi', 'kegagalan', 'dropout', 'pus_4_t', 'pus_4_t_kb', 'pus_alki', 'pus_alki_kb');
    }
    public function komplikasi_bidan_per_desa($year = null){
        $desa = $this->Desa()->get();
        $jumlah = 0;
        $kek = 0;
        $anemia = 0;
        $pendarahan = 0;
        $malaria = 0;
        $tuberkulosis = 0;
        $infeksi_lain = 0;
        $preklampsia = 0;
        $diabetes = 0;
        $jantung = 0;
        $covid_19 = 0;
        $penyebab_lain = 0;
        $komplikasi_hamil = 0;
        $komplikasi_persalinan = 0;
        $komplikasi_nifas = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPus($year)){
                $jumlah += $value->filterKomplikasiBidan($year)->jumlah;
                $kek += $value->filterKomplikasiBidan($year)->kek;
                $anemia += $value->filterKomplikasiBidan($year)->anemia;
                $pendarahan += $value->filterKomplikasiBidan($year)->pendarahan;
                $malaria += $value->filterKomplikasiBidan($year)->malaria;
                $tuberkulosis += $value->filterKomplikasiBidan($year)->tuberkulosis;
                $infeksi_lain += $value->filterKomplikasiBidan($year)->infeksi_lain;
                $preklampsia += $value->filterKomplikasiBidan($year)->preklampsia;
                $diabetes += $value->filterKomplikasiBidan($year)->diabetes;
                $jantung += $value->filterKomplikasiBidan($year)->jantung;
                $covid_19 += $value->filterKomplikasiBidan($year)->covid_19;
                $penyebab_lain += $value->filterKomplikasiBidan($year)->penyebab_lain;
                $komplikasi_hamil += $value->filterKomplikasiBidan($year)->komplikasi_hamil;
                $komplikasi_persalinan += $value->filterKomplikasiBidan($year)->komplikasi_persalinan;
                $komplikasi_nifas += $value->filterKomplikasiBidan($year)->komplikasi_nifas;
            }
        }
        return compact('jumlah', 'kek', 'anemia', 'pendarahan', 'malaria', 'tuberkulosis', 'infeksi_lain', 'preklampsia', 'diabetes', 'jantung', 'covid_19', 'penyebab_lain', 'komplikasi_hamil', 'komplikasi_persalinan', 'komplikasi_nifas');
    }
    public function komplikasi_neonatal_per_desa($year = null){
        $desa = $this->Desa()->get();
        $bblr = 0;
        $asfiksia = 0;
        $tetanus = 0;
        $infeksi = 0;
        $lain_lain = 0;
        $kelainan = 0;
        $covid_19 = 0;

        foreach ($desa as $key => $value) {
            # code...
            if($value->filterPus($year)){
                $bblr += $value->filterKomplikasiNeonatal($year)->bblr;
                $asfiksia += $value->filterKomplikasiNeonatal($year)->asfiksia;
                $tetanus += $value->filterKomplikasiNeonatal($year)->tetanus;
                $infeksi += $value->filterKomplikasiNeonatal($year)->infeksi;
                $lain_lain += $value->filterKomplikasiNeonatal($year)->lain_lain;
                $kelainan += $value->filterKomplikasiNeonatal($year)->kelainan;
                $covid_19 += $value->filterKomplikasiNeonatal($year)->covid_19;

            }
        }
        return compact('bblr', 'asfiksia', 'tetanus', 'infeksi', 'lain_lain', 'kelainan', 'covid_19');
    }

    public function unitKerjaAmbil($namaFilter, $year, $namaAttribut){
        $total = 0;
        $desa = $this->Desa()->get();

        foreach ($desa as $key => $value){
            $total += $value->$namaFilter($year)?$value->$namaFilter($year)->$namaAttribut:0;
        }
        return compact('total');
    }

    public function unitKerjaAmbilPart2($namaFilter, $year, $namaAttribut){
        $total = 0;
        $desa = $this->Desa()->get();
        foreach ($desa as $key => $value){
            $dataAtribut = explode(',', $namaAttribut);
            if(count($dataAtribut) > 1) {
                $function2 = $dataAtribut[0];
                // dd($value->$namaFilter($year, $value->id));
                $total += $value->$namaFilter($year, $value->id)?$value->$namaFilter($year, $value->id)->$function2($value->id):0;
            } else {
                $total += $value->$namaFilter($year, $value->id)?$value->$namaFilter($year, $value->id)->$namaAttribut:0;
            }
        }
        return compact('total');
    }
}
