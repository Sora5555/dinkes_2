@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Jumlah Tenaga Medis di Fasilitas Kesehatan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Jumlah Tenaga Medis</li>
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
                    <div class="row mb-2">

                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        {{-- <form action="{{url('import_pemangku')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/Pemangku Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                </div>
                            </div>
                        </form> --}}
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-around gap-3">
                                @if(Auth::user()->downloadFile('pemangku', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="pemangku" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('pemangku', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('pemangku', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="pemangku" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>
                                @endif
                                @if(Auth::user()->hasFile('pemangku', Session::get('year')) && Auth::user()->downloadFile('pemangku', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('pemangku', Session::get('year'))->file_path.Auth::user()->downloadFile('pemangku', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{url('export_pemangku')}}" ><i class="mdi mdi-note"></i>Export</a>
                            </div>
                        </div>
                        <br>
                        <table id="data" class="table table-bordered" style="width:100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Unit Kerja</th>
                                <th colspan="3">Dr. Spesialis</th>
                                <th colspan="3">Dokter</th>
                                <th colspan="3">Total</th>
                                <th colspan="3">Dokter Gigi</th>
                                <th colspan="3">Dokter Gigi Spesialis</th>
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
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                {{-- <th></th> --}}
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($unit_kerja as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->DokterSpesialis->laki_laki ?? 0}}</td>
                                        <td>{{$item->DokterSpesialis->perempuan ?? 0}}</td>
                                        <td>{{($item->DokterSpesialis->laki_laki ?? 0) + ($item->DokterSpesialis->laki_laki ?? 0)}}</td>

                                        <td>{{($item->Dokter->laki_laki ?? 0)}}</td>
                                        <td>{{($item->Dokter->perempuan ?? 0)}}</td>
                                        <td>{{ ($item->Dokter->laki_laki ?? 0) + ($item->Dokter->perempuan ?? 0)}}</td>

                                        <td>{{ ($item->Dokter->laki_laki ?? 0) + ($item->DokterSpesialis->laki_laki ?? 0)}}</td>
                                        <td>{{ ($item->Dokter->perempuan ?? 0) + ($item->DokterSpesialis->perempuan ?? 0)}}</td>
                                        <td>{{ ($item->Dokter->laki_laki ?? 0) + ($item->Dokter->perempuan ?? 0) + ($item->DokterSpesialis->laki_laki ?? 0) + ($item->DokterSpesialis->perempuan ?? 0)}}</td>

                                        <td>{{ ($item->DokterGigi->laki_laki ?? 0)}}</td>
                                        <td>{{ ($item->DokterGigi->perempuan ?? 0)}}</td>
                                        <td>{{ ($item->DokterGigi->laki_laki ?? 0) + ($item->DokterGigi->perempuan ?? 0)}}</td>

                                        <td>{{$item->DokterGigiSpesialis->laki_laki  ?? 0}}</td>
                                        <td>{{$item->DokterGigiSpesialis->perempuan ?? 0}}</td>
                                        <td>{{ ($item->DokterGigiSpesialis->laki_laki ?? 0) + ($item->DokterGigiSpesialis->perempuan ?? 0)}}</td>

                                        <td>{{ ($item->DokterGigiSpesialis->laki_laki ?? 0) + ($item->DokterGigi->laki_laki ?? 0)}}</td>
                                        <td>{{ ($item->DokterGigiSpesialis->perempuan ?? 0) + ($item->DokterGigi->perempuan ?? 0)}}</td>
                                        <td>{{ ($item->DokterGigiSpesialis->laki_laki ?? 0) + ($item->DokterGigiSpesialis->perempuan ?? 0) + ($item->DokterGigi->laki_laki ?? 0) + ($item->DokterGigi->perempuan ?? 0)}}</td>
                                        {{-- <td><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td> --}}
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
    <script src="{{asset('assets/js/pages/modal.init.js')}}"></script>
    <script>
        var table = $('#datatable').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                'url': '{{ route("datatable.pemangku") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.induk_opd = $('#induk_opd').val();
                },
            },
            columns: [
                {data: 'jabatan', name: 'jabatan'},
                {data: 'nip', name: 'nip'},
                {data: 'nama', name: 'nama'},
                {data: 'golongan', name: 'golongan'},
                {data:'action',name:'action'},
            ],
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
                    'url'	: `/pemangku/${id}`,
                    'data'	: {'id': id},
                    success	: function(res){
                        console.log(res);

                        $clickedRow.nextAll('.detail-row').remove();
                        res.forEach(function(item) {
                        let newRow = `
                            <tr class="detail-row" style="background: #f9f9f9;">
                                <td></td>
                                <td>${item.nama}</td>
                                <td>${ item.dokter_spesialis != null ? item.dokter_spesialis.laki_laki : 0}</td>
                                <td>${ item.dokter_spesialis != null ? item.dokter_spesialis.perempuan : 0}</td>
                                <td>${ item.dokter_spesialis != null ? parseInt(item.dokter_spesialis.laki_laki + item.dokter_spesialis.perempuan) : 0}</td>

                                <td>${ item.dokter != null ? item.dokter.laki_laki : 0}</td>
                                <td>${ item.dokter != null ? item.dokter.perempuan : 0}</td>
                                <td>${ item.dokter != null ? parseInt(item.dokter.laki_laki + item.dokter.perempuan) : 0}</td>

                                <td>${ item.dokter != null ? parseInt(item.dokter.laki_laki + item.dokter_spesialis.laki_laki) : 0}</td>
                                <td>${ item.dokter != null ? parseInt(item.dokter.perempuan + item.dokter_spesialis.perempuan) : 0}</td>
                                <td>${ item.dokter != null ? parseInt(item.dokter.laki_laki + item.dokter_spesialis.laki_laki + item.dokter_spesialis.perempuan + item.dokter.perempuan) : 0}</td>

                                <td>${ item.dokter_gigi != null ? item.dokter_gigi.laki_laki : 0}</td>
                                <td>${ item.dokter_gigi != null ? item.dokter_gigi.perempuan : 0}</td>
                                <td>${ item.dokter_gigi != null ? parseInt(item.dokter_gigi.laki_laki + item.dokter_gigi.perempuan) : 0}</td>

                                <td>${ item.dokter_gigi_spesialis != null ? item.dokter_gigi_spesialis.laki_laki : 0}</td>
                                <td>${ item.dokter_gigi_spesialis != null ? item.dokter_gigi_spesialis.perempuan : 0}</td>
                                <td>${ item.dokter_gigi_spesialis != null ? parseInt(item.dokter_gigi_spesialis.laki_laki + item.dokter_gigi_spesialis.perempuan) : 0}</td>

                                <td>${ item.dokter_gigi != null ? parseInt(item.dokter_gigi.laki_laki + item.dokter_gigi_spesialis.laki_laki) : 0}</td>
                                <td>${ item.dokter_gigi != null ? parseInt(item.dokter_gigi.perempuan + item.dokter_gigi_spesialis.perempuan) : 0}</td>
                                <td>${ item.dokter_gigi != null ? parseInt(item.dokter_gigi.laki_laki + item.dokter_gigi_spesialis.laki_laki + item.dokter_gigi_spesialis.perempuan + item.dokter_gigi.perempuan) : 0}</td>
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

        $('#induk_opd').change(function(){
        table.draw();
        });

        $('#datatable').on('click', '.btn-mod', function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();
                let id = $(this).attr('id')

                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){

                            let template = `
            {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <input name="jabatan_id" type="hidden" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('nama',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nip</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('nip',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('.modal').modal('toggle');
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
        $('#data').on('click', '.btn-mod2', function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let id = $(this).attr('id')

                $.ajax({
                    type: "get",
                    url: `{{url('api/pemangku')}}/${id}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            let dokterSpesialisLakiLaki = `<input type="text" name="dokter_spesialis_laki_laki" class="form-control" value="${res.dokterSpesialis.laki_laki}">`
                            let dokterSpesialisPerempuan = `<input type="text" name="dokter_spesialis_perempuan" class="form-control" value="${res.dokterSpesialis.perempuan}">`
                            let dokterLakiLaki = `<input type="text" name="dokter_laki_laki" class="form-control" value="${res.dokter.laki_laki}">`
                            let dokterPerempuan = `<input type="text" name="dokter_perempuan" class="form-control" value="${res.dokter.perempuan}">`
                            let dokterGigiLakiLaki = `<input type="text" name="dokter_gigi_laki_laki" class="form-control" value="${res.dokterGigi.laki_laki}">`
                            let dokterGigiPerempuan = `<input type="text" name="dokter_gigi_perempuan" class="form-control" value="${res.dokterGigi.perempuan}">`
                            let dokterGigiSpesialisLakiLaki = `<input type="text" name="dokter_gigi_spesialis_laki_laki" class="form-control" value="${res.dokterGigiSpesialis.laki_laki}">`
                            let dokterGigiSpesialisPerempuan = `<input type="text" name="dokter_gigi_spesialis_perempuan" class="form-control" value="${res.dokterGigiSpesialis.perempuan}">`
                            let template = `
            {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'editForm']) !!}
            <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Spesialis (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Spesialis (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nip-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-laki_laki-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-perempuan-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Gigi (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-gigi-laki_laki-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Gigi (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-gigi-perempuan-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Gigi Spesialis (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-gigi-spesialis-laki_laki-field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Dokter Gigi Spesialis (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="dokter-gigi-spesialis-perempuan-field">
                </div>
            </div>
            </div>
                `
                console.log(id);
                $('.modal-body').html(template)
                $("#nama-field").html(dokterSpesialisLakiLaki)
                $("#nip-field").html(dokterSpesialisPerempuan)
                $("#dokter-laki_laki-field").html(dokterLakiLaki)
                $("#dokter-perempuan-field").html(dokterPerempuan)
                $("#dokter-gigi-laki_laki-field").html(dokterGigiLakiLaki)
                $("#dokter-gigi-perempuan-field").html(dokterGigiPerempuan)
                $("#dokter-gigi-spesialis-laki_laki-field").html(dokterGigiSpesialisLakiLaki)
                $("#dokter-gigi-spesialis-perempuan-field").html(dokterGigiSpesialisPerempuan)
                $('#editForm').attr('action', `/pemangku/${id}`)
                $('#submitButton').attr('form', 'editForm')
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
