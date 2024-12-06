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
                                @if(Auth::user()->downloadFile('Table71', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table71" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table71', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table71', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table71" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table71', Session::get('year')) && Auth::user()->downloadFile('Table70', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table70', Session::get('year'))->file_path.Auth::user()->downloadFile('Table70', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table71.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                {{-- @role('Admin|superadmin')
                                <a type="button" class="btn btn-primary" href="{{ route('Table71.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                                @endrole --}}
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
                                        <th rowspan="2" style="vertical-align: middle">No</th>
                                        <th rowspan="2" style="vertical-align: middle; padding-left: 40px; text-align: center; padding-right: 40px;">JENIS KEJADIAN LUAR BIASA
                                        <th colspan="2">YANG TERSERANG</th>
                                        <th colspan="3">WAKTU KEJADIAN (TANGGAL)</th>
                                        <th colspan="3">JUMLAH PENDERITA</th>
                                        <th colspan="12">KELOMPOK UMUR PENDERITA</th>
                                        <th colspan="3">JUMLAH KEMATIAN	</th>
                                        <th colspan="3">JUMLAH PENDUDUK TERANCAM</th>
                                        <th colspan="3">ATTACK RATE (%)</th>
                                        <th colspan="3">CFR (%)</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="2">
                                                <button class="btn btn-success" id="Tambah_Data">+</button>
                                            </th>
                                        @endrole
                                        
                                    </tr>
                                    <tr>
                                        <th>JUMLAH KEC</th>
                                        <th >JUMLAH DESA/KEL</th>

                                        <th>DIKETAHUI</th>
                                        <th>DITANGGULANGI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">AKHIR</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">0-7 HARI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">8-28 HARI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">1-11 BLN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">1-4 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">5-9 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">10-14 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">15-19 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">20-44 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">45-54 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">55-59 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">60-69 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">70+ THN</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                    </tr>
                                </thead>
                                <tbody id="tbody_wripper">
                                    @role('Admin|superadmin')
                                        @foreach ($table71 as $key)
                                            <tr id="data_{{$key->id}}">
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    <input type="text" name="jenis_kejadian" class="form-control data-input" value="{{$key->jenis_kejadian}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="jumlah_kec" class="form-control data-input" value="{{$key->jumlah_kec}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="text" name="jumlah_desa" class="form-control data-input" value="{{$key->jumlah_desa}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="diketahui" class="form-control data-input" value="{{$key->diketahui}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="ditanggulangi" class="form-control data-input" value="{{$key->ditanggulangi}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="akhir" class="form-control data-input" value="{{$key->akhir}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="l_pen" class="form-control data-input" value="{{$key->l_pen}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="p_pen" class="form-control data-input" value="{{$key->p_pen}}" id="{{$key->id}}">
                                                </td>
                                                <td id="lp_pen_{{$key->id}}">
                                                    @php
                                                        $lp_pen_ = $key->l_pen + $key->p_pen;
                                                        echo $lp_pen_;
                                                    @endphp
                                                    {{-- {{number_format(($ditangani_24 / $jumlah) * 100, 2) . '%'}} --}}
                                                </td>
                                                <td>
                                                    <input type="number" name="k_0_7_hari" class="form-control data-input" value="{{$key->k_0_7_hari}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_8_28_hari" class="form-control data-input" value="{{$key->k_8_28_hari}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_1_11_bulan" class="form-control data-input" value="{{$key->k_1_11_bulan}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_1_4_tahun" class="form-control data-input" value="{{$key->k_1_4_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_5_9_tahun" class="form-control data-input" value="{{$key->k_5_9_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_10_14_tahun" class="form-control data-input" value="{{$key->k_10_14_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_15_19_tahun" class="form-control data-input" value="{{$key->k_15_19_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_20_44_tahun" class="form-control data-input" value="{{$key->k_20_44_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_45_54_tahun" class="form-control data-input" value="{{$key->k_45_54_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_55_59_tahun" class="form-control data-input" value="{{$key->k_55_59_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_60_69_tahun" class="form-control data-input" value="{{$key->k_60_69_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="k_70_plus_tahun" class="form-control data-input" value="{{$key->k_70_plus_tahun}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="l_mati" class="form-control data-input" value="{{$key->l_mati}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="p_mati" class="form-control data-input" value="{{$key->p_mati}}" id="{{$key->id}}">
                                                </td>
                                                <td id="lp_mati_{{$key->id}}">
                                                    @php
                                                        $lp_mati_ = $key->l_mati + $key->p_mati;
                                                        echo $lp_mati_;
                                                    @endphp
                                                </td>
                                                <td>
                                                    <input type="number" name="l_penduduk" class="form-control data-input" value="{{$key->l_penduduk}}" id="{{$key->id}}">
                                                </td>
                                                <td>
                                                    <input type="number" name="p_penduduk" class="form-control data-input" value="{{$key->p_penduduk}}" id="{{$key->id}}">
                                                </td>
                                                <td id="lp_penduduk_{{$key->id}}">
                                                    @php
                                                        $lp_penduduk_ = $key->l_penduduk + $key->p_penduduk;
                                                        echo $lp_penduduk_;
                                                    @endphp
                                                </td>
                                                <td id="L_Attack_{{$key->id}}">
                                                    {{number_format(($key->l_pen / $key->l_penduduk) * 100, 2) . '%'}}
                                                </td>
                                                <td id="P_Attack_{{$key->id}}">
                                                    {{number_format(($key->p_pen / $key->p_penduduk) * 100, 2) . '%'}}
                                                </td>
                                                <td id="LP_Attack_{{$key->id}}">
                                                    {{number_format(($lp_pen_ / $lp_penduduk_) * 100, 2) . '%'}}

                                                </td>

                                                <td id="L_CFR_{{$key->id}}">
                                                    {{number_format(($key->l_pen / $key->l_mati) * 100, 2) . '%'}}

                                                </td>
                                                <td id="P_CFR_{{$key->id}}">
                                                    {{number_format(($key->p_pen / $key->p_mati) * 100, 2) . '%'}}

                                                </td>
                                                <td id="LP_CFR_{{$key->id}}">
                                                    {{number_format(($lp_pen_ / $lp_mati_) * 100, 2) . '%'}}


                                                </td>
                                                <td>
                                                    <button class="btn btn-danger hapus_data" id="{{$key->id}}">-</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endrole    
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($table71 as $key)
                                            <tr id="data_{{$key->id}}">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$key->jenis_kejadian}}</td>
                                                <td>{{$key->jumlah_kec}}</td>
                                                <td>{{$key->jumlah_desa}}</td>
                                                <td>{{$key->diketahui}}</td>
                                                <td>{{$key->ditanggulangi}}</td>
                                                <td>{{$key->akhir}}</td>
                                                <td>{{$key->l_pen}}</td>
                                                <td>{{$key->p_pen}}</td>
                                                <td id="lp_pen_{{$key->id}}">
                                                    @php
                                                        $lp_pen_ = $key->l_pen + $key->p_pen;
                                                        echo $lp_pen_;
                                                    @endphp
                                                    {{-- {{number_format(($ditangani_24 / $jumlah) * 100, 2) . '%'}} --}}
                                                </td>
                                                <td>{{$key->k_0_7_hari}}</td>
                                                <td>{{$key->k_8_28_hari}}</td>
                                                <td>{{$key->k_1_11_bulan}}</td>
                                                <td>{{$key->k_1_4_tahun}}</td>
                                                <td>{{$key->k_5_9_tahun}}</td>
                                                <td>{{$key->k_10_14_tahun}}</td>
                                                <td>{{$key->k_15_19_tahun}}</td>
                                                <td>{{$key->k_20_44_tahun}}</td>
                                                <td>{{$key->k_45_54_tahun}}</td>
                                                <td>{{$key->k_55_59_tahun}}</td>
                                                <td>{{$key->k_60_69_tahun}}</td>
                                                <td>{{$key->k_70_plus_tahun}}</td>
                                                <td>{{$key->l_mati}}</td>
                                                <td>{{$key->p_mati}}</td>
                                                <td id="lp_mati_{{$key->id}}">
                                                    @php
                                                        $lp_mati_ = $key->l_mati + $key->p_mati;
                                                        echo $lp_mati_;
                                                    @endphp
                                                </td>
                                                <td>{{$key->l_penduduk}}</td>
                                                <td>{{$key->p_penduduk}}</td>
                                                <td id="lp_penduduk_{{$key->id}}">
                                                    @php
                                                        $lp_penduduk_ = $key->l_penduduk + $key->p_penduduk;
                                                        echo $lp_penduduk_;
                                                    @endphp
                                                </td>
                                                <td id="L_Attack_{{$key->id}}">
                                                    {{$key->l_penduduk>0?number_format(($key->l_pen / $key->l_penduduk) * 100, 2) . '%':0}}
                                                </td>
                                                <td id="P_Attack_{{$key->id}}">
                                                    {{$key->p_penduduk>0?number_format(($key->p_pen / $key->p_penduduk) * 100, 2) . '%':0}}
                                                </td>
                                                <td id="LP_Attack_{{$key->id}}">
                                                    {{$lp_penduduk_>0?number_format(($lp_pen_ / $lp_penduduk_) * 100, 2) . '%':0}}

                                                </td>

                                                <td id="L_CFR_{{$key->id}}">
                                                    {{$key->l_mati>0?number_format(($key->l_pen / $key->l_mati) * 100, 2) . '%':0}}

                                                </td>
                                                <td id="P_CFR_{{$key->id}}">
                                                    {{$key->p_mati>0?number_format(($key->p_pen / $key->p_mati) * 100, 2) . '%':0}}

                                                </td>
                                                <td id="LP_CFR_{{$key->id}}">
                                                    {{$lp_mati_>0?number_format(($lp_pen_ / $lp_mati_) * 100, 2) . '%':0}}
                                                </td>
                                            </tr>
                                        @endforeach
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
            $('#Tambah_Data').click(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'type': 'POST',
                    'url': '{{ url($route) }}',
                    'data': {
                        'name': '1',
                    },
                    success: function(res) {
                        console.log(res);
                        let lp_pen_ = parseInt(res.data.l_pen) + parseInt(res.data.p_pen);
                        let lp_mati = parseInt(res.data.l_mati) + parseInt(res.data.p_mati);
                        let lp_penduduk = parseInt(res.data.l_penduduk) + parseInt(res.data.p_penduduk);

                        let L_Attack_ = (parseInt(res.data.l_pen) / parseInt(res.data.l_penduduk)) * 100;
                        let P_Attack_ = (parseInt(res.data.p_pen) / parseInt(res.data.l_penduduk)) * 100;
                        let LP_Attack_ = (lp_pen_ / lp_penduduk) * 100;

                        let L_CFR_ = (parseInt(res.data.l_mati) / parseInt(res.data.l_penduduk)) * 100;
                        let P_CFR_ = (parseInt(res.data.p_mati) / parseInt(res.data.l_penduduk)) * 100;
                        let LP_CFR_ = (lp_mati / lp_penduduk) * 100;
                        let tbody_append = `<tr id="data_`+ res.data.id +`">
                                <td>`+ res.count +`</td>
                                <td>
                                    <input type="text" name="jenis_kejadian" class="form-control data-input" value="`+ res.data.jenis_kejadian +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="text" name="jumlah_kec" class="form-control data-input" value="`+ res.data.jumlah_kec +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="text" name="jumlah_desa" class="form-control data-input" value="`+ res.data.jumlah_desa +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="diketahui" class="form-control data-input" value="`+ res.data.diketahui +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="ditanggulangi" class="form-control data-input" value="`+ res.data.ditanggulangi +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="akhir" class="form-control data-input" value="`+ res.data.akhir +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="l_pen" class="form-control data-input" value="`+ res.data.l_pen +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="p_pen" class="form-control data-input" value="`+ res.data.p_pen +`" id="`+ res.data.id +`">
                                </td>
                                <td id="lp_pen_`+ res.data.id +`">
                                    `+ (lp_pen_) +`
                                </td>
                                <td>
                                    <input type="number" name="k_0_7_hari" class="form-control data-input" value="`+ res.data.k_0_7_hari +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_8_28_hari" class="form-control data-input" value="`+ res.data.k_8_28_hari +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_1_11_bulan" class="form-control data-input" value="`+ res.data.k_1_11_bulan +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_1_4_tahun" class="form-control data-input" value="`+ res.data.k_1_4_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_5_9_tahun" class="form-control data-input" value="`+ res.data.k_5_9_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_10_14_tahun" class="form-control data-input" value="`+ res.data.k_10_14_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_15_19_tahun" class="form-control data-input" value="`+ res.data.k_15_19_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_20_44_tahun" class="form-control data-input" value="`+ res.data.k_20_44_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_45_54_tahun" class="form-control data-input" value="`+ res.data.k_45_54_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_55_59_tahun" class="form-control data-input" value="`+ res.data.k_55_59_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_60_69_tahun" class="form-control data-input" value="`+ res.data.k_60_69_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="k_70_plus_tahun" class="form-control data-input" value="`+ res.data.k_70_plus_tahun +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="l_mati" class="form-control data-input" value="`+ res.data.l_mati +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="p_mati" class="form-control data-input" value="`+ res.data.p_mati +`" id="`+ res.data.id +`">
                                </td>
                                <td id="lp_mati_`+ res.data.id +`">
                                    `+ (lp_mati) +`
                                </td>
                                <td>
                                    <input type="number" name="l_penduduk" class="form-control data-input" value="`+ res.data.l_penduduk +`" id="`+ res.data.id +`">
                                </td>
                                <td>
                                    <input type="number" name="p_penduduk" class="form-control data-input" value="`+ res.data.p_penduduk +`" id="`+ res.data.id +`">
                                </td>
                                <td id="lp_penduduk_`+ res.data.id +`">
                                    `+ (lp_penduduk) +`
                                </td>
                                <td id="L_Attack_`+ res.data.id +`">
                                    `+ L_Attack_.toFixed(2) +`%
                                </td>
                                <td id="P_Attack_`+ res.data.id +`">
                                    `+ P_Attack_.toFixed(2) +`%
                                </td>
                                <td id="LP_Attack_`+ res.data.id +`">
                                    `+ LP_Attack_.toFixed(2) +`%
                                </td>

                                <td id="L_CFR_`+ res.data.id +`">
                                    `+ L_CFR_.toFixed(2) +`%
                                </td>
                                <td id="P_CFR_`+ res.data.id +`">
                                    `+ P_CFR_.toFixed(2) +`%
                                </td>
                                <td id="LP_CFR_`+ res.data.id +`">
                                    `+ LP_CFR_.toFixed(2) +`%
                                </td>
                                <td>
                                    <button class="btn btn-danger hapus_data" id="`+ res.data.id +`">-</button>
                                </td>
                            </tr>`;

                            $('#tbody_wripper').append(tbody_append);
                    }
                });
            });

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
                    'type': 'PUT',
                    'url': '{{ url($route) }}/' + id,
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

            $(document).on('click', '.hapus_data', function(e) {
                e.preventDefault();
                if(confirm('Apakah anda yakin akan menghapus ini?')) {
                    let id = $(this).attr('id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'type': 'DELETE',
                        'url': '{{ url($route) }}/' + id,
                        success: function(res) {
                            console.log(res);
                            $('#data_' + res.id).remove();
                        }
                    });
                }
            });



            $("#filter").click(function() {
                let year = $("#tahun").val();
                window.location.href = "{{ url($route) }}?year=" + year;
            })
        </script>
    @endpush
@endsection
