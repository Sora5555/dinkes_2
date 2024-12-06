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
                            @if(Auth::user()->downloadFile('KematianNeonatal', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KematianNeonatal" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('KematianNeonatal', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('KematianNeonatal', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KematianNeonatal" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('KematianNeonatal', Session::get('year')) && Auth::user()->downloadFile('KematianNeonatal', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('KematianNeonatal', Session::get('year'))->file_path.Auth::user()->downloadFile('KematianNeonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('KematianNeonatal.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('KematianNeonatal.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                <th colspan="15">Jumlah Kematian</th>
                                @role('Admin|superadmin')
                                <th rowspan="4">Lock data</th>
                                <th rowspan="4">Lock upload</th>
                                <th rowspan="4">File Download</th>
                                <th rowspan="4">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="5">Laki Laki</th>
                                <th colspan="5">Perempuan</th>
                                <th colspan="5">Laki Laki + Perempuan</th>
                            </tr>
                            <tr>
                                <th rowspan="2">Neonatal</th>
                                <th rowspan="2">Post Neonatal</th>
                                <th colspan="3">Balita</th>
                                <th rowspan="2">Neonatal</th>
                                <th rowspan="2">Post Neonatal</th>
                                <th colspan="3">Balita</th>
                                <th rowspan="2">Neonatal</th>
                                <th rowspan="2">Post Neonatal</th>
                                <th colspan="3">Balita</th>
                            </tr>
                            <tr>
                                <th>Bayi</th>
                                <th style="white-space: nowrap">Anak Balita</th>
                                <th>Jumlah Total</th>
                                <th>Bayi</th>
                                <th style="white-space: nowrap">Anak Balita</th>
                                <th>Jumlah Total</th>
                                <th>Bayi</th>
                                <th style="white-space: nowrap">Anak Balita</th>
                                <th>Jumlah Total</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] }}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_P')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'balita_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'post_neo_L')["total"] + $item->unitKerjaAmbil('filterKematianNeonatal', Session::get('year'), 'neo_L')["total"]}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterKematianNeonatal') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('KematianNeonatal', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('KematianNeonatal', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('KematianNeonatal', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('KematianNeonatal', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('KematianNeonatal', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('KematianNeonatal', Session::get('year'))->file_path.$item->user->downloadFile('KematianNeonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                $filterResult = $item->filterKematianNeonatal(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                   
                                    
                                    <td><input type="number" name="neo_L" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->neo_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td><input type="number" name="post_neo_L" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->post_neo_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="bayi_L{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                                        $item->filterKematianNeonatal(Session::get('year'))->neo_L 
                                        + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                                        
                                        }}</td>
                                    
                                    <td><input type="number" name="balita_L" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->balita_L}}" class="form-control data-input" style="border: none; width: 100%"></td>

                                    <td id="total_L{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                                        $item->filterKematianNeonatal(Session::get('year'))->neo_L 
                                        + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                                        + $item->filterKematianNeonatal(Session::get('year'))->balita_L 
                                        
                                        }}</td>
                                    
                                    <td><input type="number" name="neo_P" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->neo_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td><input type="number" name="post_neo_P" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->post_neo_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="bayi_P{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->neo_P + $item->filterKematianNeonatal(Session::get('year'))->post_neo_P}}</td>
                                    
                                    <td><input type="number" name="balita_P" {{$isDisabled}} id="{{$item->filterKematianNeonatal(Session::get('year'))->id}}" value="{{$item->filterKematianNeonatal(Session::get('year'))->balita_P}}" class="form-control data-input" style="border: none; width: 100%"></td>

                                    <td id="total_P{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->neo_P + $item->filterKematianNeonatal(Session::get('year'))->post_neo_P + $item->filterKematianNeonatal(Session::get('year'))->balita_P}}</td>
                                    
                                    <td id="neo_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->neo_P + $item->filterKematianNeonatal(Session::get('year'))->neo_L}}</td>
                                    
                                    <td id="post_neo_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{$item->filterKematianNeonatal(Session::get('year'))->post_neo_P + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L}}</td>
                                    
                                    <td id="bayi_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                                        $item->filterKematianNeonatal(Session::get('year'))->post_neo_P 
                                        + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                                        + $item->filterKematianNeonatal(Session::get('year'))->neo_P
                                        + $item->filterKematianNeonatal(Session::get('year'))->neo_L
                                        
                                        }}</td>
                                    
                                    <td id="balita_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                                        $item->filterKematianNeonatal(Session::get('year'))->balita_P 
                                        + $item->filterKematianNeonatal(Session::get('year'))->balita_L
                                        
                                        }}</td>
                                    
                                    <td id="total_LP{{$item->filterKematianNeonatal(Session::get('year'))->id}}">{{
                                        $item->filterKematianNeonatal(Session::get('year'))->balita_P 
                                        + $item->filterKematianNeonatal(Session::get('year'))->balita_L
                                        + $item->filterKematianNeonatal(Session::get('year'))->post_neo_P 
                                        + $item->filterKematianNeonatal(Session::get('year'))->post_neo_L
                                        + $item->filterKematianNeonatal(Session::get('year'))->neo_P 
                                        + $item->filterKematianNeonatal(Session::get('year'))->neo_L
                                        
                                        }}</td>
                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                    <td id="neo_L">{{$neo_L}}</td>
                                    <td id="post_neo_L">{{$post_neo_L}}</td>
                                    <td id="bayi_L">{{$neo_L + $post_neo_L}}</td>
                                    <td id="balita_L">{{$balita_L}}</td>
                                    <td id="total_L">{{$neo_L + $post_neo_L + $balita_L}}</td>
                                    
                                    <td id="neo_P">{{$neo_P}}</td>
                                    <td id="post_neo_P">{{$post_neo_P}}</td>
                                    <td id="bayi_P">{{$neo_P + $post_neo_P}}</td>
                                    <td id="balita_P">{{$balita_P}}</td>
                                    <td id="total_P">{{$neo_P + $post_neo_P + $balita_P}}</td>

                                    <td id="sum_neo_LP">{{$neo_L + $neo_P}}</td>
                                    <td id="sum_post_neo_LP">{{$post_neo_L + $post_neo_P}}</td>
                                    <td id="sum_bayi_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P}}</td>
                                    <td id="sum_balita_LP">{{$balita_L + $balita_P}}</td>
                                    <td id="sum_total_LP">{{$neo_L + $neo_P + $post_neo_L + $post_neo_P + $balita_L + $balita_P}}</td>
                                    
                                    <td></td>
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
        
        let bayi_L = $(this).parent().parent().find(`#bayi_L${id}`);
        let total_L = $(this).parent().parent().find(`#total_L${id}`);
        let bayi_P = $(this).parent().parent().find(`#bayi_P${id}`);
        let total_P = $(this).parent().parent().find(`#total_P${id}`);
        let neo_LP = $(this).parent().parent().find(`#neo_LP${id}`);
        let post_neo_LP = $(this).parent().parent().find(`#post_neo_LP${id}`);
        let bayi_LP = $(this).parent().parent().find(`#bayi_LP${id}`);
        let balita_LP = $(this).parent().parent().find(`#balita_LP${id}`);
        let total_LP = $(this).parent().parent().find(`#total_LP${id}`);


        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KematianNeonatal.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                bayi_L.text(`${res.bayi_L}`);
                total_L.text(`${res.total_L}`);
                bayi_P.text(`${res.bayi_P}`);
                total_P.text(`${res.total_P}`);
                neo_LP.text(`${res.neo_LP}`);
                post_neo_LP.text(`${res.post_neo_LP}`);
                bayi_LP.text(`${res.bayi_LP}`);
                balita_LP.text(`${res.balita_LP}`);
                total_LP.text(`${res.total_LP}`);
                console.log(res);

                let total_column = res.column;
                $(`#sum_neo_LP`).text(res.sum_neo_LP)
                $(`#sum_post_neo_LP`).text(res.sum_post_neo_LP)
                $(`#sum_bayi_LP`).text(res.sum_bayi_LP)
                $(`#sum_balita_LP`).text(`${res.sum_balita_LP}`)
                $(`#sum_total_LP`).text(`${res.sum_total_LP}`)
                $(`#${total_column}`).text(res.total);
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
			'data'	: {'id': id, 'mainFilter': 'filterKematianNeonatal', 'secondaryFilter': 'filterKelahiran'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.neo_L}</td>
             <td>${item.post_neo_L}</td>
             <td>${item.neo_L + item.post_neo_L}</td>
             <td>${item.balita_L}</td>
             <td>${item.balita_L + item.neo_L + item.post_neo_L}</td>
             
             <td>${item.neo_P}</td>
             <td>${item.post_neo_P}</td>
             <td>${item.neo_P + item.post_neo_P}</td>
             <td>${item.balita_P}</td>
             <td>${item.balita_P + item.neo_P + item.post_neo_P}</td>
             
             <td>${item.neo_P + item.neo_L}</td>
             <td>${item.post_neo_P + item.post_neo_L}</td>
             <td>${item.neo_P + item.post_neo_P + item.neo_L + item.post_neo_L}</td>
             <td>${item.balita_P + item.balita_L}</td>
             <td>${item.balita_P + item.neo_P + item.post_neo_P + item.balita_L + item.neo_L + item.post_neo_L}</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterKematianNeonatal'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterKematianNeonatal'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "KematianNeonatal"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "KematianNeonatal"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection