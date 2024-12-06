@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
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
                        <div class="col-md-2">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                @foreach ($sektor as $s)
                                    <option value="{{$s->id}}" {{ app('request')->input('id') == $s->id?"selected":"" }}>{{$s->kategori_npa->kategori}} - {{$s->lokasi}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end mb-2">
                        <div class="col-md-2">
                            <a href="" onclick="redir()" class="btn btn-primary col-md-12 a"><i
                                    class="mdi mdi-plus"></i> Tambah</a>
                        </div>
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered" style="width:100%;">
                            <thead class=" text-center">
                                <tr>
                                    <th>No Tagihan</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Penggunaan (m³)</th>
                                    <th>Tagihan</th>
                                    <th>Denda Keterlambatan</th>
                                    <th>Sanksi Administrasi</th>
                                    <th>Total Tagihan</th>
                                    <th>Bulan</th>
                                    {{-- <th>Sampai</th> --}}
                                    <th>Status</th>
                                    <th>Pembayaran</th>
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

    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Modal Heading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="pesan">
                        <ol>
                            <li>Pembayaran <span class="tipe"></span> berlaku selama 1 jam</li>
                            <li>Pembayaran dapat dilakukan melalui penyedia pembayaran <span class="tipe"></span></li>
                            <li>Jika Setuju, dalam 1 jam kedepan pembayaran hanya dilakukan melalui <span class="tipe"></span></li>
                        </ol>

                    </div>
                    <div class="progress" style="display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="Sedang memproses" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Memproses...</div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="first">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-true" link="" types="">Setuju</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/pages/modal.init.js') }}"></script>
<script>
    const a = document.querySelector(".a");


    function redir(){
        a.href = `tagihan/create?category=${$('#kategori').val()}`;
    }
var table = $('#datatable').DataTable({
    responsive: false,
    processing: true,
    serverSide: true,
    order: [
        [0, "desc"]
    ],
    ajax: {
        'url': '{{route('datatable.tagihan')}}',
        'type': 'GET',
        'beforeSend': function(request) {
            request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
        },
        data: function (d) {
                    d.status_pembayaran = $('#status_pembayaran').val();
                    d.date1 = $('#date1').val();
                    d.date2 = $('#date2').val();
                    d.wilayah = $('#wilayah').val();
                    d.sektor = $('#kategori').val();
                },
    },
    columns: [{
            data: 'id_tagihan',
            name: 'id_tagihan'
        },
        {
            data: 'name',
            name: 'pelanggan.name'
        },
        {
            data: 'meter_penggunaan',
            name: 'meter_penggunaan'
        },
        {
            data: 'jumlah_pembayaran',
            name: 'jumlah_pembayaran'
        },
        {
            data: 'denda_Keterlambatan',
            name: 'denda_Keterlambatan'
        },
        {
            data: 'denda_admin',
            name: 'denda_admin'
        },
        {
            data: 'total_tagihan',
            name: 'total_tagihan'
        },
        {
            data: 'tanggal',
            name: 'tanggal'
        },
        // {
        //     data: 'tanggal_akhir',
        //     name: 'tanggal_akhir'
        // },
        {
            data: 'status_pemb',
            name: 'status_pemb'
        },
        {
            data: 'pembayaran',
            name: 'pembayaran'
        },
        {
            data: 'action',
            name: 'action',
            searchable: false
        },

    ],
    "language": {
        "search": "Cari: ",
        "paginate": {
            'previous': "Sebelumnya",
            "next": "Selanjutnya"
        },
        "infoEmpty": " 0 sampai 0 dari 0 data",
        "info": "_START_ sampai _END_ dari _TOTAL_ data",
        "lengthMenu": "Tampilkan _MENU_ data",
    }
});
</script>
@endpush


@push('scripts')
<script type="text/javascript">
$('body').on('click', '.btn-va', function() {
    $('#myModal').modal('toggle');
    $('#myModal').find('.modal-title').text($(this).attr('title'));
    $('#myModal').find('.tipe').text($(this).attr('types'));
    $('#myModal').find('.btn-true').attr('link',$(this).attr('link'));
    $('#myModal').find('.btn-true').attr('types',$(this).attr('types'));
    $('.alerts').remove();
    $('.progress').hide();
    $('.response-pesan').remove();
    $('.pesan').show();
    $('.first').show();
});

$('body').on('click','.btn-true',function(){
    $('.pesan').hide();
    $('.progress').show();
    $('.first').hide();
    $('.alerts').remove();
    $.ajax({
        url:$(this).attr('link'),
        type:'POST',
        dataType:'JSON',
        data:{_token:'{{csrf_token()}}',types:$(this).attr('types')},
    }).done(function(res){
        if (res.status == '200') {
             $('.progress').hide();
             $('#myModal').find('.modal-body').prepend(res.html);
        }
    }).fail(function(res){
        $('.pesan').show();
        $('.progress').hide();
        $('.first').show();
        var html = '<div class="alert alerts alert-danger">'+res.responseJSON.message+'</div>';
            $('#myModal').find('.modal-body').prepend(html);
    });
});

$('body').on('click','.btn-copy-va',function(){
    navigator.clipboard.writeText($('.va-number').text());
    alert('virtual account telah disalin');
});
$('#kategori').change(function(){
        window.location = "/tagihan?id="+$('#kategori').val();
        });
</script>
@endpush
@endsection