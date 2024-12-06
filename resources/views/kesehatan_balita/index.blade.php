@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <style>
        .lock-header{
            height: 100% !important;
        }
        .lock-header{
            overflow-y: auto;
            max-height: 100vh !important;
        }
        .unit_kerja{
            position: sticky !important;
            left: 0 !important;
            z-index: 0 !important;
            background: white !important;
        }
        .lock-header thead{
            position: sticky !important;
            top: 0 !important;
            background-color: white !important;
            z-index: 999;
        }
    </style>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Kesehatan Balita</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Kesehatan Balita</li>
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
                            @if(Auth::user()->downloadFile('KesehatanBalita', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KesehatanBalita" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('KesehatanBalita', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('KesehatanBalita', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KesehatanBalita" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('KesehatanBalita', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('KesehatanBalita', Session::get('year'))->file_path.Auth::user()->downloadFile('KesehatanBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('KesehatanBalita.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('KesehatanBalita.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="2">Desa</th>
                                @endrole
                                <th rowspan="2">Sasaran Balita (usia 0-59 bulan)</th>
                                <th rowspan="2">Sasaran Anak Balita (usia 12-59 bulan)</th>
                                <th colspan="2">Balita Memiliki Buku KIA lengkap</th>
                                <th colspan="2">Balita Dipantau Pertumbuhan dan Perkembangan</th>
                                <th colspan="2">Balita Dilayani SDIDTK</th>
                                <th colspan="2">Balita Dilayani MTBS</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="3">Lock Upload</th>
                                <th rowspan="3" >File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
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
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"]}}</td>

                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_12_59"]}}</td>
                                    
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_kia"]}}</td>
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(Session::get('year'))["balita_kia"] / $item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"]* 100, 2):0}}%</td>
                                    
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_dipantau"]}}</td>
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(Session::get('year'))["balita_dipantau"] / $item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"]* 100, 2):0}}%</td>
                                    
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_sdidtk"]}}</td>
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_12_59"] > 0?number_format($item->kesehatan_balita_per_desa(Session::get('year'))["balita_sdidtk"] / $item->kesehatan_balita_per_desa(Session::get('year'))["balita_12_59"]* 100, 2):0}}%</td>
                                    
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_mtbs"]}}</td>
                                    <td>{{$item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(Session::get('year'))["balita_mtbs"] / $item->kesehatan_balita_per_desa(Session::get('year'))["balita_0_59"]* 100, 2):0}}%</td>
                                    <td><input type="checkbox" name="lock" {{$item->kesehatan_balita_lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('KesehatanBalita', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('KesehatanBalita', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('KesehatanBalita', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('KesehatanBalita', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('KesehatanBalita', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('KesehatanBalita', Session::get('year'))->file_path.$item->user->downloadFile('KesehatanBalita', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$totalbalita_0_59}}</td>
    
                                        <td>{{$totalbalita_12_59}}</td>
                                        
                                        <td>{{$totalbalita_kia}}</td>
                                        <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_kia / $totalbalita_0_59* 100, 2):0}}%</td>
                                        
                                        <td>{{$totalbalita_dipantau}}</td>
                                        <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_dipantau / $totalbalita_0_59 * 100, 2):0}}%</td>
                                        
                                        <td>{{$totalbalita_sdidtk}}</td>
                                        <td>{{$totalbalita_12_59 > 0?number_format($totalbalita_sdidtk / $totalbalita_12_59* 100, 2):0}}%</td>
                                        
                                        <td>{{$totalbalita_mtbs}}</td>
                                        <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_mtbs / $totalbalita_0_59* 100, 2):0}}%</td>
                                        <td></td>
                                        <td></td>
                                      </tr>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterKesehatanBalita(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_0_59" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_0_59}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_12_59" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_12_59}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_kia" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_kia}}" class="form-control data-input" style="border: none"></td>
                                    <td id="balita_kia{{$item->filterKesehatanBalita(Session::get('year'))->id}}">{{$item->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(Session::get('year'))->balita_kia/($item->filterKesehatanBalita(Session::get('year'))->balita_0_59)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_dipantau" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_dipantau}}" class="form-control data-input" style="border: none"></td>
                                    <td id="balita_dipantau{{$item->filterKesehatanBalita(Session::get('year'))->id}}">{{$item->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(Session::get('year'))->balita_dipantau/($item->filterKesehatanBalita(Session::get('year'))->balita_0_59)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_sdidtk" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_sdidtk}}" class="form-control data-input" style="border: none"></td>
                                    <td id="balita_sdidtk{{$item->filterKesehatanBalita(Session::get('year'))->id}}">{{$item->filterKesehatanBalita(Session::get('year'))->balita_12_59 > 0?number_format($item->filterKesehatanBalita(Session::get('year'))->balita_sdidtk/($item->filterKesehatanBalita(Session::get('year'))->balita_12_59)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterKesehatanBalita(Session::get('year'))->status == 1?"disabled":""}} name="balita_mtbs" id="{{$item->filterKesehatanBalita(Session::get('year'))->id}}" value="{{$item->filterKesehatanBalita(Session::get('year'))->balita_mtbs}}" class="form-control data-input" style="border: none"></td>
                                    <td id="balita_mtbs{{$item->filterKesehatanBalita(Session::get('year'))->id}}">{{$item->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(Session::get('year'))->balita_mtbs/($item->filterKesehatanBalita(Session::get('year'))->balita_0_59)*100, 2):0}}%</td>

                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="balita_0_59">{{$totalbalita_0_59}}</td>

                                    <td id="balita_12_59">{{$totalbalita_12_59}}</td>
                                    
                                    <td id="balita_kia">{{$totalbalita_kia}}</td>
                                    <td id="percentage_balita_kia">{{$totalbalita_0_59 > 0?number_format($totalbalita_kia / $totalbalita_0_59* 100, 2):0}}%</td>
                                    
                                    <td id="balita_dipantau">{{$totalbalita_dipantau}}</td>
                                    <td id="percentage_balita_dipantau">{{$totalbalita_0_59 > 0?number_format($totalbalita_dipantau / $totalbalita_0_59* 100, 2):0}}%</td>
                                    
                                    <td id="balita_sdidtk">{{$totalbalita_sdidtk}}</td>
                                    <td id="percentage_balita_sdidtk">{{$totalbalita_12_59 > 0?number_format($totalbalita_sdidtk / $totalbalita_12_59* 100, 2):0}}%</td>
                                    
                                    <td id="balita_mtbs">{{$totalbalita_mtbs}}</td>
                                    <td id="percentage_balita_mtbs">{{$totalbalita_0_59 > 0?number_format($totalbalita_mtbs / $totalbalita_0_59* 100, 2):0}}%</td>
                                    <td></td>
                                  </tr>
                                {{-- <tr>
                                    <td></td>
                                    <td id="jumlah_ibu_hamil">{{$total_ibu_hamil}}</td>
                                    <td id="k1">{{$total_k1}}</td>
                                    <td></td>
                                    <td id="k4">{{$total_k4}}</td>
                                    <td></td>
                                    <td id="k6">{{$total_k6}}</td>
                                    <td></td>
                                    <td id="jumlah_ibu_bersalin">{{$total_ibu_bersalin}}</td>
                                    <td id="fasyankes">{{$total_fasyankes}}</td>
                                    <td></td>
                                    <td id="kf1">{{$total_kf1}}</td>
                                    <td></td>
                                    <td id="kf_lengkap">{{$total_kf_lengkap}}</td>
                                    <td></td>
                                    <td id="vita">{{$total_vita}}</td>
                                </tr> --}}
                                @endrole
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>

<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title">Tambah Program</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit" class="btn btn-primary" id="submitButton" form="storeForm">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
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
        let balita_kia = $(this).parent().parent().find(`#balita_kia${id}`);
        let balita_dipantau = $(this).parent().parent().find(`#balita_dipantau${id}`);
        let balita_sdidtk = $(this).parent().parent().find(`#balita_sdidtk${id}`);
        let balita_mtbs = $(this).parent().parent().find(`#balita_mtbs${id}`);
        // let lahir_hidup_mati_LP = $(this).parent().parent().find(`#lahir_hidup_mati_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("kesehatan_balita.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                console.log(res);
                balita_kia.text(`${res.persen_balita_kia}%`);
                balita_dipantau.text(`${res.persen_balita_dipantau}%`);
                balita_sdidtk.text(`${res.persen_balita_sdidtk}%`);
                balita_mtbs.text(`${res.persen_balita_mtbs}%`);
                // lahir_hidup_mati_LP.text(`${res.lahir_hidup_mati_LP}%`);
                // kf_lengkap.text(`${res.kf_lengkap}%`);
                // vita.text(`${res.vita}%`);
                let total_column = res.column;
                $(`#${total_column}`).text(res.total);
                if(res.column != "balita_0_59" || res.column != "balita_12_59"){
                    $(`#percentage_${total_column}`).text(`${res.percentage}`);
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
			'data'	: {'id': id, 'mainFilter': 'filterKesehatanBalita'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
                                    <td></td>
                                    <td></td>
                                    <td>${item.nama}</td>
                                    <td>${item.balita_0_59}</td>

                                    <td id>${item.balita_12_59}</td>
                                    
                                    <td>${item.balita_kia}</td>
                                    <td>${item.balita_0_59>0?(item.balita_kia/item.balita_0_59) * 100:0}%</td>
                                    
                                    <td>${item.balita_dipantau}</td>
                                    <td>${item.balita_0_59>0?(item.balita_dipantau/item.balita_0_59) * 100:0}%</td>
                                    
                                    <td>${item.balita_sdidtk}</td>
                                    <td>${item.balita_12_59>0?(item.balita_sdidtk/item.balita_12_59) * 100:0}%</td>
                                    
                                    <td>${item.balita_mtbs}</td>
                                    <td>${item.balita_0_59>0?(item.balita_mtbs/item.balita_0_59) * 100:0}%</td>
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
            window.location.href = "/kesehatan_balita?year="+year;


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
			'url'	: '{{ route("KesehatanBalita.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KesehatanBalita.lock") }}',
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "KesehatanBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "KesehatanBalita"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection