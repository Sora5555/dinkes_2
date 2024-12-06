@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{$title}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$title}}</a></li>
                        <li class="breadcrumb-item active">{{$title}}</li>
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
                        {{-- <div class="col-md-2">
                            <input type="date" name="date1" value='{{ date('Y-m-d') }}' id='date1'>
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="date2" value='{{ date('Y-m-d') }}' id='date2'>
                        </div> --}}
                        <div class="col-md-2">
                            <label for="wilayah">Wilayah</label>
                            <select name="wilayah" id="wilayah" class="form-control">
                                <option value="">Semua</option>
                                @foreach ($wilayah as $w)
                                    <option value="{{$w->id}}">{{$w->nama_daerah}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sektor">Sektor</label>
                            <select name="sektor" id="sektor" class="form-control">
                                <option value="">Semua</option>
                                @foreach ($kategori as $key=>$k)
                                    <option value="{{$key}}">{{$key}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="klasifikasi">Klasifikasi</label>
                            <select name="klasifikasi" id="klasifikasi" class="form-control">
                                <option value="">Semua</option>
                                @foreach ($klasifikasi as $key=>$k)
                                    <option value="{{$k->kategori}}">{{$k->kategori}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>No. Telepon</th>
                            <th>NIK</th>
                            <th>Wilayah</th>
                            <th>Sektor</th>
                            <th>Klasifikasi</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


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
                'url': '{{ route("datatable.laporan_pelanggan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                   d.wilayah = $('#wilayah').val();
                   d.sektor = $('#sektor').val();
                   d.klasifikasi = $('#klasifikasi').val();
                },
            },
            columns: [
                {data:'id',name:'users.id'},
                {data:'name',name:'name'},
                {data:'no_telepon',name:'no_telepon'},
                {data:'nik',name:'nik'},
                {data: 'nama_daerah', name: "upt_daerahs.nama_daerah"},
                {data: 'sektor', name: "kategori_npa.sektor"},
                {data: 'kategori', name: "kategori_npa.kategori"},
                {data:'created_at',name:'pelanggans.created_at'},

            ],
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ]
        });

        $('#date1').change(function(){
        table.draw();
        });
        $('#wilayah').change(function(){
        table.draw();
        });
        $('#sektor').change(function(){
        table.draw();
        });
        $('#klasifikasi').change(function(){
        table.draw();
        });
        $('#date2').change(function(){
        table.draw();
        });
    </script>
@endpush
@endsection