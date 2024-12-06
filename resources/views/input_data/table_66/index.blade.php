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
                            <li class="breadcrumb-item active">Jumlah Kasus Terdaftar</li>
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
                                @if(Auth::user()->downloadFile('Table66', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table66" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table66', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table66', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table66" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table66', Session::get('year')) && Auth::user()->downloadFile('Table66', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table66', Session::get('year'))->file_path.Auth::user()->downloadFile('Table66', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table66.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table66.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th colspan="9">KASUS TERDAFTAR</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                            <th rowspan="3">Lock upload</th>
                                            <th rowspan="3">File Download</th>
                                            <th rowspan="3">Detail Desa</th>
                                        @endrole
                                    </tr>
                                    <TR>
                                        <TH colspan="3">PAUSI BASILER / KUSTA KERING</TH>
                                        <TH colspan="3">MULTI BASILER / KUSTA BASAH</TH>
                                        <TH colspan="3">JUMLAH</TH>
                                    </TR>
                                    <TR>
                                        <TH>ANAK</TH>
                                        <TH>DEWASA</TH>
                                        <TH>TOTAL</TH>
                                        <TH>ANAK</TH>
                                        <TH>DEWASA</TH>
                                        <TH>TOTAL</TH>
                                        <TH>ANAK</TH>
                                        <TH>DEWASA</TH>
                                        <TH>TOTAL</TH>
                                    </TR>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                        @php
                                            $GrandPausi_anak =  0;
                                            $GrandPausi_dewasa =  0;
                                            $GrandPausi_total =  0;
                                            $GrandMulti_anak =  0;
                                            $GrandMulti_dewasa =  0;
                                            $GrandMulti_total =  0;
                                            $GrandJumlah_anak =  0;
                                            $GrandJumlah_dewasa = 0;
                                            $GrandJumlah_total =  0;
                                        @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $pausi_anak = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'pausi_anak')['total'];
                                                    $GrandPausi_anak += $pausi_anak;
                                                    // $GrandJumlahBayi += $jumlah_bayi;
                                                    // $GrandTotalIbuHamil += $totalIbuHamil;
                                                    echo $pausi_anak;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $pausi_dewasa = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'pausi_dewasa')['total'];

                                                    $GrandPausi_dewasa += $pausi_dewasa;
                                                    echo $pausi_dewasa;
                                                @endphp
                                            </td>
                                            <td id="total_pausi">
                                                @php
                                                    $GrandPausi_total += $pausi_anak + $pausi_dewasa;
                                                @endphp
                                                {{$pausi_anak + $pausi_dewasa}}
                                            </td>
                                            <td>
                                                @php
                                                    $multi_anak = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'multi_anak')['total'];

                                                    $GrandMulti_anak += $multi_anak;
                                                    echo $multi_anak;
                                                    // $GrandJumlahBayi += $jumlah_bayi;
                                                    // $GrandTotalIbuHamil += $totalIbuHamil;
                                                @endphp
                                            </td>
                                            <td>
                                                @php
                                                    $multi_dewasa = $item->unitKerjaAmbilPart2('filterTable66', Session::get('year'), 'multi_dewasa')['total'];

                                                    $GrandMulti_dewasa += $multi_dewasa;
                                                    echo $multi_dewasa;
                                                @endphp
                                            </td>
                                            <td id="total_multi">
                                                @php
                                                    $GrandMulti_total += $multi_anak + $multi_dewasa;
                                                @endphp
                                                {{$multi_anak + $multi_dewasa}}
                                            </td>
                                            <td id="jumlah_anak">
                                                @php
                                                    $jumlah_anak = $multi_anak + $pausi_anak;
                                                    echo $jumlah_anak;

                                                    $GrandJumlah_anak += $jumlah_anak;
                                                @endphp
                                            </td>
                                            <td id="jumlah_dewasa">
                                                @php
                                                    $jumlah_dewasa = $multi_dewasa + $pausi_dewasa;
                                                    echo $jumlah_dewasa;


                                                    $GrandJumlah_dewasa += $jumlah_dewasa;
                                                @endphp
                                            </td>
                                            <td id="jumlah_total">
                                                @php
                                                    $jumlah_total = $jumlah_anak + $jumlah_dewasa;
                                                    echo $jumlah_total;

                                                    $GrandJumlah_total += $jumlah_total;

                                                @endphp
                                            </td>
                                            <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable66') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                            @if(isset($item->user) && $item->user->downloadFile('Table66', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table66', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @elseif(isset($item->user) && !$item->user->downloadFile('Table66', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            @if(isset($item->user) && $item->user->hasFile('Table66', Session::get('year')))
                                            <td>
                                                @if($item->user->downloadFile('Table66', Session::get('year'))->file_name != "-")
                                                <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table66', Session::get('year'))->file_path.$item->user->downloadFile('Table66', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <th id="GrandPausi_anak">{{    $GrandPausi_anak}}</th>
                                            <th id="GrandPausi_dewasa">{{  $GrandPausi_dewasa}}</th>
                                            <th id="GrandPausi_total">{{   $GrandPausi_total}}</th>
                                            <th id="GrandMulti_anak">{{    $GrandMulti_anak}}</th>
                                            <th id="GrandMulti_dewasa">{{  $GrandMulti_dewasa}}</th>
                                            <th id="GrandMulti_total">{{   $GrandMulti_total}}</th>
                                            <th id="GrandJumlah_anak">{{   $GrandJumlah_anak}}</th>
                                            <th id="GrandJumlah_dewasa">{{ $GrandJumlah_dewasa}}</th>
                                            <th id="GrandJumlah_total">{{  $GrandJumlah_total}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">ANGKA PREVALENSI PER 10.000 PENDUDUK</th>
                                            <th colspan="8"></th>
                                            <th id="angka_prevalensi">
                                                {{($GrandJumlah_total / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 10000}}
                                            </th>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandPausi_anak =  0;
                                            $GrandPausi_dewasa =  0;
                                            $GrandPausi_total =  0;
                                            $GrandMulti_anak =  0;
                                            $GrandMulti_dewasa =  0;
                                            $GrandMulti_total =  0;
                                            $GrandJumlah_anak =  0;
                                            $GrandJumlah_dewasa = 0;
                                            $GrandJumlah_total =  0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable66(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable66(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $pausi_anak = $item
                                                                ->filterTable66(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->pausi_anak;
                                                                $GrandPausi_anak += $pausi_anak;
                                                            // $GrandJumlahBayi += $jumlah_bayi;
                                                            // $GrandTotalIbuHamil += $totalIbuHamil;
                                                        @endphp
                                                        {{-- {{ $totalIbuHamil }} --}}
                                                        <input type="number" name="pausi_anak" {{$isDisabled}}
                                                            id="{{ $item->filterTable66(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $pausi_anak }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $pausi_dewasa = $item->filterTable66(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->pausi_dewasa;

                                                            $GrandPausi_dewasa += $pausi_dewasa;
                                                        @endphp
                                                        <input type="number" name="pausi_dewasa" {{$isDisabled}}
                                                            id="{{ $item->filterTable66(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $pausi_dewasa }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="total_pausi{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $GrandPausi_total += $pausi_anak + $pausi_dewasa;
                                                        @endphp
                                                        {{$pausi_anak + $pausi_dewasa}}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $multi_anak = $item
                                                                ->filterTable66(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->multi_anak;

                                                            $GrandMulti_anak += $multi_anak;
                                                            // $GrandJumlahBayi += $jumlah_bayi;
                                                            // $GrandTotalIbuHamil += $totalIbuHamil;
                                                        @endphp
                                                        {{-- {{ $totalIbuHamil }} --}}
                                                        <input type="number" name="multi_anak" {{$isDisabled}}
                                                            id="{{ $item->filterTable66(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $multi_anak }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $multi_dewasa = $item->filterTable66(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->multi_dewasa;

                                                            $GrandMulti_dewasa += $multi_dewasa;
                                                        @endphp
                                                        <input type="number" name="multi_dewasa" {{$isDisabled}}
                                                            id="{{ $item->filterTable66(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $multi_dewasa }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="total_multi{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $GrandMulti_total += $multi_anak + $multi_dewasa;
                                                        @endphp
                                                        {{$multi_anak + $multi_dewasa}}
                                                    </td>
                                                    <td id="jumlah_anak{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_anak = $multi_anak + $pausi_anak;
                                                            echo $jumlah_anak;

                                                            $GrandJumlah_anak += $jumlah_anak;
                                                        @endphp
                                                    </td>
                                                    <td id="jumlah_dewasa{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_dewasa = $multi_dewasa + $pausi_dewasa;
                                                            echo $jumlah_dewasa;


                                                            $GrandJumlah_dewasa += $jumlah_dewasa;
                                                        @endphp
                                                    </td>
                                                    <td id="jumlah_total{{ $item->filterTable66(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah_total = $jumlah_anak + $jumlah_dewasa;
                                                            echo $jumlah_total;

                                                            $GrandJumlah_total += $jumlah_total;

                                                        @endphp
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="3">JUMLAH</th>
                                            <th id="GrandPausi_anak">{{    $GrandPausi_anak}}</th>
                                            <th id="GrandPausi_dewasa">{{  $GrandPausi_dewasa}}</th>
                                            <th id="GrandPausi_total">{{   $GrandPausi_total}}</th>
                                            <th id="GrandMulti_anak">{{    $GrandMulti_anak}}</th>
                                            <th id="GrandMulti_dewasa">{{  $GrandMulti_dewasa}}</th>
                                            <th id="GrandMulti_total">{{   $GrandMulti_total}}</th>
                                            <th id="GrandJumlah_anak">{{   $GrandJumlah_anak}}</th>
                                            <th id="GrandJumlah_dewasa">{{ $GrandJumlah_dewasa}}</th>
                                            <th id="GrandJumlah_total">{{  $GrandJumlah_total}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">ANGKA PREVALENSI PER 10.000 PENDUDUK</th>
                                            <th colspan="8"></th>
                                            <th id="angka_prevalensi">
                                                {{($GrandJumlah_total / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 10000}}
                                            </th>
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
                        $('#total_pausi' + id).text(res.total_pausi);
                        $('#total_multi' + id).text(res.total_multi);
                        $('#jumlah_anak' + id).text(res.jumlah_anak);
                        $('#jumlah_dewasa' + id).text(res.jumlah_dewasa);
                        $('#jumlah_total' + id).text(res.jumlah_total);

                        $('#GrandPausi_anak').text(res.GrandPausi_anak);
                        $('#GrandPausi_dewasa').text(res.GrandPausi_dewasa);
                        $('#GrandPausi_total').text(res.GrandPausi_total);
                        $('#GrandMulti_anak').text(res.GrandMulti_anak);
                        $('#GrandMulti_dewasa').text(res.GrandMulti_dewasa);
                        $('#GrandMulti_total').text(res.GrandMulti_total);
                        $('#GrandJumlah_anak').text(res.GrandJumlah_anak);
                        $('#GrandJumlah_dewasa').text(res.GrandJumlah_dewasa);
                        $('#GrandJumlah_total').text(res.GrandJumlah_total);

                        $('#angka_prevalensi').text(res.angka_prevalensi);
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
			'data'	: {'id': id, 'mainFilter': 'filterTable66', 'thirdFilter': 'filterTable64'},
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
            <td>${item.pausi_anak}</td>
            <td>${item.pausi_dewasa}</td>
             <td>${parseInt(item.pausi_anak) + parseInt(item.pausi_dewasa)}</td>
            
             <td>${item.multi_anak}</td>
            <td>${item.multi_dewasa}</td>
             <td>${parseInt(item.multi_anak) + parseInt(item.multi_dewasa)}</td>
             <td>${parseInt(item.multi_anak) + parseInt(item.pausi_anak)}</td>
             <td>${parseInt(item.multi_dewasa) + parseInt(item.pausi_dewasa)}</td>
             <td>${parseInt(item.multi_dewasa) + parseInt(item.pausi_dewasa) + parseInt(item.multi_anak) + parseInt(item.pausi_anak)}</td>
             
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable66'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable66'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table66"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table66"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
