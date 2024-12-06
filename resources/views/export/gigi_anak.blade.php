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
        <th colspan="23">Usaha Kesehatan Gigi Sekolah (UKGS)</th>
    </tr>
    <tr>
        <th rowspan="2">Jumlah SD/MI</th>
        <th rowspan="2">Jumlah SD/MI dengan Sikat Gigi Massal</th>
        <th rowspan="2">%</th>
        <th rowspan="2">Jumlah SD/MI mendapat Yan. Gigi</th>
        <th rowspan="2">%</th>
        <th colspan="3">Jumlah Murid SD/MI</th>
        <th colspan="6">Murid SD/MI Diperiksa</th>
        <th colspan="3">Murid SD/MI Perlu Perawatan</th>
        <th colspan="6">Murid SD/MI Mendapat Perawatan</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>L</th>
        <th>%</th>
        <th>P</th>
        <th>%</th>
        <th>L+P</th>
        <th>%</th>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>L</th>
        <th>%</th>
        <th>P</th>
        <th>%</th>
        <th>L+P</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
$totalJumlahSD = 0;
$totalJumlahSikat = 0;
$totalJumlahYan = 0;

$totalSdL = 0;
$totalSdP = 0;
$totalDiperiksaL = 0;
$totalDiperiksaP = 0;

$totalRawatL = 0;
$totalRawatP = 0;
$totalDapatL = 0;
$totalDapatP = 0;
@endphp

        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
$jumlahSD = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"];
$jumlahSikat = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sikat')["total"];
$jumlahYan = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_yan')["total"];

$sdL = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"];
$sdP = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"];
$diperiksaL = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"];
$diperiksaP = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"];

$rawatL = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"];
$rawatP = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"];
$dapatL = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"];
$dapatP = $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"];

// Accumulate totals
$totalJumlahSD += $jumlahSD;
$totalJumlahSikat += $jumlahSikat;
$totalJumlahYan += $jumlahYan;

$totalSdL += $sdL;
$totalSdP += $sdP;
$totalDiperiksaL += $diperiksaL;
$totalDiperiksaP += $diperiksaP;

$totalRawatL += $rawatL;
$totalRawatP += $rawatP;
$totalDapatL += $dapatL;
$totalDapatP += $dapatP;
@endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sikat')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sikat')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] * 100, 2
                ):0}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_yan')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_yan')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] * 100, 2
                ):0}}</td>

            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] * 100, 2
                ):0}}</td>
          
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]> 0?
                number_format(($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"])
                /($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"]) * 100, 2
                ):0}}</td>

            
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"]
                /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] * 100, 2
                ):0}}</td>
          
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]> 0?
                number_format(($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"])
                /($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"]) * 100, 2
                ):0}}</td>

            
            
            
            
            
        </tr>
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahSD }}</td>
            <td>{{ $totalJumlahSikat }}</td>
            <td>{{ $totalJumlahSD > 0 ? number_format($totalJumlahSikat / $totalJumlahSD * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahYan }}</td>
            <td>{{ $totalJumlahSD > 0 ? number_format($totalJumlahYan / $totalJumlahSD * 100, 2) : 0 }}</td>
            <td>{{ $totalSdL }}</td>
            <td>{{ $totalSdP }}</td>
            <td>{{ $totalSdL + $totalSdP }}</td>
            <td>{{ $totalDiperiksaL }}</td>
            <td>{{ $totalSdL > 0 ? number_format($totalDiperiksaL / $totalSdL * 100, 2) : 0 }}</td>
            <td>{{ $totalDiperiksaP }}</td>
            <td>{{ $totalSdP > 0 ? number_format($totalDiperiksaP / $totalSdP * 100, 2) : 0 }}</td>
            <td>{{ $totalDiperiksaL + $totalDiperiksaP }}</td>
            <td>{{ ($totalSdL + $totalSdP) > 0 ? number_format(($totalDiperiksaL + $totalDiperiksaP) / ($totalSdL + $totalSdP) * 100, 2) : 0 }}</td>
            <td>{{ $totalRawatL }}</td>
            <td>{{ $totalRawatP }}</td>
            <td>{{ $totalRawatL + $totalRawatP }}</td>
            <td>{{ $totalDapatL }}</td>
            <td>{{ $totalRawatL > 0 ? number_format($totalDapatL / $totalRawatL * 100, 2) : 0 }}</td>
            <td>{{ $totalDapatP }}</td>
            <td>{{ $totalRawatP > 0 ? number_format($totalDapatP / $totalRawatP * 100, 2) : 0 }}</td>
            <td>{{ $totalDapatL + $totalDapatP }}</td>
            <td>{{ ($totalRawatL + $totalRawatP) > 0 ? number_format(($totalDapatL + $totalDapatP) / ($totalRawatL + $totalRawatP) * 100, 2) : 0 }}</td>
        </tr>
        
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterGigiAnak(Session::get('year')))
        @php
// Fetch data for the current row
$jumlahSD = $item->filterGigiAnak(Session::get('year'))->jumlah_sd;
$jumlahSikat = $item->filterGigiAnak(Session::get('year'))->jumlah_sikat;
$jumlahYan = $item->filterGigiAnak(Session::get('year'))->jumlah_yan;

$sdL = $item->filterGigiAnak(Session::get('year'))->sd_L;
$sdP = $item->filterGigiAnak(Session::get('year'))->sd_P;
$diperiksaL = $item->filterGigiAnak(Session::get('year'))->diperiksa_L;
$diperiksaP = $item->filterGigiAnak(Session::get('year'))->diperiksa_P;

$rawatL = $item->filterGigiAnak(Session::get('year'))->rawat_L;
$rawatP = $item->filterGigiAnak(Session::get('year'))->rawat_P;
$dapatL = $item->filterGigiAnak(Session::get('year'))->dapat_L;
$dapatP = $item->filterGigiAnak(Session::get('year'))->dapat_P;

// Accumulate totals
$totalJumlahSD += $jumlahSD;
$totalJumlahSikat += $jumlahSikat;
$totalJumlahYan += $jumlahYan;

$totalSdL += $sdL;
$totalSdP += $sdP;
$totalDiperiksaL += $diperiksaL;
$totalDiperiksaP += $diperiksaP;

