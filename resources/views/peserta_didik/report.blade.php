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
<h4>CAKUPAN PELAYANAN KESEHATAN PESERTA DIDIK SD/MI, SMP/MTS, SMA/MA SERTA USIA PENDIDIKAN DASAR MENURUT KECAMATAN DAN PUSKESMAS	
</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>CAKUPAN PELAYANAN KESEHATAN PESERTA DIDIK SD/MI, SMP/MTS, SMA/MA SERTA USIA PENDIDIKAN DASAR MENURUT KECAMATAN DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN {{$tahun}}</h4>
<div class="table-responsive">
    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="text-center">
        <tr>
            <th rowspan="2">No</th>
            @role("Pihak Wajib Pajak|Puskesmas")
            <th rowspan="2">Kecamatan</th>
            <th rowspan="2">Desa</th>
            @endrole
            @role("Admin")
            <th rowspan="2">Kecamatan</th>
            @endrole
            <th colspan="3">Kelas 1 SD/MI</th>
            <th colspan="3">Kelas 7 SMP/MTS</th>
            <th colspan="3">Kelas 10 SMA/MA</th>
            <th colspan="3">Usia Pendidikan Dasar (Kelas 1 - 9)</th>
            <th colspan="3">SD/MI</th>
            <th colspan="3">SMP/MTS</th>
            <th colspan="3">SMA/MA</th>
        </tr>
        <tr>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
            <th>jumlah Peserta Didik</th>
            <th>Mendapat Pelayanan</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_1"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_1"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_1"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_1"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_1"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_7"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_7"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_7"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_7"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_7"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_10"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_10"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_10"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_kelas_10"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_kelas_10"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_usia_dasar"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_usia_dasar"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_usia_dasar"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_usia_dasar"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_usia_dasar"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_sd"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sd"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sd"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sd"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_sd"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_smp"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_smp"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_smp"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_smp"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_smp"] * 100, 2):0}}</td>
                
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_sma"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sma"]}}</td>
                <td>{{$item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sma"] > 0?number_format($item->peserta_didik_per_desa(app('request')->input('year'))["pelayanan_sma"]/$item->peserta_didik_per_desa(app('request')->input('year'))["jumlah_sma"] * 100, 2):0}}</td>
              </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_kelas_1}}</td>
                <td>{{$total_pelayanan_kelas_1}}</td>
                <td>{{$total_pelayanan_kelas_1 > 0?number_format($total_pelayanan_kelas_1/$total_kelas_1 * 100, 2):0}}</td>
                
                <td>{{$total_kelas_7}}</td>
                <td>{{$total_pelayanan_kelas_7}}</td>
                <td>{{$total_pelayanan_kelas_7 > 0?number_format($total_pelayanan_kelas_7/$total_kelas_7 * 100, 2):0}}</td>
                
                <td>{{$total_kelas_10}}</td>
                <td>{{$total_pelayanan_kelas_10}}</td>
                <td>{{$total_pelayanan_kelas_10 > 0?number_format($total_pelayanan_kelas_10/$total_kelas_10 * 100, 2):0}}</td>
                
                <td>{{$total_usia_dasar}}</td>
                <td>{{$total_pelayanan_usia_dasar}}</td>
                <td>{{$total_pelayanan_usia_dasar > 0?number_format($total_pelayanan_usia_dasar/$total_usia_dasar * 100, 2):0}}</td>
                
                <td>{{$total_sd}}</td>
                <td>{{$total_pelayanan_sd}}</td>
                <td>{{$total_pelayanan_sd > 0?number_format($total_pelayanan_sd/$total_sd * 100, 2):0}}</td>
                
                <td>{{$total_smp}}</td>
                <td>{{$total_pelayanan_smp}}</td>
                <td>{{$total_pelayanan_smp > 0?number_format($total_pelayanan_smp/$total_smp * 100, 2):0}}</td>
                
                <td>{{$total_sma}}</td>
                <td>{{$total_pelayanan_sma}}</td>
                <td>{{$total_pelayanan_sma > 0?number_format($total_pelayanan_sma/$total_sma * 100, 2):0}}</td>
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterPesertaDidik(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_1}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_1}}</td>
                <td id="kelas_1{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_1 > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_1/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_1)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_7}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_7}}</td>
                <td id="kelas_7{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_7 > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_7/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_7)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_10}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_10}}</td>
                <td id="kelas_10{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_10 > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_kelas_10/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_kelas_10)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_usia_dasar}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_usia_dasar}}</td>
                <td id="usia_dasar{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_usia_dasar > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_usia_dasar/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_usia_dasar)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_sd}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_sd}}</td>
                <td id="sd{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_sd > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_sd/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_sd)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_smp}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_smp}}</td>
                <td id="smp{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_smp/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_smp)*100, 2):0}}%</td>
                
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_sma}}</td>
                <td>{{$item->filterPesertaDidik(app('request')->input('year'))->pelayanan_sma}}</td>
                <td id="sma{{$item->filterPesertaDidik(app('request')->input('year'))->id}}">{{$item->filterPesertaDidik(app('request')->input('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(app('request')->input('year'))->pelayanan_smp/($item->filterPesertaDidik(app('request')->input('year'))->jumlah_smp)*100, 2):0}}%</td>

              </tr>
              @endif
            @endforeach
            <td colspan="3">Jumlah Kab/Kota</td>
                <td id="jumlah_kelas_1">{{$total_kelas_1}}</td>
                <td id="pelayanan_kelas_1">{{$total_pelayanan_kelas_1}}</td>
                <td id="percentage_kelas_1">{{$total_pelayanan_kelas_1 > 0?number_format($total_pelayanan_kelas_1/$total_kelas_1 * 100, 2):0}}</td>
                
                <td id="jumlah_kelas_7">{{$total_kelas_7}}</td>
                <td id="pelayanan_kelas_7">{{$total_pelayanan_kelas_7}}</td>
                <td id="percentage_kelas_7">{{$total_pelayanan_kelas_7 > 0?number_format($total_pelayanan_kelas_7/$total_kelas_7 * 100, 2):0}}</td>
                
                <td id="jumlah_kelas_10">{{$total_kelas_10}}</td>
                <td id="pelayanan_kelas_10">{{$total_pelayanan_kelas_10}}</td>
                <td id="percentage_kelas_10">{{$total_pelayanan_kelas_10 > 0?number_format($total_pelayanan_kelas_10/$total_kelas_10 * 100, 2):0}}</td>
                
                <td id="jumlah_usia_dasar">{{$total_usia_dasar}}</td>
                <td id="pelayanan_usia_dasar">{{$total_pelayanan_usia_dasar}}</td>
                <td id="percentage_usia_dasar">{{$total_pelayanan_usia_dasar > 0?number_format($total_pelayanan_usia_dasar/$total_usia_dasar * 100, 2):0}}</td>
                
                <td id="jumlah_sd">{{$total_sd}}</td>
                <td id="pelayanan_sd">{{$total_pelayanan_sd}}</td>
                <td id="percentage_sd">{{$total_pelayanan_sd > 0?number_format($total_pelayanan_sd/$total_sd * 100, 2):0}}</td>
                
                <td id="jumlah_smp">{{$total_smp}}</td>
                <td id="pelayanan_smp">{{$total_pelayanan_smp}}</td>
                <td id="percentage_smp">{{$total_pelayanan_smp > 0?number_format($total_pelayanan_smp/$total_smp * 100, 2):0}}</td>
                
                <td id="jumlah_sma">{{$total_sma}}</td>
                <td id="pelayanan_sma">{{$total_pelayanan_sma}}</td>
                <td id="percentage_sma">{{$total_pelayanan_sma > 0?number_format($total_pelayanan_sma/$total_sma * 100, 2):0}}</td>
                <td></td>
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
