@extends('layouts.app')

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pembayaran</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pembayaran</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
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
                    <div class="row justify-content-start mb-2">
                    </div>
                    <div class="row justify-content-end mb-2">
                        <div class="col-md-2">
                            <a href="/pelunasan/importExcel" class="btn btn-success col-md-12"><i class="mdi mdi-plus"></i>Import Excel</a>
                        </div>
                        <div class="col-md-2">
                            <a href="/pelunasan/lunasTambah" class="btn btn-success col-md-12"><i class="mdi mdi-plus"></i>Tambah Data Pembayaran</a>
                        </div>
                    </div>
                    <div class="row justify-content-end mb-2">
                        <div class="col-md-2">
                            <a href="{{ route($route.'.create') }}" class="btn btn-primary col-md-12"><i class="mdi mdi-plus"></i>Tambah Pelunasan</a>
                        </div>
                        @role("Operator")
                        <div class="col-md-2">
                            <form action="pelunasan/delete" method="post">
                                @csrf
                                <button class="btn btn-danger col-md-12">Hapus Semua Data Pelunasan</button>
                            </form>
                        </div>
                        @endrole
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th>No Pembayaran</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Nama</th>
                                <th>Tagihan</th>
                                <th>Volume Air (M<sup>3</sup>)</th>
                                <th>Denda</th>
                                <th>Total Tagihan</th>
                                <th>Dari</th>
                                <th>Sampai</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>
<div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gambar Bukti</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modal_gambar" class="modal-body">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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
                'url': '{{ route("datatable.pelunasan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                   d.metode = $('#metode').val();
                },
            },
            columns: [
                {data:'id',name:'id'},
                {data:'tanggal_penerimaan', name:'tanggal_penerimaan'},
                {data:'name',name:'pelanggans.name'},
                {data:'tagihan', name:'tagihans.jumlah_pembayaran'},
                {data:'meter_penggunaan', name:'meter_penggunaan'},
                {data:'denda_harian', name:'denda_harian'},
                {data:'jumlah_pembayaran', name:'jumlah_pembayaran'},
                {data:'tanggal',name:'tanggal'},
                {data:'tanggal_akhir',name:'tanggal_akhir'},
                {data:'action',name:'action' , searchable: false},


            ],
        });
        $('#metode').change(function(){
        table.draw();
        });
    </script>
@endpush
@endsection