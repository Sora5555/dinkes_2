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
                            @if(Auth::user()->downloadFile('BalitaBcg', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="BalitaBcg" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('BalitaBcg', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('BalitaBcg', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="BalitaBcg" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('BalitaBcg', Session::get('year')) && Auth::user()->downloadFile('BalitaBcg', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('BalitaBcg', Session::get('year'))->file_path.Auth::user()->downloadFile('BalitaBcg', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('BalitaBcg.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('BalitaBcg.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="5">No</th>
                                <th rowspan="5">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="5">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="5">Desa</th>
                                @endrole
                                <th rowspan="4" colspan="3">Jumlah Lahir Hidup</th>
                                <th colspan="24">Bayi Diimunisasi</th>
                                @role('Admin|superadmin')
                                <th rowspan="5">Lock data</th>
                                <th rowspan="5">Lock upload</th>
                                <th rowspan="5">File Download</th>
                                <th rowspan="5">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="18">B0</th>
                                <th colspan="6" rowspan="2">BCG</th>
                            </tr>
                            <tr>
                                <th colspan="6">< 24 jam</th>
                                <th colspan="6">1-7 hari</th>
                                <th colspan="6">HB0 Total</th>
                            </tr>
                            <tr>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                                <th colspan="2">L</th>
                                <th colspan="2">P</th>
                                <th colspan="2">L+P</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
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
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"])
                                    /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"])
                                    /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"])
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"])
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'satu_minggu_L')["total"]) + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'duaempat_jam_L')["total"]
                                    /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                    ):0}}</td>

                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"]
                                    /$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] * 100, 2
                                    ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"] > 0?
                                    number_format(($item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_P')["total"] + $item->unitKerjaAmbil('filterBalitaBcg', Session::get('year'), 'bcg_L')["total"])
                                    /($item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_P')["total"] + $item->unitKerjaAmbil('filterKelahiran', Session::get('year'), 'lahir_hidup_L')["total"]) * 100, 2
                                    ):0}}</td>
                                    <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterBalitaBcg') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('BalitaBcg', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('BalitaBcg', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('BalitaBcg', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('BalitaBcg', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('BalitaBcg', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('BalitaBcg', Session::get('year'))->file_path.$item->user->downloadFile('BalitaBcg', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterBalitaBcg(Session::get('year')))
                                @php
                                $filterResult = $item->filterBalitaBcg(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="duaempat_jam_L" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="duaempat_jam_L{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="duaempat_jam_P" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="duaempat_jam_P{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="total_duaempat_jam{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L}}</td>
                                    <td id="persen_duaempat_jam{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L)
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="satu_minggu_L" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="satu_minggu_L{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->satu_minggu_L
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="satu_minggu_P" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="satu_minggu_P{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->satu_minggu_P
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="total_satu_minggu{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_P + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L}}</td>
                                    <td id="persen_satu_minggu{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->satu_minggu_P + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L)
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    <td id="total_L{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_L + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L}}</td>
                                    <td id="persen_L{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L )
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    
                                    <td id="total_P{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_P + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P}}</td>
                                    <td id="persen_P{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_P)
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2):0}}</td>
                                    
                                    <td id="total_LP{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->satu_minggu_P + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L}}</td>
                                    <td id="persen_LP{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->duaempat_jam_P + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_P + $item->filterBalitaBcg(Session::get('year'))->duaempat_jam_L + $item->filterBalitaBcg(Session::get('year'))->satu_minggu_L)
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="bcg_L" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->bcg_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="bcg_L{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->bcg_L
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" {{$isDisabled}} name="bcg_P" id="{{$item->filterBalitaBcg(Session::get('year'))->id}}" value="{{$item->filterBalitaBcg(Session::get('year'))->bcg_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="bcg_P{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P>0?
                                    number_format($item->filterBalitaBcg(Session::get('year'))->bcg_P
                                    /$item->filterKelahiran(Session::get('year'))->lahir_hidup_P * 100, 2):0}}</td>
                                    
                                    <td id="total_bcg{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterBalitaBcg(Session::get('year'))->bcg_P + $item->filterBalitaBcg(Session::get('year'))->bcg_L}}</td>
                                    <td id="persen_bcg{{$item->filterBalitaBcg(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L>0?
                                        number_format(($item->filterBalitaBcg(Session::get('year'))->bcg_P + $item->filterBalitaBcg(Session::get('year'))->bcg_L)
                                        /($item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>   
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
        let duaempat_jam_L = $(this).parent().parent().find(`#duaempat_jam_L${id}`);
        let duaempat_jam_P = $(this).parent().parent().find(`#duaempat_jam_P${id}`);
        let total_duaempat_jam = $(this).parent().parent().find(`#total_duaempat_jam${id}`);
        let persen_duaempat_jam = $(this).parent().parent().find(`#persen_duaempat_jam${id}`);
        let satu_minggu_L = $(this).parent().parent().find(`#satu_minggu_L${id}`);
        let satu_minggu_P = $(this).parent().parent().find(`#satu_minggu_P${id}`);
        let total_satu_minggu = $(this).parent().parent().find(`#total_satu_minggu${id}`);
        let persen_satu_minggu = $(this).parent().parent().find(`#persen_satu_minggu${id}`);
        let total_L = $(this).parent().parent().find(`#total_L${id}`);
        let persen_L = $(this).parent().parent().find(`#persen_L${id}`);
        let total_P = $(this).parent().parent().find(`#total_P${id}`);
        let persen_P = $(this).parent().parent().find(`#persen_P${id}`);
        let total_LP = $(this).parent().parent().find(`#total_LP${id}`);
        let persen_LP = $(this).parent().parent().find(`#persen_LP${id}`);
        let bcg_L = $(this).parent().parent().find(`#bcg_L${id}`);
        let bcg_P = $(this).parent().parent().find(`#bcg_P${id}`);
        let total_bcg = $(this).parent().parent().find(`#total_bcg${id}`);
        let persen_bcg = $(this).parent().parent().find(`#persen_bcg${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("BalitaBcg.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                duaempat_jam_L.text(`${res.duaempat_jam_L}`);
                duaempat_jam_P.text(`${res.duaempat_jam_P}`);
                total_duaempat_jam.text(`${res.total_duaempat_jam}`);
                persen_duaempat_jam.text(`${res.persen_duaempat_jam}`);
                
                satu_minggu_L.text(`${res.satu_minggu_L}`);
                satu_minggu_P.text(`${res.satu_minggu_P}`);
                total_satu_minggu.text(`${res.total_satu_minggu}`);
                persen_satu_minggu.text(`${res.persen_satu_minggu}`);
                
                total_L.text(`${res.total_L}`);
                total_P.text(`${res.total_P}`);
                persen_L.text(`${res.persen_L}`);
                persen_P.text(`${res.persen_P}`);
                total_LP.text(`${res.total_LP}`);
                persen_LP.text(`${res.persen_LP}`);

                bcg_L.text(`${res.bcg_L}`);
                bcg_P.text(`${res.bcg_P}`);
                total_bcg.text(`${res.total_bcg}`);
                persen_bcg.text(`${res.persen_bcg}`);
			}
		});
        console.log(name, value, id);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/JumlahKematianIbu?year="+year;


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
			'data'	: {'id': id, 'mainFilter': 'filterBalitaBcg', 'secondaryFilter': 'filterKelahiran'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.lahir_hidup_L}</td>
             <td>${item.lahir_hidup_P}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L}</td>
             <td>${item.duaempat_jam_L}</td>
             <td>${item.lahir_hidup_L>0?(item.duaempat_jam_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.duaempat_jam_P}</td>
             <td>${item.lahir_hidup_P>0?(item.duaempat_jam_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.duaempat_jam_L + item.duaempat_jam_P}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.duaempat_jam_L + item.duaempat_jam_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
            
             <td>${item.satu_minggu_L}</td>
             <td>${item.lahir_hidup_L>0?(item.satu_minggu_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.satu_minggu_P}</td>
             <td>${item.lahir_hidup_P>0?(item.satu_minggu_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.satu_minggu_L + item.satu_minggu_P}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.satu_minggu_L + item.satu_minggu_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
            
             <td>${item.satu_minggu_L + item.duaempat_jam_L}</td>
             <td>${item.lahir_hidup_L>0?((item.satu_minggu_L + item.duaempat_jam_L)/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.satu_minggu_P + item.duaempat_jam_P}</td>
             <td>${item.lahir_hidup_P>0?((item.satu_minggu_P + item.duaempat_jam_P)/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.satu_minggu_L + item.satu_minggu_P + item.duaempat_jam_L + item.duaempat_jam_P}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.satu_minggu_L + item.satu_minggu_P + item.duaempat_jam_L + item.duaempat_jam_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>

             <td>${item.bcg_L}</td>
             <td>${item.lahir_hidup_L>0?(item.bcg_L/item.lahir_hidup_L) * 100:0}%</td>
             <td>${item.bcg_P}</td>
             <td>${item.lahir_hidup_P>0?(item.bcg_P/item.lahir_hidup_P) * 100:0}%</td>
             <td>${item.bcg_P + item.bcg_L}</td>
             <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.bcg_L + item.bcg_P)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterBalitaBcg'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterBalitaBcg'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "BalitaBcg"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "BalitaBcg"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection