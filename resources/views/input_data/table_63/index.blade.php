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
                            <li class="breadcrumb-item active">Jumlah Bayi .....</li>
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
                                @if(Auth::user()->downloadFile('Table63', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table63" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('Table63', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('Table63', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="Table63" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('Table63', Session::get('year')) && Auth::user()->downloadFile('Table63', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('Table63', Session::get('year'))->file_path.Auth::user()->downloadFile('Table63', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('Table63.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('Table63.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
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
                                        <th rowspan="3" style="vertical-align: middle">JUMLAH BAYI YANG LAHIR DARI IBU HBsAg Reaktif</th>
                                        <th colspan="6">JUMLAH BAYI YANG LAHIR DARI IBU  HBsAg REAKTIF MENDAPAT HBIG</th>
                                        @role('Admin|superadmin')
                                            <th rowspan="3">Lock data</th>
                                            <th rowspan="3">Lock upload</th>
                                            <th rowspan="3">File Download</th>
                                            <th rowspan="3">Detail Desa</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th colspan="2">< 24 Jam</th>
                                        <th colspan="2">> 24 Jam</th>
                                        <th colspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                        <th colspan="1">JUMLAH</th>
                                        <th colspan="1">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                    @php
                                    $GrandJumlahBayi = 0;
                                    $GrandJumlahK24 = 0;
                                    $GrandJumlahB24 = 0;
                                @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                        <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td class="unit_kerja">{{ $item->nama }}</td>
                                            <td>
                                                @php
                                                    $jumlah_bayi = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year'), 'jumlah_bayi')['total'];
                                                @endphp
                                                {{ $jumlah_bayi }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_k_24 = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year'), 'jumlah_k_24')['total'];
                                                    echo $jumlah_k_24;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi > 0?number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah_b_24 = $item->unitKerjaAmbilPart2('filterTable63', Session::get('year'),  'jumlah_b_24')['total'];
                                                    $GrandJumlahB24 += $jumlah_b_24;
                                                    echo $jumlah_b_24;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi>0?number_format(($jumlah_b_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td>
                                                @php
                                                    $jumlah = $jumlah_b_24 + $jumlah_k_24;
                                                    echo $jumlah;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ $jumlah_bayi>0?number_format(($jumlah / $jumlah_bayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterTable63') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                            @if(isset($item->user) && $item->user->downloadFile('Table63', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('Table63', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @elseif(isset($item->user) && !$item->user->downloadFile('Table63', Session::get('year')))
                                            <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            @if(isset($item->user) && $item->user->hasFile('Table63', Session::get('year')))
                                            <td>
                                                @if($item->user->downloadFile('Table63', Session::get('year'))->file_name != "-")
                                                <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('Table63', Session::get('year'))->file_path.$item->user->downloadFile('Table63', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <td colspan="3">Jumlah</td>
                                            <td id="jumlah_bayi">{{ $GrandJumlahBayi }}</td>
                                            <td id="jumlah_k_24">{{ $GrandJumlahK24 }}</td>
                                            <td id="jumlah_k_p_24">
                                                {{ $GrandJumlahK24 > 0 && $GrandJumlahBayi > 0 ? number_format(($GrandJumlahK24 / $GrandJumlahBayi) * 100, 2).'%' : 0 }}
                                            </td>
                                            <td id="jumlah_b_24">
                                                {{ $GrandJumlahB24 }}
                                            </td>
                                            <td id="jumlah_b_p_24">
                                                {{ $GrandJumlahB24 > 0 && $GrandJumlahBayi > 0 ? number_format(($GrandJumlahB24 / $GrandJumlahBayi) * 100, 2).'%' : 0 }}
                                            </td>
                                            <td id="jumlah_kb_24">
                                                {{$GrandJumlahB24 + $GrandJumlahK24 }}
                                            </td>
                                            <td id="jumlah_kb_p_24">
                                                {{ $GrandJumlahB24 > 0 && $GrandJumlahK24 > 0 && $GrandJumlahBayi > 0 ? number_format((($GrandJumlahB24 + $GrandJumlahK24) / $GrandJumlahBayi) * 100, 2).'%' : 0}}
                                            </td>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandJumlahBayi = 0;
                                            $GrandJumlahK24 = 0;
                                            $GrandJumlahB24 = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterTable63(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterTable63(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $jumlah_bayi = $item
                                                                ->filterTable63(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->jumlah_bayi;
                                                            $GrandJumlahBayi += $jumlah_bayi;
                                                            // $GrandTotalIbuHamil += $totalIbuHamil;
                                                        @endphp
                                                        {{-- {{ $totalIbuHamil }} --}}
                                                        <input type="number" name="jumlah_bayi" {{$isDisabled}}
                                                            id="{{ $item->filterTable63(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable63(Session::get('year'), $item->id)->jumlah_bayi }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_k_24 = $item->filterTable63(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->jumlah_k_24;
                                                            $GrandJumlahK24 += $jumlah_k_24;
                                                        @endphp
                                                        <input type="number" name="jumlah_k_24" {{$isDisabled}}
                                                            id="{{ $item->filterTable63(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable63(Session::get('year'), $item->id)->jumlah_k_24 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_k_24_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi>0?number_format(($jumlah_k_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $jumlah_b_24 = $item->filterTable63(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->jumlah_b_24;
                                                            $GrandJumlahB24 += $jumlah_b_24;
                                                        @endphp
                                                        <input type="number" name="jumlah_b_24" {{$isDisabled}}
                                                            id="{{ $item->filterTable63(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterTable63(Session::get('year'), $item->id)->jumlah_b_24 }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td id="persen_b_24_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi>0?number_format(($jumlah_b_24 / $jumlah_bayi) * 100, 2).'%':0 }}
                                                    </td>
                                                    <td id="jumlah_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $jumlah = $jumlah_b_24 + $jumlah_k_24;
                                                            echo $jumlah;
                                                        @endphp
                                                    </td>
                                                    <td id="persen_jumlah_{{ $item->filterTable63(Session::get('year'), $item->id)->id }}">
                                                        {{ $jumlah_bayi>0?number_format(($jumlah / $jumlah_bayi) * 100, 2).'%':0 }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td id="jumlah_bayi">{{ $GrandJumlahBayi }}</td>
                                            <td id="jumlah_k_24">{{ $GrandJumlahK24 }}</td>
                                            <td id="jumlah_k_p_24">
                                                {{ $GrandJumlahBayi>0?number_format(($GrandJumlahK24 / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td id="jumlah_b_24">
                                                {{ $GrandJumlahB24 }}
                                            </td>
                                            <td id="jumlah_b_p_24">
                                                {{ $GrandJumlahBayi>0?number_format(($GrandJumlahB24 / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
                                            <td id="jumlah_kb_24">
                                                {{$GrandJumlahB24 + $GrandJumlahK24 }}
                                            </td>
                                            <td id="jumlah_kb_p_24">
                                                {{ $GrandJumlahBayi>0?number_format((($GrandJumlahB24 + $GrandJumlahK24) / $GrandJumlahBayi) * 100, 2).'%':0 }}
                                            </td>
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
                        $('#jumlah_' + id).text(res.jumlah);
                        $('#persen_k_24_' + id).text(res.persen_k_24);
                        $('#persen_b_24_' + id).text(res.persen_b_24);
                        $('#persen_jumlah_' + id).text(res.persen_jumlah);

                        $('#jumlah_bayi').text(res.jumlah_bayi);
                        $('#jumlah_k_24').text(res.jumlah_k_24);
                        $('#jumlah_k_p_24').text(res.jumlah_k_p_24);
                        $('#jumlah_b_24').text(res.jumlah_b_24);
                        $('#jumlah_b_p_24').text(res.jumlah_b_p_24);
                        $('#jumlah_kb_24').text(res.jumlah_kb_24);
                        $('#jumlah_kb_p_24').text(res.jumlah_kb_p_24);

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
			'data'	: {'id': id, 'mainFilter': 'filterTable63'},
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
             <td>${item.jumlah_bayi}</td>
             <td>${item.jumlah_k_24}</td>
             <td>${parseInt(item.jumlah_bayi) > 0 ?(parseInt(item.jumlah_k_24)/parseInt(item.jumlah_bayi)) * 100:0}%</td>
             <td>${item.jumlah_b_24}</td>
             <td>${parseInt(item.jumlah_bayi) > 0 ?(parseInt(item.jumlah_b_24)/parseInt(item.jumlah_bayi)) * 100:0}%</td>
             <td>${parseInt(item.jumlah_b_24) + parseInt(item.jumlah_k_24)}</td>
             <td>${parseInt(item.jumlah_bayi) > 0 ?((parseInt(item.jumlah_b_24) + parseInt(item.jumlah_k_24))/parseInt(item.jumlah_bayi)) * 100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterTable63'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterTable63'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "Table63"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "Table63"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
