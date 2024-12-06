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
                            @if(Auth::user()->downloadFile('Bblr', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="Bblr" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Bblr', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Bblr', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="Bblr" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('Bblr', Session::get('year')) && Auth::user()->downloadFile('Bblr', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Bblr', Session::get('year'))->file_path.Auth::user()->downloadFile('Bblr', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('BblrPrematur.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('BblrPrematur.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                <th colspan="3" rowspan="2">Jumlah Lahir Hidup</th>
                                <th colspan="6">Bayi Baru Lahir Ditimbang</th>
                                <th colspan="6">Bayi BBLR</th>
                                <th colspan="6">Prematur</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="2">Lock upload</th>
                                <th rowspan="2">File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
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
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]
                                        + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                        
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'timbang_L')["total"])
                                        /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                        ):0
                                        }}
                                    </td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                        
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'bblr_L')["total"])
                                        /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                        ):0
                                        }}
                                    </td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]>0?
                                        number_format($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"]
                                        /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                        ):0
                                        }}</td>
                                        
                                    <td>{{$item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]>0?
                                        number_format(($item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_P')["total"] + $item->unitKerjaAmbil('filterBblr', Session::get('year'), 'prematur_L')["total"])
                                        /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                        ):0
                                        }}
                                    </td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterBblr') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('Bblr', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Bblr', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('Bblr', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('Bblr', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('Bblr', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Bblr', Session::get('year'))->file_path.$item->user->downloadFile('Bblr', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterBblr(Session::get('year')))
                                @php
                                $filterResult = $item->filterBblr(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="timbang_L" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->timbang_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="timbang_L{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?number_format($item->filterBblr(Session::get('year'))->timbang_L/$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="timbang_P" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->timbang_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="timbang_P{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?number_format($item->filterBblr(Session::get('year'))->timbang_P/$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="timbang_LP{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterBblr(Session::get('year'))->timbang_P
                                     + $item->filterBblr(Session::get('year'))->timbang_L}}</td>
                                     <td id="persen_timbang_LP{{$item->filterBblr(Session::get('year'))->id}}">{{
                                     $item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_LP>0?
                                     number_format(($item->filterBblr(Session::get('year'))->timbang_P + $item->filterBblr(Session::get('year'))->timbang_L)
                                     /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="bblr_L" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->bblr_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="bblr_L{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?number_format($item->filterBblr(Session::get('year'))->bblr_L/$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="bblr_P" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->bblr_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="bblr_P{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?number_format($item->filterBblr(Session::get('year'))->bblr_P/$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="bblr_LP{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterBblr(Session::get('year'))->bblr_P
                                     + $item->filterBblr(Session::get('year'))->bblr_L}}</td>
                                     <td id="persen_bblr_LP{{$item->filterBblr(Session::get('year'))->id}}">{{
                                     $item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_LP>0?
                                     number_format(($item->filterBblr(Session::get('year'))->bblr_P + $item->filterBblr(Session::get('year'))->bblr_L)
                                     /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="prematur_L" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->prematur_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="prematur_L{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?number_format($item->filterBblr(Session::get('year'))->prematur_L/$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="prematur_P" id="{{$item->filterBblr(Session::get('year'))->id}}" value="{{$item->filterBblr(Session::get('year'))->bblr_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="bblr_P{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?number_format($item->filterBblr(Session::get('year'))->prematur_P/$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="prematur_LP{{$item->filterBblr(Session::get('year'))->id}}">{{$item->filterBblr(Session::get('year'))->prematur_P
                                     + $item->filterBblr(Session::get('year'))->prematur_L}}</td>
                                     <td id="persen_prematur_LP{{$item->filterBblr(Session::get('year'))->id}}">{{
                                     $item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_LP>0?
                                     number_format(($item->filterBblr(Session::get('year'))->prematur_P + $item->filterBblr(Session::get('year'))->prematur_L)
                                     /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
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
        let timbang_L = $(this).parent().parent().find(`#timbang_L${id}`);
        let timbang_P = $(this).parent().parent().find(`#timbang_P${id}`);
        let timbang_LP = $(this).parent().parent().find(`#timbang_LP${id}`);
        let persen_timbang_LP = $(this).parent().parent().find(`#persen_timbang_LP${id}`);
        let bblr_L = $(this).parent().parent().find(`#bblr_L${id}`);
        let bblr_LP = $(this).parent().parent().find(`#bblr_LP${id}`);
        let persen_bblr_LP = $(this).parent().parent().find(`#persen_bblr_LP${id}`);
        let prematur_L = $(this).parent().parent().find(`#prematur_L${id}`);
        let prematur_P = $(this).parent().parent().find(`#prematur_P${id}`);
        let prematur_LP = $(this).parent().parent().find(`#prematur_LP${id}`);
        let persen_prematur_LP = $(this).parent().parent().find(`#persen_prematur_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("BblrPrematur.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                timbang_L.text(`${res.timbang_L}`);
                timbang_P.text(`${res.timbang_P}`);
                timbang_LP.text(`${res.timbang_LP}`);
                persen_timbang_LP.text(`${res.persen_timbang_LP}`);
                bblr_L.text(`${res.bblr_L}`);
                bblr_P.text(`${res.bblr_P}`);
                bblr_LP.text(`${res.bblr_LP}`);
                persen_bblr_LP.text(`${res.persen_bblr_LP}`);
                prematur_L.text(`${res.prematur_L}`);
                prematur_P.text(`${res.prematur_P}`);
                prematur_LP.text(`${res.prematur_LP}`);
                persen_prematur_LP.text(`${res.persen_prematur_LP}`);
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
			'data'	: {'id': id, 'mainFilter': 'filterBblr', 'secondaryFilter': 'filterKelahiran'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.lahir_hidup_L}</td>
             <td>${item.lahir_hidup_P}</td>
             <td>${item.lahir_hidup_L + item.lahir_hidup_P}</td>
             <td>${item.timbang_L}</td>
             <td>${item.lahir_hidup_L > 0?(item.timbang_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.timbang_P}</td>
             <td>${item.lahir_hidup_P > 0?(item.timbang_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.timbang_P + item.timbang_L}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L> 0?((item.timbang_P + item.timbang_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
             <td>${item.bblr_L}</td>
             <td>${item.lahir_hidup_L > 0?(item.bblr_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.bblr_P}</td>
             <td>${item.lahir_hidup_P > 0?(item.bblr_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.bblr_P + item.bblr_L}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L> 0?((item.bblr_P + item.bblr_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
             <td>${item.prematur_L}</td>
             <td>${item.lahir_hidup_L > 0?(item.prematur_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.prematur_P}</td>
             <td>${item.lahir_hidup_P > 0?(item.prematur_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.prematur_P + item.prematur_L}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L> 0?((item.prematur_P + item.prematur_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterBblr'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterBblr'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Bblr"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Bblr"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection