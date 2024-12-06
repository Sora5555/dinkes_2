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
                        <li class="breadcrumb-item active">import</li>
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
                    <form action="{{ route($route.'.make') }}" method='POST' id="myForm" name="myForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Import data penggunaan(Format .xlsx)</label>
                                <input type="file" name="file" class="filestyle">
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-11">
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Import</button>
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
{{-- 
@push('scripts')
<script src="{{asset('assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
    <script>
        let p;
        let pt;
        $(document).ready(function(){
            $('.select2').select2();
        });

        //get radio value
        let radio = document.myForm.meteran;
        let radio_value = 1;
        var prev = null;
        for (var i = 0; i < radio.length; i++) {
            radio[i].addEventListener('change', function() {
                if (this !== prev) {
                    prev = this;
                }else if(prev){
                    console.log(prev.value);
                }
                

                if(this.value == 1){
                    radio_value = 1;
                    document.getElementById('meter_sebelumnya').readOnly = false;
                    document.getElementById('meter_sekarang').readOnly = false;
                    document.getElementById('pemakaian').readOnly = true;
                }else if(this.value == 0){
                    radio_value = 0;
                    document.getElementById('meter_sebelumnya').readOnly = true;
                    document.getElementById('meter_sekarang').readOnly = true;
                    document.getElementById('pemakaian').readOnly = false;
                }

                console.log(radio_value);
            });
        }

        function getPemakaian(){
            p = document.querySelector('#meter_sekarang').value - document.querySelector('#meter_sebelumnya').value;

            document.querySelector('#pemakaian').value = p;

            pt = p * 11500;

            // getTagihan(pt);
        }

        // function getTagihan(value = 0){
        //     const p = document.querySelector('#jumlah_tagihan');
        //     p.innerText = value;
        // }

        // $('#id_pelanggan').on('select2:close', function (e){
        //     postData('{{ route("pelanggan.data") }}','POST', {
        //         _token: csrfToken ,
        //         id: $('#id_pelanggan').val() 
        //     })
        //     .then(data => {
        //         console.log(data); // JSON data parsed by `data.json()` call
        //         document.querySelector('#nama').value= data.name;
        //         document.querySelector('#no_telepon').value = data.no_telepon;
        //         document.querySelector('#alamat').value = data.alamat;
        //         document.querySelector('#meter_sebelumnya').value = data.meter_sebelumnya;
        //         getPemakaian();
        //     });
        // });

        
        // function formSubmit(){
        //     return false;
        // }

        const meter = document.querySelector('#meter_sekarang');

        const meter_sebelumnya = document.querySelector('#meter_sebelumnya')

        meter.addEventListener('keyup', (event) => {
            getPemakaian();
        });

        meter_sebelumnya.addEventListener('keyup', (event) => {
            getPemakaian();
        });

        const form = document.getElementById('myForm');

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            let meter_sebelumnya = parseInt(document.querySelector('#meter_sebelumnya').value);
            let meter_sekarang = parseInt(document.querySelector('#meter_sekarang').value);
            let pemakaian = parseInt(document.querySelector('#pemakaian').value);
            if(radio_value == 1){
                if(meter_sekarang < meter_sebelumnya){
                    alert('error');
                }else if(meter_sekarang > meter_sebelumnya){
                    form.submit();
                }
            }else if(radio_value == 0){
                if(pemakaian > 0){
                    form.submit();
                }else if(pemakaian <= 0){
                    
                    alert('error');
                }
            }
            console.log(radio_value);
        });
    </script>
@endpush --}}

@endsection