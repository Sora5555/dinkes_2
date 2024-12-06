<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN IMUNISASI DPT-HB-Hib 3, POLIO 4*, CAMPAK RUBELA, DAN IMUNISASI DASAR LENGKAP PADA BAYI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th rowspan="3" colspan="3">Jumlah Bayi (Surviving Infant)</th>
        <th colspan="24">Bayi Diimunisasi</th>
    </tr>
    <tr>
        <th colspan="6">DPT-HB-Hib3</th>
        <th colspan="6">POLIO 4*</th>
        <th colspan="6">CAMPAK RUBELA</th>
        <th colspan="6">IMUNISASI DASAR LENGKAP</th>
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
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L+P</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
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

    $totalPolioL = 0;
    $totalPolioP = 0;
    $totalPolio = 0;

    $totalRubelaL = 0;
    $totalRubelaP = 0;
    $totalRubela = 0;

    $totalLengkapL = 0;
    $totalLengkapP = 0;
    $totalLengkap = 0;
@endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        $lahirHidupL = $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"];
        $lahirHidupP = $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"];
        $lahirHidup = $lahirHidupL + $lahirHidupP;

        $dptL = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_L')["total"];
        $dptP = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_P')["total"];
        $dpt = $dptL + $dptP;

        $polioL = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_L')["total"];
        $polioP = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_P')["total"];
        $polio = $polioL + $polioP;

        $rubelaL = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_L')["total"];
        $rubelaP = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_P')["total"];
        $rubela = $rubelaL + $rubelaP;

        $lengkapL = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_L')["total"];
        $lengkapP = $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_P')["total"];
        $lengkap = $lengkapL + $lengkapP;

        $totalLahirHidupL += $lahirHidupL;
        $totalLahirHidupP += $lahirHidupP;
        $totalLahirHidup += $lahirHidup;

        $totalDptL += $dptL;
        $totalDptP += $dptP;
        $totalDpt += $dpt;

        $totalPolioL += $polioL;
        $totalPolioP += $polioP;
        $totalPolio += $polio;

        $totalRubelaL += $rubelaL;
        $totalRubelaP += $rubelaP;
        $totalRubela += $rubela;

        $totalLengkapL += $lengkapL;
        $totalLengkapP += $lengkapP;
        $totalLengkap += $lengkap;
    @endphp

        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'dpt_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
           
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'polio_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'rubela_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterBayiImunisasi', Session::get('year'), 'lengkap_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
            
        </tr>
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td>Total</td>
            <td></td>
            <td>{{ $totalLahirHidupL }}</td>
            <td>{{ $totalLahirHidupP }}</td>
            <td>{{ $totalLahirHidup }}</td>
        
            <td>{{ $totalDptL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalDptL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalDptP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalDptP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalDpt / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalPolioL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalPolioL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalPolioP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalPolioP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalPolio / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalRubelaL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalRubelaL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalRubelaP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalRubelaP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalRubela / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalLengkapL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalLengkapL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalLengkapP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalLengkapP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalLengkap / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        </tr>
        
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterBayiImunisasi(Session::get('year')))
        @php
        $lahirHidupL = $item->filterKelahiran(Session::get('year'))->lahir_hidup_L;
        $lahirHidupP = $item->filterKelahiran(Session::get('year'))->lahir_hidup_P;
        $lahirHidup = $lahirHidupL + $lahirHidupP;

        $dptL = $item->filterBayiImunisasi(Session::get('year'))->dpt_L;
        $dptP = $item->filterBayiImunisasi(Session::get('year'))->dpt_P;
        $dpt = $dptL + $dptP;

        $polioL = $item->filterBayiImunisasi(Session::get('year'))->polio_L;
        $polioP = $item->filterBayiImunisasi(Session::get('year'))->polio_P;
        $polio = $polioL + $polioP;

        $rubelaL = $item->filterBayiImunisasi(Session::get('year'))->rubela_L;
        $rubelaP = $item->filterBayiImunisasi(Session::get('year'))->rubela_P;
        $rubela = $rubelaL + $rubelaP;

        $lengkapL = $item->filterBayiImunisasi(Session::get('year'))->lengkap_L;
        $lengkapP = $item->filterBayiImunisasi(Session::get('year'))->lengkap_P;
        $lengkap = $lengkapL + $lengkapP;

        $totalLahirHidupL += $lahirHidupL;
        $totalLahirHidupP += $lahirHidupP;
        $totalLahirHidup += $lahirHidup;

        $totalDptL += $dptL;
        $totalDptP += $dptP;
        $totalDpt += $dpt;

        $totalPolioL += $polioL;
        $totalPolioP += $polioP;
        $totalPolio += $polio;

        $totalRubelaL += $rubelaL;
        $totalRubelaP += $rubelaP;
        $totalRubela += $rubela;

        $totalLengkapL += $lengkapL;
        $totalLengkapP += $lengkapP;
        $totalLengkap += $lengkap;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            <td>{{$item->filterBayiImunisasi(Session::get('year'))->dpt_L}}</td>

<td id="dpt_L{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->dpt_L 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->dpt_P}}</td>

<td id="dpt_P{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->dpt_P 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2) : 0}}
</td>

<td id="total_dpt{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterBayiImunisasi(Session::get('year'))->dpt_P + $item->filterBayiImunisasi(Session::get('year'))->dpt_L}}
</td>

<td id="persen_dpt{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format(($item->filterBayiImunisasi(Session::get('year'))->dpt_P + $item->filterBayiImunisasi(Session::get('year'))->dpt_L) 
    / ($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->polio_L}}</td>

