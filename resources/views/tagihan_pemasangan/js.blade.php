@push('scripts')

<script>
    
    $(document).ready(function(){
        getTagihan(3300000);
        $('.select2').select2();

        const bulan = document.querySelector('#bulan');
        const tahun = document.querySelector('#tahun');

        
        
    });

    $('#id_pelanggan').on('select2:close', function (e){
        getDatas();
    });

    function getDatas(){
        postData('{{ route("pelanggan.data") }}','POST', { _token: csrfToken ,id: $('#id_pelanggan').val() })
        .then(data => {
            console.log(data); // JSON data parsed by `data.json()` call
            document.querySelector('#nama').value= data.name;
            document.querySelector('#no_telepon').value = data.no_telepon;
            document.querySelector('#alamat').value = data.alamat;
        });
    }

    function getTagihan(value = 0){
        const p = document.querySelector('#jumlah_tagihan');
        p.innerText = value;
    }

    let tipeCash = document.querySelector('#cash');
    let tipeAngsur = document.querySelector('#angsuran');
    tipeCash.addEventListener('click', (event)=>{
        let tipe = document.querySelector('input[name="tipe_pembayaran"]:checked').value;
        // console.log(tipe);
        getTagihan(3300000);
    });
    tipeAngsur.addEventListener('click', (event)=>{
        let tipe = document.querySelector('input[name="tipe_pembayaran"]:checked').value;
        // console.log(tipe);
        getTagihan(1300000);
    });
</script>

@endpush