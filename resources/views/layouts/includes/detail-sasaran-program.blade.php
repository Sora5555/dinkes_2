@if($data->indikatorPemerintah)
<ul>
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        <span class="" style="font-weight: 900">{{$item->nama_program}}</span>
            @if(count($item->detailIndikatorProgram) > 0)
                @foreach($item->detailIndikatorProgram as $key => $item2)
                    @if($key == 0)
                        <li>{{$item2->nama_sasaran_program}}</li>
                    @elseif($item2->nama_sasaran_program == $item->detailIndikatorProgram[$key - 1]->nama_sasaran_program)
                        @continue
                    @else
                        <li>{{$item2->nama_sasaran_program}}</li>
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
</ul>
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
    <ul>
        @if(count($item->detailProgram) > 0)
            @foreach ($item->detailProgram as $item2)
            <span class="" style="font-weight: 900">{{$item2->nama_program}}</span>
            @if(count($item2->detailIndikatorProgram) > 0)
                @foreach ($item2->detailIndikatorProgram as $key => $item3)
                    @if($key == 0)
                        <li>{{$item3->nama_sasaran_program}}</li>
                    @elseif($item3->nama_sasaran_program == $item2->detailIndikatorProgram[$key - 1]->nama_sasaran_program)
                        @continue
                    @else
                        <li>{{$item3->nama_sasaran_program}}</li>
                    @endif
                @endforeach
            @endif
            @endforeach
        @endif
    </ul>
    @endforeach

@endif