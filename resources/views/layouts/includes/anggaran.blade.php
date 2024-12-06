@if($data->indikatorPemerintah)
    @if(count($data->indikatorPemerintah->detailProgram) > 0)
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        @if(count($item->detailKegiatan) > 0)
            @foreach ($item->detailKegiatan as $item2)
            @if(count($item2->detailSubKegiatan) > 0)
            <ul>
                @foreach ($item2->detailSubKegiatan as $item3)
                <span class="" style="font-weight: 900">{{$item3->nama_sub_kegiatan}}</span>
                    <li>Rp. {{number_format($item3->subKegiatan->pagu_indikatif)}}</li>  
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
                        @foreach ($item3->detailSubKegiatan as $item4)
                        <span class="" style="font-weight: 900">{{$item4->nama_sub_kegiatan}}</span>
                            <li>Rp. {{number_format($item4->subKegiatan->pagu_indikatif)}}</li>    
                        @endforeach
                    </ul>
                    @endif
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach

@endif