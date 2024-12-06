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
<h4>JUMLAH KUNJUNGAN PASIEN BARU RAWAT JALAN, RAWAT INAP, DAN KUNJUNGAN GANGGUAN JIWA DI SARANA PELAYANAN KESEHATAN		
</h4>
@endrole
@role("Puskesmas|Pihak Wajib Pajak")
<h4>JUMLAH KUNJUNGAN PASIEN BARU RAWAT JALAN, RAWAT INAP, DAN KUNJUNGAN GANGGUAN JIWA DI SARANA PELAYANAN KESEHATAN		
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
                <th colspan="6">Jumlah Kunjungan</th>
                <th colspan="3">Kunjungan Gangguan Jiwa</th>
            </tr>
        <tr>
            <th colspan="3">Rawat Jalan</th>
            <th colspan="3">Rawat Inap</th>
            <th colspan="3">Jumlah</th>
        </tr>
        <tr>
            <th style="white-space:nowrap">Laki Laki</th>
            <th>Perempuan</th>
            <th>Laki Laki + Perempuan</th>
            <th style="white-space:nowrap">Laki Laki</th>
            <th>Perempuan</th>
            <th>Laki Laki + Perempuan</th>
            <th style="white-space:nowrap">Laki Laki</th>
            <th>Perempuan</th>
            <th>Laki Laki + Perempuan</th>
        </tr>
        </thead>
        <tbody>
            @role('Admin|superadmin')
            @foreach ($unit_kerja as $key => $item)
            
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$key == 0?Auth::user()->unit_kerja->nama:""}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jalan_L"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jalan_P"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jalan_P"] + $item->kunjungan_per_desa(app('request')->input('year'))["jalan_L"]}}</td>
                
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["inap_L"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["inap_P"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["inap_P"] + $item->kunjungan_per_desa(app('request')->input('year'))["inap_L"]}}</td>
                
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jiwa_L"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jiwa_P"]}}</td>
                <td>{{$item->kunjungan_per_desa(app('request')->input('year'))["jiwa_P"] + $item->kunjungan_per_desa(app('request')->input('year'))["jiwa_L"]}}</td>
                
              </tr>
            @endforeach
            <tr>
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
            @if($item->filterKunjungan(app('request')->input('year')))
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$item->nama}}</td>
                
                <td>{{$item->filterKunjungan(app('request')->input('year'))->jalan_L}}</td>
                <td>{{$item->filterKunjungan(app('request')->input('year'))->jalan_P}}</td>
                <td id="jalan{{$item->filterKunjungan(app('request')->input('year'))->id}}">{{$item->filterKunjungan(app('request')->input('year'))->jalan_P + $item->filterKunjungan(app('request')->input('year'))->jalan_L}}</td>
                
                <td>{{$item->filterKunjungan(app('request')->input('year'))->inap_L}}</td>
                <td>{{$item->filterKunjungan(app('request')->input('year'))->inap_P}}</td>
                <td id="inap{{$item->filterKunjungan(app('request')->input('year'))->id}}">{{$item->filterKunjungan(app('request')->input('year'))->inap_L + $item->filterKunjungan(app('request')->input('year'))->inap_P}}</td>
                
                <td>{{$item->filterKunjungan(app('request')->input('year'))->jiwa_L}}</td>
                <td>{{$item->filterKunjungan(app('request')->input('year'))->jalan_L}}</td>
                <td id="jiwa{{$item->filterKunjungan(app('request')->input('year'))->id}}">{{$item->filterKunjungan(app('request')->input('year'))->jiwa_L + $item->filterKunjungan(app('request')->input('year'))->jiwa_P}}</td>
                
              </tr>
              @endif
            @endforeach
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