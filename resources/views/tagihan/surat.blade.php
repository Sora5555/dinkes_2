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
        margin-block: 5px;
        padding-block: 0;
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
        margin-inline: auto;
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
        <td colspan="3" class="bold">SURAT TAGIHAN PAJAK DAERAH(STPD)</td>
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
        <div class="container">
            <div>
                <h5>Nomor: {{$datas->nomor_surat_tagihan}}</h5>
                <h5>Lampiran:</h5>
                <h5>Perihal:</h5>
            </div>
            <div>
                <h5>Yth. Bpk/Ibu/Sdr</h5>
                <h5>di-</h5>
                <h5>{{$datas->pelanggan->name}}</h5>
            </div>
        </div>

        <div class="intro" style="margin-block:0; text-align:center">
            <p>Berdasarkan ketetapan yang tercantum pada SKPD nomor: {{$datas->nomor_surat_penetapan}}, Tanggal {{date("d-M-Y")}} ternyata saudara belum melunasi pajak air permukaan: </p>
        </div>

        <div class="" style="display:flex;">
            <table>
                <tr align="left">
                    <td colspan="1">Nomor</td>
                    <td>:{{$datas->nomor_surat_tagihan}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Nama Wajib Pajak</td>
                    <td>:{{$datas->pelanggan->name}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Alamat</td>
                    <td>:{{$datas->pelanggan->alamat?$datas->pelanggan->alamat:"-"}}</td>
                </tr>
                {{-- <tr align="left">
                    <td colspan="1">Nama Perusahaan</td>
                    <td>:{{$datas->pelanggan->name}}</td>
                </tr> --}}
                {{-- <tr align="left">
                    <td colspan="1">Alamat Perusahaan</td>
                    <td>:{{$datas->pelanggan->alamat?$datas->pelanggan->alamat:"-"}}</td>
                </tr> --}}
                <tr align="left">
                    <td colspan="1">Klasifikasi Sektor</td>
                    <td>:{{$datas->pelanggan->kategori_npa->kategori}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Volume Pemakaian</td>
                    <td>:{{$datas->meter_penggunaan}}</td>
                </tr>
                <tr align="left">
                    <td colspan="1">Periode Pemakaian</td>
                    <td>:{{$datas->tanggal->isoFormat("MMMM-Y")}}</td>
                </tr>
            </table>
        </div>
        <h3 class="heading">Penghitungan Pajak</h3>
        <table class="table">
            <tr>
                <th>Jenis Pungutan</th>
                <th>Volume</th>
                <th>NPA (Rp)</th>
                <th>Tarif Pajak (%)</th>
                <th>Pokok Pajak (Rp)</th>
                <th>Bunga 2%</th>
                <th>Pajak Terutang (Rp)</th>
            </tr>
            <tr>
                <td>PAP</td>
                <td>{{$datas->meter_penggunaan}}</td>
                <td>Rp.{{number_format($datas->tarif)}}</td>
                <td>10</td>
                <td>Rp.{{number_format($datas->jumlah_pembayaran)}}</td>
                <td>Rp.{{number_format($datas->denda_harian)}}</td>
                <td>Rp.{{number_format($datas->denda_admin + $datas->jumlah_pembayaran + $datas->denda_harian)}}</td>
            </tr>
            {{-- <tr>
                <td colspan="4">Denda Keterlambatan {{$counter}}%</td>
                <td>Rp.{{number_format($datas->denda_harian)}}</td>
            </tr>
            <tr>
                <td colspan="4">Sanksi Administrasi</td>
                <td>Rp.{{number_format($datas->denda_admin)}}</td>
            </tr>
            <tr>
                <td colspan="4" style="font-weight: 700">Jumlah Pajak Terutang</td>
                <td>Rp.{{number_format($datas->denda_admin + $datas->jumlah_pembayaran + $datas->denda_harian)}}</td>
            </tr> --}}
        </table>
        </table>
        <div style="display: flex; justify-content:center; align-items:flex-start; flex-direction:column; margin:0;">
            <h3>Tanggal Jatuh Tempo: {{$deadline}}</h3>
            <h3>Tempat Pembayaran: {{$datas->pelanggan->daerah->nama_daerah}}</h3>
        </div>
        <div style="display: flex; flex-direction:column; align-items:flex-end; justify-content:space-around;">
            <h3 style="margin-block:0; padding-block:0; width:30%; text-align:right;">An. Kepala Badan Pendapatan Daerah Provinsi Kalimantan Timur {{$datas->pelanggan->daerah->nama_daerah}}</h3>
            <h3 style="margin-block:0; padding-block:0;">TTD</h3>
            <h3 style="text-decoration: underline; font-weight:700; padding-block:0; margin-block:0">{{$datas->jabatan2->nama?$datas->jabatan2->nama:$kepala->nama}}</h3>
            <h3 style="font-weight:500; padding-block:0; margin-block:0">NIP: {{$datas->jabatan2->nama?$datas->jabatan2->nik:$kepala->nik}}</h3>
        </div>
<script type="text/javascript">
    window.print();
</script>
