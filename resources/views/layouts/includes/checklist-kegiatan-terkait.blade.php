@if($data->indikatorPemerintah)

    @if(count($data->indikatorPemerintah->detailProgram) > 0)
    <ul>
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        @if(count($item->detailKegiatan) > 0)
            @foreach ($item->detailKegiatan as $item2)
            <span class="" style="font-weight: 900">{{$item2->nama_kegiatan}}</span>
            <li><input type="checkbox" class="checkbox-kegiatan-pemerintah" name="" id="{{$item2->id}}"></li>
            @endforeach
        @endif
        @endforeach
    </ul>
    @endif
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
        @if(count($item->detailProgram) > 0)
            <ul>
                @foreach ($item->detailProgram as $item2)
                @if(count($item2->detailKegiatan) > 0)
                    @foreach ($item2->detailKegiatan as $item3)
                    <span class="" style="font-weight: 900">{{$item3->nama_kegiatan}}</span>
                    <li><input type="checkbox" class="checkbox-kegiatan-opd" name="" id="{{$item3->id}}"></li>  
                    @endforeach
                @endif
                @endforeach
            </ul>
        @endif
    @endforeach

@endif