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
                            <li class="breadcrumb-item active">CAKUPAN DETEKSI DINI KANKER LEHER RAHIM</li>
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
                                <a type="button" class="btn btn-primary" href="{{ route('Table77.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th rowspan="2" style="vertical-align: middle">No</th>
                                        <th rowspan="2" style="vertical-align: middle">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="2" style="vertical-align: middle">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="2" style="vertical-align: middle">Desa</th>
                                        @endrole
                                        <th colspan="1" rowspan="2">PUSKESMAS MELAKSANAKAN KEGIATAN DETEKSI DINI IVA & SADANIS*</th>
                                        <th colspan="1" rowspan="2">"PEREMPUAN USIA 30-50 TAHUN"</th>
                                        <th colspan="2" rowspan="1">PEMERIKSAAN IVA	</th>
                                        <th colspan="2" rowspan="1">PEMERIKSAAN SADANIS</th>
                                        <th colspan="2" rowspan="1">IVA POSITIF</th>
                                        <th colspan="2" rowspan="1">CURIGA KANKER LEHER RAHIM</th>
                                        <th colspan="2" rowspan="1">KRIOTERAPI</th>
                                        <th colspan="2">IVA POSITIF DAN CURIGA KANKER LEHER RAHIM DIRUJUK</th>
                                        <th colspan="2">TUMOR/BENJOLAN</th>
                                        <th colspan="2">CURIGA KANKER PAYUDARA</th>
                                        <th colspan="2">TUMOR DAN CURIGA KANKER PAYUDARA DIRUJUK</th>

                                        @role('Admin|superadmin')
                                            <th rowspan="2">Lock data</th>
                                        @endrole
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
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandkegiatan_deteksi = 0;
                                        $Grandperempuan_30_50_tahun = 0;
                                        $Grandjumlah_iva = 0;
                                        $Grandjumlah_sadanis = 0;
                                        $Grandjumlah_iva_positif = 0;
                                        $Grandjumlah_curiga = 0;
                                        $Grandjumlah_krioterapi = 0;
                                        $Grandjumlah_iva_positif_dan_curiga_kanker_leher = 0;
                                        $Grandjumlah_tumor = 0;
                                        $Grandjumlah_kanker_payudara = 0;
                                        $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk = 0;
                                    @endphp
                                    @role('Admin|superadmin')

                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $kegiatan_deteksi = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'kegiatan_deteksi')['total'];
                                                    $Grandkegiatan_deteksi += $kegiatan_deteksi;

                                                    echo $kegiatan_deteksi;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $perempuan_30_50_tahun = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'perempuan_30_50_tahun')['total'];
                                                    $Grandperempuan_30_50_tahun += $perempuan_30_50_tahun;

                                                    echo $perempuan_30_50_tahun ;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_iva = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_iva')['total'];
                                                    $Grandjumlah_iva += $jumlah_iva;

                                                    echo $jumlah_iva;
                                                @endphp
                                            </td>
                                            <td id="persen_iva_">
                                                {{number_format(($jumlah_iva / $perempuan_30_50_tahun) * 100, 2) . '%'}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_sadanis = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_sadanis')['total'];
                                                    $Grandjumlah_sadanis += $jumlah_sadanis;

                                                    echo $jumlah_sadanis;
                                                @endphp
                                            </td>
                                            <td id="persen_sadanis_">
                                                {{$perempuan_30_50_tahun>0?number_format(($jumlah_sadanis / $perempuan_30_50_tahun) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_iva_positif = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_iva_positif')['total'];
                                                    $Grandjumlah_iva_positif += $jumlah_iva_positif;

                                                    echo $jumlah_iva_positif;
                                                @endphp
                                            </td>
                                            <td id="persen_iva_positif_">
                                                {{$jumlah_iva>0?number_format(($jumlah_iva_positif / $jumlah_iva) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_curiga = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_curiga')['total'];
                                                    $Grandjumlah_curiga += $jumlah_curiga;

                                                    echo $jumlah_curiga;
                                                @endphp
                                            </td>
                                            <td id="persen_curiga_">
                                                {{$jumlah_iva>0?number_format(($jumlah_curiga / $jumlah_iva) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_krioterapi = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_krioterapi')['total'];
                                                    $Grandjumlah_krioterapi += $jumlah_krioterapi;

                                                    echo $jumlah_krioterapi;
                                                @endphp
                                            </td>
                                            <td id="persen_krioterapi_">
                                                {{$jumlah_iva_positif>0?number_format(($jumlah_krioterapi / $jumlah_iva_positif) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_iva_positif_dan_curiga_kanker_leher = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_iva_positif_dan_curiga_kanker_leher')['total'];
                                                    $Grandjumlah_iva_positif_dan_curiga_kanker_leher += $jumlah_iva_positif_dan_curiga_kanker_leher;
                                                    echo $jumlah_iva_positif_dan_curiga_kanker_leher;
                                                @endphp
                                            </td>
                                            <td id="persen_iva_positif_dan_curiga_kanker_leher_">
                                                {{$jumlah_iva_positif - $jumlah_krioterapi + $jumlah_curiga>0?number_format(($jumlah_iva_positif_dan_curiga_kanker_leher / ($jumlah_iva_positif - $jumlah_krioterapi + $jumlah_curiga )) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_tumor = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_tumor')['total'];
                                                    $Grandjumlah_tumor += $jumlah_tumor;
                                                    echo $jumlah_tumor;
                                                @endphp
                                            </td>
                                            <td id="persen_tumor_">
                                                {{$jumlah_sadanis>0?number_format(($jumlah_tumor / $jumlah_sadanis) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_kanker_payudara = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_kanker_payudara')['total'];
                                                    $Grandjumlah_kanker_payudara += $jumlah_kanker_payudara;
                                                    echo $jumlah_kanker_payudara;
                                                @endphp
                                            </td>
                                            <td id="persen_kanker_payudara_">
                                                {{$jumlah_sadanis>0?number_format(($jumlah_kanker_payudara / $jumlah_sadanis) * 100, 2) . '%':0}}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_tumor_curiga_kanker_payudara_dirujuk = $item->unitKerjaAmbilPart2('filterTable77', app('request')->input('year'), 'jumlah_tumor_curiga_kanker_payudara_dirujuk')['total'];
                                                    $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk += $jumlah_tumor_curiga_kanker_payudara_dirujuk;
                                                    echo $jumlah_tumor_curiga_kanker_payudara_dirujuk;
                                                @endphp
                                            </td>
                                            <td id="persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_">
                                                {{$jumlah_tumor + $jumlah_kanker_payudara>0?number_format(($jumlah_tumor_curiga_kanker_payudara_dirujuk / ($jumlah_tumor + $jumlah_kanker_payudara )) * 100, 2) . '%':0}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable77(app('request')->input('year'), $item->id))
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $kegiatan_deteksi = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->kegiatan_deteksi;
                                                            $Grandkegiatan_deteksi += $kegiatan_deteksi;
                                                        @endphp
                                                        <input type="number" name="kegiatan_deteksi"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $kegiatan_deteksi }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $perempuan_30_50_tahun = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->perempuan_30_50_tahun;
                                                            $Grandperempuan_30_50_tahun += $perempuan_30_50_tahun;
                                                        @endphp
                                                        <input type="number" name="perempuan_30_50_tahun"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $perempuan_30_50_tahun }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_iva = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_iva;
                                                            $Grandjumlah_iva += $jumlah_iva;
                                                        @endphp
                                                        <input type="number" name="jumlah_iva"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_iva }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_iva_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$perempuan_30_50_tahun>0?number_format(($jumlah_iva / $perempuan_30_50_tahun) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_sadanis = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_sadanis;
                                                            $Grandjumlah_sadanis += $jumlah_sadanis;
                                                        @endphp
                                                        <input type="number" name="jumlah_sadanis"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_sadanis }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_sadanis_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$perempuan_30_50_tahun>0?number_format(($jumlah_sadanis / $perempuan_30_50_tahun) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_iva_positif = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_iva_positif;
                                                            $Grandjumlah_iva_positif += $jumlah_iva_positif;
                                                        @endphp
                                                        <input type="number" name="jumlah_iva_positif"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_iva_positif }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_iva_positif_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_iva>0?number_format(($jumlah_iva_positif / $jumlah_iva) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_curiga = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_curiga;
                                                            $Grandjumlah_curiga += $jumlah_curiga;
                                                        @endphp
                                                        <input type="number" name="jumlah_curiga"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_curiga }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_curiga_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_iva>0?number_format(($jumlah_curiga / $jumlah_iva) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_krioterapi = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_krioterapi;
                                                            $Grandjumlah_krioterapi += $jumlah_krioterapi;
                                                        @endphp
                                                        <input type="number" name="jumlah_krioterapi"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_krioterapi }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_krioterapi_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_iva_positif>0?number_format(($jumlah_krioterapi / $jumlah_iva_positif) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_iva_positif_dan_curiga_kanker_leher = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_iva_positif_dan_curiga_kanker_leher;
                                                            $Grandjumlah_iva_positif_dan_curiga_kanker_leher += $jumlah_iva_positif_dan_curiga_kanker_leher;
                                                        @endphp
                                                        <input type="number" name="jumlah_iva_positif_dan_curiga_kanker_leher"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_iva_positif_dan_curiga_kanker_leher }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_iva_positif_dan_curiga_kanker_leher_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_iva_positif - $jumlah_krioterapi + $jumlah_curiga>0?number_format(($jumlah_iva_positif_dan_curiga_kanker_leher / ($jumlah_iva_positif - $jumlah_krioterapi + $jumlah_curiga )) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_tumor = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_tumor;
                                                            $Grandjumlah_tumor += $jumlah_tumor;
                                                        @endphp
                                                        <input type="number" name="jumlah_tumor"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_tumor }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_tumor_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_sadanis>0?number_format(($jumlah_tumor / $jumlah_sadanis) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_kanker_payudara = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_kanker_payudara;
                                                            $Grandjumlah_kanker_payudara += $jumlah_kanker_payudara;
                                                        @endphp
                                                        <input type="number" name="jumlah_kanker_payudara"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_kanker_payudara }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_kanker_payudara_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_sadanis>0?number_format(($jumlah_kanker_payudara / $jumlah_sadanis) * 100, 2) . '%':0}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_tumor_curiga_kanker_payudara_dirujuk = $item
                                                                ->filterTable77(
                                                                    app('request')->input('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_tumor_curiga_kanker_payudara_dirujuk;
                                                            $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk += $jumlah_tumor_curiga_kanker_payudara_dirujuk;

                                                        @endphp
                                                        <input type="number" name="jumlah_tumor_curiga_kanker_payudara_dirujuk"
                                                        id="{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}"
                                                        value="{{ $jumlah_tumor_curiga_kanker_payudara_dirujuk }}"
                                                        class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_{{ $item->filterTable77(app('request')->input('year'), $item->id)->id }}">
                                                        {{$jumlah_tumor + $jumlah_kanker_payudara>0?number_format(($jumlah_tumor_curiga_kanker_payudara_dirujuk / ($jumlah_tumor + $jumlah_kanker_payudara )) * 100, 2) . '%':0}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endrole
                                    <tr>
                                        <th colspan="3">Jumlah</th>
                                        <th id="Grandkegiatan_deteksi">{{ $Grandkegiatan_deteksi }} </th>
                                        <th id="Grandperempuan_30_50_tahun">{{ $Grandperempuan_30_50_tahun }} </th>
                                        <th id="Grandjumlah_iva">{{ $Grandjumlah_iva }} </th>
                                        <th id="Grand_persen_iva_">{{$Grandperempuan_30_50_tahun>0?number_format(($Grandjumlah_iva / $Grandperempuan_30_50_tahun) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_sadanis">{{ $Grandjumlah_sadanis }} </th>
                                        <th id="Grand_persen_sadanis_">{{$Grandperempuan_30_50_tahun>0?number_format(($Grandjumlah_sadanis / $Grandperempuan_30_50_tahun) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_iva_positif">{{ $Grandjumlah_iva_positif }} </th>
                                        <th id="Grand_persen_iva_positif_">{{$Grandjumlah_iva>0?number_format(($Grandjumlah_iva_positif / $Grandjumlah_iva) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_curiga">{{ $Grandjumlah_curiga }} </th>
                                        <th id="Grand_persen_curiga_">{{$Grandjumlah_iva>0?number_format(($Grandjumlah_curiga / $Grandjumlah_iva) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_krioterapi">{{ $Grandjumlah_krioterapi }} </th>
                                        <th id="Grand_persen_krioterapi_">{{$Grandjumlah_iva_positif>0?number_format(($Grandjumlah_krioterapi / $Grandjumlah_iva_positif) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_iva_positif_dan_curiga_kanker_leher">{{ $Grandjumlah_iva_positif_dan_curiga_kanker_leher }} </th>
                                        <th id="Grand_persen_iva_positif_dan_curiga_kanker_leher_">{{$Grandjumlah_iva_positif - $Grandjumlah_krioterapi + $Grandjumlah_curiga>0?number_format(($Grandjumlah_iva_positif_dan_curiga_kanker_leher / ($Grandjumlah_iva_positif - $Grandjumlah_krioterapi + $Grandjumlah_curiga )) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_tumor">{{ $Grandjumlah_tumor }} </th>
                                        <th id="Grand_persen_tumor_">{{$Grandjumlah_sadanis>0?number_format(($Grandjumlah_tumor / $Grandjumlah_sadanis) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_kanker_payudara">{{ $Grandjumlah_kanker_payudara }} </th>
                                        <th id="Grand_persen_kanker_payudara_">{{$Grandjumlah_sadanis>0?number_format(($Grandjumlah_kanker_payudara / $Grandjumlah_sadanis) * 100, 2) . '%':0}}</th>
                                        <th id="Grandjumlah_tumor_curiga_kanker_payudara_dirujuk">{{ $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk }} </th>
                                        <th id="Grand_persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_">{{$Grandjumlah_tumor + $Grandjumlah_kanker_payudara>0?number_format(($Grandjumlah_tumor_curiga_kanker_payudara_dirujuk / ($Grandjumlah_tumor + $Grandjumlah_kanker_payudara )) * 100, 2) . '%':0}}</th>
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
