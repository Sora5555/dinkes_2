<ul>
    @foreach ($data->Sasaran as $sasaran)
    @if(count($sasaran->Indikator) > 0)
        <li>
            <span class="" style="font-weight: 900">{{$sasaran->nama}}</span>
            <ul>
                @foreach ($sasaran->Indikator as $indikator)
                    <li>
                        <span>{{$indikator->nama}}</span>
                        <form action="{{ route($route.'.destroy',$indikator->id) }}" method="POST" class="delete-data">
                            @csrf
                            <div class="btn-group" role="group" aria-label="Action Button">
                                <input type="hidden" name="_method" value="DELETE">
                                <a type="button" class="btn btn-sm btn-warning m-2 btn-edit-indikator" id="{{$indikator->id}}"><i class="fa fa-edit"></i> Edit</a>
                                <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
                            </div>
                            </form>
                    </li>
                @endforeach
            </ul>
        </li>
        @endif
    @endforeach
</ul>
    