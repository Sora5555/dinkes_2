<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH TERDUGA TUBERKULOSIS, KASUS TUBERKULOSIS, KASUS TUBERKULOSIS ANAK, 									
                DAN TREATMENT COVERAGE  (TC) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
        <tr>
            <th rowspan="3">Kecamatan</th>
            @role('Admin|superadmin')
            <th rowspan="3">Puskesmas</th>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            <th rowspan="3">Desa</th>
            @endrole
            <th rowspan="3">Jumlah Terduga Tuberkulosis</th>
            <th colspan="5">Jumlah Semua Kasus Tuberkulosis</th>
            <th rowspan="3">Kasus Tuberkulosis anak 0-14 tahun</th>
        </tr>
    <tr>
        <th style="white-space:nowrap" colspan="2">Laki Laki</th>
        <th colspan="2">Perempuan</th>
        <th rowspan="2">Laki Laki + Perempuan</th>
        
        
    </tr>
    <tr>
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
            <td class="unit_kerja">{{$item->kecamatan}}</td>
            <td>{{$item->nama}}</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["terduga_kasus"]}}</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_L"]}}</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_LP"] > 0?number_format($item->tuberkulosis_per_desa(Session::get('year'))["kasus_L"]/$item->tuberkulosis_per_desa(Session::get('year'))["kasus_LP"]*100, 2):0}}%</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_P"]}}</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_LP"] > 0?number_format($item->tuberkulosis_per_desa(Session::get('year'))["kasus_P"]/$item->tuberkulosis_per_desa(Session::get('year'))["kasus_LP"]*100, 2):0}}%</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_LP"]}}</td>
            <td>{{$item->tuberkulosis_per_desa(Session::get('year'))["kasus_anak"]}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$total_terduga_kasus}}</td>
            <td>{{$total_kasus_L}}</td>
            <td>{{$total_kasus_LP > 0?number_format($total_kasus_L/$total_kasus_LP*100, 2):0}}%</td>
            <td>{{$total_kasus_P}}</td>
            <td>{{$total_kasus_LP > 0?number_format($total_kasus_P/$total_kasus_LP*100, 2):0}}%</td>
            <td>{{$total_kasus_LP}}</td>
            <td>{{$total_kasus_anak}}</td>
            <td></td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterTuberkulosis(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->nama}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterTuberkulosis(Session::get('year'))->terduga_kasus}}</td>
            <td>{{$item->filterTuberkulosis(Session::get('year'))->kasus_L}}</td>
            <td id="kasus_L{{$item->filterTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterTuberkulosis(Session::get('year'))->kasus_LP > 0 ? number_format($item->filterTuberkulosis(Session::get('year'))->kasus_L / $item->filterTuberkulosis(Session::get('year'))->kasus_LP * 100, 2) : 0}}%
            </td>
            
            <td>{{$item->filterTuberkulosis(Session::get('year'))->kasus_P}}</td>
            <td id="kasus_P{{$item->filterTuberkulosis(Session::get('year'))->id}}">
                {{$item->filterTuberkulosis(Session::get('year'))->kasus_LP > 0 ? number_format($item->filterTuberkulosis(Session::get('year'))->kasus_P / $item->filterTuberkulosis(Session::get('year'))->kasus_LP * 100, 2) : 0}}%
            </td>
            
            <td>{{$item->filterTuberkulosis(Session::get('year'))->kasus_LP}}</td>
            <td>{{$item->filterTuberkulosis(Session::get('year'))->kasus_anak}}</td>
            

          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td id="terduga_kasus">{{$total_terduga_kasus}}</td>
            <td id="kasus_L">{{$total_kasus_L}}</td>
            <td id="percentage_kasus_L">{{$total_kasus_LP > 0?number_format($total_kasus_L/$total_kasus_LP*100, 2):0}}%</td>
            <td id="kasus_P">{{$total_kasus_P}}</td>
            <td id="percentage_kasus_P">{{$total_kasus_LP > 0?number_format($total_kasus_P/$total_kasus_LP*100, 2):0}}%</td>
            <td id="kasus_LP">{{$total_kasus_LP}}</td>
            <td id="kasus_anak">{{$total_kasus_anak}}</td>
            <td></td>
        </tr>
        @endrole
    </tbody>
</table>