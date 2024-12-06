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
                            <li class="breadcrumb-item active">CAKUPAN VAKSINASI COVID-19 DOSIS 1</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table86.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                        <div class="table-responsive">
                            <table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle">No</th>
                                        <th rowspan="2" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="2" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="2" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="3">USIA 6-11 TAHUN</th>
                                        <th colspan="3">USIA 12-17 TAHUN</th>
                                        <th colspan="3">USIA 18-59 TAHUN</th>
                                        <th colspan="3">USIA > 60 TAHUN</th>
                                        <th colspan="3">CAKUPAN TOTAL</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="2">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th>SASARAN</th>
                                        <th>HASIL VAKSINASI</th>
                                        <th>%</th>
                                        <th>SASARAN</th>
                                        <th>HASIL VAKSINASI</th>
                                        <th>%</th>
                                        <th>SASARAN</th>
                                        <th>HASIL VAKSINASI</th>
                                        <th>%</th>
                                        <th>SASARAN</th>
                                        <th>HASIL VAKSINASI</th>
                                        <th>%</th>
                                        <th>SASARAN</th>
                                        <th>HASIL VAKSINASI</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandsasaran_6_11 = 0;
                                        $Grandhasil_vaksinasi_6_11 = 0;
                                        $Grandsasaran_12_17 = 0;
                                        $Grandhasil_vaksinasi_12_17 = 0;
                                        $Grandsasaran_18_59 = 0;
                                        $Grandhasil_vaksinasi_18_59 = 0;
                                        $Grandsasaran_60_up = 0;
                                        $Grandhasil_vaksinasi_60_up = 0;
                                        $Grandtotal_sasaran = 0;
                                        $Grandtotal_hasil_vaksinasi = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $sasaran_6_11 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'sasaran_6_11')['total'];
                                                    $Grandsasaran_6_11 += $sasaran_6_11;

                                                    echo $sasaran_6_11;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hasil_vaksinasi_6_11 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'hasil_vaksinasi_6_11')['total'];
                                                    $Grandhasil_vaksinasi_6_11 += $hasil_vaksinasi_6_11;

                                                    echo $hasil_vaksinasi_6_11;
                                                @endphp
                                            </td>
                                            <td id="persen_6_11_">
                                                {{ $sasaran_6_11>0?number_format(($hasil_vaksinasi_6_11 / $sasaran_6_11) * 100, 2) . '%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $sasaran_12_17 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'sasaran_12_17')['total'];
                                                    $Grandsasaran_12_17 += $sasaran_12_17;

                                                    echo $sasaran_12_17;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hasil_vaksinasi_12_17 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'hasil_vaksinasi_12_17')['total'];
                                                    $Grandhasil_vaksinasi_12_17 += $hasil_vaksinasi_12_17;

                                                    echo $hasil_vaksinasi_12_17;
                                                @endphp
                                            </td>
                                            <td id="persen_12_17_">
                                                {{ $sasaran_12_17>0?number_format(($hasil_vaksinasi_12_17 / $sasaran_12_17) * 100, 2) . '%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $sasaran_18_59 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'sasaran_18_59')['total'];
                                                    $Grandsasaran_18_59 += $sasaran_18_59;

                                                    echo $sasaran_18_59;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hasil_vaksinasi_18_59 = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'hasil_vaksinasi_18_59')['total'];
                                                    $Grandhasil_vaksinasi_18_59 += $hasil_vaksinasi_18_59;
                                                    echo $hasil_vaksinasi_18_59;
                                                @endphp
                                            </td>
                                            <td id="persen_18_59_">
                                                {{ $sasaran_18_59>0?number_format(($hasil_vaksinasi_18_59 / $sasaran_18_59) * 100, 2) . '%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $sasaran_60_up = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'sasaran_60_up')['total'];
                                                    $Grandsasaran_60_up += $sasaran_60_up;
                                                    echo $sasaran_60_up;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hasil_vaksinasi_60_up = $item->unitKerjaAmbilPart2('filterTable86', Session::get('year'), 'hasil_vaksinasi_60_up')['total'];
                                                    $Grandhasil_vaksinasi_60_up += $hasil_vaksinasi_60_up;
                                                    echo $hasil_vaksinasi_60_up;
                                                @endphp
                                            </td>
                                            <td id="persen_60_up_">
                                                {{ $sasaran_60_up>0?number_format(($hasil_vaksinasi_60_up / $sasaran_60_up) * 100, 2) . '%':0 }}
                                            </td>

                                            <td id="total_sasaran_">
                                                @php
                                                    $total_sasaran_ = $sasaran_6_11 + $sasaran_12_17 + $sasaran_18_59 + $sasaran_60_up;
                                                    echo $total_sasaran_;
                                                    $Grandtotal_sasaran += $total_sasaran_;
                                                @endphp
                                            </td>
                                            <td id="total_hasil_vaksinasi_">
                                                @php
                                                    $total_hasil_vaksinasi_ = $hasil_vaksinasi_6_11 + $hasil_vaksinasi_12_17 + $hasil_vaksinasi_18_59 + $hasil_vaksinasi_60_up;
                                                    echo $total_hasil_vaksinasi_;
                                                    $Grandtotal_hasil_vaksinasi += $total_hasil_vaksinasi_;
                                                @endphp
                                            </td>
                                            <td id="total_persen_">
                                                {{ $total_sasaran_>0?number_format(($total_hasil_vaksinasi_ / $total_sasaran_) * 100, 2) . '%':0 }}
                                            </td>

                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable86(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $sasaran_6_11 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sasaran_6_11;
                                                            $Grandsasaran_6_11 += $sasaran_6_11;
                                                        @endphp
                                                        <input type="number" name="sasaran_6_11"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sasaran_6_11 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hasil_vaksinasi_6_11 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hasil_vaksinasi_6_11;
                                                            $Grandhasil_vaksinasi_6_11 += $hasil_vaksinasi_6_11;
                                                        @endphp
                                                        <input type="number" name="hasil_vaksinasi_6_11"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hasil_vaksinasi_6_11 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_6_11_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        {{ $sasaran_6_11>0?number_format(($hasil_vaksinasi_6_11 / $sasaran_6_11) * 100, 2) . '%':0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sasaran_12_17 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sasaran_12_17;
                                                            $Grandsasaran_12_17 += $sasaran_12_17;
                                                        @endphp
                                                        <input type="number" name="sasaran_12_17"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sasaran_12_17 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hasil_vaksinasi_12_17 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hasil_vaksinasi_12_17;
                                                            $Grandhasil_vaksinasi_12_17 += $hasil_vaksinasi_12_17;
                                                        @endphp
                                                        <input type="number" name="hasil_vaksinasi_12_17"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hasil_vaksinasi_12_17 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_12_17_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        {{ $sasaran_12_17>0?number_format(($hasil_vaksinasi_12_17 / $sasaran_12_17) * 100, 2) . '%':0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sasaran_18_59 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sasaran_18_59;
                                                            $Grandsasaran_18_59 += $sasaran_18_59;
                                                        @endphp
                                                        <input type="number" name="sasaran_18_59"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sasaran_18_59 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hasil_vaksinasi_18_59 = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hasil_vaksinasi_18_59;
                                                            $Grandhasil_vaksinasi_18_59 += $hasil_vaksinasi_18_59;
                                                        @endphp
                                                        <input type="number" name="hasil_vaksinasi_18_59"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hasil_vaksinasi_18_59 }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_18_59_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        {{ $sasaran_18_59>0?number_format(($hasil_vaksinasi_18_59 / $sasaran_18_59) * 100, 2) . '%':0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sasaran_60_up = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sasaran_60_up;
                                                            $Grandsasaran_60_up += $sasaran_60_up;
                                                        @endphp
                                                        <input type="number" name="sasaran_60_up"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sasaran_60_up }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hasil_vaksinasi_60_up = $item
                                                                ->filterTable86(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hasil_vaksinasi_60_up;
                                                            $Grandhasil_vaksinasi_60_up += $hasil_vaksinasi_60_up;
                                                        @endphp
                                                        <input type="number" name="hasil_vaksinasi_60_up"
                                                        id="{{ $item->filterTable86(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hasil_vaksinasi_60_up }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_60_up_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        {{ $sasaran_60_up>0?number_format(($hasil_vaksinasi_60_up / $sasaran_60_up) * 100, 2) . '%':0 }}
                                                    </td>

                                                    <td id="total_sasaran_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $total_sasaran_ = $sasaran_6_11 + $sasaran_12_17 + $sasaran_18_59 + $sasaran_60_up;
                                                            echo $total_sasaran_;
                                                            $Grandtotal_sasaran += $total_sasaran_;
                                                        @endphp
                                                    </td>
                                                    <td id="total_hasil_vaksinasi_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $total_hasil_vaksinasi_ = $hasil_vaksinasi_6_11 + $hasil_vaksinasi_12_17 + $hasil_vaksinasi_18_59 + $hasil_vaksinasi_60_up;
                                                            echo $total_hasil_vaksinasi_;
                                                            $Grandtotal_hasil_vaksinasi += $total_hasil_vaksinasi_;
                                                        @endphp
                                                    </td>
                                                    <td id="total_persen_{{ $item->filterTable86(Session::get('year'), $item->id)->id }}">
                                                        {{ $total_sasaran_>0?number_format(($total_hasil_vaksinasi_ / $total_sasaran_) * 100, 2) . '%':0 }}
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole

                                    <tr>
                                        <th colspan="3">Jumlah</th>
                                        <th id="Grandsasaran_6_11">{{ $Grandsasaran_6_11 }} </th>
                                        <th id="Grandhasil_vaksinasi_6_11">{{ $Grandhasil_vaksinasi_6_11 }} </th>
                                        <th id="Grandpersen_6_11">
                                            {{ $Grandsasaran_6_11>0?number_format(($Grandhasil_vaksinasi_6_11 / $Grandsasaran_6_11) * 100, 2) . '%':0 }}
                                        </th>
                                        <th id="Grandsasaran_12_17">{{ $Grandsasaran_12_17 }} </th>
                                        <th id="Grandhasil_vaksinasi_12_17">{{ $Grandhasil_vaksinasi_12_17 }} </th>
                                        <th id="Grandpersen_12_17">
                                            {{ $Grandsasaran_12_17>0?number_format(($Grandhasil_vaksinasi_12_17 / $Grandsasaran_12_17) * 100, 2) . '%':0 }}
                                        </th>
                                        <th id="Grandsasaran_18_59">{{ $Grandsasaran_18_59 }} </th>
                                        <th id="Grandhasil_vaksinasi_18_59">{{ $Grandhasil_vaksinasi_18_59 }} </th>
                                        <th id="Grandpersen_18_59">
                                            {{ $Grandsasaran_18_59>0?number_format(($Grandhasil_vaksinasi_18_59 / $Grandsasaran_18_59) * 100, 2) . '%':0 }}
                                        </th>
                                        <th id="Grandsasaran_60_up">{{ $Grandsasaran_60_up }} </th>
                                        <th id="Grandhasil_vaksinasi_60_up">{{ $Grandhasil_vaksinasi_60_up }} </th>
                                        <th id="Grandpersen_60_up">
                                            {{ $Grandsasaran_60_up>0?number_format(($Grandhasil_vaksinasi_60_up / $Grandsasaran_60_up) * 100, 2) . '%':0 }}
                                        </th>
                                        <th id="Grandtotal_sasaran">{{ $Grandtotal_sasaran }}</th>
                                        <th id="Grandtotal_hasil_vaksinasi">{{ $Grandtotal_hasil_vaksinasi }}</th>
                                        <th id="Grandtotal_persen">
                                            {{ $Grandtotal_sasaran>0?number_format(($Grandtotal_hasil_vaksinasi / $Grandtotal_sasaran) * 100, 2) . '%':0 }}
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
