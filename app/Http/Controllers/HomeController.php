<?php

namespace App\Http\Controllers;

use Session;
use Maatwebsite\Excel\Excel as ExcelExcel;
use App\Exports\ExportPembayaran;
use App\Models\IndikatorOpd;
use App\Models\IndukOpd;
use App\Models\IndikatorPemerintah;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Target;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanPemasangan;
use Illuminate\Support\Facades\DB;
use App\Models\PembayaranPemasangan;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        return view('index');
    }
    public function homepage(){
        $datas =  Target::join('upt_daerahs', 'targets.id_daerah', '=', 'upt_daerahs.id')->select('targets.id', 'targets.target', 'targets.tahun', 'targets.realisasi', 'targets.created_at', 'upt_daerahs.nama_daerah')->get()->pluck('target', "nama_daerah");
        $datas2 =  Target::join('upt_daerahs', 'targets.id_daerah', '=', 'upt_daerahs.id')->select('targets.id', 'targets.target', 'targets.tahun', 'targets.realisasi', 'targets.created_at', 'upt_daerahs.nama_daerah')->get()->pluck('realisasi', "nama_daerah");
        $datasTotal = Target::sum('target');
        $chartTargets = $datas->values();
        $chartLabels = $datas->keys();
        $chartRealisasis = $datas2->values();
        $datasDivide = $datasTotal / 12;
        $divide = array_fill(1, 12, $datasDivide);
        $values = array_values($divide);
         $daftar_realisasi = DB::table("tagihans")->select(DB::raw("sum(jumlah_pembayaran + denda_harian + denda_admin) as sum"), DB::raw("DATE_FORMAT(created_at, '%Y-%m') as date"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "asc")->where(DB::raw("status = 2"))->get();
        $chartData = $daftar_realisasi->values();
        return view('home-page', compact('chartTargets', 'chartLabels', 'chartRealisasis', 'values', "chartData"));
    }
    public function filterTahun($id){
        try {
            //code...

            Session::put('year', $id);
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'fail',
            ]);
        }
    }
}
