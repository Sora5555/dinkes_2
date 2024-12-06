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

                    {!! Form::model($UnitOrganisasi,['route'=>[$route.'.update',$UnitOrganisasi->id],'method'=>'PUT']) !!}
                        @csrf
                    
                    
                        @include($route.'.form')
                    <div class="mb-3 row">
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