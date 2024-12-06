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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
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
                    <div class="row justify-content-start mb-2">
                            {{-- {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                            <select name="program_id" form="storeForm" id="program_id" class="form-control">
                                <option value="">Pilih Program</option>
                            </select>
                            <select name="kegiatan_id" form="storeForm" id="kegiatan_id" class="form-control">
                                <option value="">Pilih Kegiatan</option>
                            </select>
                            --}}
                            <form action="{{ route('import_sasaran_ibu_hamil') }}" method="post" class="col-md-12 d-flex justify-content-around gap-3" enctype="multipart/form-data">
                            @csrf
                            <select name="tahun" id="tahun" class="form-control w-50">
                                <option value="2024" {{app('request')->input('year') == 2024 ? "selected":""}}>2024</option>
                                <option value="2023" {{app('request')->input('year') == 2023 ? "selected":""}}>2023</option>
                            </select> 
                            {{-- <select name="month" id="month" class="form-control w-50">
                                <option value="1" {{app('request')->input('month') == 1 ? "selected":""}}>Januari</option>
                                <option value="2" {{app('request')->input('month') == 2 ? "selected":""}}>Februari</option>
                                <option value="3" {{app('request')->input('month') == 3 ? "selected":""}}>Maret</option>
                            </select>  --}}
                            @role("Admin")
                                <input type="file" name="excel_file" class="form-control">
                                <button type="submit" class="btn btn-success">Import</button>
                            @endrole
                                <button type="button" class="btn btn-primary" id="filter">Filter</button>
                            </form>
                        {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="3">No</th>
                                <th rowspan="3">Desa</th>
                                <th rowspan="3">Sasaran Tahunan Ibu Hamil</th>
                                <th colspan="36">Pelayanan Ibu Hamil Sesuai Standar</th>
                            </tr>
                            <tr>
                               <th colspan="3">Januari</th>
                               <th colspan="3">Februari</th>
                               <th colspan="3">Maret</th>
                               <th colspan="3">April</th>
                               <th colspan="3">Mei</th>
                               <th colspan="3">Juni</th>
                               <th colspan="3">Juli</th>
                               <th colspan="3">Agustus</th>
                               <th colspan="3">September</th>
                               <th colspan="3">Oktober</th>
                               <th colspan="3">November</th>
                               <th colspan="3">Desember</th>
                            </tr>
                            <tr>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                                <th>sasaran</th>
                                <th>capaian</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($desa as $key => $item)
                                @if($item->filterSasaranTahunDesa(app('request')->input('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_jumlah_ibu_hamil}}</td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 1)
                                            
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="januari" bulan="sasaran_januari" class="btn btn-success col-md-10 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="januari" bulan="sasaran_januari" class="btn btn-danger col-md-10 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari:0}}</td>
                                    <td id="capaian_januari{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari*100, 2)}}%
                                        @else
                                        0
                                    @endif

                                    </td>

                                    {{-- februari --}}
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 1)
                                            
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="februari" bulan="sasaran_februari" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="februari" bulan="sasaran_februari" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari:0}}</td>
                                    <td id="capaian_februari{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari*100, 2)}}%
                                        @else
                                        0
                                    @endif

                                    </td>

                                    {{-- maret --}}
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 1)
                                            
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="maret" bulan="sasaran_maret" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="maret" bulan="sasaran_maret" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret:0}}</td>
                                    <td id="capaian_maret{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- april --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="april" bulan="sasaran_april" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="april" bulan="sasaran_april" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april:0}}</td>
                                    <td id="capaian_april{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- mei --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="mei" bulan="sasaran_mei" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="mei" bulan="sasaran_mei" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei:0}}</td>
                                    <td id="capaian_mei{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- Juni --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="juni" bulan="sasaran_juni" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="juni" bulan="sasaran_juni" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni:0}}</td>
                                    <td id="capaian_juni{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- juli --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="juli" bulan="sasaran_juli" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="juli" bulan="sasaran_juli" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli:0}}</td>
                                    <td id="capaian_juli{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- agustus --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="agustus" bulan="sasaran_agustus" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="agustus" bulan="sasaran_agustus" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus:0}}</td>
                                    <td id="capaian_agustus{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- september --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="september" bulan="sasaran_september" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="september" bulan="sasaran_september" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september:0}}</td>
                                    <td id="capaian_september{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- oktober --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="oktober" bulan="sasaran_oktober" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="oktober" bulan="sasaran_oktober" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober:0}}</td>
                                    <td id="capaian_oktober{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- november --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="november" bulan="sasaran_november" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="november" bulan="sasaran_november" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november:0}}</td>
                                    <td id="capaian_november{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                    {{-- desember --}}
                                    <td style="white-space: nowrap">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 3 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 2)    
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember:0}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 1)
                                        <div class=" w-100 d-flex flex-column justify-content-center align-items-center text-center">
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember:0}}
                                                <div class="w-100" style="margin-inline: auto">
                                                    <button nama_bulan="desember" bulan="sasaran_desember" class="btn btn-success col-md-5 btn-acc" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-check"></i></button>
                                                    <button nama_bulan="desember" bulan="sasaran_desember" class="btn btn-danger col-md-5 btn-reject" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-alpha-x"></i></button>
                                                </div>
                                        </div>
                                        @endif
                                    </td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember:0}}</td>
                                    <td id="capaian_desember{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>

                                </tr>
                                  @endif
                                @endforeach
                                @endrole
                                @role("Puskesmas")
                                @foreach ($desa as $key => $item)
                                @if($item->filterSasaranTahunDesa(app('request')->input('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_jumlah_ibu_hamil}}</td>
                                    @if($current_month == 1)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 0)
                                        <button nama_bulan="januari" bulan="sasaran_januari" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 2)
                                        <button nama_bulan="januari" bulan="sasaran_januari" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 3)
                                        <input type="number" nama_bulan="januari" bulan="sasaran_januari" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari}}" name="capaian_januari" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 0)
                                            <input type="text" disabled nama_bulan="januari" bulan="sasaran_januari" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 2)
                                            <input type="text" disabled nama_bulan="januari" bulan="sasaran_januari" class="form-control" class="form-control" value="silahkan ajukan sasaran baru" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @endif

                                    </td>
                                    <td id="capaian_januari{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_januari == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari*100, 2)}}%
                                        @else
                                        0
                                    @endif

                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_januari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_januari*100, 2):0}}</td>
                                    @endif
                                    {{-- februari --}}
                                    @if($current_month == 2)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 0)
                                        <button nama_bulan="februari" bulan="sasaran_februari" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 2)
                                        <button nama_bulan="februari" bulan="sasaran_februari" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 3)
                                        <input type="number" nama_bulan="februari" bulan="sasaran_februari" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari}}" name="capaian_februari" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 1 )
                                            <input type="text" disabled nama_bulan="februari" bulan="sasaran_februari" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 2)
                                            <input type="text" disabled nama_bulan="februari" bulan="sasaran_februari" class="form-control" class="form-control" value="silahkan ajukan sasaran baru" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @endif

                                    </td>
                                    <td id="capaian_februari{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_februari == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_februari/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_februari*100, 2):0}}</td>
                                    @endif
                                    {{-- maret --}}
                                    @if($current_month == 3)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 0)
                                        <button nama_bulan="maret" bulan="sasaran_maret" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 2)
                                        <button nama_bulan="maret" bulan="sasaran_maret" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 3)
                                        <input type="number" nama_bulan="maret" bulan="sasaran_maret" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret}}" name="capaian_maret" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_maret{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_maret == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_maret/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_maret*100, 2):0}}</td>
                                    @endif

                                    {{-- april --}}
                                    @if($current_month == 4)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 0)
                                        <button nama_bulan="april" bulan="sasaran_april" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 2)
                                        <button nama_bulan="april" bulan="sasaran_april" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 3)
                                        <input type="number" nama_bulan="april" bulan="sasaran_april" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april}}" name="capaian_april" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_april{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_april == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_april/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_april*100, 2):0}}</td>
                                    @endif

                                    {{-- mei --}}
                                    @if($current_month == 5)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 0)
                                        <button nama_bulan="mei" bulan="sasaran_mei" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 2)
                                        <button nama_bulan="mei" bulan="sasaran_mei" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 3)
                                        <input type="number" nama_bulan="mei" bulan="sasaran_mei" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei}}" name="capaian_mei" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_mei{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_mei == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_mei/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_mei*100, 2):0}}</td>
                                    @endif

                                    {{-- juni --}}
                                    @if($current_month == 6)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 0)
                                        <button nama_bulan="juni" bulan="sasaran_juni" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 2)
                                        <button nama_bulan="juni" bulan="sasaran_juni" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 3)
                                        <input type="number" nama_bulan="juni" bulan="sasaran_juni" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni}}" name="capaian_juni" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_juni{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juni == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juni/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juni*100, 2):0}}</td>
                                    @endif

                                    {{-- juli --}}
                                    @if($current_month == 7)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 0)
                                        <button nama_bulan="juli" bulan="sasaran_juli" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 2)
                                        <button nama_bulan="juli" bulan="sasaran_juli" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 3)
                                        <input type="number" nama_bulan="juli" bulan="sasaran_juli" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli}}" name="capaian_juli" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_juli{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_juli == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_juli/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_juli*100, 2):0}}</td>
                                    @endif

                                    {{-- agustus --}}
                                    @if($current_month == 8)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 0)
                                        <button nama_bulan="agustus" bulan="sasaran_agustus" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 2)
                                        <button nama_bulan="agustus" bulan="sasaran_agustus" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 3)
                                        <input type="number" nama_bulan="agustus" bulan="sasaran_agustus" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus}}" name="capaian_agustus" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_agustus{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_agustus == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_agustus/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_agustus*100, 2):0}}</td>
                                    @endif

                                    {{-- september --}}
                                    @if($current_month == 9)
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 3)
                                            {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september}}
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 0)
                                        <button nama_bulan="september" bulan="sasaran_september" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 2)
                                        <button nama_bulan="september" bulan="sasaran_september" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                        @endif

                                    </td>
                                    <td>
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 3)
                                        <input type="number" nama_bulan="september" bulan="sasaran_september" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september}}" name="capaian_september" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 1 )
                                            <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                        @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 2)
                                            <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                        @endif

                                    </td>
                                    <td id="capaian_september{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                        @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_september == 3)
                                        {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september*100, 2)}}%
                                        @else
                                        0
                                    @endif
                                    </td>
                                    @else
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_september/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_september*100, 2):0}}</td>
                                    @endif

                                   {{-- oktober --}}
                                   @if($current_month == 10)
                                   <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 3)
                                        {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober}}
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 0)
                                    <button nama_bulan="oktober" bulan="sasaran_oktober" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 2)
                                    <button nama_bulan="oktober" bulan="sasaran_oktober" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                    @endif

                                </td>
                                <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 3)
                                    <input type="number" nama_bulan="oktober" bulan="sasaran_oktober" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober}}" name="capaian_oktober" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 1 )
                                        <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 2)
                                        <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                    @endif

                                </td>
                                <td id="capaian_oktober{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_oktober == 3)
                                    {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober*100, 2)}}%
                                    @else
                                    0
                                @endif
                                </td>
                                @else
                                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_oktober/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_oktober*100, 2):0}}</td>
                                @endif
                                {{-- november --}}
                                @if($current_month == 11)
                                <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 3)
                                        {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november}}
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 0)
                                    <button nama_bulan="november" bulan="sasaran_november" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 2)
                                    <button nama_bulan="november" bulan="sasaran_november" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                    @endif

                                </td>
                                <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 3)
                                    <input type="number" nama_bulan="november" bulan="sasaran_november" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november}}" name="capaian_november" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 1 )
                                        <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 2)
                                        <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                    @endif

                                </td>
                                <td id="capaian_november{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_november == 3)
                                    {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november*100, 2)}}%
                                    @else
                                    0
                                @endif
                                </td>
                                @else
                                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november}}</td>
                                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november}}</td>
                                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_november/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_november*100, 2):0}}</td>
                                @endif

                                {{-- desember --}}
                                @if($current_month == 12)
                                <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 1 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 3)
                                        {{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember}}
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 0)
                                    <button nama_bulan="desember" bulan="sasaran_desember" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i> Tambah</button>
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 2)
                                    <button nama_bulan="desember" bulan="sasaran_desember" class="btn btn-warning col-md-12 btn-tambah-program" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}"><i class="mdi mdi-plus"></i>Silahkan edit Sasaran kembali</button>
                                    @endif

                                </td>
                                <td>
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 3)
                                    <input type="number" nama_bulan="desember" bulan="sasaran_desember" class="form-control data-input" value="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember}}" name="capaian_desember" id="{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 0 || $item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 1 )
                                        <input disabled type="text" class="form-control" value="silahkan isi sasaran bulan ini terlebih dahulu">
                                    @elseif($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 2)
                                        <input disabled type="text" disabled class="form-control" class="form-control" value="silahkan ajukan sasaran baru">
                                    @endif

                                </td>
                                <td id="capaian_desember{{$item->filterSasaranTahunDesa(app('request')->input('year'))->id}}">
                                    @if($item->filterSasaranTahunDesa(app('request')->input('year'))->status_desember == 3)
                                    {{number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember*100, 2)}}%
                                    @else
                                    0
                                @endif
                                </td>
                                @else
                                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember}}</td>
                                    <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember>0?number_format($item->filterSasaranTahunDesa(app('request')->input('year'))->capaian_desember/$item->filterSasaranTahunDesa(app('request')->input('year'))->sasaran_desember*100, 2):0}}</td>
                                @endif

                                    @endif
                                    @endforeach
                                </tr>
                                @endrole
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


