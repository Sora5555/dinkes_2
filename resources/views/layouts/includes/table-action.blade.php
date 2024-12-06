<form action="{{ route($route.'.destroy',$data->id) }}" method="POST" class="delete-data">
    @csrf
    <div class="btn-group" role="group" aria-label="Action Button">
            <input type="hidden" name="_method" value="DELETE">
            @if($data->status == 0)
                <div class="d-flex flex-column">
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.edit',$data->id) }}" ><i class="fa fa-edit"></i> Edit</a>
                    @if($route == 'tagihan')
                    @endif
                    @if($route == 'user' && Auth::user()->roles->first()->name == "Operator")
                    @else
                    <button type="submit" class="m-2 btn btn-sm btn-danger text-white delete-data"><i class="fa fa-trash"></i>Hapus</button>
                    @endif
                    @if($data->id_tagihan)
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
                    @endif
                </div>
            
            @elseif($data->status == 1 || $data->status == 5)
                <div class="d-flex flex-column">
                    <a type="button" class="btn btn-sm btn-primary m-2" href="{{ route($route.'.upload',$data->id) }}"><i class="mdi mdi-arrow-up-thick"></i>Upload Bukti</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
                    {{-- <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.surat',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>STPD</a> --}}
                </div>
            
            {{-- @elseif($data->status == 5)
                <div class="d-flex flex-column">
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.surat',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>STPD</a>
                    <a type="button" class="btn btn-sm btn-primary m-2" href="{{ route($route.'.upload',$data->id) }}"><i class="mdi mdi-arrow-up-thick"></i>Upload Bukti</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>Surat Penetapan</a>
                </div> --}}
            
            @elseif($data->status == 6)
                <div class="d-flex flex-column">
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.surat',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>STPD</a>
                    <a type="button" class="btn btn-sm btn-primary m-2" href="{{ route($route.'.upload',$data->id) }}"><i class="mdi mdi-arrow-up-thick"></i>Upload Bukti</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>Surat Penetapan</a>
                </div>
            
            @elseif($data->status == 3)
                <div class="d-flex flex-column">
                    <a type="button" class="btn btn-sm btn-primary m-2" href="{{ route($route.'.upload',$data->id) }}"><i class="fa fa-edit"></i>Edit Bukti</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
                    <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
                    <button type="button" class="btn btn-primary btn-sm waves-effect waves-light image_button" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" data-url='{{ asset($url) }}' onclick="image_show('{{ asset($url) }}')"><i class="mdi mdi-notebook-check"></i>Bukti Pembayaran</button>
                </div>
            
            @elseif($data->status == 2)
            <div class="d-flex flex-column">
                <button type="button" class="btn btn-sm btn-danger m-2" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" data-url='{{ asset($url) }}' onclick="image_show('{{ asset($url2) }}')"><i class="mdi mdi-beaker-plus"></i>Gambar Pemakaian</button>
                <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.penetapan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SKPD</a>
                <a type="button" class="btn btn-sm btn-warning m-2" href="{{ route($route.'.pemberitahuan',$data->id) }}"  target='_blank'><i class="mdi mdi-note"></i>SPOPD</a>
            </div>
            @endif
    </div>
</form>

