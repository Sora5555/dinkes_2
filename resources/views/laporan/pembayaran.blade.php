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
                    <form action="{{route("export-pembayaran")}}" method="get">
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label for="date1">Awal</label>
                            <input type="date" name="date1" class="form-control" value='{{ date('Y-m-d') }}' id='date1'>
                        </div>

                        <div class="col-md-2">
                            <label for="date2">Akhir</label>
                            <input type="date" name="date2" class="form-control" value='{{ date('Y-m-d') }}' id='date2'>
                        </div>
                        <div class="col-md-2">
                            <label for="Wilayah">Wilayah</label>
                            <select name="wilayah" id="wilayah" class="form-control">
                                <option value="" selected>Pilih Wilayah</option>
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
                        <div class="col-md-2">
                            <label for="metode">Cara Pembayaran</label>
                            <select name="metode" id="tipe" class="form-control">
                                <option value="">Semua</option>
                                <option value="QRIS">Qris</option>
                                <option value="Virtual Account">VA</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-success">Excel</button>
                </form>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class='table-responsive'>
                    <table id="datatable" class="table table-bordered table-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="text-center">
                        <tr>
                            <th>No Pembayaran</th>
                            <th>Tanggal Penerimaan</th>
                            <th>Nama</th>
                            <th>Tagihan</th>
                            <th>NPA</th>
                            <th>Penggunaan M<sup>3</sup></th>
                            <th>Denda</th>
                            <th>Total Tagihan</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                            <th>Wilayah</th>
                            <th>Sektor</th>
                            <th>Klasifikasi</th>
                            <th>Metode</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr style="display: none">
                                <th>Total Tagihan</th>
                                <th>Total Denda</th>
                            </tr>
                            <tr style="display: none">
                                <td class="tagihan"></td>
                                <td class="denda"></td>
                            </tr>
                        </tbody>
                    </table>
</div>
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
        $("#datatable").append('<tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tfoot>');
        let table = $('#datatable').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            order: [[ 0, "desc" ]],
            ajax: {
                'url': '{{ route("datatable.laporan_pembayaran") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.date1 = $('#date1').val();
                    d.date2 = $('#date2').val();
                    d.wilayah = $('#wilayah').val();
                    d.sektor = $('#sektor').val();
                    d.klasifikasi = $('#klasifikasi').val();
                    d.tipe= $('#tipe').val();
                },
            },
            columns: [
                {data:'id_pembayaran',name:'tagihans.id'},
                {data:'tanggal_penerimaan',name:'tanggal_penerimaan'},
                {data:'name',name:'pelanggans.name'},
                {data:'jumlah_pembayaran', name:'tagihans.jumlah_pembayaran'},
                {data:'tarif', name:"tagihans.tarif"},
                {data:'npa', name:'tagihans.meter_penggunaan'},
                {data:'denda', name:'tagihans.denda_harian'},
                {data:'total_bayar', name:'total_bayar'},
                {data:'tanggal', name:'tanggal'},
                {data:'tanggal_akhir', name:'tanggal_akhir'},
                {data: 'nama_daerah', name:"upt_daerahs.nama_daerah"},
                {data: 'sektor', name:"kategori_npa.sektor"},
                {data: 'kategori', name:"kategori_npa.kategori"},
                {data: 'metode', name:"tagihans.metode"}

            ],
            // dom: 'Bfrtip'
        });

        $('#date1').change(function(){
        table.draw();
        $.ajaxSetup({
            'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
        })
        jQuery.ajax({
                'url': '{{ route("laporan.total") }}',
                'type': 'GET',
                data: {
                    date1: $('#date1').val(),
                    date2: $('#date2').val(),
                    wilayah: $('#wilayah').val(),
                    tipe: $('#tipe').val(),
                },
                success: function(result){
                     console.log(result);
                  },
            })
        });
        $('#date2').change(function(){
        table.draw();
        total()
        });
        $('#wilayah').change(function(){
        table.draw();
        total()
        });
        $('#sektor').change(function(){
        table.draw();
        total()
        });
        $('#klasifikasi').change(function(){
        table.draw();
        total()
        });
        $('#tipe').change(function(){
        table.draw();
        total()
        });
    </script>
@endpush
@endsection