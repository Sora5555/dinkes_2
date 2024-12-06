<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PELAYANAN KESEHATAN  PENDERITA HIPERTENSI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
            <th rowspan="1" colspan="3">Jumlah Penderita Hipertensi Berusia > 15 tahun</th>
            <th colspan="6">Mendapat Pelayanan Kesehatan</th>
        </tr>
    <tr>
        <th rowspan="2">Laki Laki</th>
        <th rowspan="2">Perempuan</th>
        <th rowspan="2">Laki Laki + Perempuan</th>
        <th colspan="2" style="white-space: nowrap">Laki Laki</th>
        <th colspan="2">Perempuan</th>
        <th colspan="2">Perempuan + Laki Laki</th>
        
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
            <td>{{$item->nama}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_L"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_P"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_P"] + $item->hipertensi_per_desa(Session::get('year'))["jumlah_L"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["pelayanan_L"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format($item->hipertensi_per_desa(Session::get('year'))["pelayanan_L"]/$item->hipertensi_per_desa(Session::get('year'))["jumlah_L"]*100, 2):0}}%</td>
            
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["pelayanan_P"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_P"] > 0?number_format($item->hipertensi_per_desa(Session::get('year'))["pelayanan_P"]/$item->hipertensi_per_desa(Session::get('year'))["jumlah_P"]*100, 2):0}}%</td>
            
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["pelayanan_P"] + $item->hipertensi_per_desa(Session::get('year'))["pelayanan_L"]}}</td>
            <td>{{$item->hipertensi_per_desa(Session::get('year'))["jumlah_P"] + $item->hipertensi_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format(($item->hipertensi_per_desa(Session::get('year'))["pelayanan_P"] + $item->hipertensi_per_desa(Session::get('year'))["pelayanan_L"])/($item->hipertensi_per_desa(Session::get('year'))["jumlah_P"] + $item->hipertensi_per_desa(Session::get('year'))["jumlah_L"])*100, 2):0}}%</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$total_L}}</td>
            <td>{{$total_P}}</td>
            <td>{{$total_L + $total_P}}</td>
            <td>{{$total_pelayanan_L}}</td>
            <td>{{$total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0}}%</td>
            
            <td>{{$total_pelayanan_P}}</td>
            <td>{{$total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0}}%</td>
            
            <td>{{$total_pelayanan_P + $total_pelayanan_L}}</td>
            <td>{{$total_P + $total_L > 0?number_format(($total_pelayanan_P + $total_pelayanan_L)/($total_P + $total_L)*100, 2):0}}%</td>
            
            <td></td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterHipertensi(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->filterHipertensi(Session::get('year'))->jumlah_L}}</td>
            <td>{{$item->filterHipertensi(Session::get('year'))->jumlah_P}}</td>
            <td id="jumlah_LP{{$item->filterHipertensi(Session::get('year'))->id}}">
                {{$item->filterHipertensi(Session::get('year'))->jumlah_L + $item->filterHipertensi(Session::get('year'))->jumlah_P}}
            </td>
            
            <td>{{$item->filterHipertensi(Session::get('year'))->pelayanan_L}}</td>
            <td id="pelayanan_L{{$item->filterHipertensi(Session::get('year'))->id}}">
                {{$item->filterHipertensi(Session::get('year'))->jumlah_L > 0 ? number_format($item->filterHipertensi(Session::get('year'))->pelayanan_L / $item->filterHipertensi(Session::get('year'))->jumlah_L * 100, 2) : 0}}%
            </td>
            
            <td>{{$item->filterHipertensi(Session::get('year'))->pelayanan_P}}</td>
            <td id="pelayanan_P{{$item->filterHipertensi(Session::get('year'))->id}}">
                {{$item->filterHipertensi(Session::get('year'))->jumlah_P > 0 ? number_format($item->filterHipertensi(Session::get('year'))->pelayanan_P / $item->filterHipertensi(Session::get('year'))->jumlah_P * 100, 2) : 0}}%
            </td>
            
            <td id="pelayanan_LP{{$item->filterHipertensi(Session::get('year'))->id}}">
                {{$item->filterHipertensi(Session::get('year'))->pelayanan_P + $item->filterHipertensi(Session::get('year'))->pelayanan_L}}
            </td>
            <td id="persen_pelayanan_LP{{$item->filterHipertensi(Session::get('year'))->id}}">
                {{$item->filterHipertensi(Session::get('year'))->jumlah_P + $item->filterHipertensi(Session::get('year'))->jumlah_L > 0 ? 
                    number_format(($item->filterHipertensi(Session::get('year'))->pelayanan_P + $item->filterHipertensi(Session::get('year'))->pelayanan_L) / 
                    ($item->filterHipertensi(Session::get('year'))->jumlah_P + $item->filterHipertensi(Session::get('year'))->jumlah_L) * 100, 2) : 0}}%
            </td>
            
            
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td id="jumlah_L">{{$total_L}}</td>
            <td id="jumlah_P">{{$total_P}}</td>
            <td id="total_LP">{{$total_L + $total_P}}</td>
            <td id="pelayanan_L">{{$total_pelayanan_L}}</td>
            <td id="percentage_pelayanan_L">{{$total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0}}%</td>
            
            <td id="pelayanan_P">{{$total_pelayanan_P}}</td>
            <td id="percentage_pelayanan_P">{{$total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0}}%</td>
            
            <td id="jumlah_pelayanan_LP">{{$total_pelayanan_P + $total_pelayanan_L}}</td>
            <td id="percentage_pelayanan_LP">{{$total_P + $total_L > 0?number_format(($total_pelayanan_P + $total_pelayanan_L)/($total_P + $total_L)*100, 2):0}}%</td>
            
        </tr>
        @endrole
    </tbody>
</table>