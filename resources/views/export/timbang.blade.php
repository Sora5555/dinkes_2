<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH BALITA DITIMBANG MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="4">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="4">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="4">Desa</th>
        @endrole
        <th colspan="3">Balita</th>
                                <th colspan="6" rowspan="2">Ditimbang</th>
                            </tr>
                            <tr>
                                <th rowspan="2" colspan="3">Jumlah Sasaran Balita (S)</th>
                            </tr>
    <tr>
        <th colspan="3">Jumlah (D)</th>
        <th colspan="3">%(D/S)</th>
    </tr>   
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
    </tr>
    </thead>
    <tbody>
        @php
$totalJumlahL = 0;
$totalJumlahP = 0;
$totalJumlahAll = 0;

$totalTimbangL = 0;
$totalTimbangP = 0;
$totalTimbangAll = 0;
@endphp

        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
$jumlahL = $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"];
$jumlahP = $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"];
$jumlahAll = $jumlahL + $jumlahP;

$timbangL = $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_L')["total"];
$timbangP = $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_P')["total"];
$timbangAll = $timbangL + $timbangP;

// Accumulate totals
$totalJumlahL += $jumlahL;
$totalJumlahP += $jumlahP;
$totalJumlahAll += $jumlahAll;

$totalTimbangL += $timbangL;
$totalTimbangP += $timbangP;
$totalTimbangAll += $timbangAll;
@endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_P')["total"] + $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_L')["total"]}}</td>

            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_L')["total"]
            /$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_P')["total"]
            /$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_L')["total"] + $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'timbang_P')["total"])
            /($item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterTimbang', Session::get('year'), 'jumlah_L')["total"]) * 100, 2
            ):0}}</td>
            
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahL }}</td>
            <td>{{ $totalJumlahP }}</td>
            <td>{{ $totalJumlahAll }}</td>
            <td>{{ $totalTimbangL }}</td>
            <td>{{ $totalTimbangP }}</td>
            <td>{{ $totalTimbangAll }}</td>
            <td>{{ $totalJumlahL > 0 ? number_format($totalTimbangL / $totalJumlahL * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahP > 0 ? number_format($totalTimbangP / $totalJumlahP * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahAll > 0 ? number_format($totalTimbangAll / $totalJumlahAll * 100, 2) : 0 }}</td>
        </tr>
        
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterTimbang(Session::get('year')))
        @php
        // Fetch data for the current row
        $jumlahL = $item->filterTimbang(Session::get('year'))->jumlah_L;
        $jumlahP = $item->filterTimbang(Session::get('year'))->jumlah_P;
        $jumlahAll = $jumlahL + $jumlahP;
        
        $timbangL = $item->filterTimbang(Session::get('year'))->timbang_L;
        $timbangP = $item->filterTimbang(Session::get('year'))->timbang_P;
        $timbangAll = $timbangL + $timbangP;
        
        // Accumulate totals
        $totalJumlahL += $jumlahL;
        $totalJumlahP += $jumlahP;
        $totalJumlahAll += $jumlahAll;
        
        $totalTimbangL += $timbangL;
        $totalTimbangP += $timbangP;
        $totalTimbangAll += $timbangAll;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterTimbang(Session::get('year'))->jumlah_L}}</td>
            <td>{{$item->filterTimbang(Session::get('year'))->jumlah_P}}</td>
            <td id="jumlah_LP{{$item->filterTimbang(Session::get('year'))->id}}">
                {{$item->filterTimbang(Session::get('year'))->jumlah_L + $item->filterTimbang(Session::get('year'))->jumlah_P}}
            </td>
            
            <td>{{$item->filterTimbang(Session::get('year'))->timbang_L}}</td>
            <td>{{$item->filterTimbang(Session::get('year'))->timbang_P}}</td>
            <td id="timbang_LP{{$item->filterTimbang(Session::get('year'))->id}}">
                {{$item->filterTimbang(Session::get('year'))->timbang_L + $item->filterTimbang(Session::get('year'))->timbang_P}}
            </td>
            
            
            <td id="persen_L{{$item->filterTimbang(Session::get('year'))->id}}">{{$item->filterTimbang(Session::get('year'))->jumlah_L>0?
                number_format($item->filterTimbang(Session::get('year'))->timbang_L
                /$item->filterTimbang(Session::get('year'))->jumlah_L * 100, 2):0}}</td>
            
            <td id="persen_P{{$item->filterTimbang(Session::get('year'))->id}}">{{$item->filterTimbang(Session::get('year'))->jumlah_P>0?
                number_format($item->filterTimbang(Session::get('year'))->timbang_P
                /$item->filterTimbang(Session::get('year'))->jumlah_P * 100, 2):0}}</td>
            
            <td id="persen_LP{{$item->filterTimbang(Session::get('year'))->id}}">{{($item->filterTimbang(Session::get('year'))->jumlah_P + $item->filterTimbang(Session::get('year'))->jumlah_L)>0?
                number_format(($item->filterTimbang(Session::get('year'))->timbang_L + $item->filterTimbang(Session::get('year'))->timbang_P)
                /($item->filterTimbang(Session::get('year'))->jumlah_L + $item->filterTimbang(Session::get('year'))->jumlah_P) * 100, 2):0}}</td>
            
            
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahL }}</td>
            <td>{{ $totalJumlahP }}</td>
            <td>{{ $totalJumlahAll }}</td>
            <td>{{ $totalTimbangL }}</td>
            <td>{{ $totalTimbangP }}</td>
            <td>{{ $totalTimbangAll }}</td>
            <td>{{ $totalJumlahL > 0 ? number_format($totalTimbangL / $totalJumlahL * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahP > 0 ? number_format($totalTimbangP / $totalJumlahP * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahAll > 0 ? number_format($totalTimbangAll / $totalJumlahAll * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>