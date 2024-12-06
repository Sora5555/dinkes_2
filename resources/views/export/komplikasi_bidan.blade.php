<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH DAN PERSENTASE KOMPLIKASI KEBIDANAN																				
                MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</th>
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
        <th rowspan="2">Jumlah Ibu Hamil</th>
        <th rowspan="2">Perkiraan Ibu Hamil Dengan Komplikasi Kebidanan</th>
        <th colspan="2">Bumil Dengan Komplikasi Kebidanan yang ditangani</th>
        <th colspan="11">Jumlah Komplikasi Kebidanan</th>
        <th rowspan="2">Jumlah Komplikasi Dalam Kehamilan</th>
        <th rowspan="2">Jumlah Komplikasi Dalam Persalinan</th>
        <th rowspan="2">Jumlah Komplikasi Pasca Persalinan (Nifas)</th>
    </tr>
    <tr>
        <th style="white-space: nowrap">Jumlah</th>
        <th style="white-space: nowrap">%</th>
        <th style="white-space: nowrap;">Kurang Energi Kronis (KEK)</th>
        <th>Anemia</th>
        <th>Pendarahan</th>
        <th>Tuberkulosis</th>
        <th>Malaria</th>
        <th>Infeksi Lainnya</th>
        <th>Preklampsia/Eklampsia</th>
        <th>Diabetes Melitus</th>
        <th>Jantung</th>
        <th>Covid-19</th>
        <th>Penyebab Lainnya</th>
    </tr>
    </thead>
    <tbody>
        @php
            $jumlah_ibu_hamil = 0;
            $jumlah = 0;
            $kek = 0;
            $anemia = 0;
            $pendarahan = 0;
            $tuberkulosis = 0;
            $malaria = 0;
            $infeksi_lain = 0;
            $preklampsia = 0;
            $diabetes = 0;
            $jantung = 0;
            $covid_19 = 0;
            $penyebab_lain = 0;
            $komplikasi_hamil = 0;
            $komplikasi_persalinan = 0;
            $komplikasi_nifas = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $jumlah_ibu_hamil += $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"];
            $jumlah += $item->komplikasi_bidan_per_desa(Session::get('year'))["jumlah"];
            $kek += $item->komplikasi_bidan_per_desa(Session::get('year'))["kek"];
            $anemia += $item->komplikasi_bidan_per_desa(Session::get('year'))["anemia"];
            $pendarahan += $item->komplikasi_bidan_per_desa(Session::get('year'))["pendarahan"];
            $tuberkulosis += $item->komplikasi_bidan_per_desa(Session::get('year'))["tuberkulosis"];
            $malaria += $item->komplikasi_bidan_per_desa(Session::get('year'))["malaria"];
            $infeksi_lain += $item->komplikasi_bidan_per_desa(Session::get('year'))["infeksi_lain"];
            $preklampsia += $item->komplikasi_bidan_per_desa(Session::get('year'))["preklampsia"];
            $diabetes += $item->komplikasi_bidan_per_desa(Session::get('year'))["diabetes"];
            $jantung += $item->komplikasi_bidan_per_desa(Session::get('year'))["jantung"];
            $covid_19 += $item->komplikasi_bidan_per_desa(Session::get('year'))["covid_19"];
            $penyebab_lain += $item->komplikasi_bidan_per_desa(Session::get('year'))["penyebab_lain"];
            $komplikasi_hamil += $item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_hamil"];
            $komplikasi_persalinan += $item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_persalinan"];
            $komplikasi_nifas += $item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_nifas"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]}}</td>
            <td>{{number_format((20/100) * $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"], 2)}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["jumlah"]}}</td>
            <td>{{(20/100) * $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]>0?number_format($item->komplikasi_bidan_per_desa(Session::get('year'))["jumlah"]/((20/100) * $item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]) * 100, 2):0}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["kek"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["anemia"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["pendarahan"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["tuberkulosis"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["malaria"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["infeksi_lain"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["preklampsia"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["diabetes"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["jantung"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["covid_19"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["penyebab_lain"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_hamil"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_persalinan"]}}</td>
            <td>{{$item->komplikasi_bidan_per_desa(Session::get('year'))["komplikasi_nifas"]}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah_ibu_hamil}}</td>
            <td>{{number_format((20/100) *$jumlah_ibu_hamil, 2)}}</td>
            <td>{{$jumlah}}</td>
            <td>{{(20/100) *$jumlah_ibu_hamil > 0 ? number_format($jumlah / ((20/100) *$jumlah_ibu_hamil) * 100, 2):0}}</td>
            <td>{{$kek}}</td>
            <td>{{$anemia}}</td>
            <td>{{$pendarahan}}</td>
            <td>{{$tuberkulosis}}</td>
            <td>{{$malaria}}</td>
            <td>{{$infeksi_lain}}</td>
            <td>{{$preklampsia}}</td>
            <td>{{$diabetes}}</td>
            <td>{{$jantung}}</td>
            <td>{{$covid_19}}</td>
            <td>{{$penyebab_lain}}</td>
            <td>{{$komplikasi_hamil}}</td>
            <td>{{$komplikasi_persalinan}}</td>
            <td>{{$komplikasi_nifas}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterKomplikasiBidan(Session::get('year')))
        @php
            $jumlah_ibu_hamil += $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
            $jumlah += $item->filterKomplikasiBidan(Session::get('year'))->jumlah;
            $kek += $item->filterKomplikasiBidan(Session::get('year'))->kek;
            $anemia += $item->filterKomplikasiBidan(Session::get('year'))->anemia;
            $pendarahan += $item->filterKomplikasiBidan(Session::get('year'))->pendarahan;
            $tuberkulosis += $item->filterKomplikasiBidan(Session::get('year'))->tuberkulosis;
            $malaria += $item->filterKomplikasiBidan(Session::get('year'))->malaria;
            $infeksi_lain += $item->filterKomplikasiBidan(Session::get('year'))->infeksi_lain;
            $preklampsia += $item->filterKomplikasiBidan(Session::get('year'))->preklampsia;
            $diabetes += $item->filterKomplikasiBidan(Session::get('year'))->diabetes;
            $jantung += $item->filterKomplikasiBidan(Session::get('year'))->jantung;
            $covid_19 += $item->filterKomplikasiBidan(Session::get('year'))->covid_19;
            $penyebab_lain += $item->filterKomplikasiBidan(Session::get('year'))->penyebab_lain;
            $komplikasi_hamil += $item->filterKomplikasiBidan(Session::get('year'))->komplikasi_hamil;
            $komplikasi_persalinan += $item->filterKomplikasiBidan(Session::get('year'))->komplikasi_persalinan;
            $komplikasi_nifas += $item->filterKomplikasiBidan(Session::get('year'))->komplikasi_nifas;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil}}</td>
            <td>{{number_format((20/100) * $item->filterDesa(Session::get('year'))->jumlah_ibu_hamil, 2)}}</td>

            @php
            $komplikasiBidan = $item->filterKomplikasiBidan(Session::get('year'));
            $desa = $item->filterDesa(Session::get('year'));
        @endphp
        
        <td>{{ $komplikasiBidan->jumlah }}</td>
        <td id="persen_jumlah{{ $komplikasiBidan->id }}">
            {{ 
                $desa->jumlah_ibu_hamil > 0 ? 
                number_format($komplikasiBidan->jumlah / ((20 / 100) * $desa->jumlah_ibu_hamil) * 100, 2) : 
                0 
            }}
        </td>
        
        <td>{{ $komplikasiBidan->kek }}</td>
        <td>{{ $komplikasiBidan->anemia }}</td>
        <td>{{ $komplikasiBidan->pendarahan }}</td>
        <td>{{ $komplikasiBidan->tuberkulosis }}</td>
        <td>{{ $komplikasiBidan->malaria }}</td>
        <td>{{ $komplikasiBidan->infeks_lain }}</td>
        <td>{{ $komplikasiBidan->preklampsia }}</td>
        <td>{{ $komplikasiBidan->diabetes }}</td>
        <td>{{ $komplikasiBidan->jantung }}</td>
        <td>{{ $komplikasiBidan->covid_19 }}</td>
        <td>{{ $komplikasiBidan->penyebab_lain }}</td>
        <td>{{ $komplikasiBidan->komplikasi_hamil }}</td>
        <td>{{ $komplikasiBidan->komplikasi_persalinan }}</td>
        <td>{{ $komplikasiBidan->komplikasi_nifas }}</td>
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$jumlah_ibu_hamil}}</td>
            <td>{{number_format((20/100) *$jumlah_ibu_hamil, 2)}}</td>
            <td>{{$jumlah}}</td>
            <td>{{(20/100) *$jumlah_ibu_hamil > 0 ? number_format($jumlah / ((20/100) *$jumlah_ibu_hamil) * 100, 2):0}}</td>
            <td>{{$kek}}</td>
            <td>{{$anemia}}</td>
            <td>{{$pendarahan}}</td>
            <td>{{$tuberkulosis}}</td>
            <td>{{$malaria}}</td>
            <td>{{$infeksi_lain}}</td>
            <td>{{$preklampsia}}</td>
            <td>{{$diabetes}}</td>
            <td>{{$jantung}}</td>
            <td>{{$covid_19}}</td>
            <td>{{$penyebab_lain}}</td>
            <td>{{$komplikasi_hamil}}</td>
            <td>{{$komplikasi_persalinan}}</td>
            <td>{{$komplikasi_nifas}}</td>
        </tr>
        @endrole
    </tbody>
</table>