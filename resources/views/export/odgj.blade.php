<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KUNJUNGAN PASIEN BARU RAWAT JALAN, RAWAT INAP, DAN KUNJUNGAN GANGGUAN JIWA DI SARANA PELAYANAN KESEHATANPELAYANAN KESEHATAN ORANG DENGAN GANGGUAN JIWA (ODGJ) BERAT  MENURUT KECAMATAN DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
        <tr>
            <th rowspan="3">Kecamatan</th>
            @role('Admin|superadmin')
            <th rowspan="3">Puskesmas</th>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            <th rowspan="3">Desa</th>
            @endrole
            <th rowspan="3">Sasaran ODGJ Berat</th>
            <th colspan="11">Pelayanan Kesehatan ODGJ berat</th>
        </tr>
    <tr>
        <th colspan="3">Skizofrenia</th>
        <th colspan="3">Psikotik Akut</th>
        <th colspan="3">Total</th>
        <th colspan="2">Mendapat Pelayanan Kesehatan</th>
    </tr>
    <tr>
        <th style="white-space:nowrap">0-14 th</th>
        <th style="white-space:nowrap">15-59 th</th>
        <th style="white-space:nowrap">>60 th</th>
        <th style="white-space:nowrap">0-14 th</th>
        <th style="white-space:nowrap">15-59 th</th>
        <th style="white-space:nowrap">>60 th</th>
        <th style="white-space:nowrap">0-14 th</th>
        <th style="white-space:nowrap">15-59 th</th>
        <th style="white-space:nowrap">>60 th</th>
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["sasaran"]}}</td>

            <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_0"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_15"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_60"]}}</td>

            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_0"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_15"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_60"]}}</td>
            
            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_0"] + $item->odgj_per_desa(Session::get('year'))["skizo_0"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_15"] + $item->odgj_per_desa(Session::get('year'))["skizo_15"]}}</td>
            <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_60"] + $item->odgj_per_desa(Session::get('year'))["skizo_60"]}}</td>

            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"]>0?number_format(($item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"])/$item->odgj_per_desa(Session::get('year'))["sasaran"]*100, 2):0}}</td>
            
          </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$total_sasaran}}</td>

            <td>{{$total_skizo_0}}</td>
            <td>{{$total_skizo_15}}</td>
            <td>{{$total_skizo_60}}</td>

            <td>{{$total_psiko_0}}</td>
            <td>{{$total_psiko_15}}</td>
            <td>{{$total_psiko_60}}</td>
            
            <td>{{$total_psiko_0 + $total_skizo_0}}</td>
            <td>{{$total_psiko_15 + $total_skizo_15}}</td>
            <td>{{$total_psiko_60 + $total_skizo_60}}</td>

            <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
            <td>{{$total_jiwa_L + $total_jiwa_P>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
            
            <td></td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterOdgj(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{ $item->filterOdgj(Session::get('year'))->sasaran }}</td>

            <td>{{ $item->filterOdgj(Session::get('year'))->skizo_0 }}</td>
            <td>{{ $item->filterOdgj(Session::get('year'))->skizo_15 }}</td>
            <td>{{ $item->filterOdgj(Session::get('year'))->skizo_60 }}</td>

            <td>{{ $item->filterOdgj(Session::get('year'))->psiko_0 }}</td>
            <td>{{ $item->filterOdgj(Session::get('year'))->psiko_15 }}</td>
            <td>{{ $item->filterOdgj(Session::get('year'))->psiko_60 }}</td>

            <td id="0{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_0 + $item->filterOdgj(Session::get('year'))->skizo_0}}</td>
            <td id="15{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_15 + $item->filterOdgj(Session::get('year'))->skizo_15}}</td>
            <td id="60{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_60 + $item->filterOdgj(Session::get('year'))->skizo_60}}</td>
            
            <td id="pelayanan{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterKunjungan(Session::get('year'))->jiwa_L + $item->filterKunjungan(Session::get('year'))->jiwa_P}}</td>
            <td id="persen{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->sasaran > 0? number_format(($item->filterKunjungan(Session::get('year'))->jiwa_L + $item->filterKunjungan(Session::get('year'))->jiwa_P) / $item->filterOdgj(Session::get('year'))->sasaran * 100, 2):0}}%</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td id="sasaran">{{$total_sasaran}}</td>

            <td id="skizo_0">{{$total_skizo_0}}</td>
            <td id="skizo_15">{{$total_skizo_15}}</td>
            <td id="skizo_60">{{$total_skizo_60}}</td>

            <td id="psiko_0">{{$total_psiko_0}}</td>
            <td id="psiko_15">{{$total_psiko_15}}</td>
            <td id="psiko_60">{{$total_psiko_60}}</td>
            
            <td id="total_0">{{$total_psiko_0 + $total_skizo_0}}</td>
            <td id="total_15">{{$total_psiko_15 + $total_skizo_15}}</td>
            <td id="total_60">{{$total_psiko_60 + $total_skizo_60}}</td>

            <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
            <td id="percentage">{{$total_jiwa_L + $total_jiwa_P>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
            
            <td></td>
        </tr>
        @endrole
    </tbody>
</table>