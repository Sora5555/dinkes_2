@push('scripts')

<script>
    $(document).ready(function(){
        $('.select2').select2();

        const bulan = document.querySelector('#bulan');
        const tahun = document.querySelector('#tahun');

        // let id_pelunasan = document.querySelector('#id_pelunasan');
        let id_pembayaran = document.forms['myForm']['id_pembayaran'].value
        if(id_pembayaran.value != ''){
                getDatas();
            }
    });

    $('#id_pembayaran').on('select2:close', function (e){
            getDatas();
        });

        function getDatas()
        {
            if(id_pembayaran.value != ''){
            postData('{{ route("pembayaran.data") }}','POST', { _token: csrfToken ,id: $('#id_pembayaran').val() })
            .then(data => {
                console.log(data);
                let total = data.total_pemakaian;
                console.log(data); // JSON data parsed by `data.json()` call
                document.querySelector('#nama').value= data.name;
                document.querySelector('#no_telepon').value = data.no_telepon;
                document.querySelector('#alamat').value = data.alamat;
                document.querySelector('#total_pemakaian').value = data.total_pemakaian;
                if(total < 999){
                getTagihan(data.jumlah_pembayaran);
            } else {
                getTagihan(data.jumlah_pembayaran)
            }
                console.log(data.bulan);
                bulan.selectedIndex = [...bulan.options].findIndex (option => option.value === data.bulan);
                tahun.selectedIndex = [...tahun.options].findIndex (option => option.value === data.tahun);
            });
            }else{
                document.querySelector('#nama').value= '';
                document.querySelector('#no_telepon').value = '';
                document.querySelector('#alamat').value = '';
                document.querySelector('#total_pemakaian').value = '';
                getTagihan(0);
            }
        }

    function getTagihan(value = 0){
        const p = document.querySelector('#jumlah_tagihan');
        p.innerText = value;
    }
</script>

@endpush