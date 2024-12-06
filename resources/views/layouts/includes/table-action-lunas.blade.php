<div class="d-flex flex-column">
    <button type="button" class="btn btn-dark btn-sm waves-effect waves-light image_button m-2" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" data-url='{{ asset($url) }}' onclick="image_show('{{ asset($url) }}')"><i class="mdi mdi-cash"></i>Bukti Pembayaran</button>
                <a type="button" class="btn btn-sm btn-success m-2" href="{{ route($route.'.lunas',$data->id) }}"  target='_blank'><i class="mdi mdi-notebook-check"></i>Surat Setoran</a>
</div>