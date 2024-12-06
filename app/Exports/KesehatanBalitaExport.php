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

class KesehatanBalitaExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
                'balita_0_59' => 0,
                'balita_12_59' => 0,
                'balita_kia' => 0,
                'balita_dipantau' => 0,
                'balita_sdidtk' => 0,
                'balita_mtbs' => 0,
            ];

            $desa->each(function ($d) use (&$totals) {
                $totals['balita_0_59'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_0_59 : 0;
                $totals['balita_12_59'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_12_59 : 0;
                $totals['balita_kia'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_kia : 0;
                $totals['balita_dipantau'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_dipantau : 0;
                $totals['balita_sdidtk'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_sdidtk : 0;
                $totals['balita_mtbs'] += $d->filterKesehatanBalita(Session::get('year')) ?  $d->filterKesehatanBalita(Session::get('year'))->balita_mtbs : 0;
            });

            $mappedData = $desa->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->UnitKerja->kecamatan,
                    'desa_name' => $desa->nama,
                    'balita_0_59' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59 : 'No Data',
                    'balita_12_59' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_12_59 : '0',
                    'balita_kia' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_kia : '0',
                    'persen_balita_kia' => $desa->filterKesehatanBalita(Session::get('year')) ? $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0 ? number_format(($desa->filterKesehatanBalita(Session::get('year'))->balita_kia / $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59) * 100, 2) : 0 : '0',
                    'balita_dipantau' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_dipantau : '0',
                    'persen_balita_dipantau' => $desa->filterKesehatanBalita(Session::get('year')) ? $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0 ? number_format(($desa->filterKesehatanBalita(Session::get('year'))->balita_dipantau / $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59) * 100, 2) : 0 : '0',
                    'balita_sdidtk' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_sdidtk : '0',
                    'persen_balita_sdidtk' => $desa->filterKesehatanBalita(Session::get('year')) ? $desa->filterKesehatanBalita(Session::get('year'))->balita_12_59 > 0 ? number_format(($desa->filterKesehatanBalita(Session::get('year'))->balita_sdidtk / $desa->filterKesehatanBalita(Session::get('year'))->balita_12_59) * 100, 2) : 0 : '0',
                    'balita_mtbs' => $desa->filterKesehatanBalita(Session::get('year')) ?  $desa->filterKesehatanBalita(Session::get('year'))->balita_mtbs : '0',
                    'persen_balita_mtbs' => $desa->filterKesehatanBalita(Session::get('year')) ? $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59 > 0 ? number_format(($desa->filterKesehatanBalita(Session::get('year'))->balita_mtbs / $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59) * 100, 2) : 0 : '0',
                ];
            })->toArray();

            $mappedData[] = [
                'desa_name' => 'TOTAL',
                'kecamatan_name' => '',
                'balita_0_59' => $totals['balita_0_59'],
                'balita_12_59' => $totals['balita_12_59'],
                'balita_kia' => $totals['balita_kia'],
                'persen_balita_kia' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_kia'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
                'balita_dipantau' => $totals['balita_dipantau'],
                'persen_balita_dipantau' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_dipantau'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
                'balita_sdidtk' => $totals['balita_sdidtk'],
                'persen_balita_sdidtk' => $totals['balita_12_59'] > 0 ? number_format(($totals['balita_sdidtk'] / $totals['balita_12_59']) * 100, 2).'%' : 0,
                'balita_mtbs' => $totals['balita_mtbs'],
                'persen_balita_mtbs' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_mtbs'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
               
            ];

            return collect($mappedData);

        } else {
            $unitKerja = UnitKerja::all();

            $totals = [
                'balita_0_59' => 0,
                'balita_12_59' => 0,
                'balita_kia' => 0,
                'balita_dipantau' => 0,
                'balita_sdidtk' => 0,
                'balita_mtbs' => 0,
            ];

            $unitKerja->each(function ($d) use (&$totals){
                $totals['balita_0_59'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59');
                $totals['balita_12_59'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_12_59');
                $totals['balita_kia'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_kia');
                $totals['balita_dipantau'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_dipantau');
                $totals['balita_sdidtk'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_sdidtk');
                $totals['balita_mtbs'] += $d->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_mtbs');
            });
            $mappedData = $unitKerja->map(function($desa) {
                return [
                    'kecamatan_name' => $desa->kecamatan,
                    'desa_name' => $desa->nama,
                    'balita_0_59' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59'),
                    'balita_12_59' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_12_59'),
                    'balita_kia' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_kia'),
                    'persen_balita_kia' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_kia') / $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59')) * 100, 2) : 0,
                    'balita_dipantau' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_dipantau'),
                    'persen_balita_dipantau' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_dipantau') / $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59')) * 100, 2) : 0,
                    'balita_sdidtk' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_sdidtk'),
                    'persen_balita_sdidtk' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_12_59') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_sdidtk') / $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_12_59')) * 100, 2) : 0,
                    'balita_mtbs' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_mtbs'),
                    'persen_balita_mtbs' => $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59') > 0 ? number_format(($desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_mtbs') / $desa->admin_total(Session::get('year'), 'filterKesehatanBalita', 'balita_0_59')) * 100, 2) : 0,
                  
                ];  
            })->toArray();

            $mappedData[] = [
                'desa_name' => 'TOTAL',
                'kecamatan_name' => '',
                'balita_0_59' => $totals['balita_0_59'],
                'balita_12_59' => $totals['balita_12_59'],
                'balita_kia' => $totals['balita_kia'],
                'persen_balita_kia' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_kia'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
                'balita_dipantau' => $totals['balita_dipantau'],
                'persen_balita_dipantau' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_dipantau'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
                'balita_sdidtk' => $totals['balita_sdidtk'],
                'persen_balita_sdidtk' => $totals['balita_12_59'] > 0 ? number_format(($totals['balita_sdidtk'] / $totals['balita_12_59']) * 100, 2).'%' : 0,
                'balita_mtbs' => $totals['balita_mtbs'],
                'persen_balita_mtbs' => $totals['balita_0_59'] > 0 ? number_format(($totals['balita_mtbs'] / $totals['balita_0_59']) * 100, 2).'%' : 0,
               
            ];
            // Append Totals Row
            return collect($mappedData);
        }
    }
    public function headings(): array
    {
        return [
            ['CAKUPAN PELAYANAN KESEHATAN BALITA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS'],  // Main Title
            ['KABUPATEN/KOTA KUTAI TIMUR'],  // Main Title
            ['TAHUN '.Session::get('year')],  // Main Title
            ['Kecamatan', 'Puskesmas', 'SASARAN BALITA (USIA 0-59 BULAN)', 'SASARAN ANAK BALITA (USIA 12-59 BULAN)', 'Balita Memiliki Buku KIA', '', 'Balita Dipantau Pertumbuhan dan Perkembangan', '', 'Balita Dilayani SDIDTK', '', 'Balita Dilayani MTBS', ''],
            ['', '', '', '', 'Jumlah', '%', 'Jumlah', '%', 'jumlah', '%', 'Jumlah', '%'],
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
            
            $sheet->mergeCells('A1:L1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:L2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:L3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // Merge main header sections
            $sheet->mergeCells('A4:A5'); //Kecamatan
            $sheet->mergeCells('B4:B5'); //Desa
            $sheet->mergeCells('C4:C5'); //0_59 bulan
            $sheet->mergeCells('D4:D5'); //12_59 bulan
            $sheet->mergeCells('E4:F4'); //kia
            $sheet->mergeCells('G4:H4'); //dipantau
            $sheet->mergeCells('I4:J4'); //sdidtk
            $sheet->mergeCells('K4:L4'); //mtbs
        

            // Apply styles
            $sheet->getStyle('A1:L5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A{$lastRow}:B{$lastRow}");

            // Define the full range dynamically
            $range = 'A4:L' . $lastRow;
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
            $sheet->getStyle("A{$lastRow}:L{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:L5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:L5')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:L4')->applyFromArray([
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
            $sheet->getColumnDimension('C')->setWidth(60);
            $sheet->getColumnDimension('D')->setWidth(60);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
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
