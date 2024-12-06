<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>BAYI BARU LAHIR MENDAPAT IMD* DAN PEMBERIAN ASI EKSKLUSIF PADA BAYI < 6 BULAN MENURUT KECAMATAN DAN PUSKESMAS</th>
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
        <th colspan="3">Bayi Baru Lahir</th>
        <th colspan="3">Bayi Usia < 6 Bulan</th>
    </tr>
    <tr>
        <th rowspan="2">Jumlah</th>
        <th colspan="2">Mendapat Imd</th>
        <th rowspan="2">Jumlah</th>
        <th colspan="2">Mendapat Asi</th>
    </tr>
    <tr>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
            $jumlah_baru_lahir = 0;
            $mendapat_imd = 0;
            $jumlah_enam_bulan = 0;
            $mendapat_asi = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $jumlah_baru_lahir  += $item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_baru_lahir')["total"];
            $mendapat_imd += $item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_imd')["total"];
            $jumlah_enam_bulan += $item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_enam_bulan')["total"];
            $mendapat_asi += $item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_asi')["total"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_baru_lahir')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_imd')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_baru_lahir')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_imd')["total"] 
                /$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_baru_lahir')["total"] * 100, 2
                ):0
                }}</td>   
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_enam_bulan')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_asi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_enam_bulan')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'mendapat_asi')["total"] 
                /$item->unitKerjaAmbil('filterImdAsi', Session::get('year'), 'jumlah_enam_bulan')["total"] * 100, 2
                ):0
                }}</td>   
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah_baru_lahir}}</td>
            <td>{{$mendapat_imd}}</td>
            <td>{{$jumlah_baru_lahir > 0?number_format(($mendapat_imd/$jumlah_baru_lahir) * 100, 2):0}}%</td>
            <td>{{$jumlah_enam_bulan}}</td>
            <td>{{$mendapat_asi}}</td>
            <td>{{$jumlah_enam_bulan > 0?number_format(($mendapat_asi/$jumlah_enam_bulan) * 100, 2):0}}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterImdAsi(Session::get('year')))
        @php
        $jumlah_baru_lahir  += $item->filterImdAsi(Session::get('year'))->jumlah_baru_lahir;
        $mendapat_imd += $item->filterImdAsi(Session::get('year'))->mendapat_imd;
        $jumlah_enam_bulan += $item->filterImdAsi(Session::get('year'))->jumlah_enam_bulan;
        $mendapat_asi += $item->filterImdAsi(Session::get('year'))->mendapat_asi;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            @php
            $filterImdAsi = $item->filterImdAsi(Session::get('year'));
        @endphp
        
        <td>{{ $filterImdAsi->jumlah_baru_lahir }}</td>
        <td>{{ $filterImdAsi->mendapat_imd }}</td>
        <td id="imd{{ $filterImdAsi->id }}">
            {{
                $filterImdAsi->jumlah_baru_lahir > 0 
                ? number_format($filterImdAsi->mendapat_imd / $filterImdAsi->jumlah_baru_lahir * 100, 2)
                : 0
            }}
        </td>
        <td>{{ $filterImdAsi->jumlah_enam_bulan }}</td>
        <td>{{ $filterImdAsi->mendapat_asi }}</td>
        <td id="asi{{ $filterImdAsi->id }}">
            {{
                $filterImdAsi->jumlah_enam_bulan > 0 
                ? number_format($filterImdAsi->mendapat_asi / $filterImdAsi->jumlah_enam_bulan * 100, 2)
                : 0
            }}
        </td>
        
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah_baru_lahir}}</td>
            <td>{{$mendapat_imd}}</td>
            <td>{{$jumlah_baru_lahir > 0?number_format(($mendapat_imd/$jumlah_baru_lahir) * 100, 2):0}}%</td>
            <td>{{$jumlah_enam_bulan}}</td>
            <td>{{$mendapat_asi}}</td>
            <td>{{$jumlah_enam_bulan > 0?number_format(($mendapat_asi/$jumlah_enam_bulan) * 100, 2):0}}%</td>
        </tr>
        @endrole
    </tbody>
</table>