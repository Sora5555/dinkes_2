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
                            @if(Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PenyebabKematianBalita" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PenyebabKematianBalita" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('PenyebabKematianBalita', Session::get('year')) && Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_path.Auth::user()->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('PenyebabKematianBalita.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('PenyebabKematianBalita.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="2">Desa</th>
                                @endrole
                                <th colspan="10">Penyebab Kematian Anak Balita (12-59 Bulan)</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="2">Lock upload</th>
                                <th rowspan="2">File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th>PNEUMONIA</th>
                                <th>KELAINAN KONGENITAL</th>
                                <th>PENYAKIT SARAF</th>
                                <th>DEMAM BERDARAH</th>
                                <th>KELAINAN KONGENITAL JANTUNG</th>
                                <th>KECELAKAAN LALU LINTAS</th>
                                <th>KELAINAN KONGENITAL LAINNYA</th>
                                <th>TENGGELAM</th>
                                <th>INFEKSI PARASIT</th>
                                <th>LAIN-LAIN</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'pneumonia')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kelainan_kongenital')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'saraf')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'dbd')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'jantung')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lakalantas')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'kongenital_lain')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'tenggelam')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'infeksi')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterPenyebabKematianBalita', Session::get('year'), 'lain_lain')["total"]}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterPenyebabKematianBalita') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('PenyebabKematianBalita', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('PenyebabKematianBalita', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('PenyebabKematianBalita', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('PenyebabKematianBalita', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_path.$item->user->downloadFile('PenyebabKematianBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterPenyebabKematianBalita(Session::get('year')))
                                @php
                                $filterResult = $item->filterPenyebabKematianBalita(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="pneumonia" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->pneumonia}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="kelainan_kongenital" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->kelainan_kongenital}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="saraf" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->saraf}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="dbd" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->dbd}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="jantung" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->jantung}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="lakalantas" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->lakalantas}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="kongenital_lain" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->kongenital_lain}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="tenggelam" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->tenggelam}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="infeksi" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->infeksi}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="lain_lain" id="{{$item->filterPenyebabKematianBalita(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianBalita(Session::get('year'))->lain_lain}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
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
        
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("PenyebabKematianBalita.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
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
			'data'	: {'id': id, 'mainFilter': 'filterPenyebabKematianBalita'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.pneumonia}</td>
             <td>${item.kelainan_kongenital}</td>
             <td>${item.saraf}</td>
             <td>${item.dbd}</td>
             <td>${item.jantung}</td>
             <td>${item.lakalantas}</td>
             <td>${item.kongenital_lain}</td>
             <td>${item.tenggelam}</td>
             <td>${item.infeksi}</td>
             <td>${item.lain_lain}</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterPenyebabKematianBalita'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterPenyebabKematianBalita'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "PenyebabKematianBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "PenyebabKematianBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection