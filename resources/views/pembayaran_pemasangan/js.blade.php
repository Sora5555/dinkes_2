@push('scripts')

<script>
    $(document).ready(function(){
        $('.select2').select2();
        // let id_tagihan_pemasangan = document.querySelector('#id_tagihan_pemasangan');
        let id_tagihan = document.forms['myForm']['id_tagihan_pemasangan'].value

            if(id_tagihan_pemasangan.value != ''){
                getDatas();
            }
        
    });

    $('#id_tagihan_pemasangan').on('select2:close', function (e){
            getDatas();
        });

        function getDatas(){
            if(id_tagihan_pemasangan.value != ''){
                postData('{{ route("tagihan_pemasangan.data") }}','POST', { _token: csrfToken ,id: $('#id_tagihan_pemasangan').val() })
            .then(data => {
                console.log(data); // JSON data parsed by `data.json()` call
                document.querySelector('#nama').value= data.name;
                document.querySelector('#no_telepon').value = data.no_telepon;
                document.querySelector('#alamat').value = data.alamat;
                document.querySelector('#tipe').value = data.tipe_pembayaran;
                getTagihan(new Intl.NumberFormat().format(data.jumlah_pembayaran));

                if(data.tipe_pembayaran == 'Cash'){
                    document.querySelector('#jumlah_pembayaran').value = data.jumlah_pembayaran;
                    document.querySelector('#jumlah_pembayaran').readOnly = true;
                }
            });
            }else{
                document.querySelector('#nama').value= '';
                document.querySelector('#no_telepon').value = '';
                document.querySelector('#alamat').value = '';
                document.querySelector('#tipe').value = '';
                getTagihan(0);
            }
            
        }

    function getTagihan(value = 0){
        var val = value;
        val = val.replace(/\,/g,'');
        const p = document.querySelector('#jumlah_tagihan');
        const jumlah_pembayaran = document.querySelector('#jumlah_pembayaran');
        jumlah_pembayaran.setAttribute('max', val);
        p.innerText = value;
    }
</script>

@endpush