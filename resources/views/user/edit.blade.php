@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Ubah {{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Data</a></li>
                        <li class="breadcrumb-item active">Ubah {{$title}}</li>
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
                    {!! Form::model($user,['route'=>['user.update',$user->id],'method'=>'PUT']) !!}
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Induk OPD</label>
                        <div class="col-md-10">
                            {!! Form::select('induk_opd_id',$induk_opd,isset($user->induk_opd_id)?$user->induk_opd_id:"",['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Induk OPD']) !!}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-md-2 col-form-label">Unit Kerja</label>
                        <div class="col-md-10">
                            {!! Form::select('unit_kerja_id',$unit_kerja,isset($user->unit_kerja)?$user->unit_kerja:"",['class'=>'form-control daerah','required'=>'required','placeholder'=>'Pilih Unit Kerja']) !!}
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
                                <input type="checkbox" name="menu_access[]" value="{{$menu->id}}" id="ibu_hamil" {{$menu_permission->contains('menu_id', $menu->id)?"checked":""}}>
                            </div>
                            @endforeach
                        </div>
                    
                        <div class="mb-3 row">
                            <div class="col-md-11">
                                
                            </div>
                            <div class="col-md-1">
                                <input type="submit" value="Submit" class="btn btn-primary">
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>
@endsection

@push('scripts')
<script type="text/javascript">
        $('.roles').change(function(){
            var role = $(this).val();
            if (role =='2') {
                $('.add-field').html($('#wp-component').html());
            }else if(role =='3'){
                $('.add-field').html($('#opr_content').html());
                $('.field_daerah').html('');
            }else{
                $('.add-field').html('');
            }
        });

        $('body').on('change','.kategori',function(){
            var kategori = $('.kategori option:selected');
            if (kategori.text() !== 'BUMN' && kategori.text() !== 'BUMD') {
                if (!$('.daerah').length) {
                    $('.field_daerah').html($('#field_daerah').html());
                }
            }else{
                $('.daerah').closest('.mb-3').remove();
                $('.field_daerah').html('');
            }
        });
            function deleteRow(row){
                row.parentElement.parentElement.remove();
            }

            // delete1.addEventListener('click', (e) => {
            //     const delete2 = document.querySelector(".hapus");
            //     delete2.parentElement.parentElement.remove();
            // })
        // $(document).ready(function(){
        //     $('.select2').select2();
        // });

        // $('.kategori').select2({
        //             placeholder:'pilih wilayah',
        //             multiple:true,
        //             width:'100%',
        //             allowClear:true,
        //         });
        // $('.kategori').val('').trigger('change');
    </script>
    <script type="text/template" id="wp-component">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Kategori</label>
            <div class="col-md-10">
                {!! Form::select('kategori_industri_id',$kategori,null,['class'=>'form-control kategori','required'=>'required','placeholder'=>'pilih kategori']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">NIK</label>
            <div class="col-md-10">
                {!! Form::number('nik',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Alamat</label>
            <div class="col-md-10">
                {!! Form::text('alamat',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
    </script>

    <script type="text/template" id="field_daerah">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Daerah</label>
            <div class="col-md-10">
                {!! Form::select('daerah_id',$induk_opd,null,['class'=>'form-control','required'=>'required','placeholder'=>'pilih daerah']) !!}
            </div>
        </div>
    </script>

    <script type="text/template" id="opr_content">
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">NIK</label>
            <div class="col-md-10">
                {!! Form::number('nik',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Alamat</label>
            <div class="col-md-10">
                {!! Form::text('alamat',null,['class'=>'form-control','required'=>'required']) !!}
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-md-2 col-form-label">Daerah</label>
            <div class="col-md-10">
                {!! Form::select('daerah_id',$induk_opd,null,['class'=>'form-control','required'=>'required','placeholder'=>'pilih daerah']) !!}
            </div>
        </div>
    </script>
@endpush