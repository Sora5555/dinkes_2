@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tenaga Kesehatan Masyararakat, Lingkungan dan Gizi</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Masyarakat, Lingkungan dan Gizi</li>
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
                    {{-- <div class="row justify-content-end mb-2">
                        <div class="col-md-10 d-flex justify-content-around">
                            {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-mod col-md-12" style="background: #f7ac42"><i class="mdi mdi-plus"></i> Tambah</a>
                        </div>
                    </div> --}}
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered" style="width:100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Unit Kerja</th>
                                <th colspan="3">Tenaga Kesehatan Masyarakat</th>
                                <th colspan="3">Tenaga Kesehatan Lingkungan</th>
                                <th colspan="3">Tenaga Gizi</th>
                                @role("Pihak Wajib Pajak")
                                <th rowspan="2">Action</th>
                                @endrole
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($unit_kerja as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->TenagaKesehatanMasyarakat->laki_laki}}</td>
                                        <td>{{$item->TenagaKesehatanMasyarakat->perempuan}}</td>
                                        <td>{{$item->TenagaKesehatanMasyarakat->laki_laki + $item->TenagaKesehatanMasyarakat->perempuan}}</td>
                                        <td>{{$item->TenagaKesehatanLingkungan->laki_laki}}</td>
                                        <td>{{$item->TenagaKesehatanLingkungan->perempuan}}</td>
                                        <td>{{$item->TenagaKesehatanLingkungan->laki_laki + $item->TenagaKesehatanLingkungan->perempuan}}</td>
                                        <td>{{$item->TenagaGizi->laki_laki}}</td>
                                        <td>{{$item->TenagaGizi->perempuan}}</td>
                                        <td>{{$item->TenagaGizi->laki_laki + $item->TenagaGizi->perempuan}}</td>
                                        @role("Pihak Wajib Pajak")
                                        <td><a class="btn btn-mod2 btn-warning" id="{{$item->id}}"><i class="mdi mdi-pen"></a></td>
                                        @endrole
                                    </tr>
                                @endforeach
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
          <h5 class="modal-title">Tambah Unit Organisasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama Unit Organisasi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit" class="btn btn-primary" id="submitButton">
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
        var table = $('#datatable').removeAttr('width').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            autoWidth: false,
            order: [[ 0, "desc" ]],
            ajax: {
                'url': '{{ route("datatable.kategori_npa") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.induk_opd = $('#induk_opd').val();
                },
            },
            columns: [
                {data:'nama',name:'nama'},
                {data:'eselon',name:'eselon'},
                {data:'action',name:'action' , searchable: false},

            ],
        });
        $('#induk_opd').change(function(){
        table.draw();
        });
        $('.btn-mod').click(function(){
            if($('#induk_opd').val()== ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                $('.modal').modal('toggle');
            }
    });

    $('#data').on('click', '.btn-mod2', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/kesehatanMasyarakat')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textUraian = `<input type="text" name="kesehatanMasyarakatLakiLaki" id="nama" class="form-control" value="${res.kesehatanMasyarakat.laki_laki}">`
                            let textKode = `<input type="text" name="kesehatanMasyarakatPerempuan" class="form-control" id="bezetting" value="${res.kesehatanMasyarakat.perempuan}">`
                            let textTenagaGiziLakiLaki = `<input type="text" name="tenagaGiziLakiLaki" class="form-control" id="bezetting" value="${res.tenagaGizi.laki_laki}">`
                            let textTenagaGiziPerempuan = `<input type="text" name="tenagaGiziPerempuan" class="form-control" id="bezetting" value="${res.tenagaGizi.perempuan}">`
                            let textKesehatanLingkunganLakiLaki = `<input type="text" name="kesehatanLingkunganLakiLaki" class="form-control" id="bezetting" value="${res.kesehatanLingkungan.laki_laki}">`
                            let textKesehatanLingkunganPerempuan = `<input type="text" name="kesehatanLingkunganPerempuan" class="form-control" id="bezetting" value="${res.kesehatanLingkungan.perempuan}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Kesehatan Masyarakat (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Kesehatan Masyarakat (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Gizi (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="apotekerLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Gizi (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="apotekerPerempuanField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kesehatan Lingkungan (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="LabMedikLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kesehatan Lingkungan (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="LabMedikPerempuanField">
                </div>
            </div>          
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#apotekerLakiLakiField').html(textTenagaGiziLakiLaki)
                $('#apotekerPerempuanField').html(textTenagaGiziPerempuan);
                $('#LabMedikLakiLakiField').html(textKesehatanLingkunganLakiLaki);
                $('#LabMedikPerempuanField').html(textKesehatanLingkunganPerempuan);
                $('#EditForm').attr('action', `/unit_organisasi/${id}`);
                $('#submitButton').attr('form', 'EditForm');
                $('#title').html('Ubah data');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
    </script>
@endpush
@endsection