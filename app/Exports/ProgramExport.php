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

class ProgramExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
                    'no' => $item->id,
                    'unit_kerja' => $item->nama,
                    'tenaga_teknik_farmasi_l' => $item->TenagaTeknikFarmasi->sum("laki_laki"),
                    'tenaga_teknik_farmasi_p' => $item->TenagaTeknikFarmasi->sum("perempuan"),
                    'tenaga_teknik_farmasi_lp' => $item->TenagaTeknikFarmasi->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("perempuan"),

                    'apoteker_l' => $item->Apoteker->sum("laki_laki"),
                    'apoteker_p' => $item->Apoteker->sum("perempuan"),
                    'apoteker_lp' => $item->Apoteker->sum("laki_laki") + $item->Apoteker->sum("perempuan"),

                    'at_l' => $item->Apoteker->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("laki_laki"),
                    'at_p' => $item->Apoteker->sum("perempuan") + $item->TenagaTeknikFarmasi->sum('perempuan'),
                    'at_lp' => $item->Apoteker->sum("laki_laki") + $item->Apoteker->sum("perempuan") + $item->TenagaTeknikFarmasi->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("perempuan"),
                ];

                $employeeRows = $item->detail_desa->map(function ($items) {
                    // dd($items->AhliLabMedik->laki_laki);
                    return [
                        'no' => '-',
                        'unit_kerja' => $items->nama,
                        'tenaga_teknik_farmasi_l' => $items->TenagaTeknikFarmasi->laki_laki ?? 0,
                        'tenaga_teknik_farmasi_p' => $items->TenagaTeknikFarmasi->perempuan ?? 0,
                        'tenaga_teknik_farmasi_lp' => ($items->TenagaTeknikFarmasi->laki_laki ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),

                        'apoteker_l' => $items->Apoteker->laki_laki ?? 0,
                        'apoteker_p' => $items->Apoteker->perempuan ?? 0,
                        'apoteker_lp' => ($items->Apoteker->laki_laki ?? 0) + ($items->Apoteker->perempuan ?? 0),

                        'at_l' => ($items->Apoteker->laki_laki ?? 0)+ ($items->TenagaTeknikFarmasi->laki_laki ?? 0),
                        'at_p' => ($items->Apoteker->perempuan ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),
                        'at_lp' => ($items->Apoteker->laki_laki ?? 0) + ($items->Apoteker->perempuan ?? 0) + ($items->TenagaTeknikFarmasi->laki_laki ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),
                    ];
                });

                // Gabungkan header unit kerja dan employees
                return collect([$unitKerjaRow])->concat($employeeRows);
                // return collect([$unitKerjaRow]);
            })->toArray();
            return collect($mappedData);

        } else {
            $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();

            $mappedData = $unit_kerja->flatMap(function ($item) {
                // Data unit kerja sebagai header
                $unitKerjaRow = [
                    'no' => $item->id,
                    'unit_kerja' => $item->nama,
                    'tenaga_teknik_farmasi_l' => $item->TenagaTeknikFarmasi->sum("laki_laki"),
                    'tenaga_teknik_farmasi_p' => $item->TenagaTeknikFarmasi->sum("perempuan"),
                    'tenaga_teknik_farmasi_lp' => $item->TenagaTeknikFarmasi->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("perempuan"),

                    'apoteker_l' => $item->Apoteker->sum("laki_laki"),
                    'apoteker_p' => $item->Apoteker->sum("perempuan"),
                    'apoteker_lp' => $item->Apoteker->sum("laki_laki") + $item->Apoteker->sum("perempuan"),

                    'at_l' => $item->Apoteker->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("laki_laki"),
                    'at_p' => $item->Apoteker->sum("perempuan") + $item->TenagaTeknikFarmasi->sum('perempuan'),
                    'at_lp' => $item->Apoteker->sum("laki_laki") + $item->Apoteker->sum("perempuan") + $item->TenagaTeknikFarmasi->sum("laki_laki") + $item->TenagaTeknikFarmasi->sum("perempuan"),
                ];

                $employeeRows = $item->detail_desa->map(function ($items) {
                    // dd($items->AhliLabMedik->laki_laki);
                    return [
                        'no' => '-',
                        'unit_kerja' => $items->nama,
                        'tenaga_teknik_farmasi_l' => $items->TenagaTeknikFarmasi->laki_laki ?? 0,
                        'tenaga_teknik_farmasi_p' => $items->TenagaTeknikFarmasi->perempuan ?? 0,
                        'tenaga_teknik_farmasi_lp' => ($items->TenagaTeknikFarmasi->laki_laki ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),

                        'apoteker_l' => $items->Apoteker->laki_laki ?? 0,
                        'apoteker_p' => $items->Apoteker->perempuan ?? 0,
                        'apoteker_lp' => ($items->Apoteker->laki_laki ?? 0) + ($items->Apoteker->perempuan ?? 0),

                        'at_l' => ($items->Apoteker->laki_laki ?? 0)+ ($items->TenagaTeknikFarmasi->laki_laki ?? 0),
                        'at_p' => ($items->Apoteker->perempuan ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),
                        'at_lp' => ($items->Apoteker->laki_laki ?? 0) + ($items->Apoteker->perempuan ?? 0) + ($items->TenagaTeknikFarmasi->laki_laki ?? 0) + ($items->TenagaTeknikFarmasi->perempuan ?? 0),
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
            ['No', 'Unit Kerja / Desa', 'Tenaga Teknis Farmasi', '', '', 'Apoteker', '', '', 'Total', '', ''],
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
            $sheet->getStyle('A1:K5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],

            ]);
            $lastRow = $sheet->getHighestRow();
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
