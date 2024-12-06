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
                            <li class="breadcrumb-item active">DBD</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table72.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th colspan="9">DEMAM BERDARAH DENGUE (DBD)</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th colspan="3">JUMLAH KASUS</th>
                                        <th colspan="3">MENINGGAL</th>
                                        <th colspan="3">CFR (%)</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + p</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + p</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + p</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandl_kasus = 0;
                                        $Grandp_kasus = 0;
                                        $Grandpl_kasus = 0;
                                        $Grandl_meninggal = 0;
                                        $Grandp_meninggal = 0;
                                        $Grandpl_meninggal = 0;
                                        $Grandl_kasus_meninggal = 0;
                                        $Grandp_kasus_meninggal = 0;
                                        $Grandpl_kasus_meninggal = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $l_kasus = $item->unitKerjaAmbilPart2('filterTable72', Session::get('year'), 'l_kasus')['total'];
                                                    $Grandl_kasus += $l_kasus;
                                                    echo $l_kasus;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $p_kasus = $item->unitKerjaAmbilPart2('filterTable72', Session::get('year'), 'p_kasus')['total'];
                                                    $Grandp_kasus += $p_kasus;
                                                    echo $p_kasus;
                                                @endphp
                                            </td>
                                            <td id="lp_kasus_">
                                                @php
                                                    $Grandpl_kasus += $l_kasus + $p_kasus;
                                                @endphp
                                                {{$l_kasus + $p_kasus}}
                                            </td>
                                            <td>
                                                @php
                                                    $l_meninggal = $item->unitKerjaAmbilPart2('filterTable72', Session::get('year'), 'l_meninggal')['total'];
                                                    $Grandl_meninggal += $l_meninggal;
                                                    echo $l_meninggal;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $p_meninggal = $item->unitKerjaAmbilPart2('filterTable72', Session::get('year'), 'p_meninggal')['total'];
                                                    $Grandp_meninggal += $p_meninggal;
                                                    echo $p_meninggal;
                                                @endphp
                                            </td>
                                            <td id="lp_meninggal_">
                                                @php
                                                    $Grandpl_meninggal += $l_meninggal + $p_meninggal;
                                                @endphp
                                                {{$l_meninggal + $p_meninggal}}
                                            </td>
                                            <td id="l_kasus_meninggal_">
                                                @php
                                                    $Grandl_kasus_meninggal += $l_kasus + $l_meninggal;
                                                @endphp
                                                {{$l_kasus + $l_meninggal}}
                                            </td>
                                            <td id="p_kasus_meninggal_">
                                                @php
                                                    $Grandp_kasus_meninggal += $p_kasus + $p_meninggal;
                                                @endphp
                                                {{$p_kasus + $p_meninggal}}
                                            </td>
                                            <td id="lp_kasus_meninggal_">
                                                @php
                                                    $Grandpl_kasus_meninggal += ($p_kasus + $p_meninggal) + ($l_kasus + $l_meninggal);
                                                @endphp
                                                {{ ($p_kasus + $p_meninggal) + ($l_kasus + $l_meninggal) }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable72(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $l_kasus = $item
                                                                ->filterTable72(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_kasus;
                                                            $Grandl_kasus += $l_kasus;
                                                        @endphp
                                                        <input type="number" name="l_kasus"
                                                        id="{{ $item->filterTable72(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $l_kasus }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_kasus = $item
                                                                ->filterTable72(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->p_kasus;
                                                            $Grandp_kasus += $p_kasus;
                                                        @endphp
                                                        <input type="number" name="p_kasus"
                                                        id="{{ $item->filterTable72(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $p_kasus }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="lp_kasus_{{ $item->filterTable72(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandpl_kasus += $l_kasus + $p_kasus;
                                                        @endphp
                                                        {{$l_kasus + $p_kasus}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $l_meninggal = $item
                                                                ->filterTable72(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_meninggal;
                                                            $Grandl_meninggal += $l_meninggal;
                                                        @endphp
                                                        <input type="number" name="l_meninggal"
                                                        id="{{ $item->filterTable72(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $l_meninggal }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_meninggal = $item
                                                                ->filterTable72(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->p_meninggal;
                                                            $Grandp_meninggal += $p_meninggal;
                                                        @endphp
                                                        <input type="number" name="p_meninggal"
                                                        id="{{ $item->filterTable72(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $p_meninggal }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="lp_meninggal_{{ $item->filterTable72(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandpl_meninggal += $l_meninggal + $p_meninggal;
                                                        @endphp
                                                        {{$l_meninggal + $p_meninggal}}
                                                    </td>
                                                    <td id="l_kasus_meninggal_{{ $item->filterTable72(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandl_kasus_meninggal += $l_kasus + $l_meninggal;
                                                        @endphp
                                                        {{$l_kasus + $l_meninggal}}
                                                    </td>
                                                    <td id="p_kasus_meninggal_{{ $item->filterTable72(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandp_kasus_meninggal += $p_kasus + $p_meninggal;
                                                        @endphp
                                                        {{$p_kasus + $p_meninggal}}
                                                    </td>
                                                    <td id="lp_kasus_meninggal_{{ $item->filterTable72(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandpl_kasus_meninggal += ($p_kasus + $p_meninggal) + ($l_kasus + $l_meninggal);
                                                        @endphp
                                                        {{ ($p_kasus + $p_meninggal) + ($l_kasus + $l_meninggal) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole
                                    <tr>
                                        <th colspan="3">JUMLAH</th>
                                        <th id="Grandl_kasus">{{$Grandl_kasus}}</th>
                                        <th id="Grandp_kasus">{{$Grandp_kasus}}</th>
                                        <th id="Grandpl_kasus">{{$Grandpl_kasus}}</th>
                                        <th id="Grandl_meninggal">{{$Grandl_meninggal}}</th>
                                        <th id="Grandp_meninggal">{{$Grandp_meninggal}}</th>
                                        <th id="Grandpl_meninggal">{{$Grandpl_meninggal}}</th>
                                        <th id="Grandl_kasus_meninggal">{{$Grandl_kasus_meninggal}}</th>
                                        <th id="Grandp_kasus_meninggal">{{$Grandp_kasus_meninggal}}</th>
                                        <th id="Grandpl_kasus_meninggal">{{$Grandpl_kasus_meninggal}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">ANGKA KESAKITAN DBD PER 100.000 PENDUDUK</th>
                                        <th id="angka">{{($Grandpl_kasus / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
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

                        $('#lp_kasus_' + id).text(res.lp_kasus_);
                        $('#lp_meninggal_' + id).text(res.lp_meninggal_);
                        $('#l_kasus_meninggal_' + id).text(res.l_kasus_meninggal_);
                        $('#p_kasus_meninggal_' + id).text(res.p_kasus_meninggal_);
                        $('#lp_kasus_meninggal_' + id).text(res.lp_kasus_meninggal_);

                        $('#Grandl_kasus').text(res.Grandl_kasus);
                        $('#Grandp_kasus').text(res.Grandp_kasus);
                        $('#Grandpl_kasus').text(res.Grandpl_kasus);
                        $('#Grandl_meninggal').text(res.Grandl_meninggal);
                        $('#Grandp_meninggal').text(res.Grandp_meninggal);
                        $('#Grandpl_meninggal').text(res.Grandpl_meninggal);
                        $('#Grandl_kasus_meninggal').text(res.Grandl_kasus_meninggal);
                        $('#Grandp_kasus_meninggal').text(res.Grandp_kasus_meninggal);
                        $('#Grandpl_kasus_meninggal').text(res.Grandpl_kasus_meninggal);

                        $('#angka').text(res.angka);
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
