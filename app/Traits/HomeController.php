<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->roles->first()->name == "Admin"){
            if($request->years){
                $pelanggan = User::whereYear('created_at', '=', $request->years)->count();
                $tagihan = Tagihan::whereYear('created_at', '=', $request->years)->count();
                $pembayaran = Tagihan::whereYear('created_at', '=', $request->years)->where('status', 2)->count();
                $pembayaran_telat = Tagihan::whereYear('created_at', '=', $request->years)->whereIn('status', [0, 1])->count();
            } else {
                $pelanggan = User::count();
                $tagihan = Tagihan::count();
                $pembayaran = Tagihan::where('status', 2)->count();
                $pembayaran_telat = Tagihan::whereIn('status', [0, 1])->count();
            }
        } else {
            if($request->years){
            $pelanggan = User::whereYear('created_at', '=', $request->years)->where('daerah_id', Auth::user()->daerah_id)->count();
            $tagihan = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->whereYear('tagihans.created_at', '=', $request->years)->where("pelanggans.daerah_id", Auth::user()->daerah_id)->count();
            $pembayaran = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->whereYear('tagihans.created_at', '=', $request->years)->where("pelanggans.daerah_id", Auth::user()->daerah_id)->where('status', 2)->count();
            $pembayaran_telat = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->whereYear('tagihans.created_at', '=', $request->years)->where("pelanggans.daerah_id", Auth::user()->daerah_id)->whereIn('status', [0, 1])->count();
            } else {
                $pelanggan = User::where('daerah_id', Auth::user()->daerah_id)->count();
            $tagihan = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->where("pelanggans.daerah_id", Auth::user()->daerah_id)->count();
            $pembayaran = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->where("pelanggans.daerah_id", Auth::user()->daerah_id)->where('status', 2)->count();
            $pembayaran_telat = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->where("pelanggans.daerah_id", Auth::user()->daerah_id)->whereIn('status', [0, 1])->count();
            }
        }
        $datas1 =  Target::join('upt_daerahs', 'targets.id_daerah', '=', 'upt_daerahs.id')->select('targets.id', 'targets.target', 'targets.tahun', 'targets.realisasi', 'targets.created_at', 'upt_daerahs.nama_daerah')->get()->pluck('target', "nama_daerah");
        $datas2 =  Target::join('upt_daerahs', 'targets.id_daerah', '=', 'upt_daerahs.id')->select('targets.id', 'targets.target', 'targets.tahun', 'targets.realisasi', 'targets.created_at', 'upt_daerahs.nama_daerah')->get()->pluck('realisasi', "nama_daerah");
        $datasTotal = Target::sum('target');
        $chartTargets = $datas1->values();
        $chartLabels2 = $datas1->keys();
        $chartRealisasis = $datas2->values();
        $datasDivide = $datasTotal / 12;
        $divide = array_fill(1, 12, $datasDivide);
        $values = array_values($divide);
        $daftar_realisasi = DB::table("tagihans")->select(DB::raw("sum(jumlah_pembayaran) as sum"), DB::raw("DATE_FORMAT(tanggal_penerimaan, '%Y-%m') as date"), 'status')->where('status', '=', 2)->groupBy(DB::raw("DATE_FORMAT(tanggal_penerimaan, '%Y-%m')"), 'status')->orderBy(DB::raw("DATE_FORMAT(tanggal_penerimaan, '%Y-%m')"), "asc")->get();
        $chartData2 = $daftar_realisasi->values();
        if($request->years){
            $jumlah_pembayaran = Tagihan::whereYear('created_at', '=', $request->years)->sum('jumlah_pembayaran');
            $jumlah_hutang = Tagihan::whereYear('created_at', '=', $request->years)->where([['status', '=', 1]])->orWhere('status', 3)->sum('jumlah_pembayaran');
        } else{
            $jumlah_pembayaran = Tagihan::sum('jumlah_pembayaran');
            $jumlah_hutang = Tagihan::where([['status', '=', 1]])->orWhere('status', 3)->sum('jumlah_pembayaran');
        }
        // dd($jumlah_hutang, Tagihan::where([['status', 1]])->get());
        $daftar_pembayaran = DB::table("tagihans")->select(DB::raw("sum(jumlah_pembayaran) as sum"), DB::raw("DATE_FORMAT(created_at, '%M-%Y') as date"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("DATE_FORMAT(created_at, '%M-%Y')"))->orderBy(DB::raw("DATE_FORMAT(created_at, '%M-%Y')"), "asc")->pluck("sum", "date");
        $chartLabels = $daftar_pembayaran->keys();
        $chartData = $daftar_pembayaran->values();
        // $daftar_hutang = DB::table("tagihans")->select(DB::raw("sum(jumlah_pembayaran) as sum"), DB::raw("DATE_FORMAT(created_at, %M-%Y) as date"))->whereNotIn()->whereYear("created_at", date("Y"))->groupBy(DB::raw("DATE_FORMAT(created_at, '$%M-%Y')"))->orderBy("created_at", "asc")->pluck("sum", "date");
        $jumlah_pembayaran_pemasangan = TagihanPemasangan::sum('jumlah_pembayaran');
        $jumlah_hutang_pemasangan = 0;

        $tagihan_pemasangan = TagihanPemasangan::all();

        $datas = Tagihan::doesntHave('pembayaran')->orderBy('created_at', 'DESC')->get();

        // $pembayaran_telat = Tagihan::whereIn('status', [0, 1])->count();

        // dd(Tagihan::whereIn('status', [0, 1])->get());

        // foreach($datas as $d){
        //     if($d->tanggal->format('Y-m-d') < date('Y-m-d')){
        //         $pembayaran_telat += 1;
        //     }
        // }
        $thisMonthBill = 0;
        $thisMonthVolume = 0;

        foreach ($tagihan_pemasangan as $tp) {
            $jumlah = $tp->pembayaran->sum('jumlah_pembayaran');

            if($jumlah < $tp->jumlah_pembayaran){
                $jumlah_hutang_pemasangan += $tp->jumlah_pembayaran - $jumlah;
            }else if($jumlah >= $tp->jumlah_pembayaran){
                // return "Sudah Lunas";
            }else{
                $jumlah_hutang_pemasangan += $tp->jumlah_pembayaran - $jumlah;
            }
        }

        $penggunaan = 0;
        $total_bayar = 0;
        $countLunas = 0;
        $countBayar = 0;
        $thisMonthBill = 0;
        $thisMonthVolume = 0;
        $countBayar = 0;
        $countLunas = 0;
        $totalRealisasi = Target::sum("realisasi");
        $user = Auth::user();
        if($user->roles->first()->name == "Pihak Wajib Pajak"){
            $user_id = Auth::user()->pelanggan;
            // dd($user_id,  DB::table('tagihans')->select(DB::raw("sum(jumlah_pembayaran + denda_harian + denda_admin) as sum"))->where('pelanggan_id', '=', 443)->where('status', "=", 2)->first()->sum);
            foreach($user_id as $user){
                $total_bayar += DB::table('tagihans')->select(DB::raw("sum(jumlah_pembayaran + denda_harian + denda_admin) as sum"))->where('pelanggan_id', '=', $user->id)->where('status', "=", 2)->first()->sum;
                $penggunaan += DB::table('tagihans')->select(DB::raw("sum(meter_penggunaan) as sum"))->where('pelanggan_id', '=', $user->id)->first()->sum;
                $thisMonthBill += DB::table('tagihans')->select(DB::raw("sum(jumlah_pembayaran + denda_harian + denda_admin) as sum"))->whereMonth("created_at", '=', Carbon::now()->format("m"))->where('pelanggan_id', '=', $user->id)->first()->sum;
                $thisMonthVolume += Tagihan::whereMonth('created_at', '=', Carbon::now())->where('pelanggan_id', '=', $user->id)->sum("meter_penggunaan");
                $countLunas += count(Tagihan::where("pelanggan_id", '=', $user->id)->where("status", '=', 2)->get());
                $countBayar += count(Tagihan::where(function($query) use($user){
                    $query->where('pelanggan_id', '=', $user->id)
                    ->where('status', '=', 1);
                })
                ->orWhere(function($query) use($user){
                    $query->where('pelanggan_id', '=', $user->id)
                    ->where('status', '=', 3);
                })
                ->orWhere(function($query) use($user){
                    $query->where('pelanggan_id', '=', $user->id)
                    ->where('status', '=', 5);
                })
                ->orWhere(function($query) use($user){
                    $query->where('pelanggan_id', '=', $user->id)
                    ->where('status', '=', 6);
                })
                ->get());
            }
        }
        // dd(Tagihan::where(function($query){
        //     $query->where('pelanggan_id', '=', Auth::user()->pelanggan->id)
        //     ->where('status', '=', 1);
        // })
        // ->orWhere(
        //     function($query){
        //         $query->where('pelanggan_id', '=', Auth::user()->pelanggan->id)
        //         ->where('status', '=', 0);
        //     }
        // )
        // ->orWhere(function($query){
        //     $query->where('pelanggan_id', '=', Auth::user()->pelanggan->id)
        //     ->where('status', '=', 3);
        // })
        // ->get(), Auth::user()->pelanggan->id);
        // dd($jumlah_pembayaran_pemasangan);

        // $pembayaran_telat = Pembayaran::join('tagihans','tagihans.id','=','pembayarans.tagihan_id')->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
        //     ->whereRaw(' pembayarans.tanggal > tagihans.tanggal')
        //     ->select('pembayarans.id','pembayarans.id_pembayaran','pelanggans.id_pelanggan','pelanggans.name','tagihans.jumlah_pembayaran','tagihans.id_tagihan','pembayarans.created_at','tagihan_id')->count();
        $yearStart = Carbon::now()->addYears(-1);
        $yearEnd = Carbon::now();
        $years_to_render = $yearStart->diffInYears($yearEnd);
        $years = [];

        for ($i = 0; $i <= $years_to_render; $i++) {
            $years[] = $yearStart->isoFormat('Y');
            $yearStart->addYears();
        }

        return view('index',compact('pelanggan','tagihan','pembayaran','pembayaran_telat','jumlah_pembayaran','jumlah_hutang','jumlah_pembayaran_pemasangan','jumlah_hutang_pemasangan', 'chartLabels', 'chartData', 'chartTargets', 'chartLabels2', 'chartRealisasis', 'values', "chartData2", "penggunaan", "total_bayar", 'thisMonthBill', 'thisMonthVolume', 'countLunas', 'countBayar', 'totalRealisasi', 'years'));
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
}
