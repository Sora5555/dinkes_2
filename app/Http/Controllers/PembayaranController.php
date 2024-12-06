<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Helper\Helper;
use App\Models\Log;
use App\Models\Target;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pelunasan;
use App\Models\Pembayaran;
// use DB,Auth,Session;
use App\Traits\TraitsDenda;
use Illuminate\Http\Request;
use App\Imports\TagihanImport;
use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class PembayaranController extends Controller
{
    use TraitsDenda;

    protected $routeName = 'pembayaran';
    protected $viewName = 'pembayaran';
    protected $title = 'Tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Pembayaran::with(['tagihan'=>function($query){
        //     $query->with(['pelanggan'=>function($query){
        //         $query->with('user');
        //     }]);
        // }])->get();

        // return Auth::user()->daerah;

        $route = $this->routeName;
        $title = $this->title;
        // $datas = Tagihan::where('status', '=', '0')->join("pelanggans", "tagihans.pelanggan_id", "=", "pelanggans.id")->select('pelanggans.id', 'tagihans.id', "pelanggans.name", "tagihans.jumlah_pembayaran", "tagihans.denda_harian", "tagihans.denda_admin", "tagihans.tanggal", "tagihans.pelanggan_id", "tagihans.created_at", "pelanggans.daerah_id")->get();
        // dd($datas, Auth::user()->daerah_id);
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function datatable()
    {
        if (Auth::user()->roles->first()->name =='Admin') {
        $datas = Tagihan::where('status', '=', '0')->join("pelanggans", "tagihans.pelanggan_id", "=", "pelanggans.id")->select('pelanggans.id', 'tagihans.id', "pelanggans.name", "tagihans.jumlah_pembayaran", "tagihans.denda_harian", "tagihans.denda_admin", "tagihans.tanggal", "tagihans.pelanggan_id", "tagihans.created_at")->get();
        // $datas = Pembayaran::doesntHave('pelunasan')->whereHas('tagihan.pelanggan.daerah',function($query){
        //     $query->where(['nama_daerah'=>Auth::user()->daerah->nama_daerah]);
        // })
        } else {
            $datas = Tagihan::where('status', '=', '0')->join("pelanggans", "tagihans.pelanggan_id", "=", "pelanggans.id")->where("pelanggans.daerah_id", "=", Auth::user()->daerah_id)->select('pelanggans.id', 'tagihans.id', "pelanggans.name", "tagihans.jumlah_pembayaran", "tagihans.denda_harian", "tagihans.denda_admin", "tagihans.tanggal", "tagihans.pelanggan_id", "tagihans.created_at")->get();
        }
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran + $data->denda_harian + $data->denda_admin;
                return "Rp. ".number_format($jumlah, 2);
            })
            ->editColumn('id_pelanggan',function($data){
                return $data->pelanggan_id;
            })
            ->editColumn('name',function($data){
                return $data->name;
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->isoFormat('MMMM-Y');
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d');
            })
            ->addColumn('action', function ($data) {
                $route = 'pembayaran';
                return view('layouts.includes.table-action-nota',compact('data','route'));
            });

        return $datatables->make(true);
    }

    public function data(Request $request)
    {
        $datas = Tagihan::find($request->id);

        if($datas->meter_penggunaan_awal != null){
            $meter_sebelumnya = $datas->meter_penggunaan_awal;
            $meter_sekarang = $datas->meter_penggunaan;
            $pemakaian = $meter_sekarang - $meter_sebelumnya;

            // $jumlah_pembayaran = $pemakaian * 11500;
        }else if($datas->meter_penggunaan_awal == null){

            $pemakaian = $datas->meter_penggunaan;
            $jumlah_pembayaran = $datas->jumlah_pembayaran;

            // $jumlah_pembayaran = $meter_sekarang * 11500;
        }

        $data = [
            'name' => $datas->pelanggan->name,
            'no_telepon' => $datas->pelanggan->no_telepon,
            'alamat' => $datas->pelanggan->alamat,
            'total_pemakaian' => number_format($pemakaian),
            'jumlah_pembayaran' => number_format($jumlah_pembayaran + $datas->denda_harian + $datas->denda_admin, 2),
            'bulan' => $datas->tanggal->format('n'),
            'tahun' => $datas->tanggal->format('Y'),
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $route = $this->routeName;
        $title = $this->title;

        $start = \Carbon\Carbon::now()->subYear()->startOfYear();
        $end = \Carbon\Carbon::now()->subYear()->endOfYear();
        $months_to_render = $start->diffInMonths($end);
    
        $dates = [];
    
        for ($i = 0; $i <= $months_to_render; $i++) {
            $dates[] = $start->isoFormat('MMMM');
            $start->addMonth();
        }

        $tagihans = Tagihan::orderBy('created_at','desc')->doesntHave('pembayaran')->get();

        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        return view($this->viewName.'.create',compact('route','title','dates','years','tagihans','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'id_tagihan' => 'required|string|max:100',
        ]);

        $datas = Tagihan::find($request->id_tagihan);

        // $tagihans_sebelumnya = Tagihan::where('pelanggan_id', $datas->pelanggan_id)->whereNotIn('id', [$datas->id])->where('created_at','<',$datas->created_at)->orderBy('created_at','desc');

        // $jumlah_tagihan = $tagihans_sebelumnya->count();

        // if($jumlah_tagihan > 0){
        //     $meter_sebelumnya = $tagihans_sebelumnya->first()->meter_penggunaan;
        // }else if($jumlah_tagihan <= 0){
        //     $meter_sebelumnya = 0;
        // }

        // $total_pemakaian = $datas->meter_penggunaan - $meter_sebelumnya;

        try{
            $number = rand(0,1000);
            $txt = date("Ymdhis").''.$number;
            
            $id = $txt.$number;
            $query = Pembayaran::create([
                'id_pembayaran' => $txt,
                'tagihan_id' => $datas->id,
                'tanggal' => date('Y-m-d'),
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Pembayaran : '.$query->id_pembayaran]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $tagihan = Tagihan::where("id", "=", $id)->first();

        if ($tagihan->status !== 2 ) {
            if ($tagihan->tanggal->format('m') == Carbon::now()->format('m')){
                $tanggal = Carbon::now()->format('Y-m-d');
            }else{
                $tanggal = Carbon::create($tagihan->tanggal->format('Y-m').'-20')->format('Y-m-d');
            }
            $date = Carbon::now()->format('Y-m-d');
            $denda_harian =  $tagihan->denda_harian;
        }else{
            $denda_harian = $tagihan->denda_harian;
        }
        $now = Carbon::now()->format("Y");
        $jabatans = null;
        if(Auth::user()->roles->first()->name == "Admin"){
            $jabatans = Jabatan::all();
        } else {
            $jabatans = Jabatan::where('daerah_id', Auth::user()->daerah->id)->get();
        }
        $data=[
            'title'=>$this->title,
            'route'=>$this->routeName,
            'pembayaran'=>$tagihan,
            'denda_harian'=>$denda_harian,
            'tahun' => $now,
            'jabatans' => $jabatans,
        ];
        return view($this->viewName.'.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   

       
        $pembayaran = Tagihan::findOrFail($id);
        // $denda_harian = null;
        if ($pembayaran->status != 2 ) {
            if ($pembayaran->tanggal->format('m') == Carbon::now()->format('m')){
                $tanggal = Carbon::now()->format('Y-m-d');
            }else{
                $tanggal = Carbon::create($pembayaran->tanggal->format('Y-m').'-20')->format('Y-m-d');
            }
            $date = Carbon::now()->format('Y-m-d');
            $denda_harian = isset($request->denda_harian)?$request->denda_harian:$pembayaran->denda_harian;
        }else{
            $denda_harian = isset($request->denda_harian)?$request->denda_harian:$pembayaran->denda_harian;
        }
        
        $total = isset($request->jumlah_pembayaran)?$request->jumlah_pembayaran:$pembayaran->jumlah_pembayaran;
        $date_formated = Carbon::now()->format('Y-m-d');
        $number_pembayaran = date("Ymdhis").''.rand(1,1000);
        // return number_format($total);
        DB::beginTransaction();
        try{
            //titik pemisah ribuan
            if(strpos($total, ".")){
                $total = str_replace(".", "", $total);
            }
            if(strpos($denda_harian, ".")){
                $denda_harian = str_replace(".", "", $denda_harian);
            }
            if(strpos($request->denda_admin, ".")){
                $request->denda_admin = str_replace(".", "", $request->denda_admin);
            }

            //bila ada koma
            if(strpos($total, ",")){
                $total = str_replace(",", ".", $total);
            }
            if(strpos($denda_harian, ",")){
                $denda_harian = str_replace(",", ".", $denda_harian);
            }
            if(strpos($request->denda_admin, ",")){
                $request->denda_admin = str_replace(",", ".", $request->denda_admin);
            }
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menetapkan Tagihan Penggunaan ".$pembayaran->pelanggan->name. " dengan Jumlah pembayaran dari ".$pembayaran->jumlah_pembayaran." menjadi ". $request->jumlah_pembayaran. " denda keterlambatan dari ".$pembayaran->denda_harian." menjadi ".$request->denda_harian." Sanksi Administrasi ". $pembayaran->denda_admin." menjadi ".$request->denda_admin,
            ]);
            $pembayaran->update([
                'jumlah_pembayaran'=>(float) $total,
                'denda_harian'=>(float) $denda_harian,
                'denda_admin'=>isset($request->denda_admin)?(float) $request->denda_admin:$pembayaran->denda_admin,
                // 'tanggal_penetapan' => Carbon::now()->format('Y-m-d'),
                'status'=>1,
                'tanggal_penetapan' => $date_formated,
                'nomor_surat_penetapan' => $request->surat_penetapan,
                'nomor_surat_tagihan' => $request->surat_tagihan,
                'jabatan_id' => $request->jabatan,
                'jabatan_id2' => $request->jabatan2,
            ]);
            $pembayaran->pembayaran()->create([
                'id_pembayaran'=>$number_pembayaran,
                'tanggal'=>$date_formated,
            ]);
            $periode = $pembayaran->tanggal->isoFormat('MMMM-Y');
            Helper::sendWa($pembayaran->pelanggan->no_telepon, "Laporan penggunaan untuk periode $periode telah ditetapkan");
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Memverifikasi Data Pembayaran : '.$pembayaran->id_pembayaran]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try{
            $query = Tagihan::where('id', $id)->first();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus data tagihan ".$query->pelanggan->name." Dengan Jumlah Rp. ".$query->jumlah_pembayaran,
            ]);
            $query->delete();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Tagihan : '.$query->id]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    public function nota($id)
    {
        $datas = Tagihan::find($id);
        return view('pembayaran.nota' , compact('datas'));
    }
    public function newEdit($id)
    {
        
        $pembayaran = Pembayaran::findOrFail($id);
        $tagihan = Tagihan::where("id", '=', $pembayaran->tagihan->id)->first();
        if ($pembayaran->tagihan->status !== 2 ) {
            if ($tagihan->tanggal->format('m') == Carbon::now()->format('m')){
                $tanggal = Carbon::now()->format('Y-m-d');
            }else{
                $tanggal = Carbon::create($tagihan->tanggal->format('Y-m').'-20')->format('Y-m-d');
            }
            $date = Carbon::now()->format('Y-m-d');
            $denda_harian =  $denda_harian = $pembayaran->tagihan->denda_harian;
        }else{
            $denda_harian = $pembayaran->tagihan->denda_harian;
        }
        $now = Carbon::now()->format("Y");
        $jabatans = null;
        if(Auth::user()->roles->first()->name == "Admin"){
            $jabatans = Jabatan::all();
        } else {
            $jabatans = Jabatan::where('daerah_id', Auth::user()->daerah->id)->get();
        }
        $data=[
            'title'=>$this->title,
            'route'=>$this->routeName,
            'pembayaran'=>$tagihan,
            'file_name' => $pembayaran->file_name,
            'file_path' => $pembayaran->file_path,
            'denda_harian'=>$denda_harian,
            'tahun' => $now,
            'jabatans' => $jabatans,
        ];
        return view($this->viewName.'.newEdit')->with($data);
    }
   public function newUpdate(Request $request, $id){
        $pembayaran = Tagihan::findOrFail($id);
        if ($pembayaran->status !== 2 ) {
            if ($pembayaran->tanggal->format('m') == Carbon::now()->format('m')){
                $tanggal = Carbon::now()->format('Y-m-d');
            }else{
                $tanggal = Carbon::create($pembayaran->tanggal->format('Y-m').'-20')->format('Y-m-d');
            }
            $date = Carbon::now()->format('Y-m-d');
            $denda_harian =  $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$pembayaran->jumlah_pembayaran,$date);
        }else{
            $denda_harian = $pembayaran->denda_harian;
        }
        
        $total = $pembayaran->jumlah_pembayaran;
        $date_formated = Carbon::now()->format('Y-m-d');
        $number_pembayaran = date("Ymdhis").''.rand(1,1000);
        // return number_format($total);
        $datas = $pembayaran->pembayaran;
        $number = rand(0,1000);
        $txt = date("Ymdhis").''.$number;
        DB::beginTransaction();
        try{
            $target = Target::where("id_daerah", "=", $pembayaran->pelanggan->daerah_id)->first();
            Target::where("id_daerah", "=", $pembayaran->pelanggan->daerah_id)->update(["realisasi" => $target->realisasi + $datas->tagihan->jumlah_pembayaran]);
            $pembayaran->update([
                'jumlah_pembayaran'=>$total,
                'status'=>4,
                'tanggal_penerimaan' => Carbon::now()->format('Y-m-d'),
                'jabatan_id3' => $request->jabatan3
            ]);
            $query = Pelunasan::create([
                'id_pelunasan' => $txt,
                'pembayaran_id' => $datas->id,
                'tanggal' => date('Y-m-d'),
            ]);
            $periode = $pembayaran->tanggal->isoFormat("MMMM-Y");
            Helper::sendWa($pembayaran->pelanggan->no_telepon, "Tagihan untuk periode $periode sudah ditandai lunas.");
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengkonfirmasi Bukti Pembayaran ".$pembayaran->pelanggan->name." dengan jumlah Rp. ".$pembayaran->jumlah_pembayaran,
            ]);
            DB::commit();
            return redirect(route('pelunasan.index'))->with(['success'=>'Berhasil Menambah data pelunasan : '.$pembayaran->id_pembayaran]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }
    public function import(){
            $title = $this->title;
            $route = $this->routeName;
        return view($this->viewName.".import", compact('title', 'route'));
    }
    public function make(Request $request){
        $import = new TagihanImport();
        $import->import($request->file('file'));
        dd($import->errors(), $import->toArray($request->file('file')));
    }
}