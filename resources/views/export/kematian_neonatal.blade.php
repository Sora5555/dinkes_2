<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KEMATIAN NEONATAL, POST NEONATAL, BAYI, DAN BALITA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="4">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="4">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="4">Desa</th>
        @endrole
        <th colspan="15">Jumlah Kematian</th>
    </tr>
    <tr>
        <th colspan="5">Laki Laki</th>
        <th colspan="5">Perempuan</th>
        <th colspan="5">Laki Laki + Perempuan</th>
    </tr>
    <tr>
        <th rowspan="2">Neonatal</th>
        <th rowspan="2">Post Neonatal</th>
        <th colspan="3">Balita</th>
        <th rowspan="2">Neonatal</th>
        <th rowspan="2">Post Neonatal</th>
        <th colspan="3">Balita</th>
        <th rowspan="2">Neonatal</th>
        <th rowspan="2">Post Neonatal</th>
        <th colspan="3">Balita</th>
    </tr>
    <tr>
        <th>Bayi</th>
        <th style="white-space: nowrap">Anak Balita</th>
        <th>Jumlah Total</th>
        <th>Bayi</th>
        <th style="white-space: nowrap">Anak Balita</th>
        <th>Jumlah Total</th>
        <th>Bayi</th>
        <th style="white-space: nowrap">Anak Balita</th>
        <th>Jumlah Total</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
            
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] }}</td>
            <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            
            <td id="neo_L">{{$neo_L}}</td>
            <td id="post_neo_L">{{$post_neo_L}}</td>
            <td id="bayi_L">{{$neo_L + $post_neo_L}}</td>
            <td id="balita_L">{{$balita_L}}</td>
            <td id="total_L">{{$neo_L + $post_neo_L + $balita_L}}</td>
            
            <td id="neo_P">{{$neo_P}}</td>
            <td id="post_neo_P">{{$post_neo_P}}</td>
            <td id="bayi_P">{{$neo_P + $post_neo_P}}</td>
            <td id="balita_P">{{$balita_P}}</td>
            <td id="total_P">{{$neo_P + $post_neo_P + $balita_P}}</td>

            <td id="sum_neo_LP">{{$neo_L + $neo_P}}</td>
            <td id="sum_post_neo_LP">{{$post_neo_L + $post_neo_P}}</td>
            <td id="sum_bayi_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P}}</td>
            <td id="sum_balita_LP">{{$balita_L + $balita_P}}</td>
            <td id="sum_total_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P + $balita_L + $balita_P}}</td>
            
            <td></td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPenyebabKematianIbu(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
           
            
            @php
            $kematianNeonatal = $item->filterKematianNeonatal(Session::get('year'));
        @endphp
        
        <td>{{ $kematianNeonatal->neo_L }}</td>
        <td>{{ $kematianNeonatal->post_neo_L }}</td>
        <td id="bayi_L{{ $kematianNeonatal->id }}">
            {{ $kematianNeonatal->neo_L + $kematianNeonatal->post_neo_L }}
        </td>
        <td>{{ $kematianNeonatal->balita_L }}</td>
        <td id="total_L{{ $kematianNeonatal->id }}">
            {{ $kematianNeonatal->neo_L + $kematianNeonatal->post_neo_L + $kematianNeonatal->balita_L }}
        </td>
        <td>{{ $kematianNeonatal->neo_P }}</td>
        <td>{{ $kematianNeonatal->post_neo_P }}</td>
        <td id="bayi_P{{ $kematianNeonatal->id }}">
            {{ $kematianNeonatal->neo_P + $kematianNeonatal->post_neo_P }}
        </td>
        <td>{{ $kematianNeonatal->balita_P }}</td>
        

            <td id="total_P{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->neo_P + $item->filterKematianNeonatal(Session::get('year'))->post_neo_P + $item->filterKematianNeonatal(Session::get('year'))->balita_P}}</td>
            
            <td id="neo_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->neo_P + $item->filterKematianNeonatal(Session::get('year'))->neo_L}}</td>
            
            <td id="post_neo_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->post_neo_P + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L}}</td>
            
            <td id="bayi_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                $item->filterKematianNeonatal(Session::get('year'))->post_neo_P 
                + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                + $item->filterKematianNeonatal(Session::get('year'))->neo_P
                + $item->filterKematianNeonatal(Session::get('year'))->neo_L
                
                }}</td>
            
            <td id="balita_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                $item->filterKematianNeonatal(Session::get('year'))->balita_P 
                + $item->filterKematianNeonatal(Session::get('year'))->balita_L
                
                }}</td>
            
            <td id="total_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                $item->filterKematianNeonatal(Session::get('year'))->balita_P 
                + $item->filterKematianNeonatal(Session::get('year'))->balita_L
                + $item->filterKematianNeonatal(Session::get('year'))->post_neo_P 
                + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                + $item->filterKematianNeonatal(Session::get('year'))->neo_P 
                + $item->filterKematianNeonatal(Session::get('year'))->neo_L
                
                }}</td>
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            
            <td id="neo_L">{{$neo_L}}</td>
            <td id="post_neo_L">{{$post_neo_L}}</td>
            <td id="bayi_L">{{$neo_L + $post_neo_L}}</td>
            <td id="balita_L">{{$balita_L}}</td>
            <td id="total_L">{{$neo_L + $post_neo_L + $balita_L}}</td>
            
            <td id="neo_P">{{$neo_P}}</td>
            <td id="post_neo_P">{{$post_neo_P}}</td>
            <td id="bayi_P">{{$neo_P + $post_neo_P}}</td>
            <td id="balita_P">{{$balita_P}}</td>
            <td id="total_P">{{$neo_P + $post_neo_P + $balita_P}}</td>

            <td id="sum_neo_LP">{{$neo_L + $neo_P}}</td>
            <td id="sum_post_neo_LP">{{$post_neo_L + $post_neo_P}}</td>
            <td id="sum_bayi_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P}}</td>
            <td id="sum_balita_LP">{{$balita_L + $balita_P}}</td>
            <td id="sum_total_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P + $balita_L + $balita_P}}</td>
            
            <td></td>
        </tr>
        @endrole
    </tbody>
</table>