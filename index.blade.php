@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Jabatan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                        <li class="breadcrumb-item active">Jabatan</li>
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
                    <div class="row justify-content-end mb-2">
                        <div class="col-md-10 d-flex justify-content-around">
                            {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                        </div>
                        <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" style="background: #f7ac42"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div>
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Unit Organisasi</th>
                            <th>Aksi</th>
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
          <h5 class="modal-title" id="title">Tambah Jabatan</h5>
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
                'url': '{{ route("datatable.jabatan") }}',
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
                {data:'unit_organisasi',name:'unit_organisasi'},
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
                url: `{{url('apiEdit/jabatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let option = "<option value='0'>Pilih Unit Organisasi</option>"
                            let option1 = "<option value='0'>Tidak ada induk</option>"
                            let option2 = "<option value='0'>Tidak ada Jenis Jabatan</option>"

                            for(const key in res.unitOrganisasi){
                                if(res.data.unit_organisasi_id == res.unitOrganisasi[key].id){
                                    option += `<option value="${res.unitOrganisasi[key].id}" selected>${res.unitOrganisasi[key].nama}</option>`
                                } else {
                                    option += `<option value="${res.unitOrganisasi[key].id}">${res.unitOrganisasi[key].nama}</option>`
                                }
                            }

                            for(const key in res.dataModel){
                                if(res.data.induk_jabatan_id == res.dataModel[key].id){
                                    option1 += `<option value="${res.dataModel[key].id}" selected>${"&nbsp;".repeat(res.dataModel[key].level)}${res.dataModel[key].nama}</span></option>`
                                } else {
                                    option1 += `<option value="${res.dataModel[key].id}">${"&nbsp;".repeat(res.dataModel[key].level)}${res.dataModel[key].nama}</span></option>`
                                }
                            }

                            for(const key in res.jenisJabatan){
                                if(res.data.jenis_jabatan_id == res.jenisJabatan[key].id){
                                    option2 += `<option value="${res.jenisJabatan[key].id}" selected>${res.jenisJabatan[key].nama}</span></option>`
                                } else {
                                    option2 += `<option value="${res.jenisJabatan[key].id}">${res.jenisJabatan[key].nama}</span></option>`
                                }
                            }

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let textBezetting = `<input type="text" name="bezetting" class="form-control" id="bezetting" value="${res.data.bezetting}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Induk Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="induk_jabatan_id" id="induk_jabatan_select" class="form-control">
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Jenis Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="jenis_jabatan_id" id="jenis_jabatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Unit Organisasi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="unit_organisasi_id" id="unit_organisasi_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Bezetting</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#unit_organisasi_select').html(option)
                $('#induk_jabatan_select').html(option1)
                $('#jenis_jabatan_select').html(option2)
                $('#nama_field').html(textNama)
                $('#bezettingField').html(textBezetting);
                $('#EditForm').attr('action', `/jabatan/${id}`)
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
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();


                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            console.log(res);

                            let option = "<option value='0'>Pilih Unit Organisasi</option>"
                            let option1 = "<option value='0'>Tidak ada induk</option>"

                            for(const key in res.data){
                                option += `<option value="${res.data[key].id}">${res.data[key].nama}</option>`
                            }

                            for(const key in res.dataModel){
                                option1 += `<option value="${res.dataModel[key].id}">${"&nbsp;".repeat(res.dataModel[key].level)}${res.dataModel[key].nama}</span></option>`
                            }


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Induk Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="induk_jabatan_id" id="induk_jabatan_select" class="form-control">
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Jenis Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::select('jenis_jabatan_id',$jenis_jabatan,"",['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Jenis jabatan']) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Unit Organisasi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="unit_organisasi_id" id="unit_organisasi_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Bezetting</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('bezetting',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#unit_organisasi_select').html(option)
                $('#induk_jabatan_select').html(option1)
                $('.modal').modal('toggle');
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
    </script>
@endpush
@endsection