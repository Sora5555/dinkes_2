@if($data->indikatorPemerintah)

    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
            @if(count($item->detailIndikatorProgram) > 0)
            <ul>
                @foreach($item->detailIndikatorProgram as $key => $item2)
                @if($key == 0)
                    <span class="" style="font-weight: 900">{{$item2->nama_sasaran_program}}</span>
                @elseif($item2->nama_sasaran_program == $item->detailIndikatorProgram[$key - 1]->nama_sasaran_program)
                    <span class="" style="font-weight: 900"></span>
                @else
                <span class="" style="font-weight: 900">{{$item2->nama_sasaran_program}}</span>
                 @endif
                    <li>{{$item2->nama_indikator_program}}</li>
                @endforeach
            </ul>
            @endif
        @endforeach
    @endif
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
        @if(count($item->detailProgram) > 0)
            @foreach ($item->detailProgram as $item2)
            @if(count($item2->detailIndikatorProgram) > 0)
            <ul>
                @foreach($item2->detailIndikatorProgram as $key => $item3)
                @if($key == 0)
                    <span class="" style="font-weight: 900">{{$item3->nama_sasaran_program}}</span>
                @elseif($item3->nama_sasaran_program == $item2->detailIndikatorProgram[$key - 1]->nama_sasaran_program)
                    <span class="" style="font-weight: 900"></span>
                @else
                <span class="" style="font-weight: 900">{{$item3->nama_sasaran_program}}</span>
                 @endif
                    <li>{{$item3->nama_indikator_program}}</li>
                @endforeach
            </ul>
            @endif
            @endforeach
        @endif
    @endforeach

@endif