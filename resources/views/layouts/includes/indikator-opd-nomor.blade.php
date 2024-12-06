
    @if($data->indikatorPemerintah)
    <ul>
        <li>{{$data->indikatorPemerintah->id}}</li> 
    </ul>   
    @endif
    @if(count($data->indikatorOpd) > 0)
    <ul>
        @foreach ($data->indikatorOpd as $item)
            <li>{{$item->id}}</li>
        @endforeach
    </ul>        
    @endif