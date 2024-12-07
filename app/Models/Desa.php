<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Diabetes;
use App\Models\Kunjungan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama', 'unit_kerja_id'
    ];
    public function PengelolaProgram(){
        return $this->hasMany(PengelolaProgram::class);
    }
    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class);
    }
    public function IbuHamil(){
        return $this->hasOne(IbuHamilDanBersalin::class);
    }

    // Kategori OPD
    public function AhliLabMedik(){
        return $this->hasOne(AhliLabMedik::class);
    }

    public function TenagaTeknikBiomedik(){
        return $this->hasOne(TenagaTeknikBiomedik::class);
    }

    public function TerapiFisik(){
        return $this->hasOne(TerapiFisik::class);
    }
    public function KeteknisanMedik(){
        return $this->hasOne(KeteknisanMedik::class);
    }

    //Unit Organisasi
    public function TenagaKesehatanMasyarakat(){
        return $this->hasOne(TenagaKesehatanMasyarakat::class);
    }
    public function TenagaKesehatanLingkungan(){
        return $this->hasOne(TenagaKesehatanLingkungan::class);
    }
    public function TenagaGizi(){
        return $this->hasOne(TenagaGizi::class);
    }

    //Jabatan
    public function Perawat(){
        return $this->hasOne(Perawat::class);
    }
    public function Bidan(){
        return $this->hasOne(Bidan::class);
    }

    //Pemangku
    public function DokterSpesialis(){
        return $this->hasOne(DokterSpesialis::class);
    }
    public function Dokter(){
        return $this->hasOne(Dokter::class);
    }
    public function DokterGigi(){
        return $this->hasOne(DokterGigi::class);
    }
    public function DokterGigiSpesialis(){
        return $this->hasOne(DokterGigiSpesialis::class);
    }

    //program
    public function TenagaTeknikFarmasi(){
        return $this->hasOne(TenagaTeknisFarmasi::class);
    }

    public function Apoteker(){
        return $this->hasOne(Apoteker::class);
    }

    //Kegiatan
    public function PejabatStruktural(){
        return $this->hasOne(PejabatStruktural::class);
    }
    public function TenagaPendidik(){
        return $this->hasOne(TenagaPendidik::class);
    }
    public function Manajemen(){
        return $this->hasOne(Manajemen::class);
    }

    //sub_kegiatan
    public function Posyandu(){
        return $this->hasOne(Posyandu::class);
    }
    public function filterDesa($tahun = null, $bulan = null){

        if($tahun == null){
            $var = IbuHamilDanBersalin::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
        } else {
            $var = IbuHamilDanBersalin::where('desa_id', $this->id)->whereYear('created_at', $tahun)->first();
        }
        return $var;
    }
    public function filterSasaranTahunDesa($year = null){
        if($year == null){
            $var = SasaranTahunIbuHamil::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
        } else {
            $var = SasaranTahunIbuHamil::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterKelahiran($year = null){
        if($year == null){
            $var = Kelahiran::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
        } else {
            $var = Kelahiran::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterNeonatal($year = null){
        if($year == null){
            $var = Neonatal::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Neonatal::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKesehatanBalita($year = null){
        if($year == null){
            $var = KesehatanBalita::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = KesehatanBalita::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPesertaDidik($year = null){
        if($year == null){
            $var = PesertaDidik::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PesertaDidik::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPelayananProduktif($year = null){
        if($year == null){
            $var = PelayananProduktif::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PelayananProduktif::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPelayananLansia($year = null){
        if($year == null){
            $var = PelayananLansia::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PelayananLansia::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTuberkulosis($year = null){
        if($year == null){
            $var = Tuberkulosis::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Tuberkulosis::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterHipertensi($year = null){
        if($year == null){
            $var = Hipertensi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Hipertensi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterDiabetes($year = null){
        if($year == null){
            $var = Diabetes::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Diabetes::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKunjungan($year = null){
        if($year == null){
            $var = Kunjungan::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Kunjungan::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterOdgj($year = null){
        if($year == null){
            $var = Odgj::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Odgj::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKematianIbu($year = null){
        if($year == null){
            $var = JumlahKematianIbu::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = JumlahKematianIbu::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPenyebabKematianIbu($year = null){
        if($year == null){
            $var = PenyebabKematianIbu::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PenyebabKematianIbu::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterWus($year = null, $hamil){
        if($year == null){
            $var = Wus::where('desa_id', $this->id)->where('hamil', $hamil)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Wus::where('desa_id', $this->id)->where('hamil', $hamil)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPus($year = null){
        if($year == null){
            $var = Pus::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Pus::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKomplikasiBidan($year = null){
        if($year == null){
            $var = KomplikasiBidan::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = KomplikasiBidan::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKomplikasiNeonatal($year = null){
        if($year == null){
            $var = KomplikasiNeonatal::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = KomplikasiNeonatal::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterKematianNeonatal($year = null){
        if($year == null){
            $var = KematianNeonatal::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = KematianNeonatal::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPenyebabKematianNeonatal($year = null){
        if($year == null){
            $var = PenyebabKematianNeonatal::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PenyebabKematianNeonatal::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPenyebabKematianBalita($year = null){
        if($year == null){
            $var = PenyebabKematianBalita::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PenyebabKematianBalita::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterBblr($year = null){
        if($year == null){
            $var = BblrPrematur::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = BblrPrematur::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterImdAsi($year = null){
        if($year == null){
            $var = ImdAsi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = ImdAsi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterPelayananBalita($year = null){
        if($year == null){
            $var = PelayananBalita::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = PelayananBalita::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterBalitaBcg($year = null){
        if($year == null){
            $var = BalitaBcg::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = BalitaBcg::where('desa_id', $this->id)->whereYear('created_at', $year)->first();

        }
        return $var;
    }

    public function filterDeteksiDiniHepatitisBPadaIbuHamil($year = null, $id){
        if($year == null){
            $var = DeteksiDiniHepatitisBPadaIbuHamil::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = DeteksiDiniHepatitisBPadaIbuHamil::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterBayiImunisasi($year = null){
        if($year == null){
            $var = BayiImunisasi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = BayiImunisasi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable63($year = null, $id){
        if($year == null){
            $var = Table63::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table63::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterBadutaImunisasi($year = null){
        if($year == null){
            $var = BadutaImunisasi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = BadutaImunisasi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();


        }
        return $var;
    }
    public function filterTable64($year = null, $id){
        if($year == null){
            $var = Table64::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table64::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterBalitaVita($year = null){
        if($year == null){
            $var = BalitaVita::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = BalitaVita::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable65($year = null, $id){
        if($year == null){
            $var = Table65::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table65::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTimbang($year = null){
        if($year == null){
            $var = Timbang::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Timbang::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable66($year = null, $id){
        if($year == null){
            $var = Table66::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table66::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }

    public function filterStatusGizi($year = null){
        if($year == null){
            $var = StatusGizi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = StatusGizi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable67($year = null, $id){
        if($year == null){
            $var = Table67::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table67::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterGigi($year = null){
        if($year == null){
            $var = Gigi::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Gigi::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable68($year = null, $id){
        if($year == null){
            $var = Table68::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table68::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterGigiAnak($year = null){
        if($year == null){
            $var = GigiAnak::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = GigiAnak::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable69($year = null, $id){
        if($year == null){
            $var = Table69::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table69::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterCatin($year = null){
        if($year == null){
            $var = Catin::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Catin::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }
    public function filterTable70($year = null, $id){
        if($year == null){
            $var = Table70::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table70::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterObatTuberkulosis($year = null){
        if($year == null){
            $var = ObatTuberkulosis::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = ObatTuberkulosis::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }

    public function filterTable72($year = null, $id){
        if($year == null){
            $var = Table72::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table72::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterOdhiv($year = null){
        if($year == null){
            $var = Odhiv::where('desa_id', $this->id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Odhiv::where('desa_id', $this->id)->whereYear('created_at', $year)->first();
        }
        return $var;
    }

    public function filterTable73($year = null, $id){
        if($year == null){
            $var = Table73::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table73::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }

    public function filterTable74($year = null, $id){
        if($year == null){
            $var = Table74::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table74::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }

    public function filterTable77($year = null, $id){
        if($year == null){
            $var = Table77::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table77::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }

    public function filterTable82($year = null, $id){
        if($year == null){
            $var = Table82::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table82::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTable83($year = null, $id){
        if($year == null){
            $var = Table83::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table83::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTable84($year = null, $id){
        if($year == null){
            $var = Table84::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table84::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTable85($year = null, $id){
        if($year == null){
            $var = Table85::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table85::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTable86($year = null, $id){
        if($year == null){
            $var = Table86::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table86::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
    public function filterTable87($year = null, $id){
        if($year == null){
            $var = Table87::where('desa_id', $id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
            // dd("A");
        } else {
            $var = Table87::where('desa_id', $id)->whereYear('created_at', $year)->first();
        }

        return $var;
    }
}
