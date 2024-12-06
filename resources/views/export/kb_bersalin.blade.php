<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>CAKUPAN DAN PROPORSI PESERTA KB PASCA PERSALINAN MENURUT JENIS KONTRASEPSI, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="2">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="2">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="2">Desa</th>
        @endrole
        <th rowspan="2">Jumlah Ibu Bersalin</th>
        <th colspan="18" style="width: 80%">Peserta Aktif KB Modern</th>
    </tr>
    <tr>
        <th style="white-space: nowrap">Kondom</th>
        <th style="white-space: nowrap">%</th>
        <th style="white-space: nowrap;">Suntik &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">Pil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">Akdr &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">MOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">MOW &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">Implan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th style="white-space: nowrap;">MAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>%</th>
        <th>Jumlah</th>
        <th>%</th>
    </tr>
    </thead>
    <tbody>
        @php
        $jumlah = 0;
        $kondom = 0;
        $suntik = 0;
        $pil = 0;
        $akdr = 0;
        $mop = 0;
        $mow = 0;
        $implan = 0;
        $mal = 0;
    @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $jumlah += $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"];
        $kondom += $item->ibu_hamil_per_desa(Session::get('year'))["kondom"];
        $suntik += $item->ibu_hamil_per_desa(Session::get('year'))["suntik"];
        $pil += $item->ibu_hamil_per_desa(Session::get('year'))["pil"];
        $akdr += $item->ibu_hamil_per_desa(Session::get('year'))["akdr"];
        $mop += $item->ibu_hamil_per_desa(Session::get('year'))["mop"];
        $mow += $item->ibu_hamil_per_desa(Session::get('year'))["mow"];
        $implan += $item->ibu_hamil_per_desa(Session::get('year'))["implan"];
        $mal += $item->ibu_hamil_per_desa(Session::get('year'))["mal"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["kondom"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["kondom"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["suntik"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["suntik"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["pil"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["pil"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["akdr"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["akdr"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mop"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mop"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mow"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mow"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["implan"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["implan"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mal"]}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mal"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mal"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["implan"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["mow"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["mop"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["pil"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["akdr"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["suntik"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["kondom"]
                }}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format((($item->ibu_hamil_per_desa(Session::get('year'))["mal"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["implan"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["mow"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["mop"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["pil"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["akdr"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["suntik"]
                + $item->ibu_hamil_per_desa(Session::get('year'))["kondom"])/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]) * 100, 2):0 }}</td>
    </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah}}</td>
            <td>{{$kondom}}</td>
            <td>{{$jumlah>0?number_format(($kondom/$jumlah) * 100, 2):0}}</td>
            <td>{{$suntik}}</td>
            <td>{{$jumlah>0?number_format(($suntik/$jumlah) * 100, 2):0}}</td>
            <td>{{$pil}}</td>
            <td>{{$jumlah>0?number_format(($pil/$jumlah) * 100, 2):0}}</td>
            <td>{{$akdr}}</td>
            <td>{{$jumlah>0?number_format(($akdr/$jumlah) * 100, 2):0}}</td>
            <td>{{$mop}}</td>
            <td>{{$jumlah>0?number_format(($mop/$jumlah) * 100, 2):0}}</td>
            <td>{{$mow}}</td>
            <td>{{$jumlah>0?number_format(($mow/$jumlah) * 100, 2):0}}</td>
            <td>{{$implan}}</td>
            <td>{{$jumlah>0?number_format(($implan/$jumlah) * 100, 2):0}}</td>
            <td>{{$mal}}</td>
            <td>{{$jumlah>0?number_format(($mal/$jumlah) * 100, 2):0}}</td>
            <td>{{$mal + $implan + $mow + $mop + $akdr + $pil + $suntik + $kondom}}</td>
            <td>{{$jumlah>0?number_format((($mal + $implan + $mow + $mop + $akdr + $pil + $suntik + $kondom)/$jumlah) * 100, 2):0}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterDesa(Session::get('year')))
        @php
             $jumlah += $item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
        $kondom += $item->filterDesa(Session::get('year'))->kondom;
        $suntik += $item->filterDesa(Session::get('year'))->suntik;
        $pil += $item->filterDesa(Session::get('year'))->pil;
        $akdr += $item->filterDesa(Session::get('year'))->akdr;
        $mop += $item->filterDesa(Session::get('year'))->mop;
        $mow += $item->filterDesa(Session::get('year'))->mow;
        $implan += $item->filterDesa(Session::get('year'))->implan;
        $mal += $item->filterDesa(Session::get('year'))->mal;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin}}</td>

            @php
    $desaData = $item->filterDesa(Session::get('year'));
@endphp

<td>{{ $desaData->kondom }}</td>
<td id="kondom{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->kondom / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->suntik }}</td>
<td id="suntik{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->suntik / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->pil }}</td>
<td id="pil{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->pil / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->akdr }}</td>
<td id="akdr{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->akdr / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->mop }}</td>
<td id="mop{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->mop / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->mow }}</td>
<td id="mow{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->mow / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->implan }}</td>
<td id="implan{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->implan / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td>{{ $desaData->mal }}</td>
<td id="mal{{ $desaData->id }}">
    {{ $desaData->jumlah_ibu_bersalin > 0 ? number_format(($desaData->mal / $desaData->jumlah_ibu_bersalin) * 100, 2) : 0 }}
</td>

<td id="jumlah{{ $desaData->id }}">
    {{ 
        $desaData->mal +
        $desaData->implan +
        $desaData->mow +
        $desaData->mop +
        $desaData->pil +
        $desaData->akdr +
        $desaData->suntik +
        $desaData->kondom 
    }}
</td>

<td id="persen_jumlah{{ $desaData->id }}">
    {{ 
        $desaData->jumlah_ibu_bersalin > 0 ? number_format(
        (
            $desaData->mal +
            $desaData->implan +
            $desaData->mow +
            $desaData->mop +
            $desaData->pil +
            $desaData->akdr +
            $desaData->suntik +
            $desaData->kondom
        ) / $desaData->jumlah_ibu_bersalin * 100, 2) : 0 
    }}
</td>
</tr>
          @endif
        @endforeach
        <tr>
        <td>TOTAL</td>
        <td></td>
        <td>{{$jumlah}}</td>
        <td>{{$kondom}}</td>
        <td>{{$jumlah>0?number_format(($kondom/$jumlah) * 100, 2):0}}</td>
        <td>{{$suntik}}</td>
        <td>{{$jumlah>0?number_format(($suntik/$jumlah) * 100, 2):0}}</td>
        <td>{{$pil}}</td>
        <td>{{$jumlah>0?number_format(($pil/$jumlah) * 100, 2):0}}</td>
        <td>{{$akdr}}</td>
        <td>{{$jumlah>0?number_format(($akdr/$jumlah) * 100, 2):0}}</td>
        <td>{{$mop}}</td>
        <td>{{$jumlah>0?number_format(($mop/$jumlah) * 100, 2):0}}</td>
        <td>{{$mow}}</td>
        <td>{{$jumlah>0?number_format(($mow/$jumlah) * 100, 2):0}}</td>
        <td>{{$implan}}</td>
        <td>{{$jumlah>0?number_format(($implan/$jumlah) * 100, 2):0}}</td>
        <td>{{$mal}}</td>
        <td>{{$jumlah>0?number_format(($mal/$jumlah) * 100, 2):0}}</td>
        <td>{{$mal + $implan + $mow + $mop + $akdr + $pil + $suntik + $kondom}}</td>
        <td>{{$jumlah>0?number_format((($mal + $implan + $mow + $mop + $akdr + $pil + $suntik + $kondom)/$jumlah) * 100, 2):0}}</td>
    </tr>
        @endrole
    </tbody>
</table>