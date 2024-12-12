@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Detail Wilayah</h4>

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
                        {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        {{-- <form action="{{url('import_KelompokUmur')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/Kelompok Umur Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label> <br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                    <a href="{{url("/export_KelompokUmur")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form> --}}
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-around gap-3">
                                @if(Auth::user()->downloadFile('KelompokUmur', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="KelompokUmur" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('KelompokUmur', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('KelompokUmur', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="KelompokUmur" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>
                                @endif
                                @if(Auth::user()->hasFile('KelompokUmur', Session::get('year')) && Auth::user()->downloadFile('KelompokUmur', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('KelompokUmur', Session::get('year'))->file_path.Auth::user()->downloadFile('KelompokUmur', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{url("/export_KelompokUmur")}}" ><i class="mdi mdi-note"></i>Report</a>
                            </div>
                        </div>
                        <br>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Kelompok Umur</th>
                                <th>Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th>Rasio Jenis Kelamin</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($kelompokUmur as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->batas_bawah}} - {{$item->batas_atas}}</td>

                                    <td><input type="number" name="laki_laki" id="{{$item->id}}" value="{{$item->laki_laki}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="perempuan" id="{{$item->id}}" value="{{$item->perempuan}}" class="form-control data-input" style="border: none"></td>

                                    <td id="total_laki_laki_perempuan{{$item->id}}">{{$item->laki_laki + $item->perempuan}}</td>

                                    <td id="rasio{{$item->id}}">{{$item->perempuan>0?number_format($item->laki_laki/$item->perempuan * 100, 2):0}}</td>

                                </tr>
                                @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{$total_laki_laki}}</td>
                                        <td>{{$total_perempuan}}</td>
                                        <td>{{$total_laki_laki + $total_perempuan}}</td>
                                        <td>{{$total_perempuan > 0?number_format($total_laki_laki/$total_perempuan * 100, 2):0}}</td>
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
        // var table = $('#datatable').DataTable({
        //     responsive:false,
        //     processing: true,
        //     serverSide: true,
        //     order: [[ 0, "asc" ]],
        //     ajax: {
        //         'url': '{{ route("datatable.sub_kegiatan") }}',
        //         'type': 'GET',
        //         'beforeSend': function (request) {
        //             request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
        //         },
        //         data: function (d) {
        //             d.kegiatan_id = $('#kegiatan_id').val();
        //         },
        //     },
        //     columns: [
        //         {data:'kode',name:'kode'},
        //         {data:'nama',name:'nama'},
        //         {data:'sasaran',name:'sasaran'},
        //         {data: 'indikator', name:'indikator'}
        //     ],
        // });

        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');
        let total_laki_laki_perempuan = $(this).parent().parent().find(`#total_laki_laki_perempuan${id}`);
        let rasio = $(this).parent().parent().find(`#rasio${id}`);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KelompokUmur.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                total_laki_laki_perempuan.text(`${res.total_laki_laki_perempuan}`);
                rasio.text(`${res.rasio}%`);
			}
		});

        console.log(name, value, id, params);
        })
    </script>
@endpush
@endsection
