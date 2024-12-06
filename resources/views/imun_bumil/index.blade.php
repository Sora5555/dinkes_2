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
                            @if(Auth::user()->downloadFile('ImunBumil', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="ImunBumil" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('ImunBumil', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('ImunBumil', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="ImunBumil" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('ImunBumil', Session::get('year')) && Auth::user()->downloadFile('ImunBumil', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('ImunBumil', Session::get('year'))->file_path.Auth::user()->downloadFile('ImunBumil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('ImunBumil.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('ImunBumil.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th rowspan="3">Jumlah Ibu Hamil</th>
                                <th colspan="12">IMUNISASI Td PADA IBU HAMIL</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Lock data</th>
                                <th rowspan="3">Lock upload</th>
                                <th rowspan="3">File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="2">Td1</th>
                                <th colspan="2">Td2</th>
                                <th colspan="2">Td3</th>
                                <th colspan="2">Td4</th>
                                <th colspan="2">Td5</th>
                                <th colspan="2">Td2+</th>
                            </tr>
                            <tr>
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
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td1"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td1"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td2"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td2"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td3"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td3"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td4"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td4"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td5"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td5"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["td2_plus"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] > 0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["td2_plus"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_hamil"] * 100, 2):0}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterDesa') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('ImunBumil', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('ImunBumil', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('ImunBumil', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('ImunBumil', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('ImunBumil', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('ImunBumil', Session::get('year'))->file_path.$item->user->downloadFile('ImunBumil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @php
                                $filterResult = $item->filterDesa(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                @if($item->filterDesa(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td1" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td1}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td1{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td1/($item->filterDesa(Session::get('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td2" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td2}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td2{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td2/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td3" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td3}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td3{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td3/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td4" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td4}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td4{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td4/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td5" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td5}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td5{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td5/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="td2_plus" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->td2_plus}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="td2_plus{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->td2_plus/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 10, '2'):0}}%</td>
                                    
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
        let id = $(this).attr('id');
        let td1 = $(this).parent().parent().find(`#td1${id}`);
        let td2 = $(this).parent().parent().find(`#td2${id}`);
        let td3 = $(this).parent().parent().find(`#td3${id}`);
        let td4 = $(this).parent().parent().find(`#td4${id}`);
        let td5 = $(this).parent().parent().find(`#td5${id}`);
        let td2_plus = $(this).parent().parent().find(`#td2_plus${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("ImunBumil.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                td1.text(`${res.td1}%`);
                td2.text(`${res.td2}%`);
                td3.text(`${res.td3}%`);
                td4.text(`${res.td4}%`);
                td5.text(`${res.td5}%`);
                td2_plus.text(`${res.td2_plus}%`);
			}
		});
        
        console.log(name, value, id, params);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            let month = $("#month").val();
            window.location.href = "/IbuHamil?year="+year+"&month="+month;


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
			'data'	: {'id': id, 'mainFilter': 'filterDesa'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
             <td></td>
        <td></td>
        <td>${item.nama}</td>
        <td>${item.jumlah_ibu_hamil}</td>
        <td>${item.td1}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td1/item.jumlah_ibu_hamil) * 100:0}%</td>
        <td>${item.td2}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td2/item.jumlah_ibu_hamil) * 100:0}%</td>
        <td>${item.td3}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td3/item.jumlah_ibu_hamil) * 100:0}%</td>
        <td>${item.td4}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td4/item.jumlah_ibu_hamil) * 100:0}%</td>
        <td>${item.td5}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td5/item.jumlah_ibu_hamil) * 100:0}%</td>
        <td>${item.td2_plus}</td>
        <td>${item.jumlah_ibu_hamil>0?(item.td2_plus/item.jumlah_ibu_hamil) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterDesa'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterDesa'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "ImunBumil"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "ImunBumil"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection