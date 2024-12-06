@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Visi Rpjmd</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">RPJMD</a></li>
                        <li class="breadcrumb-item active">Visi</li>
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
                    <h4>Jumlah Puskesmas Kabupaten Kutai Timur</h4>
                    <div class="row justify-content-start mb-2">
                        <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" style="background: #f7ac42">Tabel</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" style="background: #c7c7c7">Grafik</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" style="background: #c7c7c7">Peta</button>
                        </div>
                    </div>
                    <table id="data" class="table table-bordered dt-responsive nowrap my-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Fasilitas</th>
                            <th colspan="7">Pengelola</th>
                            <th rowspan="2">Jumlah</th>
                        </tr>
                        <tr>
                            <th>Kemenkes</th>
                            <th>Pem.Prov</th>
                            <th>Pem.Kab/Kota</th>
                            <th>TNI/POLRI</th>
                            <th>BUMN</th>
                            <th>Swasta</th>
                            <th>Organisasi Kemasyarakatan</th>
                        </tr>
                        </thead>

                        <tbody>
                
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>

<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title">Tambah Visi</h5>
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
                'url': '{{ route("datatable.visi_rpjmd") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.induk_opd = $('#induk_opd').val();
                },
            },
            columns: [
                {data:'tahun_awal',name:'tahun_awal'},
                {data:'tahun_akhir',name:'tahun_akhir'},
                {data:'nama',name:'nama'},
                {data:'action',name:'action'},
                // {data:'action',name:'action' , searchable: false},

            ],
        });
        $('#induk_opd').change(function(){
        table.draw();
        });

        $('#datatable').on('click', '.btn-mod2', function(){
            let induk_opd_id = $(this).attr('induk_opd_id');
            let induk_jabatan_id = $(this).attr('induk_jabatan_id');
            let jenis_jabatan_id = $(this).attr('jenis_jabatan_id');
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/visi_rpjmd')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let tahun_awal = `<input type="text" name="tahun_awal" class="form-control" id="bezetting" value="${res.data.tahun_awal}">`
                            let tahun_akhir = `<input type="text" name="tahun_akhir" class="form-control" id="bezetting" value="${res.data.tahun_akhir}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
                <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tahun Awal</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="tahun_awal">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tahun Akhir</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="tahun_akhir">
                </div>
            </div>
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
                $('#tahun_akhir').html(tahun_akhir);
                $('#tahun_awal').html(tahun_awal);
                $('#EditForm').attr('action', `/visi_rpjmd/${id}`)
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


            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tahun Awal</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('tahun_awal',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tahun Akhir</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('tahun_akhir',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Visi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('.modal').modal('toggle');

                // $.ajax({
                //     type: "get",
                //     url: `{{url('api/jabatan')}}/${valueOpd}`,
                //     success: (res) => {
                //         if(res.status == 'success'){
                //             console.log(res);

                //             let option = "<option value='0'>Pilih Unit Organisasi</option>"
                //             let option1 = "<option value='0'>Tidak ada induk</option>"

                //             for(const key in res.data){
                //                 option += `<option value="${res.data[key].id}">${res.data[key].nama}</option>`
                //             }

                //             for(const key in res.dataModel){
                //                 option1 += `<option value="${res.dataModel[key].id}">${"&nbsp;".repeat(res.dataModel[key].level)}${res.dataModel[key].nama}</span></option>`
                //             }


                //         } else {
                //             alert(res.data);
                //         }
                //     }
                // })

    });
    </script>
@endpush
@endsection