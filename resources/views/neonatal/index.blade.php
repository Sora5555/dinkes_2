@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <style>
        .lock-header{
            height: 100% !important;
        }
        .lock-header{
            overflow-y: auto;
            max-height: 100vh !important;
        }
        .unit_kerja{
            position: sticky !important;
            left: 0 !important;
            z-index: 0 !important;
            background: white !important;
        }
        .lock-header thead{
            position: sticky !important;
            top: 0 !important;
            background-color: white !important;
            z-index: 999;
        }
    </style>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Neonatal</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                        <li class="breadcrumb-item active">Neonatal</li>
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
                            @if(Auth::user()->downloadFile('neonatal', Session::get('year')))
                            <form action="/upload/neonatal" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('neonatal', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('neonatal', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/neonatal" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('neonatal', Session::get('year')))
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('neonatal', Session::get('year'))->file_path.Auth::user()->downloadFile('neonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('neonatal.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-warning" href="{{ route('neonatal.report') }}" ><i class="mdi mdi-note"></i>PDF report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('neonatal.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive lock-header">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr>
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role("Puskesmas|Pihak Wajib Pajak")
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th colspan="3">Jumlah Lahir Hidup</th>
                                <th colspan="6">Kunjungan Neonatal 1 kali</th>
                                <th colspan="6">Kunjungan Neonatal 3 kali (kn lengkap)</th>
                                <th colspan="6">Bayi baru lahir yang diberikan screening Hipotiroid Konginetal</th>
                                @role('Admin|superadmin')
                                <th rowspan="3" >Lock data</th>
                                <th rowspan="3" >Lock Upload</th>
                                <th rowspan="3" >File Download</th>
                                <th rowspan="3">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th rowspan="2">Laki Laki</th>
                                <th rowspan="2">Perempuan</th>
                                <th rowspan="2">Laki Laki + Perempuan</th>
                                <th colspan="2">Laki Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki Laki + Perempuan</th>
                                <th colspan="2">Laki Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki Laki + Perempuan</th>
                                <th colspan="2">Laki Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki Laki + Perempuan</th>
                            </tr>
                            <tr>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                                <th>jumlah</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}} </td>
                                    <td >{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
                                    
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn1_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["kn1_L"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn1_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["kn1_P"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn1_P"] + $item->neonatal_per_desa(Session::get('year'))["kn1_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(Session::get('year'))["kn1_P"] + $item->neonatal_per_desa(Session::get('year'))["kn1_L"]) / ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
                                    
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn_lengkap_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["kn_lengkap_L"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn_lengkap_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["kn_lengkap_P"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["kn_lengkap_P"] + $item->neonatal_per_desa(Session::get('year'))["kn_lengkap_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(Session::get('year'))["kn_lengkap_P"] + $item->neonatal_per_desa(Session::get('year'))["kn_lengkap_L"]) / ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
                                    
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["hipo_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["hipo_L"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["hipo_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] > 0?number_format($item->neonatal_per_desa(Session::get('year'))["hipo_P"] / $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]* 100, 2):0}}%</td>
                                    <td>{{$item->neonatal_per_desa(Session::get('year'))["hipo_P"] + $item->neonatal_per_desa(Session::get('year'))["hipo_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] > 0?number_format(($item->neonatal_per_desa(Session::get('year'))["hipo_P"] + $item->neonatal_per_desa(Session::get('year'))["hipo_L"]) / ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"])* 100, 2):0}}%</td>
                                    <td><input type="checkbox" name="lock" {{$item->neonatal_lock_get(Session::get('year')) == 1 ? "checked":""}} {{$item->neonatal_lock_get(Session::get('year')) == 2 ? "disabled":""}} class="data-lock" id="{{$item->id}}"></td>
                                    @if(isset($item->user) && $item->user->downloadFile('neonatal', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('neonatal', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @elseif(isset($item->user) && !$item->user->downloadFile('neonatal', Session::get('year')))
                                    <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @if(isset($item->user) && $item->user->hasFile('neonatal', Session::get('year')))
                                    <td>
                                        @if($item->user->downloadFile('neonatal', Session::get('year'))->file_name != "-")
                                        <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('neonatal', Session::get('year'))->file_path.$item->user->downloadFile('neonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td style="white-space: nowrap"><button class="btn btn-success detail" id="{{$item->id}}">Detail desa</button></td>
                                    {{-- <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_mati_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_mati_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_LP"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_mati_LP"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_mati_LP"]}}</td> --}}
                                  </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{$totalLahirHidupL}}</td>
                                    <td>{{$totalLahirHidupP}}</td>
                                    <td>{{$totalLahirHidupL + $totalLahirHidupP}}</td>
                                    
                                    <td>{{$totalkn1_L}}</td>
                                    <td>{{$totalLahirHidupL > 0?number_format($totalkn1_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td>{{$totalkn1_P}}</td>
                                    <td>{{$totalLahirHidupP > 0?number_format($totalkn1_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td>{{$totalkn1_L + $totalkn1_P}}</td>
                                    <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn1_L + $totalkn1_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                                    
                                    <td>{{$totalkn_lengkap_L}}</td>
                                    <td>{{$totalLahirHidupL > 0?number_format($totalkn_lengkap_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td>{{$totalkn_lengkap_P}}</td>
                                    <td>{{$totalLahirHidupP > 0?number_format($totalkn_lengkap_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td>{{$totalkn_lengkap_L + $totalkn_lengkap_P}}</td>
                                    <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn_lengkap_L + $totalkn_lengkap_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                                    
                                    <td>{{$totalhipo_L}}</td>
                                    <td>{{$totalLahirHidupL > 0?number_format($totalhipo_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td>{{$totalhipo_P}}</td>
                                    <td>{{$totalLahirHidupP > 0?number_format($totalhipo_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td>{{$totalhipo_L + $totalhipo_P}}</td>
                                    <td>{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalhipo_L + $totalhipo_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                                    <td></td>
                                </tr>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterNeonatal(Session::get('year')) && $item->filterKelahiran(Session::get('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{Auth::user()->unit_kerja->kecamatan}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
                                    <td id="lahir_L{{$item->filterKelahiran(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>
                                    
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="kn1_L" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->kn1_L}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kn1_L{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(Session::get('year'))->kn1_L/($item->filterKelahiran(Session::get('year'))->lahir_hidup_L)*100, 2):0}}%</td>
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="kn1_P" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->kn1_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kn1_P{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(Session::get('year'))->kn1_P/($item->filterKelahiran(Session::get('year'))->lahir_hidup_P)*100, 2):0}}%</td>
                                    <td id="jumlah_kn1_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterNeonatal(Session::get('year'))->kn1_L + $item->filterNeonatal(Session::get('year'))->kn1_P}}</td>
                                    <td id="persen_kn1_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(Session::get('year'))->kn1_L + $item->filterNeonatal(Session::get('year'))->kn1_P)/(($item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P))* 100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="kn_lengkap_L" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->kn_lengkap_L}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kn_lengkap_L{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(Session::get('year'))->kn_lengkap_L/($item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}%</td>
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="kn_lengkap_P" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->kn_lengkap_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="kn_lengkap_P{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(Session::get('year'))->kn_lengkap_P/($item->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2):0}}%</td>
                                    <td id="jumlah_kn_lengkap_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterNeonatal(Session::get('year'))->kn_lengkap_L + $item->filterNeonatal(Session::get('year'))->kn_lengkap_P}}</td>
                                    <td id="persen_kn_lengkap_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(Session::get('year'))->kn_lengkap_L + $item->filterNeonatal(Session::get('year'))->kn_lengkap_P)/(($item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}%</td>
                                    
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="hipo_L" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->hipo_L}}" class="form-control data-input" style="border: none"></td>
                                    <td id="hipo_L{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0?number_format($item->filterNeonatal(Session::get('year'))->hipo_L/($item->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2):0}}</td>
                                    <td><input type="number" {{$item->filterNeonatal(Session::get('year'))->status == 1 || $item->filterNeonatal(Session::get('year'))->status == 2?"disabled":""}} name="hipo_P" id="{{$item->filterNeonatal(Session::get('year'))->id}}" value="{{$item->filterNeonatal(Session::get('year'))->hipo_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="hipo_P{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0?number_format($item->filterNeonatal(Session::get('year'))->hipo_P/($item->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2):0}}</td>
                                    <td id="jumlah_hipo_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterNeonatal(Session::get('year'))->hipo_L + $item->filterNeonatal(Session::get('year'))->hipo_P}}</td>
                                    <td id="persen_hipo_LP{{$item->filterNeonatal(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($item->filterNeonatal(Session::get('year'))->hipo_L + $item->filterNeonatal(Session::get('year'))->hipo_P)/(($item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    {{-- <td><input type="number" name="lahir_hidup_P" id="{{$item->filterKelahiran(Session::get('year'))->id}}" value="{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}" class="form-control data-input" style="border: none"></td>
                                    <td><input type="number" name="lahir_mati_P" id="{{$item->filterKelahiran(Session::get('year'))->id}}" value="{{$item->filterKelahiran(Session::get('year'))->lahir_mati_P}}" class="form-control data-input" style="border: none"></td>
                                    <td id="lahir_P{{$item->filterKelahiran(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_mati_P}}</td>
                                    <td id="lahir_hidup_LP{{$item->filterKelahiran(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    <td id="lahir_mati_LP{{$item->filterKelahiran(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_mati_P + $item->filterKelahiran(Session::get('year'))->lahir_mati_L}}</td>
                                    <td id="lahir_hidup_mati_LP{{$item->filterKelahiran(Session::get('year'))->id}}">{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_mati_P + $item->filterKelahiran(Session::get('year'))->lahir_mati_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td> --}}

                                  </tr>
                                  @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{$totalLahirHidupL}}</td>
                                    <td>{{$totalLahirHidupP}}</td>
                                    <td>{{$totalLahirHidupL + $totalLahirHidupP}}</td>
                                    
                                    <td id="kn1_L">{{$totalkn1_L}}</td>
                                    <td id="percentage_kn1_L">{{$totalLahirHidupL > 0?number_format($totalkn1_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td id="kn1_P">{{$totalkn1_P}}</td>
                                    <td id="percentage_kn1_P">{{$totalLahirHidupP > 0?number_format($totalkn1_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td id="total_kn1">{{$totalkn1_L + $totalkn1_P}}</td>
                                    <td id="percentage_total_kn1">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn1_L + $totalkn1_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                                    
                                    <td id="kn_lengkap_L">{{$totalkn_lengkap_L}}</td>
                                    <td id="percentage_kn_lengkap_L">{{$totalLahirHidupL > 0?number_format($totalkn_lengkap_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td id="kn_lengkap_P">{{$totalkn_lengkap_P}}</td>
                                    <td id="percentage_kn_lengkap_P">{{$totalLahirHidupP > 0?number_format($totalkn_lengkap_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td id="total_kn_lengkap">{{$totalkn_lengkap_L + $totalkn_lengkap_P}}</td>
                                    <td id="percentage_total_kn_lengkap">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalkn_lengkap_L + $totalkn_lengkap_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
                                    
                                    <td id="hipo_L">{{$totalhipo_L}}</td>
                                    <td id="percentage_hipo_L">{{$totalLahirHidupL > 0?number_format($totalhipo_L / $totalLahirHidupL * 100, 2):0}}%</td>
                                    <td id="hipo_P">{{$totalhipo_P}}</td>
                                    <td id="percentage_hipo_P">{{$totalLahirHidupP > 0?number_format($totalhipo_P / $totalLahirHidupP * 100, 2):0}}%</td>
                                    <td id="total_hipo">{{$totalhipo_L + $totalhipo_P}}</td>
                                    <td id="percentage_total_hipo">{{$totalLahirHidupL + $totalLahirHidupP > 0?number_format(($totalhipo_L + $totalhipo_P) / ($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0}}%</td>
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
			'url'	: `/neonatal/detail_desa/${id}`,
			'data'	: {'id': id},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
                        <td></td>
                        <td>${item.nama}</td>
                        <td>${item.lahir_hidup_L}</td>
                        <td>${item.lahir_hidup_P}</td>
                        <td>${item.lahir_hidup_P + item.lahir_hidup_L}</td>
                        <td>${item.kn1_L}</td>
                        <td>${item.lahir_hidup_L>0?(item.kn1_L/item.lahir_hidup_L) * 100:0}%</td>
                        <td>${item.kn1_P}</td>
                        <td>${item.lahir_hidup_P>0?(item.kn1_P/item.lahir_hidup_P) * 100:0}%</td>
                        <td>${item.kn1_P + item.kn1_L}</td>
                        <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.kn1_P + item.kn1_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
                        
                        <td>${item.kn_lengkap_L}</td>
                        <td>${item.lahir_hidup_L>0?(item.kn_lengkap_L/item.lahir_hidup_L) * 100:0}%</td>
                        <td>${item.kn_lengkap_P}</td>
                        <td>${item.lahir_hidup_P>0?(item.kn_lengkap_P/item.lahir_hidup_P) * 100:0}%</td>
                        <td>${item.kn_lengkap_P + item.kn_lengkap_L}</td>
                        <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.kn_lengkap_P + item.kn_lengkap_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
                        
                        <td>${item.hipo_L}</td>
                        <td>${item.lahir_hidup_L>0?(item.hipo_L/item.lahir_hidup_L) * 100:0}%</td>
                        <td>${item.hipo_P}</td>
                        <td>${item.lahir_hidup_P>0?(item.hipo_P/item.lahir_hidup_P) * 100:0}%</td>
                        <td>${item.hipo_P + item.hipo_L}</td>
                        <td>${item.lahir_hidup_P + item.lahir_hidup_L>0?((item.hipo_P + item.hipo_L)/(item.lahir_hidup_P + item.lahir_hidup_L)) * 100:0}%</td>
                        
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
        $('#data').on('input', '.data-input', function(){
		let name = $(this).attr('name');
		let value = $(this).val();
		let data = {};
        var url_string = window.location.href;
         var url = new URL(url_string);
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');
        let kn1_L = $(this).parent().parent().find(`#kn1_L${id}`);
        let kn1_P = $(this).parent().parent().find(`#kn1_P${id}`);
        let jumlah_kn1_LP = $(this).parent().parent().find(`#jumlah_kn1_LP${id}`);
        let persen_kn1_LP = $(this).parent().parent().find(`#persen_kn1_LP${id}`);
        let kn_lengkap_L = $(this).parent().parent().find(`#kn_lengkap_L${id}`);
        let kn_lengkap_P = $(this).parent().parent().find(`#kn_lengkap_P${id}`);
        let jumlah_kn_lengkap_LP = $(this).parent().parent().find(`#jumlah_kn_lengkap_LP${id}`);
        let persen_kn_lengkap_LP = $(this).parent().parent().find(`#persen_kn_lengkap_LP${id}`);
        let hipo_L = $(this).parent().parent().find(`#hipo_L${id}`);
        let hipo_P = $(this).parent().parent().find(`#hipo_P${id}`);
        let jumlah_hipo_LP = $(this).parent().parent().find(`#jumlah_hipo_LP${id}`);
        let persen_hipo_LP = $(this).parent().parent().find(`#persen_hipo_LP${id}`);
        // let lahir_hidup_mati_LP = $(this).parent().parent().find(`#lahir_hidup_mati_LP${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("neonatal.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                console.log(res, res.persen_kn1_L);
                kn1_L.text(`${res.persen_kn1_L}%`);
                kn1_P.text(`${res.persen_kn1_P}%`);
                jumlah_kn1_LP.text(`${res.jumlah_kn1_LP}`);
                persen_kn1_LP.text(`${res.persen_kn1_LP}%`);
                kn_lengkap_L.text(`${res.persen_kn_lengkap_L}%`);
                kn_lengkap_P.text(`${res.persen_kn_lengkap_P}%`);
                jumlah_kn_lengkap_LP.text(`${res.jumlah_kn_lengkap_LP}`);
                persen_kn_lengkap_LP.text(`${res.persen_kn_lengkap_LP}%`);
                hipo_L.text(`${res.persen_hipo_L}%`);
                hipo_P.text(`${res.persen_hipo_P}%`);
                persen_hipo_LP.text(`${res.persen_hipo_LP}%`);
                jumlah_hipo_LP.text(`${res.jumlah_hipo_LP}%`);
                // lahir_hidup_mati_LP.text(`${res.lahir_hidup_mati_LP}%`);
                // kf_lengkap.text(`${res.kf_lengkap}%`);
                // vita.text(`${res.vita}%`);

                let total_column = res.column;
                $(`#total_kn1`).text(res.totalkn1_LP)
                $(`#total_kn_lengkap`).text(res.totalkn_lengkap_LP)
                $(`#total_hipo`).text(res.totalhipo_LP)
                $(`#percentage_total_kn1`).text(`${res.persenkn1_LP}%`)
                $(`#percentage_total_kn_lengkap`).text(`${res.persenkn_lengkap_LP}%`)
                $(`#percentage_total_hipo`).text(`${res.persenhipo_LP}%`)
                $(`#${total_column}`).text(res.total);
                $(`#percentage_${total_column}`).text(`${res.percentage}%`);
			}
		});
        console.log(name, value, id);
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
        $("#kegiatan_id").change(function(){
            table.draw()
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
			'url'	: '{{ route("Neonatal.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("Neonatal.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
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
			'url'	: '{{ route("Neonatal.lock_upload") }}',
			'data'	: {'id': id, 'status': 1, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("Neonatal.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection