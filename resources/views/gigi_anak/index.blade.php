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
                        <li class="breadcrumb-item active">{{$title}}</li>
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
                        <div class="col-md-10 d-flex justify-content-around gap-3">
                            @if(Auth::user()->downloadFile('GigiAnak', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="GigiAnak" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('GigiAnak', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('GigiAnak', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="GigiAnak" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('GigiAnak', Session::get('year')) && Auth::user()->downloadFile('GigiAnak', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('GigiAnak', Session::get('year'))->file_path.Auth::user()->downloadFile('GigiAnak', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('GigiAnak.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('GigiAnak.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th colspan="23">Usaha Kesehatan Gigi Sekolah (UKGS)</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Lock data</th>
                                <th rowspan="3">Lock upload</th>
                                <th rowspan="3">File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th rowspan="2">Jumlah SD/MI</th>
                                <th rowspan="2">Jumlah SD/MI dengan Sikat Gigi Massal</th>
                                <th rowspan="2">%</th>
                                <th rowspan="2">Jumlah SD/MI mendapat Yan. Gigi</th>
                                <th rowspan="2">%</th>
                                <th colspan="3">Jumlah Murid SD/MI</th>
                                <th colspan="6">Murid SD/MI Diperiksa</th>
                                <th colspan="3">Murid SD/MI Perlu Perawatan</th>
                                <th colspan="6">Murid SD/MI Mendapat Perawatan</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
                                <th>L</th>
                                <th>%</th>
                                <th>P</th>
                                <th>%</th>
                                <th>L+P</th>
                                <th>%</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
                                <th>L</th>
                                <th>%</th>
                                <th>P</th>
                                <th>%</th>
                                <th>L+P</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sikat')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sikat')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] * 100, 2
                                        ):0}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_yan')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_yan')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'jumlah_sd')["total"] * 100, 2
                                        ):0}}</td>

                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] * 100, 2
                                        ):0}}</td>
                                  
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"]> 0?
                                        number_format(($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'diperiksa_P')["total"])
                                        /($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'sd_P')["total"]) * 100, 2
                                        ):0}}</td>

                                    
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"]
                                        /$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] * 100, 2
                                        ):0}}</td>
                                  
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"]> 0?
                                        number_format(($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'dapat_P')["total"])
                                        /($item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_L')["total"] + $item->unitKerjaAmbil('filterGigiAnak', Session::get('year'), 'rawat_P')["total"]) * 100, 2
                                        ):0}}</td>
                                        <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterGigiAnak') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                        @if(isset($item->user) && $item->user->downloadFile('GigiAnak', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('GigiAnak', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @elseif(isset($item->user) && !$item->user->downloadFile('GigiAnak', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        @if(isset($item->user) && $item->user->hasFile('GigiAnak', Session::get('year')))
                                        <td>
                                            @if($item->user->downloadFile('GigiAnak', Session::get('year'))->file_name != "-")
                                            <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('GigiAnak', Session::get('year'))->file_path.$item->user->downloadFile('GigiAnak', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        <td style="white-space: nowrap"><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td>         

                                    
                                    
                                    
                                    
                                    
                                </tr>
                                @endforeach
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterGigiAnak(Session::get('year')))
                                @php
                                $filterResult = $item->filterGigiAnak(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td><input type="number" {{$isDisabled}} name="jumlah_sd" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->jumlah_sd}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="jumlah_sikat" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->jumlah_sikat}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="sikat{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->jumlah_sd>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->jumlah_sikat
                                        /$item->filterGigiAnak(Session::get('year'))->jumlah_sd * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="jumlah_yan" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->jumlah_yan}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="yan{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->jumlah_sd>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->jumlah_yan
                                        /$item->filterGigiAnak(Session::get('year'))->jumlah_sd * 100, 2):0}}</td>

                                    <td><input type="number" {{$isDisabled}} name="sd_L" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->sd_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="sd_P" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->sd_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="sd_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->sd_L + $item->filterGigiAnak(Session::get('year'))->sd_P}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="diperiksa_L" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->diperiksa_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="diperiksa_L{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->sd_L>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->diperiksa_L
                                        /$item->filterGigiAnak(Session::get('year'))->sd_L * 100, 2):0}}</td>

                                    <td><input type="number" {{$isDisabled}} name="diperiksa_P" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->diperiksa_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="diperiksa_P{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->sd_P>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->diperiksa_P
                                        /$item->filterGigiAnak(Session::get('year'))->sd_P * 100, 2):0}}</td>

                                    <td id="diperiksa_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->diperiksa_L + $item->filterGigiAnak(Session::get('year'))->diperiksa_P}}</td>
                                    <td id="persen_diperiksa_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->sd_P + $item->filterGigiAnak(Session::get('year'))->sd_L>0?
                                        number_format(( $item->filterGigiAnak(Session::get('year'))->diperiksa_L + $item->filterGigiAnak(Session::get('year'))->diperiksa_P)
                                        /($item->filterGigiAnak(Session::get('year'))->sd_L + $item->filterGigiAnak(Session::get('year'))->sd_P) * 100, 2):0}}</td>

                                    <td><input type="number" {{$isDisabled}} name="rawat_L" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->rawat_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="rawat_P" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->rawat_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="rawat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_L + $item->filterGigiAnak(Session::get('year'))->rawat_P}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="dapat_L" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->dapat_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="dapat_L{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_L>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->dapat_L
                                        /$item->filterGigiAnak(Session::get('year'))->rawat_L * 100, 2):0}}</td>

                                    <td><input type="number" {{$isDisabled}} name="dapat_P" id="{{$item->filterGigiAnak(Session::get('year'))->id}}" value="{{$item->filterGigiAnak(Session::get('year'))->dapat_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="dapat_P{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_P>0?
                                        number_format($item->filterGigiAnak(Session::get('year'))->dapat_P
                                        /$item->filterGigiAnak(Session::get('year'))->rawat_P * 100, 2):0}}</td>

                                    <td id="dapat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->dapat_L + $item->filterGigiAnak(Session::get('year'))->dapat_P}}</td>
                                    <td id="persen_dapat_LP{{$item->filterGigiAnak(Session::get('year'))->id}}">{{$item->filterGigiAnak(Session::get('year'))->rawat_P + $item->filterGigiAnak(Session::get('year'))->rawat_L>0?
                                        number_format(( $item->filterGigiAnak(Session::get('year'))->dapat_L + $item->filterGigiAnak(Session::get('year'))->dapat_P)
                                        /($item->filterGigiAnak(Session::get('year'))->rawat_L + $item->filterGigiAnak(Session::get('year'))->rawat_P) * 100, 2):0}}</td>



                                </tr>
                                  @endif
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

