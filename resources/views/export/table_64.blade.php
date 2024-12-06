<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>KASUS BARU KUSTA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
                                        <th colspan="3">PAUSI BASILER (PB)/ KUSTA KERING</th>
                                        <th colspan="3">MULTI BASILER (MB)/ KUSTA BASAH</th>
                                        <th colspan="3">PB + MB</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                    @php
                                        $GrandL_PB = 0;
                                        $GrandP_PB = 0;
                                        $GrandLP_PB = 0;
                                        $GrandL_MB = 0;
                                        $GrandP_MB = 0;
                                        $GrandLP_MB = 0;
                                        $GrandL_PBMB = 0;
                                        $GrandP_PBMB = 0;
                                        $GrandLP_PBMB = 0;
                                    @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                            <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                                <td>
                                                    @php
                                                        $l_pb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'l_pb')['total'];
                                                        // $GrandJumlahBayi += $jumlah_bayi;
                                                        // $GrandTotalIbuHamil += $totalIbuHamil;
                                                    @endphp
                                                    {{  $l_pb }}
                                                </td>
                                                <td>
                                                    @php
                                                        $p_pb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'p_pb')['total'];
                                                        $GrandP_PB += $p_pb;
                                                        // $GrandJumlahK24 += $jumlah_k_24;
                                                    @endphp
                                                    {{ $p_pb }}
                                                </td>
                                                <td>
                                                    {{$p_pb + $l_pb}}
                                                    @php
                                                        $GrandLP_PB += ($p_pb + $l_pb);
                                                    @endphp
                                                    {{-- {{ number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%' }} --}}
                                                </td>
                                                <td>
                                                    @php
                                                        $l_mb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'l_mb')['total'];
                                                        $GrandL_MB += ($l_mb);
                                                        // $GrandJumlahB24 += $jumlah_b_24;
                                                    @endphp
                                                    {{ $l_mb }}
                                                </td>
                                                <td>
                                                    @php
                                                        $p_mb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'p_mb')['total'];
                                                        $GrandP_MB += $p_mb;
                                                        // $GrandJumlahB24 += $jumlah_b_24;
                                                    @endphp
                                                    {{ $p_mb }}
                                                </td>
                                                <td>
                                                    {{$l_mb + $p_mb}}
                                                    @php
                                                    $GrandLP_MB += ($l_mb + $p_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$l_pb + $l_mb}}
                                                    @php
                                                        $GrandL_PBMB += ($l_pb + $l_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$p_pb + $p_mb}}
                                                    @php
                                                        $GrandP_PBMB += ($p_pb + $p_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$l_pb + $l_mb + $p_pb + $p_mb}}
                                                    @php
                                                        $GrandLP_PBMB += ($l_pb + $l_mb + $p_pb + $p_mb);
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="GrandL_PB">{{$GrandL_PB}}</th>
                                            <th id="GrandP_PB">{{$GrandP_PB}}</th>
                                            <th id="GrandLP_PB">{{$GrandLP_PB}}</th>
                                            <th id="GrandL_MB">{{$GrandL_MB}}</th>
                                            <th id="GrandP_MB">{{$GrandP_MB}}</th>
                                            <th id="GrandLP_MB">{{$GrandLP_MB}}</th>
                                            <th id="GrandL_PBMB">{{$GrandL_PBMB}}</th>
                                            <th id="GrandP_PBMB">{{$GrandP_PBMB}}</th>
                                            <th id="GrandLP_PBMB">{{$GrandLP_PBMB}}</th>

                                        </tr>
                                        <tr>
                                            <th colspan="2">PROPORSI JENIS KELAMIN</th>
                                            <th id="PGrandL_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">ANGKA PENEMUAN KASUS BARU (NCDR/NEW CASE DETECTION RATE) PER 100.000 PENDUDUK</th>
                                            <th id="l_case">{{$jumlah_penduduk_laki_laki>0?($GrandL_PBMB / $jumlah_penduduk_laki_laki) * 100000:0}}</th>
                                            <th id="p_case">{{$jumlah_penduduk_perempuan>0?($GrandP_PBMB / $jumlah_penduduk_perempuan) * 100000:0}}</th>

                                            <th id="lp_case">{{$jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki>0?($GrandLP_PBMB / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000:0}}</th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandL_PB = 0;
                                            $GrandP_PB = 0;
                                            $GrandLP_PB = 0;
                                            $GrandL_MB = 0;
                                            $GrandP_MB = 0;
                                            $GrandLP_MB = 0;
                                            $GrandL_PBMB = 0;
                                            $GrandP_PBMB = 0;
                                            $GrandLP_PBMB = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable64(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $l_pb = $item
                                                                ->filterTable64(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_pb;
                                                            $GrandL_PB += $l_pb;
                                                        @endphp
                                                        {{ $l_pb }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_pb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->p_pb;
                                                            $GrandP_PB += $p_pb;
                                                        @endphp
                                                        {{ $p_pb }}
                                                    </td>
                                                    <td>
                                                        {{ $p_pb + $l_pb }}
                                                        @php
                                                            $GrandLP_PB += ($p_pb + $l_pb);
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $l_mb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->l_mb;
                                                            $GrandL_MB += $l_mb;
                                                        @endphp
                                                        {{ $l_mb }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_mb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->p_mb;
                                                            $GrandP_MB += $p_mb;
                                                        @endphp
                                                        {{ $p_mb }}
                                                    </td>
                                                    
                                                    <td>
                                                        {{$l_mb + $p_mb}}
                                                        @php
                                                        $GrandLP_MB += ($l_mb + $p_mb);
                                                        @endphp
                                                    </td>
                                                    <td >
                                                        {{$l_pb + $l_mb}}
                                                        @php
                                                            $GrandL_PBMB += ($l_pb + $l_mb);
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{$p_pb + $p_mb}}
                                                        @php
                                                            $GrandP_PBMB += ($p_pb + $p_mb);
                                                        @endphp
                                                    </td>
                                                    <td id="pl_PBMB_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$l_pb + $l_mb + $p_pb + $p_mb}}
                                                        @php
                                                            $GrandLP_PBMB += ($l_pb + $l_mb + $p_pb + $p_mb);
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="GrandL_PB">{{$GrandL_PB}}</th>
                                            <th id="GrandP_PB">{{$GrandP_PB}}</th>
                                            <th id="GrandLP_PB">{{$GrandLP_PB}}</th>
                                            <th id="GrandL_MB">{{$GrandL_MB}}</th>
                                            <th id="GrandP_MB">{{$GrandP_MB}}</th>
                                            <th id="GrandLP_MB">{{$GrandLP_MB}}</th>
                                            <th id="GrandL_PBMB">{{$GrandL_PBMB}}</th>
                                            <th id="GrandP_PBMB">{{$GrandP_PBMB}}</th>
                                            <th id="GrandLP_PBMB">{{$GrandLP_PBMB}}</th>

                                        </tr>
                                        <tr>
                                            <th colspan="2">PROPORSI JENIS KELAMIN</th>
                                            <th id="PGrandL_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">ANGKA PENEMUAN KASUS BARU (NCDR/NEW CASE DETECTION RATE) PER 100.000 PENDUDUK</th>
                                            <th id="l_case">{{($GrandL_PBMB / $jumlah_penduduk_laki_laki) * 100000}}</th>
                                            <th id="p_case">{{($GrandP_PBMB / $jumlah_penduduk_perempuan) * 100000}}</th>
                                            <th id="lp_case">{{($GrandLP_PBMB / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                    @endrole
                                </tbody>
                            </table>