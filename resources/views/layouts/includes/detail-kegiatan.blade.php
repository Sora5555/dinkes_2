@if($data->indikatorPemerintah)
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        @if(count($item->detailKegiatan) > 0)
        <ul>
            <span class="" style="font-weight: 900">{{$item->nama_program}}</span>
            @foreach ($item->detailKegiatan as $item2)
                <li>{{$item2->nama_kegiatan}}</li>  
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
                @if(count($item2->detailKegiatan) > 0)
                <ul>
                    <span class="" style="font-weight: 900">{{$item2->nama_program}}</span>
                    @foreach ($item2->detailKegiatan as $item3)
                        <li>{{$item3->nama_kegiatan}}</li>  
                    @endforeach
                </ul>
                @endif
            @endforeach
        @endif
    @endforeach

@endif