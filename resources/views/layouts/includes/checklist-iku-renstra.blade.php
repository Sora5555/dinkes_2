
    @if($data->indikatorPemerintah)
    <ul>
        <li><input type="checkbox" class="checklist-iku-renstra" name="" id="{{$data->indikatorPemerintah->id}}" {{$data->indikatorPemerintah->iku==1?"checked":""}}></li>
    </ul>
    @endif
    @if(count($data->indikatorOpd) > 0)
    <ul>
        @foreach ($data->indikatorOpd as $item)
            <li><input type="checkbox" class="checklist-iku-opd" name="" id="{{$item->id}}"></li>
        @endforeach
    </ul>
    @endif