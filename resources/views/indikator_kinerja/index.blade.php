@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Indikator Kinerja Pelayanan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Indikator Kinerja Pelayanan</li>
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
                        <form action="{{url('import_IndikatorKinerja')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/IndikatorKinerja Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                    <a href="{{url("/export_IndikatorKinerja")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form>
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Rumah Sakit</th>
                                <th>Jumlah Tempat Tidur</th>
                                <th>PASIEN KELUAR (HIDUP + MATI)</th>
                                <th>JUMLAH HARI PERAWATAN</th>
                                <th>JUMLAH LAMA DIRAWAT</th>
                                <th>BOR (%)</th>
                                <th>BTO (KALI)</th>
                                <th>TOI (HARI)</th>
                                <th>ALOS (HARI)</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($AngkaKematian as $key => $item)
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 2}}</td>
                                    <td>{{$item->nama_rumah_sakit}}</td>

                                    <td>{{$item->jumlah_tempat_tidur}}</td>

                                    <td>{{$item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P}}</td>

                                    <td><input type="number" name="jumlah_hari_perawatan" id="{{$item->id}}" value="{{$item->jumlah_hari_perawatan}}" class="form-control data-input" style="border: none"></td>

                                    <td><input type="number" name="jumlah_lama_dirawat" id="{{$item->id}}" value="{{$item->jumlah_lama_dirawat}}" class="form-control data-input" style="border: none"></td>

                                    <td id="bor{{$item->id}}">{{$item->jumlah_tempat_tidur>0?number_format($item->jumlah_hari_perawatan/($item->jumlah_tempat_tidur * 365) * 100, 2):0}}</td>

                                    <td id="bto{{$item->id}}">{{$item->jumlah_tempat_tidur>0?number_format(($item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P)/($item->jumlah_tempat_tidur), 2):0}}</td>

                                    <td id="toi{{$item->id}}">{{$item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P>0?number_format((($item->jumlah_tempat_tidur * 365)-$item->jumlah_hari_perawatan)/($item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P), 2):0}}</td>

                                    <td id="alos{{$item->id}}">{{$item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P>0?number_format(($item->jumlah_lama_dirawat)/($item->pasien_keluar_hidup_mati_L + $item->pasien_keluar_hidup_mati_P), 2):0}}</td>

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
        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');
        let bor = $(this).parent().parent().find(`#bor${id}`);
        let bto = $(this).parent().parent().find(`#bto${id}`);
        let toi = $(this).parent().parent().find(`#toi${id}`);
        let alos = $(this).parent().parent().find(`#alos${id}`);

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IndikatorKinerja.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                bor.text(`${res.bor}`);
                bto.text(`${res.bto}`);
                toi.text(`${res.toi}`);
                alos.text(`${res.alos}`);
			}
		});

        console.log(name, value, id, params);
        })
    </script>
@endpush
@endsection
