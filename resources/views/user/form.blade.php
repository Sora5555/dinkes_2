<div class="mb-3 row">
    <label class="col-md-2 col-form-label">Induk OPD</label>
    <div class="col-md-10">
        {!! Form::select('induk_opd_id',$induk_opd,"",['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Induk OPD']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label class="col-md-2 col-form-label">Unit Kerja</label>
    <div class="col-md-10">
        {!! Form::select('unit_kerja_id',$unit_kerja,"",['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Unit Kerja']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="example-text-input" class="col-md-2 col-form-label">Nama</label>
    <div class="col-md-10">
        {!! Form::text('nama',null,['class'=>'form-control','id'=>'example-text-input']) !!}
        {{-- <input class="form-control" type="text" name="name" id="example-text-input"> --}}
    </div>
</div>                     
<div class="mb-3 row">
    <label class="col-md-2 col-form-label">Alamat</label>
    <div class="col-md-10">
        {!! Form::text('alamat',$user->alamat,['class'=>'form-control','required'=>'required']) !!}
    </div>
</div>    
<div class="mb-3 row">
    <label for="example-email-input" class="col-md-2 col-form-label">Username</label>
    <div class="col-md-10">
        {!! Form::text('username',null,['class'=>'form-control','id'=>'example-email-input']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="example-password-input" class="col-md-2 col-form-label">Password</label>
    <div class="col-md-10">
        {!! Form::password('password',['class'=>'form-control','id'=>'example-password-input']) !!}
    </div>
</div>
<div class="mb-3 row">
    <label for="example-password-input" class="col-md-2 col-form-label">Confirm Password</label>
    <div class="col-md-10">
        {!! Form::password('password_confirmation',['class'=>'form-control','id'=>'example-password-input']) !!}
    </div>
</div>


@role("Admin") 

<div class="mb-3 row">
    <label for="example-text-input" class="col-md-2 col-form-label">Pengguna</label>
    <div class="col-md-10">
        {!! Form::select('role_id',isset($roles)?$roles:$datas, isset($daerahs)?$datas[0]->id_daerah:$user->roles->first()["id"], ['class'=>'form-control daerah','id'=>'example-text-input']) !!}
        {{-- <input class="form-control" type="text" name="name" id="example-text-input"> --}}
    </div>
</div>    
@endrole
<h6>Menu Access</h6>
<div class="mb-3 row">

@foreach($menus as $menu)
<label for="{{$menu->nama_menu}}" class="col-form-label">{{$menu->nama_menu}}</label>
<div class="col-md-10">
    <input type="checkbox" name="menu_access[]" value="{{$menu->id}}" id="ibu_hamil">
</div>
@endforeach
</div>

