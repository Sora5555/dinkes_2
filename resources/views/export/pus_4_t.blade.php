<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PASANGAN USIA SUBUR (PUS) DENGAN STATUS 4 TERLALU (4T) DAN ALKI YANG MENJADI PESERTA KB AKTIF</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th>Kecamatan</th>
        @role('Admin|superadmin')
        <th>Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th>Desa</th>
        @endrole
        <th>Jumlah Pus</th>
        <th>Pus 4T</th>
        <th>%</th>
        <th>Pus 4T pada KB Aktif</th>
        <th>%</th>
        <th>Pus Alki</th>
        <th>%</th>
        <th>Pus Alki pada KB Aktif</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
        $jumlah = 0;
        $pus_4_t = 0;
        $pus_4_t_kb = 0;
        $pus_alki = 0;
        $pus_alki_kb = 0;
    @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        $jumlah += $item->pus_per_desa(Session::get('year'))["jumlah"];
        $pus_4_t += $item->pus_per_desa(Session::get('year'))["pus_4_t"];
        $pus_4_t_kb += $item->pus_per_desa(Session::get('year'))["pus_4_t_kb"];
        $pus_alki += $item->pus_per_desa(Session::get('year'))["pus_alki"];
        $pus_alki_kb += $item->pus_per_desa(Session::get('year'))["pus_alki_kb"];
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["pus_4_t"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["pus_4_t"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["pus_4_t_kb"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["pus_4_t_kb"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["pus_alki"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["pus_alki"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["pus_alki_kb"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["pus_alki_kb"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>    
    </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah}}</td>
            <td>{{$pus_4_t}}</td>
            <td>{{$jumlah>0?number_format(($pus_4_t/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_4_t_kb}}</td>
            <td>{{$jumlah>0?number_format(($pus_4_t_kb/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_alki}}</td>
            <td>{{$jumlah>0?number_format(($pus_alki/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_alki_kb}}</td>
            <td>{{$jumlah>0?number_format(($pus_alki_kb/$jumlah) * 100, 2):0}}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPenyebabKematianIbu(Session::get('year')))
        @php
        $jumlah +=$item->filterPus(Session::get('year'))->jumlah;
        $pus_4_t += $item->filterPus(Session::get('year'))->pus_4_t;
        $pus_4_t_kb += $item->filterPus(Session::get('year'))->pus_4_t_kb;
        $pus_alki += $item->filterPus(Session::get('year'))->pus_alki;
        $pus_alki_kb += $item->filterPus(Session::get('year'))->pus_alki_kb;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterPus(Session::get('year'))->jumlah}}</td>

        @php
            $pusData = $item->filterPus(Session::get('year'));
        @endphp
        
        <td>{{ $pusData->pus_4_t }}</td>
        <td id="pus_4_t{{ $pusData->id }}">
            {{ $pusData->jumlah > 0 ? number_format(($pusData->pus_4_t / $pusData->jumlah) * 100, 2) : 0 }}
        </td>
        
        <td>{{ $pusData->pus_4_t_kb }}</td>
        <td id="pus_4_t_kb{{ $pusData->id }}">
            {{ $pusData->jumlah > 0 ? number_format(($pusData->pus_4_t_kb / $pusData->jumlah) * 100, 2) : 0 }}
        </td>
        
        <td>{{ $pusData->pus_alki }}</td>
        <td id="pus_alki{{ $pusData->id }}">
            {{ $pusData->jumlah > 0 ? number_format(($pusData->pus_alki / $pusData->jumlah) * 100, 2) : 0 }}
        </td>
        
        <td>{{ $pusData->pus_alki_kb }}</td>
        <td id="pus_alki_kb{{ $pusData->id }}">
            {{ $pusData->jumlah > 0 ? number_format(($pusData->pus_alki_kb / $pusData->jumlah) * 100, 2) : 0 }}
        </td>
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah}}</td>
            <td>{{$pus_4_t}}</td>
            <td>{{$jumlah>0?number_format(($pus_4_t/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_4_t_kb}}</td>
            <td>{{$jumlah>0?number_format(($pus_4_t_kb/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_alki}}</td>
            <td>{{$jumlah>0?number_format(($pus_alki/$jumlah) * 100, 2):0}}%</td>
            <td>{{$pus_alki_kb}}</td>
            <td>{{$jumlah>0?number_format(($pus_alki_kb/$jumlah) * 100, 2):0}}%</td>
        </tr>
        @endrole
    </tbody>
</table>