<table id="data" class="table table-bordered dt-responsive"
style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="text-center">
    <tr>
        <th>KASUS BARU KUSTA CACAT TINGKAT 0, CACAT TINGKAT 2, PENDERITA KUSTA ANAK KURANG DARI 15 TAHUN</th>
    </tr>
    <tr>
        <th>Kabupaten/Kota Kutai Timur</th>
    </tr>
    <tr>
        <th>Tahun {{Session::get('year')}}</th>
    </tr>
    <tr>
        <th rowspan="3" style="vertical-align: middle">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="3" style="vertical-align: middle">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="3" style="vertical-align: middle">Desa</th>
        @endrole
        <th colspan="9">KASUS BARU</th>
    </tr>
    <tr>
        <th rowspan="2">Penderita Kusta</th>
        <th colspan="2">Cacat Tingkat 0</th>
        <th colspan="2">Cacat Tingkat 2</th>
        <th colspan="2">Penderita Kusta Anak KURANG DARI 15 tahun</th>
        <th>PENDERITA KUSTA ANAK KURANG DARI 15 TAHUN DENGAN CACAT TINGKAT 2</th>
    </tr>
    <tr>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
    </tr>
</thead>
<tbody>
    @role('Admin|superadmin')
    @php
        $GrandPenderitaKusta = 0;
        $GrandJumlah_cacat_0 = 0;
        $GrandJumlah_cacat_1 = 0;
        $GrandPenderita_kusta_1 = 0;
        $GrandPenderita_kusta_2 = 0;
    @endphp
        @foreach ($unit_kerja as $key => $item)
        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
            <td>{{ $item->kecamatan }}</td>
            <td class="unit_kerja">{{ $item->nama }}</td>
            <td>
                @php
                    $penderitaKusta =  $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderitaKusta,id')['total'];
                    $GrandPenderitaKusta += $penderitaKusta;

                    echo $penderitaKusta;
                @endphp
            </td>
            <td>
                @php
                    $jumlah_cacat_0 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'jumlah_cacat_0')['total'];
                    $GrandJumlah_cacat_0 += $jumlah_cacat_0;

                    echo $jumlah_cacat_0;
                @endphp
            </td>
            <td>
                {{ $penderitaKusta > 0?number_format(($jumlah_cacat_0 / $penderitaKusta) * 100, 2)."%":0 }}
            </td>
            <td>
                @php
                    $jumlah_cacat_1 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'jumlah_cacat_1')['total'];
                    $GrandJumlah_cacat_1 += $jumlah_cacat_1;

                    echo $jumlah_cacat_1;
                @endphp
            </td>
            <td>
                {{ $penderitaKusta > 0?number_format(($jumlah_cacat_1 / $penderitaKusta) * 100, 2)."%":0 }}
            </td>
            <td>
                @php
                    $penderita_kusta_1 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderita_kusta_1')['total'];
                    $GrandPenderita_kusta_1 += $penderita_kusta_1;
                    echo $penderita_kusta_1;
                @endphp
            </td>
            <td>
                {{$penderitaKusta > 0? number_format(($penderita_kusta_1 / $penderitaKusta) * 100, 2)."%":0 }}
            </td>
            <td>
                @php
                    $penderita_kusta_2 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderita_kusta_2')['total'];
                    $GrandPenderita_kusta_2 += $penderita_kusta_2;
                    echo $penderita_kusta_2;
                @endphp
            </td>
        </tr>
        @endforeach
        <tr>
            <th colspan="2">JUMLAH </th>
            <th id="GrandPenderitaKusta">{{$GrandPenderitaKusta}}</th>
            <th id="GrandJumlah_cacat_0">{{$GrandJumlah_cacat_0}}</th>
            <th id="PGrandCacat0">
                {{ $GrandPenderitaKusta > 0?number_format(($GrandJumlah_cacat_0 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandJumlah_cacat_1">{{$GrandJumlah_cacat_1}}</th>
            <th id="PGrandCacat1">
                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandPenderita_kusta_1">{{$GrandPenderita_kusta_1}}</th>
            <th id="PGrandPenderitaKusta1">
                {{ $GrandPenderitaKusta>0?number_format(($GrandPenderita_kusta_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandPenderita_kusta_2">{{$GrandPenderita_kusta_2}}</th>
        </tr>
        <tr>
            <th colspan="2">ANGKA CACAT TINGKAT 2 PER 1.000.000 PENDUDUK</th>
            <th colspan="3"></th>
            <th id="angka_cacat_2_penduduk">
                {{ $jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki > 0?($GrandJumlah_cacat_1 / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000:0}}
            </th>
            <th colspan="4"></th>
        </tr>
    @endrole
    @role('Puskesmas|Pihak Wajib Pajak')
        @php
            $GrandPenderitaKusta = 0;
            $GrandJumlah_cacat_0 = 0;
            $GrandJumlah_cacat_1 = 0;
            $GrandPenderita_kusta_1 = 0;
            $GrandPenderita_kusta_2 = 0;
        @endphp

        @foreach ($desa as $key => $item)
            @if ($item->filterTable65(Session::get('year'), $item->id))
                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                    <td class="unit_kerja">{{ $item->nama }}</td>
                    <td id="penderita_kusta_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        @php
                            $penderitaKusta = $item->filterTable65(Session::get('year'), $item->id)->PenderitaKusta($item->id);
                            $GrandPenderitaKusta += $penderitaKusta;
                        @endphp
                        {{ $penderitaKusta }}
                    </td>
                    <td id="jumlah_cacat_0_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        @php
                            $jumlah_cacat_0 = $item->filterTable65(Session::get('year'), $item->id)->jumlah_cacat_0;
                            $GrandJumlah_cacat_0 += $jumlah_cacat_0;
                        @endphp
                        {{ $jumlah_cacat_0 }}
                    </td>
                    <td id="persen_jumlah_cacat_0_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        {{ $penderitaKusta ? number_format(($jumlah_cacat_0 / $penderitaKusta) * 100, 2) . "%" : 0 }}
                    </td>
                    <td id="jumlah_cacat_1_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                        @php
                            $jumlah_cacat_1 = $item->filterTable65(Session::get('year'), $item->id)->jumlah_cacat_1;
                            $GrandJumlah_cacat_1 += $jumlah_cacat_1;
                        @endphp
                        {{ $jumlah_cacat_1 }}
                    </td>
                    <td id="persen_jumlah_cacat_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        {{ $penderitaKusta > 0 ? number_format(($jumlah_cacat_1 / $penderitaKusta) * 100, 2) . "%" : 0 }}
                    </td>
                    <td id="penderita_kusta_1_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                        @php
                            $penderita_kusta_1 = $item->filterTable65(Session::get('year'), $item->id)->penderita_kusta_1;
                            $GrandPenderita_kusta_1 += $penderita_kusta_1;
                        @endphp
                        {{ $penderita_kusta_1 }}
                    </td>
                    <td id="persen_penderita_kusta_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        {{ $penderitaKusta > 0 ? number_format(($penderita_kusta_1 / $penderitaKusta) * 100, 2) . "%" : 0 }}
                    </td>
                    <td id="penderita_kusta_2_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                        @php
                            $penderita_kusta_2 = $item->filterTable65(Session::get('year'), $item->id)->penderita_kusta_2;
                            $GrandPenderita_kusta_2 += $penderita_kusta_2;
                        @endphp
                        {{ $penderita_kusta_2 }}
                    </td>
                    

                </tr>
            @endif
        @endforeach
        <tr>
            <th colspan="2">JUMLAH </th>
            <th id="GrandPenderitaKusta">{{$GrandPenderitaKusta}}</th>
            <th id="GrandJumlah_cacat_0">{{$GrandJumlah_cacat_0}}</th>
            <th id="PGrandCacat0">
                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_0 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandJumlah_cacat_1">{{$GrandJumlah_cacat_1}}</th>
            <th id="PGrandCacat1">
                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandPenderita_kusta_1">{{$GrandPenderita_kusta_1}}</th>
            <th id="PGrandPenderitaKusta1">
                {{ $GrandPenderitaKusta>0?number_format(($GrandPenderita_kusta_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
            </th>
            <th id="GrandPenderita_kusta_2">{{$GrandPenderita_kusta_2}}</th>
        </tr>
        <tr>
            <th colspan="2">ANGKA CACAT TINGKAT 2 PER 1.000.000 PENDUDUK</th>
            <th colspan="3"></th>
            <th id="angka_cacat_2_penduduk">
                {{$jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki>0?($GrandJumlah_cacat_1 / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000:0}}
            </th>
            <th colspan="4"></th>
        </tr>
    @endrole
</tbody>
</table>