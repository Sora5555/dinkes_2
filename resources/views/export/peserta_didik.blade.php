<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN PELAYANAN KESEHATAN PESERTA DIDIK SD/MI, SMP/MTS, SMA/MA SERTA USIA PENDIDIKAN DASAR MENURUT KECAMATAN DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr>
        <th rowspan="2">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="2">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="2">Desa</th>
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
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_1"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_1"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_1"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_1"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_1"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_7"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_7"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_7"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_7"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_7"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_10"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_10"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_10"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_10"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_10"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_usia_dasar"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_usia_dasar"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_usia_dasar"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_usia_dasar"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_usia_dasar"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sd"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sd"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sd"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sd"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sd"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_smp"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_smp"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_smp"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_smp"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_smp"] * 100, 2):0}}</td>
            
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sma"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sma"]}}</td>
            <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sma"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sma"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sma"] * 100, 2):0}}</td>
          </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
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
        @if($item->filterPesertaDidik(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1}}</td>
            <td id="kelas_1{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7}}</td>
            <td id="kelas_7{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10}}</td>
            <td id="kelas_10{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar}}</td>
            <td id="usia_dasar{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar/($item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sd}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_sd}}</td>
            <td id="sd{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sd > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_sd/($item->filterPesertaDidik(Session::get('year'))->jumlah_sd)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_smp}}</td>
            <td id="smp{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_smp/($item->filterPesertaDidik(Session::get('year'))->jumlah_smp)*100, 2):0}}%</td>
            
            <td>{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sma}}</td>
            <td>{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_sma}}</td>
            <td id="sma{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_smp/($item->filterPesertaDidik(Session::get('year'))->jumlah_smp)*100, 2):0}}%</td>

                                                

          </tr>
          @endif
        @endforeach
        <td></td>
        <td></td>
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