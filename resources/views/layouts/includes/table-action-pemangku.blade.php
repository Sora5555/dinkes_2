@if($route == "pemangku")
    @if(!$data->Pemangku)
        <form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
    @else
        <form action="{{ route($route.'.destroy',$data->Pemangku->id) }}" method="POST" class="delete-data">
    @endif
        @csrf
        <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
                @if($data->Pemangku)
                    <a type="button" class="btn btn-sm btn-warning m-2 btn-mod2" id="{{$data->Pemangku->id}}" induk_opd_id="{{$data->induk_opd_id}}" induk_jabatan_id="{{$data->induk_jabatan_id}}" jenis_jabatan_id="{{$data->jenis_jabatan_id}}" golongan_id="{{$data->Pemangku->golongan_id}}" unit_organisasi_id="{{$data->unit_organisasi_id}}"><i class="fa fa-edit"></i> Edit</a>
                    <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
                @else
                    <a type="button" class="btn btn-sm m-2 btn-mod" style="background: #f7ac42" id="{{$data->id}}"><i class="fa fa-plus"></i> Tambah</a>
                @endif
            </div>
        </form>
@else
<a type="button" class="btn btn-sm m-2" style="background: #42c1f7" href="{{ route($route.'.pdf_perjanjian_kinerja',$data->id) }}"  target='_blank'><i class="fa fa-print"></i>cetak</a>
@endif
