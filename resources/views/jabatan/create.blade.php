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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$title}}</a></li>
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

                    <form action="{{ route($route.'.store') }}" method='POST' id="myForm" name="myForm" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-10">
                            <div class="row">

                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">Harga NPA (Rp)</label>
                                    <div class="col-md-10">
                                        {!! Form::number('harga',null,['class'=>'form-control','id'=>'example-text-input']) !!}
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-2 col-form-label">kategori</label>
                                    <div class="col-md-10">
                                        <select name="kategori_id" id="kategori" class="form-control">
                                            @foreach($kategori as $key => $kat)
                                                <option value="{{$key}}">{{$kat == "-"?"Perusahaan air Minum":$kat}}</option>
                                            @endforeach
                                
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="row">
                                        <label for="example-text-input" class="col-md-6 col-form-label">Memiliki Range?</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="row">
                                        <div class="form-check mb-2 col" style="margin-left: .7rem;">
                                            <input class="form-check-input" type="radio" name="meteran" id="meteran" value="1" checked>
                                            <label class="form-check-label" for="meteran">
                                                Pakai
                                            </label>
                                        </div>
                                        <div class="form-check col">
                                            <input class="form-check-input" type="radio" name="meteran" id="meteran1" value="0">
                                            <label class="form-check-label" for="meteran1">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Wilayah</label>
                                <div class="col-md-10">
                                    <select name="wilayah[]" id="wilayah" class="select2 select2-multiple form-control wilayah" multiple>
                                        @foreach ($wilayah as $key=>$item)
                                            <option value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            
                            {{-- <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">Wilayah</label>
                                <div class="col-md-10">
                                    {!! Form::select('wilayah_id[]',$wilayah,isset($npa)?$npa->wilayah->pluck('id'):null,['class'=>'form-control wilayah','id'=>'example-text-input','multiple'=>'multiple']) !!}
                                </div>
                            </div> --}}
                            <div class="inputs">
                                <div class="row">
                                    <div class="col-md-3"><label for="example-text-input" class="col-md-4 col-form-label">Batas Bawah (M<sup>3</sup>)</label></div>
                                    <div class="col-md-3"><label for="meter_sekarang" class="col-md-4 col-form-label">Batas Atas (M<sup>3</sup>)</label></div>
                                </div>
                                <div class="mb-3 row">
                                
                                    <div class="col-md-3">
                                        <input class="form-control meter_sebelumnya" type="number" name="volume_awal" id="meter_sebelumnya" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control meter_sekarang" type="number" name="volume_akhir" id="meter_sekarang" min="0" value="0" onkeyup="getPemakaian(this)" data-queu="0">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-11">
                                    
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                
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

@push('scripts')
    <script type="text/javascript">
         let p;
        let pt;
        $(document).ready(function(){
            $('.select2').select2();
        });

        $('.wilayah').select2({
                    placeholder:'pilih wilayah',
                    multiple:true,
                    width:'100%',
                    allowClear:true,
                });
        $('.wilayah').val('').trigger('change');

        //get radio value
        let radio = document.myForm.meteran;
        let radio_value = 1;
        var prev = null;
        for (var i = 0; i < radio.length; i++) {
            radio[i].addEventListener('change', function() {
                if (this !== prev) {
                    prev = this;
                }else if(prev){
                    console.log(prev.value);
                }
                

                if(this.value == 1){
                    radio_value = 1;
                    
                    const counter = document.getElementsByClassName('meter_sebelumnya');
                    $('#wilayah').prop('disabled', false);
                    for (let i = 0; i < counter.length; i++){
                       counter[i].readOnly = false;
                       document.getElementsByClassName('meter_sekarang')[i].readOnly = false;
                       document.getElementsByClassName('pemakaian')[i].readOnly = true;
                    }
                }else if(this.value == 0){
                    radio_value = 0;
                    const counter = document.getElementsByClassName('meter_sebelumnya');
                    $('#wilayah').prop('disabled', true);
                    for(let i = 0; i < counter.length; i++){
                        counter[i].readOnly = true;
                        document.getElementsByClassName('meter_sekarang')[i].readOnly = true;
                        counter[i].value = null;
                        document.getElementsByClassName('meter_sekarang')[i].value = null;
                        document.getElementsByClassName('pemakaian')[i].readOnly = false;
                    }
                }

                console.log(radio_value, document.getElementsByClassName('meter_sebelumnya')[0], document.getElementsByClassName('wilayah'));
            });
        }

        $('#kategori').change(function(){
            var selected = $("#kategori option:selected");
            console.log(selected.text())
            if (selected.text() !== 'BUMN'
            && selected.text() !== 'BUMD'
            && selected.text() !== 'BUMN(PLN)' 
            // && selected.text() !== 'Niaga Kecil'
            // && selected.text() !== "Perusahaan air Minum"
            // && selected.text() !== "niaga sedang"
            // && selected.text() !== "niaga besar"
            // && selected.text() !== "niaga besar"
            // && selected.text() !== "industri kecil"
            // && selected.text() !== "industri sedang"
            // && selected.text() !== "industri besar"
            // && selected.text() !== "industri sedang"
            // && selected.text() !== "Batu Bara"
            // && selected.text() !== "Hulu Migas"
            // && selected.text() !== "Mineral Logam"
            // && selected.text() !== "Batuan"
            // && selected.text() !== "Pendulangan Emas"
            // && selected.text() !== "Industri BUMN/BUMD"
            // && selected.text() !== "Industri (Swasta)"
            // && selected.text() !== "non-agro Industri"

            
            ) {
                $('.append-element').html($('#form_plus').html());
                $('.wilayah').select2({
                    placeholder:'pilih wilayah',
                    multiple:true,
                    width:'100%',
                    allowClear:true,
                });
                $('.wilayah').val('').trigger('change');
            }else{
                $('.append-element').html('');
            }
        });
    </script>

    <script type="text/template" id="form_plus">
        <div class="mb-3 row">
            <label for="example-text-input" class="col-md-2 col-form-label">Wilayah</label>
            <div class="col-md-10">
                {!! Form::select('wilayah_id[]',$wilayah,null,['class'=>'form-control wilayah','id'=>'example-text-input','multiple'=>'multiple']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label for="example-text-input" class="col-md-2 col-form-label">Ranges Volume (M<sup>3</sup>)</label>
            <div class="col-md-5">
                {!! Form::number('volume_awal',null,['class'=>'form-control','id'=>'example-text-input','placeholder'=>'batas bawah']) !!}
            </div>
            <div class="col-md-5">
                {!! Form::number('volume_akhir',null,['class'=>'form-control','id'=>'example-text-input','placeholder'=>'batas atas']) !!}
            </div>
        </div>
    </script>
@endpush