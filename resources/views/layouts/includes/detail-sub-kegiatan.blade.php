@if($data->indikatorPemerintah)
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        @if(count($item->detailKegiatan) > 0)
            @foreach ($item->detailKegiatan as $item2)
            @if(count($item2->detailSubKegiatan) > 0)
            <ul>
                <span class="" style="font-weight: 900">{{$item2->nama_kegiatan}}</span>
                @foreach ($item2->detailSubKegiatan as $item3)
                    <li>{{$item3->nama_sub_kegiatan}}</li>  
                @endforeach
            </ul>
            @endif
            @endforeach
        @endif
        @endforeach
    @endif
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
        @if(count($item->detailProgram) > 0)
            @foreach ($item->detailProgram as $item2)
                @if(count($item2->detailKegiatan) > 0)
                    @foreach ($item2->detailKegiatan as $item3)
                    @if(count($item3->detailSubKegiatan) > 0)
                    <ul>
                    <span class="" style="font-weight: 900">{{$item3->nama_kegiatan}}</span>
                        @foreach ($item3->detailSubKegiatan as $item4)
                            <li>{{$item4->nama_sub_kegiatan}}</li>    
                        @endforeach
                    </ul>
                    @endif
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach

@endif