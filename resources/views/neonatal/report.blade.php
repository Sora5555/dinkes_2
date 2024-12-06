<style>
    table{
       width: 100%;
       text-align: center;
   }
   .table{
       border: 1px solid #0a0a0a;
       border-collapse: collapse;
   }
   tr, td, th{
       border: 1px solid #000000;
   }
   h4{
       width: 90%;
       text-align: center;
       margin-inline:auto;
   }
   .flexbox{
       width: 70%;
       display: flex;
       justify-content: space-between;
       margin-inline: auto;
       text-align: center;
   }
   .box_puskesmas, .box_program{
       display: flex;
       flex-direction: column;
       align-content: space-between;
   }
   .nama_dan_nip{
       margin-top: 34px;
   }
   .h4{
       padding-block: 0;
       margin-block: 0;
   }

</style>
@role("Admin")
<h4>CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN {{$tahun}}</h4>
<div class="table-responsive">
    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="text-center">
        <tr>
            <th rowspan="3">No</th>
            @role("Pihak Wajib Pajak|Puskesmas")
            <th rowspan="3">Kecamatan</th>
            <th rowspan="3">Desa</th>
            @endrole
            @role("Admin")
            <th rowspan="3">Kecamatan</th>
            <th rowspan="3">Puskesmas</th>
            @endrole
            <th colspan="3">Jumlah Lahir Hidup</th>
            <th colspan="6">Kunjungan Neonatal 1 kali</th>
            <th colspan="6">Kunjungan Neonatal 3 kali (kn lengkap)</th>
            <th colspan="6">Bayi baru lahir yang diberikan screening Hipotiroid Konginetal</th>
        </tr>
        <tr>
            <th rowspan="2">Laki Laki</th>
            <th rowspan="2">Perempuan</th>
            <th rowspan="2">Laki Laki + Perempuan</th>
            <th colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Laki Laki + Perempuan</th>
            <th colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Laki Laki + Perempuan</th>
            <th colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Laki Laki + Perempuan</th>
        </tr>
        <tr>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr class="text-center">
                <td>{{$key + 1}}</td>
                <td>{{$item->kecamatan}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"]}}</td>
                
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn1_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["kn1_L"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn1_P"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["kn1_P"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn1_P"] + $item->neonatal_per_desa(app('request')->input('year'))["kn1_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(app('request')->input('year'))["kn1_P"] + $item->neonatal_per_desa(app('request')->input('year'))["kn1_L"]) / ($item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
                
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_L"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_P"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_P"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_P"] + $item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_P"] + $item->neonatal_per_desa(app('request')->input('year'))["kn_lengkap_L"]) / ($item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
                
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["hipo_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["hipo_L"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["hipo_P"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(app('request')->input('year'))["hipo_P"] / $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                <td>{{$item->neonatal_per_desa(app('request')->input('year'))["hipo_P"] + $item->neonatal_per_desa(app('request')->input('year'))["hipo_L"]}}</td>
                <td>{{$item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(app('request')->input('year'))["hipo_P"] + $item->neonatal_per_desa(app('request')->input('year'))["hipo_L"]) / ($item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(app('request')->input('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
              </tr>
            @endforeach
            <tr>
                <td colspan="3">Jumlah Kab/Kota</td>
                <td>{{$totalLahirHidupL}}</td>
                <td>{{$totalLahirHidupP}}</td>
                <td>{{$totalLahirHidupL + $totalLahirHidupP}}</td>
                
                <td>{{$totalkn1_L}}</td>
                <td>{{$totalLahirHidupL > 0?number_format($totalkn1_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td>{{$totalkn1_P}}</td>
                <td>{{$totalLahirHidupP > 0?number_format($totalkn1_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td>{{$totalkn1_L + $totalkn1_P}}</td>
                <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn1_L + $totalkn1_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                
                <td>{{$totalkn_lengkap_L}}</td>
                <td>{{$totalLahirHidupL > 0?number_format($totalkn_lengkap_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td>{{$totalkn_lengkap_P}}</td>
                <td>{{$totalLahirHidupP > 0?number_format($totalkn_lengkap_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td>{{$totalkn_lengkap_L + $totalkn_lengkap_P}}</td>
                <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn_lengkap_L + $totalkn_lengkap_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                
                <td>{{$totalhipo_L}}</td>
                <td>{{$totalLahirHidupL > 0?number_format($totalhipo_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td>{{$totalhipo_P}}</td>
                <td>{{$totalLahirHidupP > 0?number_format($totalhipo_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td>{{$totalhipo_L + $totalhipo_P}}</td>
                <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalhipo_L + $totalhipo_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterNeonatal(app('request')->input('year')) && $item->filterKelahiran(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item->UnitKerja->kecamatan}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L}}</td>
                <td>{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P}}</td>
                <td id="lahir_L{{$item->filterKelahiran(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P}}</td>
                
                <td>{{$item->filterNeonatal(app('request')->input('year'))->kn1_L}}</td>
                <td id="kn1_L{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(app('request')->input('year'))->kn1_L/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L)*100, 2):0}}%</td>
                <td>{{$item->filterNeonatal(app('request')->input('year'))->kn1_P}}</td>
                <td id="kn1_P{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(app('request')->input('year'))->kn1_P/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P)*100, 2):0}}%</td>
                <td id="jumlah_kn1_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterNeonatal(app('request')->input('year'))->kn1_L + $item->filterNeonatal(app('request')->input('year'))->kn1_P}}</td>
                <td id="persen_kn1_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(app('request')->input('year'))->kn1_L + $item->filterNeonatal(app('request')->input('year'))->kn1_P)/(($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P))* 100, 2):0}}%</td>
                
                <td>{{$item->filterNeonatal(app('request')->input('year'))->kn_lengkap_L}}</td>
                <td id="kn_lengkap_L{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(app('request')->input('year'))->kn_lengkap_L/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L) * 100, 2):0}}%</td>
                <td>{{$item->filterNeonatal(app('request')->input('year'))->kn_lengkap_P}}</td>
                <td id="kn_lengkap_P{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(app('request')->input('year'))->kn_lengkap_P/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P) * 100, 2):0}}%</td>
                <td id="jumlah_kn_lengkap_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterNeonatal(app('request')->input('year'))->kn_lengkap_L + $item->filterNeonatal(app('request')->input('year'))->kn_lengkap_P}}</td>
                <td id="persen_kn_lengkap_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(app('request')->input('year'))->kn_lengkap_L + $item->filterNeonatal(app('request')->input('year'))->kn_lengkap_P)/(($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P)) * 100, 2):0}}%</td>
                
                <td>{{$item->filterNeonatal(app('request')->input('year'))->hipo_L}}</td>
                <td id="hipo_L{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(app('request')->input('year'))->hipo_L/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                <td>{{$item->filterNeonatal(app('request')->input('year'))->hipo_P}}</td>
                <td id="hipo_P{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(app('request')->input('year'))->hipo_P/($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P) * 100, 2):0}}</td>
                <td id="jumlah_hipo_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterNeonatal(app('request')->input('year'))->hipo_L + $item->filterNeonatal(app('request')->input('year'))->hipo_P}}</td>
                <td id="persen_hipo_LP{{$item->filterNeonatal(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(app('request')->input('year'))->hipo_L + $item->filterNeonatal(app('request')->input('year'))->hipo_P)/(($item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                {{-- <td><input type="number" name="lahir_hidup_P" id="{{$item->filterKelahiran(app('request')->input('year'))->id}}" value="{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P}}" class="form-control data-input" style="border: none"></td>
                <td><input type="number" name="lahir_mati_P" id="{{$item->filterKelahiran(app('request')->input('year'))->id}}" value="{{$item->filterKelahiran(app('request')->input('year'))->lahir_mati_P}}" class="form-control data-input" style="border: none"></td>
                <td id="lahir_P{{$item->filterKelahiran(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P + $item->filterKelahiran(app('request')->input('year'))->lahir_mati_P}}</td>
                <td id="lahir_hidup_LP{{$item->filterKelahiran(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L}}</td>
                <td id="lahir_mati_LP{{$item->filterKelahiran(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_mati_P + $item->filterKelahiran(app('request')->input('year'))->lahir_mati_L}}</td>
                <td id="lahir_hidup_mati_LP{{$item->filterKelahiran(app('request')->input('year'))->id}}">{{$item->filterKelahiran(app('request')->input('year'))->lahir_hidup_P + $item->filterKelahiran(app('request')->input('year'))->lahir_mati_P + $item->filterKelahiran(app('request')->input('year'))->lahir_mati_L + $item->filterKelahiran(app('request')->input('year'))->lahir_hidup_L}}</td> --}}

              </tr>
              @endif
            @endforeach
            <tr>
                <td colspan="3">Jumlah Kab/Kota</td>
                <td>{{$totalLahirHidupL}}</td>
                <td>{{$totalLahirHidupP}}</td>
                <td>{{$totalLahirHidupL + $totalLahirHidupP}}</td>
                
                <td id="kn1_L">{{$totalkn1_L}}</td>
                <td id="percentage_kn1_L">{{$totalLahirHidupL > 0?number_format($totalkn1_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td id="kn1_P">{{$totalkn1_P}}</td>
                <td id="percentage_kn1_P">{{$totalLahirHidupP > 0?number_format($totalkn1_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td id="total_kn1">{{$totalkn1_L + $totalkn1_P}}</td>
                <td id="percentage_total_kn1">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn1_L + $totalkn1_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                
                <td id="kn_lengkap_L">{{$totalkn_lengkap_L}}</td>
                <td id="percentage_kn_lengkap_L">{{$totalLahirHidupL > 0?number_format($totalkn_lengkap_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td id="kn_lengkap_P">{{$totalkn_lengkap_P}}</td>
                <td id="percentage_kn_lengkap_P">{{$totalLahirHidupP > 0?number_format($totalkn_lengkap_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td id="total_kn_lengkap">{{$totalkn_lengkap_L + $totalkn_lengkap_P}}</td>
                <td id="percentage_total_kn_lengkap">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn_lengkap_L + $totalkn_lengkap_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                
                <td id="hipo_L">{{$totalhipo_L}}</td>
                <td id="percentage_hipo_L">{{$totalLahirHidupL > 0?number_format($totalhipo_L / $totalLahirHidupL * 100, 2):0}}%</td>
                <td id="hipo_P">{{$totalhipo_P}}</td>
                <td id="percentage_hipo_P">{{$totalLahirHidupP > 0?number_format($totalhipo_P / $totalLahirHidupP * 100, 2):0}}%</td>
                <td id="total_hipo">{{$totalhipo_L + $totalhipo_P}}</td>
                <td id="percentage_total_hipo">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalhipo_L + $totalhipo_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                <td></td>
            </tr>
            @endrole
        </tbody>
    </table>
</div>
<div class="flexbox">
    <div class="box_puskesmas">
        <p>Kepala Puskesmas</p>
        <div class="nama_dan_nip">
            <p>Nama: {{Auth::user()->nama}}</p>
            <p>Nip: {{Auth::user()->nip}}</p>
        </div>
    </div>
    <div class="box_program">
        <p>Pengelola Program</p>
        <div class="nama_dan_nip">
            <p>Nama: {{$nama_pengelola}}</p>
            <p>Nip: {{$nip_pengelola}}</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.print();
</script>
