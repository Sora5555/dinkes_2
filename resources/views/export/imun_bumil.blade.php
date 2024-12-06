<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN IMUNISASI Td PADA IBU HAMIL MENURUT KECAMATAN DAN PUSKESMAS</th>
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
        <th rowspan="3">Jumlah Ibu Hamil</th>
        <th colspan="12">IMUNISASI Td PADA IBU HAMIL</th>
    </tr>
    <tr>
        <th colspan="2">Td1</th>
        <th colspan="2">Td2</th>
        <th colspan="2">Td3</th>
        <th colspan="2">Td4</th>
        <th colspan="2">Td5</th>
        <th colspan="2">Td2+</th>
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
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td1"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td1"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td2"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td2"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td3"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td3"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td4"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td4"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td5"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td5"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td2_plus"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td2_plus"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
        </tr>
        @endforeach
        <tr>
        <td>TOTAL</td>
        <td></td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td1')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td1') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td2')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td2') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td3')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td3') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td4')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td4') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td5')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td5') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td2_plus')}}</td>
        <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                number_format((\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'td2_plus') / \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100, 2):0
            }}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterDesa(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil}}</td>
            
            <td><input type="number" name="td1" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td1}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td1{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td1/($item->filterDesa(Session::get('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
            
            <td><input type="number" name="td2" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td2}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td2{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td2/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
            
            <td><input type="number" name="td3" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td3}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td3{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td3/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
            
            <td><input type="number" name="td4" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td4}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td4{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td4/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
            
            <td><input type="number" name="td5" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td5}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td5{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td5/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
            
            <td><input type="number" name="td2_plus" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td2_plus}}" class="form-control data-input" style="border: none"></td>
            
            <td id="td2_plus{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td2_plus/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 10, '2'):0}}%</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
            @php
                $total = Auth::user()->unit_kerja;
            @endphp
            <td>TOTAL</td>
                <td></td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td1')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td1')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td2')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td2')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td3')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td3')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td4')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td4')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td5')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td5')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'td2_plus')}}</td>
                <td>{{$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil') > 0?
                    number_format(($total->admin_total(Session::get('year'), 'filterDesa', 'td2_plus')/$total->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil')) * 100,2):0
                    }}%</td>
        </tr>
        @endrole
    </tbody>
</table>