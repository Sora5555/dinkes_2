@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tenaga Penunjang dan Pendukung</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                        <li class="breadcrumb-item active">Jumlah Tenaga Penunjang dan Pendukung</li>
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
                        {{-- <div class="col-md-10 d-flex justify-content-start">
                            {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                            <select name="program_id" form="storeForm" id="program_id" class="form-control">
                                <option value="">Pilih Program</option>
                            </select>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="2023">2023</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
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
                                <th colspan="3">Pejabat Struktural</th>
                                <th colspan="3">Tenaga Pendidik</th>
                                <th colspan="3">Tenaga Pendukung Manajemen</th>
                                <th colspan="3">Total</th>
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
                                        <td>{{$item->PejabatStruktural->laki_laki}}</td>
                                        <td>{{$item->PejabatStruktural->perempuan}}</td>
                                        <td>{{$item->PejabatStruktural->laki_laki + $item->PejabatStruktural->perempuan}}</td>
                                        <td>{{$item->TenagaPendidik->laki_laki}}</td>
                                        <td>{{$item->TenagaPendidik->perempuan}}</td>
                                        <td>{{$item->TenagaPendidik->laki_laki + $item->TenagaPendidik->perempuan}}</td>
                                        <td>{{$item->Manajemen->laki_laki}}</td>
                                        <td>{{$item->Manajemen->perempuan}}</td>
                                        <td>{{$item->Manajemen->laki_laki + $item->Manajemen->perempuan}}</td>
                                        <td>{{$item->Manajemen->laki_laki + $item->TenagaPendidik->laki_laki + $item->PejabatStruktural->laki_laki}}</td>
                                        <td>{{$item->Manajemen->perempuan + $item->TenagaPendidik->perempuan + $item->PejabatStruktural->perempuan}}</td>
                                        <td>{{$item->Manajemen->laki_laki + $item->Manajemen->perempuan + $item->TenagaPendidik->laki_laki + $item->TenagaPendidik->perempuan + $item->PejabatStruktural->laki_laki + $item->PejabatStruktural->perempuan}}</td>
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
        var table = $('#datatable').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            order: [[ 0, "asc" ]],
            ajax: {
                'url': '{{ route("datatable.kegiatan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.program_id = $('#program_id').val();
                },
            },
            columns: [
                {data:'kode',name:'kode'},
                {data:'nama',name:'nama'},
                {data:'sasaran',name:'sasaran'},
                {data: 'indikator', name:'indikator'}
            ],
        });
        $('#induk_opd').change(function(){
            let valueOpd = $("#induk_opd").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiProgram/kegiatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Program</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#program_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });

        $("#program_id").change(function(){
            table.draw()
        })
        $('.btn-tambah-program').click(function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();
                let program_id = $("#program_id").val();


                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="program_id" value="${program_id}">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('uraian',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kode</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('kode',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Kegiatan');
                $('.modal').modal('toggle');
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
    $('#data').on('click', '.btn-mod2', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/penunjang')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            console.log(res.data)
                            let textUraian = `<input type="text" name="pejabatStrukturalLakiLaki" id="nama" class="form-control" value="${res.pejabatStruktural.laki_laki}">`
                            let textKode = `<input type="text" name="pejabatStrukturalPerempuan" class="form-control" id="bezetting" value="${res.pejabatStruktural.perempuan}">`
                            let textTenagaPendidikLakiLaki = `<input type="text" name="tenagaPendidikLakiLaki" class="form-control" id="bezetting" value="${res.tenagaPendidik.laki_laki}">`
                            let textTenagaPendidikPerempuan = `<input type="text" name="tenagaPendidikPerempuan" class="form-control" id="bezetting" value="${res.tenagaPendidik.perempuan}">`
                            let textPendukungManajemenLakiLaki = `<input type="text" name="pendukungManajemenLakiLaki" class="form-control" id="bezetting" value="${res.pendukungManajemen.laki_laki}">`
                            let textPendukungManajemenPerempuan = `<input type="text" name="pendukungManajemenPerempuan" class="form-control" id="bezetting" value="${res.pendukungManajemen.perempuan}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pejabat Struktural (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pejabat Struktural (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Pendidik (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="tenagaPendidikLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Pendidik (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="tenagaPendidikPerempuanField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pendukung Manajemen (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="pendukungManajemenLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pendukung Manajemen (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="pendukungManajemenPerempuanField">
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#tenagaPendidikLakiLakiField').html(textTenagaPendidikLakiLaki);
                $('#tenagaPendidikPerempuanField').html(textTenagaPendidikPerempuan);
                $('#pendukungManajemenLakiLakiField').html(textPendukungManajemenLakiLaki);
                $('#pendukungManajemenPerempuanField').html(textPendukungManajemenPerempuan);
                $('#EditForm').attr('action', `/kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Program');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
    $('#datatable').on('click', '.btn-tambah-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/program')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textUraian = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'sasaranKegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sasaran');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaranKegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'sasaranKegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/sasaranKegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Sasaran Kegiatan');
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-tambah-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaranProgram')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'indikatorKegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sasaran_kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#title').html('Tambah Data Indikator');
                $('#submitButton').attr('form', 'storeForm')
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/indikatorKegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'indikatorProgram.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/indikatorKegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Indikator Program');
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