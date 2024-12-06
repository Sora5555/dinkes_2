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
                            @if(Auth::user()->downloadFile('BadutaImunisasi', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="BadutaImunisasi" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('BadutaImunisasi', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('BadutaImunisasi', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="BadutaImunisasi" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('BadutaImunisasi', Session::get('year')) && Auth::user()->downloadFile('BadutaImunisasi', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('BadutaImunisasi', Session::get('year'))->file_path.Auth::user()->downloadFile('BadutaImunisasi', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('BadutaImunisasi.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('BadutaImunisasi.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="4">No</th>
                                <th rowspan="4">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="4">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="4">Desa</th>
                                @endrole
                                <th rowspan="3" colspan="3">Jumlah Baduta</th>
                                <th colspan="12">Baduta Diimunisasi</th>
                                @role('Admin|superadmin')
                                <th rowspan="4">Lock data</th>
                                <th rowspan="4">Lock upload</th>
                                <th rowspan="4">File Download</th>
                                <th rowspan="4">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="6">DPT-HB-Hib4</th>
                                <th colspan="6">CAMPAK RUBELA2</th>
                            </tr>
                            <tr>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                            </tr>
                            <tr>
                                <th>L&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>P&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>L+P</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
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
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]
                                    /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"]
                                    /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'dpt_L')["total"])
                                    /($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]) * 100, 2
                                    ):0}}</td>
                                   
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]
                                    /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"]
                                    /$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'rubela_L')["total"])
                                    /($item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterBadutaImunisasi', Session::get('year'), 'jumlah_L')["total"]) * 100, 2
                                    ):0}}</td>
                                     <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterBadutaImunisasi') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                     @if(isset($item->user) && $item->user->downloadFile('BadutaImunisasi', Session::get('year')))
                                     <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('BadutaImunisasi', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                     @elseif(isset($item->user) && !$item->user->downloadFile('BadutaImunisasi', Session::get('year')))
                                     <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                     @else
                                     <td>-</td>
                                     @endif
                                     @if(isset($item->user) && $item->user->hasFile('BadutaImunisasi', Session::get('year')))
                                     <td>
                                         @if($item->user->downloadFile('BadutaImunisasi', Session::get('year'))->file_name != "-")
                                         <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('BadutaImunisasi', Session::get('year'))->file_path.$item->user->downloadFile('BadutaImunisasi', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterBadutaImunisasi(Session::get('year')))
                                @php
                                $filterResult = $item->filterBadutaImunisasi(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td><input type="number" {{$isDisabled}} name="jumlah_L" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="jumlah_P" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="jumlah_LP{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="dpt_L" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->dpt_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="dpt_L{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L>0?
                                    number_format($item->filterBadutaImunisasi(Session::get('year'))->dpt_L
                                    /$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="dpt_P" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->dpt_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="dpt_P{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P>0?
                                    number_format($item->filterBadutaImunisasi(Session::get('year'))->dpt_P
                                    /$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P * 100, 2):0}}</td>
                                    
                                    <td id="total_dpt{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->dpt_P + $item->filterBadutaImunisasi(Session::get('year'))->dpt_L}}</td>
                                    <td id="persen_dpt{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L>0?
                                        number_format(($item->filterBadutaImunisasi(Session::get('year'))->dpt_P + $item->filterBadutaImunisasi(Session::get('year'))->dpt_L)
                                        /($item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L) * 100, 2):0}}</td>
                                    
                                    
                                    <td><input type="number" {{$isDisabled}} name="rubela_L" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="rubela_L{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L>0?
                                    number_format($item->filterBadutaImunisasi(Session::get('year'))->rubela_L
                                    /$item->filterBadutaImunisasi(Session::get('year'))->jumlah_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="rubela_P" id="{{$item->filterBadutaImunisasi(Session::get('year'))->id}}" value="{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="rubela_P{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P>0?
                                    number_format($item->filterBadutaImunisasi(Session::get('year'))->rubela_P
                                    /$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P * 100, 2):0}}</td>
                                    
                                    <td id="total_rubela{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->rubela_P + $item->filterBadutaImunisasi(Session::get('year'))->rubela_L}}</td>
                                    <td id="persen_rubela{{$item->filterBadutaImunisasi(Session::get('year'))->id}}">{{$item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L>0?
                                        number_format(($item->filterBadutaImunisasi(Session::get('year'))->rubela_P + $item->filterBadutaImunisasi(Session::get('year'))->rubela_L)
                                        /($item->filterBadutaImunisasi(Session::get('year'))->jumlah_P + $item->filterBadutaImunisasi(Session::get('year'))->jumlah_L) * 100, 2):0}}</td>
                                    
                                    
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
        let dpt_L = $(this).parent().parent().find(`#dpt_L${id}`);
        let dpt_P = $(this).parent().parent().find(`#dpt_P${id}`);
        let total_dpt = $(this).parent().parent().find(`#total_dpt${id}`);
        let persen_dpt = $(this).parent().parent().find(`#persen_dpt${id}`);
        let rubela_L = $(this).parent().parent().find(`#rubela_L${id}`);
        let rubela_P = $(this).parent().parent().find(`#rubela_P${id}`);
        let total_rubela = $(this).parent().parent().find(`#total_rubela${id}`);
        let persen_rubela = $(this).parent().parent().find(`#persen_rubela${id}`);
        let jumlah_LP = $(this).parent().parent().find(`#jumlah_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("BadutaImunisasi.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                dpt_L.text(`${res.dpt_L}`);
                dpt_P.text(`${res.dpt_P}`);
                total_dpt.text(`${res.total_dpt}`);
                persen_dpt.text(`${res.persen_dpt}`);
                
                rubela_L.text(`${res.rubela_L}`);
                rubela_P.text(`${res.rubela_P}`);
                total_rubela.text(`${res.total_rubela}`);
                persen_rubela.text(`${res.persen_rubela}`);
                jumlah_LP.text(`${res.jumlah_LP}`);
                
                
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
			'data'	: {'id': id, 'mainFilter': 'filterBadutaImunisasi'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.jumlah_L}</td>
             <td>${item.jumlah_P}</td>
             <td>${item.jumlah_P + item.jumlah_L}</td>
             <td>${item.dpt_L}</td>
             <td>${item.jumlah_L>0?(item.dpt_L/item.jumlah_L) * 100:0}%</td>
             <td>${item.dpt_P}</td>
             <td>${item.jumlah_P>0?(item.dpt_P/item.jumlah_P) * 100:0}%</td>
             <td>${item.dpt_L + item.dpt_P}</td>
             <td>${item.jumlah_P + item.jumlah_L>0?((item.dpt_L + item.dpt_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>

             <td>${item.rubela_L}</td>
             <td>${item.jumlah_L>0?(item.rubela_L/item.jumlah_L) * 100:0}%</td>
             <td>${item.jumlah_P}</td>
             <td>${item.jumlah_P>0?(item.rubela_P/item.jumlah_P) * 100:0}%</td>
             <td>${item.rubela_P + item.rubela_L}</td>
             <td>${item.jumlah_P + item.jumlah_L>0?((item.rubela_L + item.rubela_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterBadutaImunisasi'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterBadutaImunisasi'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "BadutaImunisasi"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "BadutaImunisasi"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection