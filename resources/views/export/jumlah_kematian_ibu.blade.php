<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KEMATIAN IBU MENURUT KECAMATAN DAN PUSKESMAS</th>
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
        <th rowspan="2">Jumlah Lahir Hidup</th>
        <th colspan="4">Kematian Ibu</th>
    </tr>
    <tr>
        <th>Jumlah kematian Ibu Hamil</th>
        <th>Jumlah Kematian Ibu Bersalin</th>
        <th>Jumlah Kematian Ibu Nifas</th>
        <th>Jumlah Kematian Ibu</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
            <td>{{$item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_hamil"]}}</td>
            <td>{{$item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_bersalin"]}}</td>
            <td>{{$item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_nifas"]}}</td>
            <td>{{$item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_nifas"] + $item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_bersalin"] + $item->kematian_ibu_per_desa(Session::get('year'))["jumlah_kematian_ibu_hamil"]}}</td>
        </tr>
        @endforeach
        <tr>
        <td>TOTAL</td>
            <td></td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') + \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_hamil')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_bersalin')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_nifas')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_nifas') + 
            \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_hamil') + 
            \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_bersalin')
            }}</td>
            
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterKematianIbu(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{ $item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P }}</td>

            <td>{{ $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_hamil }}</td>
            <td>{{ $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_bersalin }}</td>
            <td>{{ $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_nifas }}</td>
            
            <td id="total{{ $item->filterKematianIbu(Session::get('year'))->id }}">
                {{ $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_hamil +
                   $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_bersalin +
                   $item->filterKematianIbu(Session::get('year'))->jumlah_kematian_ibu_nifas }}
            </td>

          </tr>
          @endif
        @endforeach
        <tr>
            @php
                $total = Auth::user()->unit_kerja;
            @endphp
            <td>TOTAL</td>
                <td></td>
                <td>{{$total->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') + $total->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_hamil')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_bersalin')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_nifas')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_nifas') + $total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_bersalin') + $total->admin_total(Session::get('year'), 'filterKematianIbu', 'jumlah_kematian_ibu_hamil')}}</td>
        </tr>
        @endrole
    </tbody>
</table>