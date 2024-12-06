@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Target Kerja</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Nilai Kerja</a></li>
                        <li class="breadcrumb-item active">Target Kerja</li>
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
        $('#table').on('click', '.btn-mod-edit-target-pemerintah', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/target_kerja_pemerintah')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="target_kerja" id="nama" class="form-control" value="${res.data.target_kerja}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
                <input name="indikator_pemerintah_id" type="hidden" value="${res.data.id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Target Kerja</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="field">
                    <input type="text" name="target_kerja" id="nama" class="form-control" value="${res.data.parameter}" disabled>
                </div>
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/target_kerja/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Target Kerja');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })

        $('#table').on('click', '.btn-mod-edit-target-opd', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/target_kerja_opd')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="target_kerja" id="nama" class="form-control" value="${res.data.target_kerja}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
                <input name="indikator_opd_id" type="hidden" value="${res.data.id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Target Kerja</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="field">
                    <input type="text" name="target_kerja" id="nama" class="form-control" value="${res.data.parameter}" disabled>
                </div>
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/target_kerja/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Target Kerja');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert(res.message);
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
                    merujuk_rpjmd(res.visi, res.misi, res.tujuan, res.sasaran, res.tujuanRenstra, res.sasaranRenstra, res.Iku, res.indikatorOpd, res.detailProgram, res.detailIndikatorProgram, res.detailKegiatan, res.detailIndikatorKegiatan);
                } else if(res.data.status == 2){
                    let visi = res.renstra
                    let misi = res.misi
                    let tujuan = res.tujuan
                    let sasaran = res.sasaranRenstra
                    let indikatorOpd = res.indikatorOpd
                    let detailProgram = res.detailProgram
                    let detailIndikatorProgram = res.detailIndikatorProgram
                    let detailKegiatan = res.detailKegiatan
                    let detailIndikatorKegiatan = res.detailIndikatorKegiatan
                    let td = ``
                    misi.forEach(element => {
                        td += ``
                        tujuan.forEach(elementTr => {
                            if(elementTr.misi_renstra_id == element.id){
                            sasaran.forEach(elementSr => {
                                let id_indikator = 1
                            if(elementSr.tujuan_renstra_id == elementTr.id){
                                td += `
                            <tr>
                            <td colspan="3"><span style="padding-left: 28px">${elementSr.nama}</span></td>
                            </tr>
                            <tr style="background:#cccccc">
                            <td>No</td>
                            <td>Indikator Kinerja Utama</td>
                            <td>Satuan</td>
                            <td>Kondisi Awal</td>
                            <td>Target Kerja</td>
                            <td>Aksi</td>
                            </tr>
                            `
                 indikatorOpd.forEach(elementIo => {
                if(elementIo.sasaran_renstra_id == elementSr.id){
                    td += `
                        <tr>
                            <td>${id_indikator}</td>
                            <td>${elementIo.nama}</td>
                            <td>${elementIo.satuan}</td>
                            <td>${elementIo.kondisi_awal}</td>
                            <td>${elementIo.target_kerja}</td>

                            <td><form action="/indikator_opd2/${elementIo.id}" method="POST" class="delete-data">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-opd" id="${elementIo.id}"><i class="fa fa-edit"></i></a>
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>

                        </tr>
                    `
                    id_indikator += 1
                }
            })
                            }
                        });
                            }
                        });
                    });
                    template = `
                    <thead class="text-center">
                        <tr style="background:#d6dad5" align="center">
                           <th colspan="7">2021 - 2026</th>
                        </tr>
                        <tr style="background:#f5c4c4" align="left">
                            <th colspan="7"><span style="text-align: left">Visi: ${visi.nama}</span></th>
                        </tr>
                        </thead>

                        <tbody id="misi_row">
                            <tr style="background:#c4dbf5" align="left">
                                <th colspan="7"><span style="padding-left: 7px">Misi Renstra</span></th>
                            </tr>
                        </tbody>
                    `;
                    $('#table').html(template);
                    // $('#table').html('<tr align="center"><td>Tidak ada data Yang Merujuk RPJMD</td></tr>')
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

function merujuk_rpjmd(visi, misi, tujuan, sasaran, tujuanRenstra, sasaranRenstra, Iku, indikatorOpd, detailProgram, detailIndikatorProgram, detailKegiatan, detailIndikatorKegiatan){
    let td = ''
    let valueOpd = $('#induk_opd').val();
            let td2 = `<table id="table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`

            sasaranRenstra.forEach(element => {
                let id_indikator = 1;
                if(element.induk_opd_id == valueOpd){
                    td2 += `
                    <thead>
                                <tr style="background:#f5d2c4" align="left">
                                    <th colspan="7"><span style="padding-left: 35px">Sasaran Renstra: ${element.nama}</span></th>
                                </tr>
                    </thead>
                    <tbody>
                    <tr style="background:#cccccc">
                            <td>No</td>
                            <td>Indikator Kinerja Utama</td>
                            <td>Satuan</td>
                            <td>Kondisi Awal</td>
                            <td>Target Kerja</td>
                            <td>Aksi</td>
                            </tr>
                    `
                    Iku.forEach(elementIku => {
                if(elementIku.id == element.indikator_pemerintah_id){
                   td2 += `
                   <tr>
                            <td>${id_indikator}</td>
                            <td>${elementIku.nama}</td>
                            <td>${elementIku.satuan}</td>
                            <td>${elementIku.kondisi_awal}</td>
                            <td>${elementIku.target_kerja}</td>

                            <td></td>
                        </tr>
                    `
                    id_indikator += 1

                }
            })
            indikatorOpd.forEach(elementIo => {
                if(elementIo.sasaran_renstra_id == element.id){
                    td2 += `
                    <tr>
                            <td>${id_indikator}</td>
                            <td>${elementIo.nama}</td>
                            <td>${elementIo.satuan}</td>
                            <td>${elementIo.kondisi_awal}</td>
                            <td>${elementIo.target_kerja}</td>

                            <td><form action="/indikator_opd2/${elementIo.id}" method="POST" class="delete-data">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-opd" id="${elementIo.id}"><i class="fa fa-edit"></i></a>
                                </div>
                            </form></td>
                        </tr>
                    `
                    id_indikator += 1
                }
            })
                }
            })
            td2 += `</tbody></table>`
                $('#table').html(td2);
                $('#table2').html(td2);
                $('#rpjmd_check').prop('checked', true)
                $('#button-tambah').attr('hidden', true);

}


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