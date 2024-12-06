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

                    <form action="{{ route($route.'.update', ['tagihan_pemasangan' => $id]) }}" method='POST' id="myForm">
                        @csrf
                        @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">No Pembayaran</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="no_tagihan" id="example-text-input" readonly value="{{ $datas->id_tagihan_pemasangan }}">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">No Pelanggan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="id_pelanggan" id="id_pelanggan">
                                        <option value="">-- Pilih Pelanggan --</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}" @if($datas->pelanggan_id == $pelanggan->id) selected @endif>{{ $pelanggan->id_pelanggan }} - {{ $pelanggan->name }}</option>
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
                                        <label for="example-text-input" class="col-md-6 col-form-label">Pembayaran</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            {{-- <input class="form-control" type="text" name="id_pelanggan" id="example-text-input"> --}}
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="tipe_pembayaran" id="cash" value="0" checked="">
                                                <label class="form-check-label" for="cash">
                                                    Cash
                                                </label>
                                            </div>

                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="tipe_pembayaran" id="angsuran" value="1">
                                                <label class="form-check-label" for="angsuran">
                                                    Angsuran
                                                </label>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

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
                                    <button type="submit" class="btn btn-primary">Submit</button>
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

@push('scripts')
    <script>
        $(document).ready(function(){
        getDatas();
    });
    </script>
@endpush

@include('tagihan_pemasangan.js')



@endsection