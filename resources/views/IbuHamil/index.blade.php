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
                            @if(Auth::user()->downloadFile('IbuHamil', Session::get('year')))
                            <form action="/upload/IbuHamil" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('IbuHamil', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('IbuHamil', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/IbuHamil" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('IbuHamil', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('IbuHamil', Session::get('year'))->file_path.Auth::user()->downloadFile('IbuHamil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('IbuHamil.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('IbuHamilDanBersalin.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                <th colspan="7">Ibu Hamil</th>
                                <th colspan="9">Ibu Bersalin/Nifas</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Lock data</th>
                                <th rowspan="3">Lock Upload</th>
                                <th rowspan="3" >File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th rowspan="3">Jumlah</th>
                                <th colspan="2">K1</th>
                                <th colspan="2">K4</th>
                                <th colspan="2">K6</th>
                                <th rowspan="3">Jumlah</th>
                                <th colspan="2">Persalinan Di Fasyankes</th>
                                <th colspan="2">Kf1</th>
                                <th colspan="2">Kf Lengkap</th>
                                <th colspan="2">Ibu Bersalin yang diberi Vit A</th>
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
                                    <td>{{$item->jumlah_ibu_hamil(Session::get('year'))}}</td>
                                    <td>{{$item->k1(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_hamil(Session::get('year')) > 0 ? number_format(($item->k1(Session::get('year'))/($item->jumlah_ibu_hamil(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->k4(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_hamil(Session::get('year')) > 0 ? number_format(($item->k4(Session::get('year'))/($item->jumlah_ibu_hamil(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->k6(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_hamil(Session::get('year')) > 0 ? number_format(($item->k6(Session::get('year'))/($item->jumlah_ibu_hamil(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->jumlah_ibu_bersalin(Session::get('year'))}}</td>
                                    <td>{{$item->fasyankes(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_bersalin(Session::get('year')) > 0 ? number_format(($item->fasyankes(Session::get('year'))/($item->jumlah_ibu_bersalin(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->kf1(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_bersalin(Session::get('year')) > 0 ? number_format(($item->kf1(Session::get('year'))/($item->jumlah_ibu_bersalin(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->kf_lengkap(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_bersalin(Session::get('year')) > 0 ? number_format(($item->kf_lengkap(Session::get('year'))/($item->jumlah_ibu_bersalin(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td>{{$item->vita(Session::get('year'))}}</td>
                                    <td>{{$item->jumlah_ibu_bersalin(Session::get('year')) > 0 ? number_format(($item->vita(Session::get('year'))/($item->jumlah_ibu_bersalin(Session::get('year'))))*100, '2'):0}}%</td>
                                    <td><input type="checkbox" name="lock" {{$item->lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('IbuHamil', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('IbuHamil', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('IbuHamil', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('IbuHamil', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('IbuHamil', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('IbuHamil', Session::get('year'))->file_path.$item->user->downloadFile('IbuHamil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                    <td>{{$total_ibu_hamil}}</td>
                                    <td>{{$total_k1}}</td>
                                    <td>{{$total_ibu_hamil > 0?number_format($total_k1/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td>{{$total_k4}}</td>
                                    <td>{{$total_ibu_hamil > 0?number_format($total_k4/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td>{{$total_k6}}</td>
                                    <td>{{$total_ibu_hamil > 0?number_format($total_k6/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td>{{$total_ibu_bersalin}}</td>
                                    <td>{{$total_fasyankes}}</td>
                                    <td>{{$total_ibu_bersalin > 0?number_format($total_fasyankes/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td>{{$total_kf1}}</td>
                                    <td>{{$total_ibu_bersalin > 0?number_format($total_kf1/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td>{{$total_kf_lengkap}}</td>
                                    <td>{{$total_ibu_bersalin > 0?number_format($total_kf_lengkap/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td>{{$total_vita}}</td>
                                    <td>{{$total_ibu_bersalin > 0?number_format($total_vita/$total_ibu_bersalin * 100, 2):0}}%</td>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                               
                                @foreach ($desa as $key => $item)
                                @if($item->filterDesa(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" name="jumlah_ibu_hamil" disabled id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}}  name="k1" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->k1}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="k1{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->k1/($item->filterDesa(Session::get('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" readonly name="k4" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterSasaranTahunDesa(Session::get('year'))?$item->filterSasaranTahunDesa(Session::get('year'))->total_capaian():0}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="k4{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterSasaranTahunDesa(Session::get('year'))?$item->filterSasaranTahunDesa(Session::get('year'))->total_capaian():0/$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 10, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}} name="k6" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->k6}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="k6{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(Session::get('year'))->k6/($item->filterDesa(Session::get('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" name="jumlah_ibu_bersalin" disabled id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}} name="fasyankes" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->fasyankes}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="fasyankes{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(Session::get('year'))->fasyankes/($item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}} name="kf1" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->kf1}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="kf1{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(Session::get('year'))->kf1/($item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}} name="kf_lengkap" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->kf_lengkap}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="kf_lengkap{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(Session::get('year'))->kf_lengkap/($item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterDesa(Session::get('year'))->status == 1?"disabled":""}} name="vita" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->vita}}" class="form-control data-input" style="border: none"></td>
                                    
                                    <td id="vita{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(Session::get('year'))->vita/($item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td id="jumlah_ibu_hamil">{{$total_ibu_hamil}}</td>
                                    <td id="k1">{{$total_k1}}</td>
                                    <td id="percentage_k1">{{$total_ibu_hamil > 0?number_format($total_k1/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td id="k4">{{$total_k4}}</td>
                                    <td id="percentage_k4">{{$total_ibu_hamil > 0?number_format($total_k4/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td id="k6">{{$total_k6}}</td>
                                    <td id="percentage_k6">{{$total_ibu_hamil > 0?number_format($total_k6/$total_ibu_hamil * 100, 2):0}}%</td>
                                    <td id="jumlah_ibu_bersalin">{{$total_ibu_bersalin}}</td>
                                    <td id="fasyankes">{{$total_fasyankes}}</td>
                                    <td id="percentage_fasyankes">{{$total_ibu_bersalin > 0?number_format($total_fasyankes/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td id="kf1">{{$total_kf1}}</td>
                                    <td id="percentage_kf1">{{$total_ibu_bersalin > 0?number_format($total_kf1/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td id="kf_lengkap">{{$total_kf_lengkap}}</td>
                                    <td id="percentage_kf_lengkap">{{$total_ibu_bersalin > 0?number_format($total_kf_lengkap/$total_ibu_bersalin * 100, 2):0}}%</td>
                                    <td id="vita">{{$total_vita}}</td>
                                    <td id="percentage_vita">{{$total_ibu_bersalin > 0?number_format($total_vita/$total_ibu_bersalin * 100, 2):0}}%</td>
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
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');
        let k1 = $(this).parent().parent().find(`#k1${id}`);
        let k4 = $(this).parent().parent().find(`#k4${id}`);
        let k6 = $(this).parent().parent().find(`#k6${id}`);
        let fasyankes = $(this).parent().parent().find(`#fasyankes${id}`);
        let kf1 = $(this).parent().parent().find(`#kf1${id}`);
        let kf_lengkap = $(this).parent().parent().find(`#kf_lengkap${id}`);
        let vita = $(this).parent().parent().find(`#vita${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IbuHamil.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                k1.text(`${res.k1}%`);
                k4.text(`${res.k4}%`);
                k6.text(`${res.k6}%`);
                fasyankes.text(`${res.fasyankes}%`);
                kf1.text(`${res.kf1}%`);
                kf_lengkap.text(`${res.kf_lengkap}%`);
                vita.text(`${res.vita}%`);
                let total_column = res.column;
                $(`#${total_column}`).text(res.total);
                $(`#percentage_${total_column}`).text(`${res.percentage}%`);
			}
		});
        
        console.log(name, value, id, params);
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
			'url'	: `/IbuHamil/detail_desa/${id}`,
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
                                    <td id="jumlah_ibu_hamil">${item.jumlah_ibu_hamil}</td>
                                    <td id="k1">${item.k1}</td>
                                    <td id="percentage_k1">${item.jumlah_ibu_hamil > 0?(item.k1/item.jumlah_ibu_hamil) * 100:0}%</td>
                                    <td id="k4">${item.k4}</td>
                                    <td id="percentage_k4">${item.jumlah_ibu_hamil > 0?(item.k4/item.jumlah_ibu_hamil) * 100:0}%</td>
                                    <td id="k6">${item.k6}</td>
                                    <td id="percentage_k6">${item.jumlah_ibu_hamil > 0?(item.k6/item.jumlah_ibu_hamil) * 100:0}%</td>
                                    <td id="jumlah_ibu_bersalin">${item.jumlah_ibu_bersalin}</td>
                                    <td id="fasyankes">${item.fasyankes}</td>
                                    <td id="percentage_fasyankes">${item.jumlah_ibu_bersalin > 0?(item.fasyankes/item.jumlah_ibu_bersalin) * 100:0}%</td>
                                    <td id="kf1">${item.kf1}</td>
                                    <td id="percentage_kf1">${item.jumlah_ibu_bersalin > 0?(item.kf1/item.jumlah_ibu_bersalin) * 100:0}%</td>
                                    <td id="kf_lengkap">${item.kf_lengkap}</td>
                                    <td id="percentage_kf_lengkap">${item.jumlah_ibu_bersalin > 0?(item.kf_lengkap/item.jumlah_ibu_bersalin) * 100:0}%</td>
                                    <td id="vita">${item.vita}</td>
                                    <td id="percentage_vita">${item.jumlah_ibu_bersalin > 0?(item.vita/item.jumlah_ibu_bersalin) * 100:0}%</td>
                        
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
            let month = $("#month").val();
            window.location.href = "/IbuHamil?year="+year+"&month="+month;


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
			'url'	: '{{ route("IbuHamil.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IbuHamil.lock") }}',
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
			'url'	: '{{ route("IbuHamil.lock_upload") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IbuHamil.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection