<table id="data" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="text-center">
                                    <tr>
                                        <th>JUMLAH PENDERITA DAN KEMATIAN PADA KLB MENURUT JENIS KEJADIAN LUAR BIASA (KLB)</th>
                                    </tr>
                                    <tr>
                                        <th>Kabupaten/Kota Kutai Timur</th>
                                    </tr>
                                    <tr>
                                        <th>Tahun {{Session::get('year')}}</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; padding-left: 40px; text-align: center; padding-right: 40px;">JENIS KEJADIAN LUAR BIASA
                                        <th colspan="2">YANG TERSERANG</th>
                                        <th colspan="3">WAKTU KEJADIAN (TANGGAL)</th>
                                        <th colspan="3">JUMLAH PENDERITA</th>
                                        <th colspan="12">KELOMPOK UMUR PENDERITA</th>
                                        <th colspan="3">JUMLAH KEMATIAN	</th>
                                        <th colspan="3">JUMLAH PENDUDUK TERANCAM</th>
                                        <th colspan="3">ATTACK RATE (%)</th>
                                        <th colspan="3">CFR (%)</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH KEC</th>
                                        <th >JUMLAH DESA/KEL</th>

                                        <th>DIKETAHUI</th>
                                        <th>DITANGGULANGI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">AKHIR</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">0-7 HARI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">8-28 HARI</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">1-11 BLN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">1-4 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">5-9 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">10-14 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">15-19 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">20-44 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">45-54 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">55-59 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">60-69 THN</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">70+ THN</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">P</th>
                                        <th style="padding-left: 40px; text-align: center; padding-right: 40px;">L + P</th>

                                    </tr>
                                </thead>
                                <tbody id="tbody_wripper">
                                    @role('Admin|superadmin')
                                        @foreach ($table71 as $key)
                                            <tr id="data_{{$key->id}}">
                                                <td>
                                                    {{ $key->jenis_kejadian }}
                                                </td>
                                                <td>
                                                    {{ $key->jumlah_kec }}
                                                </td>
                                                <td>
                                                    {{ $key->jumlah_desa }}
                                                </td>
                                                <td>
                                                    {{ $key->diketahui }}
                                                </td>
                                                <td>
                                                    {{ $key->ditanggulangi }}
                                                </td>
                                                <td>
                                                    {{ $key->akhir }}
                                                </td>
                                                <td>
                                                    {{ $key->l_pen }}
                                                </td>
                                                <td>
                                                    {{ $key->p_pen }}
                                                </td>
                                                <td id="lp_pen_{{ $key->id }}">
                                                    @php
                                                        $lp_pen_ = $key->l_pen + $key->p_pen;
                                                    @endphp
                                                    {{ $lp_pen_ }}
                                                </td>
                                                <td>
                                                    {{ $key->k_0_7_hari }}
                                                </td>
                                                <td>
                                                    {{ $key->k_8_28_hari }}
                                                </td>
                                                <td>
                                                    {{ $key->k_1_11_bulan }}
                                                </td>
                                                <td>
                                                    {{ $key->k_1_4_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_5_9_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_10_14_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_15_19_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_20_44_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_45_54_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_55_59_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_60_69_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->k_70_plus_tahun }}
                                                </td>
                                                <td>
                                                    {{ $key->l_mati }}
                                                </td>
                                                <td>
                                                    {{ $key->p_mati }}
                                                </td>
                                                <td id="lp_mati_{{ $key->id }}">
                                                    @php
                                                        $lp_mati_ = $key->l_mati + $key->p_mati;
                                                    @endphp
                                                    {{ $lp_mati_ }}
                                                </td>
                                                <td>
                                                    {{ $key->l_penduduk }}
                                                </td>
                                                <td>
                                                    {{ $key->p_penduduk }}
                                                </td>
                                                
                                                <td id="lp_penduduk_{{$key->id}}">
                                                    @php
                                                        $lp_penduduk_ = $key->l_penduduk + $key->p_penduduk;
                                                        echo $lp_penduduk_;
                                                    @endphp
                                                </td>
                                                <td id="L_Attack_{{$key->id}}">
                                                    {{number_format(($key->l_pen / $key->l_penduduk) * 100, 2) . '%'}}
                                                </td>
                                                <td id="P_Attack_{{$key->id}}">
                                                    {{number_format(($key->p_pen / $key->p_penduduk) * 100, 2) . '%'}}
                                                </td>
                                                <td id="LP_Attack_{{$key->id}}">
                                                    {{number_format(($lp_pen_ / $lp_penduduk_) * 100, 2) . '%'}}

                                                </td>

                                                <td id="L_CFR_{{$key->id}}">
                                                    {{number_format(($key->l_pen / $key->l_mati) * 100, 2) . '%'}}

                                                </td>
                                                <td id="P_CFR_{{$key->id}}">
                                                    {{number_format(($key->p_pen / $key->p_mati) * 100, 2) . '%'}}

                                                </td>
                                                <td id="LP_CFR_{{$key->id}}">
                                                    {{number_format(($lp_pen_ / $lp_mati_) * 100, 2) . '%'}}


                                                </td>
                                            </tr>
                                        @endforeach
                                    @endrole    
                                    @role('Puskesmas|Pihak Wajib Pajak')
                                        @foreach ($table71 as $key)
                                            <tr id="data_{{$key->id}}">
                                                <td>{{$key->jenis_kejadian}}</td>
                                                <td>{{$key->jumlah_kec}}</td>
                                                <td>{{$key->jumlah_desa}}</td>
                                                <td>{{$key->diketahui}}</td>
                                                <td>{{$key->ditanggulangi}}</td>
                                                <td>{{$key->akhir}}</td>
                                                <td>{{$key->l_pen}}</td>
                                                <td>{{$key->p_pen}}</td>
                                                <td id="lp_pen_{{$key->id}}">
                                                    @php
                                                        $lp_pen_ = $key->l_pen + $key->p_pen;
                                                        echo $lp_pen_;
                                                    @endphp
                                                    {{-- {{number_format(($ditangani_24 / $jumlah) * 100, 2) . '%'}} --}}
                                                </td>
                                                <td>{{$key->k_0_7_hari}}</td>
                                                <td>{{$key->k_8_28_hari}}</td>
                                                <td>{{$key->k_1_11_bulan}}</td>
                                                <td>{{$key->k_1_4_tahun}}</td>
                                                <td>{{$key->k_5_9_tahun}}</td>
                                                <td>{{$key->k_10_14_tahun}}</td>
                                                <td>{{$key->k_15_19_tahun}}</td>
                                                <td>{{$key->k_20_44_tahun}}</td>
                                                <td>{{$key->k_45_54_tahun}}</td>
                                                <td>{{$key->k_55_59_tahun}}</td>
                                                <td>{{$key->k_60_69_tahun}}</td>
                                                <td>{{$key->k_70_plus_tahun}}</td>
                                                <td>{{$key->l_mati}}</td>
                                                <td>{{$key->p_mati}}</td>
                                                <td id="lp_mati_{{$key->id}}">
                                                    @php
                                                        $lp_mati_ = $key->l_mati + $key->p_mati;
                                                        echo $lp_mati_;
                                                    @endphp
                                                </td>
                                                <td>{{$key->l_penduduk}}</td>
                                                <td>{{$key->p_penduduk}}</td>
                                                <td id="lp_penduduk_{{$key->id}}">
                                                    @php
                                                        $lp_penduduk_ = $key->l_penduduk + $key->p_penduduk;
                                                        echo $lp_penduduk_;
                                                    @endphp
                                                </td>
                                                <td id="L_Attack_{{$key->id}}">
                                                    {{$key->l_penduduk>0?number_format(($key->l_pen / $key->l_penduduk) * 100, 2) . '%':0}}
                                                </td>
                                                <td id="P_Attack_{{$key->id}}">
                                                    {{$key->p_penduduk>0?number_format(($key->p_pen / $key->p_penduduk) * 100, 2) . '%':0}}
                                                </td>
                                                <td id="LP_Attack_{{$key->id}}">
                                                    {{$lp_penduduk_>0?number_format(($lp_pen_ / $lp_penduduk_) * 100, 2) . '%':0}}

                                                </td>

                                                <td id="L_CFR_{{$key->id}}">
                                                    {{$key->l_mati>0?number_format(($key->l_pen / $key->l_mati) * 100, 2) . '%':0}}

                                                </td>
                                                <td id="P_CFR_{{$key->id}}">
                                                    {{$key->p_mati>0?number_format(($key->p_pen / $key->p_mati) * 100, 2) . '%':0}}

                                                </td>
                                                <td id="LP_CFR_{{$key->id}}">
                                                    {{$lp_mati_>0?number_format(($lp_pen_ / $lp_mati_) * 100, 2) . '%':0}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endrole
                                </tbody>
                            </table>