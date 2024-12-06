@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('layouts.includes.sticky-table')

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Diabetes</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Input Data</a></li>
                            <li class="breadcrumb-item active">Diabetes</li>
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
                                @if(Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year')))
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="DeteksiDiniHepatitisBPadaIbuHamil" id="">
                                    <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>
    
                                </form>
                                @else
                                <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="name" value="DeteksiDiniHepatitisBPadaIbuHamil" id="">
                                    <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                    <button type="submit" class="btn btn-success">Upload</button>
    
                                </form>
                                @endif
                                @if(Auth::user()->hasFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year')) && Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_name != "-")
                                    <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_path.Auth::user()->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                                @endif
                                <a type="button" class="btn btn-warning" href="{{ route('DeteksiDiniHepatitisBPIB.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                                <a type="button" class="btn btn-primary" href="{{ route('DeteksiDiniHepatitisBPIB.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                            </div>
                        </div>
                        <div class="table-responsive lock-header">
                            <table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Kecamatan</th>
                                        @role('Admin|superadmin')
                                        <th rowspan="2">Puskesmas</th>
                                        @endrole
                                        @role('Puskesmas|Pihak Wajib Pajak')
                                        <th rowspan="2">Desa</th>
                                        @endrole
                                        <th rowspan="2">JUMLAH IBU HAMIL </th>
                                        <th colspan="3">JUMLAH IBU HAMIL DIPERIKSA</th>
                                        <th rowspan="2">% BUMIL DIPERIKSA</th>
                                        <th rowspan="2">% BUMIL REAKTIF </th>
                                        @role('Admin|superadmin')
                                            <th rowspan="2">Lock data</th>
                                            <th rowspan="2">Lock upload</th>
                                            <th rowspan="2">File Download</th>
                                            <th rowspan="2">Detail Desa</th>
                                        @endrole
                                    </tr>
                                    <tr>
                                        <th>REAKTIF</th>
                                        <th>NON REAKTIF</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @role('Admin|superadmin')
                                        @php
                                            $GrandTotalIbuHamil = 0;
                                            $GrandReaktif = 0;
                                            $GrandNonReaktif = 0;
                                            $GrandTotal = 0;
                                        @endphp
                                        @foreach ($unit_kerja as $key => $item)
                                            <tr style={{ $key % 2 == 0 ? 'background: gray' : '' }}>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->kecamatan }}</td>
                                                <td class="unit_kerja">{{ $item->nama }}</td>
                                                <td>
                                                    @php
                                                        $totalIbuHamil = $item->unitKerjaAmbil('filterDesa', Session::get('year'), 'jumlah_ibu_hamil')['total'];
                                                        $GrandTotalIbuHamil += $totalIbuHamil;
                                                    @endphp
                                                    {{ $totalIbuHamil }}
                                                    {{-- <input type="hidden" name="jumlah_ibu_hamil" value="{{ $totalIbuHamil }}"> --}}
                                                </td>
                                                <td>
                                                    @php
                                                        $reaktif = $item->unitKerjaAmbilPart2('filterDeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'), 'reaktif')['total'];
                                                        $GrandReaktif += $reaktif;
                                                        
                                                        echo $reaktif;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $non_reaktif = $item->unitKerjaAmbilPart2('filterDeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'), 'non_reaktif')['total'];;
                                                        $GrandNonReaktif += $non_reaktif;
                                                        echo $non_reaktif;
                                                    @endphp
                                                </td>
                                                <td
                                                    id="total_">
                                                    @php
                                                        $total = $reaktif + $non_reaktif;
                                                        $GrandTotal += $total;

                                                    @endphp
                                                    {{ $total }}
                                                </td>
                                                <td
                                                    id="bumil_diperiksa_">
                                                    @php
                                                        $bumilDiperiksa = $totalIbuHamil>0?($total / $totalIbuHamil) * 100:0;
                                                    @endphp
                                                    {{ number_format($bumilDiperiksa, 2) . '%' }}
                                                </td>
                                                <td
                                                    id="bumil_reaktif_">
                                                    {{ $total>0?number_format(($reaktif / $total) * 100, 2) . '%':0 }}
                                                </td>
                                                <td><input type="checkbox" name="lock" {{$item->general_lock_get2(Session::get('year'), 'filterDeteksiDiniHepatitisBPadaIbuHamil') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                        @if(isset($item->user) && $item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @elseif(isset($item->user) && !$item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year')))
                                        <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                        @else
                                        <td>-</td>
                                        @endif
                                        @if(isset($item->user) && $item->user->hasFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year')))
                                        <td>
                                            @if($item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_name != "-")
                                            <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_path.$item->user->downloadFile('DeteksiDiniHepatitisBPadaIbuHamil', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                            <td id="jumlah_ibu_hamil">{{ $GrandTotalIbuHamil }}</td>
                                            <td id="jumlah_reaktif">{{ $GrandReaktif }}</td>
                                            <td id="jumlah_non_reaktif">
                                                {{ $GrandNonReaktif }}
                                            </td>
                                            <td id="jumlah_total">
                                                {{ $GrandTotal }}
                                            </td>
                                            <td id="jumlah_bumil_diperiksa">
                                                {{ $GrandTotalIbuHamil>0?number_format($GrandTotal / $GrandTotalIbuHamil, 2) . '%':0 }}
                                            </td>
                                            <td id="jumlah_bumil_reaktif">
                                                {{ $GrandTotal>0?number_format($GrandReaktif / $GrandTotal, 2) . '%':0 }}
                                            </td>
                                        </tr>
                                    @endrole
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @php
                                            $GrandTotalIbuHamil = 0;
                                            $GrandReaktif = 0;
                                            $GrandNonReaktif = 0;
                                            $GrandTotal = 0;
                                        @endphp
                                        @foreach ($desa as $key => $item)
                                            @if ($item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id))
                                            @php
                                            $filterResult = $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id);
                                            $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                        @endphp
                                                <tr style='{{ $key % 2 == 0 ? 'background: #e9e9e9' : '' }}'>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->UnitKerja->kecamatan }}</td>
                                                    <td class="unit_kerja">{{ $item->nama }}</td>
                                                    <td>
                                                        @php
                                                            $totalIbuHamil = $item
                                                                ->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )
                                                                ->IbuHamil($item->id);
                                                            $GrandTotalIbuHamil += $totalIbuHamil;
                                                        @endphp
                                                        {{ $totalIbuHamil }}
                                                        <input type="hidden" {{$isDisabled}} name="jumlah_ibu_hamil"
                                                            value="{{ $totalIbuHamil }}">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $GrandReaktif += $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->reaktif;
                                                        @endphp
                                                        <input type="number" {{$isDisabled}} name="reaktif"
                                                            id="{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->reaktif }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td>
                                                        @php
                                                            $GrandNonReaktif += $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                                                Session::get('year'),
                                                                $item->id,
                                                            )->non_reaktif;
                                                        @endphp
                                                        <input type="number" {{$isDisabled}} name="non_reaktif"
                                                            id="{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}"
                                                            value="{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->non_reaktif }}"
                                                            class="form-control data-input" style="border: none">
                                                    </td>
                                                    <td
                                                        id="total_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $total =
                                                                $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )->reaktif +
                                                                $item->filterDeteksiDiniHepatitisBPadaIbuHamil(
                                                                    Session::get('year'),
                                                                    $item->id,
                                                                )->non_reaktif;
                                                            $GrandTotal += $total;

                                                        @endphp
                                                        {{ $total }}
                                                    </td>
                                                    <td
                                                        id="bumil_diperiksa_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                                                        @php
                                                            $bumilDiperiksa = ($total / $totalIbuHamil) * 100;
                                                        @endphp
                                                        {{ number_format($bumilDiperiksa, 2) . '%' }}
                                                    </td>
                                                    <td
                                                        id="bumil_reaktif_{{ $item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->id }}">
                                                        {{ $total>0?number_format(($item->filterDeteksiDiniHepatitisBPadaIbuHamil(Session::get('year'), $item->id)->reaktif / $total) * 100, 2) . '%':0 }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr>
                                            <td colspan="3">Jumlah</td>
                                            <td id="jumlah_ibu_hamil">{{ $GrandTotalIbuHamil }}</td>
                                            <td id="jumlah_reaktif">{{ $GrandReaktif }}</td>
                                            <td id="jumlah_non_reaktif">
                                                {{ $GrandNonReaktif }}
                                            </td>
                                            <td id="jumlah_total">
                                                {{ $GrandTotal }}
                                            </td>
                                            <td id="jumlah_bumil_diperiksa">
                                                {{ $GrandTotalIbuHamil>0?number_format($GrandTotal / $GrandTotalIbuHamil, 2) . '%':0 }}
                                            </td>
                                            <td id="jumlah_bumil_reaktif">
                                                {{ $GrandTotal>0?number_format($GrandReaktif / $GrandTotal, 2) . '%':0 }}
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
                        $('#total_' + id).text(res.total);
                        $('#bumil_diperiksa_' + id).text(res.bumil_diperiksa);
                        $('#bumil_reaktif_' + id).text(res.bumil_reaktif);

                        $('#jumlah_ibu_hamil').text(res.jumlah_ibu_hamil);
                        $('#jumlah_reaktif').text(res.jumlah_reaktif);
                        $('#jumlah_non_reaktif').text(res.jumlah_non_reaktif);
                        $('#jumlah_total').text(res.jumlah_total);
                        $('#jumlah_bumil_diperiksa').text(res.jumlah_bumil_diperiksa);
                        $('#jumlah_bumil_reaktif').text(res.jumlah_bumil_reaktif);

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
			'data'	: {'id': id, 'mainFilter': 'filterDeteksiDiniHepatitisBPadaIbuHamil', 'secondaryFilter':'filterDesa'},
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
             <td>${item.jumlah_ibu_hamil}</td>
             <td>${item.reaktif}</td>
             <td>${item.non_reaktif}</td>
             <td>${parseInt(item.non_reaktif) + parseInt(item.reaktif)}</td>
             <td>${item.jumlah_ibu_hamil>0?((parseInt(item.non_reaktif) + parseInt(item.reaktif))/item.jumlah_ibu_hamil)*100:0}%</td>
             <td>${parseInt(item.non_reaktif) + parseInt(item.reaktif)>0?((parseInt(item.reaktif))/(parseInt(item.reaktif) + parseInt(item.non_reaktif)))*100:0}%</td>
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterDeteksiDiniHepatitisBPadaIbuHamil'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general2.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterDeteksiDiniHepatitisBPadaIbuHamil'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "DeteksiDiniHepatitisBPadaIbuHamil"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "DeteksiDiniHepatitisBPadaIbuHamil"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
        </script>
    @endpush
@endsection
