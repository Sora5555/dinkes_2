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

class UnitOrganisasiExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    /**
     * Return a collection of the data to be exported.s
     */
    public function collection()
    {
        // $mappedData = [];
        // Fetch the data you want to export
        if(Auth::user()->roles->first()->name !== "Admin"){
            // $desa = Auth::user()->unit_kerja->Desa()->get();
            $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
            // $totals = [
                // $mappedData = $unit_kerja->flatMap(function ($item) {
                //     // Data unit kerja sebagai header
                //     $unitKerjaRow = [
                //         'no' => $item->id,
                //         'unit_kerja' => $item->nama,
                //         'tenaga_kesehatan_masyarakat_l' => $item->TenagaKesehatanMasyarakat->sum("laki_laki"),
                //         'tenaga_kesehatan_masyarakat_p' => $item->TenagaKesehatanMasyarakat->sum("perempuan"),
                //         'tenaga_kesehatan_masyarakat_lp' => $item->TenagaKesehatanMasyarakat->sum("laki_laki") + $item->TenagaKesehatanMasyarakat->sum("perempuan"),
                //         'tenaga_kesehatan_lingkungan_l' => $item->TenagaKesehatanLingkungan->sum("laki_laki"),
                //         'tenaga_kesehatan_lingkungan_p' => $item->TenagaKesehatanLingkungan->sum("perempuan"),
                //         'tenaga_kesehatan_lingkungan_lp' => $item->TenagaKesehatanLingkungan->sum("laki_laki") + $item->TenagaKesehatanLingkungan->sum("perempuan"),
                //         'tenaga_gizi_l' => $item->TenagaGizi->sum("laki_laki"),
                //         'tenaga_gizi_p' => $item->TenagaGizi->sum("perempuan"),
                //         'tenaga_gizi_lp' => $item->TenagaGizi->sum("laki_laki") + $item->TenagaGizi->sum("perempuan"),
                //     ];

                //     $employeeRows = $item->detail_desa->map(function ($items) {
                //         // dd($items->AhliLabMedik->laki_laki);
                //         return [
                //             'no' => '-',
                //             'unit_kerja' => $items->nama,
                //             'tenaga_kesehatan_masyarakat_l' => $items->TenagaKesehatanMasyarakat->laki_laki ?? 0,
                //             'tenaga_kesehatan_masyarakat_p' => $items->TenagaKesehatanMasyarakat->perempuan ?? 0,
                //             'tenaga_kesehatan_masyarakat_lp' => ($items->TenagaKesehatanMasyarakat->laki_laki ?? 0) + ($items->TenagaKesehatanMasyarakat->perempuan ?? 0),
                //             'tenaga_kesehatan_lingkungan_l' => $items->TenagaKesehatanLingkungan->laki_laki ?? 0,
                //             'tenaga_kesehatan_lingkungan_p' => $items->TenagaKesehatanLingkungan->perempuan ?? 0,
                //             'tenaga_kesehatan_lingkungan_lp' => ($items->TenagaKesehatanLingkungan->laki_laki ?? 0) + ($items->TenagaKesehatanLingkungan->perempuan ?? 0),
                //             'tenaga_gizi_l' => $items->TenagaGizi->laki_laki ?? 0,
                //             'tenaga_gizi_p' => $items->TenagaGizi->perempuan ?? 0,
                //             'tenaga_gizi_lp' => ($items->TenagaGizi->laki_laki ?? 0) + ($items->TenagaGizi->perempuan ?? 0),
                //         ];
                //     });

                //     // Gabungkan header unit kerja dan employees
                //     return collect([$unitKerjaRow])->concat($employeeRows);
                //     // return collect([$unitKerjaRow]);
                // })->toArray();

                $mappedData = $unit_kerja->map(function ($items) {
                    return [
                            'no' => $items->id,
                            'unit_kerja' => $items->nama,
                            'tenaga_kesehatan_masyarakat_l' => $items->TenagaKesehatanMasyarakat->laki_laki ?? 0,
                            'tenaga_kesehatan_masyarakat_p' => $items->TenagaKesehatanMasyarakat->perempuan ?? 0,
                            'tenaga_kesehatan_masyarakat_lp' => ($items->TenagaKesehatanMasyarakat->laki_laki ?? 0) + ($items->TenagaKesehatanMasyarakat->perempuan ?? 0),
                            'tenaga_kesehatan_lingkungan_l' => $items->TenagaKesehatanLingkungan->laki_laki ?? 0,
                            'tenaga_kesehatan_lingkungan_p' => $items->TenagaKesehatanLingkungan->perempuan ?? 0,
                            'tenaga_kesehatan_lingkungan_lp' => ($items->TenagaKesehatanLingkungan->laki_laki ?? 0) + ($items->TenagaKesehatanLingkungan->perempuan ?? 0),
                            'tenaga_gizi_l' => $items->TenagaGizi->laki_laki ?? 0,
                            'tenaga_gizi_p' => $items->TenagaGizi->perempuan ?? 0,
                            'tenaga_gizi_lp' => ($items->TenagaGizi->laki_laki ?? 0) + ($items->TenagaGizi->perempuan ?? 0),
                    ];
                })->toArray();

                return collect($mappedData);
        } else {
            $unit_kerja = UnitKerja::get();

            // $unitKerja = UnitKerja::all();

            // $totals = [
            //     'jumlah_ibu_hamil' => 0,
            //     'jumlah_ibu_bersalin' => 0,
            //     'k1' => 0,
            //     'k4' => 0,
            //     'k6' => 0,
            //     'fasyankes' => 0,
            //     'kf1' => 0,
            //     'kf_lengkap' => 0,
            //     'vita' => 0,
            // ];

            // $unitKerja->each(function ($d) use (&$totals){
            //     $totals['jumlah_ibu_hamil'] += $d->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_hamil');
            //     $totals['jumlah_ibu_bersalin'] += $d->admin_total(Session::get('year'), 'filterDesa', 'jumlah_ibu_bersalin');
            //     $totals['k1'] += $d->admin_total(Session::get('year'), 'filterDesa', 'k1');
            //     $totals['k4'] += $d->admin_total(Session::get('year'), 'filterDesa', 'k4');
            //     $totals['k6'] += $d->admin_total(Session::get('year'), 'filterDesa', 'k6');
            //     $totals['fasyankes'] += $d->admin_total(Session::get('year'), 'filterDesa', 'fasyankes');
            //     $totals['kf1'] += $d->admin_total(Session::get('year'), 'filterDesa', 'kf1');
            //     $totals['kf_lengkap'] += $d->admin_total(Session::get('year'), 'filterDesa', 'kf_lengkap');
            //     $totals['vita'] += $d->admin_total(Session::get('year'), 'filterDesa', 'vita');
            // });

            // $mappedData = $unit_kerja->map(function($desa) {
            //     return [
            //         'id' => $desa->id,
            //         'unit_kerja' => $desa->nama,
            //         'ahli_teknologi_lab_medik_l' =>
            //     ];
            // })->toArray();

            // $mappedData[] = [
            //     'desa_name' => 'TOTAL',
            //     'kecamatan_name' => '',
            //     'jumlah_ibu_hamil' => $totals['jumlah_ibu_hamil'],
            //     'k1' => $totals['k1'],
            //     'persen_k1' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k1'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            //     'k4' => $totals['k4'],
            //     'persen_k4' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k4'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            //     'k6' => $totals['k6'],
            //     'persen_k6' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k6'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            //     'jumlah_ibu_bersalin' => $totals['jumlah_ibu_bersalin'],
            //     'fasyankes' => $totals['fasyankes'],
            //     'persen_fasyankes' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['fasyankes'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            //     'kf1' => $totals['kf1'],
            //     'persen_kf1' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['kf1'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            //     'kf_lengkap' => $totals['kf_lengkap'],
            //     'persen_kf_lengkap' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['kf_lengkap'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            //     'vita' => $totals['vita'],
            //     'persen_vita' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['vita'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            // ];
            // // Append Totals Row

            // dd($unit_kerja);

            // $mappedData = $unit_kerja->flatMap(function ($item) {
            //     // Data unit kerja sebagai header
            //     $unitKerjaRow = [
            //         'no' => $item->id,
            //         'unit_kerja' => $item->nama,
            //         'tenaga_kesehatan_masyarakat_l' => $item->TenagaKesehatanMasyarakat->sum("laki_laki"),
            //         'tenaga_kesehatan_masyarakat_p' => $item->TenagaKesehatanMasyarakat->sum("perempuan"),
            //         'tenaga_kesehatan_masyarakat_lp' => $item->TenagaKesehatanMasyarakat->sum("laki_laki") + $item->TenagaKesehatanMasyarakat->sum("perempuan"),
            //         'tenaga_kesehatan_lingkungan_l' => $item->TenagaKesehatanLingkungan->sum("laki_laki"),
            //         'tenaga_kesehatan_lingkungan_p' => $item->TenagaKesehatanLingkungan->sum("perempuan"),
            //         'tenaga_kesehatan_lingkungan_lp' => $item->TenagaKesehatanLingkungan->sum("laki_laki") + $item->TenagaKesehatanLingkungan->sum("perempuan"),
            //         'tenaga_gizi_l' => $item->TenagaGizi->sum("laki_laki"),
            //         'tenaga_gizi_p' => $item->TenagaGizi->sum("perempuan"),
            //         'tenaga_gizi_lp' => $item->TenagaGizi->sum("laki_laki") + $item->TenagaGizi->sum("perempuan"),
            //     ];

            //     $employeeRows = $item->detail_desa->map(function ($items) {
            //         // dd($items->AhliLabMedik->laki_laki);
            //         return [
            //             'no' => '-',
            //             'unit_kerja' => $items->nama,
            //             'tenaga_kesehatan_masyarakat_l' => $items->TenagaKesehatanMasyarakat->laki_laki ?? 0,
            //             'tenaga_kesehatan_masyarakat_p' => $items->TenagaKesehatanMasyarakat->perempuan ?? 0,
            //             'tenaga_kesehatan_masyarakat_lp' => ($items->TenagaKesehatanMasyarakat->laki_laki ?? 0) + ($items->TenagaKesehatanMasyarakat->perempuan ?? 0),
            //             'tenaga_kesehatan_lingkungan_l' => $items->TenagaKesehatanLingkungan->laki_laki ?? 0,
            //             'tenaga_kesehatan_lingkungan_p' => $items->TenagaKesehatanLingkungan->perempuan ?? 0,
            //             'tenaga_kesehatan_lingkungan_lp' => ($items->TenagaKesehatanLingkungan->laki_laki ?? 0) + ($items->TenagaKesehatanLingkungan->perempuan ?? 0),
            //             'tenaga_gizi_l' => $items->TenagaGizi->laki_laki ?? 0,
            //             'tenaga_gizi_p' => $items->TenagaGizi->perempuan ?? 0,
            //             'tenaga_gizi_lp' => ($items->TenagaGizi->laki_laki ?? 0) + ($items->TenagaGizi->perempuan ?? 0),
            //         ];
            //     });

            //     // Gabungkan header unit kerja dan employees
            //     return collect([$unitKerjaRow])->concat($employeeRows);
            //     // return collect([$unitKerjaRow]);
            // })->toArray();

            $mappedData = $unit_kerja->map(function ($items) {
                return [
                        'no' => $items->id,
                        'unit_kerja' => $items->nama,
                        'tenaga_kesehatan_masyarakat_l' => $items->TenagaKesehatanMasyarakat->laki_laki ?? 0,
                        'tenaga_kesehatan_masyarakat_p' => $items->TenagaKesehatanMasyarakat->perempuan ?? 0,
                        'tenaga_kesehatan_masyarakat_lp' => ($items->TenagaKesehatanMasyarakat->laki_laki ?? 0) + ($items->TenagaKesehatanMasyarakat->perempuan ?? 0),
                        'tenaga_kesehatan_lingkungan_l' => $items->TenagaKesehatanLingkungan->laki_laki ?? 0,
                        'tenaga_kesehatan_lingkungan_p' => $items->TenagaKesehatanLingkungan->perempuan ?? 0,
                        'tenaga_kesehatan_lingkungan_lp' => ($items->TenagaKesehatanLingkungan->laki_laki ?? 0) + ($items->TenagaKesehatanLingkungan->perempuan ?? 0),
                        'tenaga_gizi_l' => $items->TenagaGizi->laki_laki ?? 0,
                        'tenaga_gizi_p' => $items->TenagaGizi->perempuan ?? 0,
                        'tenaga_gizi_lp' => ($items->TenagaGizi->laki_laki ?? 0) + ($items->TenagaGizi->perempuan ?? 0),
                ];
            })->toArray();

            return collect($mappedData);
        }
    }
    public function headings(): array
    {
        return [
            ['CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS'],  // Main Title
            ['KABUPATEN/KOTA KUTAI TIMUR'],  // Main Title
            ['TAHUN '.Session::get('year')],  // Main Title
            ['No', 'Unit Kerja / Desa', 'Tenaga Kesehatan Masyarakat', '', '', 'Tenaga Kesehatan Lingkungan', '', '', 'Tenaga Kesehatan Lingkungan', '', ''],
            ['', '', 'L', 'P', 'L + P', 'L', 'P', 'L + P', 'L', 'P', 'L + P'],
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

            $sheet->mergeCells('A1:K1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:K2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:K3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // Merge main header sections
            $sheet->mergeCells('A4:A5');
            $sheet->mergeCells('B4:B5');
            $sheet->mergeCells('C4:E4');
            $sheet->mergeCells('F4:H4');
            $sheet->mergeCells('I4:K4');
            $sheet->mergeCells('L4:K4');





            // $sheet->mergeCells('A4:A5');
            // $sheet->mergeCells('B5:B5');
            // $sheet->mergeCells('C5:C6');
            // $sheet->mergeCells('J5:J6');
            // $sheet->mergeCells('D5:E5');
            // $sheet->mergeCells('F5:G5');
            // $sheet->mergeCells('H5:I5');
            // $sheet->mergeCells('K5:L5');
            // $sheet->mergeCells('M5:N5');
            // $sheet->mergeCells('O5:P5');
            // $sheet->mergeCells('Q5:R5');

            // Sub-headers for Kunjungan Neonatal 1 kali
            // $sheet->setCellValue('F6', 'jumlah');  // (shifted from F4)
            // $sheet->setCellValue('G6', '%');      // (shifted from G4)
            // $sheet->setCellValue('H6', 'jumlah');  // (shifted from H4)
            // $sheet->setCellValue('I6', '%');      // (shifted from I4)
            // $sheet->setCellValue('J6', 'jumlah');  // (shifted from J4)
            // $sheet->setCellValue('K6', '%');      // (shifted from K4)

            // // Kunjungan Neonatal 3 kali (Kn Lengkap) headers
            // $sheet->mergeCells('L5:M5');  // 'Laki Laki' (shifted from L3:M3)
            // $sheet->mergeCells('N5:O5');  // 'Perempuan' (shifted from N3:O3)
            // $sheet->mergeCells('P5:Q5');  // 'Laki Laki + Perempuan' (shifted from P3:Q3)

            // // Sub-headers for Kunjungan Neonatal 3 kali
            // $sheet->setCellValue('L6', 'jumlah');  // (shifted from L4)
            // $sheet->setCellValue('M6', '%');      // (shifted from M4)
            // $sheet->setCellValue('N6', 'jumlah');  // (shifted from N4)
            // $sheet->setCellValue('O6', '%');      // (shifted from O4)
            // $sheet->setCellValue('P6', 'jumlah');  // (shifted from P4)
            // $sheet->setCellValue('Q6', '%');      // (shifted from Q4)

            // Hipotiroid
            // $sheet->mergeCells('R5:S5');  // 'Laki Laki' (shifted from R3:S3)
            // $sheet->mergeCells('T5:U5');  // 'Perempuan' (shifted from T3:U3)
            // $sheet->mergeCells('V5:W5');  // 'Laki Laki + Perempuan' (shifted from V3:W3)

            // // Sub-headers for Hipotiroid
            // $sheet->setCellValue('R6', 'jumlah');  // (shifted from R4)
            // $sheet->setCellValue('S6', '%');      // (shifted from S4)
            // $sheet->setCellValue('T6', 'jumlah');  // (shifted from T4)
            // $sheet->setCellValue('U6', '%');      // (shifted from U4)
            // $sheet->setCellValue('V6', 'jumlah');  // (shifted from V4)
            // $sheet->setCellValue('W6', '%');

            // Apply styles
            $sheet->getStyle('A1:K5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],

            ]);
            $lastRow = $sheet->getHighestRow() + 1;
            $sheet->mergeCells("A{$lastRow}:B{$lastRow}");

            // Define the full range dynamically
            $range = 'A4:K' . $lastRow;
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
            $sheet->getStyle("A{$lastRow}:K{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:K5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:K5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:K4')->applyFromArray([
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

            // // Set column widths for readability
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(15);
            $sheet->getColumnDimension('Q')->setWidth(15);
            $sheet->getColumnDimension('V')->setWidth(15);
            $sheet->getColumnDimension('W')->setWidth(15);
            $sheet->getRowDimension(4)->setRowHeight(30);
            $sheet->getRowDimension(5)->setRowHeight(30);
            $sheet->getRowDimension(6)->setRowHeight(15);
            // // Continue adjusting column widths as needed
        },
    ];
}

}
