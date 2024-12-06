<table id="data" class="table table-bordered dt-responsive"
style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="text-center">
    <tr>
        <th>JUMLAH KASUS TERDAFTAR DAN ANGKA PREVALENSI PENYAKIT KUSTA MENURUT TIPE/JENIS, USIA, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="9">KASUS TERDAFTAR</th>
    </tr>
    <tr>
        <TH colspan="3">PAUSI BASILER / KUSTA KERING</TH>
        <TH colspan="3">MULTI BASILER / KUSTA BASAH</TH>
        <TH colspan="3">JUMLAH</TH>
    </tr>
    <tr>
        <TH>ANAK</TH>
        <TH>DEWASA</TH>
        <TH>TOTAL</TH>
        <TH>ANAK</TH>
        <TH>DEWASA</TH>
        <TH>TOTAL</TH>
        <TH>ANAK</TH>
        <TH>DEWASA</TH>
        <TH>TOTAL</TH>
    </tr>
</thead>
<tbody>
    @role('Admin|superadmin')
        @php
            $GrandPausi_anak =  0;
            $GrandPausi_dewasa =  0;
            $GrandPausi_total =  0;
            $GrandMulti_anak =  0;
            $GrandMulti_dewasa =  0;
            $GrandMulti_total =  0;
            $GrandJumlah_anak =  0;
            $GrandJumlah_dewasa = 0;
            $GrandJumlah_total =  0;
        @endphp
        @foreach ($unit_kerja as $key => $item)
        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
            <td>{{ $item->kecamatan }}</td>
            <td class="unit_kerja">{{ $item->nama }}</td>
            <td>
                @php
                    $pausi_anak = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'pausi_anak')['total'];
                    $GrandPausi_anak += $pausi_anak;
                    echo $pausi_anak;
                @endphp
            </td>
            <td>
                @php
                    $pausi_dewasa = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'pausi_dewasa')['total'];

                    $GrandPausi_dewasa += $pausi_dewasa;
                    echo $pausi_dewasa;
                @endphp
            </td>
            <td>
                @php
                    $GrandPausi_total += $pausi_anak + $pausi_dewasa;
                @endphp
                {{$pausi_anak + $pausi_dewasa}}
            </td>
            <td>
                @php
                    $multi_anak = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'multi_anak')['total'];

                    $GrandMulti_anak += $multi_anak;
                    echo $multi_anak;
                    // $GrandJumlahBayi += $jumlah_bayi;
                    // $GrandTotalIbuHamil += $totalIbuHamil;
                @endphp
            </td>
            <td>
                @php
                    $multi_dewasa = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'multi_dewasa')['total'];

                    $GrandMulti_dewasa += $multi_dewasa;
                    echo $multi_dewasa;
                @endphp
            </td>
            <td>
                @php
                    $GrandMulti_total += $multi_anak + $multi_dewasa;
                @endphp
                {{$multi_anak + $multi_dewasa}}
            </td>
            <td>
                @php
                    $jumlah_anak = $multi_anak + $pausi_anak;
                    echo $jumlah_anak;

                    $GrandJumlah_anak += $jumlah_anak;
                @endphp
            </td>
            <td>
                @php
                    $jumlah_dewasa = $multi_dewasa + $pausi_dewasa;
                    echo $jumlah_dewasa;


                    $GrandJumlah_dewasa += $jumlah_dewasa;
                @endphp
            </td>
            <td>
                @php
                    $jumlah_total = $jumlah_anak + $jumlah_dewasa;
                    echo $jumlah_total;

                    $GrandJumlah_total += $jumlah_total;

                @endphp
            </td>

        </tr>
        @endforeach
        <tr>
            <th colspan="2">JUMLAH</th>
            <th>{{    $GrandPausi_anak}}</th>
            <th>{{  $GrandPausi_dewasa}}</th>
            <th>{{   $GrandPausi_total}}</th>
            <th>{{    $GrandMulti_anak}}</th>
            <th>{{  $GrandMulti_dewasa}}</th>
            <th>{{   $GrandMulti_total}}</th>
            <th>{{   $GrandJumlah_anak}}</th>
            <th>{{ $GrandJumlah_dewasa}}</th>
            <th>{{  $GrandJumlah_total}}</th>
        </tr>
        <tr>
            <th colspan="2">ANGKA PREVALENSI PER 10.000 PENDUDUK</th>
            <th colspan="8"></th>
            <th id="angka_prevalensi">
                {{($GrandJumlah_total / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 10000}}
            </th>
        </tr>
    @endrole
    @role('Puskesmas|Pihak Wajib Pajak')
        @php
            $GrandPausi_anak =  0;
            $GrandPausi_dewasa =  0;
            $GrandPausi_total =  0;
            $GrandMulti_anak =  0;
            $GrandMulti_dewasa =  0;
            $GrandMulti_total =  0;
            $GrandJumlah_anak =  0;
            $GrandJumlah_dewasa = 0;
            $GrandJumlah_total =  0;
        @endphp
        @foreach ($desa as $key => $item)
            @if ($item->filterTable66(Session::get('year'), $item->id))
                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                    <td class="unit_kerja">{{ $item->nama }}</td>
                    <td>
                        @php
                            $pausi_anak = $item
                                ->filterTable66(
                                    Session::get('year'),
                                    $item->id,
                                )
                                ->pausi_anak;
                            $GrandPausi_anak += $pausi_anak;
                        @endphp
                        {{ $pausi_anak }}
                    </td>
                    <td>
                        @php
                            $pausi_dewasa = $item->filterTable66(
                                Session::get('year'),
                                $item->id,
                            )->pausi_dewasa;
                    
                            $GrandPausi_dewasa += $pausi_dewasa;
                        @endphp
                        {{ $pausi_dewasa }}
                    </td>
                    <td id="total_pausi{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                        @php
                            $GrandPausi_total += $pausi_anak + $pausi_dewasa;
                        @endphp
                        {{ $pausi_anak + $pausi_dewasa }}
                    </td>
                    <td>
                        @php
                            $multi_anak = $item
                                ->filterTable66(
                                    Session::get('year'),
                                    $item->id,
                                )
                                ->multi_anak;
                    
                            $GrandMulti_anak += $multi_anak;
                        @endphp
                        {{ $multi_anak }}
                    </td>
                    <td>
                        @php
                            $multi_dewasa = $item->filterTable66(
                                Session::get('year'),
                                $item->id,
                            )->multi_dewasa;
                    
                            $GrandMulti_dewasa += $multi_dewasa;
                        @endphp
                        {{ $multi_dewasa }}
                    </td>
                    
                    <td id="total_multi{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                        @php
                            $GrandMulti_total += $multi_anak + $multi_dewasa;
                        @endphp
                        {{$multi_anak + $multi_dewasa}}
                    </td>
                    <td id="jumlah_anak{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                        @php
                            $jumlah_anak = $multi_anak + $pausi_anak;
                            echo $jumlah_anak;

                            $GrandJumlah_anak += $jumlah_anak;
                        @endphp
                    </td>
                    <td id="jumlah_dewasa{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                        @php
                            $jumlah_dewasa = $multi_dewasa + $pausi_dewasa;
                            echo $jumlah_dewasa;


                            $GrandJumlah_dewasa += $jumlah_dewasa;
                        @endphp
                    </td>
                    <td id="jumlah_total{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                        @php
                            $jumlah_total = $jumlah_anak + $jumlah_dewasa;
                            echo $jumlah_total;

                            $GrandJumlah_total += $jumlah_total;

                        @endphp
                    </td>

                </tr>
            @endif
        @endforeach
        <tr>
            <th colspan="2">JUMLAH</th>
            <th id="GrandPausi_anak">{{    $GrandPausi_anak}}</th>
            <th id="GrandPausi_dewasa">{{  $GrandPausi_dewasa}}</th>
            <th id="GrandPausi_total">{{   $GrandPausi_total}}</th>
            <th id="GrandMulti_anak">{{    $GrandMulti_anak}}</th>
            <th id="GrandMulti_dewasa">{{  $GrandMulti_dewasa}}</th>
            <th id="GrandMulti_total">{{   $GrandMulti_total}}</th>
            <th id="GrandJumlah_anak">{{   $GrandJumlah_anak}}</th>
            <th id="GrandJumlah_dewasa">{{ $GrandJumlah_dewasa}}</th>
            <th id="GrandJumlah_total">{{  $GrandJumlah_total}}</th>
        </tr>
        <tr>
            <th colspan="2">ANGKA PREVALENSI PER 10.000 PENDUDUK</th>
            <th colspan="8"></th>
            <th id="angka_prevalensi">
                {{($GrandJumlah_total / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 10000}}
            </th>
        </tr>
    @endrole
</tbody>
</table>