@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('layouts.includes.sticky-table')

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{$title}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                            <li class="breadcrumb-item active">KLB</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-start gap-3">
                                <a type="button" class="btn btn-primary" href="{{ route('Table73.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                            </div>
                            {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div>
                        </div>
                        {{-- <h4 class="card-title">Pengguna</h4> --}}
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                        <div class="table-responsive lock-header">
                            <table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="3" style="vertical-align: middle">No</th>
                                        <th rowspan="3" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="3" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="3" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="15">MALARIA</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th rowspan="2">SUSPEK</th>
                                        <th colspan="3">KONFIRMASI LABORATORIUM</th>
                                        <th rowspan="2">% KONFIRMASI LABORATORIUM</th>
                                        <th colspan="3">POSITIF</th>
                                        <th rowspan="2">PENGOBATAN STANDAR</th>
                                        <th rowspan="2">% PENGOBATAN STANDAR</th>
                                        <th colspan="3">MENINGGAL</th>
                                        <th colspan="3">CFR	</th>
                                    </tr>
                                    <tr>
                                        <th>MIKROSKOPIS</th>
                                        <th>RAPID DIAGNOSTIC TEST (RDT)</th>
                                        <th>TOTAL</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandsuspek = 0;
                                        $Grandmikroskopis = 0;
                                        $Grandrapid = 0;
                                        $Grandtotal = 0;
                                        $Grandl_positif = 0;
                                        $Grandp_positif = 0;
                                        $Grandlp_positif = 0;
                                        $Grandpengobatan_standar = 0;
                                        $Grandl_meninggal = 0;
                                        $Grandp_meninggal = 0;
                                        $Grandlp_meninggal = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $suspek = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'suspek')['total'];
                                                        $Grandsuspek += $suspek;
                                                        echo $suspek;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $mikroskopis = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'mikroskopis')['total'];
                                                        $Grandmikroskopis += $mikroskopis;
                                                        echo $mikroskopis;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $rapid = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'rapid')['total'];
                                                    $Grandrapid += $rapid;
                                                    echo $rapid;
                                                @endphp
                                            </td>
                                            <td id="total_">
                                                @php
                                                    $total = $mikroskopis + $rapid;
                                                    $Grandtotal += $total;
                                                @endphp
                                                {{ $total }}
                                            </td>
                                            <td id="konfirmasi_">
                                                {{$suspek>0?number_format(($total / $suspek) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $l_positif = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'l_positif')['total'];
                                                    $Grandl_positif += $l_positif;
                                                    echo $l_positif;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $p_positif = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'p_positif')['total'];
                                                    $Grandp_positif += $p_positif;
                                                    echo $p_positif;
                                                @endphp
                                            </td>
                                            <td id="lp_positif_">
                                                @php
                                                    $lp_positif = $l_positif + $p_positif;
                                                    $Grandlp_positif += $lp_positif;
                                                    echo $lp_positif;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pengobatan_standar = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'pengobatan_standar')['total'];
                                                    $Grandpengobatan_standar += $pengobatan_standar;
                                                    echo $pengobatan_standar;
                                                @endphp
                                            </td>
                                            <td id="pengobatan_s_persen_">
                                                {{$lp_positif>0?number_format(($pengobatan_standar / $lp_positif) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $l_meninggal = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'l_meninggal')['total'];
                                                    $Grandl_meninggal += $l_meninggal;
                                                    echo $l_meninggal;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $p_meninggal = $item->unitKerjaAmbilPart2('filterTable73', Session::get('year'), 'p_meninggal')['total'];
                                                    $Grandp_meninggal += $p_meninggal;
                                                    echo $p_meninggal;
                                                @endphp
                                            </td>
                                            <td id="lp_meninggal_">
                                                @php
                                                    $lp_meninggal = $l_meninggal + $p_meninggal;
                                                    $Grandlp_meninggal += $lp_meninggal;
                                                    echo $lp_meninggal;
                                                @endphp
                                            </td>
                                            <td id="l_cfr_">
                                                {{$l_positif>0?number_format(($l_meninggal / $l_positif) * 100, 2) . '%':0}}
                                            </td>
                                            <td id="p_cfr_">
                                                {{$p_positif>0?number_format(($p_meninggal / $p_positif) * 100, 2) . '%':0}}
                                            </td>
                                            <td id="lp_cfr_">
                                                {{$lp_positif>0?number_format(($lp_meninggal / $lp_positif) * 100, 2) . '%':0}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable73(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $suspek = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->suspek;
                                                                $Grandsuspek += $suspek;
                                                        @endphp
                                                        <input type="number" name="suspek"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $suspek }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $mikroskopis = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->mikroskopis;
                                                                $Grandmikroskopis += $mikroskopis;
                                                        @endphp
                                                        <input type="number" name="mikroskopis"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $mikroskopis }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $rapid = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->rapid;
                                                            $Grandrapid += $rapid;
                                                        @endphp
                                                        <input type="number" name="rapid"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $rapid }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="total_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $total = $mikroskopis + $rapid;
                                                            $Grandtotal += $total;
                                                        @endphp
                                                        {{ $total }}
                                                    </td>
                                                    <td id="konfirmasi_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        {{$suspek>0?number_format(($total / $suspek) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $l_positif = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_positif;
                                                            $Grandl_positif += $l_positif;
                                                        @endphp
                                                        <input type="number" name="l_positif"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $l_positif }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_positif = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->p_positif;
                                                            $Grandp_positif += $p_positif;
                                                        @endphp
                                                        <input type="number" name="p_positif"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $p_positif }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="lp_positif_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $lp_positif = $l_positif + $p_positif;
                                                            $Grandlp_positif += $lp_positif;
                                                            echo $lp_positif;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pengobatan_standar = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->pengobatan_standar;
                                                            $Grandpengobatan_standar += $pengobatan_standar;
                                                        @endphp
                                                        <input type="number" name="pengobatan_standar"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $pengobatan_standar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="pengobatan_s_persen_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        {{$lp_positif>0?number_format(($pengobatan_standar / $lp_positif) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $l_meninggal = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_meninggal;
                                                            $Grandl_meninggal += $l_meninggal;
                                                        @endphp
                                                        <input type="number" name="l_meninggal"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $l_meninggal }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_meninggal = $item
                                                                ->filterTable73(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->p_meninggal;
                                                            $Grandp_meninggal += $p_meninggal;
                                                        @endphp
                                                        <input type="number" name="p_meninggal"
                                                        id="{{ $item->filterTable73(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $p_meninggal }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="lp_meninggal_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $lp_meninggal = $l_meninggal + $p_meninggal;
                                                            $Grandlp_meninggal += $lp_meninggal;
                                                            echo $lp_meninggal;
                                                        @endphp
                                                    </td>
                                                    <td id="l_cfr_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        {{$l_positif>0?number_format(($l_meninggal / $l_positif) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td id="p_cfr_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        {{$p_positif>0?number_format(($p_meninggal / $p_positif) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td id="lp_cfr_{{ $item->filterTable73(Session::get('year'), $item->id)->id }}">
                                                        {{$lp_positif>0?number_format(($lp_meninggal / $lp_positif) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole

                                    <tr>
                                        <th colspan="3">JUMLAH (KAB/KOTA)</th>
                                        <th id="Grandsuspek">{{$Grandsuspek }}</th>
                                        <th id="Grandmikroskopis">{{$Grandmikroskopis }}</th>
                                        <th id="Grandrapid">{{$Grandrapid }}</th>
                                        <th id="Grandtotal">{{$Grandtotal }}</th>
                                        <th id="Grandkonfirmasi">{{$Grandsuspek>0?number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%':0}}</th>
                                        <th id="Grandl_positif">{{$Grandl_positif }}</th>
                                        <th id="Grandp_positif">{{$Grandp_positif }}</th>
                                        <th id="Grandlp_positif">{{$Grandlp_positif }}</th>
                                        <th id="Grandpengobatan_standar">{{$Grandpengobatan_standar }}</th>
                                        <th id="Grandpengobatan_s_persen"> {{$Grandlp_positif>0?number_format(($Grandpengobatan_standar / $Grandlp_positif) * 100, 2) . '%':0}} </th>
                                        <th id="Grandl_meninggal">{{$Grandl_meninggal }}</th>
                                        <th id="Grandp_meninggal">{{$Grandp_meninggal }}</th>
                                        <th id="Grandlp_meninggal">{{$Grandlp_meninggal }}</th>
                                        <th id="Grandl_cfr">{{$Grandl_positif>0?number_format(($Grandl_meninggal / $Grandl_positif) * 100, 2) . '%':0}}</th>
                                        <th id="Grandp_cfr">{{$Grandp_positif>0?number_format(($Grandp_meninggal / $Grandp_positif) * 100, 2) . '%':0}}</th>
                                        <th id="Grandlp_cfr">{{$Grandlp_positif>0?number_format(($Grandlp_meninggal / $Grandlp_positif) * 100, 2) . '%':0}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="10">ANGKA KESAKITAN (ANNUAL PARASITE INCIDENCE) PER 1.000 PENDUDUK</th>
                                        <th id="angka_kesakitan">{{$jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki>0?($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000:0}}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


    </div>

    <div class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Tambah Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="Submit" class="btn btn-primary" id="submitButton" form="storeForm">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Required datatable js -->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    @endpush

    @push('scripts')
        <script>
            $('#data').on('input', '.data-input', function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                let data = {};
                var url_string = window.location.href;
                var url = new URL(url_string);
                let params = url.searchParams.get("year");
                let id = $(this).attr('id');
                // let persen = $(this).parent().parent().find(`#persen${id}`);
                // let balita_dipantau = $(this).parent().parent().find(`#balita_dipantau${id}`);
                // let balita_sdidtk = $(this).parent().parent().find(`#balita_sdidtk${id}`);
                // let balita_mtbs = $(this).parent().parent().find(`#balita_mtbs${id}`);
                // let lahir_hidup_mati_LP = $(this).parent().parent().find(`#lahir_hidup_mati_LP${id}`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'type': 'POST',
                    'url': '{{ url($route) }}',
                    'data': {
                        'name': name,
                        'value': value,
                        'id': id,
                        'year': params
                    },
                    success: function(res) {
                        console.log(res);
                        let properti = Object.keys(res);
                        let nilaiProperti = Object.values(res);
                        // console.log(properti);

                        for (let i = 1; i < properti.length; i++) {
                            // console.log(Object.keys(res)[i]);
                            // console.log(nilaiProperti[i]);
                            // if (typeof nilaiProperti[i] === 'string') {
                            //     let data = nilaiProperti[i].split(',');
                            //     // console.log(data);
                            //     if(data.length > 1) {
                            //         $('#' + Object.keys(res)[i]).text(data[1]);
                            //     } else {
                            //     }
                            // }
                            $('#' + Object.keys(res)[i]).text(nilaiProperti[i]);
                        }
                        // $('#klb_p_' + id).text(res.klb_p_);

                        // $('#GrandJumlah').text(res.GrandJumlah);
                        // $('#Grandditangani_24').text(res.Grandditangani_24);
                        // $('#GrandKLB_P').text(res.GrandKLB_P);
                    }
                });
                // console.log(name, value, id);
            })



            $("#filter").click(function() {
                let year = $("#tahun").val();
                window.location.href = "{{ url($route) }}?year=" + year;
            })
        </script>
    @endpush
@endsection
