<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>JUMLAH KASUS PENYAKIT YANG DAPAT DICEGAH DENGAN IMUNISASI (PD3I) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
                                    </tr>
                                    <tr>
                                        <th>Kabupaten/Kota Kutai Timur</th>
                                    </tr>
                                    <tr>
                                        <th>Tahun {{Session::get('year')}}</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="4" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="4" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="4" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="18">JUMLAH KASUS  PD3I</th>
                                       
                                    </tr>
                                    <tr>
                                        <th colspan="4">DIFTERI</th>
                                        <th colspan="3" rowspan="2">PERTUSIS</th>
                                        <th colspan="4">TETANUS NEONATORUM</th>
                                        <th colspan="3">HEPATITIS B</th>
                                        <th colspan="3" rowspan="2">SUSPEK CAMPAK</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">JUMLAH KASUS</th>
                                        <th rowspan="2">MENINGGAL</th>
                                        <th colspan="3">JUMLAH KASUS</th>
                                        <th rowspan="2">MENINGGAL</th>
                                        <th colspan="3">JUMLAH KASUS</th>
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
                                        $Granddifteri_l = 0;
                                        $Granddifteri_p = 0;
                                        $Granddifteri_lp = 0;
                                        $Granddifteri_m = 0;
                                        $Grandpertusis_l = 0;
                                        $Grandpertusis_p = 0;
                                        $Grandpertusis_lp = 0;
                                        $Grandtetanus_neonatorum_l = 0;
                                        $Grandtetanus_neonatorum_p = 0;
                                        $Grandtetanus_neonatorum_lp = 0;
                                        $Grandtetanus_neonatorum_m = 0;
                                        $Grandhepatitis_l = 0;
                                        $Grandhepatitis_p = 0;
                                        $Grandhepatitis_lp = 0;
                                        $Grandsuspek_campak_l = 0;
                                        $Grandsuspek_campak_p = 0;
                                        $Grandsuspek_campak_lp = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $difteri_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_l')['total'];
                                                    $Granddifteri_l += $difteri_l;

                                                    echo $difteri_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $difteri_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_p')['total'];

                                                    $Granddifteri_p += $difteri_p;

                                                    echo $difteri_p;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $Granddifteri_lp += $difteri_p + $difteri_l;
                                                @endphp
                                                {{$difteri_p + $difteri_l}}
                                            </td>
                                            <td>
                                                @php
                                                    $difteri_m = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_m')['total'];
                                                    $Granddifteri_m += $difteri_m;

                                                    echo $difteri_m;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pertusis_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'pertusis_l')['total'];
                                                    $Grandpertusis_l += $pertusis_l;

                                                    echo $pertusis_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pertusis_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'pertusis_p')['total'];
                                                    $Grandpertusis_p += $pertusis_p;

                                                    echo $pertusis_p;
                                                @endphp
                                            </td>
                                            <td >
                                                @php
                                                    $Grandpertusis_lp += $pertusis_l + $pertusis_p;
                                                @endphp
                                                {{$pertusis_l + $pertusis_p}}
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_l')['total'];
                                                    $Grandtetanus_neonatorum_l += $tetanus_neonatorum_l;

                                                    echo $tetanus_neonatorum_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_p')['total'];
                                                    $Grandtetanus_neonatorum_p += $tetanus_neonatorum_p;

                                                    echo $tetanus_neonatorum_p;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $Grandtetanus_neonatorum_lp += $tetanus_neonatorum_l + $tetanus_neonatorum_p;
                                                @endphp
                                                {{$tetanus_neonatorum_l + $tetanus_neonatorum_p}}
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_m = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_m')['total'];
                                                    $Grandtetanus_neonatorum_m += $tetanus_neonatorum_m;

                                                    echo $tetanus_neonatorum_m;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hepatitis_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'hepatitis_l')['total'];
                                                    $Grandhepatitis_l += $hepatitis_l;

                                                    echo $hepatitis_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hepatitis_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'hepatitis_p')['total'];
                                                    $Grandhepatitis_p += $hepatitis_p;
                                                    echo $hepatitis_p;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $Grandhepatitis_lp += $hepatitis_l + $hepatitis_p;
                                                @endphp
                                                {{ $hepatitis_l + $hepatitis_p }}
                                            </td>
                                            <td>
                                                @php
                                                    $suspek_campak_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'suspek_campak_l')['total'];
                                                    $Grandsuspek_campak_l += $suspek_campak_l;
                                                    echo $suspek_campak_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $suspek_campak_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'suspek_campak_p')['total'];
                                                    $Grandsuspek_campak_p += $suspek_campak_p;
                                                    echo $suspek_campak_p;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $Grandsuspek_campak_lp += $suspek_campak_p + $suspek_campak_l;
                                                @endphp
                                                {{$suspek_campak_p + $suspek_campak_l}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">JUMLAH</th>
                                            <th id="Granddifteri_l">{{$Granddifteri_l }} </th>
                                            <th id="Granddifteri_p">{{$Granddifteri_p }} </th>
                                            <th id="Granddifteri_lp">{{$Granddifteri_lp }} </th>
                                            <th id="Granddifteri_m">{{$Granddifteri_m }} </th>
                                            <th id="Grandpertusis_l">{{$Grandpertusis_l }} </th>
                                            <th id="Grandpertusis_p">{{$Grandpertusis_p }} </th>
                                            <th id="Grandpertusis_lp">{{$Grandpertusis_lp }} </th>
                                            <th id="Grandtetanus_neonatorum_l">{{$Grandtetanus_neonatorum_l }} </th>
                                            <th id="Grandtetanus_neonatorum_p">{{$Grandtetanus_neonatorum_p }} </th>
                                            <th id="Grandtetanus_neonatorum_lp">{{$Grandtetanus_neonatorum_lp}} </th>
                                            <th id="Grandtetanus_neonatorum_m">{{$Grandtetanus_neonatorum_m }} </th>
                                            <th id="Grandhepatitis_l">{{$Grandhepatitis_l  }} </th>
                                            <th id="Grandhepatitis_p">{{$Grandhepatitis_p  }} </th>
                                            <th id="Grandhepatitis_lp">{{$Grandhepatitis_lp  }} </th>
                                            <th id="Grandsuspek_campak_l">{{$Grandsuspek_campak_l  }} </th>
                                            <th id="Grandsuspek_campak_p">{{$Grandsuspek_campak_p }} </th>
                                            <th id="Grandsuspek_campak_lp">{{$Grandsuspek_campak_lp }} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="1">CASE FATALITY RATE (%)</th>
                                            <th colspan="3"></th>
                                            <th id="case_1">{{ $Granddifteri_m > 0 && $Granddifteri_lp > 0 ? number_format(($Granddifteri_m / $Granddifteri_lp) * 100, 2) . '%' : 0}}</th>
                                            <th colspan="6"></th>
                                            <th id="case_2">{{$Grandtetanus_neonatorum_m > 0 && $Grandtetanus_neonatorum_lp > 0 ? number_format(($Grandtetanus_neonatorum_m / $Grandtetanus_neonatorum_lp) * 100, 2) . '%' : 0}}</th>
                                            <th colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="15">INCIDENCE RATE SUSPEK CAMPAK</th>
                                            <th id="incidence_1">{{($Grandsuspek_campak_l / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_2">{{($Grandsuspek_campak_p / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_3">{{($Grandsuspek_campak_lp / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')

                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable69(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $difteri_l = $item->filterTable69(Session::get('year'), $item->id)->difteri_l;
                                                            $Granddifteri_l += $difteri_l;
                                                        @endphp
                                                        {{ $difteri_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $difteri_p = $item->filterTable69(Session::get('year'), $item->id)->difteri_p;
                                                            $Granddifteri_p += $difteri_p;
                                                        @endphp
                                                        {{ $difteri_p }}
                                                    </td>
                                                    <td id="difteri_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Granddifteri_lp += $difteri_p + $difteri_l;
                                                        @endphp
                                                        {{ $difteri_p + $difteri_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $difteri_m = $item->filterTable69(Session::get('year'), $item->id)->difteri_m;
                                                            $Granddifteri_m += $difteri_m;
                                                        @endphp
                                                        {{ $difteri_m }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pertusis_l = $item->filterTable69(Session::get('year'), $item->id)->pertusis_l;
                                                            $Grandpertusis_l += $pertusis_l;
                                                        @endphp
                                                        {{ $pertusis_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pertusis_p = $item->filterTable69(Session::get('year'), $item->id)->pertusis_p;
                                                            $Grandpertusis_p += $pertusis_p;
                                                        @endphp
                                                        {{ $pertusis_p }}
                                                    </td>
                                                    <td id="pertusis_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandpertusis_lp += $pertusis_l + $pertusis_p;
                                                        @endphp
                                                        {{ $pertusis_l + $pertusis_p }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_l = $item->filterTable69(Session::get('year'), $item->id)->tetanus_neonatorum_l;
                                                            $Grandtetanus_neonatorum_l += $tetanus_neonatorum_l;
                                                        @endphp
                                                        {{ $tetanus_neonatorum_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_p = $item->filterTable69(Session::get('year'), $item->id)->tetanus_neonatorum_p;
                                                            $Grandtetanus_neonatorum_p += $tetanus_neonatorum_p;
                                                        @endphp
                                                        {{ $tetanus_neonatorum_p }}
                                                    </td>
                                                    <td id="tetanus_neonatorum_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandtetanus_neonatorum_lp += $tetanus_neonatorum_l + $tetanus_neonatorum_p;
                                                        @endphp
                                                        {{ $tetanus_neonatorum_l + $tetanus_neonatorum_p }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_m = $item->filterTable69(Session::get('year'), $item->id)->tetanus_neonatorum_m;
                                                            $Grandtetanus_neonatorum_m += $tetanus_neonatorum_m;
                                                        @endphp
                                                        {{ $tetanus_neonatorum_m }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hepatitis_l = $item->filterTable69(Session::get('year'), $item->id)->hepatitis_l;
                                                            $Grandhepatitis_l += $hepatitis_l;
                                                        @endphp
                                                        {{ $hepatitis_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hepatitis_p = $item->filterTable69(Session::get('year'), $item->id)->hepatitis_p;
                                                            $Grandhepatitis_p += $hepatitis_p;
                                                        @endphp
                                                        {{ $hepatitis_p }}
                                                    </td>
                                                    <td id="hepatitis_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandhepatitis_lp += $hepatitis_l + $hepatitis_p;
                                                        @endphp
                                                        {{ $hepatitis_l + $hepatitis_p }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $suspek_campak_l = $item->filterTable69(Session::get('year'), $item->id)->suspek_campak_l;
                                                            $Grandsuspek_campak_l += $suspek_campak_l;
                                                        @endphp
                                                        {{ $suspek_campak_l }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $suspek_campak_p = $item->filterTable69(Session::get('year'), $item->id)->suspek_campak_p;
                                                            $Grandsuspek_campak_p += $suspek_campak_p;
                                                        @endphp
                                                        {{ $suspek_campak_p }}
                                                    </td>
                                                    
                                                    <td id="suspek_campak_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandsuspek_campak_lp += $suspek_campak_p + $suspek_campak_l;
                                                        @endphp
                                                        {{$suspek_campak_p + $suspek_campak_l}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">JUMLAH</th>
                                            <th id="Granddifteri_l">{{$Granddifteri_l }} </th>
                                            <th id="Granddifteri_p">{{$Granddifteri_p }} </th>
                                            <th id="Granddifteri_lp">{{$Granddifteri_lp }} </th>
                                            <th id="Granddifteri_m">{{$Granddifteri_m }} </th>
                                            <th id="Grandpertusis_l">{{$Grandpertusis_l }} </th>
                                            <th id="Grandpertusis_p">{{$Grandpertusis_p }} </th>
                                            <th id="Grandpertusis_lp">{{$Grandpertusis_lp }} </th>
                                            <th id="Grandtetanus_neonatorum_l">{{$Grandtetanus_neonatorum_l }} </th>
                                            <th id="Grandtetanus_neonatorum_p">{{$Grandtetanus_neonatorum_p }} </th>
                                            <th id="Grandtetanus_neonatorum_lp">{{$Grandtetanus_neonatorum_lp}} </th>
                                            <th id="Grandtetanus_neonatorum_m">{{$Grandtetanus_neonatorum_m }} </th>
                                            <th id="Grandhepatitis_l">{{$Grandhepatitis_l  }} </th>
                                            <th id="Grandhepatitis_p">{{$Grandhepatitis_p  }} </th>
                                            <th id="Grandhepatitis_lp">{{$Grandhepatitis_lp  }} </th>
                                            <th id="Grandsuspek_campak_l">{{$Grandsuspek_campak_l  }} </th>
                                            <th id="Grandsuspek_campak_p">{{$Grandsuspek_campak_p }} </th>
                                            <th id="Grandsuspek_campak_lp">{{$Grandsuspek_campak_lp }} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="1">CASE FATALITY RATE (%)</th>
                                            <th colspan="3"></th>
                                            <th id="case_1">{{$Granddifteri_lp>0?number_format(($Granddifteri_m / $Granddifteri_lp) * 100, 2) . '%':0}}</th>
                                            <th colspan="6"></th>
                                            <th id="case_2">{{$Grandtetanus_neonatorum_lp>0?number_format(($Grandtetanus_neonatorum_m / $Grandtetanus_neonatorum_lp) * 100, 2) . '%':0}}</th>
                                            <th colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="15">INCIDENCE RATE SUSPEK CAMPAK</th>
                                            <th id="incidence_1">{{($Grandsuspek_campak_l / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_2">{{($Grandsuspek_campak_p / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_3">{{($Grandsuspek_campak_lp / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                    @endrole
                                </tbody>
                            </table>