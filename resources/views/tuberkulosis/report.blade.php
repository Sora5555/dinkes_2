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
<h4>JUMLAH TERDUGA TUBERKULOSIS, KASUS TUBERKULOSIS, KASUS TUBERKULOSIS ANAK, 										
    DAN TREATMENT COVERAGE  (TC) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>JUMLAH TERDUGA TUBERKULOSIS, KASUS TUBERKULOSIS, KASUS TUBERKULOSIS ANAK, 										
    DAN TREATMENT COVERAGE  (TC) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
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
                <th rowspan="3">Jumlah Terduga Tuberkulosis</th>
                <th colspan="5">Jumlah Semua Kasus Tuberkulosis</th>
                <th rowspan="3">Kasus Tuberkulosis anak 0-14 tahun</th>
            </tr>
        <tr>
            <th style="white-space:nowrap" colspan="2">Laki Laki</th>
            <th colspan="2">Perempuan</th>
            <th rowspan="2">Laki Laki + Perempuan</th>
            
            
        </tr>
        <tr>
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
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["terduga_kasus"]}}</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_L"]}}</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_LP"] > 0?number_format($item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_L"]/$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_LP"]*100, 2):0}}%</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_P"]}}</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_LP"] > 0?number_format($item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_P"]/$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_LP"]*100, 2):0}}%</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_LP"]}}</td>
                <td>{{$item->tuberkulosis_per_desa(app('request')->input('year'))["kasus_anak"]}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_terduga_kasus}}</td>
                <td>{{$total_kasus_L}}</td>
                <td>{{$total_kasus_LP > 0?number_format($total_kasus_L/$total_kasus_LP*100, 2):0}}%</td>
                <td>{{$total_kasus_P}}</td>
                <td>{{$total_kasus_LP > 0?number_format($total_kasus_P/$total_kasus_LP*100, 2):0}}%</td>
                <td>{{$total_kasus_LP}}</td>
                <td>{{$total_kasus_anak}}</td>
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterTuberkulosis(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td>{{$item->filterTuberkulosis(app('request')->input('year'))->terduga_kasus}}</td>
                <td>{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_L}}</td>
                <td id="kasus_L{{$item->filterTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_LP>0?number_format($item->filterTuberkulosis(app('request')->input('year'))->kasus_L / $item->filterTuberkulosis(app('request')->input('year'))->kasus_LP * 100, 2):0}}%</td>
                
                <td>{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_P}}</td>
                <td id="kasus_P{{$item->filterTuberkulosis(app('request')->input('year'))->id}}">{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_LP>0?number_format($item->filterTuberkulosis(app('request')->input('year'))->kasus_P / $item->filterTuberkulosis(app('request')->input('year'))->kasus_LP * 100, 2):0}}%</td>
                
                <td>{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_LP}}</td>
                <td>{{$item->filterTuberkulosis(app('request')->input('year'))->kasus_anak}}</td>

              </tr>
              @endif
            @endforeach
            <tr>
               <td colspan="3">Jumlah Kab/Kota</td>
                <td id="terduga_kasus">{{$total_terduga_kasus}}</td>
                <td id="kasus_L">{{$total_kasus_L}}</td>
                <td id="percentage_kasus_L">{{$total_kasus_LP > 0?number_format($total_kasus_L/$total_kasus_LP*100, 2):0}}%</td>
                <td id="kasus_P">{{$total_kasus_P}}</td>
                <td id="percentage_kasus_P">{{$total_kasus_LP > 0?number_format($total_kasus_P/$total_kasus_LP*100, 2):0}}%</td>
                <td id="kasus_LP">{{$total_kasus_LP}}</td>
                <td id="kasus_anak">{{$total_kasus_anak}}</td>
                <td></td>
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