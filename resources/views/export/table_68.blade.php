<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>JUMLAH KASUS AFP (NON POLIO) MENURUT KECAMATAN DAN PUSKESMAS</th>
                                    </tr>
                                    <tr>
                                        <th>Kabupaten/Kota Kutai Timur</th>
                                    </tr>
                                    <tr>
                                        <th>Tahun {{Session::get('year')}}</th>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th >JUMLAH PENDUDUK < 15 TAHUN</th>
                                        <th >"JUMLAH KASUS AFP (NON POLIO)"</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandjumlah_penduduk_15 = 0;
                                        $Grandjumlah_kasus_afp = 0;
                                        $AffRate = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                            <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                <td>{{ $item->kecamatan }}</td>
                                                <td class="unit_kerja">{{ $item->nama }}</td>
                                                <td>
                                                    @php
                                                        $jumlah_penduduk_15 = $item->unitKerjaAmbilPart2('filterTable68', Session::get('year'), 'jumlah_penduduk_15')['total'];
                                                        $Grandjumlah_penduduk_15 += $jumlah_penduduk_15;
                                                        echo $jumlah_penduduk_15;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $jumlah_kasus_afp = $item->unitKerjaAmbilPart2('filterTable68', Session::get('year'), 'jumlah_kasus_afp')['total'];
                                                        $Grandjumlah_kasus_afp += $jumlah_kasus_afp;
                                                        echo $jumlah_kasus_afp;
                                                    @endphp
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="Grandjumlah_penduduk_15">{{$Grandjumlah_penduduk_15}}</th>
                                            <th id="Grandjumlah_kasus_afp">{{$Grandjumlah_kasus_afp}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">AFP RATE (NON POLIO) PER 100.000 PENDUDUK USIA < 15 TAHUN</th>
                                            <th id="AffRate">{{ ($Grandjumlah_kasus_afp / $Grandjumlah_penduduk_15) * 100000 }}</th>
                                        </tr>
                                    @endrole

                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable68(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jumlah_penduduk_15 = $item
                                                                ->filterTable68(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_penduduk_15;
                                                            $Grandjumlah_penduduk_15 += $jumlah_penduduk_15;
                                                        @endphp
                                                       {{ $jumlah_penduduk_15 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_kasus_afp = $item
                                                                ->filterTable68(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_kasus_afp;
                                                            $Grandjumlah_kasus_afp += $jumlah_kasus_afp;
                                                        @endphp
                                                      {{ $jumlah_kasus_afp }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="Grandjumlah_penduduk_15">{{$Grandjumlah_penduduk_15}}</th>
                                            <th id="Grandjumlah_kasus_afp">{{$Grandjumlah_kasus_afp}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">AFP RATE (NON POLIO) PER 100.000 PENDUDUK USIA < 15 TAHUN</th>
                                            <th id="AffRate">{{ $Grandjumlah_penduduk_15>0?($Grandjumlah_kasus_afp / $Grandjumlah_penduduk_15) * 100000:0 }}</th>
                                        </tr>
                                    @endrole
                                </tbody>
                            </table>