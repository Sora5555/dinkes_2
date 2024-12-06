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
                    <form action="{{ route($route.'.bukti', $datas->id) }}" method='POST' id="myForm" name="myForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-6">
                            {{-- <div class="row">
                                    <label for="example-text-input" class="col-md-4 col-form-label">No Tagihan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="no_tagihan" id="example-text-input">
                                </div>
                            </div> --}}
                           {{--  <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">ID Perusahaan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <select class="form-control select2" name="id_pelanggan" id="id_pelanggan">
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach ($pelanggans as $pelanggan)
                                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->id_pelanggan }} - {{ $pelanggan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            

                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Bulan</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            {{-- <input class="form-control" type="text" name="id_pelanggan" id="example-text-input"> --}}
                                            {{-- <select class="form-control" name="bulan" id="bulan">
                                                @foreach ($dates as $date)
                                                    <option value="{{ $loop->index + 1 }}" @if ( ($loop->index + 1) == date('n')) selected @endif>{{ $date }}</option>
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
                                            <select class="form-control" name="tahun" id="tahun">
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}" @if(date('Y') == $year) selected @endif>{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Tanggal Pelaporan</label>
                                    </div>
                                    <div class="mb-3 row">

                                        <div class="col-md-10">
                                            {!! Form::text('tanggal_p',date('Y-m-d'),['class'=>'form-control','id'=>'tanggal_p','disabled'=>'disabled']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Pengguna Meteran?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="row">
                                        <div class="form-check mb-2 col" style="margin-left: .7rem;">
                                            <input class="form-check-input" type="radio" name="meteran" id="meteran" value="1" checked>
                                            <label class="form-check-label" for="meteran">
                                                Pakai
                                            </label>
                                        </div>
                                        <div class="form-check col">
                                            <input class="form-check-input" type="radio" name="meteran" id="meteran1" value="0">
                                            <label class="form-check-label" for="meteran1">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Meter Bulan Sebelumnya (M<sup>3</sup>)</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="meter_sebelumnya" id="meter_sebelumnya" min="0" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label">Meter Sekarang (M<sup>3</sup>)</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="meter_sekarang" id="meter_sekarang" min="0" value="0">
                                </div>
                            </div>

                            <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Pemakaian (M<sup>3</sup>)</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-10">
                                    <input class="form-control" type="number" name="pemakaian" id="pemakaian"  readonly>
                                </div>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label">Bukti Pembayaran(Maksimal 5000 KB dengan Format .jpg/.png)</label>
                                <input type="file" name="file" class="filestyle" required>
                            </div>
                            {{-- <div class="row">
                                <label for="example-text-input" class="col-md-4 col-form-label" >Jumlah Tagihan</label>
                            </div>
                            <div class="mb-3 row">
                                
                                <div class="col-md-12">
                                    <p><h2>Rp. <span id="jumlah_tagihan">0</span></h2></p>
                                </div>
                            </div> --}}
                            
                            <div class="mb-3 row">
                                <div class="col-md-11">
                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                
                            </div>  
                        </div>
                        {{-- @if(Auth::user()->name != 'Admin')
                        <div class="col-md-6">
                            <h2><i class="mdi mdi-user"></i> Detail Pengguna</h2>
                            <br>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th>Nama Perusahaan</th>
                                        <th>:</th>
                                        <th>{{$pelanggans->name}}</th>
                                    </tr>
                                    <tr>
                                        <th>Daerah</th>
                                        <th>:</th>
                                        <th>{{$pelanggans->daerah->nama_daerah??'-'}}</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>:</th>
                                        <th>{{$pelanggans->alamat}}</th>
                                    </tr>
                                    <tr>
                                        <th>Kategori NPA</th>
                                        <th>:</th>
                                        <th>{{@$pelanggans->pelanggan->kategori_npa->kategori}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div> --}}
                    

                    
                                            
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