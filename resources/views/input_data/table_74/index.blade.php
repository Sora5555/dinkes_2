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
                            <li class="breadcrumb-item active">PENDERITA KRONIS FILARIASIS</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table74.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th colspan="15">PENDERITA KRONIS FILARIASIS</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th colspan="3">KASUS KRONIS TAHUN SEBELUMNYA</th>
                                        <th colspan="3">KASUS KRONIS BARU DITEMUKAN</th>
                                        <th colspan="3">KASUS KRONIS PINDAH</th>
                                        <th colspan="3">KASUS KRONIS MENINGGAL</th>
                                        <th colspan="3">JUMLAH SELURUH KASUS KRONIS</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + P</th>

                                        <th>L</th>
                                        <th>P</th>
                                        <th>L + P</th>

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
                                        $Grandkronis_t_sebelumnya_l = 0;
                                        $Grandkronis_t_sebelumnya_p = 0;
                                        $Grandkronis_t_sebelumnya_pl_ = 0;
                                        $Grandkronis_b_ditemukan_l = 0;
                                        $Grandkronis_b_ditemukan_p = 0;
                                        $Grandkronis_b_ditemukan_pl_ = 0;
                                        $Grandkronis_pindah_l = 0;
                                        $Grandkronis_pindah_p = 0;
                                        $Grandkronis_pindah_pl_ = 0;
                                        $Grandkronis_meninggal_l = 0;
                                        $Grandkronis_meninggal_p = 0;
                                        $Grandkronis_meninggal_pl_ = 0;
                                        $Grandjumlah_seluruh_kasus_l_ = 0;
                                        $Grandjumlah_seluruh_kasus_p_ = 0;
                                        $Grandjumlah_seluruh_kasus_pl_ = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $kronis_t_sebelumnya_l = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_t_sebelumnya_l')['total'];
                                                        $Grandkronis_t_sebelumnya_l += $kronis_t_sebelumnya_l;

                                                        echo $kronis_t_sebelumnya_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kronis_t_sebelumnya_p = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_t_sebelumnya_p')['total'];

                                                        $Grandkronis_t_sebelumnya_p += $kronis_t_sebelumnya_p;
                                                        echo $kronis_t_sebelumnya_p;
                                                @endphp
                                            </td>
                                            <td id="kronis_t_sebelumnya_pl_">
                                                @php
                                                    $kronis_t_sebelumnya_pl_ = $kronis_t_sebelumnya_l + $kronis_t_sebelumnya_p;
                                                    echo $kronis_t_sebelumnya_pl_;
                                                    $Grandkronis_t_sebelumnya_pl_ += $kronis_t_sebelumnya_pl_;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kronis_b_ditemukan_l = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_b_ditemukan_l')['total'];
                                                    $Grandkronis_b_ditemukan_l += $kronis_b_ditemukan_l;
                                                    echo $kronis_b_ditemukan_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kronis_b_ditemukan_p = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_b_ditemukan_p')['total'];
                                                        $Grandkronis_b_ditemukan_p += $kronis_b_ditemukan_p;
                                                        echo $kronis_b_ditemukan_p;
                                                @endphp
                                            </td>
                                            <td id="kronis_b_ditemukan_pl_">
                                                @php
                                                    $kronis_b_ditemukan_pl_ = $kronis_b_ditemukan_l + $kronis_b_ditemukan_p;
                                                    echo $kronis_b_ditemukan_pl_;
                                                    $Grandkronis_b_ditemukan_pl_ += $kronis_b_ditemukan_pl_;
                                                @endphp
                                            </td>

                                            <td>
                                                @php
                                                    $kronis_pindah_l = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_pindah_l')['total'];
                                                    $kronis_pindah_l += $kronis_pindah_l;
                                                    $Grandkronis_pindah_l += $kronis_pindah_l;
                                                    echo $kronis_pindah_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kronis_pindah_p = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_pindah_p')['total'];
                                                        $Grandkronis_pindah_p += $kronis_pindah_p;
                                                        echo $kronis_pindah_p;
                                                @endphp
                                            </td>
                                            <td id="kronis_pindah_pl_">
                                                @php
                                                    $kronis_pindah_pl_ = $kronis_pindah_l + $kronis_pindah_p;
                                                    echo $kronis_pindah_pl_;
                                                    $Grandkronis_pindah_pl_ += $kronis_pindah_pl_;
                                                @endphp
                                            </td>

                                            <td>
                                                @php
                                                    $kronis_meninggal_l = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_meninggal_l')['total'];
                                                    echo $kronis_meninggal_l;
                                                    $Grandkronis_meninggal_l += $kronis_meninggal_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kronis_meninggal_p = $item->unitKerjaAmbilPart2('filterTable74', Session::get('year'), 'kronis_meninggal_p')['total'];
                                                    $Grandkronis_meninggal_p += $kronis_meninggal_p;
                                                    echo $kronis_meninggal_p;
                                                @endphp
                                            </td>
                                            <td id="kronis_meninggal_pl_">
                                                @php
                                                    $kronis_meninggal_pl_ = $kronis_meninggal_l + $kronis_meninggal_p;
                                                    echo $kronis_meninggal_pl_;
                                                    $Grandkronis_meninggal_pl_ += $kronis_meninggal_pl_;
                                                @endphp
                                            </td>

                                            <td id="jumlah_seluruh_kasus_l_">
                                                @php
                                                $jumlah_seluruh_kasus_l_ = $kronis_t_sebelumnya_l + $kronis_b_ditemukan_l + $kronis_pindah_l + $kronis_meninggal_l;
                                                echo $jumlah_seluruh_kasus_l_;
                                                $Grandjumlah_seluruh_kasus_l_ += $jumlah_seluruh_kasus_l_;
                                            @endphp
                                            </td>
                                            <td id="jumlah_seluruh_kasus_p_">
                                                @php
                                                $jumlah_seluruh_kasus_p_ = $kronis_t_sebelumnya_p + $kronis_b_ditemukan_p + $kronis_pindah_p + $kronis_meninggal_p;
                                                echo $jumlah_seluruh_kasus_p_;
                                                $Grandjumlah_seluruh_kasus_p_ += $jumlah_seluruh_kasus_p_;
                                            @endphp
                                            </td>
                                            <td id="jumlah_seluruh_kasus_pl_">
                                                @php
                                                $jumlah_seluruh_kasus_pl_ = $jumlah_seluruh_kasus_l_ + $jumlah_seluruh_kasus_p_;
                                                echo $jumlah_seluruh_kasus_pl_;
                                                $Grandjumlah_seluruh_kasus_pl_ += $jumlah_seluruh_kasus_pl_;

                                            @endphp
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable74(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $kronis_t_sebelumnya_l = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_t_sebelumnya_l;
                                                                $Grandkronis_t_sebelumnya_l += $kronis_t_sebelumnya_l;
                                                        @endphp
                                                        <input type="number" name="kronis_t_sebelumnya_l"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_t_sebelumnya_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kronis_t_sebelumnya_p = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_t_sebelumnya_p;

                                                                $Grandkronis_t_sebelumnya_p += $kronis_t_sebelumnya_p;
                                                        @endphp
                                                        <input type="number" name="kronis_t_sebelumnya_p"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_t_sebelumnya_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="kronis_t_sebelumnya_pl_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $kronis_t_sebelumnya_pl_ = $kronis_t_sebelumnya_l + $kronis_t_sebelumnya_p;
                                                            echo $kronis_t_sebelumnya_pl_;
                                                            $Grandkronis_t_sebelumnya_pl_ += $kronis_t_sebelumnya_pl_;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kronis_b_ditemukan_l = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_b_ditemukan_l;
                                                            $Grandkronis_b_ditemukan_l += $kronis_b_ditemukan_l;
                                                        @endphp
                                                        <input type="number" name="kronis_b_ditemukan_l"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_b_ditemukan_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kronis_b_ditemukan_p = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_b_ditemukan_p;
                                                                $Grandkronis_b_ditemukan_p += $kronis_b_ditemukan_p;
                                                        @endphp
                                                        <input type="number" name="kronis_b_ditemukan_p"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_b_ditemukan_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="kronis_b_ditemukan_pl_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $kronis_b_ditemukan_pl_ = $kronis_b_ditemukan_l + $kronis_b_ditemukan_p;
                                                            echo $kronis_b_ditemukan_pl_;
                                                            $Grandkronis_b_ditemukan_pl_ += $kronis_b_ditemukan_pl_;
                                                        @endphp
                                                    </td>

                                                    <td>
                                                        @php
                                                            $kronis_pindah_l = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_pindah_l;
                                                            $kronis_pindah_l += $kronis_pindah_l;
                                                            $Grandkronis_pindah_l += $kronis_pindah_l;
                                                        @endphp
                                                        <input type="number" name="kronis_pindah_l"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_pindah_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kronis_pindah_p = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_pindah_p;
                                                                $Grandkronis_pindah_p += $kronis_pindah_p;
                                                        @endphp
                                                        <input type="number" name="kronis_pindah_p"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_pindah_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="kronis_pindah_pl_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $kronis_pindah_pl_ = $kronis_pindah_l + $kronis_pindah_p;
                                                            echo $kronis_pindah_pl_;
                                                            $Grandkronis_pindah_pl_ += $kronis_pindah_pl_;
                                                        @endphp
                                                    </td>

                                                    <td>
                                                        @php
                                                            $kronis_meninggal_l = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_meninggal_l;
                                                            $Grandkronis_meninggal_l += $kronis_meninggal_l;
                                                        @endphp
                                                        <input type="number" name="kronis_meninggal_l"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_meninggal_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kronis_meninggal_p = $item
                                                                ->filterTable74(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kronis_meninggal_p;
                                                            $Grandkronis_meninggal_p += $kronis_meninggal_p;
                                                        @endphp
                                                        <input type="number" name="kronis_meninggal_p"
                                                        id="{{ $item->filterTable74(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kronis_meninggal_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="kronis_meninggal_pl_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $kronis_meninggal_pl_ = $kronis_meninggal_l + $kronis_meninggal_p;
                                                            echo $kronis_meninggal_pl_;
                                                            $Grandkronis_meninggal_pl_ += $kronis_meninggal_pl_;
                                                        @endphp
                                                    </td>

                                                    <td id="jumlah_seluruh_kasus_l_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                        $jumlah_seluruh_kasus_l_ = $kronis_t_sebelumnya_l + $kronis_b_ditemukan_l + $kronis_pindah_l + $kronis_meninggal_l;
                                                        echo $jumlah_seluruh_kasus_l_;
                                                        $Grandjumlah_seluruh_kasus_l_ += $jumlah_seluruh_kasus_l_;
                                                    @endphp
                                                    </td>
                                                    <td id="jumlah_seluruh_kasus_p_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                        $jumlah_seluruh_kasus_p_ = $kronis_t_sebelumnya_p + $kronis_b_ditemukan_p + $kronis_pindah_p + $kronis_meninggal_p;
                                                        echo $jumlah_seluruh_kasus_p_;
                                                        $Grandjumlah_seluruh_kasus_p_ += $jumlah_seluruh_kasus_p_;
                                                    @endphp
                                                    </td>
                                                    <td id="jumlah_seluruh_kasus_pl_{{ $item->filterTable74(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                        $jumlah_seluruh_kasus_pl_ = $jumlah_seluruh_kasus_l_ + $jumlah_seluruh_kasus_p_;
                                                        echo $jumlah_seluruh_kasus_pl_;
                                                        $Grandjumlah_seluruh_kasus_pl_ += $jumlah_seluruh_kasus_pl_;

                                                    @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        <tr>
                                            <th colspan="3">JUMLAH</th>
                                            <th id="Grandkronis_t_sebelumnya_l">{{ $Grandkronis_t_sebelumnya_l }} </th>
                                            <th id="Grandkronis_t_sebelumnya_p">{{ $Grandkronis_t_sebelumnya_p }} </th>
                                            <th id="Grandkronis_t_sebelumnya_pl_">{{ $Grandkronis_t_sebelumnya_pl_ }} </th>
                                            <th id="Grandkronis_b_ditemukan_l">{{ $Grandkronis_b_ditemukan_l }} </th>
                                            <th id="Grandkronis_b_ditemukan_p">{{ $Grandkronis_b_ditemukan_p }} </th>
                                            <th id="Grandkronis_b_ditemukan_pl_">{{ $Grandkronis_b_ditemukan_pl_ }} </th>
                                            <th id="Grandkronis_pindah_l">{{ $Grandkronis_pindah_l }} </th>
                                            <th id="Grandkronis_pindah_p">{{ $Grandkronis_pindah_p }} </th>
                                            <th id="Grandkronis_pindah_pl_">{{ $Grandkronis_pindah_pl_ }} </th>
                                            <th id="Grandkronis_meninggal_l">{{ $Grandkronis_meninggal_l }} </th>
                                            <th id="Grandkronis_meninggal_p">{{ $Grandkronis_meninggal_p }} </th>
                                            <th id="Grandkronis_meninggal_pl_">{{ $Grandkronis_meninggal_pl_ }} </th>
                                            <th id="Grandjumlah_seluruh_kasus_l_">{{ $Grandjumlah_seluruh_kasus_l_ }} </th>
                                            <th id="Grandjumlah_seluruh_kasus_p_">{{ $Grandjumlah_seluruh_kasus_p_ }} </th>
                                            <th id="Grandjumlah_seluruh_kasus_pl_">{{ $Grandjumlah_seluruh_kasus_pl_ }} </th>
                                        </tr>
                                    @endrole
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
