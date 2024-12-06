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
<h4>PELAYANAN KESEHATAN PENDERITA DIABETES MELITUS (DM) MENURUT KECAMATAN DAN PUSKESMAS</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>PELAYANAN KESEHATAN PENDERITA DIABETES MELITUS (DM) MENURUT KECAMATAN DAN PUSKESMAS {{Str::upper(Auth::user()->nama)}}</h4>
@endrole

<h4>KABUPATEN/KOTA KUTAI TIMUR</h4>
<h4>TAHUN <script>document.write(new Date().getFullYear())</script></h4>
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
                <th rowspan="2">Jumlah Penderita DM</th>
                <th colspan="2">Penderita DM yang mendapatkan pelayanan sesuai standar</th>
            </tr>
        <tr>
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
                <td>{{$item->diabetes_per_desa(app('request')->input('year'))["jumlah"]}}</td>
                <td>{{$item->diabetes_per_desa(app('request')->input('year'))["pelayanan"]}}</td>
                <td>{{$item->diabetes_per_desa(app('request')->input('year'))["jumlah"] >0? number_format($item->diabetes_per_desa(app('request')->input('year'))["pelayanan"]/$item->diabetes_per_desa(app('request')->input('year'))["jumlah"] * 100, 2):0  }}</td>
                
              </tr>
            @endforeach
            <tr>
                <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_diabetes}}</td>
                <td>{{$total_pelayanan_diabetes}}</td>
                <td>{{$total_diabetes >0? number_format($total_pelayanan_diabetes/$total_diabetes * 100, 2):0  }}</td>
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterDiabetes(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td><input type="number" disabled name="jumlah" id="{{$item->filterDiabetes(app('request')->input('year'))->id}}" value="{{$item->filterDiabetes(app('request')->input('year'))->jumlah}}" class="form-control data-input" style="border: none"></td>
                <td><input type="number" disabled {{$item->filterDiabetes(app('request')->input('year'))->status == 1?"disabled":""}} name="pelayanan" id="{{$item->filterDiabetes(app('request')->input('year'))->id}}" value="{{$item->filterDiabetes(app('request')->input('year'))->pelayanan}}" class="form-control data-input" style="border: none"></td>
                <td id="persen{{$item->filterDiabetes(app('request')->input('year'))->id}}">{{$item->filterDiabetes(app('request')->input('year'))->jumlah > 0 ? number_format($item->filterDiabetes(app('request')->input('year'))->pelayanan / $item->filterDiabetes(app('request')->input('year'))->jumlah * 100, 2): 0}}%</td>
                
              </tr>
              @endif
            @endforeach
            <tr>
               <td colspan="3">Jumlah Kab/Kota</td>
                <td id="jumlah">{{$total_diabetes}}</td>
                <td id="pelayanan">{{$total_pelayanan_diabetes}}</td>
                <td id="percentage">{{$total_diabetes >0? number_format($total_pelayanan_diabetes/$total_diabetes * 100, 2):0  }}</td>
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