<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>BAYI BERAT BADAN LAHIR RENDAH (BBLR) DAN PREMATUR MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="3" rowspan="2">Jumlah Lahir Hidup</th>
        <th colspan="6">Bayi Baru Lahir Ditimbang</th>
        <th colspan="6">Bayi BBLR</th>
        <th colspan="6">Prematur</th>
    </tr>
    <tr>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
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
        @php
            $lahir_hidup_L = 0;
            $lahir_hidup_P = 0;
            $timbang_L = 0;
            $timbang_P = 0;
            $bblr_L = 0;
            $bblr_P = 0;
            $prematur_L = 0;
            $prematur_P = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        $lahir_hidup_L += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"];
        $lahir_hidup_P += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"];
        $timbang_L += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"];
        $timbang_P += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"];
        $bblr_L += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"];
        $bblr_P += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"];
        $prematur_L += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"];
        $prematur_P += $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"];
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]
                + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                ):0
                }}</td>
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                ):0
                }}</td>
                
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"])
                /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                ):0
                }}
            </td>
            
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                ):0
                }}</td>
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                ):0
                }}</td>
                
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"])
                /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                ):0
                }}
            </td>
            
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                ):0
                }}</td>
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"]
                /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                ):0
                }}</td>
                
            <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"])
                /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                ):0
                }}
            </td>
                
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{$timbang_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($timbang_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$timbang_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($timbang_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$timbang_P + $timbang_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($timbang_P + $timbang_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            <td>{{$bblr_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($bblr_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bblr_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($bblr_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$bblr_P + $bblr_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($bblr_P + $bblr_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            <td>{{$prematur_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($prematur_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bblr_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($prematur_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$prematur_P + $prematur_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($prematur_P + $prematur_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterBblr(Session::get('year')))
        @php
            $lahir_hidup_L += $item->filterKelahiran(Session::get('year'))->lahir_hidup_L;
            $lahir_hidup_P += $item->filterKelahiran(Session::get('year'))->lahir_hidup_P;
            $timbang_P += $item->filterBblr(Session::get('year'))->timbang_P;
            $timbang_L += $item->filterBblr(Session::get('year'))->timbang_L;
            $bblr_L += $item->filterBblr(Session::get('year'))->bblr_L;
            $bblr_P += $item->filterBblr(Session::get('year'))->bblr_P;
            $prematur_L += $item->filterBblr(Session::get('year'))->prematur_L;
            $prematur_P += $item->filterBblr(Session::get('year'))->prematur_P;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            
            @php
    $filterBblr = $item->filterBblr(Session::get('year'));
    $filterKelahiran = $item->filterKelahiran(Session::get('year'));
@endphp

<td>{{ $filterBblr->timbang_L }}</td>
<td id="timbang_L{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_L > 0 ? number_format($filterBblr->timbang_L / $filterKelahiran->lahir_hidup_L * 100, 2) : 0 }}
</td>
<td>{{ $filterBblr->timbang_P }}</td>
<td id="timbang_P{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_P > 0 ? number_format($filterBblr->timbang_P / $filterKelahiran->lahir_hidup_P * 100, 2) : 0 }}
</td>
<td id="timbang_LP{{ $filterBblr->id }}">
    {{ $filterBblr->timbang_L + $filterBblr->timbang_P }}
</td>
<td id="persen_timbang_LP{{ $filterBblr->id }}">
    {{
        ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) > 0 
        ? number_format(
            ($filterBblr->timbang_L + $filterBblr->timbang_P) /
            ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) * 100, 2
          ) 
        : 0
    }}
</td>
<td>{{ $filterBblr->bblr_L }}</td>
<td id="bblr_L{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_L > 0 ? number_format($filterBblr->bblr_L / $filterKelahiran->lahir_hidup_L * 100, 2) : 0 }}
</td>
<td>{{ $filterBblr->bblr_P }}</td>
<td id="bblr_P{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_P > 0 ? number_format($filterBblr->bblr_P / $filterKelahiran->lahir_hidup_P * 100, 2) : 0 }}
</td>
<td id="bblr_LP{{ $filterBblr->id }}">
    {{ $filterBblr->bblr_L + $filterBblr->bblr_P }}
</td>
<td id="persen_bblr_LP{{ $filterBblr->id }}">
    {{
        ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) > 0 
        ? number_format(
            ($filterBblr->bblr_L + $filterBblr->bblr_P) /
            ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) * 100, 2
          ) 
        : 0
    }}
</td>
<td>{{ $filterBblr->prematur_L }}</td>
<td id="prematur_L{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_L > 0 ? number_format($filterBblr->prematur_L / $filterKelahiran->lahir_hidup_L * 100, 2) : 0 }}
</td>
<td>{{ $filterBblr->prematur_P }}</td>
<td id="prematur_P{{ $filterBblr->id }}">
    {{ $filterKelahiran->lahir_hidup_P > 0 ? number_format($filterBblr->prematur_P / $filterKelahiran->lahir_hidup_P * 100, 2) : 0 }}
</td>
<td id="prematur_LP{{ $filterBblr->id }}">
    {{ $filterBblr->prematur_L + $filterBblr->prematur_P }}
</td>
<td id="persen_prematur_LP{{ $filterBblr->id }}">
    {{
        ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) > 0 
        ? number_format(
            ($filterBblr->prematur_L + $filterBblr->prematur_P) /
            ($filterKelahiran->lahir_hidup_P + $filterKelahiran->lahir_hidup_L) * 100, 2
          ) 
        : 0
    }}
</td>

            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{$timbang_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($timbang_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$timbang_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($timbang_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$timbang_P + $timbang_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($timbang_P + $timbang_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            <td>{{$bblr_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($bblr_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bblr_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($bblr_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$bblr_P + $bblr_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($bblr_P + $bblr_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            <td>{{$prematur_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($prematur_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bblr_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($prematur_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$prematur_P + $prematur_L}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L > 0?number_format((($prematur_P + $prematur_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
        </tr>
        @endrole
    </tbody>
</table>