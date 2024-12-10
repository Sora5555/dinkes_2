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

class SubKegiatanExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */

    /**
     * Return a collection of the data to be exported.
     */
    public function collection()
    {
        // $mappedData = [];
        // Fetch the data you want to export
        if(Auth::user()->roles->first()->name !== "Admin"){
            // $desa = Auth::user()->unit_kerja->Desa()->get();
            $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->whereYear('created_at', Session::get('year'))->get();

            $mappedData = $unit_kerja->flatMap(function ($item) {
                // Data unit kerja sebagai header
                $unitKerjaRow = [
                    'unit_kerja' => $item->nama,
                    'posyandu_pramata' => $item->Posyandu->sum('pratama'),
                    'posyandu_pramata_persen' => ($item->Posyandu->sum('pratama') > 0?number_format(($item->Posyandu->sum('pratama')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0).'%',
                    'posyandu_madya' => $item->Posyandu->sum('madya'),
                    'posyandu_madya_persen' => ($item->Posyandu->sum('madya') > 0?number_format(($item->Posyandu->sum('madya')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'posyandu_purnama' => $item->Posyandu->sum('purnama'),
                    'posyandu_purnama_persen' => ($item->Posyandu->sum('purnama') > 0?number_format(($item->Posyandu->sum('purnama')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'posyandu_mandiri' => $item->Posyandu->sum('mandiri'),
                    'posyandu_mandiri_persen' => ($item->Posyandu->sum('mandiri') > 0?number_format(($item->Posyandu->sum('mandiri')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'total' => $item->Posyandu->sum('pratama') + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri'),
                    'posyandu_aktif' => $item->Posyandu->sum('aktif'),
                    'posyandu_aktif_persen' => ($item->Posyandu->sum('aktif') > 0?number_format(($item->Posyandu->sum('aktif')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'): 0)."%",
                    'posbindu' => ($item->Posyandu->sum('posbindu')),
                ];

                $employeeRows = $item->detail_desa->map(function ($items) {
                    // dd($items->AhliLabMedik->laki_laki);

                    $persen = ( ($items->Posyandu->pratama ?? 0) + ($items->Posyandu->madya ?? 0) + ($items->Posyandu->purnama ?? 0) + ($items->Posyandu->mandiri ?? 0));
                    return [
                        'unit_kerja' => $items->nama,
                        'posyandu_pramata' => $items->Posyandu->pratama ?? 0,
                        'posyandu_pramata_persen' => ( ($items->Posyandu->pratama ?? 0) > 0?number_format((  ($items->Posyandu->pratama ?? 0) / $persen)*100, '2'):0).'%',
                        'posyandu_madya' => $items->Posyandu->madya ?? 0,
                        'posyandu_madya_persen' => ( ($items->Posyandu->madya ?? 0)  > 0?number_format(($items->Posyandu->sum('madya')/ $persen)*100, '2'):0)."%",
                        'posyandu_purnama' => $items->Posyandu->purnama ?? 0,
                        'posyandu_purnama_persen' => ( ($items->Posyandu->purnama ?? 0) > 0?number_format(($items->Posyandu->sum('purnama')/ $persen)*100, '2'):0)."%",
                        'posyandu_mandiri' => $items->Posyandu->mandiri ?? 0,
                        'posyandu_mandiri_persen' => ( ($items->Posyandu->mandiri ?? 0) > 0?number_format(($items->Posyandu->sum('mandiri')/ $persen)*100, '2'):0)."%",
                        'total' => ($items->Posyandu->pratama ?? 0) + ($items->Posyandu->madya ?? 0) + ($items->Posyandu->purnama ?? 0) + ($items->Posyandu->mandiri ?? 0),
                        'posyandu_aktif' => $items->Posyandu->aktif ?? 0,
                        'posyandu_aktif_persen' => ( ($items->Posyandu->aktif ?? 0) > 0 ? number_format(( ($items->Posyandu->aktif) / $persen)*100, '2'): 0)."%",
                        'posbindu' => ($items->Posyandu->posbindu ?? 0),
                    ];
                });

                // Gabungkan header unit kerja dan employees
                return collect([$unitKerjaRow])->concat($employeeRows);
                // return collect([$unitKerjaRow]);
            })->toArray();

            return collect($mappedData);

        } else {
            $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();
            $mappedData = [];

            $mappedData = $unit_kerja->flatMap(function ($item) {
                // Data unit kerja sebagai header
                $unitKerjaRow = [
                    'unit_kerja' => $item->nama,
                    'posyandu_pramata' => $item->Posyandu->sum('pratama'),
                    'posyandu_pramata_persen' => ($item->Posyandu->sum('pratama') > 0?number_format(($item->Posyandu->sum('pratama')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0).'%',
                    'posyandu_madya' => $item->Posyandu->sum('madya'),
                    'posyandu_madya_persen' => ($item->Posyandu->sum('madya') > 0?number_format(($item->Posyandu->sum('madya')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'posyandu_purnama' => $item->Posyandu->sum('purnama'),
                    'posyandu_purnama_persen' => ($item->Posyandu->sum('purnama') > 0?number_format(($item->Posyandu->sum('purnama')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'posyandu_mandiri' => $item->Posyandu->sum('mandiri'),
                    'posyandu_mandiri_persen' => ($item->Posyandu->sum('mandiri') > 0?number_format(($item->Posyandu->sum('mandiri')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'):0)."%",
                    'total' => $item->Posyandu->sum('pratama') + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri'),
                    'posyandu_aktif' => $item->Posyandu->sum('aktif'),
                    'posyandu_aktif_persen' => ($item->Posyandu->sum('aktif') > 0?number_format(($item->Posyandu->sum('aktif')/($item->Posyandu->sum("pratama") + $item->Posyandu->sum('madya') + $item->Posyandu->sum('purnama') + $item->Posyandu->sum('mandiri')))*100, '2'): 0)."%",
                    'posbindu' => ($item->Posyandu->sum('posbindu')),
                ];

                $employeeRows = $item->detail_desa->map(function ($items) {
                    // dd($items->AhliLabMedik->laki_laki);

                    $persen = ( ($items->Posyandu->pratama ?? 0) + ($items->Posyandu->madya ?? 0) + ($items->Posyandu->purnama ?? 0) + ($items->Posyandu->mandiri ?? 0));
                    return [
                        'unit_kerja' => $items->nama,
                        'posyandu_pramata' => $items->Posyandu->pratama ?? 0,
                        'posyandu_pramata_persen' => ( ($items->Posyandu->pratama ?? 0) > 0?number_format((  ($items->Posyandu->pratama ?? 0) / $persen)*100, '2'):0).'%',
                        'posyandu_madya' => $items->Posyandu->madya ?? 0,
                        'posyandu_madya_persen' => ( ($items->Posyandu->madya ?? 0)  > 0?number_format(($items->Posyandu->sum('madya')/ $persen)*100, '2'):0)."%",
                        'posyandu_purnama' => $items->Posyandu->purnama ?? 0,
                        'posyandu_purnama_persen' => ( ($items->Posyandu->purnama ?? 0) > 0?number_format(($items->Posyandu->sum('purnama')/ $persen)*100, '2'):0)."%",
                        'posyandu_mandiri' => $items->Posyandu->mandiri ?? 0,
                        'posyandu_mandiri_persen' => ( ($items->Posyandu->mandiri ?? 0) > 0?number_format(($items->Posyandu->sum('mandiri')/ $persen)*100, '2'):0)."%",
                        'total' => ($items->Posyandu->pratama ?? 0) + ($items->Posyandu->madya ?? 0) + ($items->Posyandu->purnama ?? 0) + ($items->Posyandu->mandiri ?? 0),
                        'posyandu_aktif' => $items->Posyandu->aktif ?? 0,
                        'posyandu_aktif_persen' => ( ($items->Posyandu->aktif ?? 0) > 0 ? number_format(( ($items->Posyandu->aktif) / $persen)*100, '2'): 0)."%",
                        'posbindu' => ($items->Posyandu->posbindu ?? 0),
                    ];
                });

                // Gabungkan header unit kerja dan employees
                return collect([$unitKerjaRow])->concat($employeeRows);
                // return collect([$unitKerjaRow]);
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
            ['Puskesmas', 'Strata Posyandu', '', '', '', '', '', '', '', '', 'Posyandu Aktif','' ,'Jumlah Posbindu PTM'],
            ['', 'Pratama', '', 'Madya', '', 'Purnama', '', 'Mandiri', '', 'Total', '', '', ''],
            ['', 'Jumlah', '%', 'Jumlah', '%', 'Jumlah', '%', 'Jumlah', '%', '', 'Jumlah', '%', ''],
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

            $sheet->mergeCells('A1:M1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:M2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:M3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // // Merge main header sections
            $sheet->mergeCells('A4:A6');
            $sheet->mergeCells('B4:J4');
            $sheet->mergeCells('K4:L5');
            $sheet->mergeCells('M4:M6');

            $sheet->mergeCells('B5:C5');
            $sheet->mergeCells('D5:E5');
            $sheet->mergeCells('F5:G5');
            $sheet->mergeCells('H5:I5');




            // $sheet->mergeCells('F4:H4');
            // $sheet->mergeCells('I4:K4');
            // $sheet->mergeCells('L4:N4');
            // $sheet->mergeCells('I4:K4');
            // $sheet->mergeCells('L4:K4');





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
            $sheet->getStyle('A1:M5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],

            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A{$lastRow}:B{$lastRow}");

            // Define the full range dynamically
            $range = 'A4:M' . $lastRow;
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
            $sheet->getStyle("A{$lastRow}:M{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:M5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:M5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:M4')->applyFromArray([
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
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
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
