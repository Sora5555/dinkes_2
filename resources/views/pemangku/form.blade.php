<div class="mb-3 row">
    <label for="example-text-input" class="col-md-2 col-form-label">daerah</label>
    <div class="col-md-10">
        {!! Form::select('daerah_id',isset($daerahs)?$daerahs:$datas, isset($daerahs)?$datas[0]->id_daerah:null, ['class'=>'form-control daerah','id'=>'example-text-input','placeholder'=>'pilih daerah']) !!}
        {{-- <input class="form-control" type="text" name="name" id="example-text-input"> --}}
    </div>
</div>                  
<div class="mb-3 row">
    <label for="example-email-input" class="col-md-2 col-form-label">Target</label>
    <div class="col-md-10">
        {!! Form::number('target', isset($datas[0]->target) ?$datas[0]->target:0,['class'=>'form-control','id'=>'example-number-input']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="example-email-input" class="col-md-2 col-form-label">Realisasi</label>
    <div class="col-md-10">
        {!! Form::number('realisasi', isset($datas[0]->realisasi) ?$datas[0]->realisasi:0,['class'=>'form-control','step'=>'any','id'=>'example-number-input', isset($datas[0]->realisasi)?"":"readonly"=>"readonly"]) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="example-tel-input" class="col-md-2 col-form-label">tahun</label>
    <div class="col-md-10">
        {!! Form::number('year', $year,['class'=>'form-control','id'=>'example-tel-input']) !!}
    </div>
</div>
{{-- <div class="mb-3 row">
    <label class="col-md-2 col-form-label">Role</label>
    <div class="col-md-10">
        {!! Form::select('role_id',$roles,isset($user)?$user->roles->pluck('id'):null,['class'=>'form-control roles','placeholder'=>'pilih role']) !!}
    </div>
</div> --}}
