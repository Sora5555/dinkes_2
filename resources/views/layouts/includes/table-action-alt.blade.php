<form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
    @csrf
    <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
            @if($data->status == 'Belum Lunas')
            <a href="{{ route('pembayaran.create') }}?id={{$data->id}}" class="btn btn-sm btn-success m-2"><i class="fa fa-edit"></i> Bayar</a>
            @else
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.nota',$data->id) }}" target="_blank"><i class="fa fa-edit"></i> Nota</a>
            @endif
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.edit',$data->id) }}" ><i class="fa fa-edit"></i> Edit</a>
            <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i> Hapus</button>
    </div>
</form>