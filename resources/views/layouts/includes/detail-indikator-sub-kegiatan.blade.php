@if($data->indikatorPemerintah)
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        @if(count($item->detailKegiatan) > 0)
            @foreach ($item->detailKegiatan as $item2)
            @if(count($item2->detailSubKegiatan) > 0)
                @foreach ($item2->detailSubKegiatan as $item3)
                @if(count($item3->detailIndikatorSubKegiatan) > 0)
                <ul>
                @foreach ($item3->detailIndikatorSubKegiatan as $key => $item4)
                @if($key == 0)
                <span class="" style="font-weight: 900">{{$item4->nama_sasaran_sub_kegiatan}}</span>
                @elseif($item4->nama_sasaran_sub_kegiatan == $item3->detailIndikatorSubKegiatan[$key - 1]->nama_sasaran_sub_kegiatan)
                <span class="" style="font-weight: 900"></span>
                @else
                <span class="" style="font-weight: 900">{{$item4->nama_sasaran_sub_kegiatan}}</span>
                @endif
                <li>{{$item4->nama_indikator_sub_kegiatan}}</li>
                @endforeach
            </ul>
                @endif
                @endforeach
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
                        @foreach ($item3->detailSubKegiatan as $item4)
                        @if(count($item4->detailIndikatorSubKegiatan) > 0)
                        <ul>
                            @foreach ($item4->detailIndikatorSubKegiatan as $key => $item5)
                                @if($key == 0)
                                <span class="" style="font-weight: 900">{{$item5->nama_sasaran_sub_kegiatan}}</span>
                                @elseif($item5->nama_sasaran_sub_kegiatan == $item4->detailIndikatorSubKegiatan[$key - 1]->nama_sasaran_sub_kegiatan)
                                <span class="" style="font-weight: 900"></span>
                                @else
                                <span class="" style="font-weight: 900">{{$item5->nama_sasaran_sub_kegiatan}}</span>
                                @endif
                                <li>{{$item5->nama_indikator_sub_kegiatan}}</li>
                            @endforeach
                        </ul>
                        @endif  
                        @endforeach
                    @endif
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach

@endif