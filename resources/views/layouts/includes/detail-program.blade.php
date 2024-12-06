@if($data->indikatorPemerintah)
<ul>
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
            <li>{{$item->nama_program}}</li>
        @endforeach
    @endif
</ul>
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
    <ul>
        @if(count($item->detailProgram) > 0)
            @foreach ($item->detailProgram as $item2)
                <li>{{$item2->nama_program}}</li>
            @endforeach
        @endif
    </ul>
    @endforeach

@endif