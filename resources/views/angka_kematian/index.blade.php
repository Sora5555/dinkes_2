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
                        {{-- <form action="{{url('import_AngkaKematian')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/AngkaKematian Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                    <a href="{{url("/export_AngkaKematian")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form> --}}
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-around gap-3">
                                @if(Auth::user()->downloadFile('AngkaKematian', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="AngkaKematian" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('AngkaKematian', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('AngkaKematian', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="AngkaKematian" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>
                                @endif
                                @if(Auth::user()->hasFile('AngkaKematian', Session::get('year')) && Auth::user()->downloadFile('AngkaKematian', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('AngkaKematian', Session::get('year'))->file_path.Auth::user()->downloadFile('AngkaKematian', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{url("/export_AngkaKematian")}}" ><i class="mdi mdi-note"></i>Report</a>
                            </div>
                        </div>
                        <br>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Rumah Sakit</th>
                                <th rowspan="2">Jumlah Tempat Tidur</th>
                                <th colspan="3">PASIEN KELUAR (HIDUP + MATI)</th>
                                <th colspan="3">PASIEN KELUAR MATI</th>
                                <th colspan="3">PASIEN KELUAR MATI >= 48 jam dirawat</th>
                                <th colspan="3">GROSS DEATH RATE</th>
                                <th colspan="3">NET DEATH RATE</th>
                            </tr>
                            <tr>
                                <th style="white-space:nowrap">Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th style="white-space:nowrap">Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th style="white-space:nowrap">Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th style="white-space:nowrap">Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                                <th style="white-space:nowrap">Laki Laki</th>
                                <th>Perempuan</th>
                                <th>Laki Laki + Perempuan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($AngkaKematian as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 2}}</td>
                                    <td>{{$item->nama_rumah_sakit}}</td>

                                    <td><input type="number" name="jumlah_tempat_tidur" id="{{$item->id}}" value="{{$item->jumlah_tempat_tidur}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="pasien_keluar_hidup_mati_L" id="{{$item->id}}" value="{{$item->pasien_keluar_hidup_mati_L}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="pasien_keluar_hidup_mati_P" id="{{$item->id}}" value="{{$item->pasien_keluar_hidup_mati_P}}" class="form-control data-input" style="border: none"></td>

                                    <td id="jumlah_pasien_keluar_hidup_mati{{$item->id}}">{{$item->pasien_keluar_hidup_mati_P + $item->pasien_keluar_hidup_mati_L}}</td>

                                    <td><input type="number" name="pasien_keluar_mati_L" id="{{$item->id}}" value="{{$item->pasien_keluar_mati_L}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="pasien_keluar_mati_P" id="{{$item->id}}" value="{{$item->pasien_keluar_mati_P}}" class="form-control data-input" style="border: none"></td>

                                    <td id="jumlah_pasien_keluar_mati{{$item->id}}">{{$item->pasien_keluar_mati_L + $item->pasien_keluar__mati_P}}</td>

                                    <td><input type="number" name="pasien_keluar_mati_48_L" id="{{$item->id}}" value="{{$item->pasien_keluar_mati_48_L}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="pasien_keluar_mati_48_P" id="{{$item->id}}" value="{{$item->pasien_keluar_mati_48_P}}" class="form-control data-input" style="border: none"></td>

                                    <td id="jumlah_pasien_keluar_mati_48{{$item->id}}">{{$item->pasien_keluar_mati_L + $item->pasien_keluar__mati_P}}</td>

                                    <td id="gross_death_rate_L{{$item->id}}">{{$item->pasien_keluar_hidup_mati_L>0?number_format($item->pasien_keluar_mati_L/$item->pasien_keluar_hidup_mati_L * 100, 2):0}}</td>

                                    <td id="gross_death_rate_P{{$item->id}}">{{$item->pasien_keluar_hidup_mati_P>0?number_format($item->pasien_keluar_mati_P/$item->pasien_keluar_hidup_mati_P * 100, 2):0}}</td>

                                    <td id="gross_death_rate_LP{{$item->id}}">{{$item->pasien_keluar_hidup_mati_P+$item->pasien_keluar_hidup_mati_L>0?number_format(($item->pasien_keluar_mati_P+$item->pasien_keluar_mati_L)/($item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P) * 100, 2):0}}</td>

                                    <td id="net_death_rate_L{{$item->id}}">{{$item->pasien_keluar_mati_48_L>0?number_format($item->pasien_keluar_mati_L/$item->pasien_keluar_mati_48_L * 100, 2):0}}</td>

                                    <td id="net_death_rate_P{{$item->id}}">{{$item->pasien_keluar_mati_48_P>0?number_format($item->pasien_keluar_mati_P/$item->pasien_keluar_mati_48_P * 100, 2):0}}</td>

                                    <td id="net_death_rate_LP{{$item->id}}">{{$item->pasien_keluar_mati_48_P+$item->pasien_keluar_mati_48_L>0?number_format(($item->pasien_keluar_mati_P+$item->pasien_keluar_mati_L)/($item->pasien_keluar_mati_48_L + $item->pasien_keluar_mati_48_P) * 100, 2):0}}</td>
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
        let jumlah_pasien_keluar_hidup_mati = $(this).parent().parent().find(`#jumlah_pasien_keluar_hidup_mati${id}`);
        let jumlah_pasien_keluar_mati = $(this).parent().parent().find(`#jumlah_pasien_keluar_mati${id}`);
        let jumlah_pasien_keluar_mati_48 = $(this).parent().parent().find(`#jumlah_pasien_keluar_mati_48${id}`);
        let gross_death_rate_L = $(this).parent().parent().find(`#gross_death_rate_L${id}`);
        let gross_death_rate_P = $(this).parent().parent().find(`#gross_death_rate_P${id}`);
        let gross_death_rate_LP = $(this).parent().parent().find(`#gross_death_rate_LP${id}`);
        let net_death_rate_L = $(this).parent().parent().find(`#net_death_rate_L${id}`);
        let net_death_rate_P = $(this).parent().parent().find(`#net_death_rate_P${id}`);
        let net_death_rate_LP = $(this).parent().parent().find(`#net_death_rate_LP${id}`);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("AngkaKematian.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                jumlah_pasien_keluar_hidup_mati.text(`${res.jumlah_pasien_keluar_hidup_mati}`);
                jumlah_pasien_keluar_mati.text(`${res.jumlah_pasien_keluar_mati}`);
                jumlah_pasien_keluar_mati_48.text(`${res.jumlah_pasien_keluar_mati_48}`);
                gross_death_rate_L.text(`${res.gross_death_rate_L}`);
                gross_death_rate_P.text(`${res.gross_death_rate_P}`);
                gross_death_rate_LP.text(`${res.gross_death_rate_LP}`);
                net_death_rate_L.text(`${res.net_death_rate_L}`);
                net_death_rate_P.text(`${res.net_death_rate_P}`);
                net_death_rate_LP.text(`${res.net_death_rate_LP}`);
			}
		});

        console.log(name, value, id, params);
        })
    </script>
@endpush
@endsection
