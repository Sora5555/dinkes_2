<style>
    #side-menu a,
    i {
        color: white !important;
    }

    .vertical-menu {
        background-color: #23e283 !important;
    }

    .menu-title {
        color: white !important;
    }
</style>
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>


                <li>
                    <a href="/" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-database"></i>
                            <span>Data Master</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('resume.index') }}">Resume</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('kategori_opd.index') }}">Jumlah Tenaga Biomedika, Keterapian Fisik, dan
                                    KeteknisanMedik</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('unit_organisasi.index') }}">Tenaga Kesehatan masyarakat Lingkungan dan
                                    Gizi</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('jabatan.index') }}">Keperawatan dan Kebidanan</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('pemangku.index') }}">Jumlah Tenaga Medis di Fasilitas Kesehatan</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('program.index') }}">Jumlah Tenaga Kefarmasian</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('kegiatan.index') }}">Jumlah Tenaga Penunjang dan Pendukung</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('sub_kegiatan.index') }}">Jumlah Posyandu dan Posbindu</a></li>
                        </ul>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('pengelola_program.index') }}">Pengelola Program</a></li>
                        </ul>
                        @role('Admin|superadmin')
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('import.preview') }}">Import data</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('unit_kerja.index') }}">Unit Kerja</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('DetailWilayah.index') }}">Detail Wilayah</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('ObatEsensial.index') }}">Obat Esensial</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('KelompokUmur.index') }}">Kelompok Umur</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('MelekHuruf.index') }}">Melek Huruf</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('FasilitasKesehatan.index') }}">Fasilitas Kesehatan</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('GawatDaruratSatu.index') }}">Gawat Darurat Satu</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('AngkaKematian.index') }}">Angka Kematian Pasien</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('IndikatorKinerja.index') }}">Indikator Kinerja</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('Obat.index') }}">Ketersediaan Obat</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('Vaksin.index') }}">Ketersediaan Vaksin</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('JaminanKesehatan.index') }}">Jaminan Kesehatan</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('desa.index') }}">Desa</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('jumlah_penduduk.index') }}">Jumlah Penduduk</a></li>
                            </ul>
                        @endrole
                        {{-- <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('kategori_reviu.index') }}">Kategori Reviu</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('menu.index') }}">Menu</a></li>
                    </ul> --}}

                    </li>

                    @role('Admin|superadmin')
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-hospital-building"></i>
                                <span>Fasilitas</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('rumah_sakit.index') }}">Rumah Sakit</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('jaringan_puskesmas.index') }}">Puskesmas dan Jaringannya</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('sarana_pelayanan.index') }}">Sarana Pelayanan yang lainnya</a></li>
                            </ul>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('sarana_produksi.index') }}">Sarana Produksi dan distribusi
                                        kefarmasian</a></li>
                            </ul>
                        </li>
                    @endrole
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-target"></i>
                        <span>sasaran</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('sasaran_ibu_hamil.index') }}">Ibu Hamil</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-notebook-multiple"></i>
                        <span>Input Data</span>
                    </a>
                    @if (Auth::user()->hasRoles(['puskesmas', 'superadmin', 'Pihak Wajib Pajak']) || 
                    (Auth::user()->hasRole('Admin') && Auth::user()->hasMenuPermission(1)))
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('IbuHamil.index') }}">Ibu Hamil Dan Bersalin</a></li>
                    </ul>
                    @endif
                    @if (Auth::user()->hasRoles(['puskesmas', 'superadmin', "Pihak Wajib Pajak"]) || 
                    (Auth::user()->hasRole('Admin') && Auth::user()->hasMenuPermission(2)))
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('kelahiran.index') }}">Kelahiran</a></li>
                    </ul>
                    @endif
                    @if (Auth::user()->hasRoles(['puskesmas', 'superadmin', "Pihak Wajib Pajak"]) || 
                    (Auth::user()->hasRole('Admin') && Auth::user()->hasMenuPermission(3)))
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('neonatal.index') }}">Neonatal</a></li>
                    </ul>
                    @endif
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('kesehatan_balita.index') }}">Kesehatan Balita</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('peserta_didik.index') }}">Peserta Didik</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pelayanan_produktif.index') }}">Pelayanan Produktif</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pelayanan_lansia.index') }}">Pelayanan Lansia</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('tuberkulosis.index') }}">Tuberkulosis</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('hipertensi.index') }}">Hipertensi</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('diabetes.index') }}">Diabetes</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('kunjungan.index') }}">Kunjungan</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('odgj.index') }}">Gangguan Jiwa</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('JumlahKematianIbu.index') }}">Jumlah Kematian Ibu</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('PenyebabKematianIbu.index') }}">Penyebab Kematian Ibu</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('ImunBumil.index') }}">Imunisasi Ibu Hamil</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('WusTidakHamil.index') }}">Wus Tidak Hamil</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('WusHamil.index') }}">Wus Tidak Hamil dan Hamil</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Ttd.index') }}">Tablet Tambah Darah</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Pus.index') }}">Peserta KB Aktif Modern</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Pus4T.index') }}">Pus 4T Peserta KB Aktif</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('KbBersalin.index') }}">Peserta KB Aktif Setelah Proses Persalinan</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('KomplikasiBidan.index') }}">Komplikasi Kebidanan</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('KomplikasiNeonatal.index') }}">Komplikasi Neonatal</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('KematianNeonatal.index') }}">Kematian Neonatal</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('PenyebabKematianNeonatal.index') }}">Penyebab Kematian Neonatal</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('PenyebabKematianBalita.index') }}">Penyebab Kematian Balita</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('BblrPrematur.index') }}">Bayi BBLR dan Prematur</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('ImdAsi.index') }}">Bayi Baru Lahir Mendapat IMD dan Asi Eksklusif</a>
                        </li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('PelayananBalita.index') }}">Pelayanan Balita</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('BalitaBcg.index') }}">Balita Imunisasi Hepatitis dan BCG</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('BayiImunisasi.index') }}">Imunisasi Rubela, Polio, dan dpt-hb-hib 3</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('BadutaImunisasi.index') }}">Imunisasi Rubela, dpt-hb-hib 4 Baduta</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('BalitaVita.index') }}">Cakupan Vitamin A terhadap Bayi</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Timbang.index') }}">Bayi Ditimbang</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('StatusGizi.index') }}">Status Gizi</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Gigi.index') }}">Pelayanan Kesehatan Gigi dan Mulut</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('GigiAnak.index') }}">Pelayanan Kesehatan Gigi dan Mulut Pada anak SD dan Setingkat</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Catin.index') }}">Pelayanan Kesehatan Calon Pengantin</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('ObatTuberkulosis.index') }}">Pengobatan Tuberkulosis</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('Odhiv.index') }}">Pengobatan Odhiv</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('data_posyandu.index') }}">Data Posyandu</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('tenaga_medis.index') }}">Tenaga Medis</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('keperawatan.index') }}">Tenaga Keperawatan & Kebidanan</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('DeteksiDiniHepatitisBPIB') }}">DETEKSI DINI HEPATITIS
                                B PADA IBU HAMIL</a></li>
                    </ul>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_63') }}">JUMLAH BAYI YANG LAHIR DARI IBU REAKTIF HBsAg dan MENDAPATKAN HBIG</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_64') }}">KASUS BARU KUSTA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_65') }}">KASUS BARU KUSTA CACAT TINGKAT 0, CACAT TINGKAT 2, PENDERITA KUSTA ANAK < 15 TAHUN,</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_66') }}"> JUMLAH KASUS TERDAFTAR DAN ANGKA PREVALENSI PENYAKIT KUSTA MENURUT TIPE/JENIS, USIA, KECAMATAN, DAN PUSKESMAS
                        </a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_67') }}">PENDERITA KUSTA SELESAI BEROBAT (RELEASE FROM TREATMENT/RFT) MENURUT TIPE, KECAMATAN, DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_68') }}">JUMLAH KASUS AFP (NON POLIO) MENURUT KECAMATAN DAN PUSKESMAS
                        </a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_69') }}">JUMLAH KASUS PENYAKIT YANG DAPAT DICEGAH DENGAN IMUNISASI (PD3I) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS
                        </a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_70') }}">KEJADIAN LUAR BIASA (KLB) DI DESA/KELURAHAN YANG DITANGANI < 24 JAM
                        </a></li>
                    </ul>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_71') }}">JUMLAH PENDERITA DAN KEMATIAN PADA KLB MENURUT JENIS KEJADIAN LUAR BIASA (KLB)
                        </a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_72') }}">KASUS DEMAM BERDARAH DENGUE (DBD) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS
                        </a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_73') }}">KESAKITAN DAN KEMATIAN AKIBAT MALARIA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_74') }}">PENDERITA KRONIS FILARIASIS MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_77') }}">PELAYANAN KESEHATAN  PENDERITA HIPERTENSI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</a></li>
                    </ul>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_82') }}">PERSENTASE TEMPAT DAN FASILITAS UMUM(TFU) YANG DILAKUKAN PENGAWASAN SESUAI STANDAR MENURUT KECAMATAN DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_83') }}">PERSENTASE TEMPAT PENGELOLAAN PANGAN (TPP) YANG MEMENUHI SYARAT KESEHATAN  MENURUT KECAMATAN</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_84') }}">KASUS COVID-19 MENURUT MENURUT KECAMATAN DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_85') }}">KASUS COVID-19 BERDASARKAN JENIS KELAMIN DAN KELOMPOK UMUR MENURUT KECAMATAN DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_86') }}">CAKUPAN VAKSINASI COVID-19 DOSIS 1 MENURUT KECAMATAN DAN PUSKESMAS</a></li>
                    </ul>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ url('table_87') }}">CAKUPAN VAKSINASI COVID-19 DOSIS 2 MENURUT KECAMATAN DAN PUSKESMAS</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('verifikasi.index') }}" class=" waves-effect">
                        <i class="mdi mdi-check"></i>
                        <span>Verifikasi Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}" class=" waves-effect">
                        <i class="mdi mdi-account"></i>
                        <span>User Profil</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
