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

                    {{-- <h4 class="card-title">Textual inputs</h4>
                    <p class="card-title-desc">Here are examples of <code>.form-control</code> applied to each
                        textual HTML5 <code>&lt;input&gt;</code> <code>type</code>.</p> --}}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {!! Form::model($data,['route'=>[$route.'.update',$data->id],'method'=>'PUT','onsubmit'=>'','id'=>'myForm','files'=>true]) !!}
                        @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Awal</label>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-8">
                                            {{-- <input class="form-control" type="text" name="id_pelanggan" id="example-text-input"> --}}
                                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control tanggal_awal" value="{{$data->tanggal->format("Y-m-d")}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Akhir</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control tanggal_akhir" value="{{$data->tanggal_akhir}}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="inputs">
                                <div class="row">
                                    <div class="col-md-3"><label for="meter_sekarang" class="col-md-4 col-form-label">Pemakaian</label></div>
                                    <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >Pembayaran</label></div>
                                    <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >Denda</label></div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-3">
                                        <input class="form-control meter_sekarang" type="number" name="pemakaian" id="meter_sekarang" min="0" value="{{$data->meter_penggunaan}}">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control pemakaian" type="number" name="pembayaran" id="pemakaian" value="{{$data->jumlah_pembayaran}}" step="any">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control pemakaian" type="number" name="denda" id="pemakaian" value="{{$data->denda_harian}}" step="any">
                                    </div>
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
                    

                    
                                            
                    {!! Form::close() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>


@endsection