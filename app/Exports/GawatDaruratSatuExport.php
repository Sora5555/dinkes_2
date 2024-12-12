<?php

namespace App\Exports;

use App\Models\FasilitasKesehatan;
use App\Models\KelompokUmur;
use App\Models\MelekHuruf;
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

class GawatDaruratSatuExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    /**
     * Return a collection of the data to be exported.
     */
    public function collection()
    {
        $mappedData = [];
        // Fetch the data you want to export
        if(Auth::user()->roles->first()->name !== "Admin"){
            // $desa = Auth::user()->unit_kerja->Desa()->get();

            // // $totals = [
            // //     'jumlah_ibu_hamil' => 0,
            // //     'jumlah_ibu_bersalin' => 0,
            // //     'k1' => 0,
            // //     'k4' => 0,
            // //     'k6' => 0,
            // //     'fasyankes' => 0,
            // //     'kf1' => 0,
            // //     'kf_lengkap' => 0,
            // //     'vita' => 0,
            // // ];

            // // $desa->each(function ($d) use (&$totals) {
            // //     $totals['jumlah_ibu_hamil'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->jumlah_ibu_hamil : 0;
            // //     $totals['jumlah_ibu_bersalin'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->jumlah_ibu_bersalin : 0;
            // //     $totals['k1'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->k1 : 0;
            // //     $totals['k4'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->k4 : 0;
            // //     $totals['k6'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->k6 : 0;
            // //     $totals['fasyankes'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->fasyankes : 0;
            // //     $totals['kf1'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->kf1 : 0;
            // //     $totals['kf_lengkap'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->kf_lengkap : 0;
            // //     $totals['vita'] += $d->filterDesa(Session::get('year')) ?  $d->filterDesa(Session::get('year'))->vita : 0;
            // // });

            // // $mappedData = $desa->map(function($desa) {
            // //     return [
            // //         'kecamatan_name' => $desa->UnitKerja->kecamatan,
            // //         'desa_name' => $desa->nama,
            // //         'jumlah_ibu_hamil' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil : 'No Data',
            // //         'k1' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->k1 : '0',
            // //         'persen_k1' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($desa->filterDesa(Session::get('year'))->k1 / $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, 2) : 0 : '0',
            // //         'k4' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->k4 : '0',
            // //         'persen_k4' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($desa->filterDesa(Session::get('year'))->k4 / $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, 2) : 0 : '0',
            // //         'k6' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->k6 : '0',
            // //         'persen_k6' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil > 0 ? number_format(($desa->filterDesa(Session::get('year'))->k6 / $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil) * 100, 2) : 0 : '0',
            // //         'jumlah_ibu_bersalin' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin : 'No Data',
            // //         'fasyankes' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->fasyankes : '0',
            // //         'persen_fasyankes' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($desa->filterDesa(Session::get('year'))->fasyankes / $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin) * 100, 2) : 0 : '0',
            // //         'kf1' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->kf1 : '0',
            // //         'persen_kf1' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($desa->filterDesa(Session::get('year'))->kf1 / $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin) * 100, 2) : 0 : '0',
            // //         'kf_lengkap' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->kf_lengkap : '0',
            // //         'persen_kf_lengkap' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($desa->filterDesa(Session::get('year'))->kf_lengkap / $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin) * 100, 2) : 0 : '0',
            // //         'vita' => $desa->filterDesa(Session::get('year')) ?  $desa->filterDesa(Session::get('year'))->kf_lengkap : '0',
            // //         'persen_vita' => $desa->filterDesa(Session::get('year')) ? $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin > 0 ? number_format(($desa->filterDesa(Session::get('year'))->vita / $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin) * 100, 2) : 0 : '0',
            // //     ];
            // // })->toArray();

            // // $mappedData[] = [
            // //     'desa_name' => 'TOTAL',
            // //     'kecamatan_name' => '',
            // //     'jumlah_ibu_hamil' => $totals['jumlah_ibu_hamil'],
            // //     'k1' => $totals['k1'],
            // //     'persen_k1' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k1'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            // //     'k4' => $totals['k4'],
            // //     'persen_k4' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k4'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            // //     'k6' => $totals['k6'],
            // //     'persen_k6' => $totals['jumlah_ibu_hamil'] > 0 ? number_format(($totals['k6'] / $totals['jumlah_ibu_hamil']) * 100, 2).'%' : 0,
            // //     'jumlah_ibu_bersalin' => $totals['jumlah_ibu_bersalin'],
            // //     'fasyankes' => $totals['fasyankes'],
            // //     'persen_fasyankes' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['fasyankes'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            // //     'kf1' => $totals['kf1'],
            // //     'persen_kf1' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['kf1'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            // //     'kf_lengkap' => $totals['kf_lengkap'],
            // //     'persen_kf_lengkap' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['kf_lengkap'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            // //     'vita' => $totals['vita'],
            // //     'persen_vita' => $totals['jumlah_ibu_bersalin'] > 0 ? number_format(($totals['vita'] / $totals['jumlah_ibu_bersalin']) * 100, 2).'%' : 0,
            // // ];

            // return collect($mappedData);

        } else {

        }



        $RumahSakit = FasilitasKesehatan::where('tipe', 'RUMAH SAKIT')->whereYear('created_at', Session::get('year'))->get();



        $mappedData[] = $RumahSakit->map(function($item, $no) {
            return [
                'td0' => $no++,
                'td1' => $item->fasilitas_kesehatan,
                'td2' => ($item->kemenkes + $item->pemprov + $item->pemkot + $item->tni_polri + $item->swasta + $item->bumn + $item->ormas),
                'td3' => $item->gawat_darurat_1,
                'td4' => ($item->kemenkes + $item->pemprov + $item->pemkot + $item->tni_polri + $item->bumn + $item->swasta + $item->ormas > 0?number_format($item->gawat_darurat_1/($item->kemenkes + $item->pemprov + $item->pemkot + $item->tni_polri + $item->bumn + $item->swasta + $item->ormas) * 100, 2):0),
                // 'td5' =>
            ];
        })->toArray();

        return collect($mappedData);
    }
    public function headings(): array
    {
        return [
            ['CAKUPAN PELAYANAN KESEHATAN PADA IBU HAMIL, IBU BERSALIN, DAN IBU NIFAS MENURUT KECAMATAN DAN PUSKESMAS'],  // Main Title
            ['KABUPATEN/KOTA KUTAI TIMUR'],  // Main Title
            ['TAHUN '.Session::get('year')],  // Main Title
            ['No', 'Fasilitas Kesehatan', 'Jumlah','MEMPUNYAI KEMAMPUAN PELAYANAN GAWAT DARURAT LEVEL I', ''],
            ['', '', '', 'Jumlah', '%'],
            // ['', '', '', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', '', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%', 'jumlah', '%']
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

            $sheet->mergeCells('A1:E1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:E2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:E3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // Merge main header sections
            $sheet->mergeCells('A4:A5');
            $sheet->mergeCells('B4:B5');
            $sheet->mergeCells('C4:C5');
            $sheet->mergeCells('D4:E4');


            // $sheet->mergeCells('D4:F4');
            // $sheet->mergeCells('G4:G5');
            // $sheet->mergeCells('H4:H5');
            // $sheet->mergeCells('I4:I5');
            // $sheet->mergeCells('J4:J5');
            // $sheet->mergeCells('K4:K5');


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
            $sheet->getStyle('A1:E5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],

            ]);
            $lastRow = $sheet->getHighestRow();
            // $sheet->mergeCells("A{$lastRow}:B{$lastRow}");

            // Define the full range dynamically
            $range = 'A4:E' . $lastRow;

            // $sheet->mergeCells('A'.($lastRow - 0).':C'.($lastRow - 0));
            // $sheet->mergeCells('A'.($lastRow - 1).':C'.($lastRow - 1));
            // $sheet->mergeCells('A'.($lastRow - 2).':C'.($lastRow - 2));


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
            $sheet->getStyle("A{$lastRow}:E{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:E5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:E5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:E5')->applyFromArray([
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
            // Continue adjusting column widths as needed
        },
    ];
}

}
