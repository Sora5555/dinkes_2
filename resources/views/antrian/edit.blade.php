@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Antrean</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Antrean</li>
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
                    {!! Form::model($data,['route'=>['antrian.update',$data->id],'method'=>'PUT','id'=>'myForm']) !!}
                        @csrf
                        @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <h2>Detail Tagihan</h2>
                            <table class="table tabel">
                                <tr>
                                    <th>Nama Perusahaan</th>
                                    <th>:</th>
                                    <th>{{$data->nama_perusahaan}}</th>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <th>:</th>
                                    <th>{{$data->email}}</th>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <th>:</th>
                                    <th>{{$data->no_telp}}</th>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <th>{{$data->alamat}}</th>
                                </tr>
                                <tr>
                                    <th>mulai mengunakan dan / memanfaatkan air permukaan</th>
                                    <th>:</th>
                                    <th>{{$data->date}}</th>
                                </tr>
                                <tr>
                                    <th>Daerah</th>
                                    <th>:</th>
                                    <th>{{$daerah->nama_daerah??'-'}}</th>
                                </tr>
                                <tr>
                                    <th>Alasan</th>
                                    <th>:</th>
                                    <th>{{$data->alasan??'-'}}</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>
                                    <label for="">Kategori</label>
                                    <select name="kategori[]" id="kategori" class="form-control kategori">
                                        @foreach ($kategori as $kategoris)
                                            <option value="{{$kategoris->id}}">{{$kategoris->kategori}}</option>
                                        @endforeach    
                                    </select>
                                    </th>
                                    <th>
                                        <label for="">Lokasi</label>
                                        <input type="text" name="lokasi[]" id="lokasi" class="form-control"></th>
                                    <th>
                                        <label for="" style="opacity:0">Y</label>
                                        <button type="button" class="btn btn-success tambah">Tambah</button>
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-11">
                                
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Setujui</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function(){
            $('.select2').select2();
        });

        // $('.kategori').select2({
        //             placeholder:'pilih wilayah',
        //             multiple:true,
        //             width:'100%',
        //             allowClear:true,
        //         });
        // $('.kategori').val('').trigger('change');

        const add = document.querySelector('.tambah');
            add.addEventListener('click', (e) => {
                newrow = $(`
        <tr>
            <th></th>
                                    <th></th>
                                    <th>
                                    <label for="">Kategori</label>
                                    <select name="kategori[]" id="kategori" class="form-control kategori">
                                        @foreach ($kategori as $kategoris)
                                            <option value="{{$kategoris->id}}">{{$kategoris->kategori}}</option>
                                        @endforeach    
                                    </select>
                                    </th>
                                    <th>
                                        <label for="">Lokasi</label>
                                        <input type="text" name="lokasi[]" id="lokasi" class="form-control"></th>
                                    <th>
                                        <label for="" style="opacity:0">D</label>
                                        <button type="button" class="btn btn-danger tambah" onclick="deleteRow(this)">hapus!</button>
                                    </th>
                                </tr>
		`);
                // const tr = document.querySelector('.tabel');

                $(newrow).appendTo(".tabel");
            })
            function deleteRow(row){
                row.parentElement.parentElement.remove();
            }

        </script>

    @endpush