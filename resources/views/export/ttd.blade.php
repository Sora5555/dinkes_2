<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH IBU HAMIL YANG MENDAPATKAN DAN MENGONSUMSI TABLET TAMBAH DARAH (TTD) MENURUT KECAMATAN DAN PUSKESMAS</th>
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
        <th rowspan="2">Jumlah Ibu Hamil</th>
        <th colspan="4">TTD (90 Tablet)</th>
    </tr>
    <tr>
        <th>Ibu Hamil Yang Mendapatkan</th>
        <th>%</th>
        <th>Ibu Hamil Yang mengonsumsi</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
        $jumlah_ibu_hamil = 0;
        $dapat_ttd = 0;
        $konsumsi_ttd = 0;
    @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $jumlah_ibu_hamil += $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"];
            $dapat_ttd += $item->ibu_hamil_per_desa(Session::get('year'))["dapat_ttd"];
            $konsumsi_ttd += $item->ibu_hamil_per_desa(Session::get('year'))["konsumsi_ttd"];
        @endphp
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["dapat_ttd"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["dapat_ttd"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["konsumsi_ttd"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["konsumsi_ttd"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0 }}</td>
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td></td>
            <td>{{$jumlah_ibu_hamil}}</td>
            <td>{{$dapat_ttd}}</td>
            <td>{{$jumlah_ibu_hamil > 0?number_format(($dapat_ttd/$jumlah_ibu_hamil) * 100, 2):0}}</td>
            <td>{{$konsumsi_ttd}}</td>
            <td>{{$jumlah_ibu_hamil > 0?number_format(($konsumsi_ttd/$jumlah_ibu_hamil) * 100, 2):0}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterDesa(Session::get('year')))
        @php
        $jumlah_ibu_hamil += $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
        $dapat_ttd += $item->filterDesa(Session::get('year'))->dapat_ttd;
        $konsumsi_ttd += $item->filterDesa(Session::get('year'))->konsumsi_ttd;
         @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil}}</td>
            
            <td>{{ $item->filterDesa(Session::get('year'))->dapat_ttd }}</td>
            <td id="dapat_ttd{{ $item->filterDesa(Session::get('year'))->id }}">
                {{ $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 
                    ? number_format($item->filterDesa(Session::get('year'))->dapat_ttd / $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil * 100, 2) 
                    : 0 }}
            </td>
            <td>{{ $item->filterDesa(Session::get('year'))->konsumsi_ttd }}</td>
            <td id="konsumsi_ttd{{ $item->filterDesa(Session::get('year'))->id }}">
                {{ $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 
                    ? number_format($item->filterDesa(Session::get('year'))->konsumsi_ttd / $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil * 100, 2) 
                    : 0 }}
            </td>
            
          </tr>
          @endif
        @endforeach
        <td>Total</td>
        <td></td>
        <td>{{$jumlah_ibu_hamil}}</td>
        <td>{{$dapat_ttd}}</td>
        <td>{{$jumlah_ibu_hamil > 0?number_format(($dapat_ttd/$jumlah_ibu_hamil) * 100, 2):0}}</td>
        <td>{{$konsumsi_ttd}}</td>
        <td>{{$jumlah_ibu_hamil > 0?number_format(($konsumsi_ttd/$jumlah_ibu_hamil) * 100, 2):0}}</td>
        @endrole
    </tbody>
</table>