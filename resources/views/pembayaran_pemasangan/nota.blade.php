<style>
    table{
        width: 100%;
        border: 1px solid #ddd;
    }
</style>

<table>
    <tr align="center">
        <td colspan="3">PDAM</td>
    </tr>
    <tr align="center">
        <td colspan="3" style="padding-bottom:40px">{{ date("d-M-Y") }}</td>
    </tr>
    
    <tr>
        <td>No. Pelanggan</td>
        <td>:</td>
        <td>{{ $datas->tagihan_pemasangan->pelanggan->id_pelanggan }}</td>
    </tr>
    <tr>
        <td>Nama Pelanggan</td>
        <td>:</td>
        <td>{{ $datas->tagihan_pemasangan->pelanggan->name }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $datas->tagihan_pemasangan->pelanggan->alamat }}</td>
    </tr>
    <tr>
        <td>No. Telepon</td>
        <td>:</td>
        <td>{{ $datas->tagihan_pemasangan->pelanggan->no_telepon }}</td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>No. Tagihan Pemasangan</td>
        <td>:</td>
        <td>{{ $datas->tagihan_pemasangan->id_tagihan_pemasangan }}</td>
    </tr>
    <tr>
        <td>Total Bayar</td>
        <td>:</td>
        <td>Rp. {{ number_format($datas->jumlah_pembayaran) }}</td>
    </tr>

    <tr align="center" >
        <td colspan="3" style="padding-top:40px">Terima Kasih</td>
    </tr>
</table>