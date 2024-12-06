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
        text-indent: 10px;
    }
    .heading{
        text-align: center;
        margin-block: 0;
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
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
        border-bottom: 3px double black;
        margin-inline: auto;
        text-align: center;
        padding-block: 5px;
        width: 50%;
    }
    .image{
        width: 10%;
        margin-inline: auto
    }
    img{
        width: 100%;
        margin-inline: right;
    }
    .tanda{
        width: 10%;
        margin-inline: right;
    }
    
</style>
<div class="cop">
    <div class="image"><img src="{{asset('assets/images/logo.png')}}" alt=""></div>
    <div>
        <h3>PEMERINTAH PROVINSI KALIMANTAN TIMUR</h3>
        <h4>BADAN PENDAPATAN DAERAH</h4>
        <h5>UPTD. PELAYANAN PAJAK DAN RETRIBUSI WILAYAH {{$datas->pelanggan->daerah->nama_daerah}}</h5>
        <h3>{{$datas->pelanggan->daerah->alamat}}</h3>
    </div>
</div>
<table>
    <tr align="center">
        <td colspan="3" class="bold">SURAT KETETAPAN PAJAK DAERAH(SKPD)</td>
    </tr>
    <tr align="center">
        <td colspan="3" class="bold">PAJAK AIR PERMUKAAN</td>
    </tr>
    {{-- <tr align="center">
        <td colspan="3" style="padding-bottom:40px">{{ date("d-M-Y") }}</td>
    </tr> --}}
    <tr align="right">
        <td colspan="4" style="padding:10px 20px">{{$datas->pelanggan->daerah->nama_daerah}}, {{ date("d-M-Y") }}</td>
    </tr>
</table>

        <div class="" style="display:flex; justify-content:center; width:50%; margin-inline: auto;">
            <table>
                <tr align="left">
                    <td colspan="1">Nomor</td>
                    <td>:{{$datas->nomor_surat_penetapan}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Nama Wajib Pajak</td>
                    <td>:{{$datas->pelanggan->name}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Alamat</td>
                    <td>:{{$datas->pelanggan->alamat?$datas->pelanggan->alamat:"-"}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Sektor</td>
                    <td>:{{$datas->pelanggan->kategori_npa?$datas->pelanggan->kategori_npa->kategori:"-"}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Volume Pemakaian</td>
                    <td>:{{$datas->meter_penggunaan_awal != null?$datas->meter_penggunaan - $datas->meter_penggunaan_awal:$datas->meter_penggunaan}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Periode Pemakaian</td>
                    <td>:{{$datas->tanggal->format("F-Y")}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Alat Ukur</td>
                    <td>:Meteran</td>
                </tr>
                {{-- <tr align="left">
                    <td colspan="1">Tahun</td>
                    <td>:{{$datas->tanggal->isoFormat("Y")}}</td>
                </tr> --}}
            </table>
        </div>
        <h3 class="heading">Penghitungan Pajak</h3>
        <table class="table">
            <tr>
                <th>Jenis Pungutan</th>
                <th>Volume</th>
                <th>NPA (Rp)</th>
                <th>Tarif Pajak (%)</th>
            </tr>
            <tr>
                <td>PAP</td>
                <td>{{$datas->meter_penggunaan_awal != null?$datas->meter_penggunaan - $datas->meter_penggunaan_awal:$datas->meter_penggunaan}}</td>
                <td>Rp.{{number_format($datas->tarif)}}</td>
                <td>10</td>
            </tr>
            <tr>
                <td colspan="4">&#8205;</td>
            </tr>
            <tr>
                <th>Pajak Terutang (Rp)</th>
                <th>Denda Keterlambatan</th>
                <th>Sanksi Administrasi</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Rp.{{number_format($datas->jumlah_pembayaran)}}</td>
                <td>Rp.{{number_format($datas->denda_harian)}}</td>
                <td>Rp.{{number_format($datas->denda_admin)}}</td>
                <td>Rp.{{number_format($datas->denda_admin + $datas->jumlah_pembayaran + $datas->denda_harian)}}</td>
            </tr>
            {{-- <tr>
                <td colspan="4">Denda Keterlambatan {{$counter}}%</td>
                <td>Rp.{{number_format($datas->denda_harian)}}</td>
            </tr>
            <tr>
                <td colspan="4">Sanksi Administrasi</td>
                <td>Rp.{{number_format($datas->denda_admin)}}</td>
            </tr> --}}
        </table>
        <table style="padding-top: 20px">
            <tr align="right">
                <td colspan="3">Ditetapkan</td>
                <td>: {{$datas->pelanggan->daerah->nama_daerah}}</td>
            </tr>
            <tr align="right">
                <td colspan="3">Pada Tanggal</td>
                <td>: {{$datas->pembayaran->tanggal->isoFormat("D MMMM Y")}}</td>
            </tr>
        </table>
        <div style="display: flex; flex-direction:column; align-items:flex-end; justify-content:space-around">
            <h3>{{$datas->jabatan?$datas->jabatan->jabatan:""}}</h3>
            <img src="{{$datas->jabatan?$datas->jabatan->tanda_tangan_file_path.$datas->jabatan->tanda_tangan_file_name:""}}" alt="" class="tanda">
            {{-- <h3>TTD</h3> --}}
            <h3 style="text-decoration: underline; font-weight:700;">{{$datas->jabatan?$datas->jabatan->nama:""}}</h3>
            <h3 style="text-decoration: underline; font-weight:700;">NIP: {{$datas->jabatan?$datas->jabatan->nik:""}}</h3>
        </div>
<script type="text/javascript">
    window.print();
</script>