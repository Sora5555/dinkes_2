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
                    <form action="{{ route($route.'.store') }}" method='POST' id="myForm" name="myForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row"><label for="kategori">Kategori</label></div>
                                    <div class="mb-3 row">
                                        <div class="col-md-8">
                                            <input type="hidden" name="kategori" value="{{$sektor}}">
                                            <input type="text" value="{{$nama_sektor}}" placeholder="a" class="form-control" name="name" id="cat" disabled>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Dari</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="id_pelanggan" id="example-text-input">
                                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control tanggal_awal" value="{{$present->format('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Sampai</label>
                                    </div>
                                    <div class="mb-3 row">
                                        
                                        <div class="col-md-8">
                                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control tanggal_akhir" value="{{$present->format('Y-m-d')}}">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Tanggal Pelaporan</label>
                                    </div>
                                    <div class="mb-3 row">

                                        <div class="col-md-10">
                                            {!! Form::text('tanggal_p',date('Y-m-d'),['class'=>'form-control','id'=>'tanggal_p','readonly'=>'readonly']) !!}
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
                            <div class="inputs">
                                <div class="input-wrapper">
                                    <div class="row">
                                        {{-- <h4>Pemakaian Periode {{$present->format('F-Y')}}</h4> --}}
                                        <div style="width:15%"><label for="meter_sebelumnya" class=" col-form-label">Meter Bulan Sebelumnya (M<sup>3</sup>)</label></div>
                                        <div style="width:15%"><label for="meter_sekarang" class="col-form-label">Meter Sekarang (M<sup>3</sup>)</label></div>
                                        <div style="width:15%"><label for="pemakaian" class="col-form-label" >Pemakaian (M<sup>3</sup>)</label></div>
                                        <div style="width:20%"><label for="file" class="col-form-label" >File (format .png atau .pdf maks 2 MB)</label></div>
                                        <div style="width:20%"><label for="date" class="col-form-label">Periode</label></div>
                                    </div>
                                    <div class="mb-3 row">
                                    
                                        <div class="" style="width:15%">
                                            <input class="form-control meter_sebelumnya" type="number" name="meter_sebelumnya[]" onkeyup="getPemakaian(this)" id="meter_sebelumnya" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                        </div>
                                        <div class="" style="width:15%">
                                            <input class="form-control meter_sekarang" type="number" name="meter_sekarang[]" onkeyup="getPemakaian(this)" id="meter_sekarang" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                        </div>
                                        <div class="" style="width:15%">
                                            <input class="form-control pemakaian" type="number" name="pemakaian[]" id="pemakaian" readonly>
                                        </div>
                                        <div class="" style="width:20%"><input type="file" name="file[]" class="form-control" id="file"></div>
                                        <div class="" style="width:20%"><input type="date" name="periode[]" id="periode" class="form-control periode" required id="date"></div>
                                        <div style="width:5%"><button type="button" class="btn btn-success tambah">Tambah</button></div>
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
                        @if(Auth::user()->name != 'Admin')
                        <div class="col-md-6 py-5">
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
                                        <th>Wilayah</th>
                                        <th>:</th>
                                        <th>{{$pelanggans->daerah->nama_daerah??'-'}}</th>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>:</th>
                                        <th>{{$pelanggans->alamat}}</th>
                                    </tr>
                                    {{-- <tr>
                                        <th>Klasifikasi</th>
                                        <th>:</th>
                                        <th>{{@$pelanggans->pelanggan->kategori_npa->kategori}}</th>
                                    </tr> --}}
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    

                    
                                            
                    </form>
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
                    
                    const counter = document.getElementsByClassName('meter_sebelumnya');
                    for (let i = 0; i < counter.length; i++){
                       counter[i].readOnly = false;
                       document.getElementsByClassName('meter_sekarang')[i].readOnly = false;
                       document.getElementsByClassName('pemakaian')[i].readOnly = true;
                    }
                }else if(this.value == 0){
                    radio_value = 0;
                    const counter = document.getElementsByClassName('meter_sebelumnya');
                    for(let i = 0; i < counter.length; i++){
                        counter[i].readOnly = true;
                        document.getElementsByClassName('meter_sekarang')[i].readOnly = true;
                        counter[i].value = 0;
                        document.getElementsByClassName('meter_sekarang')[i].value = 0;
                        document.getElementsByClassName('pemakaian')[i].readOnly = false;
                    }
                }

                console.log(radio_value, document.getElementsByClassName('meter_sebelumnya')[0]);
            });
        }

        function getPemakaian(el){
            let x = el.getAttribute("data-queu");
            p = el.parentElement.parentElement.querySelector("input[name='meter_sekarang[]']").value - el.parentElement.parentElement.querySelector("input[name='meter_sebelumnya[]']").value;

            el.parentElement.parentElement.querySelector("input[name='pemakaian[]']").value = p;

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

        // const meter = document.querySelector('#meter_sekarang');
        // const awal = document.querySelector(".tanggal_awal");
        // const akhir = document.querySelector(".tanggal_akhir");

        // awal.addEventListener('change', (e) => {
        //     const input = document.querySelector(".inputs");
        //     const nilai_awal = e.target.value;
        //     const nilai_akhir = document.querySelector(".tanggal_akhir").value;
        //     let dateAwal = new Date(nilai_awal);
        //     let dateAkhir = new Date(nilai_akhir);
        //     let yearAwal = dateAwal.getFullYear();
        //     let yearAkhir = dateAkhir.getFullYear();
        //     let monthAwal = dateAwal.getMonth();
        //     let monthAkhir = dateAkhir.getMonth();

        //     if(monthAwal === 0){
        //         monthAkhir++;
        //         monthAwal++;
        //     }
        //     let numberOfMonths;
        //     input.replaceChildren();
        //     if(monthAwal > monthAkhir && (yearAkhir === yearAwal || yearAwal > yearAkhir)){
        //        numberOfMonths = 0;
        //        const newrow = $(`<h5>Bulan Awal tidak bisa lebih besar dari bulan akhir</h5>`)
        //        $(".inputs").append(newrow);
        //     } else {
        //         numberOfMonths = (yearAkhir - yearAwal) * 12 + (monthAkhir - monthAwal) + 1;
        //     }
        //     for(let i = 0; i < numberOfMonths; i++){
        //         let dateAwal = new Date(nilai_awal);
        //         dateAwal.setMonth(dateAwal.getMonth() + i );
        //         let newrow;
        //         console.log(dateAwal.getMonth())
        //         if(dateAwal.getMonth() == new Date().getMonth() || dateAwal.getMonth() > new Date().getMonth() && new Date().getMonth() == 11){
        //             newrow = $(`<h5 class="my-4">Anda belum bisa melaporkan penggunaan untuk bulan ${dateAwal.toLocaleString('default', {month: 'long'})}-${dateAwal.getFullYear()}</h5>`)
        //         } else {
        //             newrow = $(`
        //         <div class="row">
        //             <h4>Pemakaian Periode ${dateAwal.toLocaleString('default', {month: 'long'})}-${dateAwal.getFullYear()}</h4>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label">Meter Bulan Sebelumnya (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="meter_sekarang" class="col-md-4 col-form-label">Meter Sekarang (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >Pemakaian (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >File</label></div>
        //         </div>
        //         <div class="mb-3 row">               
        //             <div class="col-md-3">
        //                 <input class="form-control meter_sebelumnya" type="number" name="meter_sebelumnya[${i}]" id="meter_sebelumnya" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="${i}">
        //             </div>
        //             <div class="col-md-3">
        //                  <input class="form-control meter_sekarang" type="number" name="meter_sekarang[${i}]" id="meter_sekarang" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="${i}">
        //             </div>
        //             <div class="col-md-3">
        //                 <input class="form-control pemakaian" type="number" name="pemakaian[${i}]" id="pemakaian" readonly>
        //             </div>
        //             <div class="col-md-3"><input type="file" name="file[${i}]" class="form-control"></div>
        //         </div>
		// `);
        //         }
        // $(".inputs").append(newrow);
        //     }
        // })
        // akhir.addEventListener('change', (e) => {
        //     const input = document.querySelector(".inputs");
        //     const nilai_akhir = e.target.value;
        //     const nilai_awal = document.querySelector(".tanggal_awal").value;
        //     let dateAwal = new Date(nilai_awal);
        //     let dateAkhir = new Date(nilai_akhir);
        //     let yearAwal = dateAwal.getFullYear();
        //     let yearAkhir = dateAkhir.getFullYear();
        //     let monthAwal = dateAwal.getMonth();
        //     let monthAkhir = dateAkhir.getMonth();

        //     if(monthAwal === 0){
        //         monthAkhir++;
        //         monthAwal++;
        //     }
        //     let numberOfMonths;
        //     input.replaceChildren();
        //     if(monthAwal > monthAkhir && (yearAkhir === yearAwal || yearAwal > yearAkhir)){
        //        numberOfMonths = 0;
        //        const newrow = $(`<h5>Bulan Awal tidak bisa lebih besar dari bulan akhir</h5>`)
        //        $(".inputs").append(newrow);
        //     } else {
        //         numberOfMonths = (yearAkhir - yearAwal) * 12 + (monthAkhir - monthAwal) + 1;
        //     }
        //     for(let i = 0; i < numberOfMonths; i++){
        //         let dateAwal = new Date(nilai_awal);
        //         dateAwal.setMonth(dateAwal.getMonth() + i );
        //         let newrow;
        //         if(dateAwal.getMonth() == new Date().getMonth() || dateAwal.getMonth() > new Date().getMonth() && new Date().getMonth() == 11){
        //             newrow = $(`<h5 class="my-4">Anda belum bisa melaporkan penggunaan untuk bulan ${dateAwal.toLocaleString('default', {month: 'long'})}-${dateAwal.getFullYear()}</h5>`)
        //         } else {
        //             newrow = $(`
        //         <div class="row">
        //             <h4>Pemakaian Periode ${dateAwal.toLocaleString('default', {month: 'long'})}-${dateAwal.getFullYear()}</h4>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label">Meter Bulan Sebelumnya (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="meter_sekarang" class="col-md-4 col-form-label">Meter Sekarang (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >Pemakaian (M<sup>3</sup>)</label></div>
        //             <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label" >File</label></div>
        //         </div>
        //         <div class="mb-3 row">               
        //             <div class="col-md-3">
        //                 <input class="form-control meter_sebelumnya" type="number" name="meter_sebelumnya[${i}]" id="meter_sebelumnya" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="${i}">
        //             </div>
        //             <div class="col-md-3">
        //                  <input class="form-control meter_sekarang" type="number" name="meter_sekarang[${i}]" id="meter_sekarang" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="${i}">
        //             </div>
        //             <div class="col-md-3">
        //                 <input class="form-control pemakaian" type="number" name="pemakaian[${i}]" id="pemakaian" readonly>
        //             </div>
        //             <div class="col-md-3"><input type="file" name="file[${i}]" class="form-control"></div>
        //         </div>
		// `);
        //         }
        // $(".inputs").append(newrow);
        //     }
        // })

        const add = document.querySelector('.tambah');
            add.addEventListener('click', (e) => {
                newrow = $(`
                            <div class="input-wrapper">
                                <div class="row">
                                    {{-- <h4>Pemakaian Periode {{$present->format('F-Y')}}</h4> --}}
                                    <div style="width:15%"><label for="meter_sebelumnya" class=" col-form-label">Meter Bulan Sebelumnya (M<sup>3</sup>)</label></div>
                                    <div style="width:15%"><label for="meter_sekarang" class="col-form-label">Meter Sekarang (M<sup>3</sup>)</label></div>
                                    <div style="width:15%"><label for="pemakaian" class="col-form-label" >Pemakaian (M<sup>3</sup>)</label></div>
                                    <div style="width:20%"><label for="file" class="col-form-label" >File (format .png atau .pdf maks 2 MB)</label></div>
                                    <div style="width:20%"><label for="date" class="col-form-label">Periode</label></div>
                                </div>
                                <div class="row">
                                
                                    <div class="" style="width:15%">
                                        <input class="form-control meter_sebelumnya" type="number" name="meter_sebelumnya[]" onkeyup="getPemakaian(this)" id="meter_sebelumnya" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                    </div>
                                    <div class="" style="width:15%">
                                        <input class="form-control meter_sekarang" type="number" name="meter_sekarang[]" onkeyup="getPemakaian(this)" id="meter_sekarang" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                    </div>
                                    <div class="" style="width:15%">
                                        <input class="form-control pemakaian" type="number" name="pemakaian[]" id="pemakaian" readonly>
                                    </div>
                                    <div class="" style="width:20%"><input type="file" name="file[]" class="form-control" id="file"></div>
                                    <div class="" style="width:20%"><input type="date" name="periode[]" id="tanggal_akhir" class="form-control periode" required id="date"></div>
                                    <div style="width:5%"><button type="button" class="btn btn-danger hapus" onclick="deleteRow(this)">Hapus</button></div>
                                    </div>
                                </div>
		`);
                // const tr = document.querySelector('.tabel');

                $(newrow).appendTo(".inputs");
                console.log("a")
            })

            function deleteRow(row){
                row.parentElement.parentElement.parentElement.remove();
            }
        const meter_sebelumnya = document.querySelector('#meter_sebelumnya')

        // meter.addEventListener('keyup', (event) => {
        //     getPemakaian();
        // });

        // meter_sebelumnya.addEventListener('keyup', (event) => {
        //     getPemakaian();
        // });

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
                if(pemakaian >= 0){
                    form.submit();
                }else if(pemakaian < 0){
                    alert('error');
                }
            }
            console.log(radio_value);
        });
    </script>
@endpush

@endsection