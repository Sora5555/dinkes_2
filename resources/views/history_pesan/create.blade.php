@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tambah {{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pesan Whatsapp</a></li>
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
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Nomor Telepon</label>
                        <div class="col-md-10">
                            <select class="form-select pelanggan" name="pelanggan[]" multiple="multiple">
                                @foreach ($upt_daerahs as $upt_daerah)
                                <optgroup label="{{$upt_daerah->nama_daerah}}">
                                    @foreach($pelanggans as $pelanggan)
                                        @if($pelanggan->daerah_id == $upt_daerah->id)
                                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->no_telepon }} - {{$pelanggan->name}} ({{ $pelanggan->no_pelanggan }})</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Template Pesan</label>
                        <div class="col-md-10">
                            <select class="form-select select2" name="template_pesan">
                                <option>-- Pilih Template Pesan --</option>
                                @foreach ($pesans as $pesan)
                                    <option value="{{ $pesan->id }}">{{ $pesan->nama_pesan }}</option>
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

</div>
@push('scripts')
<script>
       $('.pelanggan').select2({
            multiple:true,
            width:'100%',
            allowClear:true,
        });
</script>
    
@endpush
@endsection