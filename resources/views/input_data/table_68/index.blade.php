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
                            <li class="breadcrumb-item active">JUMLAH KASUS AFP</li>
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
                                @if(Auth::user()->downloadFile('Table68', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table68" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table68', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table68', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table68" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table68', Session::get('year')) && Auth::user()->downloadFile('Table68', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table68', Session::get('year'))->file_path.Auth::user()->downloadFile('Table68', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table68.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table68.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                            </div>
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
                                        <th rowspan="3" >JUMLAH PENDUDUK < 15 TAHUN</th>
                                        <th rowspan="3" >"JUMLAH KASUS AFP (NON POLIO)"</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="2">Lock data</th>
                                            <th>Lock upload</th>
                                            <th>File Download</th>
                                            <th>Detail Desa</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $Grandjumlah_penduduk_15 = 0;
                                        $Grandjumlah_kasus_afp = 0;
                                        $AffRate = 0;
                                    @endphp
                                    @role('Admin|superadmin')
                                        @foreach ($unit_kerja as $key => $item)
                                            <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->kecamatan }}</td>
                                                <td class="unit_kerja">{{ $item->nama }}</td>
                                                <td>
                                                    @php
                                                        $jumlah_penduduk_15 = $item->unitKerjaAmbilPart2('filterTable68', Session::get('year'), 'jumlah_penduduk_15')['total'];
                                                        $Grandjumlah_penduduk_15 += $jumlah_penduduk_15;
                                                        echo $jumlah_penduduk_15;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $jumlah_kasus_afp = $item->unitKerjaAmbilPart2('filterTable68', Session::get('year'), 'jumlah_kasus_afp')['total'];
                                                        $Grandjumlah_kasus_afp += $jumlah_kasus_afp;
                                                        echo $jumlah_kasus_afp;
                                                    @endphp
                                                </td>
                                                <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable68') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                                @if(isset($item->user) && $item->user->downloadFile('Table68', Session::get('year')))
                                                <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table68', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                                @elseif(isset($item->user) && !$item->user->downloadFile('Table68', Session::get('year')))
                                                <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                                @else
                                                <td>-</td>
                                                @endif
                                                @if(isset($item->user) && $item->user->hasFile('Table68', Session::get('year')))
                                                <td>
                                                    @if($item->user->downloadFile('Table68', Session::get('year'))->file_name != "-")
                                                    <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table68', Session::get('year'))->file_path.$item->user->downloadFile('Table68', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <th id="Grandjumlah_penduduk_15">{{$Grandjumlah_penduduk_15}}</th>
                                            <th id="Grandjumlah_kasus_afp">{{$Grandjumlah_kasus_afp}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="4">AFP RATE (NON POLIO) PER 100.000 PENDUDUK USIA < 15 TAHUN</th>
                                            <th id="AffRate">{{ ($Grandjumlah_kasus_afp / $Grandjumlah_penduduk_15) * 100000 }}</th>
                                        </tr>
                                    @endrole

                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable68(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable68(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jumlah_penduduk_15 = $item
                                                                ->filterTable68(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_penduduk_15;
                                                            $Grandjumlah_penduduk_15 += $jumlah_penduduk_15;
                                                        @endphp
                                                        <input type="number" name="jumlah_penduduk_15" {{$isDisabled}}
                                                            id="{{ $item->filterTable68(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $jumlah_penduduk_15 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_kasus_afp = $item
                                                                ->filterTable68(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_kasus_afp;
                                                            $Grandjumlah_kasus_afp += $jumlah_kasus_afp;
                                                        @endphp
                                                        <input type="number" name="jumlah_kasus_afp" {{$isDisabled}}
                                                            id="{{ $item->filterTable68(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $jumlah_kasus_afp }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="2">Jumlah</th>
                                            <th id="Grandjumlah_penduduk_15">{{$Grandjumlah_penduduk_15}}</th>
                                            <th id="Grandjumlah_kasus_afp">{{$Grandjumlah_kasus_afp}}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">AFP RATE (NON POLIO) PER 100.000 PENDUDUK USIA < 15 TAHUN</th>
                                            <th id="AffRate">{{ $Grandjumlah_penduduk_15>0?($Grandjumlah_kasus_afp / $Grandjumlah_penduduk_15) * 100000:0 }}</th>
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
                        // $('#pl_pb_' + id).text(res.pl_pb_);
                        // $('#pl_mb_' + id).text(res.pl_mb_);
                        // $('#ll_PBMB_' + id).text(res.ll_PBMB_);
                        // $('#pp_PBMB_' + id).text(res.pp_PBMB_);
                        // $('#pl_PBMB_' + id).text(res.pl_PBMB_);

                        $('#Grandjumlah_penduduk_15').text(res.Grandjumlah_penduduk_15);
                        $('#Grandjumlah_kasus_afp').text(res.Grandjumlah_kasus_afp);
                        $('#AffRate').text(res.AffRate);
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
			'data'	: {'id': id, 'mainFilter': 'filterTable68', 'thirdFilter': 'filterTable64'},
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
            <td>${item.jumlah_penduduk_15}</td>
            <td>${item.jumlah_kasus_afp}</td>
             
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable68'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable68'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table68"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table68"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
