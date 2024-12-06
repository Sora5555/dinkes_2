<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Throwable;

class TagihanImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use SkipsErrors, Importable;

    protected $error = [];
    public function model(Array $row)
    {
        $date = str_replace("'", "", $row['masa_pajak_bulantahun']);
        $masa = Carbon::parse($date);
        $number = rand(0,1000);
        $txt = date("Ymdhis").''.$number;
        $id = $txt.$number;
        try {
            //code...
            //code...
            return Tagihan::create([
                "id_tagihan" => $id,
                "pelanggan_id" => Pelanggan::where('name', 'like','%'. $row['wajib_pajak'].'%')->first()->id,
                'tanggal' => $masa->format("Y-m-d"),
                'meter_penggunaan_awal' => 0,
                'meter_penggunaan' => $row['npa'],
                'jumlah_pembayaran' => $row['pokok_ap'],
                'tarif' => 0,
                'denda_harian' => 0,
                'denda_admin' => 0,
                'file_name' => null,
                'file_path' => null,
                'pesan' => null,
                'status' => 2

            ]);
        } catch (\Throwable $th) {
            //throw $th;
            array_push( $this->errors , [$th->getMessage(), $row['wajib_pajak']]);
        }
    }    
    public function onError(Throwable $e)
    {
    }
}
