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

class PesertaDidikExport implements FromView, WithEvents
{
    public function view(): View
    {
        // Pass data to the Blade view
        $unit_kerja = UnitKerja::all();
    $total_kelas_1 = 0;
    $total_pelayanan_kelas_1 = 0;
    $total_kelas_7 = 0;
    $total_pelayanan_kelas_7 = 0;
    $total_kelas_10 = 0;
    $total_pelayanan_kelas_10 = 0;
    $total_usia_dasar = 0;
    $total_pelayanan_usia_dasar = 0;
    $total_sd = 0;
    $total_pelayanan_sd = 0;
    $total_smp = 0;
    $total_pelayanan_smp = 0;
    $total_sma = 0;
    $total_pelayanan_sma = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterPesertaDidik(Session::get('year'))){
                $total_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1;
            $total_pelayanan_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1;
            $total_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7;
            $total_pelayanan_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7;
            $total_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10;
            $total_pelayanan_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10;
            $total_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar;
            $total_pelayanan_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar;
            $total_sd += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sd;
            $total_pelayanan_sd += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sd;
            $total_smp += $desa->filterPesertaDidik(Session::get('year'))->jumlah_smp;
            $total_pelayanan_smp += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_smp;
            $total_sma += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sma;
            $total_pelayanan_sma += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sma;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_kelas_1 += $desa->jumlah_kelas_1(Session::get('year'));
            $total_pelayanan_kelas_1 += $desa->pelayanan_kelas_1(Session::get('year'));
            $total_kelas_7 += $desa->jumlah_kelas_7(Session::get('year'));
            $total_pelayanan_kelas_7 += $desa->pelayanan_kelas_7(Session::get('year'));
            $total_kelas_10 +=$desa->jumlah_kelas_10(Session::get('year'));
            $total_pelayanan_kelas_10 += $desa->pelayanan_kelas_10(Session::get('year'));
            $total_usia_dasar += $desa->jumlah_usia_dasar(Session::get('year'));
            $total_pelayanan_usia_dasar += $desa->pelayanan_usia_dasar(Session::get('year'));
            $total_sd += $desa->jumlah_sd(Session::get('year'));
            $total_pelayanan_sd += $desa->pelayanan_sd(Session::get('year'));
            $total_smp += $desa->jumlah_smp(Session::get('year'));
            $total_pelayanan_smp += $desa->pelayanan_smp(Session::get('year'));
            $total_sma += $desa->jumlah_sma(Session::get('year'));
            $total_pelayanan_sma += $desa->pelayanan_sma(Session::get('year'));
        }
    }
    $data=[
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_kelas_1' => $total_kelas_1,
        'total_pelayanan_kelas_1' => $total_pelayanan_kelas_1,
        'total_kelas_7' => $total_kelas_7,
        'total_pelayanan_kelas_7' => $total_pelayanan_kelas_7,
        'total_kelas_10' => $total_kelas_10,
        'total_pelayanan_kelas_10' => $total_pelayanan_kelas_10,
        'total_usia_dasar' => $total_usia_dasar,
        'total_pelayanan_usia_dasar' => $total_pelayanan_usia_dasar,
        'total_sd' => $total_sd,
        'total_pelayanan_sd' => $total_pelayanan_sd,
        'total_smp' => $total_smp,
        'total_pelayanan_smp' => $total_pelayanan_smp,
        'total_sma' => $total_sma,
        'total_pelayanan_sma' => $total_pelayanan_sma,
        'total_ibu_bersalin' => $totalibubersalin,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

        return view('export.peserta_didik')->with($data);
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
        

            // Apply styles
            $sheet->getStyle('A1:W5')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
               
            ]);
            $lastRow = $sheet->getHighestRow();
            $sheet->mergeCells("A" . ($lastRow) . ":B" . ($lastRow));

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
            $sheet->getStyle("A" . ($lastRow) . ":W" . ($lastRow))->applyFromArray([
                'borders' => [
                    'top' => [
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
            $sheet->getStyle('A4:W5')->applyFromArray([
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