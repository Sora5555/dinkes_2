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
                            <li class="breadcrumb-item active">CAKUPAN DETEKSI DINI KANKER LEHER RAHIM</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table82.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th rowspan="4" style="vertical-align: middle">No</th>
                                        <th rowspan="4" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="4" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="4" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="5">TFU TERDAFTAR</th>
                                        <th colspan="10">TFU YANG DILAKUKAN PENGAWASAN SESUAI STANDAR (IKL)</th>

                                        @role('Admin|superadmin')
                                            <th rowspan="4">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th colspan="2" rowspan="1">SEKOLAH</th>
                                        <th rowspan="3" style="vertical-align: middle;">PUSKESMAS</th>
                                        <th rowspan="3" style="vertical-align: middle;">PASAR</th>
                                        <th rowspan="3" style="vertical-align: middle;">TOTAL</th>
                                        <th colspan="4">SARANA PENDIDIKAN</th>
                                        <th colspan="2" rowspan="2" style="vertical-align: middle;">PUSKESMAS</th>
                                        <th colspan="2" rowspan="2" style="vertical-align: middle;">PASAR</th>
                                        <th colspan="2" rowspan="2" style="vertical-align: middle;">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">SD / MI</th>
                                        <th rowspan="2" style="vertical-align: middle;">SMP/ MTS</th>
                                        <th colspan="2">SD / MI</th>
                                        <th colspan="2">SMP/ MTS</th>
                                    </tr>
                                    <tr>
                                        <th>∑</th>
                                        <th>%</th>
                                        <th>∑</th>
                                        <th>%</th>
                                        <th>∑</th>
                                        <th>%</th>
                                        <th>∑</th>
                                        <th>%</th>
                                        <th>∑</th>
                                        <th>%</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @php
                                        $Grandsd = 0;
                                        $Grandsmp = 0;
                                        $Grandpuskesmas = 0;
                                        $Grandpasar = 0;
                                        $GrandTotal = 0;
                                        $Grandm_sd = 0;
                                        $Grandm_smp = 0;
                                        $Grandm_puskesmas = 0;
                                        $Grandm_pasar = 0;
                                        $GrandMTotal = 0;

                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $sd = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'sd')['total'];
                                                    $Grandsd += $sd;
                                                    echo $sd;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $smp = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'smp')['total'];
                                                    $Grandsmp += $smp;
                                                    echo $smp;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $puskesmas = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'puskesmas')['total'];
                                                    $Grandpuskesmas += $puskesmas;
                                                    echo $puskesmas;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pasar = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'pasar')['total'];
                                                    $Grandpasar += $pasar;
                                                    echo $pasar;
                                                @endphp
                                            </td>
                                            <td id="total_">
                                                @php
                                                    $totals = $sd + $smp + $puskesmas + $pasar;
                                                    $GrandTotal += $totals;
                                                @endphp
                                                {{ $totals }}
                                            </td>
                                            <td>
                                                @php
                                                    $m_sd = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'm_sd')['total'];
                                                    $Grandm_sd += $m_sd;
                                                    echo $m_sd;
                                                @endphp
                                            </td>
                                            <td id="persen_sd_">
                                                {{ $sd>0?number_format(($m_sd / $sd) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $m_smp = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'm_smp')['total'];
                                                    $Grandm_smp += $m_smp;
                                                    echo $m_smp;
                                                @endphp
                                            </td>
                                            <td id="persen_smp_">
                                                {{ $smp>0?number_format(($m_smp / $smp) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $m_puskesmas = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'm_puskesmas')['total'];
                                                    $Grandm_puskesmas += $m_puskesmas;
                                                    echo $m_puskesmas;
                                                @endphp
                                            </td>
                                            <td id="persen_puskesmas_">
                                                {{ $puskesmas>0?number_format(($m_puskesmas / $puskesmas) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $m_pasar = $item->unitKerjaAmbilPart2('filterTable82', Session::get('year'), 'm_pasar')['total'];
                                                    $Grandm_pasar += $m_pasar;
                                                    echo $m_pasar;
                                                @endphp
                                            </td>
                                            <td id="persen_pasar_">
                                                {{ $pasar>0?number_format(($m_pasar / $pasar) * 100, 2) . '%':0}}
                                            </td>
                                            <td id="jumlah_total_">
                                                @php
                                                    $total = $m_sd + $m_smp + $m_puskesmas + $m_pasar;
                                                    $GrandMTotal += $total;
                                                @endphp
                                                {{ $total }}
                                            </td>
                                            <td id="persen_total_">
                                                {{$totals>0? number_format(($total / $totals) * 100, 2) . '%':0}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole

                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable82(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $sd = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sd;
                                                            $Grandsd += $sd;
                                                        @endphp
                                                        <input type="number" name="sd"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sd }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $smp = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->smp;
                                                            $Grandsmp += $smp;
                                                        @endphp
                                                        <input type="number" name="smp"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $smp }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $puskesmas = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->puskesmas;
                                                            $Grandpuskesmas += $puskesmas;
                                                        @endphp
                                                        <input type="number" name="puskesmas"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $puskesmas }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pasar = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->pasar;
                                                            $Grandpasar += $pasar;
                                                        @endphp
                                                        <input type="number" name="pasar"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $pasar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="total_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $totals = $sd + $smp + $puskesmas + $pasar;
                                                            $GrandTotal += $totals;
                                                        @endphp
                                                        {{ $totals }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $m_sd = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->m_sd;
                                                            $Grandm_sd += $m_sd;
                                                        @endphp
                                                        <input type="number" name="m_sd"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $m_sd }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_sd_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        {{ $sd>0?number_format(($m_sd / $sd) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $m_smp = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->m_smp;
                                                            $Grandm_smp += $m_smp;
                                                        @endphp
                                                        <input type="number" name="m_smp"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $m_smp }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_smp_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        {{ $smp>0?number_format(($m_smp / $smp) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $m_puskesmas = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->m_puskesmas;
                                                            $Grandm_puskesmas += $m_puskesmas;
                                                        @endphp
                                                        <input type="number" name="m_puskesmas"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $m_puskesmas }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_puskesmas_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        {{ $puskesmas>0?number_format(($m_puskesmas / $puskesmas) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $m_pasar = $item
                                                                ->filterTable82(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->m_pasar;
                                                            $Grandm_pasar += $m_pasar;
                                                        @endphp
                                                        <input type="number" name="m_pasar"
                                                        id="{{ $item->filterTable82(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $m_pasar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_pasar_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        {{ $pasar>0?number_format(($m_pasar / $pasar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td id="jumlah_total_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $total = $m_sd + $m_smp + $m_puskesmas + $m_pasar;
                                                            $GrandMTotal += $total;
                                                        @endphp
                                                        {{ $total }}
                                                    </td>
                                                    <td id="persen_total_{{ $item->filterTable82(Session::get('year'), $item->id)->id }}">
                                                        {{ $totals>0?number_format(($total / $totals) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole
                                    <tr>
                                        <th colspan="3">JUMLAH</th>
                                        <th id="Grandsd">{{$Grandsd }} </th>
                                        <th id="Grandsmp">{{$Grandsmp }} </th>
                                        <th id="Grandpuskesmas">{{$Grandpuskesmas }} </th>
                                        <th id="Grandpasar">{{$Grandpasar }} </th>
                                        <th id="GrandTotal">{{$GrandTotal }} </th>
                                        <th id="Grandm_sd">{{$Grandm_sd }} </th>
                                        <th id="PersenGrandm_sd">{{ $Grandsd>0?number_format(($Grandm_sd / $Grandsd) * 100, 2) . '%':0}}</th>
                                        <th id="Grandm_smp">{{$Grandm_smp }} </th>
                                        <th id="PersenGrandm_smp">{{ $Grandsmp>0?number_format(($Grandm_smp / $Grandsmp) * 100, 2) . '%':0}}</th>
                                        <th id="Grandm_puskesmas">{{$Grandm_puskesmas }} </th>
                                        <th id="PersenGrandm_puskesmas">{{ $Grandpuskesmas>0?number_format(($Grandm_puskesmas / $Grandpuskesmas) * 100, 2) . '%':0}}</th>
                                        <th id="Grandm_pasar">{{$Grandm_pasar }}</th>
                                        <th id="PersenGrandm_pasar">{{$Grandpasar>0? number_format(($Grandm_pasar / $Grandpasar) * 100, 2) . '%':0}}</th>
                                        <th id="GrandMTotal">{{$GrandMTotal  }}</th>
                                        <th id="PersenGrandMTotal">{{ $GrandTotal>0?number_format(($GrandMTotal / $GrandTotal) * 100, 2) . '%':0}}</th>
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

                        for (let i = 1; i < properti.length; i++) {
                            $('#' + Object.keys(res)[i]).text(nilaiProperti[i]);
                        }
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
