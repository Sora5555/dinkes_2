<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PELAYANAN KESEHATAN GIGI DAN MULUT MENURUT KECAMATAN DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="2">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="2">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="2">Desa</th>
        @endrole
        <th colspan="7">Pelayanan Kesehatan Gigi dan Mulut</th>
    </tr>
    <tr>
        <th>Tumpatan Gigi Tetap</th>
        <th>Pencabutan Gigi Tetap</th>
        <th>Jumlah Kunjungan</th>
        <th>Rasio Tumpatan/Pencabutan</th>
        <th>Jumlah Kasus Gigi</th>
        <th>Jumlah Kasus Dirujuk</th>
        <th>% Kasus Dirujuk</th>
    </tr>
    </thead>
    <tbody>
        @php
$totalTumpatan = 0;
$totalPencabutan = 0;
$totalKunjungan = 0;

$totalKasus = 0;
$totalRujukan = 0;
@endphp

        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
$tumpatan = $item->unitKerjaAmbil('filterGigi', Session::get('year'), 'tumpatan')["total"];
$pencabutan = $item->unitKerjaAmbil('filterGigi', Session::get('year'), 'pencabutan')["total"];
$kunjungan = $item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kunjungan')["total"];

$kasus = $item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kasus')["total"];
$rujukan = $item->unitKerjaAmbil('filterGigi', Session::get('year'), 'rujukan')["total"];

// Accumulate totals
$totalTumpatan += $tumpatan;
$totalPencabutan += $pencabutan;
$totalKunjungan += $kunjungan;

$totalKasus += $kasus;
$totalRujukan += $rujukan;
@endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'tumpatan')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'pencabutan')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kunjungan')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'pencabutan')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterGigi', Session::get('year'), 'tumpatan')["total"]
            /$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'pencabutan')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kasus')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'rujukan')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kasus')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterGigi', Session::get('year'), 'rujukan')["total"]
            /$item->unitKerjaAmbil('filterGigi', Session::get('year'), 'kasus')["total"] * 100, 2
            ):0}}</td>
            
            
            
            
            
        </tr>
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td >Total</td>
            <td ></td>
            <td>{{ $totalTumpatan }}</td>
            <td>{{ $totalPencabutan }}</td>
            <td>{{ $totalKunjungan }}</td>
            <td>{{ $totalPencabutan > 0 ? number_format($totalTumpatan / $totalPencabutan * 100, 2) : 0 }}</td>
            <td>{{ $totalKasus }}</td>
            <td>{{ $totalRujukan }}</td>
            <td>{{ $totalKasus > 0 ? number_format($totalRujukan / $totalKasus * 100, 2) : 0 }}</td>
        </tr>
        
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterGigi(Session::get('year')))
        @php
// Fetch data for the current row
$tumpatan = $item->filterGigi(Session::get('year'))->tumpatan;
$pencabutan = $item->filterGigi(Session::get('year'))->pencabutan;
$kunjungan = $item->filterGigi(Session::get('year'))->kunjungan;

$kasus = $item->filterGigi(Session::get('year'))->kasus;
$rujukan = $item->filterGigi(Session::get('year'))->rujukan;

// Accumulate totals
$totalTumpatan += $tumpatan;
$totalPencabutan += $pencabutan;
$totalKunjungan += $kunjungan;

$totalKasus += $kasus;
$totalRujukan += $rujukan;
@endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterGigi(Session::get('year'))->tumpatan}}</td>
            <td>{{$item->filterGigi(Session::get('year'))->pencabutan}}</td>
            <td>{{$item->filterGigi(Session::get('year'))->kunjungan}}</td>
            
            <td id="rasio{{$item->filterGigi(Session::get('year'))->id}}">
                {{$item->filterGigi(Session::get('year'))->pencabutan > 0 ?
                    number_format(
                        $item->filterGigi(Session::get('year'))->tumpatan / 
                        $item->filterGigi(Session::get('year'))->pencabutan * 100, 
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterGigi(Session::get('year'))->kasus}}</td>
            <td>{{$item->filterGigi(Session::get('year'))->rujukan}}</td>
            
            
            <td id="persen{{$item->filterGigi(Session::get('year'))->id}}">{{$item->filterGigi(Session::get('year'))->kasus>0?
                number_format($item->filterGigi(Session::get('year'))->rujukan
                /$item->filterGigi(Session::get('year'))->kasus * 100, 2):0}}</td>
            
        </tr>
          @endif
        @endforeach
        <tr style="font-weight: bold; background: #f0f0f0;">
            <td >Total</td>
            <td ></td>
            <td>{{ $totalTumpatan }}</td>
            <td>{{ $totalPencabutan }}</td>
            <td>{{ $totalKunjungan }}</td>
            <td>{{ $totalPencabutan > 0 ? number_format($totalTumpatan / $totalPencabutan * 100, 2) : 0 }}</td>
            <td>{{ $totalKasus }}</td>
            <td>{{ $totalRujukan }}</td>
            <td>{{ $totalKasus > 0 ? number_format($totalRujukan / $totalKasus * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>