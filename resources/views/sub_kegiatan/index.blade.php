@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Jumlah Posyandu dan Posbindu</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                        <li class="breadcrumb-item active">Posyandu dan Posbindu</li>
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
                        <div class="col-md-10 d-flex justify-content-start">
                            {{-- {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                            <select name="program_id" form="storeForm" id="program_id" class="form-control">
                                <option value="">Pilih Program</option>
                            </select>
                            <select name="kegiatan_id" form="storeForm" id="kegiatan_id" class="form-control">
                                <option value="">Pilih Kegiatan</option>
                            </select>
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="2023">2023</option>
                            </select> --}}
                        </div>
                        {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <form action="{{url('import_sub_kegiatan')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-10">
                                    <label for="">Contoh File Import : <a href="{{asset('import/SubKegiatan Example.xlsx')}}" target="_blank">Download</a></label>
                                    <input type="file" name="excel_file" class="form-control" id="">
                                </div>
                                <div class="col-2">
                                    <label for="">-</label><br>
                                    <button type="submit" class="btn btn-success">Import</button>
                                    <a href="{{url("/export_sub_kegiatan")}}" class="btn btn-primary">Export</a>
                                </div>
                            </div>
                        </form> --}}
                        <div class="row justify-content-start mb-2">
                            <div class="col-md-10 d-flex justify-content-around gap-3">
                                @if(Auth::user()->downloadFile('sub_kegiatan', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="sub_kegiatan" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('sub_kegiatan', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('sub_kegiatan', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="sub_kegiatan" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>

                                </form>
                                @endif
                                @if(Auth::user()->hasFile('sub_kegiatan', Session::get('year')) && Auth::user()->downloadFile('sub_kegiatan', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('sub_kegiatan', Session::get('year'))->file_path.Auth::user()->downloadFile('sub_kegiatan', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{url("/export_sub_kegiatan")}}" ><i class="mdi mdi-note"></i>Report</a>
                            </div>
                        </div>
                        <br>
                        <thead class="text-center">
                        <tr>
                            <th rowspan="3">Puskesmas</th>
                            <th colspan="9">Strata Posyandu</th>
                            <th rowspan="2" colspan="2">Posyandu Aktif</th>
                            <th rowspan="3">Jumlah Posbindu PTM</th>
                            @role('Pihak Wajib Pajak')
                            <th rowspan="3">Action</th>
                            @endrole
                        </tr>
                        <tr>
                            <th colspan="2">Pratama</th>
                            <th colspan="2">Madya</th>
                            <th colspan="2">Purnama</th>
                            <th colspan="2">Mandiri</th>
                            <th rowspan="3">Total</th>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <th>%</th>
                            <th>Jumlah</th>
                            <th>%</th>
                            <th>Jumlah</th>
                            <th>%</th>
                            <th>Jumlah</th>
                            <th>%</th>
                            <th>Jumlah</th>
                            <th>%</th>
                            {{-- <th></th> --}}
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($unit_kerja as $item)
                                @php
                                    $persen = ( ($item->Posyandu->pratama ?? 0) + ($item->Posyandu->madya ?? 0) + ($item->Posyandu->purnama ?? 0) + ($item->Posyandu->mandiri ?? 0));
                                @endphp
                                <tr>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->Posyandu->pratama ?? 0}}</td>
                                    <td>{{($item->Posyandu->pratama ?? 0) > 0?number_format((($item->Posyandu->pratama ?? 0)/$persen)*100, '2'):0}}%</td>
                                    <td>{{($item->Posyandu->madya ?? 0)}}</td>
                                    <td>{{ ($item->Posyandu->madya ?? 0) > 0?number_format((($item->Posyandu->madya ?? 0)/($persen))*100, '2'):0}}%</td>
                                    <td>{{$item->Posyandu->purnama ?? 0}}</td>
                                    <td>{{  ($item->Posyandu->purnama ?? 0) > 0?number_format((($item->Posyandu->purnama ?? 0)/($persen))*100, '2'):0}}%</td>
                                    <td>{{$item->Posyandu->mandiri ?? 0}}</td>
                                    <td>{{ ($item->Posyandu->mandiri ?? 0) > 0?number_format((($item->Posyandu->mandiri ?? 0)/($persen))*100, '2'):0}}%</td>
                                    <td>{{ ($item->Posyandu->pratama ?? 0) + ($item->Posyandu->madya ?? 0) + ($item->Posyandu->purnama ?? 0) + ($item->Posyandu->mandiri ?? 0)}}</td>
                                    <td>{{ $item->Posyandu->aktif ?? 0}}</td>
                                    <td>{{ ($item->Posyandu->aktif ?? 0) > 0?number_format(( ($item->Posyandu->aktif ?? 0)/($persen))*100, '2'): 0}}%</td>
                                    <td>{{$item->Posyandu->posbindu ?? 0}}</td>
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
                'url': '{{ route("datatable.sub_kegiatan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.kegiatan_id = $('#kegiatan_id').val();
                },
            },
            columns: [
                {data:'kode',name:'kode'},
                {data:'nama',name:'nama'},
                {data:'sasaran',name:'sasaran'},
                {data: 'indikator', name:'indikator'}
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
                    'url'	: `/sub_kegiatan/${id}`,

                    'data'	: {'id': id},
                    success	: function(res){
                        console.log(res);

                        $clickedRow.nextAll('.detail-row').remove();
                        res.forEach(function(item) {
                        let pratamaPersent = 0;
                        let madyaPersent = 0;
                        let purnamaPersent = 0;
                        let mandiriPersent = 0;
                        let aktifPersent = 0;

                        let PosyanduTotal = 0;
                        if(item.posyandu != null) {
                            let PosyanduTotal = parseInt(item.posyandu.pratama + item.posyandu.madya + item.posyandu.purnama + item.posyandu.mandiri);

                            pratamaPersent = parseFloat((item.posyandu.pratama / ( PosyanduTotal)) * 100);

                            madyaPersent = parseFloat((item.posyandu.madya / ( PosyanduTotal)) * 100);
                            purnamaPersent = parseFloat((item.posyandu.purnama / ( PosyanduTotal)) * 100);
                            mandiriPersent = parseFloat((item.posyandu.mandiri / ( PosyanduTotal)) * 100);
                            aktifPersent = parseFloat((item.posyandu.aktif / ( PosyanduTotal)) * 100);
                        }

                        let newRow = `
                            <tr class="detail-row" style="background: #f9f9f9;">
                                <td>${item.nama}</td>
                                <td>${ item.posyandu != null ? item.posyandu.pratama : 0}</td>
                                <td>${parseFloat(pratamaPersent.toFixed(2))}%</td>
                                <td>${ item.posyandu != null ? item.posyandu.madya : 0}</td>
                                <td>${parseFloat(madyaPersent.toFixed(2))}%</td>
                                <td>${ item.posyandu != null ? item.posyandu.purnama : 0}</td>
                                <td>${parseFloat(purnamaPersent.toFixed(2))}%</td>
                                <td>${ item.posyandu != null ? item.posyandu.mandiri : 0}</td>
                                <td>${parseFloat(mandiriPersent.toFixed(2))}%</td>
                                <td>${PosyanduTotal}</td>
                                <td>${ item.posyandu != null ? item.posyandu.aktif : 0}</td>
                                <td>${parseFloat(aktifPersent.toFixed(2))}%</td>
                                <td>${ item.posyandu != null ? item.posyandu.posbindu : 0}</td>

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
        $('#program_id').change(function(){
            let program_id = $("#program_id").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiKegiatan/sub_kegiatan')}}/${program_id}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Kegiatan</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#kegiatan_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });

        $("#kegiatan_id").change(function(){
            table.draw()
        })
        $('.btn-tambah-program').click(function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();
                let kegiatan_id = $("#kegiatan_id").val();


                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="kegiatan_id" value="${kegiatan_id}">
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
                $('#title').html('Tambah Data Sub Kegiatan');
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
                url: `{{url('apiEdit/sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){
                            console.log(res.data)
                            let textUraian = `<input type="text" name="pratama" id="nama" class="form-control" value="${res.posyandu.pratama}">`
                            let textKode = `<input type="text" name="madya" class="form-control" id="bezetting" value="${res.posyandu.madya}">`
                            let textPosyanduPurnama = `<input type="text" name="purnama" class="form-control" id="bezetting" value="${res.posyandu.purnama}">`
                            let textPosyanduMandiri = `<input type="text" name="mandiri" class="form-control" id="bezetting" value="${res.posyandu.mandiri}">`
                            let textPosyanduAktif = `<input type="text" name="aktif" class="form-control" id="bezetting" value="${res.posyandu.aktif}">`
                            let textPosbindu = `<input type="text" name="posbindu" class="form-control" id="bezetting" value="${res.posyandu.posbindu}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posyandu Pratama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posyandu Madya</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posyandu Purnama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="purnamaField">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posyandu Mandiri</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="mandiriField">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posyandu Aktif</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="aktifField">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Posbindu</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="posbinduField">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#purnamaField').html(textPosyanduPurnama);
                $('#mandiriField').html(textPosyanduMandiri);
                $('#aktifField').html(textPosyanduAktif);
                $('#posbinduField').html(textPosbindu);
                $('#EditForm').attr('action', `/sub_kegiatan/${id}`)
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
                {!! Form::open(['route'=>'sasaran_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sub_kegiatan_id" value="${id}">
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
                url: `{{url('apiEdit/sasaran_sub_kegiatan')}}/${id}`,
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
                $('#EditForm').attr('action', `/sasaran_sub_kegiatan/${id}`)
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
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sasaran_sub_kegiatan_id" value="${id}">
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
                url: `{{url('apiEdit/indikator_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
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
                $('#EditForm').attr('action', `/indikator_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Indikator Sub Kegiatan');
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
