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
                        <li class="breadcrumb-item active">{{$route}}</li>
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

                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                    <form action="{{ route($route.'.update') }}" method='POST' enctype="multipart/form-data">
                        @csrf
                    {{-- <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ID Pelanggan</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="id_pelanggan" id="example-text-input">
                        </div>
                    </div> --}}

                    <div class="mb-3 row">
                        <label for="harga_per_kubik" class="col-md-2 col-form-label">Kepala Puskesmas</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nama" id="name" value="{{ $datas->nama }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga_per_kubik" class="col-md-2 col-form-label">NIP</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nip" id="name" value="{{ $datas->nip }}">
                        </div>
                    </div>
{{-- 
                    <div class="mb-3 row">
                        <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="alamat" >{{$datas->alamat}}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="no_telepon" class="col-md-2 col-form-label">Nomor Telepon</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="no_telepon" >{{$datas->no_telepon}}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" name="email" id="email" value="{{ $datas->email }}">
                        </div>
                    </div> --}}

                    <div class="mb-3 row">
                        <label for="password" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                        </div>
                    </div>
                    @role("Pihak Wajib Pajak|Operator")
                    @role("Pihak Wajib Pajak")
                    {{-- <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">npa</label>
                        <div class="col-md-10">
                            <select class="form-select" name="kategori" disabled>
                                <option>-- Pilih Kategori NPA --</option>
                                @foreach ($npas as $npa)
                                    <option value="{{ $npa->id }}" @if($npa->id == $datas->pelanggan->kategori_industri_id) selected @endif>{{ $npa->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    @endrole

                    <div class="mb-3 row">
                        <label class=" col-md-2 form-label">Tanda Tangan</label>
                        <div class="col-md-10"><input type="file" name="file" class="filestyle form-control"></div>
                    </div>
                    @endrole
                    <div class="mb-3 row">
                        <div class="col-md-11">
                            
                        </div>
                        <div class="col-md-1">
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                        
                    </div>

                                            
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    @push('scripts')
        <script>
            // setInputFilter(document.getElementById("nik"), function(value) {
            //     return /^-?\d*$/.test(value) && (value === "" || value.length <= 16); 
            // });
        </script>
    @endpush


</div>
@endsection