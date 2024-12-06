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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Tambah {{$title}}</li>
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
                    {!! Form::open(['route'=>$route.'.store','method'=>'POST'])!!}
                        @include('target.form')
                        <div class="mb-3 row">
                            <div class="col-md-11">
                                
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Submit" class="btn btn-primary">
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

{{-- @push('scripts')

    <script type="text/javascript">
        $('.roles').change(function(){
            var role = $(this).val();
            if (role =='2') {
                $('.add-field').html($('#wp-component').html());
            }else if(role =='3'){
                $('.add-field').html($('#opr_content').html());
                $('.field_daerah').html('');
            }else{
                $('.add-field').html('');
            }
        });

        $('body').on('change','.kategori',function(){
            var kategori = $('.kategori option:selected');
            if (kategori.text() !== 'BUMN' && kategori.text() !== 'BUMD') {
                $('.field_daerah').html($('#field_daerah').html());
            }else{
                $('.field_daerah').html('');
            }
        });
    </script> --}}
    {{-- <script type="text/template" id="wp-component">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Kategori</label>
            <div class="col-md-10">
                {!! Form::select('kategori_industri_id',$kategori,null,['class'=>'form-control kategori','required'=>'required','placeholder'=>'pilih kategori']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">NIK</label>
            <div class="col-md-10">
                {!! Form::number('nik',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Alamat</label>
            <div class="col-md-10">
                {!! Form::text('alamat',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
    </script>

    <script type="text/template" id="field_daerah">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Daerah</label>
            <div class="col-md-10">
                {!! Form::select('daerah_id',$upt_daerah,null,['class'=>'form-control','required'=>'required','placeholder'=>'pilih daerah']) !!}
            </div>
        </div>
    </script>

    <script type="text/template" id="opr_content">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">NIK</label>
            <div class="col-md-10">
                {!! Form::number('nik',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Alamat</label>
            <div class="col-md-10">
                {!! Form::text('alamat',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Daerah</label>
            <div class="col-md-10">
                {!! Form::select('daerah_id',$upt_daerah,null,['class'=>'form-control','required'=>'required','placeholder'=>'pilih daerah']) !!}
            </div>
        </div>
    </script>
@endpush --}}