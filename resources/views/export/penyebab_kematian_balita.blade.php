<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KEMATIAN ANAK BALITA MENURUT PENYEBAB UTAMA, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="10">Penyebab Kematian Anak Balita (12-59 Bulan)</th>
    </tr>
    <tr>
        <th>PNEUMONIA</th>
        <th>KELAINAN KONGENITAL</th>
        <th>PENYAKIT SARAF</th>
        <th>DEMAM BERDARAH</th>
        <th>KELAINAN KONGENITAL JANTUNG</th>
        <th>KECELAKAAN LALU LINTAS</th>
        <th>KELAINAN KONGENITAL LAINNYA</th>
        <th>TENGGELAM</th>
        <th>INFEKSI PARASIT</th>
        <th>LAIN-LAIN</th>
    </tr>
    </thead>
    <tbody>
        @php
            $pneumonia = 0;
            $kelainan_kongenital = 0;
            $saraf = 0;
            $dbd = 0;
            $jantung = 0;
            $lakalantas = 0;
            $kongenital_lain = 0;
            $tenggelam = 0;
            $infeksi = 0;
            $lain_lain = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)

        @php
            $pneumonia += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'pneumonia')["total"];
            $kelainan_kongenital += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kelainan_kongenital')["total"];
            $saraf += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'saraf')["total"];
            $dbd += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'dbd')["total"];
            $jantung += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'jantung')["total"];
            $lakalantas += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lakalantas')["total"];
            $kongenital_lain += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kongenital_lain')["total"];
            $tenggelam += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'tenggelam')["total"];
            $infeksi += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'infeksi')["total"];
            $lain_lain += $item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lain_lain')["total"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'pneumonia')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kelainan_kongenital')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'saraf')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'dbd')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'jantung')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lakalantas')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kongenital_lain')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'tenggelam')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'infeksi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lain_lain')["total"]}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$pneumonia}}</td>
            <td>{{$kelainan_kongenital}}</td>
            <td>{{$saraf}}</td>
            <td>{{$dbd}}</td>
            <td>{{$jantung}}</td>
            <td>{{$lakalantas}}</td>
            <td>{{$kongenital_lain}}</td>
            <td>{{$tenggelam}}</td>
            <td>{{$infeksi}}</td>
            <td>{{$lain_lain}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPenyebabKematianBalita(Session::get('year')))
        @php
            $pneumonia = $item->filterPenyebabKematianBalita(Session::get('year'))->pneumonia;
            $kelainan_kongenital = $item->filterPenyebabKematianBalita(Session::get('year'))->kelainan_kongenital;
            $saraf = $item->filterPenyebabKematianBalita(Session::get('year'))->saraf;
            $dbd = $item->filterPenyebabKematianBalita(Session::get('year'))->dbd;
            $jantung = $item->filterPenyebabKematianBalita(Session::get('year'))->jantung;
            $lakalantas = $item->filterPenyebabKematianBalita(Session::get('year'))->lakalantas;
            $kongenital_lain = $item->filterPenyebabKematianBalita(Session::get('year'))->kongenital_lain;
            $tenggelam = $item->filterPenyebabKematianBalita(Session::get('year'))->tenggelam;
            $infeksi = $item->filterPenyebabKematianBalita(Session::get('year'))->infeksi;
            $lain_lain = $item->filterPenyebabKematianBalita(Session::get('year'))->lain_lain;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            @php
            $penyebabKematianBalita = $item->filterPenyebabKematianBalita(Session::get('year'));
        @endphp
        
        <td>{{ $penyebabKematianBalita->pneumonia }}</td>
        <td>{{ $penyebabKematianBalita->kelainan_kongenital }}</td>
        <td>{{ $penyebabKematianBalita->saraf }}</td>
        <td>{{ $penyebabKematianBalita->dbd }}</td>
        <td>{{ $penyebabKematianBalita->jantung }}</td>
        <td>{{ $penyebabKematianBalita->lakalantas }}</td>
        <td>{{ $penyebabKematianBalita->kongenital_lain }}</td>
        <td>{{ $penyebabKematianBalita->tenggelam }}</td>
        <td>{{ $penyebabKematianBalita->infeksi }}</td>
        <td>{{ $penyebabKematianBalita->lain_lain }}</td>
        
            
          </tr>
          @endif
        @endforeach
        <td>TOTAL</td>
        <td></td>
        <td>{{$pneumonia}}</td>
        <td>{{$kelainan_kongenital}}</td>
        <td>{{$saraf}}</td>
        <td>{{$dbd}}</td>
        <td>{{$jantung}}</td>
        <td>{{$lakalantas}}</td>
        <td>{{$kongenital_lain}}</td>
        <td>{{$tenggelam}}</td>
        <td>{{$infeksi}}</td>
        <td>{{$lain_lain}}</td>
        @endrole
    </tbody>
</table>