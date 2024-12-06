<table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="text-center">
        <tr>
            <th>JUMLAH KEMATIAN NEONATAL DAN POST NEONATAL MENURUT PENYEBAB UTAMA, KECAMATAN, DAN PUSKESMAS</th>
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
        <th colspan="8">Penyebab Kematian Neonatal (0-28 hari)</th>
        <th colspan="9">Penyebab Kematian Post Neonatal (29 hari - 11 Bulan)</th>
    </tr>
    <tr>
        <th>BBLR DAN PREMATURITAS</th>
        <th>ASFIKSIA</th>
        <th>TETANUS NEONATORUM</th>
        <th>INFEKSI</th>
        <th>KELAINAN KONGENITAL</th>
        <th>COVID-19</th>
        <th>KELAINAN CARDIOVASKULAR DAN RESPIRATION</th>
        <th>LAIN-LAIN</th>
        <th>KONDISI PERINATAL</th>
        <th>PNEUMONIA</th>
        <th>DIARE</th>
        <th>KELAINAN KONGENITAL JANTUNG</th>
        <th>KELAINAN KONGENITAL LAINNYA</th>
        <th>MENINGITIS</th>
        <th>PENYAKIT SARAF</th>
        <th>DEMAM BERDARAH</th>
        <th>LAIN-LAIN</th>
    </tr>
    </thead>
    <tbody>
        @php
            $bblr = 0;
            $asfiksia = 0;
            $tetanus = 0;
            $infeksi = 0;
            $kelainan = 0;
            $covid_19 = 0;
            $cardio = 0;
            $lain_lain_neo = 0;
            $perinatal = 0;
            $pneumonia = 0;
            $diare = 0;
            $jantung = 0;
            $kelainan_kongenital = 0;
            $meningitis = 0;
            $saraf = 0;
            $dbd = 0;
            $lain_lain_post_neo = 0;
        @endphp
        @role('Admin|superadmin')
        @foreach ($unit_kerja as $key => $item)
        @php
            $bblr += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'bblr')["total"];
            $asfiksia += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'asfiksia')["total"];
            $tetanus += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'tetanus')["total"];
            $infeksi += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'infeksi')["total"];
            $kelainan += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'kelainan')["total"];
            $covid_19 += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'covid_19')["total"];
            $cardio += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'cardio')["total"];
            $lain_lain_neo += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'lain_lain_neo')["total"];
            $perinatal += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'perinatal')["total"];
            $pneumonia += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'pneumonia')["total"];
            $diare += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'diare')["total"];
            $jantung += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'jantung')["total"];
            $kelainan_kongenital += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'kelainan_kongenital')["total"];
            $meningitis += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'meningitis')["total"];
            $saraf += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'saraf')["total"];
            $dbd += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'dbd')["total"];
            $lain_lain_post_neo += $item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'lain_lain_post_neo')["total"];
        @endphp
        
        <tr style={{$key % 2 == 0?"background: gray":""}}>
            <td>{{$item->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'bblr')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'asfiksia')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'tetanus')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'infeksi')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'kelainan')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'covid_19')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'cardio')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'lain_lain_neo')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'perinatal')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'pneumonia')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'diare')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'jantung')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'kelainan_kongenital')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'meningitis')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'saraf')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'dbd')["total"]}}</td>
            <td>{{$item->unitKerjaAmbil('filterPenyebabKematianNeonatal', Session::get('year'), 'lain_lain_post_neo')["total"]}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$bblr}}</td>
            <td>{{$asfiksia}}</td>
            <td>{{$tetanus}}</td>
            <td>{{$infeksi}}</td>
            <td>{{$kelainan}}</td>
            <td>{{$covid_19}}</td>
            <td>{{$cardio}}</td>
            <td>{{$lain_lain_neo}}</td>
            <td>{{$perinatal}}</td>
            <td>{{$pneumonia}}</td>
            <td>{{$diare}}</td>
            <td>{{$jantung}}</td>
            <td>{{$kelainan_kongenital}}</td>
            <td>{{$meningitis}}</td>
            <td>{{$saraf}}</td>
            <td>{{$dbd}}</td>
            <td>{{$lain_lain_post_neo}}</td>
        </tr>
        @endrole
        @role('Puskesmas|Pihak Wajib Pajak')
        @foreach ($desa as $key => $item)
        @if($item->filterPenyebabKematianNeonatal(Session::get('year')))
        @php
            $bblr = $item->filterPenyebabKematianNeonatal(Session::get('year'))->bblr;
            $asfiksia = $item->filterPenyebabKematianNeonatal(Session::get('year'))->asfiksia;
            $tetanus = $item->filterPenyebabKematianNeonatal(Session::get('year'))->tetanus;
            $infeksi = $item->filterPenyebabKematianNeonatal(Session::get('year'))->infeksi;
            $kelainan = $item->filterPenyebabKematianNeonatal(Session::get('year'))->kelainan;
            $covid_19 = $item->filterPenyebabKematianNeonatal(Session::get('year'))->covid_19;
            $cardio = $item->filterPenyebabKematianNeonatal(Session::get('year'))->cardio;
            $lain_lain_neo = $item->filterPenyebabKematianNeonatal(Session::get('year'))->lain_lain_neo;
            $perinatal = $item->filterPenyebabKematianNeonatal(Session::get('year'))->perinatal;
            $pneumonia = $item->filterPenyebabKematianNeonatal(Session::get('year'))->pneumonia;
            $diare = $item->filterPenyebabKematianNeonatal(Session::get('year'))->diare;
            $jantung = $item->filterPenyebabKematianNeonatal(Session::get('year'))->jantung;
            $kelainan_kongenital = $item->filterPenyebabKematianNeonatal(Session::get('year'))->kelainan_kongenital;
            $meningitis = $item->filterPenyebabKematianNeonatal(Session::get('year'))->meningitis;
            $saraf = $item->filterPenyebabKematianNeonatal(Session::get('year'))->saraf;
            $dbd = $item->filterPenyebabKematianNeonatal(Session::get('year'))->dbd;
            $lain_lain_post_neo = $item->filterPenyebabKematianNeonatal(Session::get('year'))->lain_lain_post_neo;
        @endphp
        <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
            <td>{{$item->UnitKerja->kecamatan}}</td>
            <td class="unit_kerja">{{$item->nama}}</td>
            
            @php
            $penyebabKematian = $item->filterPenyebabKematianNeonatal(Session::get('year'));
        @endphp
        
        <td>{{ $penyebabKematian->bblr }}</td>
        <td>{{ $penyebabKematian->asfiksia }}</td>
        <td>{{ $penyebabKematian->tetanus }}</td>
        <td>{{ $penyebabKematian->infeksi }}</td>
        <td>{{ $penyebabKematian->kelainan }}</td>
        <td>{{ $penyebabKematian->covid_19 }}</td>
        <td>{{ $penyebabKematian->cardio }}</td>
        <td>{{ $penyebabKematian->lain_lain_neo }}</td>
        <td>{{ $penyebabKematian->perinatal }}</td>
        <td>{{ $penyebabKematian->pneumonia }}</td>
        <td>{{ $penyebabKematian->diare }}</td>
        <td>{{ $penyebabKematian->jantung }}</td>
        <td>{{ $penyebabKematian->kelainan_kongenital }}</td>
        <td>{{ $penyebabKematian->meningitis }}</td>
        <td>{{ $penyebabKematian->saraf }}</td>
        <td>{{ $penyebabKematian->dbd }}</td>
        <td>{{ $penyebabKematian->lain_lain_post_neo }}</td>
        
            
          </tr>
          @endif
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td>{{$bblr}}</td>
            <td>{{$asfiksia}}</td>
            <td>{{$tetanus}}</td>
            <td>{{$infeksi}}</td>
            <td>{{$kelainan}}</td>
            <td>{{$covid_19}}</td>
            <td>{{$cardio}}</td>
            <td>{{$lain_lain_neo}}</td>
            <td>{{$perinatal}}</td>
            <td>{{$pneumonia}}</td>
            <td>{{$diare}}</td>
            <td>{{$jantung}}</td>
            <td>{{$kelainan_kongenital}}</td>
            <td>{{$meningitis}}</td>
            <td>{{$saraf}}</td>
            <td>{{$dbd}}</td>
            <td>{{$lain_lain_post_neo}}</td>
        </tr>
        @endrole
    </tbody>
</table>