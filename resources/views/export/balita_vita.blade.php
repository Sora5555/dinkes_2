<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN PEMBERIAN VITAMIN A PADA BAYI DAN ANAK BALITA MENURUT KECAMATAN DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="3">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="3">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="3">Desa</th>
        @endrole
        <th colspan="3">Bayi 6-11 Bulan</th>
        <th colspan="3">Bayi 12-59 Bulan</th>
        <th colspan="3">Bayi 6-59 Bulan</th>
    </tr>
    <tr>
        <th rowspan="2">Jumlah Bayi</th>
        <th colspan="2">Mendapat Vit A</th>
        <th rowspan="2">Jumlah Bayi</th>
        <th colspan="2">Mendapat Vit A</th>
        <th rowspan="2">Jumlah Bayi</th>
        <th colspan="2">Mendapat Vit A</th>
    </tr>
    <tr>
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
            $totalJumlah6 = 0;
            $totalVita6 = 0;

            $totalJumlah12 = 0;
            $totalVita12 = 0;

            $totalJumlahAll = 0;
            $totalVitaAll = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
            $jumlah6 = $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"];
            $vita6 = $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_6')["total"];

            $jumlah12 = $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"];
            $vita12 = $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_12')["total"];

            $jumlahAll = $jumlah6 + $jumlah12;
            $vitaAll = $vita6 + $vita12;

            // Accumulate totals
            $totalJumlah6 += $jumlah6;
            $totalVita6 += $vita6;

            $totalJumlah12 += $jumlah12;
            $totalVita12 += $vita12;

            $totalJumlahAll += $jumlahAll;
            $totalVitaAll += $vitaAll;
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_6')["total"]}}</td>

            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_6')["total"]
            /$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_12')["total"]}}</td>

            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_12')["total"]
            /$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"] + $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_12')["total"] + $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_6')["total"]}}</td>

            <td>{{$item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"] + $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_12')["total"] + $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'vita_6')["total"])
            /($item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_6')["total"] + $item->unitKerjaAmbil('filterBalitaVita', Session::get('year'), 'jumlah_12')["total"]) * 100, 2
            ):0}}</td>
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlah6 }}</td>
            <td>{{ $totalVita6 }}</td>
            <td>{{ $totalJumlah6 > 0 ? number_format($totalVita6 / $totalJumlah6 * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlah12 }}</td>
            <td>{{ $totalVita12 }}</td>
            <td>{{ $totalJumlah12 > 0 ? number_format($totalVita12 / $totalJumlah12 * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahAll }}</td>
            <td>{{ $totalVitaAll }}</td>
            <td>{{ $totalJumlahAll > 0 ? number_format($totalVitaAll / $totalJumlahAll * 100, 2) : 0 }}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterBalitaVita(Session::get('year')))
        @php
// Fetch data for the current row
            $jumlah6 = $item->filterBalitaVita(Session::get('year'))->jumlah_6;
            $vita6 = $item->filterBalitaVita(Session::get('year'))->vita_6;

            $jumlah12 = $item->filterBalitaVita(Session::get('year'))->jumlah_12;
            $vita12 = $item->filterBalitaVita(Session::get('year'))->vita_12;

            $jumlahAll = $jumlah6 + $jumlah12;
            $vitaAll = $vita6 + $vita12;

            // Accumulate totals
            $totalJumlah6 += $jumlah6;
            $totalVita6 += $vita6;

            $totalJumlah12 += $jumlah12;
            $totalVita12 += $vita12;

            $totalJumlahAll += $jumlahAll;
            $totalVitaAll += $vitaAll;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterBalitaVita(Session::get('year'))->jumlah_6}}</td>
            <td>{{$item->filterBalitaVita(Session::get('year'))->vita_6}}</td>
            <td id="persen_6{{$item->filterBalitaVita(Session::get('year'))->id}}">
                {{$item->filterBalitaVita(Session::get('year'))->jumlah_6 > 0 ? 
                number_format($item->filterBalitaVita(Session::get('year'))->vita_6 
                / $item->filterBalitaVita(Session::get('year'))->jumlah_6 * 100, 2) : 0}}
            </td>

            <td>{{$item->filterBalitaVita(Session::get('year'))->jumlah_12}}</td>
            <td>{{$item->filterBalitaVita(Session::get('year'))->vita_12}}</td>
            <td id="persen_12{{$item->filterBalitaVita(Session::get('year'))->id}}">
                {{$item->filterBalitaVita(Session::get('year'))->jumlah_12 > 0 ? 
                number_format($item->filterBalitaVita(Session::get('year'))->vita_12 
                / $item->filterBalitaVita(Session::get('year'))->jumlah_12 * 100, 2) : 0}}
            </td>

            
            <td id="total_jumlah{{$item->filterBalitaVita(Session::get('year'))->id}}">{{$item->filterBalitaVita(Session::get('year'))->jumlah_6 + $item->filterBalitaVita(Session::get('year'))->jumlah_12}}</td>
            <td id="total_vita{{$item->filterBalitaVita(Session::get('year'))->id}}">{{$item->filterBalitaVita(Session::get('year'))->vita_6 + $item->filterBalitaVita(Session::get('year'))->vita_12}}</td>
            <td id="persen_total{{$item->filterBalitaVita(Session::get('year'))->id}}">{{$item->filterBalitaVita(Session::get('year'))->jumlah_6 + $item->filterBalitaVita(Session::get('year'))->jumlah_12>0?
                number_format(($item->filterBalitaVita(Session::get('year'))->vita_6 + $item->filterBalitaVita(Session::get('year'))->vita_12)
                /($item->filterBalitaVita(Session::get('year'))->jumlah_6 + $item->filterBalitaVita(Session::get('year'))->jumlah_12) * 100, 2):0}}</td>
            
            
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlah6 }}</td>
            <td>{{ $totalVita6 }}</td>
            <td>{{ $totalJumlah6 > 0 ? number_format($totalVita6 / $totalJumlah6 * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlah12 }}</td>
            <td>{{ $totalVita12 }}</td>
            <td>{{ $totalJumlah12 > 0 ? number_format($totalVita12 / $totalJumlah12 * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahAll }}</td>
            <td>{{ $totalVitaAll }}</td>
            <td>{{ $totalJumlahAll > 0 ? number_format($totalVitaAll / $totalJumlahAll * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>