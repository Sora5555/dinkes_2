<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PERSENTASE CAKUPAN IMUNISASI Td PADA WANITA USIA SUBUR (HAMIL DAN TIDAK HAMIL) MENURUT KECAMATAN DAN PUSKESMAS</th>
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
            <th rowspan="3">Jumlah Wus (15-39 Tahun)</th>
            <th colspan="10">Imunisasi Td Pada WUS Tidak Hamil</th>
        </tr>
        <tr>
            <th colspan="2">Td1</th>
            <th colspan="2">Td2</th>
            <th colspan="2">Td3</th>
            <th colspan="2">Td4</th>
            <th colspan="2">Td5</th>
        </tr>
    <tr>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
        $jumlah = 0;
        $td1 = 0;
        $td2 = 0;
        $td3 = 0;
        $td4 = 0;
        $td5 = 0;
    @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        $jumlah += $item->wus_hamil_per_desa(Session::get('year'))["jumlah"];
        $td1 += $item->wus_hamil_per_desa(Session::get('year'))["td1"];
        $td2 += $item->wus_hamil_per_desa(Session::get('year'))["td2"];
        $td3 += $item->wus_hamil_per_desa(Session::get('year'))["td3"];
        $td4 += $item->wus_hamil_per_desa(Session::get('year'))["td4"];
        $td5 += $item->wus_hamil_per_desa(Session::get('year'))["td5"];
    @endphp
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["td1"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->wus_hamil_per_desa(Session::get('year'))["td1"]/$item->wus_hamil_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["td2"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->wus_hamil_per_desa(Session::get('year'))["td2"]/$item->wus_hamil_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["td3"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->wus_hamil_per_desa(Session::get('year'))["td3"]/$item->wus_hamil_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["td4"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->wus_hamil_per_desa(Session::get('year'))["td4"]/$item->wus_hamil_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["td5"]}}</td>
            <td>{{$item->wus_hamil_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->wus_hamil_per_desa(Session::get('year'))["td5"]/$item->wus_hamil_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah}}</td>
            <td>{{$td1}}</td>
            <td>{{$jumlah>0?number_format(($td1/$jumlah) * 100, 2):0}}</td>
            <td>{{$td2}}</td>
            <td>{{$jumlah>0?number_format(($td2/$jumlah) * 100, 2):0}}</td>
            <td>{{$td3}}</td>
            <td>{{$jumlah>0?number_format(($td3/$jumlah) * 100, 2):0}}</td>
            <td>{{$td4}}</td>
            <td>{{$jumlah>0?number_format(($td4/$jumlah) * 100, 2):0}}</td>
            <td>{{$td5}}</td>
            <td>{{$jumlah>0?number_format(($td5/$jumlah) * 100, 2):0}}</td>
            </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterWus(Session::get('year'), 1))
        @php
        $jumlah += $item->filterWus(Session::get('year'), 1)->jumlah;
        $td1 += $item->filterWus(Session::get('year'), 1)->td1;
        $td2 += $item->filterWus(Session::get('year'), 1)->td2;
        $td3 += $item->filterWus(Session::get('year'), 1)->td3;
        $td4 += $item->filterWus(Session::get('year'), 1)->td4;
        $td5 += $item->filterWus(Session::get('year'), 1)->td5;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{ $item->filterWus(Session::get('year'), 1)->jumlah }}</td>

            <td>{{ $item->filterWus(Session::get('year'), 1)->td1 }}</td>
            <td id="td1{{ $item->filterWus(Session::get('year'), 1)->id }}">
                {{ $item->filterWus(Session::get('year'), 1)->jumlah > 0 ? number_format($item->filterWus(Session::get('year'), 1)->td1 / $item->filterWus(Session::get('year'), 1)->jumlah * 100, 2) : 0 }}
            </td>
            
            <td>{{ $item->filterWus(Session::get('year'), 1)->td2 }}</td>
            <td id="td2{{ $item->filterWus(Session::get('year'), 1)->id }}">
                {{ $item->filterWus(Session::get('year'), 1)->jumlah > 0 ? number_format($item->filterWus(Session::get('year'), 1)->td2 / $item->filterWus(Session::get('year'), 1)->jumlah * 100, 2) : 0 }}
            </td>
            
            <td>{{ $item->filterWus(Session::get('year'), 1)->td3 }}</td>
            <td id="td3{{ $item->filterWus(Session::get('year'), 1)->id }}">
                {{ $item->filterWus(Session::get('year'), 1)->jumlah > 0 ? number_format($item->filterWus(Session::get('year'), 1)->td3 / $item->filterWus(Session::get('year'), 1)->jumlah * 100, 2) : 0 }}
            </td>
            
            <td>{{ $item->filterWus(Session::get('year'), 1)->td4 }}</td>
            <td id="td4{{ $item->filterWus(Session::get('year'), 1)->id }}">
                {{ $item->filterWus(Session::get('year'), 1)->jumlah > 0 ? number_format($item->filterWus(Session::get('year'), 1)->td4 / $item->filterWus(Session::get('year'), 1)->jumlah * 100, 2) : 0 }}
            </td>
            
            <td>{{ $item->filterWus(Session::get('year'), 1)->td5 }}</td>
            <td id="td5{{ $item->filterWus(Session::get('year'), 1)->id }}">
                {{ $item->filterWus(Session::get('year'), 1)->jumlah > 0 ? number_format($item->filterWus(Session::get('year'), 1)->td5 / $item->filterWus(Session::get('year'), 1)->jumlah * 100, 2) : 0 }}
            </td>
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah}}</td>
            <td>{{$td1}}</td>
            <td>{{$jumlah>0?number_format(($td1/$jumlah) * 100, 2):0}}</td>
            <td>{{$td2}}</td>
            <td>{{$jumlah>0?number_format(($td2/$jumlah) * 100, 2):0}}</td>
            <td>{{$td3}}</td>
            <td>{{$jumlah>0?number_format(($td3/$jumlah) * 100, 2):0}}</td>
            <td>{{$td4}}</td>
            <td>{{$jumlah>0?number_format(($td4/$jumlah) * 100, 2):0}}</td>
            <td>{{$td5}}</td>
            <td>{{$jumlah>0?number_format(($td5/$jumlah) * 100, 2):0}}</td>
            </tr>
        @endrole
    </tbody>
</table>