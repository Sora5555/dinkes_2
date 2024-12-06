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

                    <form action="{{ route($route.'.store') }}" method='POST' id="myForm">
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
                                <label for="example-text-input" class="col-md-5 col-form-label">No Tagihan / Nama Perusahaan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="id_pembayaran" id="id_pembayaran">
                                        <option value="">-- Pilih Pembayaran --</option>
                                        @foreach ($pembayarans as $pembayaran)
                                            <option value="{{ $pembayaran->id }}" @if($request->get('id') == $pembayaran->id) selected @endif>{{ $pembayaran->id_pembayaran }} - {{ $pembayaran->pelanggan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Nama</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="tel" name="nama" id="nama" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >No Telepon</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="tel" name="no_telepon" id="no_telepon" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Alamat</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <textarea class="form-control" name="alamat" id="alamat" readonly></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Bulan</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            {{-- <input class="form-control" type="text" name="id_pelanggan" id="example-text-input"> --}}
                                            <select class="form-control" name="bulan" id="bulan" disabled="disabled">
                                                @foreach ($dates as $date)
                                                    <option value="{{ $loop->index + 1 }}">{{ $date }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Tahun</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            <select class="form-control" name="tahun" id="tahun" disabled="disabled">
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Penggunaan Volume Air</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" name="total_pemakaian" id="total_pemakaian" readonly>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Denda</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="denda" id="denda"  readonly>
                                </div>
                            </div> --}}

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Jumlah Tagihan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-12">
                                    <p><h2>Rp. <span id="jumlah_tagihan">0</span></h2></p>
                                </div>
                            </div>
                            
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