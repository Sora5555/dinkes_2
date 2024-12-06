@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.includes.sticky-table')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pelayanan Lansia</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Pelayanan Lansia</li>
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
                            @if(Auth::user()->downloadFile('PelayananLansia', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PelayananLansia" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('PelayananLansia', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('PelayananLansia', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PelayananLansia" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('PelayananLansia', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('PelayananLansia', Session::get('year'))->file_path.Auth::user()->downloadFile('PelayananLansia', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('PelayananLansia.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('PelayananLansia.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="4">No</th>
                                    <th rowspan="4">Kecamatan</th>
                                    @role('Admin|superadmin')
                                    <th rowspan="4">Puskesmas</th>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                    <th rowspan="4">Desa</th>
                                    @endrole
                                    <th colspan="9">Penduduk Usia 60+ tahun</th>
                                    @role('Admin|superadmin')
                                    <th rowspan="4">Lock data</th>
                                    <th rowspan="4">Lock Upload</th>
                                    <th rowspan="4">File Download</th>
                                    <th rowspan="4">Detail Desa</th>
                                    @endrole
                                </tr>
                            <tr>
                                <th colspan="3">Jumlah</th>
                                <th colspan="6">Mendapat Pelayanan Kesehatan Skrining sesuai standar</th>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap" rowspan="2">Laki Laki</th>
                                <th rowspan="2">Perempuan</th>
                                <th rowspan="2">Laki Laki + Perempuan</th>
                                
                                <th style="white-space:nowrap" colspan="2">Laki Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki Laki + Perempuan</th>
                                
                            </tr>
                            <tr>
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
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"]}}</td>
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"]}}</td>
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] +  $item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"]}}</td>
                                    
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_L"]}}</td>
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_L'] / $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_L'] * 100, 2): 0}}%</td>
                                    
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_P"]}}</td>
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"] > 0?number_format($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_P'] / $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_P'] * 100, 2): 0}}%</td>
                                    
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["standar_P"] + $item->pelayanan_lansia_per_desa(Session::get('year'))["standar_L"]}}</td>
                                    <td>{{$item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_P"] + $item->pelayanan_lansia_per_desa(Session::get('year'))["jumlah_L"] > 0?number_format(($item->pelayanan_lansia_per_desa(Session::get('year'))['standar_P'] + $item->pelayanan_lansia_per_desa(Session::get('year'))['standar_L']) / ($item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_P'] + $item->pelayanan_lansia_per_desa(Session::get('year'))['jumlah_L']) * 100, 2): 0}}%</td>
                                    <td><input type="checkbox" name="lock" {{$item->pelayanan_lansia_lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('PelayananLansia', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('PelayananLansia', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('PelayananLansia', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('PelayananLansia', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('PelayananLansia', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('PelayananLansia', Session::get('year'))->file_path.$item->user->downloadFile('PelayananLansia', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$total_L}}</td>
                                    <td>{{$total_P}}</td>
                                    <td>{{$total_L +  $total_P}}</td>
                                    
                                    <td>{{$totalstandar_L}}</td>
                                    <td>{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
                                    
                                    <td>{{$totalstandar_P}}</td>
                                    <td>{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
                                    
                                    <td>{{$totalstandar_P + $totalstandar_L}}</td>
                                    <td>{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterPelayananLansia(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" name="jumlah_L" id="{{$item->filterPelayananLansia(Session::get('year'))->id}}" value="{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" name="jumlah_P" id="{{$item->filterPelayananLansia(Session::get('year'))->id}}" value="{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="jumlah_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L + $item->filterPelayananLansia(Session::get('year'))->jumlah_P}}</td>
                                    
                                    <td><input type="number" {{$item->filterPelayananLansia(Session::get('year'))->status == 1?"disabled":""}} name="standar_L" id="{{$item->filterPelayananLansia(Session::get('year'))->id}}" value="{{$item->filterPelayananLansia(Session::get('year'))->standar_L}}" class="form-control data-input" style="border: none"></td>
                                    <td id="standar_L{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_L > 0? number_format($item->filterPelayananLansia(Session::get('year'))->standar_L/$item->filterPelayananLansia(Session::get('year'))->jumlah_L * 100):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPelayananLansia(Session::get('year'))->status == 1?"disabled":""}} name="standar_P" id="{{$item->filterPelayananLansia(Session::get('year'))->id}}" value="{{$item->filterPelayananLansia(Session::get('year'))->standar_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="standar_P{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P > 0? number_format($item->filterPelayananLansia(Session::get('year'))->standar_P/$item->filterPelayananLansia(Session::get('year'))->jumlah_P * 100):0}}%</td>
                                    
                                    <td id="standar_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->standar_P + $item->filterPelayananLansia(Session::get('year'))->standar_L}}</td>
                                    <td id="persen_standar_LP{{$item->filterPelayananLansia(Session::get('year'))->id}}">{{$item->filterPelayananLansia(Session::get('year'))->jumlah_P + $item->filterPelayananLansia(Session::get('year'))->jumlah_L > 0? number_format(($item->filterPelayananLansia(Session::get('year'))->standar_P + $item->filterPelayananLansia(Session::get('year'))->standar_L)/($item->filterPelayananLansia(Session::get('year'))->jumlah_P + $item->filterPelayananLansia(Session::get('year'))->jumlah_L) * 100):0}}%</td>
                                    
                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="jumlah_L">{{$total_L}}</td>
                                    <td id="jumlah_P">{{$total_P}}</td>
                                    <td id="total_LP">{{$total_L +  $total_P}}</td>
                                    
                                    <td id="standar_L">{{$totalstandar_L}}</td>
                                    <td id="percentage_standar_L">{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
                                    
                                    <td id="standar_P">{{$totalstandar_P}}</td>
                                    <td id="percentage_standar_P">{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
                                    
                                    <td id="totalstandar_LP">{{$totalstandar_P + $totalstandar_L}}</td>
                                    <td id="percentage_totalstandar_LP">{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
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
        let jumlah_LP = $(this).parent().parent().find(`#jumlah_LP${id}`);
        let standar_L = $(this).parent().parent().find(`#standar_L${id}`);
        let standar_P = $(this).parent().parent().find(`#standar_P${id}`);
        let standar_LP = $(this).parent().parent().find(`#standar_LP${id}`);
        let persen_standar_LP = $(this).parent().parent().find(`#persen_standar_LP${id}`);
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
			'url'	: '{{ route("pelayanan_lansia.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': ids},
			success	: function(res){
                console.log(res);
                // balita_kia.text(`${res.persen_balita_kia}%`);
                // balita_dipantau.text(`${res.persen_balita_dipantau}%`);
                // balita_sdidtk.text(`${res.persen_balita_sdidtk}%`);
                // balita_mtbs.text(`${res.persen_balita_mtbs}%`);
                jumlah_LP.text(`${res.jumlah_LP}`);
                standar_L.text(`${res.standar_L}%`);
                standar_P.text(`${res.standar_P}%`);
                standar_LP.text(`${res.standar_LP}`);
                persen_standar_LP.text(`${res.persen_standar_LP}%`);
                // lahir_hidup_mati_LP.text(`${res.lahir_hidup_mati_LP}%`);
                // kf_lengkap.text(`${res.kf_lengkap}%`);
                // vita.text(`${res.vita}%`);
                 let total_column = res.column;
                 $('#total_LP').text(res.total_LP);
                 $('#totalstandar_LP').text(res.totalstandar_LP);
                 $('#percentage_totalstandar_LP').text(res.percentage_totalstandar_LP);
                 $(`#${total_column}`).text(res.total);
                 $(`#percentage_${total_column}`).text(`${res.percentage}%`);
                 if(res.column == "jumlah_L"){
                    $(`#percentage_standar_L`).text(`${res.percent_standar_L}%`);
                } else if(res.column == "jumlah_P"){
                    $(`#percentage_standar_P`).text(`${res.percent_standar_P}%`);
                }
                }
		});
        console.log(name, value, id);
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
			'data'	: {'id': id, 'mainFilter': 'filterPelayananLansia'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
                         <td></td>
                                    <td></td>
                                    <td>${item.nama}</td>
                                    <td >${item.jumlah_L}</td>
                                    <td >${item.jumlah_P}</td>
                                    <td >${item.jumlah_L + item.jumlah_P}</td>
                                    
                                    <td>${item.standar_L}</td>
                                    <td>${item.jumlah_L>0?(item.standar_L/item.jumlah_L) * 100:0}%</td>
                                    
                                    <td>${item.standar_P}</td>
                                    <td>${item.jumlah_P>0?(item.standar_P/item.jumlah_P) * 100:0}%</td>
                                    
                                    <td>${item.standar_P + item.standar_L}</td>
                                    <td>${item.jumlah_P + item.jumlah_L>0?((item.standar_L + item.standar_P)/(item.jumlah_L + item.jumlah_P)) * 100:0}%</td>
                                    
                        
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
            window.location.href = "/pelayanan_lansia?year="+year;


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
			'url'	: '{{ route("PelayananLansia.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("PelayananLansia.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "PelayananLansia"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "PelayananLansia"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection