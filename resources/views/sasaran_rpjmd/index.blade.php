@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Sasaran Rpjmd</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">RPJMD</a></li>
                        <li class="breadcrumb-item active">Sasaran</li>
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
                    <table id="table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    @if(count($visi) > 0)
                        @foreach ($visi as $v)
                        <thead class="text-center">
                            <tr style="background:#d6dad5" align="center">
                               <th colspan="4">{{$v->tahun_awal}} - {{$v->tahun_akhir}}</th>
                            </tr>
                            <tr style="background:#f5c4c4" align="left">
                                <th colspan="4"><span style="text-align: left">Visi: {{$v->nama}}</span></th>
                            </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($v->Misi as $M)
                                <tr style="background:#c4dbf5" align="left">
                                    <th colspan="4"><span style="padding-left: 7px">Misi: {{$M->nama}}</span></th>
                                </tr>
                                <tr align="center">
                                    <td colspan="2">Tujuan:</td>
                                    <td colspan="2">Sasaran:</td>
                                </tr>
                                @foreach ($M->tujuan as $t)
                                    @if (count($t->Sasaran) > 0)
                                    @foreach ($t->Sasaran as $key => $s)
                                    <tr>
                                        @if($key==0)
                                            <td>{{$t->nama}}</td>
                                            <td><button class="btn col-md-5 btn-mod" id="{{$t->id}}" style="background: #42d408"><i class="mdi mdi-plus"></i></button></td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        <td>{{$s->nama}}</td>
                                        <td><form action="{{ route($route.'.destroy',$s->id) }}" method="POST" class="delete-data">
                                            @csrf
                                            <div class="btn-group" role="group" aria-label="Action Button">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod2" id="{{$s->id}}"><i class="fa fa-edit"></i></a>
                                                    <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </form>
                                        
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>{{$t->nama}}</td>
                                        <td><button class="btn col-md-5 btn-mod" id="{{$t->id}}" style="background: #42d408"><i class="mdi mdi-plus"></i></button></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        @endforeach
                    @endforeach
                    @else
                    <thead class="text-center">
                        <tr>
                           <th colspan="2">Tidak ada data</th>
                        </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    @endif
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
          <h5 class="modal-title" id="title">Tambah Sasaran</h5>
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
        $('#table').on('click', '.btn-mod2', function(){
            let induk_opd_id = $(this).attr('induk_opd_id');
            let induk_jabatan_id = $(this).attr('induk_jabatan_id');
            let jenis_jabatan_id = $(this).attr('jenis_jabatan_id');
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaran_rpjmd')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tujuan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/sasaran_rpjmd/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Sasaran RPJMD');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })


        $('#table').on('click', '.btn-mod', function(){
            let id = $(this).attr('id');
            let valueOpd = $('#induk_opd').val();

            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <button type="button" id="tambah_misi" class="btn col-md-3" style="background: #42d408; font-weight: bold">Tambah Sasaran</button>
            <div id="misi_field">
                <input name="tujuan_rpjmd_id" type="hidden" value="${id}">
                <input name="induk_opd_id" type="hidden" value="${valueOpd}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Sasaran</label>
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