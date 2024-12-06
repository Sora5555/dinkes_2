@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.includes.sticky-table')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Orang Dalam Gangguan Jiwa</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Orang Dalam Gangguan Jiwa</li>
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
                            @if(Auth::user()->downloadFile('Odgj', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="Odgj" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Odgj', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Odgj', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="Odgj" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('Odgj', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Odgj', Session::get('year'))->file_path.Auth::user()->downloadFile('Odgj', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('Odgj.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('Odgj.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                    <th rowspan="3">Sasaran ODGJ Berat</th>
                                    <th colspan="11">Pelayanan Kesehatan ODGJ berat</th>
                                    @role('Admin|superadmin')
                                    <th rowspan="3">Lock data</th>
                                    <th rowspan="3">Lock upload</th>
                                    <th rowspan="3">File Download</th>
                                    <th rowspan="3">Detail Desa</th>
                                    @endrole
                                </tr>
                            <tr>
                                <th colspan="3">Skizofrenia</th>
                                <th colspan="3">Psikotik Akut</th>
                                <th colspan="3">Total</th>
                                <th colspan="2">Mendapat Pelayanan Kesehatan</th>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap">0-14 th</th>
                                <th style="white-space:nowrap">15-59 th</th>
                                <th style="white-space:nowrap">>60 th</th>
                                <th style="white-space:nowrap">0-14 th</th>
                                <th style="white-space:nowrap">15-59 th</th>
                                <th style="white-space:nowrap">>60 th</th>
                                <th style="white-space:nowrap">0-14 th</th>
                                <th style="white-space:nowrap">15-59 th</th>
                                <th style="white-space:nowrap">>60 th</th>
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
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["sasaran"]}}</td>

                                    <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_0"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_15"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["skizo_60"]}}</td>

                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_0"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_15"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_60"]}}</td>
                                    
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_0"] + $item->odgj_per_desa(Session::get('year'))["skizo_0"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_15"] + $item->odgj_per_desa(Session::get('year'))["skizo_15"]}}</td>
                                    <td>{{$item->odgj_per_desa(Session::get('year'))["psiko_60"] + $item->odgj_per_desa(Session::get('year'))["skizo_60"]}}</td>

                                    <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"]}}</td>
                                    <td>{{$item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"]>0?number_format(($item->kunjungan_per_desa(Session::get('year'))["jiwa_L"] + $item->kunjungan_per_desa(Session::get('year'))["jiwa_P"])/$item->odgj_per_desa(Session::get('year'))["sasaran"]*100, 2):0}}</td>
                                    
                                    <td><input type="checkbox" name="lock" {{$item->odgj_lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('Odgj', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Odgj', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('Odgj', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('Odgj', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('Odgj', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Odgj', Session::get('year'))->file_path.$item->user->downloadFile('Odgj', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td style="white-space: nowrap"><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td>
                                  </tr>
                                  </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$total_sasaran}}</td>

                                    <td>{{$total_skizo_0}}</td>
                                    <td>{{$total_skizo_15}}</td>
                                    <td>{{$total_skizo_60}}</td>

                                    <td>{{$total_psiko_0}}</td>
                                    <td>{{$total_psiko_15}}</td>
                                    <td>{{$total_psiko_60}}</td>
                                    
                                    <td>{{$total_psiko_0 + $total_skizo_0}}</td>
                                    <td>{{$total_psiko_15 + $total_skizo_15}}</td>
                                    <td>{{$total_psiko_60 + $total_skizo_60}}</td>

                                    <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
                                    <td>{{$total_jiwa_L + $total_jiwa_P>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
                                    
                                    <td></td>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterOdgj(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" disabled name="sasaran" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->sasaran}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="skizo_0" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->skizo_0}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="skizo_15" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->skizo_15}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="skizo_60" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->skizo_60}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="psiko_0" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->psiko_0}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="psiko_15" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->psiko_15}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterOdgj(Session::get('year'))->status == 1?"disabled":""}} name="psiko_60" id="{{$item->filterOdgj(Session::get('year'))->id}}" value="{{$item->filterOdgj(Session::get('year'))->psiko_60}}" class="form-control data-input" style="border: none"></td>

                                    <td id="0{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_0 + $item->filterOdgj(Session::get('year'))->skizo_0}}</td>
                                    <td id="15{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_15 + $item->filterOdgj(Session::get('year'))->skizo_15}}</td>
                                    <td id="60{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->psiko_60 + $item->filterOdgj(Session::get('year'))->skizo_60}}</td>
                                    
                                    <td id="pelayanan{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterKunjungan(Session::get('year'))->jiwa_L + $item->filterKunjungan(Session::get('year'))->jiwa_P}}</td>
                                    <td id="persen{{$item->filterOdgj(Session::get('year'))->id}}">{{$item->filterOdgj(Session::get('year'))->sasaran > 0? number_format(($item->filterKunjungan(Session::get('year'))->jiwa_L + $item->filterKunjungan(Session::get('year'))->jiwa_P) / $item->filterOdgj(Session::get('year'))->sasaran * 100, 2):0}}%</td>
                                    
                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                   <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="sasaran">{{$total_sasaran}}</td>

                                    <td id="skizo_0">{{$total_skizo_0}}</td>
                                    <td id="skizo_15">{{$total_skizo_15}}</td>
                                    <td id="skizo_60">{{$total_skizo_60}}</td>

                                    <td id="psiko_0">{{$total_psiko_0}}</td>
                                    <td id="psiko_15">{{$total_psiko_15}}</td>
                                    <td id="psiko_60">{{$total_psiko_60}}</td>
                                    
                                    <td id="total_0">{{$total_psiko_0 + $total_skizo_0}}</td>
                                    <td id="total_15">{{$total_psiko_15 + $total_skizo_15}}</td>
                                    <td id="total_60">{{$total_psiko_60 + $total_skizo_60}}</td>

                                    <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
                                    <td id="percentage">{{$total_sasaran>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
                                    
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
        var table = $('#datatable').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            order: [[ 0, "asc" ]],
            ajax: {
                'url': '{{ route("datatable.sub_kegiatan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.kegiatan_id = $('#kegiatan_id').val();
                },
            },
            columns: [
                {data:'kode',name:'kode'},
                {data:'nama',name:'nama'},
                {data:'sasaran',name:'sasaran'},
                {data: 'indikator', name:'indikator'}
            ],
        });

        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let id = $(this).attr('id');
        let total_0 = $(this).parent().parent().find(`#0${id}`);
        let total_15 = $(this).parent().parent().find(`#15${id}`);
        let total_60 = $(this).parent().parent().find(`#60${id}`);
        let persen = $(this).parent().parent().find(`#persen${id}`);
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
			'type' 	: 'POST',
			'url'	: '{{ route("odgj.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                console.log(res);
                total_0.text(`${res.total_0}`);
                total_15.text(`${res.total_15}`);
                total_60.text(`${res.total_60}`);
                persen.text(`${res.persen}%`);
                 let total_column = res.column;
                 $(`#total_0`).text(res.jumlah_0);
                 $(`#total_15`).text(res.jumlah_15);
                 $(`#total_60`).text(res.jumlah_60);
                 $(`#${total_column}`).text(res.total);
                 if(total_column == sasaran){
                    $(`#percentage`).text(res.percentage);
                 }
			}
		});
        console.log(name, value, id);
        })
        $('#induk_opd').change(function(){
            let valueOpd = $("#induk_opd").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiProgram/kegiatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Program</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#program_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });
        $('#program_id').change(function(){
            let program_id = $("#program_id").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiKegiatan/sub_kegiatan')}}/${program_id}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Kegiatan</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#kegiatan_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/odgj?year="+year;


        })
        $("#kegiatan_id").change(function(){
            table.draw()
        })
        $('.btn-tambah-program').click(function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();
                let kegiatan_id = $("#kegiatan_id").val();


                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="kegiatan_id" value="${kegiatan_id}">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('uraian',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kode</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('kode',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sub Kegiatan');
                $('.modal').modal('toggle');
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
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
			'url'	: '{{ route("Odgj.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("Odgj.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
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
			'data'	: {'id': id, 'mainFilter': 'filterOdgj', 'secondaryFilter': 'filterKunjungan'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
                                       <td></td>
                                    <td></td>
                                    <td>${item.nama}</td>
                                    <td>${item.sasaran}</td>

                                    <td>${item.skizo_0}</td>
                                    <td>${item.skizo_15}</td>
                                    <td>${item.skizo_60}</td>

                                    <td>${item.psiko_0}</td>
                                    <td>${item.psiko_15}</td>
                                    <td>${item.psiko_60}</td>
                                    
                                    <td>${item.psiko_0 + item.skizo_0}</td>
                                    <td>${item.psiko_15 + item.skizo_15}</td>
                                    <td>${item.psiko_60 + item.skizo_60}</td>
                                    <td>${item.jiwa_L + item.jiwa_P}</td>
                                    <td>${item.sasaran>0?((item.jiwa_L + item.jiwa_P)/item.sasaran) * 100:0}%</td>

                                    
                                    <td></td>
                        
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
    $('#data').on('click', '.btn-mod2', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/IbuHamil')}}/${id}`,
                success: (res) => {
                    console.log(res)
                    if(res.status == "success"){
                            console.log(res.data)
                            let textUraian = `<input type="text" name="k1" id="nama" class="form-control" value="${res.IbuHamil.k1}">`
                            let textKode = `<input type="text" name="k4" class="form-control" id="bezetting" value="${res.IbuHamil.k4}">`
                            let textPosyanduPurnama = `<input type="text" name="k6" class="form-control" id="bezetting" value="${res.IbuHamil.k6}">`
                            let textPosyanduMandiri = `<input type="text" name="fasyankes" class="form-control" id="bezetting" value="${res.IbuHamil.fasyankes}">`
                            let textPosyanduAktif = `<input type="text" name="kf1" class="form-control" id="bezetting" value="${res.IbuHamil.kf1}">`
                            let textPosbindu = `<input type="text" name="kf_lengkap" class="form-control" id="bezetting" value="${res.IbuHamil.kf_lengkap}">`
                            let textVita = `<input type="text" name="vita" class="form-control" id="bezetting" value="${res.IbuHamil.vita}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K1</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K4</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K6</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="purnamaField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Persalinan di Fasyankes</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="mandiriField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kf1</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="aktifField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">KF Lengkap</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="posbinduField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Ibu Bersalin Yang diberi Vitamin A</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="vitaField">
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#purnamaField').html(textPosyanduPurnama);
                $('#mandiriField').html(textPosyanduMandiri);
                $('#aktifField').html(textPosyanduAktif);
                $('#posbinduField').html(textPosbindu);
                $('#vitaField').html(textVita);
                $('#EditForm').attr('action', `/IbuHamil/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Program');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
    $('#datatable').on('click', '.btn-tambah-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/program')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textUraian = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'sasaran_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sub_kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sasaran');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaran_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'sasaranKegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/sasaran_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Sasaran Kegiatan');
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-tambah-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaranProgram')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sasaran_sub_kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#title').html('Tambah Data Indikator');
                $('#submitButton').attr('form', 'storeForm')
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/indikator_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/indikator_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Indikator Sub Kegiatan');
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Odgj"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Odgj"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection