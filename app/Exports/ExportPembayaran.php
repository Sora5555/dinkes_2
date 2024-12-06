<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportPembayaran implements FromView
{
    protected $date1;
    protected $date2;
    protected $wilayah;
    protected $sektor;
    protected $klasifikasi;
    protected $tipe;

    function __construct() {
       
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $datas = User::all();


        return view("exportPembayaran", [
            'Pembayaran' => $datas,
        ]);
    }

    // public function collection()
    // {
    //     // return view("exportPembayaran", [
    //     //     'Pembayaran' => Tagihan::where('status', 2)->
    //     //     join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')->
    //     //     select('tagihans.tanggal','pelanggans.id','pelanggans.name','tagihans.jumlah_pembayaran','tagihans.status', 'tagihans.denda_harian', 'tagihans.denda_admin', "tagihans.id", 'tagihans.meter_penggunaan', 'tagihans.tanggal_penerimaan', 'tagihans.tanggal_akhir', 'upt_daerahs.nama_daerah', 'upt_daerahs.id')
    //     //     ->whereBetween('tagihans.tanggal',[$this->date1, $this->date2])
    //     //     ->where("upt_daerahs.id", $this->wilayah)
    //     //     ->get(),
    //     // ]);
    // }
}
