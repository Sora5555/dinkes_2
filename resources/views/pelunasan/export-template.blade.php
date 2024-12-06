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
                    <h4 class="mb-sm-0">Template Excel {{ $title }}</h4>

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
        <!-- end row -->

    </div>
@endsection