<td id="polio_L{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->polio_L 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->polio_P}}</td>

<td id="polio_P{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->polio_P 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2) : 0}}
</td>

<td id="total_polio{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterBayiImunisasi(Session::get('year'))->polio_P + $item->filterBayiImunisasi(Session::get('year'))->polio_L}}
</td>

<td id="persen_polio{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format(($item->filterBayiImunisasi(Session::get('year'))->polio_P + $item->filterBayiImunisasi(Session::get('year'))->polio_L) 
    / ($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->rubela_L}}</td>

<td id="rubela_L{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->rubela_L 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->rubela_P}}</td>

<td id="rubela_P{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->rubela_P 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2) : 0}}
</td>

<td id="total_rubela{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterBayiImunisasi(Session::get('year'))->rubela_P + $item->filterBayiImunisasi(Session::get('year'))->rubela_L}}
</td>

<td id="persen_rubela{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format(($item->filterBayiImunisasi(Session::get('year'))->rubela_P + $item->filterBayiImunisasi(Session::get('year'))->rubela_L) 
    / ($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->lengkap_L}}</td>

<td id="lengkap_L{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->lengkap_L 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2) : 0}}
</td>

<td>{{$item->filterBayiImunisasi(Session::get('year'))->lengkap_P}}</td>

<td id="lengkap_P{{$item->filterBayiImunisasi(Session::get('year'))->id}}">
    {{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ? 
    number_format($item->filterBayiImunisasi(Session::get('year'))->lengkap_P 
    / $item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2) : 0}}
</td>

            
            <td id="total_lengkap{{$item->filterBayiImunisasi(Session::get('year'))->id}}">{{$item->filterBayiImunisasi(Session::get('year'))->lengkap_P + $item->filterBayiImunisasi(Session::get('year'))->lengkap_L}}</td>
            <td id="persen_lengkap{{$item->filterBayiImunisasi(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                number_format(($item->filterBayiImunisasi(Session::get('year'))->lengkap_P + $item->filterBayiImunisasi(Session::get('year'))->lengkap_L)
                /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
            
        </tr>
          @endif
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td>Total</td>
            <td></td>
            <td>{{ $totalLahirHidupL }}</td>
            <td>{{ $totalLahirHidupP }}</td>
            <td>{{ $totalLahirHidup }}</td>
        
            <td>{{ $totalDptL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalDptL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalDptP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalDptP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalDpt / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalPolioL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalPolioL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalPolioP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalPolioP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalPolio / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalRubelaL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalRubelaL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalRubelaP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalRubelaP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalRubela / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        
            <td>{{ $totalLengkapL }}</td>
            <td>
                {{ $totalLahirHidupL > 0 ? number_format(($totalLengkapL / $totalLahirHidupL) * 100, 2) : 0 }}
            </td>
            <td>{{ $totalLengkapP }}</td>
            <td>
                {{ $totalLahirHidupP > 0 ? number_format(($totalLengkapP / $totalLahirHidupP) * 100, 2) : 0 }}
            </td>
            <td>
                {{ $totalLahirHidup > 0 ? number_format(($totalLengkap / $totalLahirHidup) * 100, 2) : 0 }}
            </td>
        </tr>
        @endrole
    </tbody>
</table>