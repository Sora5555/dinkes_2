<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>KEJADIAN LUAR BIASA (KLB) DI DESA/KELURAHAN YANG DITANGANI KURANG DARI 24 JAM</th>
                                    </tr>
                                    <tr>
                                        <th>Kabupaten/Kota Kutai Timur</th>
                                    </tr>
                                    <tr>
                                        <th>Tahun {{Session::get('year')}}</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="2" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="2" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="3">KLB DI DESA/KELURAHAN</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH</th>
                                        <th>DITANGANI < 24 JAM</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $GrandJumlah = 0;
                                        $Grandditangani_24 = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $jumlah = $item->unitKerjaAmbilPart2('filterTable70', Session::get('year'), 'jumlah')['total'];
                                                    $GrandJumlah += $jumlah;
                                                    echo $jumlah;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $ditangani_24 = $item->unitKerjaAmbilPart2('filterTable70', Session::get('year'), 'ditangani_24')['total'];
                                                    $Grandditangani_24 += $ditangani_24;
                                                    echo $ditangani_24;
                                                @endphp
                                            </td>
                                            <td>
                                                {{$ditangani_24 > 0 && $jumlah > 0? number_format(($ditangani_24 / $jumlah) * 100, 2) . '%' : 0}}
                                            </td>
                                        </tr>
                                        @endforeach

                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable70(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jumlah = $item
                                                                ->filterTable70(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah;
                                                            $GrandJumlah += $jumlah;
                                                        @endphp
                                                        {{ $jumlah }}
                                                    </td>
                                                    <td>
                                                        {{ $ditangani_24 }}
                                                    </td>
                                                    <td id="klb_p_{{ $item->filterTable70(Session::get('year'), $item->id)->id }}">
                                                        {{$jumlah>0?number_format(($ditangani_24 / $jumlah) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole
                                    <tr>
                                        <th colspan="2">JUMLAH</th>
                                        <th id="GrandJumlah">{{ $GrandJumlah  }}</th>
                                        <th id="Grandditangani_24">{{ $Grandditangani_24 }}</th>
                                        <th id="GrandKLB_P">{{$GrandJumlah>0?number_format(($Grandditangani_24 / $GrandJumlah) * 100, 2) . '%':0}}</th>
                                    </tr>
                                </tbody>
                            </table>