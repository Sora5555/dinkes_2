@if($data->indikatorPemerintah)

    @if(count($data->indikatorPemerintah->detailProgram) > 0)
    <ul>
        @foreach($data->indikatorPemerintah->detailProgram as $item)
        <span class="" style="font-weight: 900">{{$item->nama_program}}</span>
            <li><input type="checkbox" class="checkbox-program-pemerintah" name="" id="{{$item->id}}"></li>
        @endforeach
    </ul>
    @endif
@endif
@if(count($data->indikatorOpd) > 0)

    @foreach ($data->indikatorOpd as $item)
        @if(count($item->detailProgram) > 0)
            <ul>
                @foreach ($item->detailProgram as $item2)
                <span class="" style="font-weight: 900">{{$item2->nama_program}}</span>
                <li><input type="checkbox" class="checkbox-program-opd" name="" id="{{$item2->id}}"></li>
                @endforeach
            </ul>
        @endif
    @endforeach

@endif