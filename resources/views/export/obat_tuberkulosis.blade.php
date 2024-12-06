<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>ANGKA KESEMBUHAN DAN PENGOBATAN LENGKAP SERTA KEBERHASILAN PENGOBATAN TUBERKULOSIS MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="3" rowspan="2" style="white-space: nowrap">JUMLAH KASUS TUBERKULOSIS PARU TERKONFIRMASI BAKTERIOLOGIS YANG DITEMUKAN DAN DIOBATI*</th>
        <th colspan="3" rowspan="2" style="white-space: nowrap">JUMLAH SEMUA KASUS TUBERKULOSIS YANG DITEMUKAN DAN DIOBATI</th>
        <th colspan="6" style="white-space: nowrap">ANGKA KESEMBUHAN (CURE RATE) TUBERKULOSIS PARU TERKONFIRMASI BAKTERIOLOGIS</th>
        <th colspan="6" style="white-space: nowrap">ANGKA PENGOBATAN LENGKAP (COMPLETE RATE) SEMUA KASUS TUBERKULOSIS</th>
        <th colspan="6" style="white-space: nowrap">ANGKA KEBERHASILAN PENGOBATAN (SUCCESS RATE/SR) SEMUA KASUS TUBERKULOSIS</th>
        <th colspan="2" rowspan="2" style="white-space: nowrap">JUMLAH KEMATIAN SELAMA PENGOBATAN TUBERKULOSIS</th>
    </tr>
    <tr>
        <th colspan="2">Laki-Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Laki-Laki + Perempuan</th>
        <th colspan="2">Laki-Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Laki-Laki + Perempuan</th>
        <th colspan="2">Laki-Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Laki-Laki + Perempuan</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L + P</th>
        <th>L</th>
        <th>P</th>
        <th>L + P</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
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
    // Initialize total variables
    $totalKonfirmasiL = $totalKonfirmasiP = $totalKonfirmasi = 0;
    $totalDiobatiL = $totalDiobatiP = $totalDiobati = 0;
    $totalKesembuhanL = $totalKesembuhanP = $totalKesembuhan = 0;
    $totalLengkapL = $totalLengkapP = $totalLengkap = 0;
    $totalBerhasilL = $totalBerhasilP = $totalBerhasil = 0;
    $totalKematian = 0;
@endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        // Fetch and sum values
        $konfirmasiL = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"];
        $konfirmasiP = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"];
        $diobatiL = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"];
        $diobatiP = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"];
        $kesembuhanL = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"];
        $kesembuhanP = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"];
        $lengkapL = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"];
        $lengkapP = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"];
        $berhasilL = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"];
        $berhasilP = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"];
        $kematian = $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kematian')["total"];

        // Update totals
        $totalKonfirmasiL += $konfirmasiL;
        $totalKonfirmasiP += $konfirmasiP;
        $totalDiobatiL += $diobatiL;
        $totalDiobatiP += $diobatiP;
        $totalKesembuhanL += $kesembuhanL;
        $totalKesembuhanP += $kesembuhanP;
        $totalLengkapL += $lengkapL;
        $totalLengkapP += $lengkapP;
        $totalBerhasilL += $berhasilL;
        $totalBerhasilP += $berhasilP;
        $totalKematian += $kematian;
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] * 100, 2
                ):0}}</td>
            
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] > 0?
                number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"])
                /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"]) * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] * 100, 2
                ):0}}</td>
            
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"])
                /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] * 100, 2
                ):0}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"]
                /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] * 100, 2
                ):0}}</td>
            
            
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"])
                /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
                ):0}}</td>

            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kematian')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
            number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kematian')["total"]
            /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
            ):0}}</td>
            

            
            
            
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalKonfirmasiL }}</td>
            <td>{{ $totalKonfirmasiP }}</td>
            <td>{{ $totalKonfirmasiL + $totalKonfirmasiP }}</td>
    
            <td>{{ $totalDiobatiL }}</td>
            <td>{{ $totalDiobatiP }}</td>
            <td>{{ $totalDiobatiL + $totalDiobatiP }}</td>
    
            <td>{{ $totalKesembuhanL }}</td>
            <td>{{ $totalKonfirmasiL > 0 ? number_format($totalKesembuhanL / $totalKonfirmasiL * 100, 2) : 0 }}</td>
            <td>{{ $totalKesembuhanP }}</td>
            <td>{{ $totalKonfirmasiP > 0 ? number_format($totalKesembuhanP / $totalKonfirmasiP * 100, 2) : 0 }}</td>
            <td>{{ $totalKesembuhanL + $totalKesembuhanP }}</td>
            <td>{{ ($totalKonfirmasiL + $totalKonfirmasiP) > 0 ? number_format(($totalKesembuhanL + $totalKesembuhanP) / ($totalKonfirmasiL + $totalKonfirmasiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalLengkapL }}</td>
            <td>{{ $totalDiobatiL > 0 ? number_format($totalLengkapL / $totalDiobatiL * 100, 2) : 0 }}</td>
            <td>{{ $totalLengkapP }}</td>
            <td>{{ $totalDiobatiP > 0 ? number_format($totalLengkapP / $totalDiobatiP * 100, 2) : 0 }}</td>
            <td>{{ $totalLengkapL + $totalLengkapP }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format(($totalLengkapL + $totalLengkapP) / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalBerhasilL }}</td>
            <td>{{ $totalDiobatiL > 0 ? number_format($totalBerhasilL / $totalDiobatiL * 100, 2) : 0 }}</td>
            <td>{{ $totalBerhasilP }}</td>
            <td>{{ $totalDiobatiP > 0 ? number_format($totalBerhasilP / $totalDiobatiP * 100, 2) : 0 }}</td>
            <td>{{ $totalBerhasilL + $totalBerhasilP }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format(($totalBerhasilL + $totalBerhasilP) / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalKematian }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format($totalKematian / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterObatTuberkulosis(Session::get('year')))
        @php
        // Fetch and sum values
        $konfirmasiL = $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L;
        $konfirmasiP = $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P;
        $diobatiL = $item->filterObatTuberkulosis(Session::get('year'))->diobati_L;
        $diobatiP = $item->filterObatTuberkulosis(Session::get('year'))->diobati_P;
        $kesembuhanL = $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L;
        $kesembuhanP = $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P;
        $lengkapL = $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L;
        $lengkapP = $item->filterObatTuberkulosis(Session::get('year'))->lengkap_P;
        $berhasilL = $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L;
        $berhasilP = $item->filterObatTuberkulosis(Session::get('year'))->berhasil_P;
        $kematian = $item->filterObatTuberkulosis(Session::get('year'))->kematian;

        // Update totals
        $totalKonfirmasiL += $konfirmasiL;
        $totalKonfirmasiP += $konfirmasiP;
        $totalDiobatiL += $diobatiL;
        $totalDiobatiP += $diobatiP;
        $totalKesembuhanL += $kesembuhanL;
        $totalKesembuhanP += $kesembuhanP;
        $totalLengkapL += $lengkapL;
        $totalLengkapP += $lengkapP;
        $totalBerhasilL += $berhasilL;
        $totalBerhasilP += $berhasilP;
        $totalKematian += $kematian;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L}}</td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P}}</td>
            <td id="konfirmasi{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L}}
            </td>
            
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L}}</td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P}}</td>
            <td id="diobati{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L}}
            </td>
            
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L}}</td>
            <td id="kesembuhan_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L /
                        $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L * 100,
                        2
                    ) : 0}}
            </td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P}}</td>
            <td id="kesembuhan_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P /
                        $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P * 100,
                        2
                    ) : 0}}
            </td>
            <td id="kesembuhan_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P + $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L}}
            </td>
            <td id="persen_kesembuhan_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L > 0 ?
                    number_format(
                        ($item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P + $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L) /
                        ($item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P) * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_L}}</td>
            <td id="lengkap_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L /
                        $item->filterObatTuberkulosis(Session::get('year'))->diobati_L * 100,
                        2
                    ) : 0}}
            </td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_P}}</td>
            <td id="lengkap_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->lengkap_P /
                        $item->filterObatTuberkulosis(Session::get('year'))->diobati_P * 100,
                        2
                    ) : 0}}
            </td>
            <td id="lengkap_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_P + $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L}}
            </td>
            <td id="persen_lengkap_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L > 0 ?
                    number_format(
                        ($item->filterObatTuberkulosis(Session::get('year'))->lengkap_P + $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L) /
                        ($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_L}}</td>
            <td id="berhasil_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L /
                        $item->filterObatTuberkulosis(Session::get('year'))->diobati_L * 100,
                        2
                    ) : 0}}
            </td>
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_P}}</td>
            <td id="berhasil_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P > 0 ?
                    number_format(
                        $item->filterObatTuberkulosis(Session::get('year'))->berhasil_P /
                        $item->filterObatTuberkulosis(Session::get('year'))->diobati_P * 100,
                        2
                    ) : 0}}
            </td>
            <td id="berhasil_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_P + $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L}}
            </td>
            <td id="persen_berhasil_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L > 0 ?
                    number_format(
                        ($item->filterObatTuberkulosis(Session::get('year'))->berhasil_P + $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L) /
                        ($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100,
                        2
                    ) : 0}}
            </td>
            
            <td>{{$item->filterObatTuberkulosis(Session::get('year'))->kematian}}</td>
            
            
            <td id="kematian{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
            number_format($item->filterObatTuberkulosis(Session::get('year'))->kematian
            /($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100, 2):0}}</td>
        </tr>
          @endif
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{ $totalKonfirmasiL }}</td>
            <td>{{ $totalKonfirmasiP }}</td>
            <td>{{ $totalKonfirmasiL + $totalKonfirmasiP }}</td>
    
            <td>{{ $totalDiobatiL }}</td>
            <td>{{ $totalDiobatiP }}</td>
            <td>{{ $totalDiobatiL + $totalDiobatiP }}</td>
    
            <td>{{ $totalKesembuhanL }}</td>
            <td>{{ $totalKonfirmasiL > 0 ? number_format($totalKesembuhanL / $totalKonfirmasiL * 100, 2) : 0 }}</td>
            <td>{{ $totalKesembuhanP }}</td>
            <td>{{ $totalKonfirmasiP > 0 ? number_format($totalKesembuhanP / $totalKonfirmasiP * 100, 2) : 0 }}</td>
            <td>{{ $totalKesembuhanL + $totalKesembuhanP }}</td>
            <td>{{ ($totalKonfirmasiL + $totalKonfirmasiP) > 0 ? number_format(($totalKesembuhanL + $totalKesembuhanP) / ($totalKonfirmasiL + $totalKonfirmasiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalLengkapL }}</td>
            <td>{{ $totalDiobatiL > 0 ? number_format($totalLengkapL / $totalDiobatiL * 100, 2) : 0 }}</td>
            <td>{{ $totalLengkapP }}</td>
            <td>{{ $totalDiobatiP > 0 ? number_format($totalLengkapP / $totalDiobatiP * 100, 2) : 0 }}</td>
            <td>{{ $totalLengkapL + $totalLengkapP }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format(($totalLengkapL + $totalLengkapP) / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalBerhasilL }}</td>
            <td>{{ $totalDiobatiL > 0 ? number_format($totalBerhasilL / $totalDiobatiL * 100, 2) : 0 }}</td>
            <td>{{ $totalBerhasilP }}</td>
            <td>{{ $totalDiobatiP > 0 ? number_format($totalBerhasilP / $totalDiobatiP * 100, 2) : 0 }}</td>
            <td>{{ $totalBerhasilL + $totalBerhasilP }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format(($totalBerhasilL + $totalBerhasilP) / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
    
            <td>{{ $totalKematian }}</td>
            <td>{{ ($totalDiobatiL + $totalDiobatiP) > 0 ? number_format($totalKematian / ($totalDiobatiL + $totalDiobatiP) * 100, 2) : 0 }}</td>
        </tr>
        @endrole
    </tbody>
</table>