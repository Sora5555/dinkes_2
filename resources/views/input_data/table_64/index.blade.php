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
                            <li class="breadcrumb-item active">Kasus baru kusta</li>
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
                                @if(Auth::user()->downloadFile('Table64', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table64" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table64', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table64', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table64" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table64', Session::get('year')) && Auth::user()->downloadFile('Table64', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table64', Session::get('year'))->file_path.Auth::user()->downloadFile('Table64', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table64.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table64.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                        </div>
                        <div class="table-responsive lock-header">
                            <table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="3" style="vertical-align: middle">No</th>
                                        <th rowspan="3" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="3" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="3" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="9">KASUS BARU</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                            <th rowspan="3">Lock upload</th>
                                            <th rowspan="3">File Download</th>
                                            <th rowspan="3">Detail Desa</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th colspan="3">PAUSI BASILER (PB)/ KUSTA KERING</th>
                                        <th colspan="3">MULTI BASILER (MB)/ KUSTA BASAH</th>
                                        <th colspan="3">PB + MB</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                        <th colspan="1">L</th>
                                        <th colspan="1">P</th>
                                        <th colspan="1">L + P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                    @php
                                        $GrandL_PB = 0;
                                        $GrandP_PB = 0;
                                        $GrandLP_PB = 0;
                                        $GrandL_MB = 0;
                                        $GrandP_MB = 0;
                                        $GrandLP_MB = 0;
                                        $GrandL_PBMB = 0;
                                        $GrandP_PBMB = 0;
                                        $GrandLP_PBMB = 0;
                                    @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                            <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                                <td>
                                                    @php
                                                        $l_pb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'l_pb')['total'];
                                                        $GrandL_PB += $l_pb;
                                                        // $GrandJumlahBayi += $jumlah_bayi;
                                                        // $GrandTotalIbuHamil += $totalIbuHamil;
                                                    @endphp
                                                    {{  $l_pb }}
                                                </td>
                                                <td>
                                                    @php
                                                        $p_pb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'p_pb')['total'];
                                                        $GrandP_PB += $p_pb;
                                                        // $GrandJumlahK24 += $jumlah_k_24;
                                                    @endphp
                                                    {{ $p_pb }}
                                                </td>
                                                <td>
                                                    {{$p_pb + $l_pb}}
                                                    @php
                                                        $GrandLP_PB += ($p_pb + $l_pb);
                                                    @endphp
                                                    {{-- {{ number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%' }} --}}
                                                </td>
                                                <td>
                                                    @php
                                                        $l_mb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'l_mb')['total'];
                                                        $GrandL_MB += ($l_mb);
                                                        // $GrandJumlahB24 += $jumlah_b_24;
                                                    @endphp
                                                    {{ $l_mb }}
                                                </td>
                                                <td>
                                                    @php
                                                        $p_mb = $item->unitKerjaAmbilPart2('filterTable64', Session::get('year'), 'p_mb')['total'];
                                                        $GrandP_MB += $p_mb;
                                                        // $GrandJumlahB24 += $jumlah_b_24;
                                                    @endphp
                                                    {{ $p_mb }}
                                                </td>
                                                <td>
                                                    {{$l_mb + $p_mb}}
                                                    @php
                                                    $GrandLP_MB += ($l_mb + $p_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$l_pb + $l_mb}}
                                                    @php
                                                        $GrandL_PBMB += ($l_pb + $l_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$p_pb + $p_mb}}
                                                    @php
                                                        $GrandP_PBMB += ($p_pb + $p_mb);
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{$l_pb + $l_mb + $p_pb + $p_mb}}
                                                    @php
                                                        $GrandLP_PBMB += ($l_pb + $l_mb + $p_pb + $p_mb);
                                                    @endphp
                                                </td>
                                                <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable64') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                            @if(isset($item->user) && $item->user->downloadFile('Table64', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table64', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @elseif(isset($item->user) && !$item->user->downloadFile('Table64', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            @if(isset($item->user) && $item->user->hasFile('Table64', Session::get('year')))
                                            <td>
                                                @if($item->user->downloadFile('Table64', Session::get('year'))->file_name != "-")
                                                <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table64', Session::get('year'))->file_path.$item->user->downloadFile('Table64', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <th colspan="3">Jumlah</th>
                                            <th id="GrandL_PB">{{$GrandL_PB}}</th>
                                            <th id="GrandP_PB">{{$GrandP_PB}}</th>
                                            <th id="GrandLP_PB">{{$GrandLP_PB}}</th>
                                            <th id="GrandL_MB">{{$GrandL_MB}}</th>
                                            <th id="GrandP_MB">{{$GrandP_MB}}</th>
                                            <th id="GrandLP_MB">{{$GrandLP_MB}}</th>
                                            <th id="GrandL_PBMB">{{$GrandL_PBMB}}</th>
                                            <th id="GrandP_PBMB">{{$GrandP_PBMB}}</th>
                                            <th id="GrandLP_PBMB">{{$GrandLP_PBMB}}</th>

                                        </tr>
                                        <tr>
                                            <th colspan="3">PROPORSI JENIS KELAMIN</th>
                                            <th id="PGrandL_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">ANGKA PENEMUAN KASUS BARU (NCDR/NEW CASE DETECTION RATE) PER 100.000 PENDUDUK</th>
                                            <th id="l_case">{{($GrandL_PBMB / $jumlah_penduduk_laki_laki) * 100000}}</th>
                                            <th id="p_case">{{($GrandP_PBMB / $jumlah_penduduk_perempuan) * 100000}}</th>

                                            <th id="lp_case">{{($GrandLP_PBMB / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandL_PB = 0;
                                            $GrandP_PB = 0;
                                            $GrandLP_PB = 0;
                                            $GrandL_MB = 0;
                                            $GrandP_MB = 0;
                                            $GrandLP_MB = 0;
                                            $GrandL_PBMB = 0;
                                            $GrandP_PBMB = 0;
                                            $GrandLP_PBMB = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable64(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable64(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $l_pb = $item
                                                                ->filterTable64(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->l_pb;
                                                                $GrandL_PB += $l_pb;
                                                            // $GrandJumlahBayi += $jumlah_bayi;
                                                            // $GrandTotalIbuHamil += $totalIbuHamil;
                                                        @endphp
                                                        {{-- {{ $totalIbuHamil }} --}}
                                                        <input type="number" name="l_pb" {{$isDisabled}}
                                                            id="{{ $item->filterTable64(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable64(Session::get('year'), $item->id)->l_pb }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_pb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->p_pb;
                                                            $GrandP_PB += $p_pb;
                                                            // $GrandJumlahK24 += $jumlah_k_24;
                                                        @endphp
                                                        <input type="number" name="p_pb" {{$isDisabled}}
                                                            id="{{ $item->filterTable64(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable64(Session::get('year'), $item->id)->p_pb }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="pl_pb_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$p_pb + $l_pb}}
                                                        @php
                                                            $GrandLP_PB += ($p_pb + $l_pb);
                                                        @endphp
                                                        {{-- {{ number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%' }} --}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $l_mb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->l_mb;
                                                            $GrandL_MB += ($l_mb);
                                                            // $GrandJumlahB24 += $jumlah_b_24;
                                                        @endphp
                                                        <input type="number" name="jumlah_b_24" {{$isDisabled}}
                                                            id="{{ $item->filterTable64(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable64(Session::get('year'), $item->id)->l_mb }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $p_mb = $item->filterTable64(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->p_mb;
                                                            $GrandP_MB += $p_mb;
                                                            // $GrandJumlahB24 += $jumlah_b_24;
                                                        @endphp
                                                        <input type="number" name="jumlah_b_24" {{$isDisabled}}
                                                            id="{{ $item->filterTable64(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable64(Session::get('year'), $item->id)->p_mb }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="pl_mb_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$l_mb + $p_mb}}
                                                        @php
                                                        $GrandLP_MB += ($l_mb + $p_mb);
                                                        @endphp
                                                    </td>
                                                    <td id="ll_PBMB_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$l_pb + $l_mb}}
                                                        @php
                                                            $GrandL_PBMB += ($l_pb + $l_mb);
                                                        @endphp
                                                    </td>
                                                    <td id="pp_PBMB_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$p_pb + $p_mb}}
                                                        @php
                                                            $GrandP_PBMB += ($p_pb + $p_mb);
                                                        @endphp
                                                    </td>
                                                    <td id="pl_PBMB_{{ $item->filterTable64(Session::get('year'), $item->id)->id }}">
                                                        {{$l_pb + $l_mb + $p_pb + $p_mb}}
                                                        @php
                                                            $GrandLP_PBMB += ($l_pb + $l_mb + $p_pb + $p_mb);
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="3">Jumlah</th>
                                            <th id="GrandL_PB">{{$GrandL_PB}}</th>
                                            <th id="GrandP_PB">{{$GrandP_PB}}</th>
                                            <th id="GrandLP_PB">{{$GrandLP_PB}}</th>
                                            <th id="GrandL_MB">{{$GrandL_MB}}</th>
                                            <th id="GrandP_MB">{{$GrandP_MB}}</th>
                                            <th id="GrandLP_MB">{{$GrandLP_MB}}</th>
                                            <th id="GrandL_PBMB">{{$GrandL_PBMB}}</th>
                                            <th id="GrandP_PBMB">{{$GrandP_PBMB}}</th>
                                            <th id="GrandLP_PBMB">{{$GrandLP_PBMB}}</th>

                                        </tr>
                                        <tr>
                                            <th colspan="3">PROPORSI JENIS KELAMIN</th>
                                            <th id="PGrandL_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PB / $GrandLP_PB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_MB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_MB / $GrandLP_MB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th></th>
                                            <th id="PGrandL_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandL_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                            <th id="PGrandP_PBMB">
                                                @php
                                                    try {
                                                        echo number_format(($GrandP_PBMB / $GrandLP_PBMB) * 100, 2)."%";
                                                    } catch (DivisionByZeroError $e) {
                                                        echo "0";
                                                    }
                                                @endphp
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="8">ANGKA PENEMUAN KASUS BARU (NCDR/NEW CASE DETECTION RATE) PER 100.000 PENDUDUK</th>
                                            <th id="l_case">{{($GrandL_PBMB / $jumlah_penduduk_laki_laki) * 100000}}</th>
                                            <th id="p_case">{{($GrandP_PBMB / $jumlah_penduduk_perempuan) * 100000}}</th>
                                            <th id="lp_case">{{($GrandLP_PBMB / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000}}</th>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td id="jumlah_bayi">{{ $GrandJumlahBayi }}</td>
                                            <td id="jumlah_k_24">{{ $GrandJumlahK24 }}</td>
                                            <td id="jumlah_k_p_24">
                                                {{ number_format(($GrandJumlahK24 / $GrandJumlahBayi) * 100, 2).'%' }}
                                            </td>
                                            <td id="jumlah_b_24">
                                                {{ $GrandJumlahB24 }}
                                            </td>
                                            <td id="jumlah_b_p_24">
                                                {{ number_format(($GrandJumlahB24 / $GrandJumlahBayi) * 100, 2).'%' }}
                                            </td>
                                            <td id="jumlah_kb_24">
                                                {{$GrandJumlahB24 + $GrandJumlahK24 }}
                                            </td>
                                            <td id="jumlah_kb_p_24">
                                                {{ number_format((($GrandJumlahB24 + $GrandJumlahK24) / $GrandJumlahBayi) * 100, 2).'%' }}
                                            </td>
                                            {{-- <td id="jumlah_bumil_reaktif">
                                                {{ number_format($GrandReaktif / $GrandTotal, 2) . '%' }}
                                            </td> --}}
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
                        $('#pl_pb_' + id).text(res.pl_pb_);
                        $('#pl_mb_' + id).text(res.pl_mb_);
                        $('#ll_PBMB_' + id).text(res.ll_PBMB_);
                        $('#pp_PBMB_' + id).text(res.pp_PBMB_);
                        $('#pl_PBMB_' + id).text(res.pl_PBMB_);

                        $('#GrandL_PB').text(res.GrandL_PB);
                        $('#GrandP_PB').text(res.GrandP_PB);
                        $('#GrandLP_PB').text(res.GrandLP_PB);
                        $('#GrandL_MB').text(res.GrandL_MB);
                        $('#GrandP_MB').text(res.GrandP_MB);
                        $('#GrandLP_MB').text(res.GrandLP_MB);
                        $('#GrandL_PBMB').text(res.GrandL_PBMB);
                        $('#GrandP_PBMB').text(res.GrandP_PBMB);
                        $('#GrandLP_PBMB').text(res.GrandLP_PBMB);

                        $('#PGrandL_PB').text(res.PGrandL_PB);
                        $('#PGrandP_PB').text(res.PGrandP_PB);
                        $('#PGrandL_MB').text(res.PGrandL_MB);
                        $('#PGrandP_MB').text(res.PGrandP_MB);
                        $('#PGrandL_PBMB').text(res.PGrandL_PBMB);
                        $('#PGrandP_PBMB').text(res.PGrandP_PBMB);

                        $('#l_case').text(res.l_case);
                        $('#p_case').text(res.p_case);
                        $('#lp_case').text(res.lp_case);
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
			'data'	: {'id': id, 'mainFilter': 'filterTable64'},
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
             <td>${item.l_pb}</td>
             <td>${item.p_pb}</td>
             <td>${parseInt(item.l_pb) + parseInt(item.p_pb) }</td>
             <td>${item.l_mb}</td>
             <td>${item.p_mb}</td>
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) }</td>
             <td>${parseInt(item.l_mb) + parseInt(item.l_pb)}</td>
             <td>${parseInt(item.p_mb) + parseInt(item.p_pb)}</td>
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb) }</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable64'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable64'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table64"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table64"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
