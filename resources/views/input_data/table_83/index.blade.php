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
                            <li class="breadcrumb-item active">PERSENTASE TEMPAT PENGELOLAAN PANGAN (TPP) </li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table83.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                               
                            </div>
                            {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div>
                        </div>
                        {{-- <h4 class="card-title">Pengguna</h4> --}}
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
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
                                        <th colspan="3">JASA BOGA</th>
                                        <th colspan="3">RESTORAN</th>
                                        <th colspan="3">TPP TERTENTU</th>
                                        <th colspan="3">DEPOT AIR MINUM</th>
                                        <th colspan="3">RUMAH MAKAN</th>
                                        <th colspan="3">KELOMPOK GERAI PANGAN JAJANAN</th>
                                        <th colspan="3">SENTRA PANGAN JAJANAN/KANTIN</th>
                                        <th colspan="3">TPP MEMENUHI SYARAT</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                        <th rowspan="2" style="vertical-align: middle;">TERDAFTAR</th>
                                        <th colspan="2">LAIK HSP</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandjasa_boga_terdaftar = 0;
                                        $Grandjasa_boga_jumlah = 0;
                                        $Grandrestoran_terdaftar = 0;
                                        $Grandrestoran_jumlah = 0;
                                        $Grandtpp_tertentu_terdaftar = 0;
                                        $Grandtpp_tertentu_jumlah = 0;
                                        $Granddepot_air_minum_terdaftar = 0;
                                        $Granddepot_air_minum_jumlah = 0;
                                        $Grandrumah_makan_terdaftar = 0;
                                        $Grandrumah_makan_jumlah = 0;
                                        $Grandkelompok_gerai_terdaftar = 0;
                                        $Grandkelompok_gerai_jumlah = 0;
                                        $Grandsentra_pangan_terdaftar = 0;
                                        $Grandsentra_pangan_jumlah = 0;
                                        $Grandterdaftar_tpp_memenuhi_syarat = 0;
                                        $Grandjumlah_tpp_memenuhi_syarat = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $jasa_boga_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'jasa_boga_terdaftar')['total'];
                                                    $Grandjasa_boga_terdaftar += $jasa_boga_terdaftar;

                                                    echo  $jasa_boga_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $jasa_boga_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'jasa_boga_jumlah')['total'];
                                                    $Grandjasa_boga_jumlah += $jasa_boga_jumlah;

                                                    echo $jasa_boga_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_jasa_boga_">
                                                {{ $jasa_boga_terdaftar>0?number_format(($jasa_boga_jumlah / $jasa_boga_terdaftar) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $restoran_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'restoran_terdaftar')['total'];
                                                    $Grandrestoran_terdaftar += $restoran_terdaftar;

                                                    echo $restoran_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $restoran_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'restoran_jumlah')['total'];
                                                    $Grandrestoran_jumlah += $restoran_jumlah;

                                                    echo $restoran_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_restoran_">
                                                {{ $restoran_terdaftar>0?number_format(($restoran_jumlah / $restoran_terdaftar) * 100, 2) . '%':0}}
                                            </td>

                                            <td>
                                                @php
                                                    $tpp_tertentu_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'tpp_tertentu_terdaftar')['total'];
                                                    $Grandtpp_tertentu_terdaftar += $tpp_tertentu_terdaftar;

                                                    echo $tpp_tertentu_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $tpp_tertentu_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'tpp_tertentu_jumlah')['total'];
                                                    $Grandtpp_tertentu_jumlah += $tpp_tertentu_jumlah;

                                                    echo $tpp_tertentu_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_tpp_tertentu_">
                                                {{ $tpp_tertentu_terdaftar>0?number_format(($tpp_tertentu_jumlah / $tpp_tertentu_terdaftar) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $depot_air_minum_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'depot_air_minum_terdaftar')['total'];
                                                    $Granddepot_air_minum_terdaftar += $depot_air_minum_terdaftar;

                                                    echo $depot_air_minum_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $depot_air_minum_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'depot_air_minum_jumlah')['total'];
                                                    $Granddepot_air_minum_jumlah += $depot_air_minum_jumlah;

                                                    echo $depot_air_minum_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_depot_air_minum_">
                                                {{ $depot_air_minum_terdaftar>0?number_format(($depot_air_minum_jumlah / $depot_air_minum_terdaftar) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $rumah_makan_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'rumah_makan_terdaftar')['total'];
                                                    $Grandrumah_makan_terdaftar += $rumah_makan_terdaftar;

                                                    echo $rumah_makan_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $rumah_makan_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'rumah_makan_jumlah')['total'];
                                                    $Grandrumah_makan_jumlah += $rumah_makan_jumlah;

                                                    echo $rumah_makan_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_rumah_makan_">
                                                {{ $rumah_makan_terdaftar>0?number_format(($rumah_makan_jumlah / $rumah_makan_terdaftar) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $kelompok_gerai_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'kelompok_gerai_terdaftar')['total'];
                                                    $Grandkelompok_gerai_terdaftar += $kelompok_gerai_terdaftar;

                                                    echo $kelompok_gerai_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $kelompok_gerai_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'kelompok_gerai_jumlah')['total'];
                                                    $Grandkelompok_gerai_jumlah += $kelompok_gerai_jumlah;
                                                    echo $kelompok_gerai_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_kelompok_gerai_">
                                                {{ $kelompok_gerai_terdaftar>0?number_format(($kelompok_gerai_jumlah / $kelompok_gerai_terdaftar) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $sentra_pangan_terdaftar = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'sentra_pangan_terdaftar')['total'];
                                                    $Grandsentra_pangan_terdaftar += $sentra_pangan_terdaftar;
                                                    echo $sentra_pangan_terdaftar;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $sentra_pangan_jumlah = $item->unitKerjaAmbilPart2('filterTable83', Session::get('year'), 'sentra_pangan_jumlah')['total'];
                                                    $Grandsentra_pangan_jumlah += $sentra_pangan_jumlah;
                                                    echo $sentra_pangan_jumlah;
                                                @endphp
                                            </td>
                                            <td id="persen_sentra_pangan_">
                                                {{ $sentra_pangan_terdaftar>0?number_format(($sentra_pangan_jumlah / $sentra_pangan_terdaftar) * 100, 2) . '%':0}}
                                            </td>

                                            <td id="terdaftar_tpp_memenuhi_syarat_">
                                                @php
                                                    $terdaftar_tpp_memenuhi_syarat_ = $jasa_boga_terdaftar + $restoran_terdaftar + $tpp_tertentu_terdaftar + $depot_air_minum_terdaftar + $rumah_makan_terdaftar + $kelompok_gerai_terdaftar + $sentra_pangan_terdaftar;
                                                    echo $terdaftar_tpp_memenuhi_syarat_;
                                                    $Grandterdaftar_tpp_memenuhi_syarat += $terdaftar_tpp_memenuhi_syarat_;
                                                @endphp
                                            </td>
                                            <td id="jumlah_tpp_memenuhi_syarat_">
                                                @php
                                                    $jumlah_tpp_memenuhi_syarat_ = $jasa_boga_jumlah + $restoran_jumlah + $tpp_tertentu_jumlah + $depot_air_minum_jumlah + $rumah_makan_jumlah + $kelompok_gerai_jumlah + $sentra_pangan_jumlah;
                                                    echo $jumlah_tpp_memenuhi_syarat_;
                                                    $Grandjumlah_tpp_memenuhi_syarat += $jumlah_tpp_memenuhi_syarat_;
                                                @endphp
                                            </td>
                                            <td id="persen_tpp_memenuhi_syarat_">
                                                {{ $terdaftar_tpp_memenuhi_syarat>0?number_format(($jumlah_tpp_memenuhi_syarat_ / $terdaftar_tpp_memenuhi_syarat_) * 100, 2) . '%':0}}
                                            </td>

                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable83(Session::get('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jasa_boga_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jasa_boga_terdaftar;
                                                            $Grandjasa_boga_terdaftar += $jasa_boga_terdaftar;
                                                        @endphp
                                                        <input type="number" name="jasa_boga_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $jasa_boga_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jasa_boga_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jasa_boga_jumlah;
                                                            $Grandjasa_boga_jumlah += $jasa_boga_jumlah;
                                                        @endphp
                                                        <input type="number" name="jasa_boga_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $jasa_boga_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_jasa_boga_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $jasa_boga_terdaftar>0?number_format(($jasa_boga_jumlah / $jasa_boga_terdaftar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $restoran_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->restoran_terdaftar;
                                                            $Grandrestoran_terdaftar += $restoran_terdaftar;
                                                        @endphp
                                                        <input type="number" name="restoran_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $restoran_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $restoran_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->restoran_jumlah;
                                                            $Grandrestoran_jumlah += $restoran_jumlah;
                                                        @endphp
                                                        <input type="number" name="restoran_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $restoran_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_restoran_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $restoran_terdaftar>0?number_format(($restoran_jumlah / $restoran_terdaftar) * 100, 2) . '%':0}}
                                                    </td>

                                                    <td>
                                                        @php
                                                            $tpp_tertentu_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->tpp_tertentu_terdaftar;
                                                            $Grandtpp_tertentu_terdaftar += $tpp_tertentu_terdaftar;
                                                        @endphp
                                                        <input type="number" name="tpp_tertentu_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $tpp_tertentu_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $tpp_tertentu_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->tpp_tertentu_jumlah;
                                                            $Grandtpp_tertentu_jumlah += $tpp_tertentu_jumlah;
                                                        @endphp
                                                        <input type="number" name="tpp_tertentu_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $tpp_tertentu_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_tpp_tertentu_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $tpp_tertentu_terdaftar>0?number_format(($tpp_tertentu_jumlah / $tpp_tertentu_terdaftar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $depot_air_minum_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->depot_air_minum_terdaftar;
                                                            $Granddepot_air_minum_terdaftar += $depot_air_minum_terdaftar;
                                                        @endphp
                                                        <input type="number" name="depot_air_minum_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $depot_air_minum_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $depot_air_minum_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->depot_air_minum_jumlah;
                                                            $Granddepot_air_minum_jumlah += $depot_air_minum_jumlah;
                                                        @endphp
                                                        <input type="number" name="depot_air_minum_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $depot_air_minum_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_depot_air_minum_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $depot_air_minum_terdaftar>0?number_format(($depot_air_minum_jumlah / $depot_air_minum_terdaftar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $rumah_makan_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->rumah_makan_terdaftar;
                                                            $Grandrumah_makan_terdaftar += $rumah_makan_terdaftar;
                                                        @endphp
                                                        <input type="number" name="rumah_makan_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $rumah_makan_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $rumah_makan_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->rumah_makan_jumlah;
                                                            $Grandrumah_makan_jumlah += $rumah_makan_jumlah;
                                                        @endphp
                                                        <input type="number" name="rumah_makan_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $rumah_makan_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_rumah_makan_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $rumah_makan_terdaftar>0?number_format(($rumah_makan_jumlah / $rumah_makan_terdaftar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $kelompok_gerai_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kelompok_gerai_terdaftar;
                                                            $Grandkelompok_gerai_terdaftar += $kelompok_gerai_terdaftar;
                                                        @endphp
                                                        <input type="number" name="kelompok_gerai_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kelompok_gerai_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>

                                                    <td>
                                                        @php
                                                            $kelompok_gerai_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->kelompok_gerai_jumlah;
                                                            $Grandkelompok_gerai_jumlah += $kelompok_gerai_jumlah;
                                                        @endphp
                                                        <input type="number" name="kelompok_gerai_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $kelompok_gerai_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_kelompok_gerai_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $kelompok_gerai_terdaftar>0?number_format(($kelompok_gerai_jumlah / $kelompok_gerai_terdaftar) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sentra_pangan_terdaftar = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sentra_pangan_terdaftar;
                                                            $Grandsentra_pangan_terdaftar += $sentra_pangan_terdaftar;
                                                        @endphp
                                                        <input type="number" name="sentra_pangan_terdaftar"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sentra_pangan_terdaftar }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $sentra_pangan_jumlah = $item
                                                                ->filterTable83(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->sentra_pangan_jumlah;
                                                            $Grandsentra_pangan_jumlah += $sentra_pangan_jumlah;
                                                        @endphp
                                                        <input type="number" name="sentra_pangan_jumlah"
                                                        id="{{ $item->filterTable83(Session::get('year'), $item->id)->id }}"
                                                        value="{{ $sentra_pangan_jumlah }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_sentra_pangan_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $sentra_pangan_terdaftar>0?number_format(($sentra_pangan_jumlah / $sentra_pangan_terdaftar) * 100, 2) . '%':0}}
                                                    </td>

                                                    <td id="terdaftar_tpp_memenuhi_syarat_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $terdaftar_tpp_memenuhi_syarat_ = $jasa_boga_terdaftar + $restoran_terdaftar + $tpp_tertentu_terdaftar + $depot_air_minum_terdaftar + $rumah_makan_terdaftar + $kelompok_gerai_terdaftar + $sentra_pangan_terdaftar;
                                                            echo $terdaftar_tpp_memenuhi_syarat_;
                                                            $Grandterdaftar_tpp_memenuhi_syarat += $terdaftar_tpp_memenuhi_syarat_;
                                                        @endphp
                                                    </td>
                                                    <td id="jumlah_tpp_memenuhi_syarat_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_tpp_memenuhi_syarat_ = $jasa_boga_jumlah + $restoran_jumlah + $tpp_tertentu_jumlah + $depot_air_minum_jumlah + $rumah_makan_jumlah + $kelompok_gerai_jumlah + $sentra_pangan_jumlah;
                                                            echo $jumlah_tpp_memenuhi_syarat_;
                                                            $Grandjumlah_tpp_memenuhi_syarat += $jumlah_tpp_memenuhi_syarat_;
                                                        @endphp
                                                    </td>
                                                    <td id="persen_tpp_memenuhi_syarat_{{ $item->filterTable83(Session::get('year'), $item->id)->id }}">
                                                        {{ $terdaftar_tpp_memenuhi_syarat_>0?number_format(($jumlah_tpp_memenuhi_syarat_ / $terdaftar_tpp_memenuhi_syarat_) * 100, 2) . '%':0}}
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole
                                    <tr>
                                        <th colspan="3">Jumlah</th>
                                        <th id="Grandjasa_boga_terdaftar">{{ $Grandjasa_boga_terdaftar }} </th>
                                        <th id="Grandjasa_boga_jumlah">{{ $Grandjasa_boga_jumlah }} </th>
                                        <th id="Persen_Grandjasa_boga">{{ $Grandjasa_boga_terdaftar>0?number_format(($Grandjasa_boga_jumlah / $Grandjasa_boga_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandrestoran_terdaftar">{{ $Grandrestoran_terdaftar }} </th>
                                        <th id="Grandrestoran_jumlah">{{ $Grandrestoran_jumlah }} </th>
                                        <th id="Persen_Grandrestoran_jumlah">{{ $Grandrestoran_terdaftar>0?number_format(($Grandrestoran_jumlah / $Grandrestoran_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandtpp_tertentu_terdaftar">{{ $Grandtpp_tertentu_terdaftar }} </th>
                                        <th id="Grandtpp_tertentu_jumlah">{{ $Grandtpp_tertentu_jumlah }} </th>
                                        <th id="Persen_Grandtertentu_jumlah">{{ $Grandtpp_tertentu_terdaftar>0?number_format(($Grandtpp_tertentu_jumlah / $Grandtpp_tertentu_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Granddepot_air_minum_terdaftar">{{ $Granddepot_air_minum_terdaftar }} </th>
                                        <th id="Granddepot_air_minum_jumlah">{{ $Granddepot_air_minum_jumlah }} </th>
                                        <th id="Persen_Granddepot_air_minum">{{ $Granddepot_air_minum_terdaftar>0?number_format(($Granddepot_air_minum_jumlah / $Granddepot_air_minum_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandrumah_makan_terdaftar">{{ $Grandrumah_makan_terdaftar }} </th>
                                        <th id="Grandrumah_makan_jumlah">{{ $Grandrumah_makan_jumlah }} </th>
                                        <th id="Persen_Grandrumah_makan">{{ $Grandrumah_makan_terdaftar>0?number_format(($Grandrumah_makan_jumlah / $Grandrumah_makan_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandkelompok_gerai_terdaftar">{{ $Grandkelompok_gerai_terdaftar }} </th>
                                        <th id="Grandkelompok_gerai_jumlah">{{ $Grandkelompok_gerai_jumlah }} </th>
                                        <th id="Persen_Grandkelompok_gerai">{{ $Grandkelompok_gerai_terdaftar>0?number_format(($Grandkelompok_gerai_jumlah / $Grandkelompok_gerai_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandsentra_pangan_terdaftar">{{ $Grandsentra_pangan_terdaftar }} </th>
                                        <th id="Grandsentra_pangan_jumlah">{{ $Grandsentra_pangan_jumlah }} </th>
                                        <th id="Persen_Grandsentra_pangan">{{ $Grandsentra_pangan_terdaftar>0?number_format(($Grandsentra_pangan_jumlah / $Grandsentra_pangan_terdaftar) * 100, 2) . '%':0}}</th>

                                        <th id="Grandterdaftar_tpp_memenuhi_syarat">{{ $Grandterdaftar_tpp_memenuhi_syarat }} </th>
                                        <th id="Grandjumlah_tpp_memenuhi_syarat">{{ $Grandjumlah_tpp_memenuhi_syarat }} </th>
                                        <th id="Persen_Grand_tpp_memenuhi_syarat">{{ $Grandterdaftar_tpp_memenuhi_syarat>0?number_format(($Grandjumlah_tpp_memenuhi_syarat / $Grandterdaftar_tpp_memenuhi_syarat) * 100, 2) . '%':0}}</th>
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

                        let properti = Object.keys(res);
                        let nilaiProperti = Object.values(res);

                        for (let i = 1; i < properti.length; i++) {
                            $('#' + Object.keys(res)[i]).text(nilaiProperti[i]);
                        }
                    }
                });
                // console.log(name, value, id);
            })



            $("#filter").click(function() {
                let year = $("#tahun").val();
                window.location.href = "{{ url($route) }}?year=" + year;
            })
        </script>
    @endpush
@endsection
