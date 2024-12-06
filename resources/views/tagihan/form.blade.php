 <div class="row">
   <div class="col-md-6">
       <div class="row">
        <div class="col-md-6">
            <div class="row">
                <label for="example-text-input" class="col-md-6 col-form-label">Bulan</label>
            </div>
            <div class="mb-3 row">

                <div class="col-md-8">
                    {{-- <input class="form-control" type="text" name="id_pelanggan" id="example-text-input"> --}}
                    {!! Form::select('bulan',$month,isset($tagihan)?$selected_month:null,['class'=>'form-control','id'=>'bulan']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <label for="example-text-input" class="col-md-6 col-form-label">Tahun</label>
            </div>
            <div class="mb-3 row">

                <div class="col-md-8">
                    {!! Form::select('tahun',$year,isset($tagihan)?$selected_year:null,['class'=>'form-control','id'=>'tahun']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <label for="example-text-input" class="col-md-6 col-form-label">Tanggal Pelaporan</label>
            </div>
            <div class="mb-3 row">

                <div class="col-md-10">
                    {!! Form::text('tanggal_p',isset($tagihan)?$tagihan->created_at->format('Y-m-d'):null,['class'=>'form-control','id'=>'tanggal_p','disabled'=>'disabled']) !!}
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row">
                <label for="example-text-input" class="col-md-6 col-form-label">Pengguna Meteran?</label>
            </div>
        </div>
        <div class="col-md-6">

            <div class="row">
                <div class="form-check mb-2 col" style="margin-left: .7rem;">
                   {{--  <input class="form-check-input" type="radio" name="meteran" id="meteran" value="1" checked> --}}
                   {!! Form::radio('meteran',1,$tagihan->meter_penggunaan_awal != '0' ?true:'',['class'=>'form-check-input','id'=>'meteran']) !!}
                    <label class="form-check-label" for="meteran">
                        Pakai
                    </label>
                </div>
                <div class="form-check col">
                   {{--  <input class="form-check-input" type="radio" name="meteran" id="meteran1" value="0"> --}}
                    {!! Form::radio('meteran',0,$tagihan->meter_penggunaan_awal == '0'?true:'',['class'=>'form-check-input','id'=>'meteran1']) !!}
                    <label class="form-check-label" for="meteran1">
                        Tidak
                    </label>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <label for="example-text-input" class="col-md-4 col-form-label">Meter Bulan Sebelumnya</label>
    </div>
    <div class="mb-3 row">

        <div class="col-md-10">
            {!! Form::number('meter_sebelumnya',isset($tagihan)?$tagihan->meter_penggunaan_awal:0,['class'=>'form-control','id'=>'meter_sebelumnya','min'=>0,'required'=>'required']) !!}
        </div>
    </div>
    <div class="row">
        <label for="example-text-input" class="col-md-4 col-form-label">Meter Sekarang</label>
    </div>
    <div class="mb-3 row">

        <div class="col-md-10">
            {{-- <input class="form-control" type="number" name="meter_sekarang" id="meter_sekarang" min="0" value="0"> --}}
            {!! Form::number('meter_sekarang',$tagihan->meter_penggunaan_awal == '0' ?0:$tagihan->meter_penggunaan,['class'=>'form-control','id'=>'meter_sekarang','min'=>0,'required'=>'required']) !!}
        </div>
    </div>

    <div class="row">
        <label for="example-text-input" class="col-md-4 col-form-label" >Pemakaian</label>
    </div>
    <div class="mb-3 row">

        <div class="col-md-10">
           {{--  <input class="form-control" type="number" name="pemakaian" id="pemakaian", disabled> --}}
            {!! Form::number('pemakaian',$tagihan->meter_penggunaan_awal == '0' ? $tagihan->meter_penggunaan:$tagihan->meter_penggunaan - $tagihan->meter_penggunaan_awal,['class'=>'form-control','id'=>'pemakaian','required'=>'required','readonly'=>'readonly']) !!}
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Dokument Pendukung</label>
        <input type="file" name="file" class="filestyle">
    </div>

</div>
</div>