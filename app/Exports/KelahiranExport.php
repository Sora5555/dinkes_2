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

class KelahiranExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
                'lahir_mati_L' => 0,
                'lahir_hidup_P' => 0,
                'lahir_mati_P' => 0,
            ];

            $desa->each(function ($d) use (&$totals) {
                $totals['lahir_hidup_L'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_hidup_L : 0;
                $totals['lahir_mati_L'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_mati_L : 0;
                $totals['lahir_hidup_P'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_hidup_P : 0;
                $totals['lahir_mati_P'] += $d->filterKelahiran(Session::get('year')) ?  $d->filterKelahiran(Session::get('year'))->lahir_mati_P : 0;
            });

            $mappedData = $desa->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->UnitKerja->kecamatan,
                    'desa_name' => $desa->nama,
                    'lahir_hidup_L' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L : 'No Data',
                    'lahir_mati_L' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_L : '0',
                    'lahir_L' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L : '0',
                    'lahir_hidup_P' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P : 'No Data',
                    'lahir_mati_P' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_P : '0',
                    'lahir_P' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_P + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P : '0',
                    'lahir_hidup_LP' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P : '0',
                    'lahir_mati_LP' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_L + $desa->filterKelahiran(Session::get('year'))->lahir_mati_P : '0',
                    'lahir_hidup_mati_LP' => $desa->filterKelahiran(Session::get('year')) ?  $desa->filterKelahiran(Session::get('year'))->lahir_mati_L + $desa->filterKelahiran(Session::get('year'))->lahir_mati_P + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L + $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P: '0',
                ];
            })->toArray();

            $mappedData[] = [
                'desa_name' => 'TOTAL',
                'kecamatan_name' => '',
                'lahir_hidup_L' => $totals['lahir_hidup_L'],
                'lahir_mati_L' => $totals['lahir_mati_L'],
                'lahir_L' => $totals['lahir_hidup_L'] + $totals['lahir_mati_L'],
                'lahir_hidup_P' => $totals['lahir_hidup_P'],
                'lahir_mati_P' => $totals['lahir_mati_P'],
                'lahir_P' => $totals['lahir_hidup_P'] + $totals['lahir_mati_P'],
                'lahir_hidup_LP' => $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
                'lahir_mati_LP' => $totals['lahir_mati_L'] + $totals['lahir_mati_P'],
                'lahir_hidup_mati_LP' => $totals['lahir_mati_L'] + $totals['lahir_mati_P'] + $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
               
            ];

            return collect($mappedData);

        } else {
            $unitKerja = UnitKerja::all();

            $totals = [
                'lahir_hidup_L' => 0,
                'lahir_mati_L' => 0,
                'lahir_hidup_P' => 0,
                'lahir_mati_P' => 0,
            ];

            $unitKerja->each(function ($d) use (&$totals){
                $totals['lahir_hidup_L'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L');
                $totals['lahir_hidup_P'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P');
                $totals['lahir_mati_L'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_L');
                $totals['lahir_mati_P'] += $d->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_P');
            });
            $mappedData = $unitKerja->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->kecamatan,
                    'desa_name' => $desa->nama,
                    'lahir_hidup_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'),
                    'lahir_mati_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_L'),
                    'lahir_L' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L'),
                    'lahir_hidup_P' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                    'lahir_mati_P' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_P'),
                    'lahir_P' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                    'lahir_hidup_LP' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                    'lahir_mati_LP' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_P'),
                    'lahir_hidup_mati_LP' => $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_mati_P') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_L') + $desa->admin_total(Session::get('year'), 'filterKelahiran', 'lahir_hidup_P'),
                  
                ];  
            })->toArray();

            $mappedData[] = [
                'desa_name' => 'TOTAL',
                'kecamatan_name' => '',
                'lahir_hidup_L' => $totals['lahir_hidup_L'],
                'lahir_mati_L' => $totals['lahir_mati_L'],
                'lahir_L' => $totals['lahir_hidup_L'] + $totals['lahir_mati_L'],
                'lahir_hidup_P' => $totals['lahir_hidup_P'],
                'lahir_mati_P' => $totals['lahir_mati_P'],
                'lahir_P' => $totals['lahir_hidup_P'] + $totals['lahir_mati_P'],
                'lahir_hidup_LP' => $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
                'lahir_mati_LP' => $totals['lahir_mati_L'] + $totals['lahir_mati_P'],
                'lahir_hidup_mati_LP' => $totals['lahir_mati_L'] + $totals['lahir_mati_P'] + $totals['lahir_hidup_L'] + $totals['lahir_hidup_P'],
               
            ];
            $mappedData[] = [
                'desa_name' => 'ANGKA LAHIR MATI PER 1.000 KELAHIRAN (DILAPORKAN)',
                'kecamatan_name' => '',
                'lahir_hidup_L' => '',
                'lahir_mati_L' => $totals['lahir_mati_L'] > 0?number_format(($totals['lahir_hidup_L']/$totals['lahir_mati_L']) * 1000, 2):0,
                'lahir_L' => '',
                'lahir_hidup_P' => '',
                'lahir_mati_P' => $totals['lahir_mati_P'] > 0?number_format(($totals['lahir_hidup_P']/$totals['lahir_mati_P']) * 1000, 2):0,
                'lahir_P' => '',
                'lahir_hidup_LP' => '',
                'lahir_mati_LP' => $totals['lahir_mati_P'] + $totals['lahir_mati_L'] > 0?number_format((($totals['lahir_hidup_P'] + $totals['lahir_mati_P'])/($totals['lahir_mati_L'] + $totals['lahir_hidup_L'])) * 1000, 2):0,
            ];
            // Append Totals Row
            return collect($mappedData);
        }
    }
    public function headings(): array
    {
        return [
            ['JUMLAH KELAHIRAN MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS'],  // Main Title
            ['KABUPATEN/KOTA KUTAI TIMUR'],  // Main Title
            ['TAHUN '.Session::get('year')],  // Main Title
            ['Kecamatan', 'Puskesmas', 'Jumlah Kelahiran', '', '', '', '', '', '', '', ''],
            ['', '', 'Laki-laki', '', '', 'Perempuan', '', '', 'Laki-laki + Perempuan', '', ''],
            ['', '', 'Hidup', 'Mati', 'Hidup + Mati', 'Hidup', 'Mati', 'Hidup + Mati', 'Hidup', 'Mati', 'Hidup + Mati']
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
            $sheet->mergeCells('A4:A6');
            $sheet->mergeCells('B4:B6');
            $sheet->mergeCells('C4:K4');
            $sheet->mergeCells('C5:E5');
            $sheet->mergeCells('F5:H5');
            $sheet->mergeCells('I5:K5');
        

            // Apply styles
            $sheet->getStyle('A1:K6')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A" . ($lastRow - 1) . ":B" . ($lastRow - 1));
            $sheet->mergeCells("A{$lastRow}:C{$lastRow}");

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
            $sheet->getStyle("A" . ($lastRow - 1) . ":K" . ($lastRow - 1))->applyFromArray([
                'borders' => [
                    'top' => [
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
            $sheet->getStyle('A4:K6')->applyFromArray([
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

            // Set column widths for readability
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getRowDimension(4)->setRowHeight(30);
            $sheet->getRowDimension(5)->setRowHeight(30);
            $sheet->getRowDimension(6)->setRowHeight(15);
            // Continue adjusting column widths as needed
        },
    ];
}

}
