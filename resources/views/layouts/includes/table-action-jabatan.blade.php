<form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
    @csrf
    <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
            <a type="button" class="btn btn-sm btn-warning m-2 btn-mod2" id="{{$data->id}}" induk_opd_id="{{$data->induk_opd_id}}" induk_jabatan_id="{{$data->induk_jabatan_id}}" jenis_jabatan_id="{{$data->jenis_jabatan_id}}" unit_organisasi_id="{{$data->unit_organisasi_id}}"><i class="fa fa-edit"></i> Edit</a>
            <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
    </div>
</form>

