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

                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                    <form action="{{ route($route.'.store') }}" method='POST'>
                        @csrf
                    {{-- <div class="mb-3 row">
                        <label for="example-text-input" class="col-md-2 col-form-label">ID Pelanggan</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="id_pelanggan" id="example-text-input">
                        </div>
                    </div> --}}
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Nama</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="email" name="email" id="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="name" class="col-md-2 col-form-label">Confirm Password</label>
                        <div class="col-md-10">
                            <input class="form-control" type="password" name="password_confirmation" id="confirm">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="no_telepon" class="col-md-2 col-form-label">No. Telepon</label>
                        <div class="col-md-10">
                            <input class="form-control" type="tel" name="no_telepon" id="no_telepon">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nik" class="col-md-2 col-form-label">NIK</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="nik" id="nik">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-md-2 col-form-label">Alamat</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="alamat" ></textarea>
                        </div>
                    </div>


                    <div class="mb-3 row">
                                <label for="nik" class="col-md-2 col-form-label">Pilih Kategori</label>
                        <div class="col-md-10">
                            <select class="form-control select2" name="kategori_industri" id="kategori_industri">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori_industris as $kategori_industri)
                                    <option value="{{ $kategori_industri->id }}">{{ $kategori_industri->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
            setInputFilter(document.getElementById("nik"), function(value) {
                return /^-?\d*$/.test(value) && (value === "" || value.length <= 16); 
            });
        </script>
    @endpush


</div>
@endsection