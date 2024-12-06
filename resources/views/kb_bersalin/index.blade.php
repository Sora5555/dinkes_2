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
                            @if(Auth::user()->downloadFile('KbBersalin', Session::get('year')))
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KbBersalin" id="">
                                <input type="file" name="file_upload" id="" {{Auth::user()->downloadFile('KbBersalin', Session::get('year'))->status == 1 ?"disabled":""}} class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success" {{Auth::user()->downloadFile('KbBersalin', Session::get('year'))->status == 1?"disabled":""}}>Upload</button>

                            </form>
                            @else
                            <form action="/upload/general" method="post" class="d-flex gap-5" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="KbBersalin" id="">
                                <input type="file" name="file_upload" id="" class="form-control" placeholder="upload PDF file">
                                <button type="submit" class="btn btn-success">Upload</button>

                            </form>
                            @endif
                            @if(Auth::user()->hasFile('KbBersalin', Session::get('year')) && Auth::user()->downloadFile('KbBersalin', Session::get('year'))->file_name != "-")
                                <a type="button" class="btn btn-warning" href="{{ Auth::user()->downloadFile('KbBersalin', Session::get('year'))->file_path.Auth::user()->downloadFile('KbBersalin', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
                            @endif
                            <a type="button" class="btn btn-warning" href="{{ route('KbBersalin.excel') }}" ><i class="mdi mdi-note"></i>Report</a>
                            <a type="button" class="btn btn-primary" href="{{ route('IbuHamilDanBersalin.add', ['year' => Session::get('year')]) }}"><i class="mdi mdi-plus"></i>Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="text-center">
                            <tr style="width: 100%">
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kecamatan</th>
                                @role('Admin|superadmin')
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th rowspan="2">Jumlah Ibu Bersalin</th>
                                <th colspan="18" style="width: 80%">Peserta Aktif KB Modern</th>
                                @role('Admin|superadmin')
                                <th rowspan="2">Lock data</th>
                                <th rowspan="2">Lock upload</th>
                                <th rowspan="2">File Download</th>
                                <th rowspan="2">Detail Desa</th>
                                @endrole
                            </tr>
                            <tr>
                                <th style="white-space: nowrap">Kondom</th>
                                <th style="white-space: nowrap">%</th>
                                <th style="white-space: nowrap;">Suntik &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">Pil &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">Akdr &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">MOP &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">MOW &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">Implan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th style="white-space: nowrap;">MAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                            </tr>
                            </thead>
                            <tbody>
                                @role('Admin|superadmin')
                                @foreach ($unit_kerja as $key => $item)
                                
                                <tr style={{$key % 2 == 0?"background: gray":""}}>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["kondom"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["kondom"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["suntik"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["suntik"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["pil"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["pil"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["akdr"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["akdr"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mop"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mop"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mow"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mow"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["implan"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["implan"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mal"]}}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format($item->ibu_hamil_per_desa(Session::get('year'))["mal"]/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"] * 100, 2):0 }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["mal"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["implan"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["mow"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["mop"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["pil"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["akdr"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["suntik"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["kondom"]
                                        }}</td>
                                    <td>{{$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]>0?number_format((($item->ibu_hamil_per_desa(Session::get('year'))["mal"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["implan"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["mow"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["mop"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["pil"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["akdr"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["suntik"]
                                        + $item->ibu_hamil_per_desa(Session::get('year'))["kondom"])/$item->ibu_hamil_per_desa(Session::get('year'))["jumlah_ibu_bersalin"]) * 100, 2):0 }}</td>
                                         <td><input type="checkbox" name="lock" {{$item->general_lock_get(Session::get('year'), 'filterDesa') == 1 ? "checked":""}} class="data-lock" id="{{$item->id}}"></td>
                                         @if(isset($item->user) && $item->user->downloadFile('KbBersalin', Session::get('year')))
                                         <td><input type="checkbox" name="lock_upload" {{$item->user->downloadFile('KbBersalin', Session::get('year'))->status == 1 ? "checked":""}} class="data-lock-upload" id="{{$item->user->id}}"></td>
                                         @elseif(isset($item->user) && !$item->user->downloadFile('KbBersalin', Session::get('year')))
                                         <td><input type="checkbox" name="lock_upload" class="data-lock-upload" id="{{$item->user->id}}"></td>
                                         @else
                                         <td>-</td>
                                         @endif
                                         @if(isset($item->user) && $item->user->hasFile('KbBersalin', Session::get('year')))
                                         <td>
                                             @if($item->user->downloadFile('KbBersalin', Session::get('year'))->file_name != "-")
                                             <a type="button" class="btn btn-warning" href="{{ $item->user->downloadFile('KbBersalin', Session::get('year'))->file_path.$item->user->downloadFile('KbBersalin', Session::get('year'))->file_name }}" download="" ><i class="mdi mdi-note"></i>Download pdf file</a>
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
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterDesa(Session::get('year')))
                                @php
                                $filterResult = $item->filterDesa(Session::get('year'));
                                $isDisabled = $filterResult->status == 1 ? "disabled" : "";
                                @endphp
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->UnitKerja->kecamatan}}</td>
                                    <td class="unit_kerja">{{$item->nama}}</td>
                                    
                                    <td>{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin}}</td>

                                    <td><input type="number" name="kondom" {{$isDisabled}} id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->kondom}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="kondom{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->kondom/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="suntik" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->suntik}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="suntik{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->suntik/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="pil" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->pil}}" class="form-control data-input" style="border: none"></td>
                                    <td id="pil{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->pil/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="akdr" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->akdr}}" class="form-control data-input" style="border: none"></td>
                                    <td id="akdr{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->akdr/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="mop" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->mop}}" class="form-control data-input" style="border: none"></td>
                                    <td id="mop{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->mop/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="mow" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->mow}}" class="form-control data-input" style="border: none"></td>
                                    <td id="mow{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->mow/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="implan" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->implan}}" class="form-control data-input" style="border: none"></td>
                                    <td id="implan{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->implan/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td><input type="number" {{$isDisabled}} name="mal" id="{{$item->filterDesa(Session::get('year'))->id}}" value="{{$item->filterDesa(Session::get('year'))->mal}}" class="form-control data-input" style="border: none"></td>
                                    <td id="mal{{$item->filterDesa(Session::get('year'))->id}}">{{$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format($item->filterDesa(Session::get('year'))->mal/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin * 100, 2):0}}</td>
                                    <td id="jumlah{{$item->filterDesa(Session::get('year'))->id}}">{{
                                    $item->filterDesa(Session::get('year'))->mal
                                    + $item->filterDesa(Session::get('year'))->implan
                                    + $item->filterDesa(Session::get('year'))->mow
                                    + $item->filterDesa(Session::get('year'))->mop
                                    + $item->filterDesa(Session::get('year'))->pil
                                    + $item->filterDesa(Session::get('year'))->akdr
                                    + $item->filterDesa(Session::get('year'))->suntik
                                    + $item->filterDesa(Session::get('year'))->kondom}}</td>
                                    <td id="persen_jumlah{{$item->filterDesa(Session::get('year'))->id}}">{{
                                    $item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin>0?number_format(
                                    (($item->filterDesa(Session::get('year'))->mal
                                    + $item->filterDesa(Session::get('year'))->implan
                                    + $item->filterDesa(Session::get('year'))->mow
                                    + $item->filterDesa(Session::get('year'))->mop
                                    + $item->filterDesa(Session::get('year'))->pil
                                    + $item->filterDesa(Session::get('year'))->akdr
                                    + $item->filterDesa(Session::get('year'))->suntik
                                    + $item->filterDesa(Session::get('year'))->kondom)/$item->filterDesa(Session::get('year'))->jumlah_ibu_bersalin) * 100, 2):0}}</td>
                                  </tr>
                                  @endif
                                @endforeach
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
        let id = $(this).attr('id');
        let kondom = $(this).parent().parent().find(`#kondom${id}`);
        let suntik = $(this).parent().parent().find(`#suntik${id}`);
        let pil = $(this).parent().parent().find(`#pil${id}`);
        let mop = $(this).parent().parent().find(`#mop${id}`);
        let mow = $(this).parent().parent().find(`#mow${id}`);
        let implan = $(this).parent().parent().find(`#implan${id}`);
        let akdr = $(this).parent().parent().find(`#akdr${id}`);
        let mal = $(this).parent().parent().find(`#mal${id}`);
        let efek_samping = $(this).parent().parent().find(`#efek_samping${id}`);
        let komplikasi = $(this).parent().parent().find(`#komplikasi${id}`);
        let kegagalan = $(this).parent().parent().find(`#kegagalan${id}`);
        let dropout = $(this).parent().parent().find(`#dropout${id}`);
        let jumlah = $(this).parent().parent().find(`#jumlah${id}`);
        let persen_jumlah = $(this).parent().parent().find(`#persen_jumlah${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("KbBersalin.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id},
			success	: function(res){
                kondom.text(`${res.kondom}`);
                pil.text(`${res.pil}`);
                suntik.text(`${res.suntik}`);
                mop.text(`${res.mop}`);
                mow.text(`${res.mow}`);
                implan.text(`${res.implan}`);
                akdr.text(`${res.akdr}`);
                mal.text(`${res.mal}`);
			}
		});
        console.log(name, value, id);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/JumlahKematianIbu?year="+year;


        })
        $('#data').on('click', '.detail', function(){
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
			'url'	: `/general/detail_desa/${id}`,
			'data'	: {'id': id, 'mainFilter': 'filterDesa'},
			success	: function(res){
                console.log(res);


                $clickedRow.nextAll('.detail-row').remove();
                res.desa.forEach(function(item) {
                    let newRow = `
                    <tr class="detail-row" style="background: #f9f9f9;">
              <td></td>
              <td></td>
            <td>${item.nama}</td>
             <td>${item.jumlah_ibu_bersalin}</td>
            <td>${item.kondom}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.kondom/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.suntik}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.suntik/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.pil}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.pil/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.akdr}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.akdr/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.mop}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.mop/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.mow}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.mow/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.implan}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.implan/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.mal}</td>
            <td>${item.jumlah_ibu_bersalin>0?(item.mal/item.jumlah_ibu_bersalin) * 100:0}%</td>
            <td>${item.mal + item.kondom + item.suntik + item.pil + item.akdr + item.mop + item.mow + item.implan}</td>
            <td>${item.jumlah_ibu_bersalin>0?((item.mal + item.kondom + item.suntik + item.pil + item.akdr + item.mop + item.mow + item.implan)/item.jumlah_ibu_bersalin) * 100:0}%</td>
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
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': 'filterDesa'},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': 'filterDesa'},
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
			'data'	: {'id': id, 'status': 1, 'year': year, 'name': "KbBersalin"},
			success	: function(res){
				console.log(res);
			}
		});
            } else {
                $.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("general.lock_upload") }}',
			'data'	: {'id': id, 'status': 0, 'year': year, 'name': "KbBersalin"},
			success	: function(res){
				console.log(res);
			}
		});
            }
        })
    </script>
@endpush
@endsection