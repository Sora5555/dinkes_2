@extends('layouts.app')

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#upt_id").select2();
            $("#id_pelanggan").select2({
                ajax: {
                    url: function () {
                        const upt_id = $("#upt_id").val();
                        return "{{ url('pelunasan/ajaxGetPelanggan') }}/"+upt_id;
                    },
                    dataType: "json",
                    type: "GET",
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Import Excel {{ $title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $title }}</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
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

                        <form action="{{ url('/pelunasan/importExcel') }}" method='POST' id="myForm" enctype="multipart/form-data">
                            @csrf
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <p>Filter Import</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kabupaten/Kota</label>
                                        <select class="form-control select2" id="upt_id" name="upt_id">
                                            <option value="0">-- Semua Kabupaten/Kota --</option>
                                            @foreach ($upts as $upt)
                                                <option value="{{ $upt->id }}">{{ $upt->nama_daerah }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Pelanggan/Perusahaan</label>
                                        <select class="form-control select2" name="id_pelanggan" id="id_pelanggan">
                                            <option value="0">-- Semua Perusahaan --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                               
                            </div> --}}
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">File Excel</label>
                                        <input type="file" class="form-control" name="file">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" name="import_data" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                  Tetap Import Data Lainnya Jika Ada Data Yang Tidak Sesuai/Error
                                                </label>
                                              </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr>
                                            <p>Check Data Double (Berdasarkan Perusahaan dan Tanggal Pemakaian)</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="double_data" value="1" id="double_data1" checked>
                                                <label class="form-check-label" for="double_data1">
                                                  Jangan Import Data Jika Data Sudah Ada Di Database
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio" name="double_data" value="2" id="double_data2">
                                                <label class="form-check-label" for="double_data2">
                                                  Update Data Jika Data Sudah Ada Di Database
                                                </label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" type="radio" name="double_data" value="3" id="double_data3" >
                                                <label class="form-check-label" for="double_data3">
                                                  Tetap Tambah Data Jika Data Sudah Ada Di Database
                                                </label>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success my-4">Import</button>
                                </div>
                            </div>
                           


                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Result : </h4>
                        @php
                            $results = session('results');
                        @endphp
                        @if (isset($results))
                            @foreach ($results as $key => $result)
                                <div class="row my-2">
                                    <div class="col-md-12">
                                        <div class="alert alert-{{$result['status']}}" role="alert">
                                            {{ @$result['message'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Template Excel</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('/pelunasan/exportTemplate') }}" method='POST' id="myForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kabupaten/Kota</label>
                                        <select class="form-control select2" id="upt_id" name="upt_id">
                                            <option value="0">-- Semua Kabupaten/Kota --</option>
                                            @foreach ($upts as $upt)
                                                <option value="{{ $upt->id }}">{{ $upt->nama_daerah }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Pelanggan/Perusahaan</label>
                                        <select class="form-control select2" name="id_pelanggan" id="id_pelanggan">
                                            <option value="0">-- Semua Perusahaan --</option>
                                            
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control" name="bulan" id="bulan">
                                            @foreach (config("app.months") as $date)
                                                <option value="{{ $loop->index + 1 }}">{{ $date }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select class="form-control" name="tahun" id="tahun">
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}" @if(date('Y') == $year) selected @endif>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success my-4">Export</button>
                                </div>
                            </div>
                           


                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>

    </div>
    
@endsection
