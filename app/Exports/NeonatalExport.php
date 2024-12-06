<?php

namespace App\Exports;

use Session;
use App\Models\Neonatal;
use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Style\Border;

class NeonatalExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    /**
     * Return a collection of the data to be exported.
     */
    public function collection()
    {
        // Fetch the data you want to export
        if(Auth::user()->roles->first()->name !== "Admin"){
            $desa = Auth::user()->unit_kerja->Desa()->get();

            $totals = [
                'lahir_hidup_L' => 0,
                'lahir_hidup_P' => 0,
                'kn1_L' => 0,
                'kn1_P' => 0,
                'kn_lengkap_L' => 0,
                'kn_lengkap_P' => 0,
                'hipo_L' => 0,
                'hipo_P' => 0,
            ];

            $desa->each(function ($d) use (&$totals) {
                $totals['lahir_hidup_L'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_hidup_L : 0;
                $totals['lahir_hidup_P'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_hidup_P : 0;
                $totals['kn1_L'] += $d->filterNeonatal(Session::get('year')) ?  $d->filterNeonatal(Session::get('year'))->kn1_L : 0;
                $totals['kn1_P'] += $d->filterNeonatal(Session::get('year')) ?  $d->filterNeonatal(Session::get('year'))->kn1_P : 0;
                $totals['hipo_L'] += $d->filterNeonatal(Session::get('year')) ?  $d->filterNeonatal(Session::get('year'))->hipo_L : 0;
                $totals['hipo_P'] += $d->filterNeonatal(Session::get('year')) ?  $d->filterNeonatal(Session::get('year'))->hipo_P : 0;
            });

            $mappedData = $desa->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->UnitKerja->kecamatan,
                    'desa_name' => $desa->nama,
                    'lahir_hidup_L' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L : 'No Data',
                    'lahir_hidup_P' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P : '0',
                    'lahir_hidup_LP' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L : '0',
                    
                    'kn1_L' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->kn1_L : '0',
                    'persen_kn1_L' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? number_format(($desa->filterNeonatal(Session::get('year'))->kn1_L / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0 : '0',
                    'kn1_P' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->kn1_P : '0',
                    'persen_kn1_P' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ?  number_format(($desa->filterNeonatal(Session::get('year'))->kn1_P / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2) : 0 : '0',
                    'kn1_LP' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterNeonatal(Session::get('year'))->kn1_L + $desa->filterNeonatal(Session::get('year'))->kn1_P : '0',
                    'persen_kn1_LP' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($desa->filterNeonatal(Session::get('year'))->kn1_L + $desa->filterNeonatal(Session::get('year'))->kn1_P)/(($desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P))* 100, 2) : 0 : '0',
                    
                    'kn_lengkap_L' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->kn_lengkap_L : '0',
                    'persen_kn_lengkap_L' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ?  number_format(($desa->filterNeonatal(Session::get('year'))->kn_lengkap_L / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0 : '0',
                    'kn_lengkap_P' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P : '0',
                    'persen_kn_lengkap_P' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ?  number_format(($desa->filterNeonatal(Session::get('year'))->kn_lengkap_P / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2) : 0 : '0',
                    'kn_lengkap_LP' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterNeonatal(Session::get('year'))->kn_lengkap_L + $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P : '0',
                    'persen_kn_lengkap_LP' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($desa->filterNeonatal(Session::get('year'))->kn_lengkap_L + $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P)/(($desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P))* 100, 2) : 0 : '0',
                    
                    'hipo_L' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->hipo_L : '0',
                    'persen_hipo_L' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L > 0 ? number_format(($desa->filterNeonatal(Session::get('year'))->hipo_L / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L) * 100, 2) : 0 : '0',
                    'hipo_P' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterNeonatal(Session::get('year'))->hipo_P : '0',
                    'persen_hipo_P' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P > 0 ?  number_format(($desa->filterNeonatal(Session::get('year'))->hipo_P / $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P) * 100, 2) : 0 : '0',
                    'hipo_LP' => $desa->filterNeonatal(Session::get('year')) ? $desa->filterNeonatal(Session::get('year'))->hipo_L + $desa->filterNeonatal(Session::get('year'))->hipo_P : '0',
                    'persen_hipo_LP' => $desa->filterNeonatal(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P> 0?number_format(($desa->filterNeonatal(Session::get('year'))->hipo_L + $desa->filterNeonatal(Session::get('year'))->hipo_P)/(($desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P))* 100, 2) : 0 : '0',
                ];
            })->toArray();

            $mappedData[] = [
                'desa_name' => 'TOTAL',
                'kecamatan_name' => '',
                'lahir_hidup_L' => $totals['lahir_hidup_L'],
                'lahir_hidup_P' => $totals['lahir_hidup_P'],
                'lahir_hidup_LP' => $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
                'kn1_L' => $totals['kn1_L'],
                'persen_kn1_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['kn1_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'kn1_P' => $totals['kn1_P'],
                'persen_kn1_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['kn1_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'kn1_LP' => $totals['kn1_L'] + $totals['kn1_P'],
                'persen_kn1_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['kn1_L'] + $totals['kn1_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
                'kn_lengkap_L' => $totals['kn_lengkap_L'],
                'persen_kn_lengkap_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['kn_lengkap_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'kn_lengkap_P' => $totals['kn_lengkap_P'],
                'persen_kn_lengkap_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['kn_lengkap_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'kn_lengkap_LP' => $totals['kn_lengkap_L'] + $totals['kn_lengkap_P'],
                'persen_kn_lengkap_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['kn_lengkap_L'] + $totals['kn_lengkap_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
                'hipo_L' => $totals['hipo_L'],
                'persen_hipo_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['hipo_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'hipo_P' => $totals['hipo_P'],
                'persen_hipo_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['hipo_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'hipo_LP' => $totals['hipo_L'] + $totals['hipo_P'],
                'persen_hipo_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['hipo_L'] + $totals['hipo_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
            ];

            return collect($mappedData);

        } else {
            $unitKerja = UnitKerja::all();

            $totals = [
                'lahir_hidup_L' => 0,
                'lahir_hidup_P' => 0,
                'kn1_L' => 0,
                'kn1_P' => 0,
                'kn_lengkap_L' => 0,
                'kn_lengkap_P' => 0,
                'hipo_L' => 0,
                'hipo_P' => 0,
            ];

            $unitKerja->each(function ($d) use (&$totals){
                $totals['lahir_hidup_L'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L');
                $totals['lahir_hidup_P'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P');
                $totals['kn1_L'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L');
                $totals['kn1_P'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P');
                $totals['kn_lengkap_L'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_L');
                $totals['kn_lengkap_P'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_P');
                $totals['hipo_L'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_L');
                $totals['hipo_P'] += $d->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_P');
            });
            $mappedData = $unitKerja->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->kecamatan,
                    'desa_name' => $desa->nama,
                    'lahir_hidup_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'),
                    'lahir_hidup_P' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                    'lahir_hidup_LP' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                    
                    'kn1_L' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L'),
                    'persen_kn1_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L')) * 100, 2) : 0,
                    'kn1_P' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P'),
                    'persen_kn1_P' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')) * 100, 2) : 0,
                    'kn1_LP' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L'),
                    'persen_kn1_LP' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format((($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn1_L')) / ($desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'))) * 100, 2) : 0,
                    
                    'kn_lengkap_L' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_L'),
                    'persen_kn_lengkap_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_L') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L')) * 100, 2) : 0,
                    'kn_lengkap_P' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_P'),
                    'persen_kn_lengkap_P' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_P') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')) * 100, 2) : 0,
                    'kn_lengkap_LP' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_L'),
                    'persen_kn_lengkap_LP' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format((($desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'kn_lengkap_L')) / ($desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'))) * 100, 2) : 0,
                    
                    'hipo_L' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_L'),
                    'persen_hipo_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_L') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L')) * 100, 2) : 0,
                    'hipo_P' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_P'),
                    'persen_hipo_P' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_P') / $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P')) * 100, 2) : 0,
                    'hipo_LP' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_L'),
                    'persen_hipo_LP' => $desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') > 0 ? number_format((($desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_P') + $desa->admin_total(Session::get('year'), 'filterNeonatal', 'hipo_L')) / ($desa->admin_total(Session::get('year'), 'filterNeonatal', 'lahir_hidup_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'))) * 100, 2) : 0,
                    
                ];
            })->toArray();

            $mappedData[] = [
                'kecamatan_name' => 'TOTAL',
                'desa_name' => '',
                'lahir_hidup_L' => $totals['lahir_hidup_L'],
                'lahir_hidup_P' => $totals['lahir_hidup_P'],
                'lahir_hidup_LP' => $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
                'kn1_L' => $totals['kn1_L'],
                'persen_kn1_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['kn1_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'kn1_P' => $totals['kn1_P'],
                'persen_kn1_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['kn1_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'kn1_LP' => $totals['kn1_L'] + $totals['kn1_P'],
                'persen_kn1_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['kn1_L'] + $totals['kn1_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
                'kn_lengkap_L' => $totals['kn_lengkap_L'],
                'persen_kn_lengkap_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['kn_lengkap_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'kn_lengkap_P' => $totals['kn_lengkap_P'],
                'persen_kn_lengkap_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['kn_lengkap_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'kn_lengkap_LP' => $totals['kn_lengkap_L'] + $totals['kn_lengkap_P'],
                'persen_kn_lengkap_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['kn_lengkap_L'] + $totals['kn_lengkap_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
                'hipo_L' => $totals['hipo_L'],
                'persen_hipo_L' => $totals['lahir_hidup_L'] > 0 ? number_format(($totals['hipo_L'] / $totals['lahir_hidup_L']) * 100, 2).'%' : 0,
                'hipo_P' => $totals['hipo_P'],
                'persen_hipo_P' => $totals['lahir_hidup_P'] > 0 ? number_format(($totals['hipo_P'] / $totals['lahir_hidup_P']) * 100, 2).'%' : 0,
                'hipo_LP' => $totals['hipo_L'] + $totals['hipo_P'],
                'persen_hipo_LP' => ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P']) > 0 ? number_format((($totals['hipo_L'] + $totals['hipo_P']) / ($totals['lahir_hidup_L'] + $totals['lahir_hidup_P'])) * 100, 2).'%' : 0,
            ];
            // Append Totals Row
            return collect($mappedData);
        }
    }
    public function headings(): array
    {
        return [
            ['CAKUPAN KUNJUNGAN NEONATAL MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS'],  // Main Title
            ['KABUPATEN/KOTA KUTAI TIMUR'],  // Main Title
            ['TAHUN '.Session::get('year')],  // Main Title
            ['Kecamatan', 'Puskesmas', 'Jumlah Lahir Hidup', '', '', 'Kunjungan Neonatal 1 kali', '', '', '', '', '', 'Kunjungan Neonatal 3 kali (Kn Lengkap)', '', '', '', '', '', 'Bayi baru lahir yang diberikan screening Hipotiroid Konginetal', '', '', '', '', ''],
            ['', '', 'Laki Laki', 'Perempuan', 'Laki Laki + Perempuan', 'Laki Laki', '', 'Perempuan', '', 'Laki Laki + Perempuan', '', 'Laki Laki', '', 'Perempuan', '', 'Laki Laki + Perempuan', '', 'Laki Laki', '', 'Perempuan', '', 'Laki Laki + Perempuan', ''],
            ['', '', '', '', '', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', '', ]
        ];
    }

    public function startCell(): string
{
    return 'A1';  // Data will start here if header rows are set from A1 to A4
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $sheet = $event->sheet;

            // Merge the main title across the entire row
            
            $sheet->mergeCells('A1:W1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:W2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:W3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // Merge main header sections
            $sheet->mergeCells('C4:E4');  // 'Jumlah Lahir Hidup' (shifted from C2:E2)
            $sheet->mergeCells('F4:K4');  // 'Kunjungan Neonatal 1 kali'
            $sheet->mergeCells('L4:Q4');  // 'Kunjungan Neonatal 3 kali (Kn Lengkap)'
            $sheet->mergeCells('R4:W4');  // 'Hipotiroid'
        
            // Merge column headers for sub-sections
            $sheet->mergeCells('A4:A6');   // 'Desa' (shifted from A2:A4)
            $sheet->mergeCells('B4:B6');   // 'Desa' (shifted from B2:B4)
            $sheet->mergeCells('C5:C6');  // 'Laki Laki (Jumlah Lahir Hidup)' (shifted from C3:C4)
            $sheet->mergeCells('D5:D6');  // 'Perempuan (Jumlah Lahir Hidup)' (shifted from D3:D4)
            $sheet->mergeCells('E5:E6');  // 'Laki Laki + Perempuan (Jumlah Lahir Hidup)' (shifted from E3:E4)
        
            // Kunjungan Neonatal 1 kali headers
            $sheet->mergeCells('F5:G5');  // 'Laki Laki' (shifted from F3:G3)
            $sheet->mergeCells('H5:I5');  // 'Perempuan' (shifted from H3:I3)
            $sheet->mergeCells('J5:K5');  // 'Laki Laki + Perempuan' (shifted from J3:K3)
        
            // Sub-headers for Kunjungan Neonatal 1 kali
            $sheet->setCellValue('F6', 'jumlah');  // (shifted from F4)
            $sheet->setCellValue('G6', '%');      // (shifted from G4)
            $sheet->setCellValue('H6', 'jumlah');  // (shifted from H4)
            $sheet->setCellValue('I6', '%');      // (shifted from I4)
            $sheet->setCellValue('J6', 'jumlah');  // (shifted from J4)
            $sheet->setCellValue('K6', '%');      // (shifted from K4)
        
            // Kunjungan Neonatal 3 kali (Kn Lengkap) headers
            $sheet->mergeCells('L5:M5');  // 'Laki Laki' (shifted from L3:M3)
            $sheet->mergeCells('N5:O5');  // 'Perempuan' (shifted from N3:O3)
            $sheet->mergeCells('P5:Q5');  // 'Laki Laki + Perempuan' (shifted from P3:Q3)
        
            // Sub-headers for Kunjungan Neonatal 3 kali
            $sheet->setCellValue('L6', 'jumlah');  // (shifted from L4)
            $sheet->setCellValue('M6', '%');      // (shifted from M4)
            $sheet->setCellValue('N6', 'jumlah');  // (shifted from N4)
            $sheet->setCellValue('O6', '%');      // (shifted from O4)
            $sheet->setCellValue('P6', 'jumlah');  // (shifted from P4)
            $sheet->setCellValue('Q6', '%');      // (shifted from Q4)
        
            // Hipotiroid
            $sheet->mergeCells('R5:S5');  // 'Laki Laki' (shifted from R3:S3)
            $sheet->mergeCells('T5:U5');  // 'Perempuan' (shifted from T3:U3)
            $sheet->mergeCells('V5:W5');  // 'Laki Laki + Perempuan' (shifted from V3:W3)
        
            // Sub-headers for Hipotiroid
            $sheet->setCellValue('R6', 'jumlah');  // (shifted from R4)
            $sheet->setCellValue('S6', '%');      // (shifted from S4)
            $sheet->setCellValue('T6', 'jumlah');  // (shifted from T4)
            $sheet->setCellValue('U6', '%');      // (shifted from U4)
            $sheet->setCellValue('V6', 'jumlah');  // (shifted from V4)
            $sheet->setCellValue('W6', '%'); 

            // Apply styles
            $sheet->getStyle('A1:W6')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A{$lastRow}:B{$lastRow}");

            // Define the full range dynamically
            $range = 'A4:W' . $lastRow;
            $sheet->getStyle($range)->applyFromArray([
                'borders' => [
                    'vertical' => [ // Applies to the outer border of the entire range
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                    
                ],
            ]);
            $sheet->getStyle("A{$lastRow}:W{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:W6')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:W5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:W4')->applyFromArray([
               'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);

            // Set column widths for readability
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(15);
            $sheet->getColumnDimension('Q')->setWidth(15);
            $sheet->getColumnDimension('V')->setWidth(15);
            $sheet->getColumnDimension('W')->setWidth(15);
            $sheet->getRowDimension(4)->setRowHeight(30);
            $sheet->getRowDimension(5)->setRowHeight(30);
            $sheet->getRowDimension(6)->setRowHeight(15);
            // Continue adjusting column widths as needed
        },
    ];
}

}
