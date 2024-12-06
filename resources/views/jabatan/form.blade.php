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
<div class="append-element">
    @if(isset($npa))
        @if($npa->wilayah->count() > 0)
        <div class="mb-3 row">
            <label for="example-text-input" class="col-md-2 col-form-label">Wilayah</label>
            <div class="col-md-10">
                {!! Form::select('wilayah_id[]',$wilayah,isset($npa)?$npa->wilayah->pluck('id'):null,['class'=>'form-control wilayah','id'=>'example-text-input','multiple'=>'multiple']) !!}
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
        @endif
    @endif
</div>
