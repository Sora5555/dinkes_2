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
<h4>PELAYANAN KESEHATAN  PENDERITA HIPERTENSI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>PELAYANAN KESEHATAN  PENDERITA HIPERTENSI MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole
<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN <script>document.write(new Date().getFullYear())</script></h4>

<div class="table-responsive">
    <table id="data" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                <th rowspan="1" colspan="3">Jumlah Penderita Hipertensi Berusia > 15 tahun</th>
                <th colspan="6">Mendapat Pelayanan Kesehatan</th>
            </tr>
        <tr>
            <th rowspan="2">Laki Laki</th>
            <th rowspan="2">Perempuan</th>
            <th rowspan="2">Laki Laki + Perempuan</th>
            <th colspan="2" style="white-space: nowrap">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th colspan="2">Perempuan + Laki Laki</th>
            
        </tr>
        <tr>
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
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"] + $item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_L"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format($item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_L"]/$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"]*100, 2):0}}%</td>
                
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_P"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"] > 0?number_format($item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_P"]/$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"]*100, 2):0}}%</td>
                
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_P"] + $item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_L"]}}</td>
                <td>{{$item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"] + $item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"] > 0?number_format(($item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_P"] + $item->hipertensi_per_desa(app('request')->input('year'))["pelayanan_L"])/($item->hipertensi_per_desa(app('request')->input('year'))["jumlah_P"] + $item->hipertensi_per_desa(app('request')->input('year'))["jumlah_L"])*100, 2):0}}%</td>
                
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_L}}</td>
                <td>{{$total_P}}</td>
                <td>{{$total_L + $total_P}}</td>
                <td>{{$total_pelayanan_L}}</td>
                <td>{{$total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0}}%</td>
                
                <td>{{$total_pelayanan_P}}</td>
                <td>{{$total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0}}%</td>
                
                <td>{{$total_pelayanan_P + $total_pelayanan_L}}</td>
                <td>{{$total_P + $total_L > 0?number_format(($total_pelayanan_P + $total_pelayanan_L)/($total_P + $total_L)*100, 2):0}}%</td>
                
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterHipertensi(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td>{{$item->filterHipertensi(app('request')->input('year'))->jumlah_L}}</td>
                <td>{{$item->filterHipertensi(app('request')->input('year'))->jumlah_P}}</td>
                <td id="jumlah_LP{{$item->filterHipertensi(app('request')->input('year'))->id}}">{{$item->filterHipertensi(app('request')->input('year'))->jumlah_L + $item->filterHipertensi(app('request')->input('year'))->jumlah_P}}</td>
                
                <td>{{$item->filterHipertensi(app('request')->input('year'))->pelayanan_L}}</td>
                <td id="pelayanan_L{{$item->filterHipertensi(app('request')->input('year'))->id}}">{{$item->filterHipertensi(app('request')->input('year'))->jumlah_L > 0?number_format($item->filterHipertensi(app('request')->input('year'))->pelayanan_L/$item->filterHipertensi(app('request')->input('year'))->jumlah_L*100, 2):0}}%</td>
                
                <td>{{$item->filterHipertensi(app('request')->input('year'))->jumlah_P}}</td>
                <td id="pelayanan_P{{$item->filterHipertensi(app('request')->input('year'))->id}}">{{$item->filterHipertensi(app('request')->input('year'))->jumlah_P > 0?number_format($item->filterHipertensi(app('request')->input('year'))->pelayanan_P/$item->filterHipertensi(app('request')->input('year'))->jumlah_P*100, 2):0}}%</td>
                
                <td id="pelayanan_LP{{$item->filterHipertensi(app('request')->input('year'))->id}}">{{$item->filterHipertensi(app('request')->input('year'))->pelayanan_P + $item->filterHipertensi(app('request')->input('year'))->pelayanan_L}}</td>
                <td id="persen_pelayanan_LP{{$item->filterHipertensi(app('request')->input('year'))->id}}">{{$item->filterHipertensi(app('request')->input('year'))->jumlah_P + $item->filterHipertensi(app('request')->input('year'))->jumlah_L  > 0?number_format(($item->filterHipertensi(app('request')->input('year'))->pelayanan_P + $item->filterHipertensi(app('request')->input('year'))->pelayanan_L)/($item->filterHipertensi(app('request')->input('year'))->jumlah_P + $item->filterHipertensi(app('request')->input('year'))->jumlah_L)*100, 2):0}}%</td>
                
                
              </tr>
              @endif
            @endforeach
            <tr>
                <td colspan="3">Jumlah Kab/Kota</td>
                <td id="jumlah_L">{{$total_L}}</td>
                <td id="jumlah_P">{{$total_P}}</td>
                <td id="total_LP">{{$total_L + $total_P}}</td>
                <td id="pelayanan_L">{{$total_pelayanan_L}}</td>
                <td id="percentage_pelayanan_L">{{$total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0}}%</td>
                
                <td id="pelayanan_P">{{$total_pelayanan_P}}</td>
                <td id="percentage_pelayanan_P">{{$total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0}}%</td>
                
                <td id="jumlah_pelayanan_LP">{{$total_pelayanan_P + $total_pelayanan_L}}</td>
                <td id="percentage_pelayanan_LP">{{$total_P + $total_L > 0?number_format(($total_pelayanan_P + $total_pelayanan_L)/($total_P + $total_L)*100, 2):0}}%</td>
                
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