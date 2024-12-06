<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Helper\Helper;
use App\Models\Log;
use App\Models\NPA;

use App\Models\User;
use App\Mail\Emailing;
use App\Models\Target;
use App\Models\Jabatan;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pelunasan;
use App\Models\UptDaerah;
use App\Models\Pembayaran;
use App\Traits\TraitsDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\PembayaranTagihansExport;
use App\Imports\PembayaranTagihansImport;

class PelunasanController extends Controller
{
    use TraitsDenda;

    protected $routeName = 'pelunasan';
    protected $viewName = 'pelunasan';
    protected $title = 'Pembayaran';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function datatable()
    {

        //Penambahan tanggal penerimaan dan perbaikan tabel pelunasan.
        if (Auth::user()->roles->first()->name =='Admin') {
            $datas = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->where("tagihans.status", '=', 2)->join('pembayarans', 'pembayarans.tagihan_id', '=', 'tagihans.id')->select("tagihans.id", 'meter_penggunaan', 'meter_penggunaan_awal', 'jumlah_pembayaran', 'tagihans.tanggal', 'tanggal_akhir', 'name', 'denda_harian', 'denda_admin', 'tanggal_penerimaan', 'status', 'pembayarans.file_name', 'pembayarans.file_path');
            // $datas = Pembayaran::doesntHave('pelunasan')->whereHas('tagihan.pelanggan.daerah',function($query){
            //     $query->where(['nama_daerah'=>Auth::user()->daerah->nama_daerah]);
            // })
            } else {
                $datas = Tagihan::join("pelanggans", 'pelanggans.id', '=', 'tagihans.pelanggan_id')->where("tagihans.status", '=', 2)->join('pembayarans', 'pembayarans.tagihan_id', '=', 'tagihans.id')->where("pelanggans.daerah_id", '=', Auth::user()->daerah_id)->select("tagihans.id", 'meter_penggunaan', 'meter_penggunaan_awal', 'jumlah_pembayaran', 'tagihans.tanggal', 'tanggal_akhir', 'name', 'denda_harian', 'denda_admin', 'tanggal_penerimaan', 'status', 'pembayarans.file_name', 'pembayarans.file_path');
            }
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran + $data->denda_harian + $data->denda_admin;
                return "Rp. ".number_format($jumlah, 2);
            })
            ->editColumn('name',function($data){
                    return $data->name;
            })
            ->editColumn('tagihan',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah, 2);
            })
            ->editColumn('denda_harian',function($data){
                $jumlah = $data->denda_harian + $data->denda_admin;
                return "Rp. ".number_format($jumlah, 2);
            })
            ->editColumn('meter_penggunaan',function($data){
                $jumlah = $data->meter_penggunaan;
                return number_format($jumlah, 2);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F-Y');
            })
            ->editColumn('tanggal_penerimaan',function($data){
                return date("d-F-Y", strtotime($data->tanggal_penerimaan));
            })
            ->editColumn('tanggal_akhir',function($data){
                return date("F-Y", strtotime($data->tanggal_akhir));
            })
            ->addColumn('action', function ($data) {
                $route = 'pelunasan';
                $file_name = $data->file_name;
                $file_path = $data->file_path;
                return view('layouts.includes.table-action-nota',compact('data','route', 'file_name', 'file_path'));
            });

        return $datatables->make(true);
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

        $pembayarans = Tagihan::where("status", 1)->orWhere('status', 5)->orWhere('status', 6)->get();


        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        return view($this->viewName.'.create',compact('route','title','dates','years','pembayarans','request'));
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
            'id_pembayaran' => 'required|string|max:100',
        ]);

        $datas = Tagihan::find($request->id_pembayaran);
        
        try{
            $number = rand(0,1000);
            $txt = date("Ymdhis").''.$number;
            
            $id = $txt.$number;
            $target = Target::where("id_daerah", "=", $datas->pelanggan->daerah_id)->first();
            Target::where("id_daerah", "=", $datas->pelanggan->daerah_id)->update(["realisasi" => $target->realisasi + $datas->jumlah_pembayaran]);
            $query = Pelunasan::create([
                'id_pelunasan' => $txt,
                'pembayaran_id' => $datas->id,
                'tanggal' => date('Y-m-d'),
            ]);
            $periode = $datas->tanggal->isoFormat("MMMM-Y");
            $datas->update([
                'tanggal_penerimaan' => Carbon::now()->format('Y-m-d'),
                'status' => 2,
            ]);
            Helper::sendWa($datas->pelanggan->no_telepon, "Tagihan untuk periode $periode sudah ditandai lunas.");
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menambah Data Pelunasan ".$datas->pelanggan->name. " dengan Jumlah Rp. ". $datas->jumlah_pembayaran,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Pelunasan : '.$query->id]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pelunasan : '.$e->getMessage()])->withErrors($request->all());
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
        //
        $title = $this->title;
        $route = $this->routeName;

        $data = Tagihan::where("id", $id)->first();
        return view($this->viewName.'.edit',compact('route','title', 'data'));
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
        //
        $data = Tagihan::where('id', $id)->first();
        try {
            if($request->pembayaran != $data->jumlah_pembayaran){
                $target = Target::where("id_daerah", $data->pelanggan->daerah_id)->first();
                $target->update([
                    'realisasi' => ($target->realisasi - $data->jumlah_pembayaran) + $request->pembayaran,
                ]);
            }
            $data->update([
                'jumlah_pembayaran' => $request->pembayaran,
                'meter_penggunaan' => $request->pemakaian,
                'tanggal' => $request->tanggal_awal,
                'denda_harian' => $request->denda,
                'tanggal_akhir' => $request->tanggal_akhir
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengedit data pelunasan ".$data->pelanggan->name." dengan periode ".$request->tanggal_awal." dan jumlah pembayaran Rp. ".$request->pembayaran,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Pelunasan : '.$data->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        try{
            $query = Tagihan::where('id', $id)->first();
            $target = Target::where("id_daerah", $query->pelanggan->daerah_id)->first();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus data pelunasan ".$query->pelanggan->name. " dengan jumlah Rp. ".$query->jumlah_pembayaran,
            ]);
            $target->update([
                'realisasi' => $target->realisasi - $query->jumlah_pembayaran,
            ]);
            $query->delete();


            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Pembayaran : '.$query->id]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }
    public function lunas()
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
        if(Auth::user()->roles->first()->name == "Admin"){
            $jabatans = Jabatan::all();
        } else {
            $jabatans = Jabatan::where('daerah_id', Auth::user()->daerah->id)->get();
        }

        $pelanggans = Pelanggan::all();


        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        return view($this->viewName.'.lunas',compact('route','title','dates','years','pelanggans', 'jabatans'));
    }
    public function lunasStore(Request $request){
        $datas = Pelanggan::where('id', $request->id_pelanggan)->first();
        try{
            $direktori=public_path().'/storage/image/';          
            $nama_file=str_replace(' ','-',$request->file->getClientOriginalName());
            $file_format= $request->file->getClientOriginalExtension();
            DB::beginTransaction();
            $number = rand(0,1000);
            $request['file_path'] = '/storage/image/';
            $request['file_name'] = $nama_file;
            $txt = date("Ymdhis").''.$number;
            $id = $txt;
            $request['id_tagihan'] = $id;
            $request['pelanggan_id'] = $request->id_pelanggan;
            $request['tanggal'] = $request->tanggal;
            $request['tanggal_akhir'] = $request->tanggal;
            $request['tanggal_penerimaan'] = $request->tanggal_penerimaan;
            $request['meter_penggunaan_awal'] = 0;
            $request['meter_penggunaan'] = (float)$request->pemakaian;
            $request['jumlah_pembayaran'] = $request->jumlah_pembayaran;
            $request['tarif'] = 0;
            $request['pesan'] = null;
            $request['status'] = 2;
            $request['denda_harian'] = $request->denda;
            $request['denda_admin'] = $request->denda_admin;
            $request['jabatan_id'] = $request->jabatan_id;
            $request['jabatan_id2'] = $request->jabatan_id2;
            $request['jabatan_id3'] = $request->jabatan_id3;
            $tagihan = Tagihan::create($request->all());
            $number2 = rand(0, 1000);
            $txt2 = date("Ymdhis").''.$number2;
            $pembayaran = Pembayaran::create([
                'id_pembayaran' => $txt2,
                'tagihan_id' => $tagihan->id,
                'tanggal' => date('Y-m-d'),
                'file_path' => '/storage/image/',
                'file_name' => $nama_file,

            ]);
            $number3 = rand(0, 1000);
            $txt3 = date("Ymdhis").''.$number3;
            $pelunasan = Pelunasan::create([
                'id_pelunasan' => $txt3,
                'pembayaran_id' => $pembayaran->id,
                'tanggal' => date('Y-m-d'),
            ]);
            $target = Target::where("id_daerah", "=", $datas->daerah_id)->first();
            Target::where("id_daerah", "=", $datas->daerah_id)
            ->update(["realisasi" => $target->realisasi + $request->jumlah_pembayaran]);
            // $vars  = array(
            //     '{id_pelanggan}' => $datas->id,
            //     '{nama_pelanggan}' => $datas->name,
            //     '{alamat}' => $datas->alamat,
            //     '{tanggal}' => strtoupper($date_formated),
            //     '{meter_penggunaan}' => $request["meter_penggunaan"],
            //     '{jumlah_pembayaran}' => $request["jumlah_pembayaran"],
            // );
            // $msg = "Pelanggan atas nama {nama_pelanggan} telah melakukan pelaporan untuk periode tagihan {tanggal}";    
            // $msg1 = strtr($msg, $vars);
            // $operator = User::role("Operator")->where("daerah_id", '=', $datas->daerah_id)->first();
            // Helper::sendWa($operator->no_telepon,$msg1);
            // // Helper::sendWa(Auth::user()->no_telepon, $msg1);
            // Mail::to($operator->email)->send(new Emailing($datas, false, $operator, $date_formated));
            // // Mail::to(Auth::user()->email)->send(new Emailing(Auth::user()->pelanggan, false, $operator, $date_formated));
            $number_pembayaran = date("Ymdhis").''.rand(1,1000);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Melaporkan Penggunaan"
            ]);
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Tagihan : '.$tagihan->id_tagihan]);
        } catch (\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Tagihan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    public function exportTemplateView()
    {
        $route = $this->routeName;
        $title = $this->title;
        
        $upts = UptDaerah::orderBy("nama_daerah")->get();
        return view($this->viewName.'.export-template',compact('route','title','upts'));
    }

    public function exportTemplate()
    {
        return Excel::download(new PembayaranTagihansExport, 'template_pembayaran'.date("Y_M_D_H_i").'.xlsx');
    }

    // mengambil data pelanggan/perusahaan berdasarkan upt/daerahnya
    public function ajaxGetPelanggan($upt_id)
    {   
        if($upt_id == 0){
            $pelanggans = Pelanggan::orderBy("name")->get()->toArray();
        } else {
            $pelanggans = Pelanggan::orderBy("name")->where('daerah_id',$upt_id)->get()->toArray();
        }
        
        $results = [
            [
                'id'=>0,
                'name'=>"-- Semua Perusahaan --"
            ]
        ];
        $results = array_merge($results,$pelanggans);
        return response()->json($results);
    }

    //fungsi ke view untuk import excel
    public function importExcelView()
    {
        $route = $this->routeName;
        $title = $this->title;
        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;
        $upts = UptDaerah::orderBy("nama_daerah")->get();
        return view($this->viewName.'.import-excel',compact('route','title','upts','years'));
    }

    public function importExcel(Request $request)
    {   
        $import = new PembayaranTagihansImport;
        Excel::import($import, $request->file);
        $results = $import->results;
        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;
        $session = ['success'=>'Berhasil Mengimport Data Tagihan Dari File : '.$request->file->getClientOriginalName(),'results'=>$results];
        
        //cek apakah import data lainnya walaupun ada data yang tidak sesuai format
        $error = false;
        foreach ($results as $result) {
            if($result['status'] == 'danger'){
                $error = true;
            }
        }
        if(!$request->import_data){
            if($error){
                $session = ['error'=>'Gagal Mengimport Data Tagihan Dari File : '.$request->file->getClientOriginalName(),'results'=>$results];
            }
        }
        return redirect('pelunasan/importExcel')->with($session);
    }
    public function delete(){
        $datas = Tagihan::whereHas('pelanggan', function($query) {
            $query->where('pelanggans.daerah_id', '=', Auth::user()->daerah_id);
        })->get();
        foreach($datas as $data){
            $target = Target::where('id_daerah', $data->pelanggan->daerah_id)->first();
            $target->update([
                'realisasi' => $target->realisasi - $data->jumlah_pembayaran,
            ]);
            $data->pembayaran->tagihan->delete();
            $data->pembayaran->delete();
            $data->delete();
        }
        return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus semua data tagihan']);

    }
    
}
