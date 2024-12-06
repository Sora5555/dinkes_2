
@if($data->indikatorPemerintah)
<ul>
    <li><input type="checkbox" class="checklist-indikator-pemerintah-berkualitas" name="" id="{{$data->indikatorPemerintah->id}}" {{$data->indikatorPemerintah->berkualitas == 1?"checked":""}}></li>
</ul>
@endif
@if(count($data->indikatorOpd) > 0)
<ul>
    @foreach ($data->indikatorOpd as $item)
        <li><input type="checkbox" class="checklist-indikator-opd-berkualitas" name="" id="{{$item->id}}" {{$item->berkualitas == 1?"checked":""}}></li>
    @endforeach
</ul>
@endif