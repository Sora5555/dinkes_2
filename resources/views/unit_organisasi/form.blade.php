<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Nama</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::text('nama',null,['class'=>'form-control','id'=>"nama"]) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Eselon</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
         {!! Form::select('eselon_id',$eselon_arr, $UnitOrganisasi->eselon_id,['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Eselon']) !!}
    </div>
</div>