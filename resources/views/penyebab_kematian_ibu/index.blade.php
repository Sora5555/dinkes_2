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
                            @if(Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PenyebabKematianIbu" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PenyebabKematianIbu" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('PenyebabKematianIbu', Session::get('year')) && Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_path.Auth::user()->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('PenyebabKematianIbu.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('PenyebabKematianIbu.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                <th colspan="10">Kematian Ibu</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="2">Lock upload</th>
                                <th rowspan="2">File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th>Perdarahan</th>
                                <th>Gangguan Hipertensi</th>
                                <th>Infeksi</th>
                                <th>Kelainan Jantung dan Pembuluh darah</th>
                                <th>Gangguan Autoimun</th>
                                <th>Gangguan Cerebrovaskular</th>
                                <th>Covid-19</th>
                                <th>KOMPLIKASI PASCA KEGUGURAN (ABORTUS)</th>
                                <th>Lain-lain</th>
                                <th>Jumlah Kematian Ibu</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["perdarahan"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_hipertensi"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["infeksi"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["kelainan_jantung"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_autoimun"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_cerebro"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["covid_19"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["abortus"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["lain_lain"]}}</td>
                                    <td>{{$item->penyebab_kematian_ibu_per_desa(Session::get('year'))["lain_lain"]
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["abortus"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["covid_19"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_cerebro"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_autoimun"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["kelainan_jantung"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["infeksi"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["gangguan_hipertensi"] 
                                     + $item->penyebab_kematian_ibu_per_desa(Session::get('year'))["perdarahan"] 
                                        }}</td>
                                         <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterPenyebabKematianIbu') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                         @if(isset($item->user) && $item->user->downloadFile('PenyebabKematianIbu', Session::get('year')))
                                         <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('PenyebabKematianIbu', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                         @elseif(isset($item->user) && !$item->user->downloadFile('PenyebabKematianIbu', Session::get('year')))
                                         <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                         @else
                                         <td>-</td>
                                         @endif
                                         @if(isset($item->user) && $item->user->hasFile('PenyebabKematianIbu', Session::get('year')))
                                         <td>
                                             @if($item->user->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_name != "-")
                                             <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_path.$item->user->downloadFile('PenyebabKematianIbu', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterPenyebabKematianIbu(Session::get('year')))
                                @php
                                $filterResult = $item->filterPenyebabKematianIbu(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->nama}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td><input type="number" {{$isDisabled}} name="perdarahan" id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->perdarahan}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="gangguan_hipertensi" id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_hipertensi}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="infeksi" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->infeksi}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="kelainan_jantung" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->kelainan_jantung}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="gangguan_autoimun" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_autoimun}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="gangguan_cerebro" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_cerebro}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="covid_19" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->covid_19}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="abortus" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->abortus}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" name="lain_lain" {{$isDisabled}} id="{{$item->filterPenyebabKematianIbu(Session::get('year'))->id}}" value="{{$item->filterPenyebabKematianIbu(Session::get('year'))->lain_lain}}" class="form-control data-input" style="border: none"></td>
                                    
                                    
                                    <td id="total{{$item->filterKematianIbu(Session::get('year'))->id}}">{{
                                    $item->filterPenyebabKematianIbu(Session::get('year'))->perdarahan 
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_hipertensi 
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->infeksi
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->kelainan_jantung
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_autoimun
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->gangguan_cerebro
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->covid_19
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->abortus
                                    + $item->filterPenyebabKematianIbu(Session::get('year'))->lain_lain
                                    }}</td>

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
        let total = $(this).parent().parent().find(`#total${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("PenyebabKematianIbu.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                total.text(`${res.total}`);
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
			'data'	: {'id': id, 'mainFilter': 'filterPenyebabKematianIbu'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
             <td></td>
             <td></td>
                <td>${item.nama}</td>
                <td>${item.perdarahan}</td>
                <td>${item.gangguan_hipertensi}</td>
                <td>${item.infeksi}</td>
                <td>${item.kelainan_jantung}</td>
                <td>${item.gangguan_autoimun}</td>
                <td>${item.gangguan_cerebro}</td>
                <td>${item.covid_19}</td>
                <td>${item.abortus}</td>
                <td>${item.lain_lain}</td>
                <td>${item.lain_lain + item.abortus + item.covid_19 + item.gangguan_cerebro + item.gangguan_autoimun + item.kelainan_jantung + item.infeksi + item.gangguan_hipertensi + item.perdarahan}</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterPenyebabKematianIbu'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterPenyebabKematianIbu'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "PenyebabKematianIbu"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "PenyebabKematianIbu"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection