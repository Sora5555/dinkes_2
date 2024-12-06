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
                            <li class="breadcrumb-item active">KASUS COVID-19</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table84.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th rowspan="1" style="vertical-align: middle">No</th>
                                        <th rowspan="1" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="1" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="1" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th>KASUS</th>
                                        <th>SEMBUH</th>
                                        <th>MENIGGAL</th>
                                        <th>ANGKA</th>
                                        <th>ANGKA</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="1">Lock data</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $GrandKasus = 0;
                                        $GrandSembuh = 0;
                                        $GrandMeninggal = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $kasus = $item->unitKerjaAmbilPart2('filterTable84', Session::get('year'), 'kasus')['total'];
                                                    $GrandKasus += $kasus;
                                                    echo $kasus;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $sembuh = $item->unitKerjaAmbilPart2('filterTable84', Session::get('year'), 'sembuh')['total'];
                                                    $GrandSembuh += $sembuh;
                                                    echo $sembuh;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $meninggal = $item->unitKerjaAmbilPart2('filterTable84', Session::get('year'), 'meninggal')['total'];
                                                    $GrandMeninggal += $meninggal;
                                                    echo $meninggal;
                                                @endphp
                                            </td>
                                            <td id="AngkaPersen_1_">
                                                {{$kasus>0?number_format(($sembuh / $kasus) * 100, 2) . '%':0}}
                                            </td>
                                            <td id="AngkaPersen_2_">
                                                {{$kasus>0?number_format(($meninggal / $kasus) * 100, 2) . '%':0}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable84(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $kasus = $item
                                                                ->filterTable84(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kasus;
                                                            $GrandKasus += $kasus;
                                                        @endphp
                                                        <input type="number" name="kasus"
                                                        id="{{ $item->filterTable84(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kasus }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sembuh = $item
                                                                ->filterTable84(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sembuh;
                                                            $GrandSembuh += $sembuh;
                                                        @endphp
                                                        <input type="number" name="sembuh"
                                                        id="{{ $item->filterTable84(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sembuh }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $meninggal = $item
                                                                ->filterTable84(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->meninggal;
                                                            $GrandMeninggal += $meninggal;
                                                        @endphp
                                                        <input type="number" name="meninggal"
                                                        id="{{ $item->filterTable84(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $meninggal }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="AngkaPersen_1_{{ $item->filterTable84(Session::get('year'), $item->id)->id }}">
                                                        {{$kasus>0?number_format(($sembuh / $kasus) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td id="AngkaPersen_2_{{ $item->filterTable84(Session::get('year'), $item->id)->id }}">
                                                        {{$kasus>0?number_format(($meninggal / $kasus) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole

                                    <tr>
                                        <th colspan="3">Jumlah</th>
                                        <th id="GrandKasus">{{ $GrandKasus }} </th>
                                        <th id="GrandSembuh">{{ $GrandSembuh }} </th>
                                        <th id="GrandMeninggal">{{ $GrandMeninggal }} </th>
                                        <th id="GrandAngkaPersen_1">
                                            {{$GrandKasus>0?number_format(($GrandSembuh / $GrandKasus) * 100, 2) . '%':0}}
                                        </th>
                                        <th id="GrandAngkaPersen_2">
                                            {{$GrandKasus>0?number_format(($GrandMeninggal / $GrandKasus) * 100, 2) . '%':0}}
                                        </th>
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
