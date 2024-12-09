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
                            <form action="{{ route('VaksinNew') }}" method="POST" class="d-flex w-100 gap-3 align-items-end">
                                @csrf
                                <div class="col-md-5">
                                    <label for="nama_vaksin">Nama Vaksin</label>
                                    <input type="text" class="form-control" name="nama_vaksin" id="">
                                </div>
                                <div class="col-md-5">
                                    <label for="satuan">Satuan</label>
                                    <select name="satuan" id="" class="form-control">
                                        <option value="Tablet">Tablet</option>
                                        <option value="Vial">Vial</option>
                                        <option value="Ampul">Ampul</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-25 h-50">Simpan</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form action="{{url('import_Vaksin')}}" method="post" enctype="multipart/form-data">
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
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Vaksin</th>
                                <th rowspan="2">Satuan</th>
                                <th rowspan="2">Ketersediaan Vaksin</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($vaksin as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama_vaksin}}</td>
                                    <td>{{$item->satuan}}</td>

                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex flex-column align-items-start">
                                                <label for="diatas_80"> > 80%</label>
                                                <input type="checkbox" {{$item->status == 1?"checked":""}} name="diatas_80" id="{{$item->id}}" class="data-input">
                                            </div>
                                            <div class="d-flex flex-column align-items-start">
                                                <label for="dibawah_80"> < 80% </label>
                                                <input type="checkbox" {{$item->status == 2?"checked":""}} name="dibawah_80" id="{{$item->id}}" class="data-input">
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3">JUMLAH ITEM VAKSIN IDL YANG TERSEDIA DI KABUPATEN/KOTA</td>
                                    <td>{{$vaksin_tersedia}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">% KABUPATEN/KOTA DENGAN KETERSEDIAAN VAKSIN IDL</td>
                                    <td>{{$total_vaksin?number_format($vaksin_tersedia/$total_vaksin * 100, 2):0}}%</td>
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
			'url'	: '{{ route("Vaksin.store") }}',
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
