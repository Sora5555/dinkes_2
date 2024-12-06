@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.includes.sticky-table')


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
                        <div class="col-md-10 d-flex justify-content-around gap-3">
                            @if(Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="ObatTuberkulosis" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="ObatTuberkulosis" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('ObatTuberkulosis', Session::get('year')) && Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year'))->file_path.Auth::user()->downloadFile('ObatTuberkulosis', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('ObatTuberkulosis.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('ObatTuberkulosis.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th colspan="3" rowspan="2" style="white-space: nowrap">JUMLAH KASUS TUBERKULOSIS PARU TERKONFIRMASI BAKTERIOLOGIS YANG DITEMUKAN DAN DIOBATI*</th>
                                <th colspan="3" rowspan="2" style="white-space: nowrap">JUMLAH SEMUA KASUS TUBERKULOSIS YANG DITEMUKAN DAN DIOBATI</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA KESEMBUHAN (CURE RATE) TUBERKULOSIS PARU TERKONFIRMASI BAKTERIOLOGIS</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA PENGOBATAN LENGKAP (COMPLETE RATE) SEMUA KASUS TUBERKULOSIS</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA KEBERHASILAN PENGOBATAN (SUCCESS RATE/SR) SEMUA KASUS TUBERKULOSIS</th>
                                <th colspan="2" rowspan="2" style="white-space: nowrap">JUMLAH KEMATIAN SELAMA PENGOBATAN TUBERKULOSIS</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Lock data</th>
                                <th rowspan="3">Lock upload</th>
                                <th rowspan="3">File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kesembuhan_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'konfirmasi_P')["total"]) * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'lengkap_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'berhasil_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
                                        ):0}}</td>

                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kematian')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'kematian')["total"]
                                    /($item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', Session::get('year'), 'diobati_P')["total"]) * 100, 2
                                    ):0}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterObatTuberkulosis') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('ObatTuberkulosis', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('ObatTuberkulosis', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('ObatTuberkulosis', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('ObatTuberkulosis', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('ObatTuberkulosis', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('ObatTuberkulosis', Session::get('year'))->file_path.$item->user->downloadFile('ObatTuberkulosis', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterObatTuberkulosis(Session::get('year')))
                                @php
                                    $filterResult = $item->filterObatTuberkulosis(Session::get('year'));
                                    $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td><input type="number" {{$isDisabled}} name="konfirmasi_L" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="konfirmasi_P" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="konfirmasi{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="diobati_L" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" {{$isDisabled}} name="diobati_P" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="diobati{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L}}</td>

                                    <td><input type="number" {{$isDisabled}} name="kesembuhan_L" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kesembuhan_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L
                                        /$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="kesembuhan_P" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kesembuhan_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P
                                        /$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P * 100, 2):0}}</td>
                                    
                                    <td id="kesembuhan_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P + $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L}}</td>

                                    <td id="persen_kesembuhan_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L>0?
                                        number_format(($item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_P + $item->filterObatTuberkulosis(Session::get('year'))->kesembuhan_L)
                                        /($item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_L + $item->filterObatTuberkulosis(Session::get('year'))->konfirmasi_P) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="lengkap_L" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="lengkap_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->lengkap_L
                                        /$item->filterObatTuberkulosis(Session::get('year'))->diobati_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="lengkap_P" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="lengkap_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->lengkap_P
                                        /$item->filterObatTuberkulosis(Session::get('year'))->diobati_P * 100, 2):0}}</td>
                                    
                                    <td id="lengkap_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->lengkap_P + $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L}}</td>

                                    <td id="persen_lengkap_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
                                        number_format(($item->filterObatTuberkulosis(Session::get('year'))->lengkap_P + $item->filterObatTuberkulosis(Session::get('year'))->lengkap_L)
                                        /($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100, 2):0}}</td>
                                   
                                   <td><input type="number" {{$isDisabled}} name="berhasil_L" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="berhasil_L{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->berhasil_L
                                        /$item->filterObatTuberkulosis(Session::get('year'))->diobati_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="berhasil_P" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="berhasil_P{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P>0?
                                        number_format($item->filterObatTuberkulosis(Session::get('year'))->berhasil_P
                                        /$item->filterObatTuberkulosis(Session::get('year'))->diobati_P * 100, 2):0}}</td>
                                    
                                    <td id="berhasil_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->berhasil_P + $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L}}</td>

                                    <td id="persen_berhasil_LP{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
                                        number_format(($item->filterObatTuberkulosis(Session::get('year'))->berhasil_P + $item->filterObatTuberkulosis(Session::get('year'))->berhasil_L)
                                        /($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100, 2):0}}</td>

                                    <td><input type="number" {{$isDisabled}} name="kematian" id="{{$item->filterObatTuberkulosis(Session::get('year'))->id}}" value="{{$item->filterObatTuberkulosis(Session::get('year'))->kematian}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kematian{{$item->filterObatTuberkulosis(Session::get('year'))->id}}">{{$item->filterObatTuberkulosis(Session::get('year'))->diobati_P + $item->filterObatTuberkulosis(Session::get('year'))->diobati_L>0?
                                    number_format($item->filterObatTuberkulosis(Session::get('year'))->kematian
                                    /($item->filterObatTuberkulosis(Session::get('year'))->diobati_L + $item->filterObatTuberkulosis(Session::get('year'))->diobati_P) * 100, 2):0}}</td>
                                </tr>
                                  @endif
                                @endforeach
                                @endrole
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


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

        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');

        let konfirmasi = $(this).parent().parent().find(`#konfirmasi${id}`);
        let diobati = $(this).parent().parent().find(`#diobati${id}`);
        let kesembuhan_L = $(this).parent().parent().find(`#kesembuhan_L${id}`);
        let kesembuhan_P = $(this).parent().parent().find(`#kesembuhan_P${id}`);
        let kesembuhan_LP = $(this).parent().parent().find(`#kesembuhan_LP${id}`);
        let persen_kesembuhan_LP = $(this).parent().parent().find(`#persen_kesembuhan_LP${id}`);
        let persen_layanan_LP = $(this).parent().parent().find(`#persen_layanan_LP${id}`);
        let lengkap_L = $(this).parent().parent().find(`#lengkap_L${id}`);
        let lengkap_P = $(this).parent().parent().find(`#lengkap_P${id}`);
        let lengkap_LP = $(this).parent().parent().find(`#lengkap_LP${id}`);
        let persen_lengkap_LP = $(this).parent().parent().find(`#persen_lengkap_LP${id}`);
        let berhasil_L = $(this).parent().parent().find(`#berhasil_L${id}`);
        let berhasil_P = $(this).parent().parent().find(`#berhasil_P${id}`);
        let berhasil_LP = $(this).parent().parent().find(`#berhasil_LP${id}`);
        let persen_berhasil_LP = $(this).parent().parent().find(`#persen_berhasil_LP${id}`);
        let kematian = $(this).parent().parent().find(`#kematian${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("ObatTuberkulosis.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                konfirmasi.text(`${res.konfirmasi}`);
                diobati.text(`${res.diobati}`);
                kesembuhan_L.text(`${res.kesembuhan_L}`);
                kesembuhan_P.text(`${res.kesembuhan_P}`);
                kesembuhan_LP.text(`${res.kesembuhan_LP}`);
                persen_kesembuhan_LP.text(`${res.persen_kesembuhan_LP}`);
                lengkap_L.text(`${res.lengkap_L}`);
                lengkap_P.text(`${res.lengkap_P}`);
                lengkap_LP.text(`${res.lengkap_LP}`);
                persen_lengkap_LP.text(`${res.persen_lengkap_LP}`);
                berhasil_L.text(`${res.berhasil_L}`);
                berhasil_P.text(`${res.berhasil_P}`);
                berhasil_LP.text(`${res.berhasil_LP}`);
                persen_berhasil_LP.text(`${res.persen_berhasil_LP}`);
                kematian.text(`${res.kematian}`);
			}
		});
        console.log(name, value, id);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/JumlahKematianIbu?year="+year;


        })
        $('#data').on('click', '.detail', function(){
            console.log("A");
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
			'data'	: {'id': id, 'mainFilter': 'filterObatTuberkulosis'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    console.log(item);
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.konfirmasi_L}</td>
             <td>${item.konfirmasi_P}</td>
             <td>${item.konfirmasi_L + item.konfirmasi_P}%</td>
             <td>${item.diobati_L}</td>
             <td>${item.diobati_P}</td>
             <td>${item.diobati_P + item.diobati_L}</td>

             <td>${item.kesembuhan_L}</td>
             <td>${item.konfirmasi_L>0?(item.kesembuhan_L/item.konfirmasi_L) * 100:0}%</td>
             <td>${item.kesembuhan_P}</td>
             <td>${item.konfirmasi_P>0?(item.kesembuhan_P/item.konfirmasi_P) * 100:0}%</td>
             <td>${item.kesembuhan_P + item.kesembuhan_L}</td>
             <td>${item.konfirmasi_P + item.konfirmasi_L>0?((item.kesembuhan_P + item.kesembuhan_L)/(item.konfirmasi_P + item.konfirmasi_L)) * 100:0}%</td>
             
             <td>${item.lengkap_L}</td>
             <td>${item.diobati_L>0?(item.lengkap_L/item.diobati_L) * 100:0}%</td>
             <td>${item.lengkap_P}</td>
             <td>${item.diobati_P>0?(item.lengkap_P/item.diobati_P) * 100:0}%</td>
             <td>${item.lengkap_P + item.lengkap_L}</td>
             <td>${item.diobati_P + item.diobati_L>0?((item.lengkap_P + item.lengkap_L)/(item.diobati_P + item.diobati_L)) * 100:0}%</td>
             
             <td>${item.berhasil_L}</td>
             <td>${item.diobati_L>0?(item.berhasil_L/item.diobati_L) * 100:0}%</td>
             <td>${item.berhasil_P}</td>
             <td>${item.diobati_P>0?(item.berhasil_P/item.diobati_P) * 100:0}%</td>
             <td>${item.berhasil_P + item.berhasil_L}</td>
             <td>${item.diobati_P + item.diobati_L>0?((item.berhasil_P + item.berhasil_L)/(item.diobati_P + item.diobati_L)) * 100:0}%</td>

              <td>${item.kematian}</td>
             <td>${item.diobati_L + item.diobati_P>0?(item.kematian/(item.diobati_L + item.diobati_P)) * 100:0}%</td>
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
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterObatTuberkulosis'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterObatTuberkulosis'},
			success	: function(res){
				console.log(res);
			}
		});
            }
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "ObatTuberkulosis"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "ObatTuberkulosis"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection