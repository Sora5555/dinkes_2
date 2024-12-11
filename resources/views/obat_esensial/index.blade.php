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
                        <div class="col-md-10 d-flex justify-content-around gap-3">
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{-- <form action="{{url('import_ObatEsensial')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/ObatEsensial Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>

                                    <a href="{{url("/export_ObatEsensial")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form> --}}
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-around gap-3">
                                @if(Auth::user()->downloadFile('ObatEsensial', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="ObatEsensial" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('ObatEsensial', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('ObatEsensial', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="ObatEsensial" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>
                                @endif
                                @if(Auth::user()->hasFile('ObatEsensial', Session::get('year')) && Auth::user()->downloadFile('ObatEsensial', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('ObatEsensial', Session::get('year'))->file_path.Auth::user()->downloadFile('ObatEsensial', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                {{-- <a type="button" class="btn btn-warning" href="{{ route('ImdAsi.excel') }}" ><i class="mdi mdi-note"></i>Report</a> --}}
                            </div>
                        </div>
                        <br>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Unit Kerja</th>
                                <th rowspan="2">Ketersediaan obat esensial</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama}}</td>

                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex flex-column align-items-start">
                                                <label for="diatas_80"> > 80%</label>
                                                <input type="checkbox" {{$item->ObatEsensial ? $item->ObatEsensial->status == 1?"checked":"" : ""}} name="diatas_80" id="{{$item->id}}" class="data-input">
                                            </div>
                                            <div class="d-flex flex-column align-items-start">
                                                <label for="dibawah_80"> < 80% </label>
                                                <input type="checkbox" {{  $item->ObatEsensial ?  $item->ObatEsensial->status == 2?"checked":"" : ""}} name="dibawah_80" id="{{$item->id}}" class="data-input">
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">JUMLAH PUSKESMAS YANG MEMILIKI 80% OBAT DAN VAKSIN ESENSIAL</td>
                                    <td>{{$obat_tersedia}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">JUMLAH PUSKESMAS YANG MELAPOR</td>
                                    <td>{{$total_obat}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">% KABUPATEN/KOTA DENGAN KETERSEDIAAN OBAT ESENSIAL</td>
                                    <td>{{$total_obat?number_format($obat_tersedia/$total_obat * 100, 2):0}}%</td>
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
        let id = $(this).attr('id');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("ObatEsensial.store") }}',
			'data'	: {'name' : name, 'id': id},
			success	: function(res){
               if(res.err != ""){
                alert(res.err)
               }
			}
		});

        })
    </script>
@endpush
@endsection
