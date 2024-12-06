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
                            <select name="tahun" id="tahun" class="form-control">
                                <option value="2024" {{app('request')->input('year') == 2024 ? "selected":""}}>2024</option>
                            </select> 
                            <button class="btn btn-primary" id="filter">Submit</button>
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
                                <th rowspan="3">No</th>
                                @role("Admin")
                                <th rowspan="3">Puskesmas</th>
                                @endrole
                                @role("Puskesmas|Pihak Wajib Pajak")
                                <th rowspan="3">Desa</th>
                                @endrole
                                <th rowspan="3" style="white-space: nowrap">Jumlah Balita</th>
                                <th colspan="3" style="white-space: nowrap">Balita Batuk atau Kesukaran Bernapas</th>
                                <th colspan="3" style="white-space: nowrap">Perkiraan Pneumonia Balita</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA KESEMBUHAN (CURE RATE) TUBERKULOSIS PARU TERKONFIRMASI BAKTERIOLOGIS</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA PENGOBATAN LENGKAP (COMPLETE RATE) SEMUA KASUS TUBERKULOSIS</th>
                                <th colspan="6" style="white-space: nowrap">ANGKA KEBERHASILAN PENGOBATAN (SUCCESS RATE/SR) SEMUA KASUS TUBERKULOSIS</th>
                                <th colspan="2" rowspan="2" style="white-space: nowrap">JUMLAH KEMATIAN SELAMA PENGOBATAN TUBERKULOSIS</th>
                            </tr>
                            <tr>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                                <th colspan="2">Laki-Laki</th>
                                <th colspan="2">Perempuan</th>
                                <th colspan="2">Laki-Laki + Perempuan</th>
                            </tr>
                            <tr>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>L</th>
                                <th>P</th>
                                <th>L + P</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
                                <th>%</th>
                                <th>Jumlah</th>
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
                                    <td>{{$item->nama}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"]}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kesembuhan_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'konfirmasi_P')["total"]) * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'lengkap_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"]) * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_L')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_P')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] > 0?
                                        number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_P')["total"]
                                        /$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] * 100, 2
                                        ):0}}</td>
                                    
                                    
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_L')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] > 0?
                                        number_format(($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'berhasil_L')["total"])
                                        /($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"]) * 100, 2
                                        ):0}}</td>

                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kematian')["total"]}}</td>
                                    <td>{{$item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] > 0?
                                    number_format($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'kematian')["total"]
                                    /($item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_L')["total"] + $item->unitKerjaAmbil('filterObatTuberkulosis', app('request')->input('year'), 'diobati_P')["total"]) * 100, 2
                                    ):0}}</td>
                                    

                                    
                                    
                                    
                                </tr>
                                @endforeach
                                @endrole
                                @role('Puskesmas|Pihak Wajib Pajak')
                                @foreach ($desa as $key => $item)
                                @if($item->filterPenyebabKematianIbu(app('request')->input('year')))
                                <tr style='{{$key % 2 == 0?"background: #e9e9e9":""}}'>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->nama}}</td>
                                    <td><input type="number" name="konfirmasi_L" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" name="konfirmasi_P" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="konfirmasi{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P + $item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L}}</td>
                                    
                                    <td><input type="number" name="diobati_L" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td><input type="number" name="diobati_P" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    <td id="diobati{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L}}</td>

                                    <td><input type="number" name="kesembuhan_L" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kesembuhan_L{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_L
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="kesembuhan_P" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kesembuhan_P{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_P
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P * 100, 2):0}}</td>
                                    
                                    <td id="kesembuhan_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_P + $item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_L}}</td>

                                    <td id="persen_kesembuhan_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P + $item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L>0?
                                        number_format(($item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_P + $item->filterObatTuberkulosis(app('request')->input('year'))->kesembuhan_L)
                                        /($item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_L + $item->filterObatTuberkulosis(app('request')->input('year'))->konfirmasi_P) * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="lengkap_L" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="lengkap_L{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_L
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="lengkap_P" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="lengkap_P{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_P
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P * 100, 2):0}}</td>
                                    
                                    <td id="lengkap_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_P + $item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_L}}</td>

                                    <td id="persen_lengkap_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L>0?
                                        number_format(($item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_P + $item->filterObatTuberkulosis(app('request')->input('year'))->lengkap_L)
                                        /($item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P) * 100, 2):0}}</td>
                                   
                                   <td><input type="number" name="berhasil_L" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_L}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="berhasil_L{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_L
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L * 100, 2):0}}</td>
                                    
                                    <td><input type="number" name="berhasil_P" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_P}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="berhasil_P{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P>0?
                                        number_format($item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_P
                                        /$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P * 100, 2):0}}</td>
                                    
                                    <td id="berhasil_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_P + $item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_L}}</td>

                                    <td id="persen_berhasil_LP{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L>0?
                                        number_format(($item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_P + $item->filterObatTuberkulosis(app('request')->input('year'))->berhasil_L)
                                        /($item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P) * 100, 2):0}}</td>

                                    <td><input type="number" name="kematian" id="{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}" value="{{$item->filterObatTuberkulosis(app('request')->input('year'))->kematian}}" class="form-control data-input" style="border: none; width: 100%"></td>
                                    
                                    <td id="kematian{{$item->filterObatTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L>0?
                                    number_format($item->filterObatTuberkulosis(app('request')->input('year'))->kematian
                                    /($item->filterObatTuberkulosis(app('request')->input('year'))->diobati_L + $item->filterObatTuberkulosis(app('request')->input('year'))->diobati_P) * 100, 2):0}}</td>
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
        let params = url.searchParams.get("year");
        let id = $(this).attr('id');

        let konfirmasi = $(this).parent().parent().find(`#konfirmasi${id}`);
        let diobati = $(this).parent().parent().find(`#diobati${id}`);
        let kesembuhan_L = $(this).parent().parent().find(`#kesembuhan_L${id}`);
        let kesembuhan_P = $(this).parent().parent().find(`#kesembuhan_P${id}`);
        let kesembuhan_LP = $(this).parent().parent().find(`#kesembuhan_LP${id}`);
        let persen_kesembuhan_LP = $(this).parent().parent().find(`#persen_kesembuhan_LP${id}`);
        let persen_layanan_LP = $(this).parent().parent().find(`#persen_layanan_LP${id}`);
        let lengkap_L = $(this).parent().parent().find(`#lengkap_L${id}`);
        let lengkap_P = $(this).parent().parent().find(`#lengkap_P${id}`);
        let lengkap_LP = $(this).parent().parent().find(`#lengkap_LP${id}`);
        let persen_lengkap_LP = $(this).parent().parent().find(`#persen_lengkap_LP${id}`);
        let berhasil_L = $(this).parent().parent().find(`#berhasil_L${id}`);
        let berhasil_P = $(this).parent().parent().find(`#berhasil_P${id}`);
        let berhasil_LP = $(this).parent().parent().find(`#berhasil_LP${id}`);
        let persen_berhasil_LP = $(this).parent().parent().find(`#persen_berhasil_LP${id}`);
        let kematian = $(this).parent().parent().find(`#kematian${id}`);
        
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			'type' 	: 'POST',
			'url'	: '{{ route("ObatTuberkulosis.store") }}',
			'data'	: {'name' : name, 'value' : value, 'id': id, 'year': params},
			success	: function(res){
                konfirmasi.text(`${res.konfirmasi}`);
                diobati.text(`${res.diobati}`);
                kesembuhan_L.text(`${res.kesembuhan_L}`);
                kesembuhan_P.text(`${res.kesembuhan_P}`);
                kesembuhan_LP.text(`${res.kesembuhan_LP}`);
                persen_kesembuhan_LP.text(`${res.persen_kesembuhan_LP}`);
                lengkap_L.text(`${res.lengkap_L}`);
                lengkap_P.text(`${res.lengkap_P}`);
                lengkap_LP.text(`${res.lengkap_LP}`);
                persen_lengkap_LP.text(`${res.persen_lengkap_LP}`);
                berhasil_L.text(`${res.berhasil_L}`);
                berhasil_P.text(`${res.berhasil_P}`);
                berhasil_LP.text(`${res.berhasil_LP}`);
                persen_berhasil_LP.text(`${res.persen_berhasil_LP}`);
                kematian.text(`${res.kematian}`);
			}
		});
        console.log(name, value, id);
        })
        $("#filter").click(function(){
            let year = $("#tahun").val();
            window.location.href = "/JumlahKematianIbu?year="+year;


        })
    </script>
@endpush
@endsection