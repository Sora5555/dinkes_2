
<ul>
    @foreach ($data->sasaran as $sasaran)
        <li>
            <span>{{$sasaran->nama}}</span>

            <form action="{{ route($route.'.destroy',$sasaran->id) }}" method="POST" class="delete-data">
            @csrf
            <div class="btn-group" role="group" aria-label="Action Button">
                <input type="hidden" name="_method" value="DELETE">
                <a type="button" class="btn btn-sm btn-warning m-2 btn-edit-sasaran" id="{{$sasaran->id}}"><i class="fa fa-edit"></i> Edit</a>
                <a type="button" class="btn btn-sm m-2 btn-tambah-indikator" style="background: #f7ac42" id="{{$sasaran->id}}"><i class="fa fa-plus"></i> Tambah</a>
                @if(count($sasaran->Indikator) <= 0)
                <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
                @endif
            </div>
            </form>
        </li>
    @endforeach
</ul>
    