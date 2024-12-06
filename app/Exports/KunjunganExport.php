<?php

namespace App\Exports;

use App\Models\Desa;
use App\Models\IndukOpd;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\PesertaDidik;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Session;

class KunjunganExport implements FromView, WithEvents
{
    public function view(): View
    {
        // Pass data to the Blade view
            // }
    $unit_kerja = UnitKerja::all();
    $total = 0;
    $totalk1 = 0;
    $totalk4 = 0;
    $totalk6 = 0;
    $totalfasyankes = 0;
    $totalkf1 = 0;
    $totalkf_lengkap = 0;
    $totalvita = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            // $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
            // $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
            // $totalk4 += $desa->filterDesa(Session::get('year'))->k4;
            // $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
            // $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
            // $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
            // $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
            // $totalvita += $desa->filterDesa(Session::get('year'))->vita;
            // $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
        }
    } else{
        foreach($unit_kerja as $desa){
            $total += $desa->jumlah_ibu_hamil(Session::get('year'));
            $totalk1 += $desa->k1(Session::get('year'));
            $totalk4 += $desa->k4(Session::get('year'));
            $totalk6 += $desa->k6(Session::get('year'));
            $totalfasyankes += $desa->fasyankes(Session::get('year'));
            $totalkf1 += $desa->kf1(Session::get('year'));
            $totalkf_lengkap += $desa->kf_lengkap(Session::get('year'));
            $totalvita += $desa->vita(Session::get('year'));
            $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_ibu_hamil' => $total,
        'total_k1' => $totalk1,
        'total_k4' => $totalk4,
        'total_k6' => $totalk6,
        'total_fasyankes' => $totalfasyankes,
        'total_kf1' => $totalkf1,
        'total_kf_lengkap' => $totalkf_lengkap,
        'total_vita' => $totalvita,
        'total_ibu_bersalin' => $totalibubersalin,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];
    
    

        return view('export.kunjungan')->with($data);
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
        

            // Apply styles
            $sheet->getStyle('A1:K6')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A" . ($lastRow) . ":B" . ($lastRow));

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
            $sheet->getStyle("A" . ($lastRow) . ":K" . ($lastRow))->applyFromArray([
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
            $sheet->getStyle('A5:K6')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A6:K6')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                    'top' => [
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
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(30);
            $sheet->getColumnDimension('I')->setWidth(30);
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(30);
            $sheet->getColumnDimension('L')->setWidth(30);
            $sheet->getColumnDimension('M')->setWidth(30);
            $sheet->getColumnDimension('N')->setWidth(30);
            $sheet->getColumnDimension('O')->setWidth(30);
            $sheet->getColumnDimension('P')->setWidth(30);
            $sheet->getColumnDimension('Q')->setWidth(30);
            $sheet->getColumnDimension('R')->setWidth(30);
            $sheet->getColumnDimension('S')->setWidth(30);
            $sheet->getColumnDimension('T')->setWidth(30);
            $sheet->getColumnDimension('U')->setWidth(30);
            $sheet->getColumnDimension('V')->setWidth(30);
            $sheet->getColumnDimension('W')->setWidth(30);
            $sheet->getRowDimension(4)->setRowHeight(30);
            $sheet->getRowDimension(5)->setRowHeight(30);
            $sheet->getRowDimension(6)->setRowHeight(15);
            // Continue adjusting column widths as needed
        },
    ];
}
}