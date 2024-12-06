
    @if($data->indikatorPemerintah)
    <ul>
        <li>{{$data->indikatorPemerintah->nama}}</li>
    </ul>
    @endif
    @if(count($data->indikatorOpd) > 0)
    <ul>
        @foreach ($data->indikatorOpd as $item)
            <li>{{$item->nama}}</li>
        @endforeach   
    </ul>     
    @endif