</div>

<div class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title">Tambah Program</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" value="Submit" class="btn btn-primary" id="submitButton" form="storeForm">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

@push('scripts')
    <!-- Required datatable js -->
    <script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

@endpush

@push('scripts')
    <script>
        var table = $('#datatable').DataTable({
            responsive:false,
            processing: true,
            serverSide: true,
            order: [[ 0, "asc" ]],
            ajax: {
                'url': '{{ route("datatable.sub_kegiatan") }}',
                'type': 'GET',
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRFToken", '{{ csrf_token() }}');
                },
                data: function (d) {
                    d.kegiatan_id = $('#kegiatan_id').val();
                },
            },
            columns: [
                {data:'kode',name:'kode'},
                {data:'nama',name:'nama'},
                {data:'sasaran',name:'sasaran'},
                {data: 'indikator', name:'indikator'}
            ],
        });

        $('#data').on('input', '.data-input', function(){
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
        var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let sasaran_id = $(this).attr('id');
        let name = $(this).attr('name');
        let nama_bulan = $(this).attr('nama_bulan'); 
        let bulan = $(this).attr('bulan'); 
        let parent = $(this).parent().parent();
        console.log($(this).length, $(this).parent().parent());       
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: `{{url('apiCapaian/sasaran_ibu_hamil')}}/${sasaran_id}`,
			'data'	: {'name' : name, 'value' : value, 'id': sasaran_id, 'bulan':bulan},
			success	: function(res){
                console.log()
                parent.find(`#${res.name}${sasaran_id}`).text(`${res.percent}%`);
			}
		});
        
        })
        $('#induk_opd').change(function(){
            let valueOpd = $("#induk_opd").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiProgram/kegiatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Program</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#program_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });
        $('#program_id').change(function(){
            let program_id = $("#program_id").val()
            $.ajax({
                    type: "get",
                    url: `{{url('apiKegiatan/sub_kegiatan')}}/${program_id}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        let option = `<option value="">Pilih Kegiatan</option>`;

                        for(const key in res.data){
                            option += `<option value="${res.data[key].id}">${res.data[key].kode} - ${res.data[key].uraian}</option>`
                        }
                        $("#kegiatan_id").html(option)

                        } else {
                            alert(res.data);
                        }
                    }
                })
        });
        $("#filter").click(function(){
            let year = $("#tahun").val();
            let month = $("#month").val();
            window.location.href = "/sasaran_ibu_hamil?year="+year+"&month="+month;


        })
        $("#kegiatan_id").change(function(){
            table.draw()
        })
        $('.btn-tambah-program').click(function(){
            let sasaran_id = $(this).attr('id');
            let bulan = $(this).attr('bulan');
            let nama_bulan = $(this).attr('nama_bulan');
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {

                $.ajax({
                    type: "get",
                    url: `{{url('api/sasaran_ibu_hamil')}}/${sasaran_id}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            console.log(res, bulan, res[bulan]);
                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="sasaran_id" value="${sasaran_id}">
                <input type="hidden" name="bulan_capaian" value="sasaran_${nama_bulan}">
                <input type="hidden" name="status" value="status_${nama_bulan}">
                <label for="name" class="col-md-2 col-form-label">Sasaran</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    <input type="text" name="nilai_capaian" class="form-control" value="${res.data[bulan]}">
                </div>
            </div>
                `
                $('.modal-body').html(template)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sasaran');
                $('.modal').modal('toggle');
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
        $('.btn-acc').click(function(){
            let sasaran_id = $(this).attr('id');
            let bulan = $(this).attr('bulan');
            let nama_bulan = $(this).attr('nama_bulan');
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {

                $.ajax({
                    type: "GET",
                    url: `{{url('apiAcc/sasaran_ibu_hamil')}}/${sasaran_id}`,
                    data: {'bulan' : bulan, 'nama_bulan' : nama_bulan, 'id': sasaran_id},
                    success: (res) => {
                        if(res.status == 'success'){
                            $(this).parent().attr('hidden', 'hidden');
                            alert("sasaran telah di acc")
                            console.log(res, bulan, res[bulan]);
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });
        $('.btn-reject').click(function(){
            let sasaran_id = $(this).attr('id');
            let bulan = $(this).attr('bulan');
            let nama_bulan = $(this).attr('nama_bulan');
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {

                $.ajax({
                    type: "GET",
                    url: `{{url('apiReject/sasaran_ibu_hamil')}}/${sasaran_id}`,
                    data: {'bulan' : bulan, 'nama_bulan' : nama_bulan, 'id': sasaran_id},
                    success: (res) => {
                        if(res.status == 'success'){
                            $(this).parent().attr('hidden', 'hidden');
                            alert("sasaran telah di tolak")
                            console.log(res, bulan, res[bulan]);
                        } else {
                            alert(res.data);
                        }
                    }
                })

            }
    });

    
        $('#data').on('click', '.data-lock', function(){
            let id = $(this).attr('id');
            let year = $("#tahun").val();
            $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
            if($(this).is(':checked')){
            $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IbuHamil.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("IbuHamil.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    $('#data').on('click', '.btn-mod2', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/IbuHamil')}}/${id}`,
                success: (res) => {
                    console.log(res)
                    if(res.status == "success"){
                            console.log(res.data)
                            let textUraian = `<input type="text" name="k1" id="nama" class="form-control" value="${res.IbuHamil.k1}">`
                            let textKode = `<input type="text" name="k4" class="form-control" id="bezetting" value="${res.IbuHamil.k4}">`
                            let textPosyanduPurnama = `<input type="text" name="k6" class="form-control" id="bezetting" value="${res.IbuHamil.k6}">`
                            let textPosyanduMandiri = `<input type="text" name="fasyankes" class="form-control" id="bezetting" value="${res.IbuHamil.fasyankes}">`
                            let textPosyanduAktif = `<input type="text" name="kf1" class="form-control" id="bezetting" value="${res.IbuHamil.kf1}">`
                            let textPosbindu = `<input type="text" name="kf_lengkap" class="form-control" id="bezetting" value="${res.IbuHamil.kf_lengkap}">`
                            let textVita = `<input type="text" name="vita" class="form-control" id="bezetting" value="${res.IbuHamil.vita}">`


                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K1</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K4</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="bezettingField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">K6</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="purnamaField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Persalinan di Fasyankes</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="mandiriField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kf1</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="aktifField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">KF Lengkap</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="posbinduField">
                </div>
            </div>     
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Ibu Bersalin Yang diberi Vitamin A</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="vitaField">
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#bezettingField').html(textKode);
                $('#purnamaField').html(textPosyanduPurnama);
                $('#mandiriField').html(textPosyanduMandiri);
                $('#aktifField').html(textPosyanduAktif);
                $('#posbinduField').html(textPosbindu);
                $('#vitaField').html(textVita);
                $('#EditForm').attr('action', `/IbuHamil/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Program');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
    $('#datatable').on('click', '.btn-tambah-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/program')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textUraian = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'sasaran_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sub_kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textUraian)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sasaran');

                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-sasaran', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaran_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'sasaranKegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/sasaran_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Sasaran Kegiatan');
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-tambah-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/sasaranProgram')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control">`
                            let template = `
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'storeForm']) !!}
                <input type="hidden" name="sasaran_sub_kegiatan_id" value="${id}">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Nama</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div>  
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#title').html('Tambah Data Indikator');
                $('#submitButton').attr('form', 'storeForm')
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
        $('#datatable').on('click', '.btn-edit-indikator', function(){
            let id = $(this).attr('id');

            $.ajax({
                type: "get",
                url: `{{url('apiEdit/indikator_sub_kegiatan')}}/${id}`,
                success: (res) => {
                    if(res.status == "success"){

                            let textNama = `<input type="text" name="nama" id="nama" class="form-control" value="${res.data.nama}">`
                            let template = `
                {!! Form::open(['route'=>'indikator_sub_kegiatan.store','method'=>'POST', 'id'=>'EditForm']) !!}
                <input name="_method" type="hidden" value="PUT">
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10" id="nama_field">
                </div>
            </div> 
                `
                $('.modal-body').html(template)
                $('#nama_field').html(textNama)
                $('#EditForm').attr('action', `/indikator_sub_kegiatan/${id}`)
                $('#submitButton').attr('form', 'EditForm')
                $('#title').html('Ubah data Indikator Sub Kegiatan');
                $('.modal').modal('toggle');
                    } else {
                        alert("Ada Yang salah saat pengambilan data");
                    }
                }
            })

        })
    </script>
@endpush
@endsection