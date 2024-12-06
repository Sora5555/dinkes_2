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
                            <li class="breadcrumb-item active">Kasus baru kusta Cacat</li>
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
                                @if(Auth::user()->downloadFile('Table65', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table65" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table65', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table65', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table65" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table65', Session::get('year')) && Auth::user()->downloadFile('Table65', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table65', Session::get('year'))->file_path.Auth::user()->downloadFile('Table65', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table65.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table65.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th colspan="8">KASUS BARU</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                            <th rowspan="3">Lock upload</th>
                                            <th rowspan="3">File Download</th>
                                            <th rowspan="3">Detail Desa</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th rowspan="2">Penderita Kusta</th>
                                        <th colspan="2">Cacat Tingkat 0</th>
                                        <th colspan="2">Cacat Tingkat 2</th>
                                        <th colspan="2">Penderita Kusta Anak < 15 tahun</th>
                                        <th>PENDERITA KUSTA ANAK < 15 TAHUN DENGAN CACAT TINGKAT 2</th>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <th>%</th>
                                        <th>Jumlah</th>
                                        <th>%</th>
                                        <th>Jumlah</th>
                                        <th>%</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                    @php
                                        $GrandPenderitaKusta = 0;
                                        $GrandJumlah_cacat_0 = 0;
                                        $GrandJumlah_cacat_1 = 0;
                                        $GrandPenderita_kusta_1 = 0;
                                        $GrandPenderita_kusta_2 = 0;
                                    @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td id="penderita_kusta_">
                                                @php
                                                    $penderitaKusta =  $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderitaKusta,id')['total'];
                                                    $GrandPenderitaKusta += $penderitaKusta;

                                                    echo $penderitaKusta;
                                                @endphp
                                            </td>
                                            <td id="jumlah_cacat_0_">
                                                @php
                                                    $jumlah_cacat_0 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'jumlah_cacat_0')['total'];
                                                    $GrandJumlah_cacat_0 += $jumlah_cacat_0;

                                                    echo $jumlah_cacat_0;
                                                @endphp
                                            </td>
                                            <td id="persen_jumlah_cacat_0_">
                                                {{ $penderitaKusta > 0?number_format(($jumlah_cacat_0 / $penderitaKusta) * 100, 2)."%":0 }}
                                            </td>
                                            <td id="jumlah_cacat_1_">
                                                @php
                                                    $jumlah_cacat_1 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'jumlah_cacat_1')['total'];
                                                    $GrandJumlah_cacat_1 += $jumlah_cacat_1;

                                                    echo $jumlah_cacat_1;
                                                @endphp
                                            </td>
                                            <td id="persen_jumlah_cacat_1_">
                                                {{ $penderitaKusta > 0?number_format(($jumlah_cacat_1 / $penderitaKusta) * 100, 2)."%":0 }}
                                            </td>
                                            <td id="penderita_kusta_1_">
                                                @php
                                                    $penderita_kusta_1 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderita_kusta_1')['total'];
                                                    $GrandPenderita_kusta_1 += $penderita_kusta_1;
                                                    echo $penderita_kusta_1;
                                                @endphp
                                            </td>
                                            <td id="persen_penderita_kusta_1_">
                                                {{$penderitaKusta > 0? number_format(($penderita_kusta_1 / $penderitaKusta) * 100, 2)."%":0 }}
                                            </td>
                                            <td id="penderita_kusta_2_">
                                                @php
                                                    $penderita_kusta_2 = $item->unitKerjaAmbilPart2('filterTable65', Session::get('year'), 'penderita_kusta_2')['total'];
                                                    $GrandPenderita_kusta_2 += $penderita_kusta_2;
                                                    echo $penderita_kusta_2;
                                                @endphp
                                            </td>
                                            <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable65') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                            @if(isset($item->user) && $item->user->downloadFile('Table65', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table65', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @elseif(isset($item->user) && !$item->user->downloadFile('Table65', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            @if(isset($item->user) && $item->user->hasFile('Table65', Session::get('year')))
                                            <td>
                                                @if($item->user->downloadFile('Table65', Session::get('year'))->file_name != "-")
                                                <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table65', Session::get('year'))->file_path.$item->user->downloadFile('Table65', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <th colspan="3">JUMLAH </th>
                                            <th id="GrandPenderitaKusta">{{$GrandPenderitaKusta}}</th>
                                            <th id="GrandJumlah_cacat_0">{{$GrandJumlah_cacat_0}}</th>
                                            <th id="PGrandCacat0">
                                                {{ $GrandPenderitaKusta > 0?number_format(($GrandJumlah_cacat_0 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandJumlah_cacat_1">{{$GrandJumlah_cacat_1}}</th>
                                            <th id="PGrandCacat1">
                                                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandPenderita_kusta_1">{{$GrandPenderita_kusta_1}}</th>
                                            <th id="PGrandPenderitaKusta1">
                                                {{ $GrandPenderitaKusta>0?number_format(($GrandPenderita_kusta_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandPenderita_kusta_2">{{$GrandPenderita_kusta_2}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">ANGKA CACAT TINGKAT 2 PER 1.000.000 PENDUDUK</th>
                                            <th colspan="3"></th>
                                            <th id="angka_cacat_2_penduduk">
                                                {{ $jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki > 0?($GrandJumlah_cacat_1 / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000:0}}
                                            </th>
                                            <th colspan="4"></th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandPenderitaKusta = 0;
                                            $GrandJumlah_cacat_0 = 0;
                                            $GrandJumlah_cacat_1 = 0;
                                            $GrandPenderita_kusta_1 = 0;
                                            $GrandPenderita_kusta_2 = 0;
                                        @endphp

                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable65(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable65(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td id="penderita_kusta_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $penderitaKusta = $item->filterTable65(Session::get('year'), $item->id)->PenderitaKusta($item->id);
                                                            $GrandPenderitaKusta += $penderitaKusta;
                                                        @endphp
                                                        <input type="number" name="penderitaKusta" {{$isDisabled}}
                                                            id="{{ $item->filterTable65(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $penderitaKusta }}"
                                                            class="form-control data-input" style="border: none" readonly>
                                                    </td>
                                                    <td id="jumlah_cacat_0_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_cacat_0 = $item->filterTable65(Session::get('year'), $item->id)->jumlah_cacat_0;
                                                            $GrandJumlah_cacat_0 += $jumlah_cacat_0;
                                                        @endphp
                                                        <input type="number" name="jumlah_cacat_0" {{$isDisabled}}
                                                            id="{{ $item->filterTable65(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $jumlah_cacat_0 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_jumlah_cacat_0_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        {{ $penderitaKusta?number_format(($jumlah_cacat_0 / $penderitaKusta) * 100, 2)."%":0 }}
                                                    </td>
                                                    <td id="jumlah_cacat_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_cacat_1 = $item->filterTable65(Session::get('year'), $item->id)->jumlah_cacat_1;
                                                            $GrandJumlah_cacat_1 += $jumlah_cacat_1;
                                                        @endphp
                                                        <input type="number" name="jumlah_cacat_1" {{$isDisabled}}
                                                            id="{{ $item->filterTable65(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $jumlah_cacat_1 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_jumlah_cacat_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        {{ $penderitaKusta > 0?number_format(($jumlah_cacat_1 / $penderitaKusta) * 100, 2)."%":0 }}
                                                    </td>
                                                    <td id="penderita_kusta_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $penderita_kusta_1 = $item->filterTable65(Session::get('year'), $item->id)->penderita_kusta_1;
                                                            $GrandPenderita_kusta_1 += $penderita_kusta_1;
                                                        @endphp
                                                        <input type="number" name="penderita_kusta_1" {{$isDisabled}}
                                                            id="{{ $item->filterTable65(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $penderita_kusta_1 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_penderita_kusta_1_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        {{ $penderitaKusta>0?number_format(($penderita_kusta_1 / $penderitaKusta) * 100, 2)."%":0 }}
                                                    </td>
                                                    <td id="penderita_kusta_2_{{ $item->filterTable65(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $penderita_kusta_2 = $item->filterTable65(Session::get('year'), $item->id)->penderita_kusta_2;
                                                            $GrandPenderita_kusta_2 += $penderita_kusta_2;
                                                        @endphp
                                                        <input type="number" name="penderita_kusta_2" {{$isDisabled}}
                                                            id="{{ $item->filterTable65(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $penderita_kusta_2 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="3">JUMLAH </th>
                                            <th id="GrandPenderitaKusta">{{$GrandPenderitaKusta}}</th>
                                            <th id="GrandJumlah_cacat_0">{{$GrandJumlah_cacat_0}}</th>
                                            <th id="PGrandCacat0">
                                                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_0 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandJumlah_cacat_1">{{$GrandJumlah_cacat_1}}</th>
                                            <th id="PGrandCacat1">
                                                {{ $GrandPenderitaKusta>0?number_format(($GrandJumlah_cacat_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandPenderita_kusta_1">{{$GrandPenderita_kusta_1}}</th>
                                            <th id="PGrandPenderitaKusta1">
                                                {{ $GrandPenderitaKusta>0?number_format(($GrandPenderita_kusta_1 / $GrandPenderitaKusta) * 100, 2)."%":0 }}
                                            </th>
                                            <th id="GrandPenderita_kusta_2">{{$GrandPenderita_kusta_2}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">ANGKA CACAT TINGKAT 2 PER 1.000.000 PENDUDUK</th>
                                            <th colspan="3"></th>
                                            <th id="angka_cacat_2_penduduk">
                                                {{$jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki>0?($GrandJumlah_cacat_1 / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000:0}}
                                            </th>
                                            <th colspan="4"></th>
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
                        $('#persen_jumlah_cacat_0_' + id).text(res.persen_jumlah_cacat_0_);
                        $('#persen_jumlah_cacat_1_' + id).text(res.persen_jumlah_cacat_1_);
                        $('#persen_penderita_kusta_1_' + id).text(res.persen_penderita_kusta_1_);

                        $('#GrandPenderitaKusta').text(res.GrandPenderitaKusta);
                        $('#GrandJumlah_cacat_0').text(res.GrandJumlah_cacat_0);
                        $('#PGrandCacat0').text(res.PGrandCacat0);
                        $('#GrandJumlah_cacat_1').text(res.GrandJumlah_cacat_1);
                        $('#PGrandCacat1').text(res.PGrandCacat1);
                        $('#GrandPenderita_kusta_1').text(res.GrandPenderita_kusta_1);
                        $('#PGrandPenderitaKusta1').text(res.PGrandPenderitaKusta1);
                        $('#GrandPenderita_kusta_2').text(res.GrandPenderita_kusta_2);
                        $('#angka_cacat_2_penduduk').text(res.angka_cacat_2_penduduk);
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
			'data'	: {'id': id, 'mainFilter': 'filterTable65', 'thirdFilter': 'filterTable64'},
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
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb)}</td>
             <td>${item.jumlah_cacat_0}</td>
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb) > 0 ? (parseInt(item.jumlah_cacat_0)/(parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb))) * 100:0 }%</td>
             <td>${item.jumlah_cacat_1}</td>
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb) > 0 ? (parseInt(item.jumlah_cacat_1)/(parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb))) * 100:0 }%</td>
             <td>${item.penderita_kusta_1}</td>
             <td>${parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb) > 0 ? (parseInt(item.penderita_kusta_1)/(parseInt(item.l_mb) + parseInt(item.p_mb) + parseInt(item.l_pb) + parseInt(item.p_pb))) * 100:0 }%</td>
             <td>${item.penderita_kusta_2}</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable65'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable65'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table65"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table65"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