@push('scripts')
    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

@endpush

@push('scripts')
    <script>

        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');
        let sikat = $(this).parent().parent().find(`#sikat${id}`);
        let yan = $(this).parent().parent().find(`#yan${id}`);
        let diperiksa_L = $(this).parent().parent().find(`#diperiksa_L${id}`);
        let diperiksa_P = $(this).parent().parent().find(`#diperiksa_P${id}`);
        let diperiksa_LP = $(this).parent().parent().find(`#diperiksa_LP${id}`);
        let persen_diperiksa_LP = $(this).parent().parent().find(`#persen_diperiksa_LP${id}`);
        let sd_LP = $(this).parent().parent().find(`#sd_LP${id}`);
        
        let dapat_L = $(this).parent().parent().find(`#dapat_L${id}`);
        let dapat_P = $(this).parent().parent().find(`#dapat_P${id}`);
        let dapat_LP = $(this).parent().parent().find(`#dapat_LP${id}`);
        let persen_dapat_LP = $(this).parent().parent().find(`#persen_dapat_LP${id}`);
        let rawat_LP = $(this).parent().parent().find(`#rawat_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("GigiAnak.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                sikat.text(`${res.sikat}`);
                yan.text(`${res.yan}`);
                diperiksa_L.text(`${res.diperiksa_L}`);
                diperiksa_P.text(`${res.diperiksa_P}`);
                diperiksa_LP.text(`${res.diperiksa_LP}`);
                persen_diperiksa_LP.text(`${res.persen_diperiksa_LP}`);
                sd_LP.text(`${res.sd_LP}`);
                dapat_L.text(`${res.dapat_L}`);
                dapat_P.text(`${res.dapat_P}`);
                dapat_LP.text(`${res.dapat_LP}`);
                persen_dapat_LP.text(`${res.persen_dapat_LP}`);
                rawat_LP.text(`${res.rawat_LP}`);
			}
		});
        console.log(name, value, id);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/JumlahKematianIbu?year="+year;


        })
        $('#data').on('click', '.detail', function(){
            let id = $(this).attr('id');
            let $clickedRow = $(this).closest('tr'); // Get the clicked row element
            if ($clickedRow.next().hasClass('detail-row')) {

        $clickedRow.nextAll('.detail-row').remove();
            } else {
                 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'GET',
			'url'	: `/general/detail_desa/${id}`,
			'data'	: {'id': id, 'mainFilter': 'filterGigiAnak'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.jumlah_sd}</td>
             <td>${item.jumlah_sikat}</td>
             <td>${item.jumlah_sd>0?(item.jumlah_sikat/item.jumlah_sd) * 100:0}%</td>
             <td>${item.jumlah_yan}</td>
             <td>${item.jumlah_sd>0?(item.jumlah_yan/item.jumlah_sd) * 100:0}%</td>
             <td>${item.sd_L}</td>
             <td>${item.sd_P}</td>
             <td>${item.sd_P + item.sd_L}</td>
              <td>${item.diperiksa_L}</td>
              <td>${item.sd_L > 0?(item.diperiksa_L/item.sd_L) * 100:0}%</td>
              <td>${item.diperiksa_P}</td>
              <td>${item.sd_P > 0?(item.diperiksa_P/item.sd_P) * 100:0}%</td>
              <td>${item.diperiksa_P + item.diperiksa_L}</td>
              <td>${item.sd_P + item.sd_L > 0?((item.diperiksa_P + item.diperiksa_L)/(item.sd_P + item.sd_L)) * 100:0}%</td>
             <td>${item.rawat_L}</td>
             <td>${item.rawat_P}</td>
             <td>${item.rawat_P + item.rawat_L}</td>
              <td>${item.dapat_L}</td>
              <td>${item.rawat_L > 0?(item.dapat_L/item.rawat_L) * 100:0}%</td>
              <td>${item.dapat_P}</td>
              <td>${item.rawat_P > 0?(item.dapat_P/item.rawat_P) * 100:0}%</td>
              <td>${item.dapat_P + item.dapat_L}</td>
              <td>${item.rawat_P + item.rawat_L > 0?((item.dapat_P + item.dapat_L)/(item.rawat_P + item.rawat_L)) * 100:0}%</td>
            </tr>
                `;
                $clickedRow.after(newRow); // Insert the new row after the clicked row
                $clickedRow = $clickedRow.next(); // Move reference to the new row for subsequent inserts
            });
			}
		}); 
            }
            console.log(id);
        })
        $('#data').on('click', '.data-lock', function(){
            let id = $(this).attr('id');
            let year = $("#tahun").val();
            $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
            if($(this).is(':checked')){
            $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterGigiAnak'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterGigiAnak'},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        $('#data').on('click', '.data-lock-upload', function(){
            let id = $(this).attr('id');
            let year = $("#tahun").val();
            $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
            if($(this).is(':checked')){
            $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "GigiAnak"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "GigiAnak"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection