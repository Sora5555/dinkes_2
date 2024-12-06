<style>
    table{
        width: 100%;
        border: 1px solid #ddd;
    }
    .font{
        weight: 700 !important;
    }
</style>

<table>
    <tr align="center">
        <td colspan="3">UPT. PPRD WILAYAH {{$datas->pelanggan->daerah->nama_daerah}}</td>
    </tr>
    <tr align="center">
        <td colspan="3">{{$datas->pelanggan->alamat}}</td>
    </tr>
    <tr align="center">
        <td colspan="3" style="padding-bottom:40px">{{ date("d-M-Y") }}</td>
    </tr>
    
    <tr>
        <td>No. Pelanggan</td>
        <td>:</td>
        <td>{{ $datas->pelanggan->no_pelanggan }}</td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td>:</td>
        <td>{{ $datas->pelanggan->name }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $datas->pelanggan->alamat }}</td>
    </tr>
    <tr>
        <td>No. Telepon</td>
        <td>:</td>
        <td>{{ $datas->pelanggan->no_telepon }}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>No. Tagihan</td>
        <td>:</td>
        <td>{{ $datas->id_tagihan }}</td>
    </tr>
    <tr>
        <td>Jumlah Penggunaan</td>
        <td>:</td>
        <td>{{ $datas->meter_penggunaan }} m³</td>
    </tr>
    <tr>
        <td>Denda Harian</td>
        <td>:</td>
        <td>Rp.{{ number_format($datas->denda_harian) }}</td>
    </tr>
     <tr>
        <td>Denda Administrasi</td>
        <td>:</td>
        <td>Rp.{{ number_format($datas->denda_admin) }}</td>
    </tr>
    <tr>
        <td>Tagihan Penggunaan</td>
        <td>:</td>
        <td>Rp. {{ number_format($datas->jumlah_pembayaran) }}</td>
    </tr>
    <tr>
        <td style="font-weight:Bold">Total Tagihan</td>
        <td style="font-weight:Bold">:</td>
        <td style="font-weight:Bold">Rp. {{ number_format($datas->jumlah_pembayaran + $datas->denda_harian + $datas->denda_admin) }}</td>
    </tr>

    <tr align="center" >
        <td colspan="3" style="padding-top:40px">Terima Kasih</td>
    </tr>
</table>

<script type="text/javascript">
    window.print();
</script>
