<style>
    table{
        width: 100%;
        text-align: center;
    }
    .table{
        border: 1px solid #ddd;
        border-collapse: collapse;
    }
    tr{
        border: 1px solid #ddd;
    }
    .bold{
        font-weight: 600;
    }
    .container{
        display: flex;
        width: 100%;
        justify-content: space-around;
    }
    .container > div{
        display: flex;
        flex-direction: column;
        gap: 0;
        padding-right: 100px;
    }
    .intro{
        width: 40%;
        margin-inline: auto;
        margin-block: 30px;
    }
    p{
        text-indent: 30px;
    }
    .heading{
        text-align: center
    }
    img{
        width: 5%;
    }
    h5{
        display: inline;
        margin: 0;
        padding: 0;
    }
    .cop{
        display: flex;
        justify-content: flex-start;
        width: 70%;
        align-items: center;
        margin-inline: left;
    }
    .image{
        width: 20%;
        text-align: center
    }
    img{
        width: 40%;
    }
</style>

<div class="cop">
    <div>
        <h3>PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
        <h3>BADAN PENDAPATAN DAERAH</h3>
        <h3>UPTD. PPRD WILAYAH {{$datas->pelanggan->daerah->nama_daerah}}</h3>
    </div>
    <div class="image"><img src="{{asset('assets/images/logo.png')}}" alt=""></div>
</div>
<table>
    {{-- <tr align="center">
        <td colspan="3"><img src="{{asset('assets/images/logo.png')}}" alt=""></td>
    </tr> --}}
    <tr align="center" style="text-decoration: underline">
        <td colspan="3" class="bold">SURAT SETORAN PAJAK DAERAH</td>
    </tr>
    <tr align="center">
        <td colspan="3" class="bold">Nomor: {{$datas->nomor_surat_setoran}}</td>
    </tr>
    {{-- <tr align="center">
        <td colspan="3" style="padding-bottom:40px">{{ date("d-M-Y") }}</td>
    </tr> --}}
    <table>
        <tr align="left" style="margin-block: 5px">
            <td style="padding-block: 5px">
                Bendahara Penerima/penerima pembantu {{$datas->pelanggan->daerah->nama_daerah}}
            </td>
            {{-- <td>Rp. {{number_format($datas->jumlah_pembayaran + $datas->denda_harian + $datas->denda_admin)}}</td> --}}
        </tr>
        <tr align="left" style="margin-block: 20px">
            <td style="padding-bottom: 10px">
                Telah Terima Dari:
            </td>
            <td style="padding-bottom: 10px"></td>
            {{-- <td>{{$word}}</td> --}}
        </tr>
        <tr align="left" style="margin-block: 5px">
            <td style="padding-top: 5px">
                Nama: 
            </td>
            <td style="padding-top: 5px">{{$datas->pelanggan->name}}</td>
        </tr>
        <tr align="left" style="margin-block: 5px">
            <td style="padding-bottom: 5px">
                Alamat: 
            </td>
            <td style="padding-bottom: 5px">{{$datas->pelanggan->alamat}}</td>
        </tr>
        <tr align="left" style="margin-block: 5px">
            <td style="padding-bottom: 5px">
                Uang Sebesar:  
            </td>
            <td>Rp. {{number_format($datas->jumlah_pembayaran + $datas->denda_harian + $datas->denda_admin)}}</td>
        </tr>
        <tr align="left" style="margin-block: 5px">
            <td style="padding-bottom: 5px">
                Dengan Huruf:   
            </td>
            <td>( {{$word}} )</td>
        </tr>
        <tr align="left" style="margin-block: 5x">
            <td style="padding-bottom: 5px">
                Sebagai Pembayaran
            </td>
            <td>Pajak Air Permukaan
                <div>
                    periode: {{$datas->tanggal->isoFormat("MMMM-Y")}}
                </div>
            </td>
        </tr>

    </table>

        <table class="table">
            <tr>
                <th>Rekening Penerima</th>
                <th>Uang Diatas Diterima {{$datas->pelanggan->daerah->nama_daerah}}, {{$datas->tanggal_penerimaan}}</th>
                <th>{{$datas->pelanggan->daerah->nama_daerah}}, {{$datas->tanggal_penerimaan}}</th>
            </tr>
            <tr>
                <td>Mengetahui Kepala {{$datas->pelanggan->daerah->nama_daerah}}: {{$datas->jabatan?$datas->jabatan->nama:""}}</td>
                <td>Bendahara Penerima: {{$datas->jabatan3?$datas->jabatan3->nama:""}}</td>
                <td>Penyetor: {{$datas->pelanggan->name}}</td>
            </tr>
            {{-- <tr>
                <td>Denda Keterlambatan</td>
                <td>-</td>
                <td>Rp.{{number_format($datas->denda_harian)}}</td>
            </tr>
            <tr>
                <td>Sanksi Administrasi</td>
                <td>-</td>
                <td>Rp.{{number_format($datas->denda_admin)}}</td>
            </tr>
            <tr>
                <td colspan="2">Jumlah</td>
                <td>Rp.{{number_format($datas->denda_admin + $datas->denda_harian + $datas->jumlah_pembayaran)}}</td>
            </tr> --}}
        </table>
        <table>
            {{-- <tr align="left" style="margin-block: 2rem">
                <td style="padding-block: 0px">
                    e. Tanggal diterima uang:
                </td>
                <td>
                    {{$datas->pembayaran->pelunasan->created_at->isoFormat("D-MMMM-Y")}}
                </td>
            </tr> --}}
        </table>
        {{-- <div style="display: flex; flex-direction:column; align-items:flex-end; justify-content:space-around">
            <h3>{{$datas->pelanggan->daerah->nama_daerah}}, {{$datas->tanggal_penerimaan}}</h3>
            <div style="display: flex; justify-content:space-around; width:100%"> 
                <div>
                    <h3>Kepala Biro Hukum</h3>
                    <h3></h3>
                    <h3>TTD</h3>
                    <h3 style="text-decoration: underline; font-weight:700;">Rosani Erawadi SH. M.Si</h3>
                    <h3>NIP: 197101241997031007</h3>
                </div>
                <div>
                    <h3>Gubernur Kalimantan Timur</h3>
                    <h3>Ttd</h3>
                    <h3>H. Isran Noor</h3>
                </div>
            </div>
        </div> --}}
<script type="text/javascript">
    window.print();
</script>
