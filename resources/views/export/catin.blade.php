<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PELAYANAN KESEHATAN GIGI DAN MULUT PADA ANAK SD DAN SETINGKAT MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="3" rowspan="2">Jumlah Catin terdaftar di KUA atau lembaga Agama Lainnya</th>
        <th colspan="6" >Catin Mendapatkan Layanan Kesehatan</th>
        <th colspan="2" rowspan="2">Catin Perempuan Anemia</th>
        <th colspan="2" rowspan="2">Catin Perempuan Gizi Kurang</th>
    </tr>
    <tr>
        <th colspan="2">Laki-Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Laki-Laki + Perempuan</th>
    </tr>
    <tr>
        <th>Laki-Laki</th>
        <th>Perempuan</th>
        <th>Laki-Laki + Perempuan</th>
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
    // Initialize total variables
    $totalKuaL = $totalKuaP = $totalKuaTotal = 0;
    $totalLayananL = $totalLayananP = $totalLayananTotal = 0;
    $totalAnemia = $totalGizi = 0;
@endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        // Fetch values
        $kuaL = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"];
        $kuaP = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"];
        $layananL = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_L')["total"];
        $layananP = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"];
        $anemia = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'anemia')["total"];
        $gizi = $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'gizi')["total"];
        
        // Increment totals
        $totalKuaL += $kuaL;
        $totalKuaP += $kuaP;
        $totalKuaTotal += $kuaL + $kuaP;
        $totalLayananL += $layananL;
        $totalLayananP += $layananP;
        $totalLayananTotal += $layananL + $layananP;
        $totalAnemia += $anemia;
        $totalGizi += $gizi;
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"] + $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_L')["total"]
                /$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"]
                /$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] + $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"] + $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"] > 0?
                number_format(($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] + $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_L')["total"])
                /($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_L')["total"] + $item->unitKerjaAmbil('filterCatin', Session::get('year'), 'kua_P')["total"]) * 100, 2
                ):0}}</td>

            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'anemia')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'anemia')["total"]
            /$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'gizi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterCatin', Session::get('year'), 'gizi')["total"]
            /$item->unitKerjaAmbil('filterCatin', Session::get('year'), 'layanan_P')["total"] * 100, 2
            ):0}}</td>
            
            
            
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalKuaL }}</td>
            <td>{{ $totalKuaP }}</td>
            <td>{{ $totalKuaTotal }}</td>
            <td>{{ $totalLayananL }}</td>
            <td>{{ $totalKuaL > 0 ? number_format($totalLayananL / $totalKuaL * 100, 2) : 0 }}</td>
            <td>{{ $totalLayananP }}</td>
            <td>{{ $totalKuaP > 0 ? number_format($totalLayananP / $totalKuaP * 100, 2) : 0 }}</td>
            <td>{{ $totalLayananTotal }}</td>
            <td>{{ $totalKuaTotal > 0 ? number_format($totalLayananTotal / $totalKuaTotal * 100, 2) : 0 }}</td>
            <td>{{ $totalAnemia }}</td>
            <td>{{ $totalLayananP > 0 ? number_format($totalAnemia / $totalLayananP * 100, 2) : 0 }}</td>
            <td>{{ $totalGizi }}</td>
            <td>{{ $totalLayananP > 0 ? number_format($totalGizi / $totalLayananP * 100, 2) : 0 }}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterCatin(Session::get('year')))
        @php
        // Fetch values
        $kuaL = $item->filterCatin(Session::get('year'))->kua_L;
        $kuaP = $item->filterCatin(Session::get('year'))->kua_P;
        $layananL = $item->filterCatin(Session::get('year'))->layanan_L;
        $layananP = $item->filterCatin(Session::get('year'))->layanan_P;
        $anemia = $item->filterCatin(Session::get('year'))->anemia;
        $gizi = $item->filterCatin(Session::get('year'))->gizi;
        
        // Increment totals
        $totalKuaL += $kuaL;
        $totalKuaP += $kuaP;
        $totalKuaTotal += $kuaL + $kuaP;
        $totalLayananL += $layananL;
        $totalLayananP += $layananP;
        $totalLayananTotal += $layananL + $layananP;
        $totalAnemia += $anemia;
        $totalGizi += $gizi;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterCatin(Session::get('year'))->kua_L}}</td>
            <td>{{$item->filterCatin(Session::get('year'))->kua_P}}</td>
            <td id="kua{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->kua_P + $item->filterCatin(Session::get('year'))->kua_L}}
            </td>
            
            <td>{{$item->filterCatin(Session::get('year'))->layanan_L}}</td>
            
            <td id="layanan_L{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->kua_L > 0 ?
                    number_format(
                        $item->filterCatin(Session::get('year'))->layanan_L /
                        $item->filterCatin(Session::get('year'))->kua_L * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterCatin(Session::get('year'))->layanan_P}}</td>
            
            <td id="layanan_P{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->kua_P > 0 ?
                    number_format(
                        $item->filterCatin(Session::get('year'))->layanan_P /
                        $item->filterCatin(Session::get('year'))->kua_P * 100,
                        2
                    ) : 0}}
            </td>
            
            <td id="layanan_LP{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->layanan_P + $item->filterCatin(Session::get('year'))->layanan_L}}
            </td>
            
            <td id="persen_layanan_LP{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->kua_P + $item->filterCatin(Session::get('year'))->kua_L > 0 ?
                    number_format(
                        ($item->filterCatin(Session::get('year'))->layanan_P + $item->filterCatin(Session::get('year'))->layanan_L) /
                        ($item->filterCatin(Session::get('year'))->kua_L + $item->filterCatin(Session::get('year'))->kua_P) * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterCatin(Session::get('year'))->anemia}}</td>
            
            <td id="anemia{{$item->filterCatin(Session::get('year'))->id}}">
                {{$item->filterCatin(Session::get('year'))->layanan_P > 0 ?
                    number_format(
                        $item->filterCatin(Session::get('year'))->anemia /
                        $item->filterCatin(Session::get('year'))->layanan_P * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterCatin(Session::get('year'))->gizi}}</td>
            
            
            <td id="gizi{{$item->filterCatin(Session::get('year'))->id}}">{{$item->filterCatin(Session::get('year'))->layanan_P>0?
            number_format($item->filterCatin(Session::get('year'))->gizi
            /$item->filterCatin(Session::get('year'))->layanan_P * 100, 2):0}}</td>
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalKuaL }}</td>
            <td>{{ $totalKuaP }}</td>
            <td>{{ $totalKuaTotal }}</td>
            <td>{{ $totalLayananL }}</td>
            <td>{{ $totalKuaL > 0 ? number_format($totalLayananL / $totalKuaL * 100, 2) : 0 }}</td>
            <td>{{ $totalLayananP }}</td>
            <td>{{ $totalKuaP > 0 ? number_format($totalLayananP / $totalKuaP * 100, 2) : 0 }}</td>
            <td>{{ $totalLayananTotal }}</td>
            <td>{{ $totalKuaTotal > 0 ? number_format($totalLayananTotal / $totalKuaTotal * 100, 2) : 0 }}</td>
            <td>{{ $totalAnemia }}</td>
            <td>{{ $totalLayananP > 0 ? number_format($totalAnemia / $totalLayananP * 100, 2) : 0 }}</td>
            <td>{{ $totalGizi }}</td>
            <td>{{ $totalLayananP > 0 ? number_format($totalGizi / $totalLayananP * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>