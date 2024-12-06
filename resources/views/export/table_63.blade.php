<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tr>
                                    <th>JUMLAH BAYI YANG LAHIR DARI IBU REAKTIF HBsAg dan MENDAPATKAN HBIG</th>
                                </tr>
                                <tr>
                                    <th>Kabupaten/Kota Kutai Timur</th>
                                </tr>
                                <tr>
                                    <th>Tahun {{Session::get('year')}}</th>
                                </tr>
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="3" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="3" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="3" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th rowspan="3" style="vertical-align: middle">JUMLAH BAYI YANG LAHIR DARI IBU HBsAg Reaktif</th>
                                        <th colspan="6">JUMLAH BAYI YANG LAHIR DARI IBU  HBsAg REAKTIF MENDAPAT HBIG</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">< 24 Jam</th>
                                        <th colspan="2">> 24 Jam</th>
                                        <th colspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                    @php
                                    $GrandJumlahBayi = 0;
                                    $GrandJumlahK24 = 0;
                                    $GrandJumlahB24 = 0;
                                @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $jumlah_bayi = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year'), 'jumlah_bayi')['total'];
                                                @endphp
                                                {{ $jumlah_bayi }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_k_24 = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year') 'jumlah_k_24')['total'];
                                                    echo $jumlah_k_24;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi > 0?number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_b_24 = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year') 'jumlah_b_24')['total'];
                                                    $GrandJumlahB24 += $jumlah_b_24;
                                                    echo $jumlah_b_24;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi>0?number_format(($jumlah_b_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah = $jumlah_b_24 + $jumlah_k_24;
                                                    echo $jumlah;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi>0?number_format(($jumlah / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td id="jumlah_bayi">{{ $GrandJumlahBayi }}</td>
                                            <td id="jumlah_k_24">{{ $GrandJumlahK24 }}</td>
                                            <td id="jumlah_k_p_24">
                                                {{ $GrandJumlahK24 > 0 && $GrandJumlahBayi > 0 ? number_format(($GrandJumlahK24 / $GrandJumlahBayi) * 100, 2).'%' : 0 }}
                                            </td>
                                            <td id="jumlah_b_24">
                                                {{ $GrandJumlahB24 }}
                                            </td>
                                            <td id="jumlah_b_p_24">
                                                {{ $GrandJumlahB24 > 0 && $GrandJumlahBayi > 0 ? number_format(($GrandJumlahB24 / $GrandJumlahBayi) * 100, 2).'%' : 0 }}
                                            </td>
                                            <td id="jumlah_kb_24">
                                                {{$GrandJumlahB24 + $GrandJumlahK24 }}
                                            </td>
                                            <td id="jumlah_kb_p_24">
                                                {{ $GrandJumlahB24 > 0 && $GrandJumlahK24 > 0 && $GrandJumlahBayi > 0 ? number_format((($GrandJumlahB24 + $GrandJumlahK24) / $GrandJumlahBayi) * 100, 2).'%' : 0}}
                                            </td>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandJumlahBayi = 0;
                                            $GrandJumlahK24 = 0;
                                            $GrandJumlahB24 = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable63(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jumlah_bayi = $item
                                                                ->filterTable63(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_bayi;
                                                            $GrandJumlahBayi += $jumlah_bayi;
                                                        @endphp
                                                        {{ $jumlah_bayi }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_k_24 = $item->filterTable63(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->jumlah_k_24;
                                                            $GrandJumlahK24 += $jumlah_k_24;
                                                        @endphp
                                                        {{ $jumlah_k_24 }}
                                                    </td>
                                                    <td id="persen_k_24_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi > 0 ? number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2) . '%' : 0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_b_24 = $item->filterTable63(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->jumlah_b_24;
                                                            $GrandJumlahB24 += $jumlah_b_24;
                                                        @endphp
                                                        {{ $jumlah_b_24 }}
                                                    </td>
                                                    
                                                    <td id="persen_b_24_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi>0?number_format(($jumlah_b_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                                    </td>
                                                    <td id="jumlah_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah = $jumlah_b_24 + $jumlah_k_24;
                                                            echo $jumlah;
                                                        @endphp
                                                    </td>
                                                    <td id="persen_jumlah_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi>0?number_format(($jumlah / $jumlah_bayi) * 100, 2).'%':0 }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td id="jumlah_bayi">{{ $GrandJumlahBayi }}</td>
                                            <td id="jumlah_k_24">{{ $GrandJumlahK24 }}</td>
                                            <td id="jumlah_k_p_24">
                                                {{ $GrandJumlahBayi>0?number_format(($GrandJumlahK24 / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td id="jumlah_b_24">
                                                {{ $GrandJumlahB24 }}
                                            </td>
                                            <td id="jumlah_b_p_24">
                                                {{ $GrandJumlahBayi>0?number_format(($GrandJumlahB24 / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td id="jumlah_kb_24">
                                                {{$GrandJumlahB24 + $GrandJumlahK24 }}
                                            </td>
                                            <td id="jumlah_kb_p_24">
                                                {{ $GrandJumlahBayi>0?number_format((($GrandJumlahB24 + $GrandJumlahK24) / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
                                        </tr>
                                    @endrole
                                </tbody>
                            </table>