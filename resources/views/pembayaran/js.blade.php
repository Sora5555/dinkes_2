@push('scripts')

<script>
    $(document).ready(function(){
        $('.select2').select2();

        const bulan = document.querySelector('#bulan');
        const tahun = document.querySelector('#tahun');

        // let id_tagihan = document.querySelector('#id_tagihan');
        let id_tagihan = document.forms['myForm']['id_tagihan'].value
        if(id_tagihan.value != ''){
                getDatas();
            }
    });

    $('#id_tagihan').on('select2:close', function (e){
            getDatas();
        });

        function getDatas()
        {
            if(id_tagihan.value != ''){
            postData('{{ route("tagihan.data") }}','POST', { _token: csrfToken ,id: $('#id_tagihan').val() })
            .then(data => {
                console.log(data); // JSON data parsed by `data.json()` call
                document.querySelector('#nama').value= data.name;
                document.querySelector('#no_telepon').value = data.no_telepon;
                document.querySelector('#alamat').value = data.alamat;
                document.querySelector('#total_pemakaian').value = data.total_pemakaian;
                getTagihan(data.total_pemakaian * 11500);

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

    // function getTagihan(value = 0){
    //     const p = document.querySelector('#jumlah_tagihan');
    //     p.innerText = value;
    // }
</script>

@endpush