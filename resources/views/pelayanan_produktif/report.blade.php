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
<h4>PELAYANAN KESEHATAN USIA PRODUKTIF MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>PELAYANAN KESEHATAN USIA PRODUKTIF MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN {{$tahun}}</h4>
<div class="table-responsive">
    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="text-center">
            <tr>
                <th rowspan="4">No</th>
                @role("Pihak Wajib Pajak|Puskesmas")
                <th rowspan="4">Kecamatan</th>
                <th rowspan="4">Desa</th>
                @endrole
                @role("Admin")
                <th rowspan="4">Kecamatan</th>
                @endrole
                <th colspan="15">Penduduk Usia 15-59 tahun</th>
            </tr>
        <tr>
            <th colspan="3">Jumlah</th>
            <th colspan="6">Mendapat Pelayanan Kesehatan Skrining sesuai standar</th>
            <th colspan="6">Berisiko</th>
        </tr>
        <tr>
            <th style="white-space:nowrap" rowspan="2">Laki Laki</th>
            <th rowspan="2">Perempuan</th>
            <th rowspan="2">Laki Laki + Perempuan</th>
            
            <th style="white-space:nowrap" colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Laki Laki + Perempuan</th>

            <th style="white-space:nowrap" colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Laki Laki + Perempuan</th>
            
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
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"] +  $item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"]}}</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["standar_L"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format($item->pelayanan_produktif_per_desa(app('request')->input('year'))['standar_L'] / $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_L'] * 100, 2): 0}}%</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["standar_P"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"] > 0?number_format($item->pelayanan_produktif_per_desa(app('request')->input('year'))['standar_P'] / $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_P'] * 100, 2): 0}}%</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["standar_P"] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))["standar_L"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format(($item->pelayanan_produktif_per_desa(app('request')->input('year'))['standar_P'] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))['standar_L']) / ($item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_P'] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_L']) * 100, 2): 0}}%</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["risiko_L"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format($item->pelayanan_produktif_per_desa(app('request')->input('year'))['risiko_L'] / $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_L'] * 100, 2): 0}}%</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["risiko_P"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"] > 0?number_format($item->pelayanan_produktif_per_desa(app('request')->input('year'))['risiko_P'] / $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_P'] * 100, 2): 0}}%</td>
                
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["risiko_P"] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))["risiko_L"]}}</td>
                <td>{{$item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_P"] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format(($item->pelayanan_produktif_per_desa(app('request')->input('year'))['risiko_P'] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))['risiko_L']) / ($item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_P'] + $item->pelayanan_produktif_per_desa(app('request')->input('year'))['jumlah_L']) * 100, 2): 0}}%</td>
              </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_L}}</td>
                <td>{{$total_P}}</td>
                <td>{{$total_L +  $total_P}}</td>
                
                <td>{{$totalstandar_L}}</td>
                <td>{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
                
                <td>{{$totalstandar_P}}</td>
                <td>{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
                
                <td>{{$totalstandar_P + $totalstandar_L}}</td>
                <td>{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_L + $total_P) * 100, 2): 0}}%</td>
                
                <td>{{$totalrisiko_L}}</td>
                <td>{{$total_L > 0?number_format($totalrisiko_L / $total_L * 100, 2): 0}}%</td>
                
                <td>{{$totalrisiko_P}}</td>
                <td>{{$total_P > 0?number_format($totalrisiko_P / $total_P * 100, 2): 0}}%</td>
                
                <td>{{$total_P + $total_L}}</td>
                <td>{{$total_P + $total_L > 0?number_format(($totalrisiko_P + $totalrisiko_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterPelayananProduktif(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L}}</td>
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P}}</td>
                <td id="jumlah_LP{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L + $item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P}}</td>
                
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->standar_L}}</td>
                <td id="standar_L{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L > 0? number_format($item->filterPelayananProduktif(app('request')->input('year'))->standar_L/$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L * 100):0}}%</td>
                
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->standar_P}}</td>
                <td id="standar_P{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P > 0? number_format($item->filterPelayananProduktif(app('request')->input('year'))->standar_P/$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P * 100):0}}%</td>
                
                <td id="standar_LP{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->standar_P + $item->filterPelayananProduktif(app('request')->input('year'))->standar_L}}</td>
                <td id="persen_standar_LP{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P + $item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L > 0? number_format(($item->filterPelayananProduktif(app('request')->input('year'))->standar_P + $item->filterPelayananProduktif(app('request')->input('year'))->standar_L)/($item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P + $item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L) * 100):0}}%</td>
                
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->risiko_L}}</td>
                <td id="risiko_L{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L > 0? number_format($item->filterPelayananProduktif(app('request')->input('year'))->risiko_L/$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L * 100):0}}%</td>
                
                <td>{{$item->filterPelayananProduktif(app('request')->input('year'))->risiko_P}}</td>
                <td id="risiko_P{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P > 0? number_format($item->filterPelayananProduktif(app('request')->input('year'))->risiko_P/$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P * 100):0}}%</td>
                <td id="risiko_LP{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->risiko_P + $item->filterPelayananProduktif(app('request')->input('year'))->risiko_L}}</td>
                <td id="persen_risiko_LP{{$item->filterPelayananProduktif(app('request')->input('year'))->id}}">{{$item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P + $item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L > 0? number_format(($item->filterPelayananProduktif(app('request')->input('year'))->risiko_P + $item->filterPelayananProduktif(app('request')->input('year'))->risiko_L)/($item->filterPelayananProduktif(app('request')->input('year'))->jumlah_P + $item->filterPelayananProduktif(app('request')->input('year'))->jumlah_L) * 100):0}}%</td>
                
              </tr>
              @endif
            @endforeach
            <td colspan="3">Jumlah Kab/Kota</td>
            <td id="jumlah_L">{{$total_L}}</td>
            <td id="jumlah_P">{{$total_P}}</td>
            <td id="total_LP">{{$total_L +  $total_P}}</td>
            
            <td id="standar_L">{{$totalstandar_L}}</td>
            <td id="percentage_standar_L">{{$total_L > 0?number_format($totalstandar_L / $total_L * 100, 2): 0}}%</td>
            
            <td id="standar_P">{{$totalstandar_P}}</td>
            <td id="percentage_standar_P">{{$total_P > 0?number_format($totalstandar_P / $total_P * 100, 2): 0}}%</td>
            
            <td id="totalstandar_LP">{{$totalstandar_P + $totalstandar_L}}</td>
            <td id="percentage_totalstandar_LP">{{$total_P + $total_L > 0?number_format(($totalstandar_P + $totalstandar_L) / ($total_L + $total_P) * 100, 2): 0}}%</td>
            
            <td id="risiko_L">{{$totalrisiko_L}}</td>
            <td id="percentage_risiko_L">{{$total_L > 0?number_format($totalrisiko_L / $total_L * 100, 2): 0}}%</td>
            
            <td id="risiko_P">{{$totalrisiko_P}}</td>
            <td id="percentage_risiko_P">{{$total_P > 0?number_format($totalrisiko_P / $total_P * 100, 2): 0}}%</td>
            
            <td id="totalrisiko_LP">{{$total_P + $total_L}}</td>
            <td id="percentage_totalrisiko_LP">{{$total_P + $total_L > 0?number_format(($totalrisiko_P + $totalrisiko_L) / ($total_P + $total_L) * 100, 2): 0}}%</td>
            <td></td>
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