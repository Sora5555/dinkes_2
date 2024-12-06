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
                            <li class="breadcrumb-item active">JUMLAH KASUS PENYAKIT</li>
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
                                @if(Auth::user()->downloadFile('Table69', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table69" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table69', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table69', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table69" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table69', Session::get('year')) && Auth::user()->downloadFile('Table69', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table69', Session::get('year'))->file_path.Auth::user()->downloadFile('Table69', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table69.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table69.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                            </div>
                        </div>
                        <div class="table-responsive lock-header">
                            <table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="4" style="vertical-align: middle">No</th>
                                        <th rowspan="4" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="4" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="4" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="17">JUMLAH KASUS  PD3I</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="4">Lock data</th>
                                        <th rowspan="4">Lock upload</th>
                                        <th rowspan="4">File Download</th>
                                        <th rowspan="4">Detail Desa</th>
                                    @endrole
                                       
                                    </tr>
                                    <tr>
                                        <th colspan="4">DIFTERI</th>
                                        <th colspan="3" rowspan="2">PERTUSIS</th>
                                        <th colspan="4">TETANUS NEONATORUM</th>
                                        <th colspan="3">HEPATITIS B</th>
                                        <th colspan="3" rowspan="2">SUSPEK CAMPAK</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">JUMLAH KASUS</th>
                                        <th rowspan="2">MENINGGAL</th>
                                        <th colspan="3">JUMLAH KASUS</th>
                                        <th rowspan="2">MENINGGAL</th>
                                        <th colspan="3">JUMLAH KASUS</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L+P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L+P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L+P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L+P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L+P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Granddifteri_l = 0;
                                        $Granddifteri_p = 0;
                                        $Granddifteri_lp = 0;
                                        $Granddifteri_m = 0;
                                        $Grandpertusis_l = 0;
                                        $Grandpertusis_p = 0;
                                        $Grandpertusis_lp = 0;
                                        $Grandtetanus_neonatorum_l = 0;
                                        $Grandtetanus_neonatorum_p = 0;
                                        $Grandtetanus_neonatorum_lp = 0;
                                        $Grandtetanus_neonatorum_m = 0;
                                        $Grandhepatitis_l = 0;
                                        $Grandhepatitis_p = 0;
                                        $Grandhepatitis_lp = 0;
                                        $Grandsuspek_campak_l = 0;
                                        $Grandsuspek_campak_p = 0;
                                        $Grandsuspek_campak_lp = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $difteri_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_l')['total'];
                                                    $Granddifteri_l += $difteri_l;

                                                    echo $difteri_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $difteri_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_p')['total'];

                                                    $Granddifteri_p += $difteri_p;

                                                    echo $difteri_p;
                                                @endphp
                                            </td>
                                            <td id="difteri_lp_">
                                                @php
                                                    $Granddifteri_lp += $difteri_p + $difteri_l;
                                                @endphp
                                                {{$difteri_p + $difteri_l}}
                                            </td>
                                            <td>
                                                @php
                                                    $difteri_m = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'difteri_m')['total'];
                                                    $Granddifteri_m += $difteri_m;

                                                    echo $difteri_m;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pertusis_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'pertusis_l')['total'];
                                                    $Grandpertusis_l += $pertusis_l;

                                                    echo $pertusis_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pertusis_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'pertusis_p')['total'];
                                                    $Grandpertusis_p += $pertusis_p;

                                                    echo $pertusis_p;
                                                @endphp
                                            </td>
                                            <td id="pertusis_lp_">
                                                @php
                                                    $Grandpertusis_lp += $pertusis_l + $pertusis_p;
                                                @endphp
                                                {{$pertusis_l + $pertusis_p}}
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_l')['total'];
                                                    $Grandtetanus_neonatorum_l += $tetanus_neonatorum_l;

                                                    echo $tetanus_neonatorum_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_p')['total'];
                                                    $Grandtetanus_neonatorum_p += $tetanus_neonatorum_p;

                                                    echo $tetanus_neonatorum_p;
                                                @endphp
                                            </td>
                                            <td id="tetanus_neonatorum_lp_">
                                                @php
                                                    $Grandtetanus_neonatorum_lp += $tetanus_neonatorum_l + $tetanus_neonatorum_p;
                                                @endphp
                                                {{$tetanus_neonatorum_l + $tetanus_neonatorum_p}}
                                            </td>
                                            <td>
                                                @php
                                                    $tetanus_neonatorum_m = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'tetanus_neonatorum_m')['total'];
                                                    $Grandtetanus_neonatorum_m += $tetanus_neonatorum_m;

                                                    echo $tetanus_neonatorum_m;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hepatitis_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'hepatitis_l')['total'];
                                                    $Grandhepatitis_l += $hepatitis_l;

                                                    echo $hepatitis_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $hepatitis_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'hepatitis_p')['total'];
                                                    $Grandhepatitis_p += $hepatitis_p;
                                                    echo $hepatitis_p;
                                                @endphp
                                            </td>
                                            <td id="hepatitis_lp_">
                                                @php
                                                    $Grandhepatitis_lp += $hepatitis_l + $hepatitis_p;
                                                @endphp
                                                {{ $hepatitis_l + $hepatitis_p }}
                                            </td>
                                            <td>
                                                @php
                                                    $suspek_campak_l = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'suspek_campak_l')['total'];
                                                    $Grandsuspek_campak_l += $suspek_campak_l;
                                                    echo $suspek_campak_l;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $suspek_campak_p = $item->unitKerjaAmbilPart2('filterTable69', Session::get('year'), 'suspek_campak_p')['total'];
                                                    $Grandsuspek_campak_p += $suspek_campak_p;
                                                    echo $suspek_campak_p;
                                                @endphp
                                            </td>
                                            <td id="suspek_campak_lp_">
                                                @php
                                                    $Grandsuspek_campak_lp += $suspek_campak_p + $suspek_campak_l;
                                                @endphp
                                                {{$suspek_campak_p + $suspek_campak_l}}
                                            </td>
                                            <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable69') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                            @if(isset($item->user) && $item->user->downloadFile('Table69', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table69', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @elseif(isset($item->user) && !$item->user->downloadFile('Table69', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            @if(isset($item->user) && $item->user->hasFile('Table69', Session::get('year')))
                                            <td>
                                                @if($item->user->downloadFile('Table69', Session::get('year'))->file_name != "-")
                                                <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table69', Session::get('year'))->file_path.$item->user->downloadFile('Table69', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <th colspan="3">JUMLAH</th>
                                            <th id="Granddifteri_l">{{$Granddifteri_l }} </th>
                                            <th id="Granddifteri_p">{{$Granddifteri_p }} </th>
                                            <th id="Granddifteri_lp">{{$Granddifteri_lp }} </th>
                                            <th id="Granddifteri_m">{{$Granddifteri_m }} </th>
                                            <th id="Grandpertusis_l">{{$Grandpertusis_l }} </th>
                                            <th id="Grandpertusis_p">{{$Grandpertusis_p }} </th>
                                            <th id="Grandpertusis_lp">{{$Grandpertusis_lp }} </th>
                                            <th id="Grandtetanus_neonatorum_l">{{$Grandtetanus_neonatorum_l }} </th>
                                            <th id="Grandtetanus_neonatorum_p">{{$Grandtetanus_neonatorum_p }} </th>
                                            <th id="Grandtetanus_neonatorum_lp">{{$Grandtetanus_neonatorum_lp}} </th>
                                            <th id="Grandtetanus_neonatorum_m">{{$Grandtetanus_neonatorum_m }} </th>
                                            <th id="Grandhepatitis_l">{{$Grandhepatitis_l  }} </th>
                                            <th id="Grandhepatitis_p">{{$Grandhepatitis_p  }} </th>
                                            <th id="Grandhepatitis_lp">{{$Grandhepatitis_lp  }} </th>
                                            <th id="Grandsuspek_campak_l">{{$Grandsuspek_campak_l  }} </th>
                                            <th id="Grandsuspek_campak_p">{{$Grandsuspek_campak_p }} </th>
                                            <th id="Grandsuspek_campak_lp">{{$Grandsuspek_campak_lp }} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">CASE FATALITY RATE (%)</th>
                                            <th colspan="3"></th>
                                            <th id="case_1">{{ $Granddifteri_m > 0 && $Granddifteri_lp > 0 ? number_format(($Granddifteri_m / $Granddifteri_lp) * 100, 2) . '%' : 0}}</th>
                                            <th colspan="6"></th>
                                            <th id="case_2">{{$Grandtetanus_neonatorum_m > 0 && $Grandtetanus_neonatorum_lp > 0 ? number_format(($Grandtetanus_neonatorum_m / $Grandtetanus_neonatorum_lp) * 100, 2) . '%' : 0}}</th>
                                            <th colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="16">INCIDENCE RATE SUSPEK CAMPAK</th>
                                            <th id="incidence_1">{{($Grandsuspek_campak_l / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_2">{{($Grandsuspek_campak_p / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_3">{{($Grandsuspek_campak_lp / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')

                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable69(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable69(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $difteri_l = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->difteri_l;
                                                            $Granddifteri_l += $difteri_l;
                                                        @endphp
                                                        <input type="number" name="difteri_l" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $difteri_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $difteri_p = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->difteri_p;

                                                            $Granddifteri_p += $difteri_p;
                                                        @endphp
                                                        <input type="number" name="difteri_p" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $difteri_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="difteri_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Granddifteri_lp += $difteri_p + $difteri_l;
                                                        @endphp
                                                        {{$difteri_p + $difteri_l}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $difteri_m = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->difteri_m;
                                                            $Granddifteri_m += $difteri_m;
                                                        @endphp
                                                        <input type="number" name="difteri_m" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $difteri_m }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pertusis_l = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->pertusis_l;
                                                            $Grandpertusis_l += $pertusis_l;
                                                        @endphp
                                                        <input type="number" name="pertusis_l" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $pertusis_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pertusis_p = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->pertusis_p;
                                                                $Grandpertusis_p += $pertusis_p;
                                                        @endphp
                                                        <input type="number" name="pertusis_p" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $pertusis_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="pertusis_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandpertusis_lp += $pertusis_l + $pertusis_p;
                                                        @endphp
                                                        {{$pertusis_l + $pertusis_p}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_l = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->tetanus_neonatorum_l;
                                                            $Grandtetanus_neonatorum_l += $tetanus_neonatorum_l;
                                                        @endphp
                                                        <input type="number" name="tetanus_neonatorum_l" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $tetanus_neonatorum_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_p = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->tetanus_neonatorum_p;
                                                            $Grandtetanus_neonatorum_p += $tetanus_neonatorum_p;
                                                        @endphp
                                                        <input type="number" name="tetanus_neonatorum_p" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $tetanus_neonatorum_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="tetanus_neonatorum_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandtetanus_neonatorum_lp += $tetanus_neonatorum_l + $tetanus_neonatorum_p;
                                                        @endphp
                                                        {{$tetanus_neonatorum_l + $tetanus_neonatorum_p}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tetanus_neonatorum_m = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->tetanus_neonatorum_m;
                                                            $Grandtetanus_neonatorum_m += $tetanus_neonatorum_m;
                                                        @endphp
                                                        <input type="number" name="tetanus_neonatorum_m" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $tetanus_neonatorum_m }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hepatitis_l = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hepatitis_l;
                                                            $Grandhepatitis_l += $hepatitis_l;
                                                        @endphp
                                                        <input type="number" name="hepatitis_l" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hepatitis_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $hepatitis_p = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->hepatitis_p;
                                                            $Grandhepatitis_p += $hepatitis_p;
                                                        @endphp
                                                        <input type="number" name="hepatitis_p" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $hepatitis_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="hepatitis_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandhepatitis_lp += $hepatitis_l + $hepatitis_p;
                                                        @endphp
                                                        {{ $hepatitis_l + $hepatitis_p }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $suspek_campak_l = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->suspek_campak_l;
                                                            $Grandsuspek_campak_l += $suspek_campak_l;
                                                        @endphp
                                                        <input type="number" name="suspek_campak_l" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $suspek_campak_l }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $suspek_campak_p = $item
                                                                ->filterTable69(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->suspek_campak_p;
                                                            $Grandsuspek_campak_p += $suspek_campak_p;
                                                        @endphp
                                                        <input type="number" name="suspek_campak_p" {{$isDisabled}}
                                                        id="{{ $item->filterTable69(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $suspek_campak_p }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="suspek_campak_lp_{{ $item->filterTable69(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $Grandsuspek_campak_lp += $suspek_campak_p + $suspek_campak_l;
                                                        @endphp
                                                        {{$suspek_campak_p + $suspek_campak_l}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">JUMLAH</th>
                                            <th id="Granddifteri_l">{{$Granddifteri_l }} </th>
                                            <th id="Granddifteri_p">{{$Granddifteri_p }} </th>
                                            <th id="Granddifteri_lp">{{$Granddifteri_lp }} </th>
                                            <th id="Granddifteri_m">{{$Granddifteri_m }} </th>
                                            <th id="Grandpertusis_l">{{$Grandpertusis_l }} </th>
                                            <th id="Grandpertusis_p">{{$Grandpertusis_p }} </th>
                                            <th id="Grandpertusis_lp">{{$Grandpertusis_lp }} </th>
                                            <th id="Grandtetanus_neonatorum_l">{{$Grandtetanus_neonatorum_l }} </th>
                                            <th id="Grandtetanus_neonatorum_p">{{$Grandtetanus_neonatorum_p }} </th>
                                            <th id="Grandtetanus_neonatorum_lp">{{$Grandtetanus_neonatorum_lp}} </th>
                                            <th id="Grandtetanus_neonatorum_m">{{$Grandtetanus_neonatorum_m }} </th>
                                            <th id="Grandhepatitis_l">{{$Grandhepatitis_l  }} </th>
                                            <th id="Grandhepatitis_p">{{$Grandhepatitis_p  }} </th>
                                            <th id="Grandhepatitis_lp">{{$Grandhepatitis_lp  }} </th>
                                            <th id="Grandsuspek_campak_l">{{$Grandsuspek_campak_l  }} </th>
                                            <th id="Grandsuspek_campak_p">{{$Grandsuspek_campak_p }} </th>
                                            <th id="Grandsuspek_campak_lp">{{$Grandsuspek_campak_lp }} </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">CASE FATALITY RATE (%)</th>
                                            <th colspan="3"></th>
                                            <th id="case_1">{{$Granddifteri_lp>0?number_format(($Granddifteri_m / $Granddifteri_lp) * 100, 2) . '%':0}}</th>
                                            <th colspan="6"></th>
                                            <th id="case_2">{{$Grandtetanus_neonatorum_lp>0?number_format(($Grandtetanus_neonatorum_m / $Grandtetanus_neonatorum_lp) * 100, 2) . '%':0}}</th>
                                            <th colspan="6"></th>
                                        </tr>
                                        <tr>
                                            <th colspan="16">INCIDENCE RATE SUSPEK CAMPAK</th>
                                            <th id="incidence_1">{{($Grandsuspek_campak_l / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_2">{{($Grandsuspek_campak_p / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                            <th id="incidence_3">{{($Grandsuspek_campak_lp / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
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
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    @endpush

    @push('scripts')
        <script>
            $('#data').on('input', '.data-input', function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                let data = {};
                var url_string = window.location.href;
                var url = new URL(url_string);
                let params = url.searchParams.get("year");
                let id = $(this).attr('id');
                // let persen = $(this).parent().parent().find(`#persen${id}`);
                // let balita_dipantau = $(this).parent().parent().find(`#balita_dipantau${id}`);
                // let balita_sdidtk = $(this).parent().parent().find(`#balita_sdidtk${id}`);
                // let balita_mtbs = $(this).parent().parent().find(`#balita_mtbs${id}`);
                // let lahir_hidup_mati_LP = $(this).parent().parent().find(`#lahir_hidup_mati_LP${id}`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'type': 'POST',
                    'url': '{{ url($route) }}',
                    'data': {
                        'name': name,
                        'value': value,
                        'id': id,
                        'year': params
                    },
                    success: function(res) {
                        console.log(res);
                        $('#difteri_lp_' + id).text(res.difteri_lp_);
                        $('#pertusis_lp_' + id).text(res.pertusis_lp_);
                        $('#tetanus_neonatorum_lp_' + id).text(res.tetanus_neonatorum_lp_);
                        $('#hepatitis_lp_' + id).text(res.hepatitis_lp_);
                        $('#suspek_campak_lp_' + id).text(res.suspek_campak_lp_);

                        $('#Granddifteri_l').text(res.Granddifteri_l);
                        $('#Granddifteri_p').text(res.Granddifteri_p);
                        $('#Granddifteri_lp').text(res.Granddifteri_lp);
                        $('#Granddifteri_m').text(res.Granddifteri_m);
                        $('#Grandpertusis_l').text(res.Grandpertusis_l);
                        $('#Grandpertusis_p').text(res.Grandpertusis_p);
                        $('#Grandpertusis_lp').text(res.Grandpertusis_lp);
                        $('#Grandtetanus_neonatorum_l').text(res.Grandtetanus_neonatorum_l);
                        $('#Grandtetanus_neonatorum_p').text(res.Grandtetanus_neonatorum_p);
                        $('#Grandtetanus_neonatorum_lp').text(res.Grandtetanus_neonatorum_lp);
                        $('#Grandtetanus_neonatorum_m').text(res.Grandtetanus_neonatorum_m);
                        $('#Grandhepatitis_l').text(res.Grandhepatitis_l);
                        $('#Grandhepatitis_p').text(res.Grandhepatitis_p);
                        $('#Grandhepatitis_lp').text(res.Grandhepatitis_lp);
                        $('#Grandsuspek_campak_l').text(res.Grandsuspek_campak_l);
                        $('#Grandsuspek_campak_p').text(res.Grandsuspek_campak_p);
                        $('#Grandsuspek_campak_lp').text(res.Grandsuspek_campak_lp);

                        $('#case_1').text(res.case_1);
                        $('#case_2').text(res.case_2);

                        $('#incidence_1').text(res.incidence_1);
                        $('#incidence_2').text(res.incidence_2);
                        $('#incidence_3').text(res.incidence_3);
                    }
                });
                // console.log(name, value, id);
            })



            $("#filter").click(function() {
                let year = $("#tahun").val();
                window.location.href = "{{ url($route) }}?year=" + year;
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
			'url'	: `/general2/detail_desa/${id}`,
			'data'	: {'id': id, 'mainFilter': 'filterTable69', 'thirdFilter': 'filterTable64'},
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
            <td>${item.difteri_l}</td>
            <td>${item.difteri_p}</td>
            <td>${parseInt(item.difteri_p) + parseInt(item.difteri_l)}</td>
            <td>${parseInt(item.difteri_m)}</td>
             <td>${item.pertusis_l}</td>
            <td>${item.pertusis_p}</td>
            <td>${parseInt(item.pertusis_p) + parseInt(item.pertusis_l)}</td>
            <td>${item.tetanus_neonatorum_l}</td>
            <td>${item.tetanus_neonatorum_p}</td>
            <td>${parseInt(item.tetanus_neonatorum_p) + parseInt(item.tetanus_neonatorum_l)}</td>
            <td>${parseInt(item.tetanus_neonatorum_m)}</td>
             <td>${item.hepatitis_l}</td>
            <td>${item.hepatitis_p}</td>
            <td>${parseInt(item.hepatitis_p) + parseInt(item.hepatitis_l)}</td>
             <td>${item.suspek_campak_l}</td>
            <td>${item.suspek_campak_p}</td>
            <td>${parseInt(item.suspek_campak_p) + parseInt(item.suspek_campak_l)}</td>
             
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
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable69'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable69'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table69"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table69"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
