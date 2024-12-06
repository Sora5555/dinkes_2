<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PRESENTASE ODHIV BARU MENDAPATKAN PENGOBATAN MENURUT KECAMATAN DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th>Kecamatan</th>
        @role('Admin|superadmin')
        <th>Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th>Desa</th>
        @endrole
        <th style="white-space: nowrap">ODHIV Baru Ditemukan</th>
        <th style="white-space: nowrap">ODHIV Baru Ditemukan dan Mendapatkan Pengobatan ARV</th>
        <th style="white-space: nowrap">Persentase ODHIV Baru Mendapat Pengobatan ARV</th>
    </tr>
    </thead>
    <tbody>
        @php
    // Initialize totals
    $totalBaru = 0;
    $totalArv = 0;
@endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        // Retrieve values
        $baru = $item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'baru')["total"];
        $arv = $item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'arv')["total"];
        $percentage = $arv > 0 ? number_format($baru / $arv * 100, 2) : 0;

        // Add to totals
        $totalBaru += $baru;
        $totalArv += $arv;
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'baru')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'arv')["total"]}}</td>

            <td>{{$item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'arv')["total"] > 0?
                number_format($item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'baru')["total"]
                /$item->unitKerjaAmbil('filterOdhiv', Session::get('year'), 'arv')["total"] * 100, 2
                ):0}}</td>
            
            
        </tr>
        @endforeach
        @php
    // Calculate total percentage
    $totalPercentage = $totalArv > 0 ? number_format($totalBaru / $totalArv * 100, 2) : 0;
@endphp
<tr style="font-weight: bold; background: #f0f0f0;">
    <td>Total</td>
    <td></td>
    <td>{{ $totalBaru }}</td>
    <td>{{ $totalArv }}</td>
    <td>{{ $totalPercentage }}</td>
</tr>

        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterOdhiv(Session::get('year')))
        @php
        // Retrieve values
        $baru = $item->filterOdhiv(Session::get('year'))->baru;
        $arv = $item->filterOdhiv(Session::get('year'))->arv;
        $percentage = $arv > 0 ? number_format($baru / $arv * 100, 2) : 0;

        // Add to totals
        $totalBaru += $baru;
        $totalArv += $arv;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterOdhiv(Session::get('year'))->baru}}</td>
            <td>{{$item->filterOdhiv(Session::get('year'))->arv}}</td>
            
            <td id="persen{{$item->filterOdhiv(Session::get('year'))->id}}">{{$item->filterOdhiv(Session::get('year'))->arv>0?
                number_format($item->filterOdhiv(Session::get('year'))->baru
                /$item->filterOdhiv(Session::get('year'))->arv * 100, 2):0}}</td>
            
        </tr>
          @endif
        @endforeach
        @php
    // Calculate total percentage
    $totalPercentage = $totalArv > 0 ? number_format($totalBaru / $totalArv * 100, 2) : 0;
@endphp
<tr style="font-weight: bold; background: #f0f0f0;">
    <td >Total</td>
    <td ></td>
    <td>{{ $totalBaru }}</td>
    <td>{{ $totalArv }}</td>
    <td>{{ $totalPercentage }}</td>
</tr>
        @endrole
    </tbody>
</table>