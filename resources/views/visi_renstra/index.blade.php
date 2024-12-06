@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Visi dan Misi Renstra</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Renstra</a></li>
                        <li class="breadcrumb-item active">Visi Dan Misi</li>
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
                        <div class="col-md-10 d-flex justify-content-center">
                            {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                            <div class="d-flex flex-column justify-content-center align-items-center w-25">
                                <label for="rpjmd_check">Merujuk RPJMD</label>
                                <input type="checkbox" id="rpjmd_check">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" id="button-tambah" style="background: #f7ac42"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div>
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <table id="table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
          <h5 class="modal-title" id="title">Tambah Visi dan Misi Renstra</h5>
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

$('#rpjmd_check').change(function(){
    let induk_opd_id = $("#induk_opd").val();
    if($(this).prop('checked')){
        $.ajax({
            type: "get",
            url: `{{url('apiEdit/merujuk_rpjmd')}}/${induk_opd_id}`,
            success: (res) => {
                if(res.status == "success"){
                        console.log(res.data);
                        merujuk_rpjmd(); 
                } else {
                    alert(res.data);
                }
            }
        })
    } else {
        $.ajax({
            type: "get",
            url: `{{url('apiEdit/tidak_merujuk_rpjmd')}}/${induk_opd_id}`,
            success: (res) => {
                if(res.status == "success"){
                    $('#table').html("");
                    $('#rpjmd_check').prop('checked', false)
                    $('#button-tambah').attr('hidden', false);
                } else {
                    alert(res.data);
                }
            }
        }) 
}
})

$('#induk_opd').change(function(){

    let id = $(this).val();
    let template = ''
if(id != ""){
    $.ajax({
            type: "get",
            url: `{{url('apiEdit/visi_renstra')}}/${id}`,
            success: (res) => {
                if(res.status == "success"){
                        if(res.data.status == 1){
                        console.log(res.data);
                        merujuk_rpjmd();
                    } else if(res.data.status == 2){
                        let visi = res.renstra
                        let misi = res.misi
                        let td = ``
                        misi.forEach(element => {
                            td += `<tr>
                                <td>${element.nama}</td>
                                <td><form method="POST" action="/visi_renstra/${element.id}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <div class="btn-group" role="group" aria-label="Action Button">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod2" id="${element.id}"><i class="fa fa-edit"></i></a>
                                                    <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </form>
                                        
                                        </td>
                                </tr>`
                        });
                        template = `
                        @if(count($visi) > 0)
                        @foreach ($visi as $v)
                        <thead class="text-center">
                            <tr style="background:#d6dad5" align="center">
                               <th colspan="2">2021 - 2026</th>
                            </tr>
                            <tr style="background:#f5c4c4" align="left">
                                <th colspan="2"><span style="text-align: left">Visi: ${visi.nama}</span></th>
                            </tr>
                            </thead>
    
                            <tbody id="misi_row">
                                <tr style="background:#c4dbf5" align="left">
                                    <th colspan="2"><span style="padding-left: 7px">Misi Renstra</span></th>
                                </tr>
                            </tbody>
                    @endforeach
                    @endif
                        `;
                        $('#table').html(template);
                        $('#rpjmd_check').prop('checked', false);
                        $('#misi_row').append(td);
                        $('#button-tambah').attr('hidden', false);
                    } else {
                        template = ``;
                        $('#table').html(template);
                        $('#rpjmd_check').prop('checked', false)
                        $('#button-tambah').attr('hidden', false);
                    }
                    

                } else {
                    alert("Ada Yang salah saat pengambilan data");
                }
            }
        })
    } else {
                        console.log(id)
                        template = ``;
                        $('#table').html(template);
                        $('#rpjmd_check').prop('checked', false)
                        $('#button-tambah').attr('hidden', false);
                    }
    });

    function merujuk_rpjmd(){
        template = `
       @if(count($visi) > 0)
                        @foreach ($visi as $v)
                        <thead class="text-center">
                            <tr style="background:#d6dad5" align="center">
                               <th colspan="2">{{$v->tahun_awal}} - {{$v->tahun_akhir}}</th>
                            </tr>
                            <tr style="background:#f5c4c4" align="left">
                                <th colspan="2"><span style="text-align: left">Visi: {{$v->nama}}</span></th>
                            </tr>
                            </thead>
    
                            <tbody>
                                @foreach ($v->Misi as $key => $M)
                                <tr style="background:#c4dbf5" align="left">
                                    <th colspan="2"><span style="padding-left: 7px">Misi {{$key + 1}}: {{$M->nama}}</span></th>
                                </tr>
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
                    @endif`
                    $('#table').html(template);
                    $('#rpjmd_check').prop('checked', true)
                    $('#button-tambah').attr('hidden', true);

    }

    $('#table').on('click', '.btn-mod2', function(){
        let induk_opd_id = $(this).attr('induk_opd_id');
        let induk_jabatan_id = $(this).attr('induk_jabatan_id');
        let jenis_jabatan_id = $(this).attr('jenis_jabatan_id');
        let id = $(this).attr('id');

        $.ajax({
            type: "get",
            url: `{{url('apiEdit/misi_renstra')}}/${id}`,
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
            $('#EditForm').attr('action', `/visi_renstra/${id}`)
            $('#submitButton').attr('form', 'EditForm')
            $('#title').html('Ubah data Misi Renstra');

            $('.modal').modal('toggle');
                    alert(res.data.nama);
                } else {
                    alert("Ada Yang salah saat pengambilan data");
                }
            }
        })

    })


    $('.btn-mod').click(function(){
        let id = $("#induk_opd").val();

        if(id){
            let template = `
            {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <input name="induk_opd_id" type="hidden" value="${id}">
            <div class="mb-3 row">
            <label for="name" class="col-md-2 col-form-label">Visi</label>
        </div>
        <div class="mb-3 row">
            <div class="col-md-10">
                {!! Form::text('nama_visi',null,['class'=>'form-control','id'=>"nama"]) !!}
            </div>
        </div>
        <button type="button" id="tambah_misi" class="btn col-md-3" style="background: #42d408; font-weight: bold">Tambah Misi</button>
        <div id="misi_field">
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
        } else {
            alert("Silahkan Pilih SKPD terlebih dahulu")
        }

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