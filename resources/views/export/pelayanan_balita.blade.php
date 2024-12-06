<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN PELAYANAN KESEHATAN BAYI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="3" rowspan="2">Jumlah Bayi</th>
        <th colspan="6">Pelayanan Kesehatan Bayi</th>
    </tr>
    <tr>
        <th colspan="2">L</th>
        <th colspan="2">P</th>
        <th colspan="2">L + P</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L + P</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
            $lahir_hidup_L = 0;
            $lahir_hidup_P = 0;
            $jumlah_L = 0;
            $jumlah_P = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $lahir_hidup_L += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"];
            $lahir_hidup_P += $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"];
            $jumlah_L += $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"];
            $jumlah_P += $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]
            /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]
                + $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]
                }}</td>
            <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
            number_format(($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"])
            /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
            ):0}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{$jumlah_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($jumlah_L/$lahir_hidup_L) * 100, 2):0}}</td>
            <td>{{$jumlah_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($jumlah_P/$lahir_hidup_P) * 100, 2):0}}</td>
            <td>{{$jumlah_P + $jumlah_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($jumlah_P + $jumlah_L)/($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPelayananBalita(Session::get('year')))
        @php
        $lahir_hidup_L += $item->filterKelahiran(Session::get('year'))->lahir_hidup_L;
        $lahir_hidup_P += $item->filterKelahiran(Session::get('year'))->lahir_hidup_P;
        $jumlah_L += $item->filterPelayananBalita(Session::get('year'))->jumlah_L;
        $jumlah_P += $item->filterPelayananBalita(Session::get('year'))->jumlah_P;
    @endphp

        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            
            @php
            $filterPelayananBalita = $item->filterPelayananBalita(Session::get('year'));
            $filterKelahiran = $item->filterKelahiran(Session::get('year'));
        @endphp
        
        <td>{{ $filterPelayananBalita->jumlah_L }}</td>
        <td id="persen_jumlah_L{{ $filterPelayananBalita->id }}">
            {{
                $filterKelahiran->lahir_hidup_L > 0 
                ? number_format($filterPelayananBalita->jumlah_L / $filterKelahiran->lahir_hidup_L * 100, 2)
                : 0
            }}
        </td>
        
        <td>{{ $filterPelayananBalita->jumlah_P }}</td>
        <td id="persen_jumlah_P{{ $filterPelayananBalita->id }}">
            {{
                $filterKelahiran->lahir_hidup_P > 0 
                ? number_format($filterPelayananBalita->jumlah_P / $filterKelahiran->lahir_hidup_P * 100, 2)
                : 0
            }}
        </td>
        
            
            <td id="jumlah_LP{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterPelayananBalita(Session::get('year'))->jumlah_P + $item->filterPelayananBalita(Session::get('year'))->jumlah_L}}</td>
            <td id="persen_jumlah_LP{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
            number_format( ($item->filterPelayananBalita(Session::get('year'))->jumlah_P + $item->filterPelayananBalita(Session::get('year'))->jumlah_L)/
                ($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
            
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{$jumlah_L}}</td>
            <td>{{$lahir_hidup_L > 0?number_format(($jumlah_L/$lahir_hidup_L) * 100, 2):0}}</td>
            <td>{{$jumlah_P}}</td>
            <td>{{$lahir_hidup_P > 0?number_format(($jumlah_P/$lahir_hidup_P) * 100, 2):0}}</td>
            <td>{{$jumlah_P + $jumlah_L}}</td>
            <td>{{$lahir_hidup_L + $lahir_hidup_P > 0?number_format((($jumlah_P + $jumlah_L)/($lahir_hidup_P + $lahir_hidup_L)) * 100, 2):0}}</td>
        </tr>
        @endrole
    </tbody>
</table>