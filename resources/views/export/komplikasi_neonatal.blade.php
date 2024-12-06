<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH DAN PERSENTASE KOMPLIKASI NEONATAL																								
                MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
        </tr>
        <tr>
            <th>Kabupaten/Kota Kutai Timur</th>
        </tr>
        <tr>
            <th>Tahun {{Session::get('year')}}</th>
        </tr>
    <tr style="width: 100%">
        <th rowspan="3">Kecamatan</th>
        @role('Admin|superadmin')
        <th rowspan="3">Puskesmas</th>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        <th rowspan="3">Desa</th>
        @endrole
        <th colspan="3" rowspan="2">Jumlah Lahir Hidup</th>
        <th colspan="3" rowspan="2">Perkiraan Neonatal Komplikasi</th>
        <th colspan="16">Jumlah Komplikasi Pada Neonatus</th>
    </tr>
    <tr>
        <th colspan="2">BBLR</th>
        <th colspan="2">Asfiksia</th>
        <th colspan="2">Infeksi</th>
        <th colspan="2">Tetanus Neonatorum</th>
        <th colspan="2">Kelainan Konginetal</th>
        <th colspan="2">Covid-19</th>
        <th colspan="2">Lain-lain</th>
        <th colspan="2">Total</th>
    </tr>
    <tr>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>L</th>
        <th>P</th>
        <th>L+P</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>
        <th>jumlah</th>
        <th>%</th>

    </tr>
    </thead>
    <tbody>
        @php
            $lahir_hidup_L = 0;
            $lahir_hidup_P = 0;
            $bblr = 0;
            $asfiksia = 0;
            $infeksi = 0;
            $tetanus = 0;
            $kelainan = 0;
            $covid_19 = 0;
            $lain_lain = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $lahir_hidup_L += $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"];
            $lahir_hidup_P += $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"];
            $bblr += $item->komplikasi_neonatal_per_desa(Session::get('year'))["bblr"];
            $asfiksia += $item->komplikasi_neonatal_per_desa(Session::get('year'))["asfiksia"];
            $infeksi += $item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi'];
            $tetanus += $item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus'];
            $kelainan += $item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan'];
            $covid_19 += $item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19'];
            $lain_lain += $item->komplikasi_neonatal_per_desa(Session::get('year'))["lain_lain"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]}}</td>
            <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
            <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]}}</td>
            
            <td>{{number_format((15/100) * $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"], 2)}}</td>
            <td>{{number_format((15/100) * $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"], 2)}}</td>
            <td>{{number_format((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]), 2)}}</td>
        
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']}}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']
                }}</td>
            <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format(($item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']
                + $item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr'])/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>       
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{number_format((15/100) * $lahir_hidup_L, 2)}}</td>
            <td>{{number_format((15/100) * $lahir_hidup_P, 2)}}</td>
            <td>{{number_format((15/100) * ($lahir_hidup_P + $lahir_hidup_L), 2)}}</td>
            <td>{{$bblr}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($bblr/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$asfiksia}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($asfiksia/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$infeksi}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($infeksi/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$tetanus}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($tetanus/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$kelainan}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($kelainan/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$covid_19}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($covid_19/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$lain_lain}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($lain_lain/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$lain_lain + $covid_19 + $kelainan + $tetanus + $infeksi + $asfiksia + $bblr}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format(($lain_lain + $covid_19 + $kelainan + $tetanus + $infeksi + $asfiksia + $bblr)/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterKomplikasiNeonatal(Session::get('year')))
        @php
        $lahir_hidup_L += $item->filterKelahiran(Session::get('year'))->lahir_hidup_L;
        $lahir_hidup_P += $item->filterKelahiran(Session::get('year'))->lahir_hidup_P;
        $bblr += $item->filterKomplikasiNeonatal(Session::get('year'))->bblr;
        $asfiksia += $item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia;
        $infeksi += $item->filterKomplikasiNeonatal(Session::get('year'))->infeksi;
        $tetanus += $item->filterKomplikasiNeonatal(Session::get('year'))->tetanus;
        $kelainan += $item->filterKomplikasiNeonatal(Session::get('year'))->kelainan;
        $covid_19 += $item->filterKomplikasiNeonatal(Session::get('year'))->covid_19;
        $lain_lain += $item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain;
    @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>

            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>

            <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
            
            <td>{{number_format((15/100) * $item->filterKelahiran(Session::get('year'))->lahir_hidup_L, 2)}}</td>
            
            <td>{{number_format((15/100) * $item->filterKelahiran(Session::get('year'))->lahir_hidup_P, 2)}}</td>
            
            <td>{{number_format((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P), 2)}}</td>

            
            @php
            $komplikasiNeonatal = $item->filterKomplikasiNeonatal(Session::get('year'));
            $kelahiran = $item->filterKelahiran(Session::get('year'));
            $totalLahirHidup = $kelahiran->lahir_hidup_L + $kelahiran->lahir_hidup_P;
            $batasPersen = 15 / 100 * $totalLahirHidup;
        @endphp
        
        <td>{{ $komplikasiNeonatal->bblr }}</td>
        <td id="bblr{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->bblr / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->asfiksia }}</td>
        <td id="asfiksia{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->asfiksia / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->infeksi }}</td>
        <td id="infeksi{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->infeksi / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->tetanus }}</td>
        <td id="tetanus{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->tetanus / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->kelainan }}</td>
        <td id="kelainan{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->kelainan / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->covid_19 }}</td>
        <td id="covid_19{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->covid_19 / $batasPersen * 100, 2) : 0 }}
        </td>
        
        <td>{{ $komplikasiNeonatal->lain_lain }}</td>
        <td id="lain_lain{{ $komplikasiNeonatal->id }}">
            {{ $batasPersen > 0 ? number_format($komplikasiNeonatal->lain_lain / $batasPersen * 100, 2) : 0 }}
        </td>
        
            
            <td id="total{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{$item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain 
                + $item->filterKomplikasiNeonatal(Session::get('year'))->covid_19
                + $item->filterKomplikasiNeonatal(Session::get('year'))->kelainan
                + $item->filterKomplikasiNeonatal(Session::get('year'))->tetanus
                + $item->filterKomplikasiNeonatal(Session::get('year'))->infeksi
                + $item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia
                + $item->filterKomplikasiNeonatal(Session::get('year'))->bblr
                }}</td>

                <td id="persen_total{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
             + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format(($item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain 
                + $item->filterKomplikasiNeonatal(Session::get('year'))->covid_19
                + $item->filterKomplikasiNeonatal(Session::get('year'))->kelainan
                + $item->filterKomplikasiNeonatal(Session::get('year'))->tetanus
                + $item->filterKomplikasiNeonatal(Session::get('year'))->infeksi
                + $item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia
                + $item->filterKomplikasiNeonatal(Session::get('year'))->bblr)/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
             + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$lahir_hidup_L}}</td>
            <td>{{$lahir_hidup_P}}</td>
            <td>{{$lahir_hidup_P + $lahir_hidup_L}}</td>
            <td>{{number_format((15/100) * $lahir_hidup_L, 2)}}</td>
            <td>{{number_format((15/100) * $lahir_hidup_P, 2)}}</td>
            <td>{{number_format((15/100) * ($lahir_hidup_P + $lahir_hidup_L), 2)}}</td>
            <td>{{$bblr}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($bblr/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$asfiksia}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($asfiksia/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$infeksi}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($infeksi/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$tetanus}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($tetanus/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$kelainan}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($kelainan/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$covid_19}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($covid_19/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$lain_lain}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format($lain_lain/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
            <td>{{$lain_lain + $covid_19 + $kelainan + $tetanus + $infeksi + $asfiksia + $bblr}}</td>
            <td>{{(15/100) * ($lahir_hidup_P + $lahir_hidup_L) > 0?number_format(($lain_lain + $covid_19 + $kelainan + $tetanus + $infeksi + $asfiksia + $bblr)/((15/100) * ($lahir_hidup_P + $lahir_hidup_L)) * 100,2):0 }}%</td>
        </tr>
        @endrole
    </tbody>
</table>