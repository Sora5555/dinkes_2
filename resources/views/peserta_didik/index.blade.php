@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.includes.sticky-table')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Peserta Didik</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Peserta Didik</li>
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
                        <div class="col-md-10 d-flex justify-content-start gap-3">
                            @if(Auth::user()->downloadFile('PesertaDidik', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PesertaDidik" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('PesertaDidik', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('PesertaDidik', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="PesertaDidik" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('PesertaDidik', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('PesertaDidik', Session::get('year'))->file_path.Auth::user()->downloadFile('PesertaDidik', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('PesertaDidik.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('PesertaDidik.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="2">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="2">Desa</th>
                                @endrole
                                <th colspan="3">Kelas 1 SD/MI</th>
                                <th colspan="3">Kelas 7 SMP/MTS</th>
                                <th colspan="3">Kelas 10 SMA/MA</th>
                                <th colspan="3">Usia Pendidikan Dasar (Kelas 1 - 9)</th>
                                <th colspan="3">SD/MI</th>
                                <th colspan="3">SMP/MTS</th>
                                <th colspan="3">SMA/MA</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="3">Lock Upload</th>
                                <th rowspan="3" >File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                                <th>jumlah Peserta Didik</th>
                                <th>Mendapat Pelayanan</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_1"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_1"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_1"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_1"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_1"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_7"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_7"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_7"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_7"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_7"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_10"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_10"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_10"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_kelas_10"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_kelas_10"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_usia_dasar"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_usia_dasar"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_usia_dasar"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_usia_dasar"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_usia_dasar"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sd"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sd"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sd"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sd"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sd"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_smp"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_smp"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_smp"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_smp"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_smp"] * 100, 2):0}}</td>
                                    
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sma"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sma"]}}</td>
                                    <td>{{$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sma"] > 0?number_format($item->peserta_didik_per_desa(Session::get('year'))["pelayanan_sma"]/$item->peserta_didik_per_desa(Session::get('year'))["jumlah_sma"] * 100, 2):0}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->peserta_didik_lock_get(Session::get('year')) == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('PesertaDidik', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('PesertaDidik', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('PesertaDidik', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('PesertaDidik', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('PesertaDidik', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('PesertaDidik', Session::get('year'))->file_path.$item->user->downloadFile('PesertaDidik', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td style="white-space: nowrap"><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td>
                                  </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{$total_kelas_1}}</td>
                                    <td>{{$total_pelayanan_kelas_1}}</td>
                                    <td>{{$total_pelayanan_kelas_1 > 0?number_format($total_pelayanan_kelas_1/$total_kelas_1 * 100, 2):0}}</td>
                                    
                                    <td>{{$total_kelas_7}}</td>
                                    <td>{{$total_pelayanan_kelas_7}}</td>
                                    <td>{{$total_pelayanan_kelas_7 > 0?number_format($total_pelayanan_kelas_7/$total_kelas_7 * 100, 2):0}}</td>
                                    
                                    <td>{{$total_kelas_10}}</td>
                                    <td>{{$total_pelayanan_kelas_10}}</td>
                                    <td>{{$total_pelayanan_kelas_10 > 0?number_format($total_pelayanan_kelas_10/$total_kelas_10 * 100, 2):0}}</td>
                                    
                                    <td>{{$total_usia_dasar}}</td>
                                    <td>{{$total_pelayanan_usia_dasar}}</td>
                                    <td>{{$total_pelayanan_usia_dasar > 0?number_format($total_pelayanan_usia_dasar/$total_usia_dasar * 100, 2):0}}</td>
                                    
                                    <td>{{$total_sd}}</td>
                                    <td>{{$total_pelayanan_sd}}</td>
                                    <td>{{$total_pelayanan_sd > 0?number_format($total_pelayanan_sd/$total_sd * 100, 2):0}}</td>
                                    
                                    <td>{{$total_smp}}</td>
                                    <td>{{$total_pelayanan_smp}}</td>
                                    <td>{{$total_pelayanan_smp > 0?number_format($total_pelayanan_smp/$total_smp * 100, 2):0}}</td>
                                    
                                    <td>{{$total_sma}}</td>
                                    <td>{{$total_pelayanan_sma}}</td>
                                    <td>{{$total_pelayanan_sma > 0?number_format($total_pelayanan_sma/$total_sma * 100, 2):0}}</td>
                                    <td></td>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterPesertaDidik(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_kelas_1" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_kelas_1" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kelas_1{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_kelas_7" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_kelas_7" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kelas_7{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_kelas_10" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_kelas_10" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kelas_10{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10 > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10/($item->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_usia_dasar" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_usia_dasar" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar}}" class="form-control data-input" style="border: none"></td>
                                    <td id="usia_dasar{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar/($item->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_sd" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sd}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_sd" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_sd}}" class="form-control data-input" style="border: none"></td>
                                    <td id="sd{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sd > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_sd/($item->filterPesertaDidik(Session::get('year'))->jumlah_sd)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_smp" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_smp" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_smp}}" class="form-control data-input" style="border: none"></td>
                                    <td id="smp{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_smp/($item->filterPesertaDidik(Session::get('year'))->jumlah_smp)*100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="jumlah_sma" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->jumlah_sma}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" {{$item->filterPesertaDidik(Session::get('year'))->status == 1?"disabled":""}} name="pelayanan_sma" id="{{$item->filterPesertaDidik(Session::get('year'))->id}}" value="{{$item->filterPesertaDidik(Session::get('year'))->pelayanan_sma}}" class="form-control data-input" style="border: none"></td>
                                    <td id="sma{{$item->filterPesertaDidik(Session::get('year'))->id}}">{{$item->filterPesertaDidik(Session::get('year'))->jumlah_smp > 0?number_format($item->filterPesertaDidik(Session::get('year'))->pelayanan_smp/($item->filterPesertaDidik(Session::get('year'))->jumlah_smp)*100, 2):0}}%</td>

                                                                        

                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                <td></td>
                                <td></td>
                                    <td id="jumlah_kelas_1">{{$total_kelas_1}}</td>
                                    <td id="pelayanan_kelas_1">{{$total_pelayanan_kelas_1}}</td>
                                    <td id="percentage_kelas_1">{{$total_kelas_1 > 0?number_format($total_pelayanan_kelas_1/$total_kelas_1 * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_kelas_7">{{$total_kelas_7}}</td>
                                    <td id="pelayanan_kelas_7">{{$total_pelayanan_kelas_7}}</td>
                                    <td id="percentage_kelas_7">{{$total_kelas_7 > 0?number_format($total_pelayanan_kelas_7/$total_kelas_7 * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_kelas_10">{{$total_kelas_10}}</td>
                                    <td id="pelayanan_kelas_10">{{$total_pelayanan_kelas_10}}</td>
                                    <td id="percentage_kelas_10">{{$total_kelas_10 > 0?number_format($total_pelayanan_kelas_10/$total_kelas_10 * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_usia_dasar">{{$total_usia_dasar}}</td>
                                    <td id="pelayanan_usia_dasar">{{$total_pelayanan_usia_dasar}}</td>
                                    <td id="percentage_usia_dasar">{{$total_usia_dasar > 0?number_format($total_pelayanan_usia_dasar/$total_usia_dasar * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_sd">{{$total_sd}}</td>
                                    <td id="pelayanan_sd">{{$total_pelayanan_sd}}</td>
                                    <td id="percentage_sd">{{$total_sd > 0?number_format($total_pelayanan_sd/$total_sd * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_smp">{{$total_smp}}</td>
                                    <td id="pelayanan_smp">{{$total_pelayanan_smp}}</td>
                                    <td id="percentage_smp">{{$total_smp > 0?number_format($total_pelayanan_smp/$total_smp * 100, 2):0}}</td>
                                    
                                    <td id="jumlah_sma">{{$total_sma}}</td>
                                    <td id="pelayanan_sma">{{$total_pelayanan_sma}}</td>
                                    <td id="percentage_sma">{{$total_sma > 0?number_format($total_pelayanan_sma/$total_sma * 100, 2):0}}</td>
                                    <td></td>
                                </tr>
                                @endrole
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
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let id = $(this).attr('id');
        let persen_kelas_1 = $(this).parent().parent().find(`#kelas_1${id}`);
        let persen_kelas_7 = $(this).parent().parent().find(`#kelas_7${id}`);
        let persen_kelas_10 = $(this).parent().parent().find(`#kelas_10${id}`);
        let persen_usia_dasar = $(this).parent().parent().find(`#usia_dasar${id}`);
        let persen_sd = $(this).parent().parent().find(`#sd${id}`);
        let persen_smp = $(this).parent().parent().find(`#smp${id}`);
        let persen_sma = $(this).parent().parent().find(`#sma${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("peserta_didik.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                console.log(res);
                // balita_kia.text(`${res.persen_balita_kia}%`);
                // balita_dipantau.text(`${res.persen_balita_dipantau}%`);
                // balita_sdidtk.text(`${res.persen_balita_sdidtk}%`);
                // balita_mtbs.text(`${res.persen_balita_mtbs}%`);
                persen_kelas_1.text(`${res.persen_kelas_1}%`);
                persen_kelas_7.text(`${res.persen_kelas_7}%`);
                persen_kelas_10.text(`${res.persen_kelas_10}%`);
                persen_usia_dasar.text(`${res.persen_usia_dasar}%`);
                persen_sd.text(`${res.persen_sd}%`);
                persen_smp.text(`${res.persen_smp}%`);
                persen_sma.text(`${res.persen_sma}%`);
                // lahir_hidup_mati_LP.text(`${res.lahir_hidup_mati_LP}%`);
                // kf_lengkap.text(`${res.kf_lengkap}%`);
                // vita.text(`${res.vita}%`);
                let total_column = res.column;
                $(`#${total_column}`).text(res.total);
                $(`#percentage_${res.percentage_column}`).text(`${res.percentage}%`);
			}
		});
        console.log(name, value, id);
        })
        $('#data').on('click', '.detail', function(){
            let id = $(this).attr('id');
            let $clickedRow = $(this).closest('tr'); // Get the clicked row element
            if ($clickedRow.next().hasClass('detail-row')) {

        $clickedRow.nextAll('.detail-row').remove();
            } else {
                 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'GET',
			'url'	: `/general/detail_desa/${id}`,
			'data'	: {'id': id, 'mainFilter': 'filterPesertaDidik'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
                        <td></td>
                        <td>${item.nama}</td>
                                    <td>${item.jumlah_kelas_1}</td>
                                    <td>${item.pelayanan_kelas_1}</td>
                                    <td>${item.jumlah_kelas_1 > 0?(item.pelayanan_kelas_1/item.jumlah_kelas_1) * 100:0}%</td>
                                    
                                    <td>${item.jumlah_kelas_7}</td>
                                    <td>${item.pelayanan_kelas_7}</td>
                                    <td id="">${item.jumlah_kelas_7 > 0?(item.pelayanan_kelas_7/item.jumlah_kelas_7) * 100:0}%</td>
                                    
                                    <td>${item.jumlah_kelas_10}</td>
                                    <td>${item.pelayanan_kelas_10}</td>
                                    <td id="">${item.jumlah_kelas_10 > 0?(item.pelayanan_kelas_10/item.jumlah_kelas_10) * 100:0}%</td>
                                    
                                    <td>${item.jumlah_usia_dasar}</td>
                                    <td>${item.pelayanan_usia_dasar}</td>
                                    <td id="">${item.jumlah_usia_dasar > 0?(item.pelayanan_usia_dasar/item.jumlah_usia_dasar) * 100:0}%</td>
                                    
                                    <td>${item.jumlah_sd}</td>
                                    <td>${item.pelayanan_sd}</td>
                                    <td id="">${item.jumlah_sd > 0?(item.pelayanan_sd/item.jumlah_sd) * 100:0}%</td>
                                   
                                    <td>${item.jumlah_smp}</td>
                                    <td>${item.pelayanan_smp}</td>
                                    <td id="">${item.jumlah_smp > 0?(item.pelayanan_smp/item.jumlah_smp) * 100:0}%</td>
                                    
                                    <td>${item.jumlah_sma}</td>
                                    <td>${item.pelayanan_sma}</td>
                                    <td id="">${item.jumlah_sma > 0?(item.pelayanan_sma/item.jumlah_sma) * 100:0}%</td>
                                    
                                    

                                    <td></td>
                        
                    </tr>
                `;
                $clickedRow.after(newRow); // Insert the new row after the clicked row
                $clickedRow = $clickedRow.next(); // Move reference to the new row for subsequent inserts
            });
			}
		}); 
            }
            console.log(id);
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
            window.location.href = "/peserta_didik?year="+year;


        })
        $("#kegiatan_id").change(function(){
            table.draw()
        })
        $('.btn-tambah-program').click(function(){
            if($('#induk_opd').val() == ""){
                alert("Pilih SKPD Terlebih dahulu")
            } else {
                let valueOpd = $('#induk_opd').val();
                let stringOpd = valueOpd.toString();
                let kegiatan_id = $("#kegiatan_id").val();


                $.ajax({
                    type: "get",
                    url: `{{url('api/jabatan')}}/${valueOpd}`,
                    success: (res) => {
                        if(res.status == 'success'){
                            let template = `
                {!! Form::open(['route'=>$route.'.store','method'=>'POST', 'id'=>'storeForm']) !!}
            <div class="mb-3 row">
                <input type="hidden" name="kegiatan_id" value="${kegiatan_id}">
                <label for="name" class="col-md-2 col-form-label">Uraian</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::text('uraian',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-md-2 col-form-label">Kode</label>
            </div>
            <div class="mb-3 row">
                <div class="col-md-10">
                    {!! Form::number('kode',null,['class'=>'form-control','id'=>"nama"]) !!}
                </div>
            </div>     
                `
                $('.modal-body').html(template)
                $('#submitButton').attr('form', 'storeForm')
                $('#title').html('Tambah Data Sub Kegiatan');
                $('.modal').modal('toggle');
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
			'url'	: '{{ route("PesertaDidik.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("PesertaDidik.lock") }}',
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
        $('#data').on('click', '.data-lock-upload', function(){
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
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "PesertaDidik"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "PesertaDidik"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection