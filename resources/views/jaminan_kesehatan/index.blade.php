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
                        <form action="{{ route('JaminanNew') }}" method="POST" class="d-flex w-100 gap-3 align-items-end">
                            @csrf
                            <div class="col-md-5">
                                <label for="nama_kepesertaan">Nama Kepesertaan</label>
                                <input type="text" class="form-control" name="nama_kepesertaan" id="">
                            </div>
                            <div class="col-md-5">
                                <label for="satuan">Golongan</label>
                                <select name="golongan" id="" class="form-control">
                                    <option value="pbi">PBI</option>
                                    <option value="non_pbi">NON PBI</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-25 h-50">Simpan</button>
                        </form>
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <form action="{{url('import_JaminanKesehatan')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/Jaminan KesehatanExample.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                    <a href="{{url("/export_JaminanKesehatan ")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Jenis Kepesertaan</th>
                                <th colspan="2">Peserta Jaminan Kesehatan</th>
                            </tr>
                            <tr>
                                <td>jumlah</td>
                                <td>%</td>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                <tr>
                                    <td colspan="4">PENERIMA BANTUAN IURAN (PBI)</td>
                                </tr>
                                @foreach ($pbi as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama_kepesertaan}}</td>

                                    <td><input type="number" name="jumlah" id="{{$item->id}}" value="{{$item->jumlah}}" class="form-control data-input" style="border: none"></td>
                                    <td id="persen{{$item->id}}">{{$totalPenduduk>0?number_format($item->jumlah/$totalPenduduk, 2):1}}</td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Sub Jumlah Pbi</td>
                                    <td>{{$jumlahPbi}}</td>
                                    <td>{{$totalPenduduk>0?number_format($jumlahPbi/$totalPenduduk, 2):0}}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">NON PBI</td>
                                </tr>
                                @foreach ($nonPbi as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama_kepesertaan}}</td>

                                    <td><input type="number" name="jumlah" id="{{$item->id}}" value="{{$item->jumlah}}" class="form-control data-input" style="border: none"></td>

                                    <td id="persen{{$item->id}}">{{$totalPenduduk>0?number_format($item->jumlah/$totalPenduduk, 2):0}}</td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Sub Jumlah Non Pbi</td>
                                    <td>{{$jumlahNonPbi}}</td>
                                    <td>{{$totalPenduduk>0?number_format($jumlahNonPbi/$totalPenduduk, 2):0}}</td>
                                </tr>

                                <tr>
                                    <td colspan="2">JUMLAH KAB/KOTA</td>
                                    <td>{{$jumlahNonPbi + $jumlahPbi}}</td>
                                    <td>{{$totalPenduduk>0?number_format($jumlahNonPbi + $jumlahPbi/$totalPenduduk, 2):0}}</td>
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
        let persen = $(this).parent().parent().find(`#persen${id}`);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("JaminanKesehatan.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                persen.text(`${res.persen}`);
			}
		});

        console.log(name, value, id, params);
        })
    </script>
@endpush
@endsection
