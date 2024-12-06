<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Awalan Surat</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::text('awalan_surat',null,['class'=>'form-control','id'=>'nama_daerah']) !!}    
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Urutan</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::text('urutan',null,['class'=>'form-control','id'=>'urutan']) !!}    
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Kode Wilayah</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::text('kode_wilayah',null,['class'=>'form-control','id'=>'kode_wilayah']) !!}    
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">tahun</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::number('tahun',null,['class'=>'form-control','id'=>'tahun']) !!}    
    </div>
</div>
<div class="mb-3 row">
    <label for="daerah_id" class="col-md-2 col-form-label">Nama Daerah</label>
</div>
<div class="mb-3 row">
    <div class="col-md-10">
        {!! Form::select('daerah_id', $data, null,['class'=>'form-control','id'=>'daerah_id'], ['0' => 'pilih wilayah']) !!}    
    </div>
</div>