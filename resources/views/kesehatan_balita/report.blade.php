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
<h4>CAKUPAN PELAYANAN KESEHATAN BALITA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS												
</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>CAKUPAN PELAYANAN KESEHATAN BALITA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS{{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN {{$tahun}}</h4>
<div class="table-responsive">
    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="text-center">
        <tr>
            <th rowspan="2">No</th>
            @role("Pihak Wajib Pajak|Puskesmas")
            <th rowspan="3">Kecamatan</th>
            <th rowspan="3">Desa</th>
            @endrole
            @role("Admin")
            <th rowspan="3">Kecamatan</th>
            @endrole
            <th rowspan="2">Sasaran Balita (usia 0-59 bulan)</th>
            <th rowspan="2">Sasaran Anak Balita (usia 12-59 bulan)</th>
            <th colspan="2">Balita Memiliki Buku KIA lengkap</th>
            <th colspan="2">Balita Dipantau Pertumbuhan dan Perkembangan</th>
            <th colspan="2">Balita Dilayani SDIDTK</th>
            <th colspan="2">Balita Dilayani MTBS</th>
        </tr>
        <tr>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
            <th>jumlah</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"]}}</td>

                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_12_59"]}}</td>
                
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_kia"]}}</td>
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_kia"] / $item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"]* 100, 2):0}}%</td>
                
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_dipantau"]}}</td>
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_dipantau"] / $item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"]* 100, 2):0}}%</td>
                
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_sdidtk"]}}</td>
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_12_59"] > 0?number_format($item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_sdidtk"] / $item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_12_59"]* 100, 2):0}}%</td>
                
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_mtbs"]}}</td>
                <td>{{$item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"] > 0?number_format($item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_mtbs"] / $item->kesehatan_balita_per_desa(app('request')->input('year'))["balita_0_59"]* 100, 2):0}}%</td>
              </tr>
            @endforeach
            <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{{$totalbalita_0_59}}</td>

                    <td>{{$totalbalita_12_59}}</td>
                    
                    <td>{{$totalbalita_kia}}</td>
                    <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_kia / $totalbalita_0_59* 100, 2):0}}%</td>
                    
                    <td>{{$totalbalita_dipantau}}</td>
                    <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_dipantau / $totalbalita_0_59* 100, 2):0}}%</td>
                    
                    <td>{{$totalbalita_sdidtk}}</td>
                    <td>{{$totalbalita_12_59 > 0?number_format($totalbalita_sdidtk / $totalbalita_12_59* 100, 2):0}}%</td>
                    
                    <td>{{$totalbalita_mtbs}}</td>
                    <td>{{$totalbalita_0_59 > 0?number_format($totalbalita_mtbs / $totalbalita_0_59* 100, 2):0}}%</td>
                    <td></td>
                  </tr>
                {{-- <td></td>
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
                <td>{{$total_vita}}</td> --}}
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterKesehatanBalita(app('request')->input('year')))
            <tr style=''>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59}}</td>
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_12_59}}</td>
                
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_kia}}</td>
                <td id="balita_kia{{$item->filterKesehatanBalita(app('request')->input('year'))->id}}">{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(app('request')->input('year'))->balita_kia/($item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59)*100, 2):0}}%</td>
                
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_dipantau}}</td>
                <td id="balita_dipantau{{$item->filterKesehatanBalita(app('request')->input('year'))->id}}">{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(app('request')->input('year'))->balita_dipantau/($item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59)*100, 2):0}}%</td>
                
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_sdidtk}}</td>
                <td id="balita_sdidtk{{$item->filterKesehatanBalita(app('request')->input('year'))->id}}">{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_12_59 > 0?number_format($item->filterKesehatanBalita(app('request')->input('year'))->balita_sdidtk/($item->filterKesehatanBalita(app('request')->input('year'))->balita_12_59)*100, 2):0}}%</td>
                
                <td>{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_mtbs}}</td>
                <td id="balita_mtbs{{$item->filterKesehatanBalita(app('request')->input('year'))->id}}">{{$item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59 > 0?number_format($item->filterKesehatanBalita(app('request')->input('year'))->balita_mtbs/($item->filterKesehatanBalita(app('request')->input('year'))->balita_0_59)*100, 2):0}}%</td>

              </tr>
              @endif
            @endforeach
            <tr>
                <td colspan="3">Jumlah Kab/Kota</td>
                <td id="balita_0_59">{{$totalbalita_0_59}}</td>

                <td id="balita_12_59">{{$totalbalita_12_59}}</td>
                
                <td id="balita_kia">{{$totalbalita_kia}}</td>
                <td id="percentage_balita_kia">{{$totalbalita_0_59 > 0?number_format($totalbalita_kia / $totalbalita_0_59* 100, 2):0}}%</td>
                
                <td id="balita_dipantau">{{$totalbalita_dipantau}}</td>
                <td id="percentage_balita_dipantau">{{$totalbalita_0_59 > 0?number_format($totalbalita_dipantau / $totalbalita_0_59* 100, 2):0}}%</td>
                
                <td id="balita_sdidtk">{{$totalbalita_sdidtk}}</td>
                <td id="percentage_balita_sdidtk">{{$totalbalita_12_59 > 0?number_format($totalbalita_sdidtk / $totalbalita_12_59* 100, 2):0}}%</td>
                
                <td id="balita_mtbs">{{$totalbalita_mtbs}}</td>
                <td id="percentage_balita_mtbs">{{$totalbalita_0_59 > 0?number_format($totalbalita_mtbs / $totalbalita_0_59* 100, 2):0}}%</td>
                <td></td>
              </tr>
            {{-- <tr>
                <td></td>
                <td id="jumlah_ibu_hamil">{{$total_ibu_hamil}}</td>
                <td id="k1">{{$total_k1}}</td>
                <td></td>
                <td id="k4">{{$total_k4}}</td>
                <td></td>
                <td id="k6">{{$total_k6}}</td>
                <td></td>
                <td id="jumlah_ibu_bersalin">{{$total_ibu_bersalin}}</td>
                <td id="fasyankes">{{$total_fasyankes}}</td>
                <td></td>
                <td id="kf1">{{$total_kf1}}</td>
                <td></td>
                <td id="kf_lengkap">{{$total_kf_lengkap}}</td>
                <td></td>
                <td id="vita">{{$total_vita}}</td>
            </tr> --}}
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
