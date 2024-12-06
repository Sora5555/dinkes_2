<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>STATUS GIZI BALITA BERDASARKAN INDEKS BB/U, TB/U, DAN BB/TB MENURUT KECAMATAN DAN PUSKESMAS</th>
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
        <th rowspan="2">Jumlah Balita Yang Ditimbang</th>
        <th colspan="2">Balita Berat Badan Kurang (BB/U)</th>
        <th rowspan="2">Jumlah Balita Yang Diukur Tinggi Badan</th>
        <th colspan="2">Balita Pendek (TB/U)</th>
        <th rowspan="2">Jumlah Balita Yang Diukur Tinggi Badan</th>
        <th colspan="2">Balita Kurang Gizi (BB/TB: < -2 s.d -3 SD)</th>
        <th colspan="2">Balita Gizi Buruk(BB/TB: < -3 SD)</th>
    </tr>
    <tr>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
$totalJumlahTimbang = 0;
$totalBbKurang = 0;

$totalJumlahTinggi = 0;
$totalTbKurang = 0;

$totalJumlahGizi = 0;
$totalGiziKurang = 0;
$totalGiziBuruk = 0;
@endphp

        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
// Fetch data for the current row
$jumlahTimbang = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_timbang')["total"];
$bbKurang = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'bb_kurang')["total"];

$jumlahTinggi = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_tinggi')["total"];
$tbKurang = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'tb_kurang')["total"];

$jumlahGizi = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"];
$giziKurang = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_kurang')["total"];
$giziBuruk = $item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_buruk')["total"];

// Accumulate totals
$totalJumlahTimbang += $jumlahTimbang;
$totalBbKurang += $bbKurang;

$totalJumlahTinggi += $jumlahTinggi;
$totalTbKurang += $tbKurang;

$totalJumlahGizi += $jumlahGizi;
$totalGiziKurang += $giziKurang;
$totalGiziBuruk += $giziBuruk;
@endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td> 
            <td class="unit_kerja">{{$item->nama}}</td> 
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_timbang')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'bb_kurang')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_timbang')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'bb_kurang')["total"]
            /$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_timbang')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_tinggi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'tb_kurang')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_tinggi')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'tb_kurang')["total"]
            /$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_tinggi')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_kurang')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_kurang')["total"]
            /$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"] * 100, 2
            ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_buruk')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'gizi_buruk')["total"]
            /$item->unitKerjaAmbil('filterStatusGizi', Session::get('year'), 'jumlah_gizi')["total"] * 100, 2
            ):0}}</td>
            
            
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahTimbang }}</td>
            <td>{{ $totalBbKurang }}</td>
            <td>{{ $totalJumlahTimbang > 0 ? number_format($totalBbKurang / $totalJumlahTimbang * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahTinggi }}</td>
            <td>{{ $totalTbKurang }}</td>
            <td>{{ $totalJumlahTinggi > 0 ? number_format($totalTbKurang / $totalJumlahTinggi * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahGizi }}</td>
            <td>{{ $totalGiziKurang }}</td>
            <td>{{ $totalJumlahGizi > 0 ? number_format($totalGiziKurang / $totalJumlahGizi * 100, 2) : 0 }}</td>
            <td>{{ $totalGiziBuruk }}</td>
            <td>{{ $totalJumlahGizi > 0 ? number_format($totalGiziBuruk / $totalJumlahGizi * 100, 2) : 0 }}</td>
        </tr>
        
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterStatusGizi(Session::get('year')))
        @php
        // Fetch data for the current row
        $jumlahTimbang = $item->filterStatusGizi(Session::get('year'))->jumlah_timbang;
        $bbKurang = $item->filterStatusGizi(Session::get('year'))->bb_kurang;
        
        $jumlahTinggi = $item->filterStatusGizi(Session::get('year'))->jumlah_tinggi;
        $tbKurang = $item->filterStatusGizi(Session::get('year'))->tb_kurang;
        
        $jumlahGizi = $item->filterStatusGizi(Session::get('year'))->jumlah_gizi;
        $giziKurang = $item->filterStatusGizi(Session::get('year'))->gizi_kurang;
        $giziBuruk = $item->filterStatusGizi(Session::get('year'))->gizi_buruk;
        
        // Accumulate totals
        $totalJumlahTimbang += $jumlahTimbang;
        $totalBbKurang += $bbKurang;
        
        $totalJumlahTinggi += $jumlahTinggi;
        $totalTbKurang += $tbKurang;
        
        $totalJumlahGizi += $jumlahGizi;
        $totalGiziKurang += $giziKurang;
        $totalGiziBuruk += $giziBuruk;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterStatusGizi(Session::get('year'))->jumlah_timbang}}</td>
            <td>{{$item->filterStatusGizi(Session::get('year'))->bb_kurang}}</td>
            
            <td id="timbang{{$item->filterStatusGizi(Session::get('year'))->id}}">
                {{$item->filterStatusGizi(Session::get('year'))->jumlah_timbang > 0 ?
                    number_format(
                        $item->filterStatusGizi(Session::get('year'))->bb_kurang / 
                        $item->filterStatusGizi(Session::get('year'))->jumlah_timbang * 100, 
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterStatusGizi(Session::get('year'))->jumlah_tinggi}}</td>
            <td>{{$item->filterStatusGizi(Session::get('year'))->tb_kurang}}</td>
            
            <td id="tinggi{{$item->filterStatusGizi(Session::get('year'))->id}}">
                {{$item->filterStatusGizi(Session::get('year'))->jumlah_tinggi > 0 ?
                    number_format(
                        $item->filterStatusGizi(Session::get('year'))->tb_kurang / 
                        $item->filterStatusGizi(Session::get('year'))->jumlah_tinggi * 100, 
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterStatusGizi(Session::get('year'))->jumlah_gizi}}</td>
            <td>{{$item->filterStatusGizi(Session::get('year'))->tb_kurang}}</td>
            
            <td id="gizi{{$item->filterStatusGizi(Session::get('year'))->id}}">
                {{$item->filterStatusGizi(Session::get('year'))->jumlah_gizi > 0 ?
                    number_format(
                        $item->filterStatusGizi(Session::get('year'))->gizi_kurang / 
                        $item->filterStatusGizi(Session::get('year'))->jumlah_gizi * 100, 
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterStatusGizi(Session::get('year'))->gizi_buruk}}</td>
            
            
            <td id="gizi_buruk{{$item->filterStatusGizi(Session::get('year'))->id}}">{{$item->filterStatusGizi(Session::get('year'))->jumlah_gizi>0?
                number_format($item->filterStatusGizi(Session::get('year'))->gizi_buruk
                /$item->filterStatusGizi(Session::get('year'))->jumlah_gizi * 100, 2):0}}</td>
            
            
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalJumlahTimbang }}</td>
            <td>{{ $totalBbKurang }}</td>
            <td>{{ $totalJumlahTimbang > 0 ? number_format($totalBbKurang / $totalJumlahTimbang * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahTinggi }}</td>
            <td>{{ $totalTbKurang }}</td>
            <td>{{ $totalJumlahTinggi > 0 ? number_format($totalTbKurang / $totalJumlahTinggi * 100, 2) : 0 }}</td>
            <td>{{ $totalJumlahGizi }}</td>
            <td>{{ $totalGiziKurang }}</td>
            <td>{{ $totalJumlahGizi > 0 ? number_format($totalGiziKurang / $totalJumlahGizi * 100, 2) : 0 }}</td>
            <td>{{ $totalGiziBuruk }}</td>
            <td>{{ $totalJumlahGizi > 0 ? number_format($totalGiziBuruk / $totalJumlahGizi * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>