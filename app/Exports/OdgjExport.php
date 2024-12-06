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

class OdgjExport implements FromView, WithEvents
{
    public function view(): View
    {
        // Pass data to the Blade view
            // }
            $unit_kerja = UnitKerja::all();
            $total_sasaran = 0;
            $total_skizo_0 = 0;
            $total_skizo_15 = 0;
            $total_skizo_60 = 0;
            $total_psiko_0 = 0;
            $total_psiko_15 = 0;
            $total_psiko_60 = 0;
            $total_jiwa_L = 0;
            $total_jiwa_P = 0;
            $totalvita = 0;
            $totalibubersalin = 0;
            $indukOpd = IndukOpd::pluck('nama', 'id');
            // $desa = Desa::first();
            // dd($desa->filterDesa(null));
            if(Auth::user()->roles->first()->name !== "Admin"){
                $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
                foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
                    if($desa->filterOdgj(Session::get('year'))){
                        $total_sasaran += $desa->filterOdgj(Session::get('year'))->sasaran;
                        $total_skizo_0 += $desa->filterOdgj(Session::get('year'))->skizo_0;
                        $total_skizo_15 += $desa->filterOdgj(Session::get('year'))->skizo_15;
                        $total_skizo_60 += $desa->filterOdgj(Session::get('year'))->skizo_60;
                        $total_psiko_0 += $desa->filterOdgj(Session::get('year'))->psiko_0;
                        $total_psiko_15 += $desa->filterOdgj(Session::get('year'))->psiko_15;
                        $total_psiko_60 += $desa->filterOdgj(Session::get('year'))->psiko_60;
                        $total_jiwa_L += $desa->filterKunjungan(Session::get('year'))->jiwa_L;
                        $total_jiwa_P += $desa->filterKunjungan(Session::get('year'))->jiwa_P;
        
                    }
                }
            } else{
                foreach($unit_kerja as $desa){
                    $total_sasaran += $desa->sasaran_odgj(Session::get('year'));
                    $total_skizo_0 += $desa->skizo_0(Session::get('year'));
                    $total_skizo_15 += $desa->skizo_15(Session::get('year'));
                    $total_skizo_60 += $desa->skizo_60(Session::get('year'));
                    $total_psiko_0 += $desa->psiko_0(Session::get('year'));
                    $total_psiko_15 += $desa->psiko_15(Session::get('year'));
                    $total_psiko_60 += $desa->psiko_60(Session::get('year'));
                    $total_jiwa_L += $desa->jiwa_L(Session::get('year'));
                    $total_jiwa_P += $desa->jiwa_P(Session::get('year'));
                    $totalvita += $desa->vita(Session::get('year'));
                    $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
                }
            }
        
            // dd(UnitKerja::first()->jumlah_k1);
        
            $data=[
                'induk_opd_arr' => $indukOpd,
                'unit_kerja' =>  $unit_kerja,
                'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
                'total_sasaran' => $total_sasaran,
                'total_skizo_0' => $total_skizo_0,
                'total_skizo_15' => $total_skizo_15,
                'total_skizo_60' => $total_skizo_60,
                'total_psiko_0' => $total_psiko_0,
                'total_psiko_15' => $total_psiko_15,
                'total_psiko_60' => $total_psiko_60,
                'total_jiwa_L' => $total_jiwa_L,
                'total_jiwa_P' => $total_jiwa_P,
                // 'jabatan' => Jabatan::get(),
                // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
                // 'unit_organisasi' => UnitOrganisasi::get()
            ];
        
    
    

        return view('export.odgj')->with($data);
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $sheet = $event->sheet;

            // Merge the main title across the entire row
            
            $sheet->mergeCells('A1:N1'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A2:N2'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)
            $sheet->mergeCells('A3:N3'); // Shifted from 'A1:W1' to 'A3:W3' (two extra rows)

            // Merge main header sections
        

            // Apply styles
            $sheet->getStyle('A1:N6')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A" . ($lastRow) . ":B" . ($lastRow));

            // Define the full range dynamically
            $range = 'A4:N' . $lastRow;
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
            $sheet->getStyle("A" . ($lastRow) . ":N" . ($lastRow))->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle("A{$lastRow}:N{$lastRow}")->applyFromArray([
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A4:N6')->applyFromArray([
               'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Black color
                    ],
                ],
            ]);
            $sheet->getStyle('A5:N6')->applyFromArray([
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
            $sheet->getStyle('A6:N6')->applyFromArray([
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
            $sheet->getStyle('A4:N4')->applyFromArray([
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