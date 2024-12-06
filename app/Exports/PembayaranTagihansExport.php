<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class PembayaranTagihansExport implements FromView,ShouldAutoSize,WithStyles
{   
    protected $row_count = 2;

    public function styles(Worksheet $sheet)
    {   
       
        $sheet->getStyle('A1:H'.$this->row_count)->applyFromArray([
            'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
        ]);

    }

    public function view(): View
    {   
        $upt_id = request()->upt_id;
        $id_pelanggan = request()->id_pelanggan;
        if($id_pelanggan == 0){
            if($upt_id == 0){
                $pelanggans = Pelanggan::with('daerah')->orderBy("daerah_id")->get();
            } else {
                $pelanggans = Pelanggan::with('daerah')->orderBy("daerah_id")->where('daerah_id',$upt_id)->get();
            }
        } else {
            $pelanggans = Pelanggan::with('daerah')->orderBy("daerah_id")->where('id',$id_pelanggan)->get();
        }
        $this->row_count += count($pelanggans);
        return view('pelunasan.excel.template',compact('pelanggans'),['tahun'=>request()->tahun,'bulan'=>request()->bulan]);
    }
}
