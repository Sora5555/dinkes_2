<span>{{$data->uraian}}</span>
@if(!$data->Pemangku)
<form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
@else
<form action="{{ route($route.'.destroy',$data->Pemangku->id) }}" method="POST" class="delete-data">
@endif
    @csrf
    <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
            <a type="button" class="btn btn-sm btn-warning m-2 btn-edit-program" id="{{$data->id}}"><i class="fa fa-edit"></i> Edit</a>
            <a type="button" class="btn btn-sm m-2 btn-tambah-sasaran" style="background: #f7ac42" id="{{$data->id}}"><i class="fa fa-plus"></i> Tambah</a>
            @if(count($data->Sasaran) <= 0)
            <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
            @endif
    </div>
</form>