@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Program Dan kegiatan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Program Dan Kegiatan</a></li>
                        <li class="breadcrumb-item active">Program Dan kegiatan</li>
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
$(".modal").on('change', "#program_select", function(){
        let id = $(this).val();
        console.log(id);
        if(id != ""){
    $.ajax({
        type: "get",
        url: `{{url('apiSasaran/sasaran_program')}}/${id}`,
        success: (res) => {
            if(res.status == "success"){
                if(res.sasaran.length > 0){
                    let td = `<table id="table3" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`
                    res.sasaran.forEach(element => {
                        let index = 1;
                        td += `<tr style="background:#f5f2c4">
                            <th colspan="4">${element.nama}</th>
                            </tr>
                            <tr style="background:#b9ddff">
                            <th>No</th>
                            <th>Indikator Program</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            </tr>
                            `
                        res.indikatorProgram.forEach((elementIp) => {
                            if(elementIp.sasaran_program_id == element.id){
                                td += `
                                <tr>
                                    <input type="hidden" name="sasaran_program_id[]" id="nama" class="form-control" value="${element.id}">
                                    <input type="hidden" name="indikator_program_id[]" id="nama" class="form-control" value="${elementIp.id}">
                                    <td>${index}</td>
                                    <td>${elementIp.nama}</td>
                                    <td><input type="text" name="target[]" id="nama" class="form-control" value=""></td>
                                    <td><input type="text" name="kondisi[]" id="nama" class="form-control" value=""></td>
                                </tr>
                                `
                                index++
                            }
                        })
                    });

                    td += '</table>'
                    $('#sasaran_container').html(td);

                } else {
                    $('#sasaran_container').html("");
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
    })
$(".modal").on('change', "#kegiatan_select", function(){
        let id = $(this).val();
        console.log(id);
        if(id != ""){
    $.ajax({
        type: "get",
        url: `{{url('apiSasaran/sasaran_kegiatan')}}/${id}`,
        success: (res) => {
            if(res.status == "success"){
                if(res.sasaran.length > 0){
                    let td = `<table id="table3" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`
                    res.sasaran.forEach(element => {
                        td += `<tr style="background:#f5f2c4">
                            <th colspan="4">${element.nama}</th>
                            </tr>
                            <tr style="background:#b9ddff">
                            <th>No</th>
                            <th>Indikator Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            </tr>
                            `
                        res.indikatorKegiatan.forEach(elementIp => {
                            if(elementIp.sasaran_kegiatan_id == element.id){
                                td += `
                                <tr>
                                    <input type="hidden" name="sasaran_kegiatan_id[]" id="nama" class="form-control" value="${element.id}">
                                    <input type="hidden" name="indikator_kegiatan_id[]" id="nama" class="form-control" value="${elementIp.id}">
                                    <td>${elementIp.id}</td>
                                    <td>${elementIp.nama}</td>
                                    <td><input type="text" name="target[]" id="nama" class="form-control" value=""></td>
                                    <td><input type="text" name="kondisi[]" id="nama" class="form-control" value=""></td>
                                </tr>
                                `
                            }
                        })
                    });

                    td += '</table>'
                    $('#sasaran_container').html(td);

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
    })

$(".modal").on('change', "#sub_kegiatan_select", function(){
        let id = $(this).val();
        console.log(id);
        if(id != ""){
    $.ajax({
        type: "get",
        url: `{{url('apiSasaran/sasaran_sub_kegiatan')}}/${id}`,
        success: (res) => {
            if(res.status == "success"){
                if(res.sasaran.length > 0){
                    let td = `<table id="table3" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`
                    res.sasaran.forEach(element => {
                        td += `<tr style="background:#f5f2c4">
                            <th colspan="4">${element.nama}</th>
                            </tr>
                            <tr style="background:#b9ddff">
                            <th>No</th>
                            <th>Indikator Sub Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            </tr>
                            `
                        res.indikatorKegiatan.forEach(elementIp => {
                            if(elementIp.sasaran_sub_kegiatan_id == element.id){
                                td += `
                                <tr>
                                    <input type="hidden" name="sasaran_sub_kegiatan_id[]" id="nama" class="form-control" value="${element.id}">
                                    <input type="hidden" name="indikator_sub_kegiatan_id[]" id="nama" class="form-control" value="${elementIp.id}">
                                    <td>${elementIp.id}</td>
                                    <td>${elementIp.nama}</td>
                                    <td><input type="text" name="target[]" id="nama" class="form-control" value=""></td>
                                    <td><input type="text" name="kondisi[]" id="nama" class="form-control" value=""></td>
                                </tr>
                                `
                            }
                        })
                    });

                    td += '</table>'
                    $('#sasaran_container').html(td);

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
                    merujuk_rpjmd(res.visi, res.misi, res.tujuan, res.sasaran, res.tujuanRenstra, res.sasaranRenstra, res.Iku, res.indikatorOpd, res.detailProgram, res.detailIndikatorProgram, res.detailKegiatan, res.detailIndikatorKegiatan, res.detailSubKegiatan, res.detailIndikatorSubKegiatan);
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
                    let detailSubKegiatan = res.detailSubKegiatan
                    let detailIndikatorSubKegiatan = res.detailIndikatorSubKegiatan
                    let td = ``
                    misi.forEach(element => {
                        td += ``
                        tujuan.forEach(elementTr => {
                            if(elementTr.misi_renstra_id == element.id){
                            sasaran.forEach(elementSr => {
                            if(elementSr.tujuan_renstra_id == elementTr.id){
                                td += `
                            <tr>
                            <td colspan="3"><span style="padding-left: 28px">${elementSr.nama}</span></td>
                            `
                 indikatorOpd.forEach(elementIo => {
                if(elementIo.sasaran_renstra_id == elementSr.id){
                    td += `
                        <tr>
                            <td style="padding-left: 70px">IKU: ${elementIo.nama}</td>
                            <td colspan="4"><button class="btn col-md-6 btn-mod" id="${elementIo.id}" style="background: #42d408"><i class="mdi mdi-plus"></i></button>   
                            </td>
                        </tr>
                    `
                    detailProgram.forEach(elementdP => {
                        if(elementdP.indikator_opd_id == elementIo.id){
                            td += `
                            <tr>
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Program: ${elementdP.nama_program}</span>
                            <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4">
                                <form method="POST" action="detail_program/${elementdP.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="m-2 btn btn-sm btn-mod-kegiatan" id="${elementdP.program_id}" detail_program_id="${elementdP.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i>
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Program</th>
                            <th>Indikator Program</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorProgram.forEach(elementdIP => {
                                if(elementdIP.detail_program_id == elementdP.id){
                                    td += `
                                        <tr>
                                            <td>${elementdIP.nama_sasaran_program}</td>
                                            <td>${elementdIP.nama_indikator_program}</td>
                                            <td>${elementdIP.target_indikator}</td>
                                            <td>${elementdIP.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target" id="${elementdIP.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })

                            detailKegiatan.forEach(elementdK => {
                                if(elementdK.detail_program_id == elementdP.id){
                                    td += `
                            <tr>
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="detail_kegiatan/${elementdK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="m-2 btn btn-sm btn-mod-sub-kegiatan" id="${elementdK.kegiatan_id}" detail_kegiatan_id="${elementdK.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i>
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Kegiatan</th>
                            <th>Indikator Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `
                            detailIndikatorKegiatan.forEach(elementdIK => {
                                if(elementdIK.detail_kegiatan_id == elementdK.id){
                                    td += `
                                        <tr>
                                            <td>${elementdIK.nama_sasaran_kegiatan}</td>
                                            <td>${elementdIK.nama_indikator_kegiatan}</td>
                                            <td>${elementdIK.target_indikator}</td>
                                            <td>${elementdIK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-kegiatan" id="${elementdIK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })

                            detailSubKegiatan.forEach(elementdSK => {
                                if(elementdSK.detail_kegiatan_id == elementdK.id){
                                    td += `
                            <tr style="background: #b6f961">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="/detail_sub_kegiatan/${elementdSK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" action="detail_sub_kegiatan/${elementdSK.id}" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Sub Kegiatan</th>
                            <th>Indikator Sub Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorSubKegiatan.forEach(elementdISK => {
                                if(elementdISK.detail_sub_kegiatan_id == elementdSK.id){
                                    td += `
                                        <tr>
                                            <td>${elementdISK.nama_sasaran_sub_kegiatan}</td>
                                            <td>${elementdISK.nama_indikator_sub_kegiatan}</td>
                                            <td>${elementdISK.target_indikator}</td>
                                            <td>${elementdISK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-sub-kegiatan" id="${elementdISK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })
                                }
                            })


                            
                                }
                            })
                        }
                    })
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

function merujuk_rpjmd(visi, misi, tujuan, sasaran, tujuanRenstra, sasaranRenstra, Iku, indikatorOpd, detailProgram, detailIndikatorProgram, detailKegiatan, detailIndikatorKegiatan, detailSubKegiatan, detailIndikatorSubKegiatan){
    let td = ''
    let valueOpd = $('#induk_opd').val();
            let td2 = `<table id="table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`

            sasaranRenstra.forEach(element => {
                if(element.induk_opd_id == valueOpd){
                    td2 += `
                    <thead>
                                <tr style="background:#f5d2c4" align="left">
                                    <th colspan="7"><span style="padding-left: 35px">Sasaran Renstra: ${element.nama}</span></th>
                                </tr>
                    </thead>
                    `
                    Iku.forEach(elementIku => {
                if(elementIku.id == element.indikator_pemerintah_id){
                   td2 += `
                   <tbody>
                        <tr style="background:#b9ddff">
                            <td style="padding-left: 70px">IKU: ${elementIku.nama}</td>
                            <td colspan="4"><button class="btn col-md-4 btn-mod-opd" id="${elementIku.id}" style="background: #42d408"><i class="mdi mdi-plus"></i></button></td>
                        </tr>
                    `

                    detailProgram.forEach(elementdP => {
                        if(elementdP.indikator_pemerintah_id == elementIku.id){
                            td2 += `
                            <tr style="background: #f9d361">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Program: ${elementdP.nama_program}</span>
                            <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="detail_program/${elementdP.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}

                                <div class="btn-group" role="group" aria-label="Action Button">
                                        <button class="m-2 btn btn-sm btn-mod-kegiatan" id="${elementdP.program_id}" detail_program_id="${elementdP.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th align="center" style="padding:5px">Sasaran Program</th>
                            <th>Indikator Program</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            
                            `
                            detailIndikatorProgram.forEach(elementdIP => {
                                if(elementdIP.detail_program_id == elementdP.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdIP.nama_sasaran_program}</td>
                                            <td>${elementdIP.nama_indikator_program}</td>
                                            <td>${elementdIP.target_indikator}</td>
                                            <td>${elementdIP.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target" id="${elementdIP.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })

                            detailKegiatan.forEach(elementdK => {
                                if(elementdK.detail_program_id == elementdP.id){
                                    td2 += `
                            <tr style="background: #b6f961">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="detail_kegiatan/${elementdK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" action="detail_kegiatan/${elementdK.id}" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="m-2 btn btn-sm btn-mod-sub-kegiatan" id="${elementdK.kegiatan_id}" detail_kegiatan_id="${elementdK.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i>
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Kegiatan</th>
                            <th>Indikator Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorKegiatan.forEach(elementdIK => {
                                if(elementdIK.detail_kegiatan_id == elementdK.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdIK.nama_sasaran_kegiatan}</td>
                                            <td>${elementdIK.nama_indikator_kegiatan}</td>
                                            <td>${elementdIK.target_indikator}</td>
                                            <td>${elementdIK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-kegiatan" id="${elementdIK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })

                            detailSubKegiatan.forEach(elementdSK => {
                                if(elementdSK.detail_kegiatan_id == elementdK.id){
                                    td2 += `
                            <tr style="background: #b6f961">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="/detail_sub_kegiatan/${elementdSK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" action="detail_sub_kegiatan/${elementdSK.id}" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Sub Kegiatan</th>
                            <th>Indikator Sub Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorSubKegiatan.forEach(elementdISK => {
                                if(elementdISK.detail_sub_kegiatan_id == elementdSK.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdISK.nama_sasaran_sub_kegiatan}</td>
                                            <td>${elementdISK.nama_indikator_sub_kegiatan}</td>
                                            <td>${elementdISK.target_indikator}</td>
                                            <td>${elementdISK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-sub-kegiatan" id="${elementdISK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })
                                }
                            })
                                }
                            })
                        }
                    })
                }
            })
            indikatorOpd.forEach(elementIo => {
                if(elementIo.sasaran_renstra_id == element.id){
                    td2 += `
                        <tr style="background:#b9ddff">
                            <td>IKU: ${elementIo.nama}</td>
                            <td colspan="4"><button class="btn col-md-4 btn-mod" id="${elementIo.id}" style="background: #42d408"><i class="mdi mdi-plus"></i></button></td>
                        </tr>
                    `

                    detailProgram.forEach(elementdP => {
                        if(elementdP.indikator_opd_id == elementIo.id){
                            td2 += `
                            <tr style="background: #f9d361">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Program: ${elementdP.nama_program}</span>
                            <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="detail_program/${elementdP.id}" class="delete-data">
                                {{ method_field('DELETE') }}
                                @csrf
                                <div class="btn-group" role="group" aria-label="Action Button">
                                        <button class="m-2 btn btn-sm btn-mod-kegiatan" id="${elementdP.program_id}" detail_program_id="${elementdP.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Program</th>
                            <th>Indikator Program</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorProgram.forEach(elementdIP => {
                                if(elementdIP.detail_program_id == elementdP.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdIP.nama_sasaran_program}</td>
                                            <td>${elementdIP.nama_indikator_program}</td>
                                            <td>${elementdIP.target_indikator}</td>
                                            <td>${elementdIP.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target" id="${elementdIP.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })

                            detailKegiatan.forEach(elementdK => {
                                if(elementdK.detail_program_id == elementdP.id){
                                    td2 += `
                            <tr style="background: #b6f961">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="detail_kegiatan/${elementdK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="m-2 btn btn-sm btn-mod-sub-kegiatan" id="${elementdK.kegiatan_id}" detail_kegiatan_id="${elementdK.id}" type="button" style="background: #42d408"><i class="mdi mdi-plus"></i></button>
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Kegiatan</th>
                            <th>Indikator Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `
                            detailIndikatorKegiatan.forEach(elementdIK => {
                                if(elementdIK.detail_kegiatan_id == elementdK.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdIK.nama_sasaran_kegiatan}</td>
                                            <td>${elementdIK.nama_indikator_kegiatan}</td>
                                            <td>${elementdIK.target_indikator}</td>
                                            <td>${elementdIK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-kegiatan" id="${elementdIK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })
                            detailSubKegiatan.forEach(elementdSK => {
                                if(elementdSK.detail_kegiatan_id == elementdK.id){
                                    td2 += `
                            <tr style="background: #b6f961">
                            <td><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
                            </div></td>
                            <td colspan="4"><form method="POST" action="/detail_sub_kegiatan/${elementdSK.id}" class="delete-data">
                                @csrf
                                {{ method_field('DELETE') }}
                                <div class="btn-group" role="group" action="detail_sub_kegiatan/${elementdSK.id}" aria-label="Action Button">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i></button>
                                </div>
                            </form></td>
                        </tr>
                        <tr align="center">
                            <th>Sasaran Sub Kegiatan</th>
                            <th>Indikator Sub Kegiatan</th>
                            <th>Target Indikator</th>
                            <th>Kondisi Awal</th>
                            <th>Aksi</th>
                        </tr>
                            `

                            detailIndikatorSubKegiatan.forEach(elementdISK => {
                                if(elementdISK.detail_sub_kegiatan_id == elementdSK.id){
                                    td2 += `
                                        <tr>
                                            <td>${elementdISK.nama_sasaran_sub_kegiatan}</td>
                                            <td>${elementdISK.nama_indikator_sub_kegiatan}</td>
                                            <td>${elementdISK.target_indikator}</td>
                                            <td>${elementdISK.kondisi_awal}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action Button">
                                                <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-sub-kegiatan" id="${elementdISK.id}"><i class="fa fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    `
                                }
                            })
                                }
                            })
                            
                                }
                            })
                            //add Kegiatan thingy here.
                        }
                    })
                    
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


        $('#table').on('click', '.btn-mod', function(){
            let id = $(this).attr('id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiEdit/program_kegiatan')}}/${induk_opd_id}`,
                success: (res) => {
                    if(res.status == "success"){
                        console.log(res);
                            let option = "<option value='0'>Pilih Program</option>"
                            let option2 = "<option value='0'>Pilih Jabatan</option>"

                            for(const key in res.program){
                                    option += `<option value="${res.program[key].id}">${res.program[key].uraian}</option>`
                            }
                            for(const key in res.jabatan){
                                    option2 += `<option value="${res.jabatan[key].id}">${res.jabatan[key].nama}</option>`
                            }

                            let template = `
                {!! Form::open(['route'=>'detail_program.store','method'=>'POST', 'id'=>'EditForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="indikator_opd_id" id="nama" class="form-control" value="${id}">
                <label for="name" class="col-md-2 col-form-label">Indikator Kerja Utama</label>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Program</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="program_id" id="program_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="jabatan_id" id="jabatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row" id="sasaran_container">
            </div>
                `
                $('.modal-body').html(template)
                $('#program_select').html(option);
                $('#jabatan_select').html(option2);
                // $('#EditForm').attr('action', `/detail_program/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Tambah Data Program');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });
        $('#table').on('click', '.btn-mod-kegiatan', function(){
            let id = $(this).attr('id');
            let detail_program_id = $(this).attr('detail_program_id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiKegiatan/program_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                        console.log(res);
                            let option = "<option value='0'>Pilih Kegiatan</option>"
                            let option2 = "<option value='0'>Pilih Jabatan</option>"

                            for(const key in res.kegiatan){
                                    option += `<option value="${res.kegiatan[key].id}">${res.kegiatan[key].uraian}</option>`
                            }
                            for(const key in res.jabatan){
                                    option2 += `<option value="${res.jabatan[key].id}">${res.jabatan[key].nama}</option>`
                            }

                            let template = `
                {!! Form::open(['route'=>'detail_kegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="detail_program_id" id="nama" class="form-control" value="${detail_program_id}">
                <label for="name" class="col-md-2 col-form-label">Indikator Kerja Utama</label>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Kegiatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="kegiatan_id" id="kegiatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="jabatan_id" id="jabatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row" id="sasaran_container">
            </div>
                `
                $('.modal-body').html(template)
                $('#kegiatan_select').html(option);
                $('#jabatan_select').html(option2);
                // $('#EditForm').attr('action', `/detail_program/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Tambah Data Kegiatan');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });
        $('#table').on('click', '.btn-mod-sub-kegiatan', function(){
            let id = $(this).attr('id');
            let detail_kegiatan_id = $(this).attr('detail_kegiatan_id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiKegiatan/sub_kegiatan_detail')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                        console.log(res);
                            let option = "<option value='0'>Pilih Sub Kegiatan</option>"
                            let option2 = "<option value='0'>Pilih Jabatan</option>"

                            for(const key in res.sub_kegiatan){
                                    option += `<option value="${res.sub_kegiatan[key].id}">${res.sub_kegiatan[key].uraian}</option>`
                            }
                            for(const key in res.jabatan){
                                    option2 += `<option value="${res.jabatan[key].id}">${res.jabatan[key].nama}</option>`
                            }

                            let template = `
                {!! Form::open(['route'=>'detail_sub_kegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="detail_kegiatan_id" id="nama" class="form-control" value="${detail_kegiatan_id}">
                <label for="name" class="col-md-2 col-form-label">Indikator Kerja Utama</label>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Sub Kegiatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="sub_kegiatan_id" id="sub_kegiatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="jabatan_id" id="jabatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row" id="sasaran_container">
            </div>
                `
                $('.modal-body').html(template)
                $('#sub_kegiatan_select').html(option);
                $('#jabatan_select').html(option2);
                // $('#EditForm').attr('action', `/detail_program/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Tambah Data Kegiatan');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });
    $('#table').on('click', '.btn-mod-edit-target', function(){
            let id = $(this).attr('id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiEdit/detail_indikator_program')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                       let text = `<input type="text" name="target_indikator" class="form-control" value="${res.data.target_indikator}">`
                       let text2 = `<input type="text" name="kondisi_awal" class="form-control" value="${res.data.kondisi_awal}">`

                            let template = `
                {!! Form::open(['route'=>'detail_program.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Edit Target</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="target_container">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kondisi Awal</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="kondisi_container">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#target_container').html(text);
                $('#kondisi_container').html(text2);
                $('#EditForm').attr('action', `/detail_indikator_program/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Edit Data Target Program');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });
    $('#table').on('click', '.btn-mod-edit-target-kegiatan', function(){
            let id = $(this).attr('id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiEdit/detail_indikator_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                       let text = `<input type="text" name="target_indikator" class="form-control" value="${res.data.target_indikator}">`
                       let text2 = `<input type="text" name="kondisi_awal" class="form-control" value="${res.data.kondisi_awal}">`

                            let template = `
                {!! Form::open(['route'=>'detail_program.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Edit Target</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="target_container">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kondisi Awal</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="kondisi_container">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#target_container').html(text);
                $('#kondisi_container').html(text2);
                $('#EditForm').attr('action', `/detail_indikator_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Edit Data Target Program');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });
    $('#table').on('click', '.btn-mod-edit-target-sub-kegiatan', function(){
            let id = $(this).attr('id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiEdit/detail_indikator_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                       let text = `<input type="text" name="target_indikator" class="form-control" value="${res.data.target_indikator}">`
                       let text2 = `<input type="text" name="kondisi_awal" class="form-control" value="${res.data.kondisi_awal}">`

                            let template = `
                {!! Form::open(['route'=>'detail_program.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Edit Target</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="target_container">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kondisi Awal</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="kondisi_container">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#target_container').html(text);
                $('#kondisi_container').html(text2);
                $('#EditForm').attr('action', `/detail_indikator_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Edit Data Target Program');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

    });



    $('#table').on('click', '.btn-mod-opd', function(){
            let id = $(this).attr('id');
            let induk_opd_id = $('#induk_opd').val();
            $.ajax({
                type: "get",
                url: `{{url('apiEdit/program_kegiatan')}}/${induk_opd_id}`,
                success: (res) => {
                    if(res.status == "success"){
                        console.log(res);
                            let option = "<option value='0'>Pilih Program</option>"
                            let option2 = "<option value='0'>Pilih Jabatan</option>"

                            for(const key in res.program){
                                    option += `<option value="${res.program[key].id}">${res.program[key].uraian}</option>`
                            }
                            for(const key in res.jabatan){
                                    option2 += `<option value="${res.jabatan[key].id}">${res.jabatan[key].nama}</option>`
                            }

                            let template = `
                {!! Form::open(['route'=>'detail_program.store','method'=>'POST', 'id'=>'EditForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="indikator_pemerintah_id" id="nama" class="form-control" value="${id}">
                <label for="name" class="col-md-2 col-form-label">Indikator Kerja Utama</label>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Program</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="program_id" id="program_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pilih Jabatan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="">
                    <select name="jabatan_id" id="jabatan_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row" id="sasaran_container">
            </div>
                `
                $('.modal-body').html(template)
                $('#program_select').html(option);
                $('#jabatan_select').html(option2);
                // $('#EditForm').attr('action', `/detail_program/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Tambah Data Program');

                $('.modal').modal('toggle');
                        alert(res.data.nama);
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

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