<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KUNJUNGAN PASIEN BARU RAWAT JALAN, RAWAT INAP, DAN KUNJUNGAN GANGGUAN JIWA DI SARANA PELAYANAN KESEHATAN</th>
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
            <th colspan="6">Jumlah Kunjungan</th>
            <th colspan="3">Kunjungan Gangguan Jiwa</th>
        </tr>
    <tr>
        <th colspan="3">Rawat Jalan</th>
        <th colspan="3">Rawat Inap</th>
        <th colspan="3">Jumlah</th>
    </tr>
    <tr>
        <th style="white-space:nowrap">Laki Laki</th>
        <th>Perempuan</th>
        <th>Laki Laki + Perempuan</th>
        <th style="white-space:nowrap">Laki Laki</th>
        <th>Perempuan</th>
        <th>Laki Laki + Perempuan</th>
        <th style="white-space:nowrap">Laki Laki</th>
        <th>Perempuan</th>
        <th>Laki Laki + Perempuan</th>
    </tr>
    </thead>
    <tbody>
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jalan_L"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jalan_P"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jalan_P"] + $item->kunjungan_per_desa(Session::get('year'))["jalan_L"]}}</td>
            
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["inap_L"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["inap_P"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["inap_P"] + $item->kunjungan_per_desa(Session::get('year'))["inap_L"]}}</td>
            
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_L"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_P"]}}</td>
            <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_P"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_L"]}}</td>
            
          </tr>
        @endforeach
        <tr>
            @php
            @endphp
            <td></td>
            <td>TOTAL</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jalan_L')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jalan_P')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jalan_P') + \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jalan_L')}}</td>
            
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'inap_L')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'inap_P')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'inap_P') + \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'inap_L')}}</td>
            
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jiwa_L')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jiwa_P')}}</td>
            <td>{{\App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jiwa_P') + \App\Models\UnitKerja::totalForAllUnitKerja(Session::get('year'), 'filterKunjungan', 'jiwa_L')}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterKunjungan(Session::get('year')))
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
         @php
            $kunjungan = $item->filterKunjungan(Session::get('year'));
        @endphp
        
        <!-- Kunjungan Jalan -->
        <td>{{$kunjungan->jalan_L}}</td>
        <td>{{$kunjungan->jalan_P}}</td>
        <td id="jalan{{$kunjungan->id}}">{{$kunjungan->jalan_L + $kunjungan->jalan_P}}</td>
        
        <!-- Kunjungan Inap -->
        <td>{{$kunjungan->inap_L}}</td>
        <td>{{$kunjungan->inap_P}}</td>
        <td id="inap{{$kunjungan->id}}">{{$kunjungan->inap_L + $kunjungan->inap_P}}</td>
        
        <!-- Kunjungan Jiwa -->
        <td>{{$kunjungan->jiwa_L}}</td>
        <td>{{$kunjungan->jiwa_P}}</td>
        <td id="jiwa{{$kunjungan->id}}">{{$kunjungan->jiwa_L + $kunjungan->jiwa_P}}</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
        @php
            $total = Auth::user()->unit_kerja;
        @endphp
        <td></td>
            <td>TOTAL</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jalan_L')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jalan_P')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jalan_L') + $total->admin_total(Session::get('year'), 'filterKunjungan', 'jalan_P')}}</td>
            
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'inap_L')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'inap_P')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'inap_L') + $total->admin_total(Session::get('year'), 'filterKunjungan', 'inap_P')}}</td>
            
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jiwa_L')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jiwa_P')}}</td>
            <td>{{$total->admin_total(Session::get('year'), 'filterKunjungan', 'jiwa_L') + $total->admin_total(Session::get('year'), 'filterKunjungan', 'jiwa_P')}}</td>
            
        @endrole
    </tr>
    </tbody>
</table>