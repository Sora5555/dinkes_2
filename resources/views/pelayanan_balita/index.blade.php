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
                            @if(Auth::user()->downloadFile('PelayananBalita', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PelayananBalita" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('PelayananBalita', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('PelayananBalita', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PelayananBalita" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('PelayananBalita', Session::get('year')) && Auth::user()->downloadFile('PelayananBalita', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('PelayananBalita', Session::get('year'))->file_path.Auth::user()->downloadFile('PelayananBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('PelayananBalita.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('PelayananBalita.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                                <th colspan="3" rowspan="2">Jumlah Bayi</th>
                                <th colspan="6">Pelayanan Kesehatan Bayi</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Lock data</th>
                                <th rowspan="3">Lock upload</th>
                                <th rowspan="3">File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L + P</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
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
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"]
                                        + $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"]
                                        }}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_P')["total"] + $item->unitKerjaAmbil('filterPelayananBalita', Session::get('year'), 'jumlah_L')["total"])
                                    /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                    ):0}}</td>
                                     <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterPelayananBalita') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                     @if(isset($item->user) && $item->user->downloadFile('PelayananBalita', Session::get('year')))
                                     <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('PelayananBalita', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                     @elseif(isset($item->user) && !$item->user->downloadFile('PelayananBalita', Session::get('year')))
                                     <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                     @else
                                     <td>-</td>
                                     @endif
                                     @if(isset($item->user) && $item->user->hasFile('PelayananBalita', Session::get('year')))
                                     <td>
                                         @if($item->user->downloadFile('PelayananBalita', Session::get('year'))->file_name != "-")
                                         <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('PelayananBalita', Session::get('year'))->file_path.$item->user->downloadFile('PelayananBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterPelayananBalita(Session::get('year')))
                                @php
                                $filterResult = $item->filterPelayananBalita(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="jumlah_L" id="{{$item->filterPelayananBalita(Session::get('year'))->id}}" value="{{$item->filterPelayananBalita(Session::get('year'))->jumlah_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="persen_jumlah_L{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                    number_format($item->filterPelayananBalita(Session::get('year'))->jumlah_L
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="jumlah_P" id="{{$item->filterPelayananBalita(Session::get('year'))->id}}" value="{{$item->filterPelayananBalita(Session::get('year'))->jumlah_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="persen_jumlah_P{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?
                                    number_format($item->filterPelayananBalita(Session::get('year'))->jumlah_P
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_LP{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterPelayananBalita(Session::get('year'))->jumlah_P + $item->filterPelayananBalita(Session::get('year'))->jumlah_L}}</td>
                                    <td id="persen_jumlah_LP{{$item->filterPelayananBalita(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                    number_format( ($item->filterPelayananBalita(Session::get('year'))->jumlah_P + $item->filterPelayananBalita(Session::get('year'))->jumlah_L)/
                                        ($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    
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
        let persen_jumlah_L = $(this).parent().parent().find(`#persen_jumlah_L${id}`);
        let persen_jumlah_P = $(this).parent().parent().find(`#persen_jumlah_P${id}`);
        let persen_jumlah_LP = $(this).parent().parent().find(`#persen_jumlah_LP${id}`);
        let jumlah_LP = $(this).parent().parent().find(`#jumlah_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("PelayananBalita.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                persen_jumlah_L.text(`${res.persen_jumlah_L}`);
                persen_jumlah_P.text(`${res.persen_jumlah_P}`);
                persen_jumlah_LP.text(`${res.persen_jumlah_LP}`);
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
			'data'	: {'id': id, 'mainFilter': 'filterPelayananBalita', 'secondaryFilter': 'filterKelahiran'},
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
             <td>${item.lahir_hidup_P + item.lahir_hidup_L}</td>
             <td>${item.jumlah_L}</td>
             <td>${item.lahir_hidup_L>0?(item.jumlah_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.jumlah_P}</td>
             <td>${item.lahir_hidup_P>0?(item.jumlah_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.jumlah_P + item.jumlah_L}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.jumlah_P + item.jumlah_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterPelayananBalita'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterPelayananBalita'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "PelayananBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "PelayananBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection