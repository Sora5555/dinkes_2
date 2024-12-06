<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Jenis Denda</label>
    <div class="col-md-10">
        {!! Form::select('type',['Sanksi Administrasi'=>'Sanksi Administrasi','Denda Keterlambatan'=>'Denda Keterlambatan'],null,['class'=>'form-control','id'=>'type_denda','placeholder'=>'pilih jenis denda']) !!}    
    </div>
</div>
<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Tanggal Jatuh Tempo</label>
    <div class="col-md-10">
        {!! Form::selectRange('tanggal_jt',1,31,null,['class'=>'form-control','id'=>'jenis_pengali','placeholder'=>'pilih tanggal jatuh tempo']) !!}   
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Bentuk Denda</label>
    <div class="col-md-10">
        {!! Form::select('jenis_pengali',['persen'=>'persen','rupiah'=>'rupiah'],null,['class'=>'form-control','id'=>'jenis_pengali','placeholder'=>'pilih bentuk denda']) !!}   
    </div>
</div>

<div class="mb-3 row">
    <label for="name" class="col-md-2 col-form-label">Nominal Denda</label>
    <div class="col-md-10">
        {!! Form::number('nominal_denda',null,['class'=>'form-control','id'=>'nominal_denda']) !!}  
        <span style="color:orange; font-weight: bold;">*jika jenis denda dalam bentuk Persen(%) maka inputkan jumlah persenannya</span>
        <br>  
        <span style="color:orange; font-weight: bold;">*jika jenis denda dalam bentuk Rupiah(Rp) maka inputkan jumlah rupiahnya</span>  
    </div>
</div>