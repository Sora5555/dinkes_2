@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tenaga Biomedika, keterapian fisik dan keteknisan medik</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                        <li class="breadcrumb-item active">Terapi fisik, Biomedika, Teknis Medik</li>
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
                            <a href="{{ route($route.'.create') }}" class="btn col-md-12" style="background: #23e283"><i class="mdi mdi-plus"></i> Tambah</a>
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
                                <th colspan="3">Ahli Teknologi Lab Medik</th>
                                <th colspan="3">Tenaga Teknik Biomedika Lainnya</th>
                                <th colspan="3">Keterapian Fisik</th>
                                <th colspan="3">Keteknisan Medik</th>
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
                                        <td>{{$item->AhliLabMedik->laki_laki}}</td>
                                        <td>{{$item->AhliLabMedik->perempuan}}</td>
                                        <td>{{$item->AhliLabMedik->laki_laki + $item->AhliLabMedik->perempuan}}</td>
                                        <td>{{$item->TenagaTeknikBiomedik->laki_laki}}</td>
                                        <td>{{$item->TenagaTeknikBiomedik->perempuan}}</td>
                                        <td>{{$item->TenagaTeknikBiomedik->laki_laki + $item->TenagaTeknikBiomedik->perempuan}}</td>
                                        <td>{{$item->TerapiFisik->laki_laki}}</td>
                                        <td>{{$item->TerapiFisik->perempuan}}</td>
                                        <td>{{$item->TerapiFisik->laki_laki + $item->TerapiFisik->perempuan}}</td>
                                        <td>{{$item->KeteknisanMedik->laki_laki}}</td>
                                        <td>{{$item->KeteknisanMedik->perempuan}}</td>
                                        <td>{{$item->KeteknisanMedik->laki_laki + $item->KeteknisanMedik->perempuan}}</td>
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
            order: [[ 0, "desc" ]],
            ajax: {
                'url': '{{ route("datatable.upt_daerah") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                }
            },
            columns: [
                {data:'nama',name:'nama'},
                {data:'action',name:'action' , searchable: false},

            ],
        });

        $('#data').on('click', '.btn-mod2', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/biomedika')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textUraian = `<input type="text" name="teknisBiomedikaLakiLaki" id="nama" class="form-control" value="${res.teknisBiomedika.laki_laki}">`
                            let textKode = `<input type="text" name="teknisBiomedikaPerempuan" class="form-control" id="bezetting" value="${res.teknisBiomedika.perempuan}">`
                            let textTerapiFisikLakiLaki = `<input type="text" name="terapiFisikLakiLaki" class="form-control" id="bezetting" value="${res.terapiFisik.laki_laki}">`
                            let textTerapiFisikPerempuan = `<input type="text" name="terapiFisikPerempuan" class="form-control" id="bezetting" value="${res.terapiFisik.perempuan}">`
                            let textLabMedikLakiLaki = `<input type="text" name="labMedikLakiLaki" class="form-control" id="bezetting" value="${res.labMedik.laki_laki}">`
                            let textLabMedikPerempuan = `<input type="text" name="labMedikPerempuan" class="form-control" id="bezetting" value="${res.labMedik.perempuan}">`
                            let textKeteknisanMedikLakiLaki = `<input type="text" name="keteknisanMedikLakiLaki" class="form-control" id="bezetting" value="${res.keteknisanMedik.laki_laki}">`
                            let textKeteknisanMedikPerempuan = `<input type="text" name="keteknisanMedikPerempuan" class="form-control" id="bezetting" value="${res.keteknisanMedik.perempuan}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Teknis Biomedika (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Tenaga Teknis Biomedika (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Terapi Fisik (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="apotekerLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Terapi Fisik (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="apotekerPerempuanField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Lab Medik (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="LabMedikLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Lab Medik (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="LabMedikPerempuanField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Keteknisan Medik (L)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="KeteknisanMedikLakiLakiField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Keteknisan Medik (P)</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="KeteknisanMedikPerempuanField">
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#apotekerLakiLakiField').html(textTerapiFisikLakiLaki)
                $('#apotekerPerempuanField').html(textTerapiFisikPerempuan);
                $('#LabMedikLakiLakiField').html(textLabMedikLakiLaki);
                $('#LabMedikPerempuanField').html(textLabMedikPerempuan);
                $('#KeteknisanMedikLakiLakiField').html(textKeteknisanMedikLakiLaki);
                $('#KeteknisanMedikPerempuanField').html(textKeteknisanMedikPerempuan);
                $('#EditForm').attr('action', `/kategori_opd/${id}`);
                $('#submitButton').attr('form', 'EditForm');
                $('#title').html('Ubah data');

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