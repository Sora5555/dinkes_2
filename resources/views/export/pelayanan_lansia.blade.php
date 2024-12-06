<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PELAYANAN KESEHATAN USIA LANJUT  MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
        <tr>
            <th rowspan="4">Kecamatan</th>
            @role('Admin|superadmin')
            <th rowspan="4">Puskesmas</th>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            <th rowspan="4">Desa</th>
            @endrole
            <th colspan="9">Penduduk Usia 60+ tahun</th>
        </tr>
    <tr>
        <th colspan="3">Jumlah</th>
        <th colspan="6">Mendapat Pelayanan Kesehatan Skrining sesuai standar</th>
    </tr>
    <tr>
        <th style="white-space:nowrap" rowspan="2">Laki Laki</th>
        <th rowspan="2">Perempuan</th>
        <th rowspan="2">Laki Laki + Perempuan</th>
        
        <th style="white-space:nowrap" colspan="2">Laki Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Laki Laki + Perempuan</th>
        
    </tr>
    <tr>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"]}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"]}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] +  $item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"]}}</td>
            
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_L"]}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_L'] / $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_L'] * 100, 2): 0}}%</td>
            
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_P"]}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"] > 0?number_format($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_P'] / $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_P'] * 100, 2): 0}}%</td>
            
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_P"] + $item->pelayanan_lansia_per_desa(Session::get('year'))["standar_L"]}}</td>
            <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"] + $item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format(($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_P'] + $item->pelayanan_lansia_per_desa(Session::get('year'))['standar_L']) / ($item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_P'] + $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_L']) * 100, 2): 0}}%</td>
          </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$total_L}}</td>
            <td>{{$total_P}}</td>
            <td>{{$total_L +  $total_P}}</td>
            
            <td>{{$totalstandar_L}}</td>
            <td>{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
            
            <td>{{$totalstandar_P}}</td>
            <td>{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
            
            <td>{{$totalstandar_P + $totalstandar_L}}</td>
            <td>{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPelayananLansia(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L}}</td>
            <td>{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P}}</td>
            <td id="jumlah_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L + $item->filterPelayananLansia(Session::get('year'))->jumlah_P}}</td>
            
            <td>{{$item->filterPelayananLansia(Session::get('year'))->standar_L}}</td>
            <td id="standar_L{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L > 0 ? number_format($item->filterPelayananLansia(Session::get('year'))->standar_L / $item->filterPelayananLansia(Session::get('year'))->jumlah_L * 100, 2) : 0}}%</td>
            
            <td>{{$item->filterPelayananLansia(Session::get('year'))->standar_P}}</td>
            <td id="standar_P{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P > 0 ? number_format($item->filterPelayananLansia(Session::get('year'))->standar_P / $item->filterPelayananLansia(Session::get('year'))->jumlah_P * 100, 2) : 0}}%</td>
            
            <td id="standar_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->standar_P + $item->filterPelayananLansia(Session::get('year'))->standar_L}}</td>
            <td id="persen_standar_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P + $item->filterPelayananLansia(Session::get('year'))->jumlah_L > 0 ? number_format(($item->filterPelayananLansia(Session::get('year'))->standar_P + $item->filterPelayananLansia(Session::get('year'))->standar_L) / ($item->filterPelayananLansia(Session::get('year'))->jumlah_P + $item->filterPelayananLansia(Session::get('year'))->jumlah_L) * 100, 2) : 0}}%</td>
            
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td id="jumlah_L">{{$total_L}}</td>
            <td id="jumlah_P">{{$total_P}}</td>
            <td id="total_LP">{{$total_L +  $total_P}}</td>
            
            <td id="standar_L">{{$totalstandar_L}}</td>
            <td id="percentage_standar_L">{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
            
            <td id="standar_P">{{$totalstandar_P}}</td>
            <td id="percentage_standar_P">{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
            
            <td id="totalstandar_LP">{{$totalstandar_P + $totalstandar_L}}</td>
            <td id="percentage_totalstandar_LP">{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
        </tr>
        @endrole
    </tbody>
</table>