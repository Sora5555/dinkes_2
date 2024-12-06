
<form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
    @csrf
    <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
            @if($data->status == 0)
             @if($route == 'hariLibur')
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.edit',$data->id) }}" ><i class="fa fa-edit"></i>Edit</a>
            @else
            @if($route == 'pembayaran')
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route('tagihan.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
            @endif
            <a type="button" class="btn btn-sm btn-success m-2" href="{{ route($route.'.edit',$data->id) }}" ><i class="fa fa-edit"></i>Periksa</a>
            @endif
            @elseif($data->status == 1 || $data->status == 4 || $data->status == 5)
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route('tagihan.penetapan',$data->tagihanid) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route('tagihan.pemberitahuan',$data->tagihanid) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
            @elseif($data->status == 2)
            <a type="button" class="btn btn-sm btn-success m-2" href="{{ route('tagihan.lunas',$data->id) }}"  target='_blank'><i class="mdi mdi-notebook-check"></i>Surat Setoran</a>
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route('tagihan.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
            <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route('tagihan.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
            <button type="button" class="btn btn-primary btn-sm m-2 waves-effect waves-light image_button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" data-url='{{ asset($file_path.''.$file_name) }}' onclick="image_show('{{ asset($file_path.''.$file_name) }}')"><i class="mdi mdi-notebook-check"></i>Bukti Pembayaran</button>
            @role('Admin|superadmin')
                <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.edit',$data->id) }}" ><i class="fa fa-edit"></i>Edit</a>
            @endrole
            @elseif($data->status == 3)
            <a type="button" class="btn btn-sm btn-success m-2" href="{{ route('pembayaran.newEdit',$data->id) }}" ><i class="fa fa-edit"></i> Periksa</a>
            @endif
            
            @if($route == 'pelunasan')
             @role('Admin|superadmin')
            <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i> Hapus</button>
            @endrole
            @role('Operator')
            @endrole
            @else
            <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i> Hapus</button>
            @endif
    </div>
</form>