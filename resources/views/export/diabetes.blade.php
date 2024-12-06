<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PELAYANAN KESEHATAN PENDERITA DIABETES MELITUS (DM) MENURUT KECAMATAN DAN PUSKESMAS</th>
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
            <th rowspan="2">Jumlah Penderita DM</th>
            <th colspan="2">Penderita DM yang mendapatkan pelayanan sesuai standar</th>
        </tr>
    <tr>
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
            <td>{{$item->diabetes_per_desa(Session::get('year'))["jumlah"]}}</td>
            <td>{{$item->diabetes_per_desa(Session::get('year'))["pelayanan"]}}</td>
            <td>{{$item->diabetes_per_desa(Session::get('year'))["jumlah"] >0? number_format($item->diabetes_per_desa(Session::get('year'))["pelayanan"]/$item->diabetes_per_desa(Session::get('year'))["jumlah"] * 100, 2):0  }}</td>
            
            <td><input type="checkbox" name="lock" {{$item->diabetes_lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
          </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$total_diabetes}}</td>
            <td>{{$total_pelayanan_diabetes}}</td>
            <td>{{$total_diabetes >0? number_format($total_pelayanan_diabetes/$total_diabetes * 100, 2):0  }}</td>
            <td></td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterDiabetes(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterDiabetes(Session::get('year'))->jumlah}}</td>
            <td>{{$item->filterDiabetes(Session::get('year'))->pelayanan}}</td>
            <td id="persen{{$item->filterDiabetes(Session::get('year'))->id}}">{{$item->filterDiabetes(Session::get('year'))->jumlah > 0 ? number_format($item->filterDiabetes(Session::get('year'))->pelayanan / $item->filterDiabetes(Session::get('year'))->jumlah * 100, 2): 0}}%</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
           <td>TOTAL</td>
            <td></td>
            <td id="jumlah">{{$total_diabetes}}</td>
            <td id="pelayanan">{{$total_pelayanan_diabetes}}</td>
            <td id="percentage">{{$total_diabetes >0? number_format($total_pelayanan_diabetes/$total_diabetes * 100, 2):0  }}</td>
            <td></td>
        </tr>
        @endrole
    </tbody>
</table>