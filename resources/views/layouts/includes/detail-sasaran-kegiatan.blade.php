@if($data->indikatorPemerintah)

    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)

        @if(count($item->detailKegiatan) > 0)
        @foreach ($item->detailKegiatan as $item2)
            @if(count($item2->detailIndikatorKegiatan) > 0)
            <ul>
            <span class="" style="font-weight: 900">{{$item2->nama_kegiatan}}</span>
                @foreach($item2->detailIndikatorKegiatan as $key => $item3)
                    @if($key == 0)
                        <li>{{$item3->nama_sasaran_kegiatan}}</li>
                    @elseif($item3->nama_sasaran_kegiatan == $item2->detailIndikatorKegiatan[$key - 1]->nama_sasaran_kegiatan)
                        @continue
                    @else
                        <li>{{$item3->nama_sasaran_kegiatan}}</li>
                    @endif
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
                @if(count($item3->detailIndikatorKegiatan) > 0)
                <ul>
                    <span class="" style="font-weight: 900">{{$item3->nama_kegiatan}}</span>
                    @foreach ($item3->detailIndikatorKegiatan as $key => $item4)
                        @if($key == 0)
                            <li>{{$item4->nama_sasaran_kegiatan}}</li>
                        @elseif($item4->nama_sasaran_kegiatan == $item3->detailIndikatorKegiatan[$key - 1]->nama_sasaran_kegiatan)
                            @continue
                        @else
                            <li>{{$item4->nama_sasaran_kegiatan}}</li>
                        @endif
                    @endforeach
                </ul>
                @endif
            @endforeach
            @endif
            @endforeach
        @endif
    @endforeach

@endif