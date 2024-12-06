@extends('layouts.app')

@section('content')
<div class="container-fluid">

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
                            {{-- {!! Form::select('induk_opd_id',$induk_opd_arr,"",['class'=>'form-control daerah', 'form'=>'storeForm','required'=>'required','placeholder'=>'Pilih SKPD', 'id'=>'induk_opd']) !!}
                            <select name="program_id" form="storeForm" id="program_id" class="form-control">
                                <option value="">Pilih Program</option>
                            </select>
                            <select name="kegiatan_id" form="storeForm" id="kegiatan_id" class="form-control">
                                <option value="">Pilih Kegiatan</option>
                            </select>
                            --}}
                            <input type="text" id="searchInput" placeholder="Search for names..." onkeyup="searchTable()" class="form-control">
                        </div>
                        {{-- <div class="col-md-2">
                            <button class="btn btn-primary col-md-12 btn-tambah-program"><i class="mdi mdi-plus"></i> Tambah</button>
                        </div> --}}
                    </div>
                    {{-- <h4 class="card-title">Pengguna</h4> --}}
                    {{-- <p class="card-title-desc">DataTables has most features enabled by
                        default, so all you need to do to use it with your own tables is to call
                        the construction function: <code>$().DataTable();</code>.
                    </p> --}}
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th>No</th>
                                <th>Indikator</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L+P</th>
                                <th>Satuan</th>
                                @role('superadmin')
                                <th>Lock Data</th>
                                @endrole
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @if (Auth::user()->hasRole(['superadmin']) || 
                                (Auth::user()->hasRole('Admin') && Auth::user()->hasMenuPermission(3)))
                                <tr>
                                    <td>1</td>
                                    <td>Kunjungan Neonatus 1 Kali</td>
                                    <td>{{$unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0?number_format(($unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterNeonatal', 'kn1_L') / $unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L')) * 100, 2):0}}</td>
                                    <td>{{$unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') > 0?number_format(($unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterNeonatal', 'kn1_P') / $unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')) * 100, 2):0}}</td>
                                    <td>{{$unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') + $unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0?number_format((($unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterNeonatal', 'kn1_P') + $unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterNeonatal', 'kn1_L')) / ($unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') + $unit_kerja->totalForAllUnitKerja(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'))) * 100, 2):0}}</td>
                                    <td>%</td>
                                    @role('superadmin')
                                    <td><input type="checkbox" name="lock" {{$unit_kerja->check_lock('App\Models\Neonatal') == 2 ? "checked":""}} class="data-lock" id="App\Models\Neonatal" year={{Session::get('year')}} ></td>
                                    @endrole
                                </tr>
                                @endif
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <tr>
                                    <td>1</td>
                                    <td>Kunjungan Neonatus 1 Kali</td>
                                    <td>{{$unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0?number_format(($unit_kerja->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L') / $unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L')) * 100, 2):0}}</td>
                                    <td>{{$unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') > 0?number_format(($unit_kerja->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P') / $unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')) * 100, 2):0}}</td>
                                    <td>{{$unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') + $unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0?number_format((($unit_kerja->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P') + $unit_kerja->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L')) / ($unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') + $unit_kerja->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'))) * 100, 2):0}}</td>
                                    <td>%</td>
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
        
        let bayi_L = $(this).parent().parent().find(`#bayi_L${id}`);
        let total_L = $(this).parent().parent().find(`#total_L${id}`);
        let bayi_P = $(this).parent().parent().find(`#bayi_P${id}`);
        let total_P = $(this).parent().parent().find(`#total_P${id}`);
        let neo_LP = $(this).parent().parent().find(`#neo_LP${id}`);
        let post_neo_LP = $(this).parent().parent().find(`#post_neo_LP${id}`);
        let bayi_LP = $(this).parent().parent().find(`#bayi_LP${id}`);
        let balita_LP = $(this).parent().parent().find(`#balita_LP${id}`);
        let total_LP = $(this).parent().parent().find(`#total_LP${id}`);


        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KematianNeonatal.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                bayi_L.text(`${res.bayi_L}`);
                total_L.text(`${res.total_L}`);
                bayi_P.text(`${res.bayi_P}`);
                total_P.text(`${res.total_P}`);
                neo_LP.text(`${res.neo_LP}`);
                post_neo_LP.text(`${res.post_neo_LP}`);
                bayi_LP.text(`${res.bayi_LP}`);
                balita_LP.text(`${res.balita_LP}`);
                total_LP.text(`${res.total_LP}`);
                console.log(res);

                let total_column = res.column;
                $(`#sum_neo_LP`).text(res.sum_neo_LP)
                $(`#sum_post_neo_LP`).text(res.sum_post_neo_LP)
                $(`#sum_bayi_LP`).text(res.sum_bayi_LP)
                $(`#sum_balita_LP`).text(`${res.sum_balita_LP}`)
                $(`#sum_total_LP`).text(`${res.sum_total_LP}`)
                $(`#${total_column}`).text(res.total);
			}
		});
        console.log(name, value, id);
        })
        $('#data').on('click', '.data-lock', function(){
            let id = $(this).attr('id');
            let year = $(this).attr('year');
            let name = $(this).attr('name')
            $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
            if($(this).is(':checked')){
            $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("resume.lock") }}',
			'data'	: {'id': id, 'status': 2, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("resume.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    function searchTable() {
    // Get the input field and convert its value to lowercase
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    
    // Get the table and the rows
    let table = document.getElementById('data');
    let tr = table.getElementsByTagName('tr');
    
    // Loop through all table rows, starting from row 1 (to skip the table headers)
    for (let i = 1; i < tr.length; i++) {
        let tds = tr[i].getElementsByTagName('td');
        let rowContainsFilter = false;
        
        // Check each cell in the row for the search term
        for (let j = 0; j < tds.length; j++) {
            let td = tds[j];
            if (td) {
                if (td.innerHTML.toLowerCase().indexOf(filter) > -1) {
                    rowContainsFilter = true;
                    break;  // No need to check other cells if one matches
                }
            }
        }
        
        // Show or hide the row based on the search
        if (rowContainsFilter) {
            tr[i].style.display = '';
        } else {
            tr[i].style.display = 'none';
        }
    }
}
    </script>
@endpush
@endsection