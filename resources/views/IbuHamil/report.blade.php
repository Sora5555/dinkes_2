<style>
     table{
        width: 100%;
        text-align: center;
    }
    .table{
        border: 1px solid #0a0a0a;
        border-collapse: collapse;
    }
    tr, td, th{
        border: 1px solid #000000;
    }
    h4{
        width: 90%;
        text-align: center;
        margin-inline:auto;
    }
    .flexbox{
        width: 70%;
        display: flex;
        justify-content: space-between;
        margin-inline: auto;
        text-align: center;
    }
    .box_puskesmas, .box_program{
        display: flex;
        flex-direction: column;
        align-content: space-between;
    }
    .nama_dan_nip{
        margin-top: 34px;
    }
    .h4{
        padding-block: 0;
        margin-block: 0;
    }

</style>
@role("Admin")
<h4>CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN {{$tahun}}</h4>
<div class="table-responsive">
    <table id="data" class="table" >
        <thead class="text-center">
        <tr>
            <th rowspan="3">No</th>
            @role("Pihak Wajib Pajak|Puskesmas")
            <th rowspan="3">Kecamatan</th>
            <th rowspan="3">Desa</th>
            @endrole
            @role("Admin")
            <th rowspan="3">Kecamatan</th>
            @endrole
            <th colspan="7">Ibu Hamil</th>
            <th colspan="9">Ibu Bersalin/Nifas</th>
        </tr>
        <tr>
            <th rowspan="3">Jumlah</th>
            <th colspan="2">K1</th>
            <th colspan="2">K4</th>
            <th colspan="2">K6</th>
            <th rowspan="3">Jumlah</th>
            <th colspan="2">Persalinan Di Fasyankes</th>
            <th colspan="2">Kf1</th>
            <th colspan="2">Kf Lengkap</th>
            <th colspan="2">Ibu Bersalin yang diberi Vit A</th>
        </tr>
        <tr>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
            <th>Jumlah</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr style={{$key % 2 == 0?"background: gray":""}}>
                <td>{{$key + 1}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->jumlah_ibu_hamil(app('request')->input('year'))}}</td>
                <td>{{$item->k1(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_hamil(app('request')->input('year')) > 0 ? number_format(($item->k1(app('request')->input('year'))/($item->jumlah_ibu_hamil(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->k4(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_hamil(app('request')->input('year')) > 0 ? number_format(($item->k4(app('request')->input('year'))/($item->jumlah_ibu_hamil(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->k6(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_hamil(app('request')->input('year')) > 0 ? number_format(($item->k6(app('request')->input('year'))/($item->jumlah_ibu_hamil(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->jumlah_ibu_bersalin(app('request')->input('year'))}}</td>
                <td>{{$item->fasyankes(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_bersalin(app('request')->input('year')) > 0 ? number_format(($item->fasyankes(app('request')->input('year'))/($item->jumlah_ibu_bersalin(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->kf1(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_bersalin(app('request')->input('year')) > 0 ? number_format(($item->kf1(app('request')->input('year'))/($item->jumlah_ibu_bersalin(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->kf_lengkap(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_bersalin(app('request')->input('year')) > 0 ? number_format(($item->kf_lengkap(app('request')->input('year'))/($item->jumlah_ibu_bersalin(app('request')->input('year'))))*100, '2'):0}}%</td>
                <td>{{$item->vita(app('request')->input('year'))}}</td>
                <td>{{$item->jumlah_ibu_bersalin(app('request')->input('year')) > 0 ? number_format(($item->vita(app('request')->input('year'))/($item->jumlah_ibu_bersalin(app('request')->input('year'))))*100, '2'):0}}%</td>
              </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_ibu_hamil}}</td>
                <td>{{$total_k1}}</td>
                <td></td>
                <td>{{$total_k4}}</td>
                <td></td>
                <td>{{$total_k6}}</td>
                <td></td>
                <td>{{$total_ibu_bersalin}}</td>
                <td>{{$total_fasyankes}}</td>
                <td></td>
                <td>{{$total_kf1}}</td>
                <td></td>
                <td>{{$total_kf_lengkap}}</td>
                <td></td>
                <td>{{$total_vita}}</td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterDesa(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil}}</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->k1}}</td>
                <td id="k1{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->k1/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                <td>{{$item->filterSasaranTahunDesa(app('request')->input('year'))?$item->filterSasaranTahunDesa(app('request')->input('year'))->total_capaian():0}}</td>
                <td id="k4{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->k4/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->k6}}</td>
                <td id="k6{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->k6/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_hamil))*100, '2'):0}}%</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin}}</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->fasyankes}}</td>
                <td id="fasyankes{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->fasyankes/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->kf1}}</td>
                <td id="kf1{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->kf1/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->kf_lengkap}}</td>
                <td id="kf_lengkap{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->kf_lengkap/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
                <td>{{$item->filterDesa(app('request')->input('year'))->vita}}</td>
                <td id="vita{{$item->filterDesa(app('request')->input('year'))->id}}">{{$item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin > 0 ? number_format(($item->filterDesa(app('request')->input('year'))->vita/($item->filterDesa(app('request')->input('year'))->jumlah_ibu_bersalin))*100, '2'):0}}%</td>
              </tr>
              @endif
            @endforeach
            <tr>
                <td colspan="3">Jumlah Kab/Kota</td>
                <td id="jumlah_ibu_hamil">{{$total_ibu_hamil}}</td>
                <td id="k1">{{$total_k1}}</td>
                <td>{{($total_k1/$total_ibu_hamil)*100}}%</td>
                <td id="k4">{{$total_k4}}</td>
                <td>{{number_format(($total_k4/$total_ibu_hamil)*100, 2)}}%</td>
                <td id="k6">{{$total_k6}}</td>
                <td>{{($total_k6/$total_ibu_hamil)*100}}%</td>
                <td id="jumlah_ibu_bersalin">{{$total_ibu_bersalin}}</td>
                <td id="fasyankes">{{$total_fasyankes}}</td>
                <td>{{$total_ibu_bersalin > 0?($total_fasyankes/$total_ibu_bersalin)*100:0}}%</td>
                <td id="kf1">{{$total_kf1}}</td>
                <td>{{$total_ibu_bersalin > 0?($total_kf1/$total_ibu_bersalin)*100:0}}%</td>
                <td id="kf_lengkap">{{$total_kf_lengkap}}</td>
                <td>{{$total_ibu_bersalin > 0?($total_kf_lengkap/$total_ibu_bersalin)*100:0}}%</td>
                <td id="vita">{{$total_vita}}</td>
                <td>{{$total_ibu_bersalin > 0?($total_vita/$total_ibu_bersalin)*100:0}}%</td>
            </tr>
            @endrole
        </tbody>
    </table>
</div>
<div class="flexbox">
    <div class="box_puskesmas">
        <p>Kepala Puskesmas</p>
        <div class="nama_dan_nip">
            <p>Nama: {{Auth::user()->nama}}</p>
            <p>Nip: {{Auth::user()->nip}}</p>
        </div>
    </div>
    <div class="box_program">
        <p>Pengelola Program</p>
        <div class="nama_dan_nip">
            <p>Nama: {{$nama_pengelola}}</p>
            <p>Nip: {{$nip_pengelola}}</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.print();
</script>