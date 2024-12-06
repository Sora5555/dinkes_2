@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Realisasi Anggaran</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pagu</a></li>
                        <li class="breadcrumb-item active">Realisasi Anggaran</li>
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
                    <thead>
                        <tr style="background:#f5f2c4">
                            <th colspan="7"><div class="d-flex justify-content-between align-items-center">Sasaran: Sasaran 1</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    {{-- @if(count($visi) > 0)
                        @foreach ($visi as $v)
                        <thead class="text-center">
                            <tr style="background:#d6dad5">
                               <th colspan="2">{{$v->tahun_awal}} - {{$v->tahun_akhir}}</th>
                            </tr>
                            <tr style="background:#f5c4c4">
                                <th><span style="text-align: left">Visi: {{$v->nama}}</span></th>
                                <th><button class="btn col-md-3 btn-mod" id="{{$v->id}}" style="background: #42d408"><i class="mdi mdi-plus"></i></button></th>
                            </tr>
                            </thead>
    
                            <tbody>
                                <tr align="center">
                                    <th>Misi:</th>
                                    <td></td>
                                </tr>
                                    @foreach ($v->Misi as $M)
                                    <tr>
                                        <td>{{$M->nama}}</td>
                                        <td><form action="{{ route($route.'.destroy',$M->id) }}" method="POST" class="delete-data">
                                            @csrf
                                            <div class="btn-group" role="group" aria-label="Action Button">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod2" id="{{$M->id}}"><i class="fa fa-edit"></i> Edit</a>
                                                    <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
                                            </div>
                                        </form>
                                        
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        @endforeach
                    @else
                    <thead class="text-center">
                        <tr>
                           <th colspan="2">Tidak ada data</th>
                        </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    @endif --}}
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
                url: `{{url('apiEdit/pagu_anggaran')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textNama = `<input type="text" name="pagu_anggaran" id="nama" class="form-control" value="${res.data.pagu_indikatif}">`
                            let textCapaianSatu = `<input type="text" name="tw_1" id="nama" class="form-control" value="${res.data.rp_tri_1}">`
                            let textCapaianDua = `<input type="text" name="tw_2" id="nama" class="form-control" value="${res.data.rp_tri_2}">`
                            let textCapaianTiga = `<input type="text" name="tw_3" id="nama" class="form-control" value="${res.data.rp_tri_3}">`
                            let textCapaianEmpat = `<input type="text" name="tw_4" id="nama" class="form-control" value="${res.data.rp_tri_4}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
                <input name="indikator_opd_id" type="hidden" value="${res.data.id}">
                <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Pagu</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="field">
                    <input type="text" name="target_kerja" id="nama" class="form-control" value="${res.data.pagu_indikatif}" disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">TW 1</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_satu_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">TW 2</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_dua_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">TW 3</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_tiga_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">TW 4</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_empat_field">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_empat_field">
                    <h5>Pagu Anggaran: ${res.data.pagu_indikatif}</h5>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_empat_field">
                    <h5>Realisasi Anggaran: ${parseInt(res.data.rp_tri_1) + parseInt(res.data.rp_tri_2) + parseInt(res.data.rp_tri_3) + parseInt(res.data.rp_tri_4)}</h5>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="capaian_empat_field">
                    <h5>Sisa Anggaran: ${parseInt(res.data.pagu_indikatif) - (parseInt(res.data.rp_tri_1) + parseInt(res.data.rp_tri_2) + parseInt(res.data.rp_tri_3) + parseInt(res.data.rp_tri_4))}</h5>
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#capaian_satu_field').html(textCapaianSatu)
                $('#capaian_dua_field').html(textCapaianDua)
                $('#capaian_tiga_field').html(textCapaianTiga)
                $('#capaian_empat_field').html(textCapaianEmpat)
                $('#EditForm').attr('action', `/realisasi_anggaran/${id}`)
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
        url: `https://dalev.bappedalitbang.samarindakota.go.id/api/program-apbd-by-opd/${id}/2023/yqAHitGWZnS53QzS`,
        success: (res) => {
            if(res.status == "success"){
                    if(res.data){
                    console.log(res.data);
                    merujuk_rpjmd(res.data);
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
                    let subKegiatan = res.subKegiatan
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
                            <td style="padding-left: 70px" colspan="7">IKU: ${elementIo.nama}</td>
                        </tr>
                    `
                    detailProgram.forEach(elementdP => {
                        if(elementdP.indikator_opd_id == elementIo.id){
                            td += `
                            <tr>
                            <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Program: ${elementdP.nama_program}</span>
                            <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
                            </div></td>
                        </tr>
                            `


                            detailKegiatan.forEach(elementdK => {
                                if(elementdK.detail_program_id == elementdP.id){
                                    td += `
                            <tr>
                            <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
                            </div></td>
                        </tr>
                            `
                            detailSubKegiatan.forEach(elementdSK => {
                                if(elementdSK.detail_kegiatan_id == elementdK.id){
                                    td2 += `
                            <tr style="background: #b6f961">
                            <td colspan="7"><div class="d-flex flex-column" style="padding-left: 28px">
                            <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
                            <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
                            </div></td>
                        </tr>
                            `

                            subKegiatan.forEach(elementSk => {
                                if(elementdSK.sub_kegiatan_id == elementSk.id){
                                    td2 += `
                                    <tr>
                            <td colspan="9">Pagu Anggaran: Rp. ${parseInt(elementSk.pagu_indikatif).toLocaleString()}</td>
                        </tr>
                        <tr align="center">
                            <th colspan="9">Realisasi</th>
                        </tr>
                        <tr>
                            <td>TW 1</td>
                            <td>TW 2</td>
                            <td>TW 3</td>
                            <td>TW 4</td>
                            <td>Aksi</td>
                        </tr>
                        <tr>
                            <td>Rp. ${parseInt(elementSk.rp_tri_1).toLocaleString()}</td>
                            <td>Rp. ${parseInt(elementSk.rp_tri_2).toLocaleString()}</td>
                            <td>Rp. ${parseInt(elementSk.rp_tri_3).toLocaleString()}</td>
                            <td>Rp. ${parseInt(elementSk.rp_tri_4).toLocaleString()}</td>
                            <td><form action="/indikator_opd2/${elementSk.id}" method="POST" class="delete-data">
                                @csrf
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-pemerintah" id="${elementSk.id}"><i class="fa fa-edit"></i></a>
                                </div>
                            </form></td>
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

function merujuk_rpjmd(data){
    let td = ''
    let valueOpd = $('#induk_opd').val();
            let td2 = `<table id="table" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">`


                data.forEach(elementData => {
                elementData.data_program.forEach(elementProgram => {
                    td2 += `
                             <tr>
                             <td colspan="7"><div class="d-flex flex-column" style="padding-left: 28px">
                             <span>Program: ${elementProgram.nama_program}</span>                
                             </div></td>
                         </tr>
                            
                             `
                             elementProgram.data_kegiatan.forEach(elementKegiatan => {
                                td2 += `
                             <tr style="background: #b6f961">
                             <td colspan="7"><div class="d-flex flex-column" style="padding-left: 56px;">
                             <span>Kegiatan: ${elementKegiatan.nama_kegiatan}</span>
                             </div></td>
                         </tr>
                             `
                             elementKegiatan.data_sub_kegiatan.forEach(elementSubKegiatan => {
                                td2 += `
                             <tr style="background: #f9af61">
                             <td colspan="7"><div class="d-flex flex-column" style="padding-left: 72px;">
                             <span>Sub Kegiatan: ${elementSubKegiatan.nama_sub_kegiatan}</span>
                             <span>Pagu Anggaran: Rp. ${parseInt(elementSubKegiatan.jumlah_belanja).toLocaleString()}
                             </div></td>
                         </tr>
                         <tr align="center">
                             <th colspan="9">Realisasi</th>
                         </tr>
                         <tr>
                             <td>TW 1</td>
                             <td>TW 2</td>
                             <td>TW 3</td>
                             <td>TW 4</td>
                         </tr>
                         <tr>
                             <td>Rp. ${parseInt(elementSubKegiatan.rp_tri_1).toLocaleString()}</td>
                             <td>Rp. ${parseInt(elementSubKegiatan.rp_tri_2).toLocaleString()}</td>
                             <td>Rp. ${parseInt(elementSubKegiatan.rp_tri_3).toLocaleString()}</td>
                             <td>Rp. ${parseInt(elementSubKegiatan.rp_tri_4).toLocaleString()}</td>
                         </tr>
                             `
                               
                             })
                             })
                })
            })
            // sasaranRenstra.forEach(element => {
            //     if(element.induk_opd_id == valueOpd){
            //         td2 += `
            //         <thead>
            //                     <tr style="background:#f5d2c4" align="left">
            //                         <th colspan="7"><span style="padding-left: 35px">Sasaran Renstra: ${element.nama}</span></th>
            //                     </tr>
            //         </thead>
            //         `
            //         Iku.forEach(elementIku => {
            //     if(elementIku.id == element.indikator_pemerintah_id){
            //        td2 += `
            //        <tbody>
            //             <tr style="background:#b9ddff">
            //                 <td style="padding-left: 70px" colspan="7">IKU: ${elementIku.nama}</td>
            //             </tr>
            //         `

            //         detailProgram.forEach(elementdP => {
            //             if(elementdP.indikator_pemerintah_id == elementIku.id){
            //                 td2 += `
            //                 <tr>
            //                 <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Program: ${elementdP.nama_program}</span>
            //                 <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
                            
            //                 `
            //                 detailKegiatan.forEach(elementdK => {
            //                     if(elementdK.detail_program_id == elementdP.id){
            //                         td2 += `
            //                 <tr>
            //                 <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
            //                 <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
            //                 `

            //                 detailSubKegiatan.forEach(elementdSK => {
            //                     if(elementdSK.detail_kegiatan_id == elementdK.id){
            //                         td2 += `
            //                 <tr style="background: #b6f961">
            //                 <td colspan="7"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
            //                 <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
            //                 `

            //                 subKegiatan.forEach(elementSk => {
            //                     if(elementdSK.sub_kegiatan_id == elementSk.id){
            //                         td2 += `
            //                         <tr>
            //                 <td colspan="9">Pagu Anggaran: Rp. ${parseInt(elementSk.pagu_indikatif).toLocaleString()}</td>
            //                 </tr>
            //             <tr align="center">
            //                 <th colspan="9">Realisasi</th>
            //             </tr>
            //             <tr>
            //                 <td>TW 1</td>
            //                 <td>TW 2</td>
            //                 <td>TW 3</td>
            //                 <td>TW 4</td>
            //                 <td>Aksi</td>
            //             </tr>
            //             <tr>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_1).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_2).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_3).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_4).toLocaleString()}</td>
            //                 <td><form action="/indikator_opd2/${elementSk.id}" method="POST" class="delete-data">
            //                     @csrf
            //                     <div class="btn-group" role="group" aria-label="Action Button">
            //                         <input type="hidden" name="_method" value="DELETE">
            //                         <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-pemerintah" id="${elementSk.id}"><i class="fa fa-edit"></i></a>
            //                     </div>
            //                 </form></td>
            //             </tr>
            //                 `       
            //                     }
            //                 })


            //                     }
            //                 })

            //                     }
            //                 })
            //             }
            //         })
            //     }
            // })
            // indikatorOpd.forEach(elementIo => {
            //     if(elementIo.sasaran_renstra_id == element.id){
            //         td2 += `
            //             <tr style="background:#b9ddff">
            //                 <td colspan="7">IKU: ${elementIo.nama}</td>
            //             </tr>
            //         `

            //         detailProgram.forEach(elementdP => {
            //             if(elementdP.indikator_opd_id == elementIo.id){
            //                 td2 += `
            //                 <tr>
            //                 <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Program: ${elementdP.nama_program}</span>
            //                 <span>Penanggung Jawab: ${elementdP.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
            //                 `

            //                 detailKegiatan.forEach(elementdK => {
            //                     if(elementdK.detail_program_id == elementdP.id){
            //                         td2 += `
            //                 <tr>
            //                 <td colspan="9"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Kegiatan: ${elementdK.nama_kegiatan}</span>
            //                 <span>Penanggung Jawab: ${elementdK.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
            //                 `

            //                 detailSubKegiatan.forEach(elementdSK => {
            //                     if(elementdSK.detail_kegiatan_id == elementdK.id){
            //                         td2 += `
            //                 <tr style="background: #b6f961">
            //                 <td colspan="7"><div class="d-flex flex-column" style="padding-left: 28px">
            //                 <span>Sub Kegiatan: ${elementdSK.nama_sub_kegiatan}</span>
            //                 <span>Penanggung Jawab: ${elementdSK.nama_jabatan}</span>    
            //                 </div></td>
            //             </tr>
            //                 `

            //                 subKegiatan.forEach(elementSk => {
            //                     if(elementdSK.sub_kegiatan_id == elementSk.id){
            //                         td2 += `
            //                         <tr>
            //                 <td colspan="9">Pagu Anggaran: Rp. ${parseInt(elementSk.pagu_indikatif).toLocaleString()}</td>
            //             </tr>
            //             <tr align="center">
            //                 <th colspan="9">Realisasi</th>
            //             </tr>
            //             <tr>
            //                 <td>TW 1</td>
            //                 <td>TW 2</td>
            //                 <td>TW 3</td>
            //                 <td>TW 4</td>
            //                 <td>Aksi</td>
            //             </tr>
            //             <tr>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_1).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_2).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_3).toLocaleString()}</td>
            //                 <td>Rp. ${parseInt(elementSk.rp_tri_4).toLocaleString()}</td>
            //                 <td><form action="/indikator_opd2/${elementSk.id}" method="POST" class="delete-data">
            //                     @csrf
            //                     <div class="btn-group" role="group" aria-label="Action Button">
            //                         <input type="hidden" name="_method" value="DELETE">
            //                         <a type="button" class="btn btn-sm btn-warning m-2 btn-mod-edit-target-pemerintah" id="${elementSk.id}"><i class="fa fa-edit"></i></a>
            //                     </div>
            //                 </form></td>
            //             </tr>
            //                 `       
            //                     }
            //                 })


            //                     }
            //                 })

                            
            //                     }
            //                 })
            //                 //add Kegiatan thingy here.
            //             }
            //         })
                    
            //     }
            // })
            //     }
            // })
            td2 += `</tbody></table>`
                $('#table').html(td2);
                $('#table2').html(td2);
                $('#rpjmd_check').prop('checked', true)
                $('#button-tambah').attr('hidden', true);

}
    </script>
@endpush
@endsection