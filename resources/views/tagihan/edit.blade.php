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
                    {!! Form::model($tagihan,['route'=>[$route.'.update',$tagihan->id],'method'=>'PUT','onsubmit'=>'','id'=>'myForm','files'=>true]) !!}
                       @include('tagihan.form')
                       <div class="mb-3 row">
                            <div class="col-md-11"></div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>      
                    {!! Form::close() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>

@push('scripts')
<script src="{{asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
    <script>
        let p;
        let pt;
        $(document).ready(function(){
            $('.select2').select2();

            // setInterval(getDatas, 3000);
            // getDatas();
        });

        function getPemakaian(){
            p = $('#meter_sekarang').val() - $('#meter_sebelumnya').val();

            $('#pemakaian').val(p);

            pt = p * 11500;

            // getTagihan(pt);
        }

        // function getTagihan(value = 0){
        //     const p = document.querySelector('#jumlah_tagihan');
        //     p.innerText = value;
        // }

        // $('#id_pelanggan').on('select2:close', function (e){
        //     getDatas();
        // });

        // function getDatas(){
        //     postData('{{ route("pelanggan.data") }}','POST', { _token: csrfToken ,id: $('#id_pelanggan').val(), edit:  })
        //     .then(data => {
        //         console.log(data); // JSON data parsed by `data.json()` call
        //         $('#nama').val(data.name);
        //         $('#no_telepon').val(data.no_telepon);
        //         $('#alamat').val(data.alamat);
        //         $('#meter_sebelumnya').val(data.meter_sebelumnya);
        //         getPemakaian();
        //     });
        // }

        // function formSubmit(){
        //     return false;
        // }

        $('.form-check-input').change(function(){
            value = $(this).val();
            if (value == 1) {
                $('#meter_sebelumnya').prop("readonly",false);
                $('#meter_sekarang').prop("readonly",false);
                $('#pemakaian').prop("readonly",true);
            }else{
                $('#meter_sebelumnya').prop("readonly",true);
                $('#meter_sekarang').prop("readonly",true);
                $('#pemakaian').prop("readonly",false);
            }
        });

        $('#pemakaian').keyup(function(){
            $('#meter_sebelumnya').val(0);
            $('#meter_sekarang').val(0);
        });

        $(document).ready(function(){
            if ($('#meter_sebelumnya').val() == 0) {
                $('#meter_sebelumnya').prop('readonly',true);
            }
            if ($('#meter_sekarang').val() == 0) {
                $('#meter_sekarang').prop('readonly',true);
            }
            if ($('#meter_sebelumnya').val() == 0 && $('#meter_sekarang').val() == 0) {
                $('#pemakaian').prop('readonly',false);
            }
        });

        const meter = document.querySelector('#meter_sekarang');

        meter.addEventListener('keyup', (event) => {
            getPemakaian();
        });

        meter.addEventListener('click', (event) => {
            getPemakaian();
        });

        // const form = document.getElementById('myForm');

        // form.addEventListener('submit', (event) => {
        //     event.preventDefault();
        //     let meter_sebelumnya = parseInt(document.querySelector('#meter_sebelumnya').value);
        //     let meter_sekarang = parseInt(document.querySelector('#meter_sekarang').value);
        //     if(meter_sekarang < meter_sebelumnya){
        //         console.log(document.querySelector('#meter_sebelumnya').value);
        //         console.log(document.querySelector('#meter_sekarang').value);
        //         console.log(pt);
        //         alert('error');
        //     }else if(meter_sekarang > meter_sebelumnya){
        //         form.submit();
        //     }
        // });

        

    </script>
@endpush

@endsection