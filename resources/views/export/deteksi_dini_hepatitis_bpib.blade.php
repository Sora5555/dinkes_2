<table id="data" class="table table-bordered dt-responsive"
style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead class="text-center">
    <tr>
        <th>DETEKSI DINI HEPATITIS B PADA IBU HAMIL MENURUT KECAMATAN DAN PUSKESMAS</th>
    </tr>
    <tr>
        <th>Kabupaten/Kota Kutai Timur</th>
    </tr>
    <tr>
        <th>Tahun {{Session::get('year')}}</th>
    </tr>
    <tr>
        <th rowspan="2">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="2">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="2">Desa</th>
        @endrole
        <th rowspan="2">JUMLAH IBU HAMIL </th>
        <th colspan="3">JUMLAH IBU HAMIL DIPERIKSA</th>
        <th rowspan="2">% BUMIL DIPERIKSA</th>
        <th rowspan="2">% BUMIL REAKTIF </th>
    </tr>
    <tr>
        <th>REAKTIF</th>
        <th>NON REAKTIF</th>
        <th>TOTAL</th>
    </tr>
</thead>
<tbody>
    @role('Admin|superadmin')
        @php
            $GrandTotalIbuHamil = 0;
            $GrandReaktif = 0;
            $GrandNonReaktif = 0;
            $GrandTotal = 0;
        @endphp
        @foreach ($unit_kerja as $key => $item)
            <tr style={{ $key % 2 == 0 ? 'background: gray' : '' }}>
                <td>{{ $item->kecamatan }}</td>
                <td class="unit_kerja">{{ $item->nama }}</td>
                <td>
                    @php
                        $totalIbuHamil = $item->unitKerjaAmbilPart2('filterDesa', Session::get('year'), 'jumlah_ibu_hamil')['total'];
                        $GrandTotalIbuHamil += $totalIbuHamil;
                    @endphp
                    {{ $totalIbuHamil }}
                    {{-- <input type="hidden" name="jumlah_ibu_hamil" value="{{ $totalIbuHamil }}"> --}}
                </td>
                <td>
                    @php
                        $reaktif = $item->unitKerjaAmbilPart2('filterDeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'), 'reaktif')['total'];
                        $GrandReaktif += $reaktif;
                        
                        echo $reaktif;
                    @endphp
                </td>
                <td>
                    @php
                        $non_reaktif = $item->unitKerjaAmbilPart2('filterDeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'), 'non_reaktif')['total'];;
                        $GrandNonReaktif += $non_reaktif;
                        echo $non_reaktif;
                    @endphp
                </td>
                <td>
                    @php
                        $total = $reaktif + $non_reaktif;
                        $GrandTotal += $total;

                    @endphp
                    {{ $total }}
                </td>
                <td>
                    @php
                        $bumilDiperiksa = $totalIbuHamil>0?($total / $totalIbuHamil) * 100:0;
                    @endphp
                    {{ number_format($bumilDiperiksa, 2) . '%' }}
                </td>
                <td>
                    {{ $total>0?number_format(($reaktif / $total) * 100, 2) . '%':0 }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2">Jumlah</td>
            <td id="jumlah_ibu_hamil">{{ $GrandTotalIbuHamil }}</td>
            <td id="jumlah_reaktif">{{ $GrandReaktif }}</td>
            <td id="jumlah_non_reaktif">
                {{ $GrandNonReaktif }}
            </td>
            <td id="jumlah_total">
                {{ $GrandTotal }}
            </td>
            <td id="jumlah_bumil_diperiksa">
                {{ $GrandTotalIbuHamil>0?number_format($GrandTotal / $GrandTotalIbuHamil, 2) . '%':0 }}
            </td>
            <td id="jumlah_bumil_reaktif">
                {{ $GrandTotal>0?number_format($GrandReaktif / $GrandTotal, 2) . '%':0 }}
            </td>
        </tr>
    @endrole
    @role('Puskesmas|Pihak Wajib Pajak')
        @php
            $GrandTotalIbuHamil = 0;
            $GrandReaktif = 0;
            $GrandNonReaktif = 0;
            $GrandTotal = 0;
        @endphp
        @foreach ($desa as $key => $item)
            @if ($item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id))
                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                    <td class="unit_kerja">{{ $item->nama }}</td>
                    <td>
                        @php
                            $totalIbuHamil = $item
                                ->filterDesa(
                                    Session::get('year'),
                                )
                                ->jumlah_ibu_hamil;
                            $GrandTotalIbuHamil += $totalIbuHamil;
                        @endphp
                        {{ $totalIbuHamil }}
                    </td>
                    <td>
                        @php
                            $GrandReaktif += $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                Session::get('year'),
                                $item->id,
                            )->reaktif;
                        @endphp
                        {{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->reaktif }}
                    </td>
                    <td>
                        @php
                            $GrandNonReaktif += $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                Session::get('year'),
                                $item->id,
                            )->non_reaktif;
                        @endphp
                        {{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->non_reaktif }}
                    </td>
                    
                    <td
                        id="total_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                        @php
                            $total =
                                $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                    Session::get('year'),
                                    $item->id,
                                )->reaktif +
                                $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                    Session::get('year'),
                                    $item->id,
                                )->non_reaktif;
                            $GrandTotal += $total;

                        @endphp
                        {{ $total }}
                    </td>
                    <td
                        id="bumil_diperiksa_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                        @php
                            $bumilDiperiksa = $totalIbuHamil>0?($total / $totalIbuHamil) * 100:0;
                        @endphp
                        {{ number_format($bumilDiperiksa, 2) . '%' }}
                    </td>
                    <td
                        id="bumil_reaktif_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                        {{ $total>0?number_format(($item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->reaktif / $total) * 100, 2) . '%':0 }}
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="2">Jumlah</td>
            <td id="jumlah_ibu_hamil">{{ $GrandTotalIbuHamil }}</td>
            <td id="jumlah_reaktif">{{ $GrandReaktif }}</td>
            <td id="jumlah_non_reaktif">
                {{ $GrandNonReaktif }}
            </td>
            <td id="jumlah_total">
                {{ $GrandTotal }}
            </td>
            <td id="jumlah_bumil_diperiksa">
                {{ $GrandTotalIbuHamil>0?number_format($GrandTotal / $GrandTotalIbuHamil, 2) . '%':0 }}
            </td>
            <td id="jumlah_bumil_reaktif">
                {{ $GrandTotal>0?number_format($GrandReaktif / $GrandTotal, 2) . '%':0 }}
            </td>
        </tr>
    @endrole
</tbody>
</table>