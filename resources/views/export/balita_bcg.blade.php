<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN IMUNISASI HEPATITIS B0 (0 -7 HARI) DAN BCG PADA BAYI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="5">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="5">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="5">Desa</th>
        @endrole
        <th rowspan="4" colspan="3">Jumlah Lahir Hidup</th>
        <th colspan="24">Bayi Diimunisasi</th>
    </tr>
    <tr>
        <th colspan="18">B0</th>
        <th colspan="6" rowspan="2">BCG</th>
    </tr>
    <tr>
        <th colspan="6">< 24 jam</th>
        <th colspan="6">1-7 hari</th>
        <th colspan="6">HB0 Total</th>
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
            $lahir_hidup_L = 0;
            $lahir_hidup_P = 0;
            $duaempat_jam_L = 0;
            $duaempat_jam_P = 0;
            $satu_minggu_L = 0;
            $satu_minggu_P = 0;
            $bcg_L = 0;
            $bcg_P = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $lahir_hidup_L += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"];
            $lahir_hidup_P += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"];
            $duaempat_jam_L += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"];
            $duaempat_jam_P += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"];
            $satu_minggu_L += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"];
            $satu_minggu_P += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"];
            $bcg_L += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"];
            $bcg_P += $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"])
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"])
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]) + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>

            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
            
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P}}</td>
            <td>{{$duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($duaempat_jam_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($duaempat_jam_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$duaempat_jam_P + $duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($duaempat_jam_P + $duaempat_jam_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            
            <td>{{$satu_minggu_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($satu_minggu_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($satu_minggu_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $satu_minggu_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($satu_minggu_P + $satu_minggu_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            
            <td>{{$satu_minggu_L + $duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format((($satu_minggu_L + $duaempat_jam_L) / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format((($satu_minggu_P + $duaempat_jam_P) / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $satu_minggu_L + $duaempat_jam_L + $duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($satu_minggu_P + $satu_minggu_L + $duaempat_jam_L + $duaempat_jam_P) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>

            <td>{{$bcg_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($bcg_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bcg_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($bcg_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$bcg_P + $bcg_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($bcg_P + $bcg_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterBalitaBcg(Session::get('year')))
        @php
            $lahir_hidup_L += $item->filterKelahiran(Session::get('year'))->lahir_hidup_L;
            $lahir_hidup_P += $item->filterKelahiran(Session::get('year'))->lahir_hidup_P;
            $duaempat_jam_L += $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L;
            $duaempat_jam_P += $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P;
            $satu_minggu_L += $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L;
            $satu_minggu_P += $item->filterBalitaBcg(Session::get('year'))->satu_minggu_P;
            $bcg_L += $item->filterBalitaBcg(Session::get('year'))->bcg_L;
            $bcg_P += $item->filterBalitaBcg(Session::get('year'))->bcg_P;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            
            @php
            $filterBalitaBcg = $item->filterBalitaBcg(Session::get('year'));
            $filterKelahiran = $item->filterKelahiran(Session::get('year'));
            $totalLahirHidup = $filterKelahiran->lahir_hidup_L + $filterKelahiran->lahir_hidup_P;
        @endphp
        
        <td>{{ $filterBalitaBcg->duaempat_jam_L }}</td>
        <td id="duaempat_jam_L{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_L > 0
                ? number_format($filterBalitaBcg->duaempat_jam_L / $filterKelahiran->lahir_hidup_L * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterBalitaBcg->duaempat_jam_P }}</td>
        <td id="duaempat_jam_P{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_P > 0
                ? number_format($filterBalitaBcg->duaempat_jam_P / $filterKelahiran->lahir_hidup_P * 100, 2)
                : 0
            }}
        </td>
        <td id="total_duaempat_jam{{ $filterBalitaBcg->id }}">
            {{ $filterBalitaBcg->duaempat_jam_L + $filterBalitaBcg->duaempat_jam_P }}
        </td>
        <td id="persen_duaempat_jam{{ $filterBalitaBcg->id }}">
            {{
                $totalLahirHidup > 0
                ? number_format(($filterBalitaBcg->duaempat_jam_L + $filterBalitaBcg->duaempat_jam_P) / $totalLahirHidup * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterBalitaBcg->satu_minggu_L }}</td>
        <td id="satu_minggu_L{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_L > 0
                ? number_format($filterBalitaBcg->satu_minggu_L / $filterKelahiran->lahir_hidup_L * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterBalitaBcg->satu_minggu_P }}</td>
        <td id="satu_minggu_P{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_P > 0
                ? number_format($filterBalitaBcg->satu_minggu_P / $filterKelahiran->lahir_hidup_P * 100, 2)
                : 0
            }}
        </td>
        <td id="total_satu_minggu{{ $filterBalitaBcg->id }}">
            {{ $filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->satu_minggu_P }}
        </td>
        <td id="persen_satu_minggu{{ $filterBalitaBcg->id }}">
            {{
                $totalLahirHidup > 0
                ? number_format(($filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->satu_minggu_P) / $totalLahirHidup * 100, 2)
                : 0
            }}
        </td>
        <td id="total_L{{ $filterBalitaBcg->id }}">
            {{ $filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->duaempat_jam_L }}
        </td>
        <td id="persen_L{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_L > 0
                ? number_format(($filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->duaempat_jam_L) / $filterKelahiran->lahir_hidup_L * 100, 2)
                : 0
            }}
        </td>
        <td id="total_P{{ $filterBalitaBcg->id }}">
            {{ $filterBalitaBcg->satu_minggu_P + $filterBalitaBcg->duaempat_jam_P }}
        </td>
        <td id="persen_P{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_P > 0
                ? number_format(($filterBalitaBcg->satu_minggu_P + $filterBalitaBcg->duaempat_jam_P) / $filterKelahiran->lahir_hidup_P * 100, 2)
                : 0
            }}
        </td>
        <td id="total_LP{{ $filterBalitaBcg->id }}">
            {{
                $filterBalitaBcg->duaempat_jam_L + $filterBalitaBcg->duaempat_jam_P + $filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->satu_minggu_P
            }}
        </td>
        <td id="persen_LP{{ $filterBalitaBcg->id }}">
            {{
                $totalLahirHidup > 0
                ? number_format(($filterBalitaBcg->duaempat_jam_L + $filterBalitaBcg->duaempat_jam_P + $filterBalitaBcg->satu_minggu_L + $filterBalitaBcg->satu_minggu_P) / $totalLahirHidup * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterBalitaBcg->bcg_L }}</td>
        <td id="bcg_L{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_L > 0
                ? number_format($filterBalitaBcg->bcg_L / $filterKelahiran->lahir_hidup_L * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterBalitaBcg->bcg_P }}</td>
        <td id="bcg_P{{ $filterBalitaBcg->id }}">
            {{
                $filterKelahiran->lahir_hidup_P > 0
                ? number_format($filterBalitaBcg->bcg_P / $filterKelahiran->lahir_hidup_P * 100, 2)
                : 0
            }}
        </td>
        
            
            <td id="total_bcg{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->bcg_P + $item->filterBalitaBcg(Session::get('year'))->bcg_L}}</td>
            <td id="persen_bcg{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                number_format(($item->filterBalitaBcg(Session::get('year'))->bcg_P + $item->filterBalitaBcg(Session::get('year'))->bcg_L)
                /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>   
        </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P}}</td>
            <td>{{$duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($duaempat_jam_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($duaempat_jam_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$duaempat_jam_P + $duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($duaempat_jam_P + $duaempat_jam_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            
            <td>{{$satu_minggu_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($satu_minggu_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($satu_minggu_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $satu_minggu_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($satu_minggu_P + $satu_minggu_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
            
            <td>{{$satu_minggu_L + $duaempat_jam_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format((($satu_minggu_L + $duaempat_jam_L) / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format((($satu_minggu_P + $duaempat_jam_P) / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$satu_minggu_P + $satu_minggu_L + $duaempat_jam_L + $duaempat_jam_P}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($satu_minggu_P + $satu_minggu_L + $duaempat_jam_L + $duaempat_jam_P) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>

            <td>{{$bcg_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($bcg_L / $lahir_hidup_L) * 100, 2):0}}%</td>
            <td>{{$bcg_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($bcg_P / $lahir_hidup_P) * 100, 2):0}}%</td>
            <td>{{$bcg_P + $bcg_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($bcg_P + $bcg_L) / ($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}%</td>
        </tr>
        @endrole
    </tbody>
</table>