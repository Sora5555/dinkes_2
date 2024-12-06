@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Laporan Keselarasan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan</a></li>
                        <li class="breadcrumb-item active">Keselarasan</li>
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
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="row justify-content-end mb-2">
                        <div class="col-md-12 d-flex justify-content-start">
                            {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                            <tr style="background:#cccccc">
                                <td>No</td>
                                <td >Sasaran</td>
                                <td  align="center">Sasaran Strategis Berorientasi Hasil</td>
                                <td >No</td>
                                <td >Indikator Sasaran Strategis</td>
                                <td >Indikator Sasaran Strategis Berkualitas</td>
                                <td >Iku/Bukan Iku</td>
                                <td >No</td>
                                <td style="white-space: nowrap">Uraian Program</td>
                                <td style="white-space: nowrap">Sasaran Program</td>
                                <td style="white-space: nowrap">Indikator Program</td>
                                <td style="white-space: nowrap">Program Terkait Dengan Sasaran</td>
                                <td style="white-space: nowrap">Uraian Kegiatan</td>
                                <td style="white-space: nowrap">Sasaran Kegiatan</td>
                                <td style="white-space: nowrap">Indikator Kegiatan</td>
                                <td style="white-space: nowrap">Sasaran Terkait dengan Kegiatan</td>
                                <td style="white-space: nowrap">Uraian Sub Kegiatan</td>
                                <td style="white-space: nowrap">Sasaran Sub Kegiatan</td>
                                <td style="white-space: nowrap">Indikator Sub Kegiatan</td>
                                <td >Anggaran</td>
                                <td >Ket</td>
                            </tr>
                        </thead>
                        <tbody>
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
          <h5 class="modal-title" id="title">Tambah Misi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit" class="btn" style="background: #f7ac42" id="submitButton" form="storeForm">
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
            searching: true,
            order: [],
            ajax: {
                'url': '{{ route("datatable.keselarasan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.induk_opd = $('#induk_opd').val();
                },
            },
            columns: [
                {data:'sasaran_id',name:'sasaran_id'},
                {data:'nama_sasaran',name:'nama_sasaran'},
                {data:'checklist_sasaran_hasil',name:'checklist_sasaran_hasil'},
                {data: 'indikator_opd_nomor', name:'indikator_opd_nomor'},
                {data: 'indikator_opd', name:'indikator_opd'},
                {data: 'checklist_indikator_berkualitas', name:'checklist_indikator_berkualitas'},
                {data: 'iku_bukan_iku_indikator_renstra', name: 'iku_bukan_iku_indikator_renstra'},
                {data: 'nomor_detail_program', name: 'nomor_detail_program'},
                {data: 'detail_program', name: 'detail_program'},
                {data: 'detail_sasaran_program', name: 'detail_sasaran_program'},
                {data: 'detail_indikator_program', name: 'detail_indikator_program'},
                {data: 'checklist_program_terkait', name: 'checklist_program_terkait'},
                {data: 'detail_kegiatan', name: 'detail_kegiatan'},
                {data: 'detail_sasaran_kegiatan', name: 'detail_sasaran_kegiatan'},
                {data: 'detail_indikator_kegiatan', name: 'detail_indikator_kegiatan'},
                {data: 'checklist_kegiatan_terkait', name: 'checklist_kegiatan_terkait'},
                {data: 'detail_sub_kegiatan', name: 'detail_sub_kegiatan'},
                {data: 'detail_sasaran_sub_kegiatan', name: 'detail_sasaran_sub_kegiatan'},
                {data: 'detail_indikator_sub_kegiatan', name: 'detail_indikator_sub_kegiatan'},
                {data: 'anggaran', name: 'anggaran'},
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
                // null,
              
                // {data:'action',name:'action' , searchable: false},

            ],
        });
        $('#induk_opd').change(function(){
        table.draw();
        });
        $('#datatable').on('change', '.checklist-hasil-sasaran', function(){
           let id = $(this).attr('id');

           $.ajax({
            type: "get",
            url: `{{url('apiEdit/hasilSasaran')}}/${id}`,
            success: (res) => {
            if(res.status == "success"){
                alert(res.message)
            } else {
                alert("Ada Yang salah saat pengambilan data");
            }
            }
        })
        })
        $('#datatable').on('change', '.checklist-indikator-opd-berkualitas', function(){
           let id = $(this).attr('id');

           $.ajax({
            type: "get",
            url: `{{url('apiEdit/indikatorOpdBerkualitas')}}/${id}`,
            success: (res) => {
            if(res.status == "success"){
                alert(res.message)
            } else {
                alert("Ada Yang salah saat pengambilan data");
            }
            }
        })
        })
        $('#datatable').on('change', '.checklist-indikator-pemerintah-berkualitas', function(){
           let id = $(this).attr('id');

           $.ajax({
            type: "get",
            url: `{{url('apiEdit/indikatorPemerintahBerkualitas')}}/${id}`,
            success: (res) => {
            if(res.status == "success"){
                alert(res.message)
            } else {
                alert("Ada Yang salah saat pengambilan data");
            }
            }
        })
        })
        $('#datatable').on('change', '.checklist-iku-renstra', function(){
           let id = $(this).attr('id');

           $.ajax({
            type: "get",
            url: `{{url('apiEdit/ikurenstra')}}/${id}`,
            success: (res) => {
            if(res.status == "success"){
                alert(res.message)
            } else {
                alert("Ada Yang salah saat pengambilan data");
            }
            }
        })
        })
        $('#table').on('click', '.btn-mod2', function(){
            let induk_opd_id = $(this).attr('induk_opd_id');
            let induk_jabatan_id = $(this).attr('induk_jabatan_id');
            let jenis_jabatan_id = $(this).attr('jenis_jabatan_id');
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/misi_rpjmd')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Visi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/misi_rpjmd/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data jabatan');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })


        $('.btn-mod').click(function(){
            let id = $(this).attr('id');

            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <button type="button" id="tambah_misi" class="btn col-md-3" style="background: #42d408; font-weight: bold">Tambah Misi</button>
            <div id="misi_field">
                <input name="visi_rpjmd_id" type="hidden" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Misi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama[]',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            </div>
                `
                $('.modal-body').html(template)
                $('.modal').modal('toggle');

    });

    $(".modal").on("click", '#tambah_misi', function(){
        let template = `
        <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama[]',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
        `
        $("#misi_field").append(template);
    })
    </script>
@endpush
@endsection