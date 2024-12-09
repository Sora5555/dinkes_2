@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Jumlah Tenaga Keperawatan dan Kebidanan di Fasilitas Kesehatan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                        <li class="breadcrumb-item active">keperawatan dan kebidanan</li>
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
                        {{-- <div class="col-md-2">
                            <button class="btn col-md-12 btn-mod" style="background: #23e283"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <form action="{{url('import_jabatan')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/jabatan Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <table id="data" class="table table-bordered" style="width:100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Unit Kerja</th>
                                <th colspan="3">Tenaga Keperawatan</th>
                                <th rowspan="2">Tenaga Kebidanan</th>
                                <th></th>
                                @role("Pihak Wajib Pajak")
                                <th rowspan="2">Action</th>
                                @endrole
                            </tr>
                            <tr>
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
                                        <td>{{$item->Perawat->sum("laki_laki")}}</td>
                                        <td>{{$item->Perawat->sum("perempuan")}}</td>
                                        <td>{{$item->Perawat->sum("laki_laki") + $item->Perawat->sum("perempuan")}}</td>
                                        <td>{{$item->Bidan->sum("perempuan")}}</td>
                                        <td><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td>
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
                {data:'jenis_jabatan',name:'jenis_jabatan'},
                {data:'action',name:'action'},
                // {data:'action',name:'action' , searchable: false},

            ],
        });
        $('#induk_opd').change(function(){
        table.draw();
        });

        $('#data').on('click', '.detail', function(){
            let id = $(this).attr('id');
            let $clickedRow = $(this).closest('tr'); // Get the clicked row elements
            if ($clickedRow.next().hasClass('detail-row')) {
                $clickedRow.nextAll('.detail-row').remove();
            } else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'type' 	: 'GET',
                    'url'	: `/jabatan/${id}`,
                    'data'	: {'id': id},
                    success	: function(res){
                        console.log(res);


                        $clickedRow.nextAll('.detail-row').remove();
                        res.forEach(function(item) {
                        let newRow = `
                            <tr class="detail-row" style="background: #f9f9f9;">
                                <td></td>
                                <td>${item.nama}</td>
                                <td>${ item.perawat != null ? item.perawat.laki_laki : 0}</td>
                                <td>${ item.perawat != null ? item.perawat.perempuan : 0}</td>
                                <td>${ item.perawat != null ? parseInt(item.perawat.laki_laki + item.perawat.perempuan) : 0}</td>
                                <td>${item.bidan != null ? item.bidan.perempuan : 0}</td>
                                <td></td>
                            </tr>
                            `;
                        $clickedRow.after(newRow); // Insert the new row after the clicked row
                        $clickedRow = $clickedRow.next(); // Move reference to the new row for subsequent inserts
                    });
                    }
                });
            }
            console.log(id);
        })

        $('#data').on('click', '.btn-mod2', function(){
            let induk_opd_id = $(this).attr('induk_opd_id');
            let induk_jabatan_id = $(this).attr('induk_jabatan_id');
            let jenis_jabatan_id = $(this).attr('jenis_jabatan_id');
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/jabatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            let textPerawatLakiLaki = `<input type="text" name="perawat_laki_laki" id="nama" class="form-control" value="${res.perawat.laki_laki}">`
                            let textPerawatPerempuan = `<input type="text" name="perawat_perempuan" class="form-control" id="bezetting" value="${res.perawat.perempuan}">`
                            let textBidan = `<input type="text" name="bidan" class="form-control" id="bezetting" value="${res.bidan.perempuan}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Keperawatan (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Keperawatan (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Kebidanan</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField2">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textPerawatLakiLaki)
                $('#bezettingField').html(textPerawatPerempuan);
                $('#bezettingField2').html(textBidan);
                $('#EditForm').attr('action', `/jabatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data');

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
                <label for="name" class="col-md-2 col-form-label">Unit Organisasi</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <select name="unit_organisasi_id" id="unit_organisasi_select" class="form-control">

                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama Jabatan</label>
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
