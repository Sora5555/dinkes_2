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
<h4>PELAYANAN KESEHATAN ORANG DENGAN GANGGUAN JIWA (ODGJ) BERAT  MENURUT KECAMATAN DAN PUSKESMAS		
</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>PELAYANAN KESEHATAN ORANG DENGAN GANGGUAN JIWA (ODGJ) BERAT  MENURUT KECAMATAN DAN PUSKESMAS	
    {{Str::upper(Auth::user()->nama)}}</h4>
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
                <th rowspan="3">Sasaran ODGJ Berat</th>
                <th colspan="11">Pelayanan Kesehatan ODGJ berat</th>
            </tr>
        <tr>
            <th colspan="3">Skizofrenia</th>
            <th colspan="3">Psikotik Akut</th>
            <th colspan="3">Total</th>
            <th colspan="2">Mendapat Pelayanan Kesehatan</th>
        </tr>
        <tr>
            <th style="white-space:nowrap">0-14 th</th>
            <th style="white-space:nowrap">15-59 th</th>
            <th style="white-space:nowrap">>60 th</th>
            <th style="white-space:nowrap">0-14 th</th>
            <th style="white-space:nowrap">15-59 th</th>
            <th style="white-space:nowrap">>60 th</th>
            <th style="white-space:nowrap">0-14 th</th>
            <th style="white-space:nowrap">15-59 th</th>
            <th style="white-space:nowrap">>60 th</th>
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
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["sasaran"]}}</td>

                <td>{{$item->odgj_per_desa(app('request')->input('year'))["skizo_0"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["skizo_15"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["skizo_60"]}}</td>

                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_0"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_15"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_60"]}}</td>
                
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_0"] + $item->odgj_per_desa(app('request')->input('year'))["skizo_0"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_15"] + $item->odgj_per_desa(app('request')->input('year'))["skizo_15"]}}</td>
                <td>{{$item->odgj_per_desa(app('request')->input('year'))["psiko_60"] + $item->odgj_per_desa(app('request')->input('year'))["skizo_60"]}}</td>

                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jiwa_L"] + $item->kunjungan_per_desa(app('request')->input('year'))["jiwa_P"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jiwa_L"] + $item->kunjungan_per_desa(app('request')->input('year'))["jiwa_P"]>0?number_format(($item->kunjungan_per_desa(app('request')->input('year'))["jiwa_L"] + $item->kunjungan_per_desa(app('request')->input('year'))["jiwa_P"])/$item->odgj_per_desa(app('request')->input('year'))["sasaran"]*100, 2):0}}</td>
                
              </tr>
            @endforeach
            <tr>
               <td colspan="2">Jumlah Kab/Kota</td>
                <td>{{$total_sasaran}}</td>

                <td>{{$total_skizo_0}}</td>
                <td>{{$total_skizo_15}}</td>
                <td>{{$total_skizo_60}}</td>

                <td>{{$total_psiko_0}}</td>
                <td>{{$total_psiko_15}}</td>
                <td>{{$total_psiko_60}}</td>
                
                <td>{{$total_psiko_0 + $total_skizo_0}}</td>
                <td>{{$total_psiko_15 + $total_skizo_15}}</td>
                <td>{{$total_psiko_60 + $total_skizo_60}}</td>

                <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
                <td>{{$total_jiwa_L + $total_jiwa_P>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
                
                <td></td>
            </tr>
            @endrole
            @role('Puskesmas|Pihak Wajib Pajak')
            @foreach ($desa as $key => $item)
            @if($item->filterOdgj(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                
                <td><input type="number" disabled name="sasaran" id="{{$item->filterOdgj(app('request')->input('year'))->id}}" value="{{$item->filterOdgj(app('request')->input('year'))->sasaran}}" class="form-control data-input" style="border: none"></td>
                
                <td>{{$item->filterOdgj(app('request')->input('year'))->skizo_0}}</td>
                <td>{{$item->filterOdgj(app('request')->input('year'))->skizo_15}}</td>
                <td>{{$item->filterOdgj(app('request')->input('year'))->skizo_60}}</td>
                
                <td>{{$item->filterOdgj(app('request')->input('year'))->psiko_0}}</td>
                <td>{{$item->filterOdgj(app('request')->input('year'))->psiko_15}}</td>
                <td>{{$item->filterOdgj(app('request')->input('year'))->psiko_60}}</td>

                <td id="0{{$item->filterOdgj(app('request')->input('year'))->id}}">{{$item->filterOdgj(app('request')->input('year'))->psiko_0 + $item->filterOdgj(app('request')->input('year'))->skizo_0}}</td>
                <td id="15{{$item->filterOdgj(app('request')->input('year'))->id}}">{{$item->filterOdgj(app('request')->input('year'))->psiko_15 + $item->filterOdgj(app('request')->input('year'))->skizo_15}}</td>
                <td id="60{{$item->filterOdgj(app('request')->input('year'))->id}}">{{$item->filterOdgj(app('request')->input('year'))->psiko_60 + $item->filterOdgj(app('request')->input('year'))->skizo_60}}</td>
                
                <td id="pelayanan{{$item->filterOdgj(app('request')->input('year'))->id}}">{{$item->filterKunjungan(app('request')->input('year'))->jiwa_L + $item->filterKunjungan(app('request')->input('year'))->jiwa_P}}</td>
                <td id="persen{{$item->filterOdgj(app('request')->input('year'))->id}}">{{$item->filterOdgj(app('request')->input('year'))->sasaran > 0? number_format(($item->filterKunjungan(app('request')->input('year'))->jiwa_L + $item->filterKunjungan(app('request')->input('year'))->jiwa_P) / $item->filterOdgj(app('request')->input('year'))->sasaran * 100, 2):0}}%</td>
                
              </tr>
              @endif
            @endforeach
            <tr>
               <td colspan="3">Jumlah Kab/Kota</td>
                <td id="sasaran">{{$total_sasaran}}</td>

                <td id="skizo_0">{{$total_skizo_0}}</td>
                <td id="skizo_15">{{$total_skizo_15}}</td>
                <td id="skizo_60">{{$total_skizo_60}}</td>

                <td id="psiko_0">{{$total_psiko_0}}</td>
                <td id="psiko_15">{{$total_psiko_15}}</td>
                <td id="psiko_60">{{$total_psiko_60}}</td>
                
                <td id="total_0">{{$total_psiko_0 + $total_skizo_0}}</td>
                <td id="total_15">{{$total_psiko_15 + $total_skizo_15}}</td>
                <td id="total_60">{{$total_psiko_60 + $total_skizo_60}}</td>

                <td>{{$total_jiwa_L + $total_jiwa_P}}</td>
                <td id="percentage">{{$total_jiwa_L + $total_jiwa_P>0?number_format(($total_jiwa_L + $total_jiwa_P)/$total_sasaran*100, 2):0}}</td>
                
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