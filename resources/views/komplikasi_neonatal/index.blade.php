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
                            @if(Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KomplikasiNeonatal" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KomplikasiNeonatal" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('KomplikasiNeonatal', Session::get('year')) && Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_path.Auth::user()->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('KomplikasiNeonatal.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('KomplikasiNeonatal.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                <th colspan="3" rowspan="2">Jumlah Lahir Hidup</th>
                                <th colspan="3" rowspan="2">Perkiraan Neonatal Komplikasi</th>
                                <th colspan="16">Jumlah Komplikasi Pada Neonatus</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="2">Lock upload</th>
                                <th rowspan="2">File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th colspan="2">BBLR</th>
                                <th colspan="2">Asfiksia</th>
                                <th colspan="2">Infeksi</th>
                                <th colspan="2">Tetanus Neonatorum</th>
                                <th colspan="2">Kelainan Konginetal</th>
                                <th colspan="2">Covid-19</th>
                                <th colspan="2">Lain-lain</th>
                                <th colspan="2">Total</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
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
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]}}</td>
                                    <td>{{$item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"]}}</td>
                                    
                                    <td>{{number_format((15/100) * $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"], 2)}}</td>
                                    <td>{{number_format((15/100) * $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"], 2)}}</td>
                                    <td>{{number_format((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"]), 2)}}</td>
                                
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']}}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format($item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>
                                    <td>{{$item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr']
                                        }}</td>
                                    <td>{{(15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])>0?number_format(($item->komplikasi_neonatal_per_desa(Session::get('year'))['lain_lain']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['covid_19']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['kelainan']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['tetanus']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['infeksi']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['asfiksia']
                                        + $item->komplikasi_neonatal_per_desa(Session::get('year'))['bblr'])/((15/100) * ($item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_L"] + $item->kelahiran_per_desa(Session::get('year'))["lahir_hidup_P"])) * 100, 2):0}}</td>    
                                        <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterKomplikasiNeonatal') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                        @if(isset($item->user) && $item->user->downloadFile('KomplikasiNeonatal', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('KomplikasiNeonatal', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @elseif(isset($item->user) && !$item->user->downloadFile('KomplikasiNeonatal', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        @if(isset($item->user) && $item->user->hasFile('KomplikasiNeonatal', Session::get('year')))
                                        <td>
                                            @if($item->user->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_name != "-")
                                            <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_path.$item->user->downloadFile('KomplikasiNeonatal', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @if($item->filterKomplikasiNeonatal(Session::get('year')))
                                @php
                                $filterResult = $item->filterKomplikasiNeonatal(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>

                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P}}</td>

                                    <td>{{$item->filterKelahiran(Session::get('year'))->lahir_hidup_P + $item->filterKelahiran(Session::get('year'))->lahir_hidup_L}}</td>
                                    
                                    <td>{{number_format((15/100) * $item->filterKelahiran(Session::get('year'))->lahir_hidup_L, 2)}}</td>
                                    
                                    <td>{{number_format((15/100) * $item->filterKelahiran(Session::get('year'))->lahir_hidup_P, 2)}}</td>
                                    
                                    <td>{{number_format((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P), 2)}}</td>

                                    
                                    <td><input type="number" name="bblr" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->bblr}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="bblr{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->bblr/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="asfiksia" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="asfiksia{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    
                                    <td><input type="number" name="infeksi" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->infeksi}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="infeksi{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->infeksi/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    
                                    <td><input type="number" name="tetanus" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->tetanus}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="tetanus{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->tetanus/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="kelainan" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->kelainan}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kelainan{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->kelainan/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    
                                    <td><input type="number" name="covid_19" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->covid_19}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="covid_19{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->covid_19/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="lain_lain" {{$isDisabled}} id="{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}" value="{{$item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="lain_lain{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format($item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
                                    <td id="total{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{$item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain 
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->covid_19
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->kelainan
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->tetanus
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->infeksi
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->bblr
                                        }}</td>

                                        <td id="persen_total{{$item->filterKomplikasiNeonatal(Session::get('year'))->id}}">{{(15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)>0?number_format(($item->filterKomplikasiNeonatal(Session::get('year'))->lain_lain 
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->covid_19
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->kelainan
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->tetanus
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->infeksi
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->asfiksia
                                        + $item->filterKomplikasiNeonatal(Session::get('year'))->bblr)/((15/100) * ($item->filterKelahiran(Session::get('year'))->lahir_hidup_L
                                     + $item->filterKelahiran(Session::get('year'))->lahir_hidup_P)) * 100, 2):0}}</td>
                                    
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
        
        let persen_total = $(this).parent().parent().find(`#persen_total${id}`);
        let total = $(this).parent().parent().find(`#total${id}`);
        let bblr = $(this).parent().parent().find(`#bblr${id}`);
        let asfiksia = $(this).parent().parent().find(`#asfiksia${id}`);
        let infeksi = $(this).parent().parent().find(`#infeksi${id}`);
        let tetanus = $(this).parent().parent().find(`#tetanus${id}`);
        let kelainan = $(this).parent().parent().find(`#kelainan${id}`);
        let covid_19 = $(this).parent().parent().find(`#covid_19${id}`);
        let lain_lain = $(this).parent().parent().find(`#lain_lain${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KomplikasiNeonatal.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                persen_total.text(`${res.persen_total}`);
                total.text(`${res.total}`);
                bblr.text(`${res.bblr}`);
                asfiksia.text(`${res.asfiksia}`);
                infeksi.text(`${res.infeksi}`);
                tetanus.text(`${res.tetanus}`);
                covid_19.text(`${res.kelainan}`);
                lain_lain.text(`${res.lain_lain}`);
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
			'data'	: {'id': id, 'mainFilter': 'filterKomplikasiNeonatal', 'secondaryFilter': 'filterKelahiran'},
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
            <td>${(15/100) * item.lahir_hidup_L}</td>
            <td>${(15/100) * item.lahir_hidup_P}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)}</td>
            <td>${item.bblr}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.bblr/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.asfiksia}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.asfiksia/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.infeksi}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.infeksi/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.tetanus}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.tetanus/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.kelainan}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.kelainan/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.covid_19}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.covid_19/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.lain_lain}</td>
            <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?(item.lain_lain/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>
            <td>${item.covid_19 + item.lain_lain + item.kelainan + item.tetanus + item.infeksi + item.asfiksia + item.bblr}</td>
             <td>${(15/100) * (item.lahir_hidup_L + item.lahir_hidup_P)>0?((item.covid_19 + item.lain_lain + item.kelainan + item.tetanus + item.infeksi + item.asfiksia + item.bblr)/((15/100) * (item.lahir_hidup_L + item.lahir_hidup_P))) * 100:0}%</td>    
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterKomplikasiNeonatal'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterKomplikasiNeonatal'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "KomplikasiNeonatal"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "KomplikasiNeonatal"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection