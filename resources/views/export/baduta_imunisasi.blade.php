<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN IMUNISASI LANJUTAN DPT-HB-Hib 4 DAN CAMPAK RUBELA 2 PADA ANAK USIA DIBAWAH DUA TAHUN (BADUTA)																	
                MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th rowspan="3" colspan="3">Jumlah Baduta</th>
        <th colspan="12">Baduta Diimunisasi</th>
    </tr>
    <tr>
        <th colspan="6">DPT-HB-Hib4</th>
        <th colspan="6">CAMPAK RUBELA2</th>
    </tr>
    <tr>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
    </tr>
    <tr>
        <th>L&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>P&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>L+P</th>
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
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
$totalLahirHidupL = 0;
$totalLahirHidupP = 0;
$totalLahirHidup = 0;

$totalDptL = 0;
$totalDptP = 0;
$totalDpt = 0;

$totalRubelaL = 0;
$totalRubelaP = 0;
$totalRubela = 0;
@endphp

        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
            $jumlahL = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"];
            $jumlahP = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"];
            $jumlahTotal = $jumlahL + $jumlahP;

            $dptL = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"];
            $dptP = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"];
            $dptTotal = $dptL + $dptP;

            $rubelaL = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"];
            $rubelaP = $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"];
            $rubelaTotal = $rubelaL + $rubelaP;

            // Accumulate totals
            $totalLahirHidupL += $jumlahL;
            $totalLahirHidupP += $jumlahP;
            $totalLahirHidup += $jumlahTotal;

            $totalDptL += $dptL;
            $totalDptP += $dptP;
            $totalDpt += $dptTotal;

            $totalRubelaL += $rubelaL;
            $totalRubelaP += $rubelaP;
            $totalRubela += $rubelaTotal;
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]
            /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"]
            /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"])
            /($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]) * 100, 2
            ):0}}</td>
           
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]
            /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"]
            /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"])
            /($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]) * 100, 2
            ):0}}</td>
            
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{ $totalLahirHidupL }}</td>
            <td>{{ $totalLahirHidupP }}</td>
            <td>{{ $totalLahirHidup }}</td>
            <td>{{ $totalDptL }}</td>
            <td>{{ $totalLahirHidupL > 0 ? number_format($totalDptL / $totalLahirHidupL * 100, 2) : 0 }}</td>
            <td>{{ $totalDptP }}</td>
            <td>{{ $totalLahirHidupP > 0 ? number_format($totalDptP / $totalLahirHidupP * 100, 2) : 0 }}</td>
            <td>{{ $totalDpt }}</td>
            <td>{{ $totalLahirHidup > 0 ? number_format($totalDpt / $totalLahirHidup * 100, 2) : 0 }}</td>
            <td>{{ $totalRubelaL }}</td>
            <td>{{ $totalLahirHidupL > 0 ? number_format($totalRubelaL / $totalLahirHidupL * 100, 2) : 0 }}</td>
            <td>{{ $totalRubelaP }}</td>
            <td>{{ $totalLahirHidupP > 0 ? number_format($totalRubelaP / $totalLahirHidupP * 100, 2) : 0 }}</td>
            <td>{{ $totalRubela }}</td>
            <td>{{ $totalLahirHidup > 0 ? number_format($totalRubela / $totalLahirHidup * 100, 2) : 0 }}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterBadutaImunisasi(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L}}</td>
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P}}</td>
            <td id="jumlah_LP{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L}}
            </td>
            
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->dpt_L}}</td>
            <td id="dpt_L{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L > 0 ? 
                number_format($item->filterBadutaImunisasi(Session::get('year'))->dpt_L 
                / $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L * 100, 2) : 0}}
            </td>
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->dpt_P}}</td>
            <td id="dpt_P{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P > 0 ? 
                number_format($item->filterBadutaImunisasi(Session::get('year'))->dpt_P 
                / $item->filterBadutaImunisasi(Session::get('year'))->jumlah_P * 100, 2) : 0}}
            </td>
            
            <td id="total_dpt{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->dpt_P + $item->filterBadutaImunisasi(Session::get('year'))->dpt_L}}
            </td>
            <td id="persen_dpt{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L > 0 ? 
                number_format(($item->filterBadutaImunisasi(Session::get('year'))->dpt_P + $item->filterBadutaImunisasi(Session::get('year'))->dpt_L) 
                / ($item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L) * 100, 2) : 0}}
            </td>
            
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_L}}</td>
            <td id="rubela_L{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">
                {{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L > 0 ? 
                number_format($item->filterBadutaImunisasi(Session::get('year'))->rubela_L 
                / $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L * 100, 2) : 0}}
            </td>
            <td>{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_P}}</td>
            
            <td id="rubela_P{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P>0?
            number_format($item->filterBadutaImunisasi(Session::get('year'))->rubela_P
            /$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P * 100, 2):0}}</td>
            
            <td id="total_rubela{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_P + $item->filterBadutaImunisasi(Session::get('year'))->rubela_L}}</td>
            <td id="persen_rubela{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L>0?
                number_format(($item->filterBadutaImunisasi(Session::get('year'))->rubela_P + $item->filterBadutaImunisasi(Session::get('year'))->rubela_L)
                /($item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L) * 100, 2):0}}</td>
            
            
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{ $totalLahirHidupL }}</td>
            <td>{{ $totalLahirHidupP }}</td>
            <td>{{ $totalLahirHidup }}</td>
            <td>{{ $totalDptL }}</td>
            <td>{{ $totalLahirHidupL > 0 ? number_format($totalDptL / $totalLahirHidupL * 100, 2) : 0 }}</td>
            <td>{{ $totalDptP }}</td>
            <td>{{ $totalLahirHidupP > 0 ? number_format($totalDptP / $totalLahirHidupP * 100, 2) : 0 }}</td>
            <td>{{ $totalDpt }}</td>
            <td>{{ $totalLahirHidup > 0 ? number_format($totalDpt / $totalLahirHidup * 100, 2) : 0 }}</td>
            <td>{{ $totalRubelaL }}</td>
            <td>{{ $totalLahirHidupL > 0 ? number_format($totalRubelaL / $totalLahirHidupL * 100, 2) : 0 }}</td>
            <td>{{ $totalRubelaP }}</td>
            <td>{{ $totalLahirHidupP > 0 ? number_format($totalRubelaP / $totalLahirHidupP * 100, 2) : 0 }}</td>
            <td>{{ $totalRubela }}</td>
            <td>{{ $totalLahirHidup > 0 ? number_format($totalRubela / $totalLahirHidup * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>