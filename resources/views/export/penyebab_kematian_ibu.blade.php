<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KEMATIAN IBU MENURUT PENYEBAB, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="10">Kematian Ibu</th>
    </tr>
    <tr>
        <th>Perdarahan</th>
        <th>Gangguan Hipertensi</th>
        <th>Infeksi</th>
        <th>Kelainan Jantung dan Pembuluh darah</th>
        <th>Gangguan Autoimun</th>
        <th>Gangguan Cerebrovaskular</th>
        <th>Covid-19</th>
        <th>KOMPLIKASI PASCA KEGUGURAN (ABORTUS)</th>
        <th>Lain-lain</th>
        <th>Jumlah Kematian Ibu</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["perdarahan"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_hipertensi"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["infeksi"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["kelainan_jantung"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_autoimun"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_cerebro"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["covid_19"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["abortus"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["lain_lain"]}}</td>
            <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["lain_lain"]
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["abortus"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["covid_19"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_cerebro"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_autoimun"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["kelainan_jantung"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["infeksi"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_hipertensi"] 
             + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["perdarahan"] 
                }}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
                <td></td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'perdarahan')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_hipertensi')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'infeksi')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'kelainan_jantung')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_autoimun')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_cerebro')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'covid_19')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'abortus')}}</td>
                <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'lain_lain')}}</td>
                <td>{{
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'lain_lain') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'abortus') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'covid_19') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_cerebro') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_autoimun') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'kelainan_jantung') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'infeksi') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_hipertensi') + 
                \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterPenyebabKematianIbu', 'perdarahan')
              
                }}</td>
                
            </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPenyebabKematianIbu(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->nama}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->perdarahan }}</td>

            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_hipertensi }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->infeksi }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->kelainan_jantung }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_autoimun }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_cerebro }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->covid_19 }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->abortus }}</td>
            
            <td>{{ $item->filterPenyebabKematianIbu(Session::get('year'))->lain_lain }}</td>
            
            
            
            <td id="total{{$item->filterKematianIbu(Session::get('year'))->id}}">{{
            $item->filterPenyebabKematianIbu(Session::get('year'))->perdarahan 
            + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_hipertensi 
            + $item->filterPenyebabKematianIbu(Session::get('year'))->infeksi
            + $item->filterPenyebabKematianIbu(Session::get('year'))->kelainan_jantung
            + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_autoimun
            + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_cerebro
            + $item->filterPenyebabKematianIbu(Session::get('year'))->covid_19
            + $item->filterPenyebabKematianIbu(Session::get('year'))->abortus
            + $item->filterPenyebabKematianIbu(Session::get('year'))->lain_lain
            }}</td>

          </tr>
          @endif
        @endforeach
        <tr>
            @php
                $total = Auth::user()->unit_kerja;
            @endphp
            <td>TOTAL</td>
                <td></td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'perdarahan')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_hipertensi')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'infeksi')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'kelainan_jantung')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_autoimun')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_cerebro')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'covid_19')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'abortus')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'lain_lain')}}</td>
                <td>{{
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'lain_lain') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'abortus') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'covid_19') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_cerebro') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_autoimun') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'kelainan_jantung') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'infeksi') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'gangguan_hipertensi') +
                $total->admin_total(Session::get('year'), 'filterPenyebabKematianIbu', 'perdarahan')
                }}</td>
        </tr>
        @endrole
    </tbody>
</table>