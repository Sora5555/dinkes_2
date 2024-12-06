<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>PESERTA KB AKTIF METODE MODERN MENURUT JENIS KONTRASEPSI,DAN PESERTA KB AKTIF MENGALAMI EFEK SAMPING, KOMPLIKASI KEGAGALAN DAN DROP OUT MENURUT  KECAMATAN DAN PUSKESMAS</th>
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
        <th rowspan="2">Jumlah Pus</th>
        <th colspan="18" style="width: 80%">Peserta Aktif KB Modern</th>
        <th rowspan="2">Efek Samping Ber-KB</th>
        <th rowspan="2">%</th>
        <th rowspan="2">Komplikasi Ber-KB</th>
        <th rowspan="2">%</th>
        <th rowspan="2">Kegagalan Ber-KB</th>
        <th rowspan="2">%</th>
        <th rowspan="2" style="white-space: nowrap;">Drop out Ber-KB</th>
        <th rowspan="2">%</th>
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
        $efek_samping = 0;
        $kegagalan = 0;
        $komplikasi = 0;
        $dropout = 0;
    @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
        $jumlah += $item->pus_per_desa(Session::get('year'))["jumlah"];
        $kondom += $item->pus_per_desa(Session::get('year'))["kondom"];
        $suntik += $item->pus_per_desa(Session::get('year'))["suntik"];
        $pil += $item->pus_per_desa(Session::get('year'))["pil"];
        $akdr += $item->pus_per_desa(Session::get('year'))["akdr"];
        $mop += $item->pus_per_desa(Session::get('year'))["mop"];
        $mow += $item->pus_per_desa(Session::get('year'))["mow"];
        $implan += $item->pus_per_desa(Session::get('year'))["implan"];
        $mal += $item->pus_per_desa(Session::get('year'))["mal"];
        $efek_samping += $item->pus_per_desa(Session::get('year'))["efek_samping"];
        $kegagalan += $item->pus_per_desa(Session::get('year'))["kegagalan"];
        $komplikasi += $item->pus_per_desa(Session::get('year'))["komplikasi"];
        $dropout += $item->pus_per_desa(Session::get('year'))["dropout"];
    @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["kondom"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["kondom"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["suntik"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["suntik"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["pil"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["pil"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["akdr"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["akdr"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["mop"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["mop"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["mow"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["mow"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["implan"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["implan"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["mal"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["mal"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["mal"]
                + $item->pus_per_desa(Session::get('year'))["implan"]
                + $item->pus_per_desa(Session::get('year'))["mow"]
                + $item->pus_per_desa(Session::get('year'))["mop"]
                + $item->pus_per_desa(Session::get('year'))["pil"]
                + $item->pus_per_desa(Session::get('year'))["akdr"]
                + $item->pus_per_desa(Session::get('year'))["suntik"]
                + $item->pus_per_desa(Session::get('year'))["kondom"]
                }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format((($item->pus_per_desa(Session::get('year'))["mal"]
                + $item->pus_per_desa(Session::get('year'))["implan"]
                + $item->pus_per_desa(Session::get('year'))["mow"]
                + $item->pus_per_desa(Session::get('year'))["mop"]
                + $item->pus_per_desa(Session::get('year'))["pil"]
                + $item->pus_per_desa(Session::get('year'))["akdr"]
                + $item->pus_per_desa(Session::get('year'))["suntik"]
                + $item->pus_per_desa(Session::get('year'))["kondom"])/$item->pus_per_desa(Session::get('year'))["jumlah"]) * 100, 2):0 }}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["efek_samping"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["efek_samping"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>    
            <td>{{$item->pus_per_desa(Session::get('year'))["komplikasi"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["komplikasi"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>    
            <td>{{$item->pus_per_desa(Session::get('year'))["kegagalan"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["kegagalan"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>    
            <td>{{$item->pus_per_desa(Session::get('year'))["dropout"]}}</td>
            <td>{{$item->pus_per_desa(Session::get('year'))["jumlah"]>0?number_format($item->pus_per_desa(Session::get('year'))["dropout"]/$item->pus_per_desa(Session::get('year'))["jumlah"] * 100, 2):0 }}</td>    
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
            <td>{{$efek_samping}}</td>
            <td>{{$jumlah>0?number_format(($efek_samping/$jumlah) * 100, 2):0}}</td>
            <td>{{$komplikasi}}</td>
            <td>{{$jumlah>0?number_format(($komplikasi/$jumlah) * 100, 2):0}}</td>
            <td>{{$kegagalan}}</td>
            <td>{{$jumlah>0?number_format(($kegagalan/$jumlah) * 100, 2):0}}</td>
            <td>{{$dropout}}</td>
            <td>{{$jumlah>0?number_format(($dropout/$jumlah) * 100, 2):0}}</td>
            
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPus(Session::get('year')))
        @php
        $jumlah += $item->filterPus(Session::get('year'))->jumlah;
        $kondom += $item->filterPus(Session::get('year'))->kondom;
        $suntik += $item->filterPus(Session::get('year'))->suntik;
        $pil += $item->filterPus(Session::get('year'))->pil;
        $akdr += $item->filterPus(Session::get('year'))->akdr;
        $mop += $item->filterPus(Session::get('year'))->mop;
        $mow += $item->filterPus(Session::get('year'))->mow;
        $implan += $item->filterPus(Session::get('year'))->implan;
        $mal += $item->filterPus(Session::get('year'))->mal;
        $efek_samping += $item->filterPus(Session::get('year'))->efek_samping;
        $kegagalan += $item->filterPus(Session::get('year'))->kegagalan;
        $komplikasi += $item->filterPus(Session::get('year'))->komplikasi;
        $dropout += $item->filterPus(Session::get('year'))->dropout;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td><input type="number" name="jumlah" id="{{$item->filterPus(Session::get('year'))->id}}" value="{{$item->filterPus(Session::get('year'))->jumlah}}" class="form-control data-input" style="border: none"></td>

            <td>{{ $item->filterPus(Session::get('year'))->kondom }}</td>
            <td id="kondom{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->kondom / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->suntik }}</td>
            <td id="suntik{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->suntik / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->pil }}</td>
            <td id="pil{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->pil / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->akdr }}</td>
            <td id="akdr{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->akdr / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->mop }}</td>
            <td id="mop{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->mop / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->mow }}</td>
            <td id="mow{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->mow / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->implan }}</td>
            <td id="implan{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->implan / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->mal }}</td>
            <td id="mal{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->mal / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td id="jumlah{{ $item->filterPus(Session::get('year'))->id }}">
                {{
                    $item->filterPus(Session::get('year'))->mal +
                    $item->filterPus(Session::get('year'))->implan +
                    $item->filterPus(Session::get('year'))->mow +
                    $item->filterPus(Session::get('year'))->mop +
                    $item->filterPus(Session::get('year'))->pil +
                    $item->filterPus(Session::get('year'))->akdr +
                    $item->filterPus(Session::get('year'))->suntik +
                    $item->filterPus(Session::get('year'))->kondom
                }}
            </td>
            <td id="persen_jumlah{{ $item->filterPus(Session::get('year'))->id }}">
                {{
                    $item->filterPus(Session::get('year'))->jumlah > 0 ? 
                    number_format(
                        (
                            $item->filterPus(Session::get('year'))->mal +
                            $item->filterPus(Session::get('year'))->implan +
                            $item->filterPus(Session::get('year'))->mow +
                            $item->filterPus(Session::get('year'))->mop +
                            $item->filterPus(Session::get('year'))->pil +
                            $item->filterPus(Session::get('year'))->akdr +
                            $item->filterPus(Session::get('year'))->suntik +
                            $item->filterPus(Session::get('year'))->kondom
                        ) / $item->filterPus(Session::get('year'))->jumlah * 100, 2
                    ) : 0
                }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->efek_samping }}</td>
            <td id="efek_samping{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->efek_samping / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->komplikasi }}</td>
            <td id="komplikasi{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->komplikasi / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->kegagalan }}</td>
            <td id="kegagalan{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->kegagalan / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
            </td>
            <td>{{ $item->filterPus(Session::get('year'))->dropout }}</td>
            <td id="dropout{{ $item->filterPus(Session::get('year'))->id }}">
                {{ $item->filterPus(Session::get('year'))->jumlah > 0 ? number_format($item->filterPus(Session::get('year'))->dropout / $item->filterPus(Session::get('year'))->jumlah * 100, 2) : 0 }}
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
            <td>{{$efek_samping}}</td>
            <td>{{$jumlah>0?number_format(($efek_samping/$jumlah) * 100, 2):0}}</td>
            <td>{{$komplikasi}}</td>
            <td>{{$jumlah>0?number_format(($komplikasi/$jumlah) * 100, 2):0}}</td>
            <td>{{$kegagalan}}</td>
            <td>{{$jumlah>0?number_format(($kegagalan/$jumlah) * 100, 2):0}}</td>
            <td>{{$dropout}}</td>
            <td>{{$jumlah>0?number_format(($dropout/$jumlah) * 100, 2):0}}</td>
            
        </tr>
        @endrole
    </tbody>
</table>