$totalRawatL += $rawatL;
$totalRawatP += $rawatP;
$totalDapatL += $dapatL;
$totalDapatP += $dapatP;
@endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterGigiAnak(Session::get('year'))->jumlah_sd}}</td>
            <td>{{$item->filterGigiAnak(Session::get('year'))->jumlah_sikat}}</td>
            
            <td id="sikat{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->jumlah_sd > 0 ?
                    number_format(
                        $item->filterGigiAnak(Session::get('year'))->jumlah_sikat /
                        $item->filterGigiAnak(Session::get('year'))->jumlah_sd * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->jumlah_yan}}</td>
            
            <td id="yan{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->jumlah_sd > 0 ?
                    number_format(
                        $item->filterGigiAnak(Session::get('year'))->jumlah_yan /
                        $item->filterGigiAnak(Session::get('year'))->jumlah_sd * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->sd_L}}</td>
            <td>{{$item->filterGigiAnak(Session::get('year'))->sd_P}}</td>
            <td id="sd_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->sd_L + $item->filterGigiAnak(Session::get('year'))->sd_P}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->diperiksa_L}}</td>
            <td id="diperiksa_L{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->sd_L > 0 ?
                    number_format(
                        $item->filterGigiAnak(Session::get('year'))->diperiksa_L /
                        $item->filterGigiAnak(Session::get('year'))->sd_L * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->diperiksa_P}}</td>
            <td id="diperiksa_P{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->sd_P > 0 ?
                    number_format(
                        $item->filterGigiAnak(Session::get('year'))->diperiksa_P /
                        $item->filterGigiAnak(Session::get('year'))->sd_P * 100,
                        2
                    ) : 0}}
            </td>
            
            <td id="diperiksa_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->diperiksa_L +
                  $item->filterGigiAnak(Session::get('year'))->diperiksa_P}}
            </td>
            
            <td id="persen_diperiksa_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->sd_P + $item->filterGigiAnak(Session::get('year'))->sd_L > 0 ?
                    number_format(
                        ($item->filterGigiAnak(Session::get('year'))->diperiksa_L +
                         $item->filterGigiAnak(Session::get('year'))->diperiksa_P) /
                        ($item->filterGigiAnak(Session::get('year'))->sd_L +
                         $item->filterGigiAnak(Session::get('year'))->sd_P) * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->rawat_L}}</td>
            <td>{{$item->filterGigiAnak(Session::get('year'))->rawat_P}}</td>
            <td id="rawat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->rawat_L +
                  $item->filterGigiAnak(Session::get('year'))->rawat_P}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->dapat_L}}</td>
            <td id="dapat_L{{$item->filterGigiAnak(Session::get('year'))->id}}">
                {{$item->filterGigiAnak(Session::get('year'))->rawat_L > 0 ?
                    number_format(
                        $item->filterGigiAnak(Session::get('year'))->dapat_L /
                        $item->filterGigiAnak(Session::get('year'))->rawat_L * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigiAnak(Session::get('year'))->dapat_P}}</td>
            
            <td id="dapat_P{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_P>0?
                number_format($item->filterGigiAnak(Session::get('year'))->dapat_P
                /$item->filterGigiAnak(Session::get('year'))->rawat_P * 100, 2):0}}</td>

            <td id="dapat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->dapat_L + $item->filterGigiAnak(Session::get('year'))->dapat_P}}</td>
            <td id="persen_dapat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_P + $item->filterGigiAnak(Session::get('year'))->rawat_L>0?
                number_format(( $item->filterGigiAnak(Session::get('year'))->dapat_L + $item->filterGigiAnak(Session::get('year'))->dapat_P)
                /($item->filterGigiAnak(Session::get('year'))->rawat_L + $item->filterGigiAnak(Session::get('year'))->rawat_P) * 100, 2):0}}</td>



        </tr>
          @endif
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahSD }}</td>
            <td>{{ $totalJumlahSikat }}</td>
            <td>{{ $totalJumlahSD > 0 ? number_format($totalJumlahSikat / $totalJumlahSD * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahYan }}</td>
            <td>{{ $totalJumlahSD > 0 ? number_format($totalJumlahYan / $totalJumlahSD * 100, 2) : 0 }}</td>
            <td>{{ $totalSdL }}</td>
            <td>{{ $totalSdP }}</td>
            <td>{{ $totalSdL + $totalSdP }}</td>
            <td>{{ $totalDiperiksaL }}</td>
            <td>{{ $totalSdL > 0 ? number_format($totalDiperiksaL / $totalSdL * 100, 2) : 0 }}</td>
            <td>{{ $totalDiperiksaP }}</td>
            <td>{{ $totalSdP > 0 ? number_format($totalDiperiksaP / $totalSdP * 100, 2) : 0 }}</td>
            <td>{{ $totalDiperiksaL + $totalDiperiksaP }}</td>
            <td>{{ ($totalSdL + $totalSdP) > 0 ? number_format(($totalDiperiksaL + $totalDiperiksaP) / ($totalSdL + $totalSdP) * 100, 2) : 0 }}</td>
            <td>{{ $totalRawatL }}</td>
            <td>{{ $totalRawatP }}</td>
            <td>{{ $totalRawatL + $totalRawatP }}</td>
            <td>{{ $totalDapatL }}</td>
            <td>{{ $totalRawatL > 0 ? number_format($totalDapatL / $totalRawatL * 100, 2) : 0 }}</td>
            <td>{{ $totalDapatP }}</td>
            <td>{{ $totalRawatP > 0 ? number_format($totalDapatP / $totalRawatP * 100, 2) : 0 }}</td>
            <td>{{ $totalDapatL + $totalDapatP }}</td>
            <td>{{ ($totalRawatL + $totalRawatP) > 0 ? number_format(($totalDapatL + $totalDapatP) / ($totalRawatL + $totalRawatP) * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>