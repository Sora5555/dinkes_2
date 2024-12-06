<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>PENDERITA KUSTA SELESAI BEROBAT (RELEASE FROM TREATMENT/RFT) MENURUT TIPE, KECAMATAN, DAN PUSKESMAS</th>
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
                                        <th colspan="3">KUSTA (PB)</th>
                                        <th colspan="3">KUSTA (MB)</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">Tahun</th>
                                        <th colspan="2">2022</th>
                                        <th colspan="1">Tahun</th>
                                        <th colspan="2">2021</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">JML PENDERITA BARUa</th>
                                        <th colspan="1">JML PENDERITA RFT</th>
                                        <th colspan="1">RFT RATE PB (%)</th>
                                        <th colspan="1">JML PENDERITA BARUb</th>
                                        <th colspan="1">JML PENDERITA RFT</th>
                                        <th colspan="1">RFT RATE MB (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                        @php
                                            $Grandkusta_2022_baru = 0;
                                            $Grandkusta_2022_rft = 0;
                                            $Grandkusta_2021_baru = 0;
                                            $Grandkusta_2021_rft = 0;
                                        @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $kusta_2022_baru = $item->unitKerjaAmbilPart2('filterTable67', Session::get('year'), 'kusta_2022_baru')['total'];
                                                    $Grandkusta_2022_baru += $kusta_2022_baru;
                                                    echo $kusta_2022_baru;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kusta_2022_rft = $item->unitKerjaAmbilPart2('filterTable67', Session::get('year'), 'kusta_2022_rft')['total'];
                                                    $Grandkusta_2022_rft += $kusta_2022_rft;
                                                    echo  $kusta_2022_rft;
                                                @endphp
                                            </td>
                                            <td>
                                                {{$kusta_2022_baru>0 ? number_format(($kusta_2022_rft / $kusta_2022_baru) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $kusta_2021_baru = $item->unitKerjaAmbilPart2('filterTable67', Session::get('year'), 'kusta_2021_baru')['total'];
                                                    $Grandkusta_2021_baru += $kusta_2021_baru;
                                                    echo $kusta_2021_baru;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kusta_2021_rft = $item->unitKerjaAmbilPart2('filterTable67', Session::get('year'), 'kusta_2021_rft')['total'];
                                                    $Grandkusta_2021_rft += $kusta_2021_rft;
                                                    echo  $kusta_2021_rft;
                                                @endphp
                                            </td>
                                            <td>
                                                {{$kusta_2021_baru>0?number_format(($kusta_2021_rft / $kusta_2021_baru) * 100, 2) . '%':0}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th>{{  $Grandkusta_2022_baru }}</th>
                                            <th>{{ $Grandkusta_2022_rft  }}</th>
                                            <th>
                                                {{$Grandkusta_2022_rft > 0 && $Grandkusta_2022_baru > 0 ? number_format(($Grandkusta_2022_rft / $Grandkusta_2022_baru) * 100, 2) . '%' : 0}}
                                            </th>
                                            <th>{{ $Grandkusta_2021_baru }}</th>
                                            <th>{{ $Grandkusta_2021_rft  }}</th>
                                            <th>
                                                {{$Grandkusta_2021_rft > 0 && $Grandkusta_2021_baru > 0 ? number_format(($Grandkusta_2021_rft / $Grandkusta_2021_baru) * 100, 2) . '%' : 0}}
                                            </th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $Grandkusta_2022_baru = 0;
                                            $Grandkusta_2022_rft = 0;
                                            $Grandkusta_2021_baru = 0;
                                            $Grandkusta_2021_rft = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable67(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $kusta_2022_baru = $item
                                                                ->filterTable67(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kusta_2022_baru;
                                                            $Grandkusta_2022_baru += $kusta_2022_baru;
                                                        @endphp
                                                        {{ $kusta_2022_baru }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kusta_2022_rft = $item
                                                                ->filterTable67(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kusta_2022_rft;
                                                            $Grandkusta_2022_rft += $kusta_2022_rft;
                                                        @endphp
                                                        {{ $kusta_2022_rft }}
                                                    </td>
                                                    <td id="pb_rate_{{ $item->filterTable67(Session::get('year'), $item->id)->id }}">
                                                        {{ $kusta_2022_baru ? number_format(($kusta_2022_rft / $kusta_2022_baru) * 100, 2) . '%' : 0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kusta_2021_baru = $item
                                                                ->filterTable67(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kusta_2021_baru;
                                                            $Grandkusta_2021_baru += $kusta_2021_baru;
                                                        @endphp
                                                        {{ $kusta_2021_baru }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kusta_2021_rft = $item
                                                                ->filterTable67(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kusta_2021_rft;
                                                            $Grandkusta_2021_rft += $kusta_2021_rft;
                                                        @endphp
                                                        {{ $kusta_2021_rft }}
                                                    </td>
                                                    
                                                    <td id="mb_rate_{{ $item->filterTable67(Session::get('year'), $item->id)->id }}">
                                                        {{$kusta_2021_baru>0?number_format(($kusta_2021_rft / $kusta_2021_baru) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="Grandkusta_2022_baru">{{  $Grandkusta_2022_baru }}</th>
                                            <th id="Grandkusta_2022_rft">{{ $Grandkusta_2022_rft  }}</th>
                                            <th id="PGrandKusta_2022">
                                                {{$Grandkusta_2022_baru>0?number_format(($Grandkusta_2022_rft / $Grandkusta_2022_baru) * 100, 2) . '%':0}}
                                            </th>
                                            <th id="Grandkusta_2021_baru">{{ $Grandkusta_2021_baru }}</th>
                                            <th id="Grandkusta_2021_rft">{{ $Grandkusta_2021_rft  }}</th>
                                            <th id="PGrandKusta_2021">
                                                {{$Grandkusta_2021_baru>0?number_format(($Grandkusta_2021_rft / $Grandkusta_2021_baru) * 100, 2) . '%':0}}
                                            </th>
                                        </tr>
                                    @endrole
                                </tbody>
                            </table>