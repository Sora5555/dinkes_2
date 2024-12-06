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
                    {!! Form::model($pembayaran,['route'=>[$route.'.newUpdate',$pembayaran->id],'method'=>'PUT','id'=>'myForm']) !!}
                        @csrf
                        @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Detail Tagihan</h2>
                            <table class="table">
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->name}}</th>
                                </tr>
                                <tr>
                                    <th>Nomor Pelanggan</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->no_pelanggan}}</th>
                                </tr>
                                <tr>
                                    <th>Nik</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->nik}}</th>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->kategori_npa->kategori}}</th>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->no_telepon}}</th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->alamat}}</th>
                                </tr>
                                <tr>
                                    <th>Daerah</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->pelanggan->daerah->nama_daerah??'-'}}</th>
                                </tr>
                                <tr>
                                    <th>Penggunaan</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->meter_penggunaan_sebelumnya != null? $pembayaran->meter_penggunaan - $pembayaran->meter_penggunaan_sebelumnya:$pembayaran->meter_penggunaan}} M<sup>3</sup></th>
                                </tr>
                                <tr>
                                    <th>Periode Tagihan</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->tanggal->isoFormat('MMMM-Y')}}</th>
                                </tr>
                                <tr>
                                    <th>Tanggal Lapor</th>
                                    <th>:</th>
                                    <th>{{$pembayaran->created_at->isoFormat('D-MMMM-Y')}}</th>
                                </tr>
                            </table>
                        </div>

                   


                        <div class="col-md-6">
                            <div class="row">
                                                                
                            </div>
                            
                            <div class="row">
                                <label for="example-text-input" class="col-md-12 col-form-label" >Denda Keterlambatan (2%/Bulan)</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-10">
                                    <h3>Rp.{{number_format($denda_harian)}}</h3>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-12 col-form-label" >Sanksi Administrasi (Rp25.000/bulan)</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <h3>Rp.{{number_format($pembayaran->denda_admin)}}</h3>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Tagihan Penggunaan</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <h2>Rp.<span id="jumlah_tagihan">{{number_format($pembayaran->jumlah_pembayaran)}}</span></h2>
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Nomor Surat Setoran</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <h2><span id="jumlah_tagihan">{{$pembayaran->nomor_surat_setoran}}</span></h2>
                                </div>
                            </div>

                             <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Total Tagihan</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <h2>Rp.<span id="jumlah_tagihan">{{number_format($pembayaran->jumlah_pembayaran+$pembayaran->denda_admin+$denda_harian)}}</span></h2>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Penandatangan Surat Setoran</label>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-12">
                                    <select name="jabatan3" id="jabatan" class="form-control">
                                        @foreach($jabatans as $jabatan)
                                            <option value="{{$jabatan->id}}">{{$jabatan->nama}} - {{$jabatan->jabatan}} {{$jabatan->daerah->nama_daerah}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <div class="col-md-11">
                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Lunas</button>
                                    <a class="btn btn-success btn-mod">Bukti</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>
<div class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gambar Bukti Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <center>
            <img class="img img-fluid" src="{{asset($file_path)}}/{{$file_name}}">
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
    $(document).ready(function(){
        getDatas();
    });

    $('.btn-mod').click(function(){
        $('.modal').modal('toggle');
    });
</script>  
@endpush


@include('pembayaran.js')



@endsection