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
                        <form action="{{url('import_MelekHuruf')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Variabel</th>
                                <th colspan="3">Jumlah</th>
                                <th colspan="3">Persentase</th>
                            </tr>
                            <tr>
                                <th>Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th>Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>PENDUDUK BERUMUR 15 TAHUN KE ATAS</td>

                                    <td>{{$laki_laki}}</td>

                                    <td>{{$perempuan}}</td>

                                    <td>{{$laki_laki + $perempuan}}</td>

                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                @role('Admin|superadmin')
                                @foreach ($MelekHuruf as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 2}}</td>
                                    <td>{{$item->variabel}}</td>

                                    <td><input type="number" name="laki_laki" id="{{$item->id}}" value="{{$item->laki_laki}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="perempuan" id="{{$item->id}}" value="{{$item->perempuan}}" class="form-control data-input" style="border: none"></td>

                                    <td id="total_laki_laki_perempuan{{$item->id}}">{{$item->laki_laki + $item->perempuan}}</td>

                                    <td id="persen_laki_laki{{$item->id}}">{{$laki_laki>0?number_format($item->laki_laki/$laki_laki * 100, 2):0}}</td>
                                    <td id="persen_perempuan{{$item->id}}">{{$perempuan>0?number_format($item->perempuan/$perempuan * 100, 2):0}}</td>
                                    <td id="persen_laki_laki_perempuan{{$item->id}}">{{$perempuan + $laki_laki>0?number_format(($item->perempuan + $item->laki_laki)/($perempuan + $laki_laki) * 100, 2):0}}</td>

                                </tr>
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
        let persen_laki_laki = $(this).parent().parent().find(`#persen_laki_laki${id}`);
        let persen_perempuan = $(this).parent().parent().find(`#persen_perempuan${id}`);
        let persen_laki_laki_perempuan = $(this).parent().parent().find(`#persen_laki_laki_perempuan${id}`);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("MelekHuruf.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                total_laki_laki_perempuan.text(`${res.total_laki_laki_perempuan}`);
                persen_laki_laki.text(`${res.persen_laki_laki}`);
                persen_perempuan.text(`${res.persen_perempuan}`);
                persen_laki_laki_perempuan.text(`${res.persen_laki_laki_perempuan}`);
			}
		});

        console.log(name, value, id, params);
        })
    </script>
@endpush
@endsection
