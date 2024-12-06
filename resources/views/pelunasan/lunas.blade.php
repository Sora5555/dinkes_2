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

                    <form action="/pelunasan/storeLunas" method='POST' id="myForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-6">
                            {{-- <div class="row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">No Pembayaran</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="no_tagihan" id="example-text-input">
                                </div>
                            </div> --}}
                            <div class="row">
                                <label for="example-text-input" class="col-md-5 col-form-label">Nama Perusahaan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="id_pelanggan" id="id_pelanggan">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Jumlah Penggunaan M<sup>3</sup></label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="pemakaian" id="pemakaian" pattern="[0-9]+([,\.][0-9]+)?" step="any">
                                </div>
                            </div> 

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Pembayaran</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="jumlah_pembayaran" id="jumlah_pembayaran" pattern="[0-9]+([,\.][0-9]+)?" step="any">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Denda Keterlambatan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="denda" id="denda" pattern="[0-9]+([,\.][0-9]+)?" step="any">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Denda Admin</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="denda_admin" id="denda_admin" pattern="[0-9]+([,\.][0-9]+)?" step="any">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-6 col-form-label">Tanggal Penerimaan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-8">
                                    <input type="date" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control tanggal_akhir">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-6 col-form-label">Periode</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-8">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control tanggal_akhir">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-6 col-form-label">Bukti Pembayaran (harus berupa file .jpg/.png)</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-8">
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-5 col-form-label">Penandatangan SKPD</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="jabatan_id" id="id_pelanggan">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-5 col-form-label">Penandatangan STPD</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="jabatan_id2" id="id_pelanggan">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-5 col-form-label">Penandatangan Surat Setoran</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="jabatan_id3" id="id_pelanggan">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        <div class="col-6">

                            {{-- <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Denda</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="denda" id="denda"  readonly>
                                </div>
                            </div> --}}

                            <div class="mb-3 row">
                                <div class="col-md-11">
                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>                  
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>



@include('pelunasan.js')



@endsection