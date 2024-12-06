<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use Helper\Helper;
use App\Models\Log;
use App\Models\NPA;
use App\Models\User;
use App\Models\Lunas;
use App\Models\Surat;
use App\Mail\Emailing;
use App\Models\Tagihan;
use App\Models\Jabatan;
use App\Models\hariLibur;
use App\Models\Pelanggan;
use App\Models\JenisDenda;
use App\Models\Penetapan;
use App\Models\Pembayaran;
use App\Traits\TraitsDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use NumberFormatter;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\Traits\TraitsApi;
use Str;

class TagihanController extends Controller
{
    use TraitsDenda,TraitsApi;

    protected $routeName = 'tagihan';
    protected $viewName = 'tagihan';
    protected $title = 'Laporan Pemakaian';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return Tagihan::find(11)->status;
        $route = $this->routeName;
        $title = $this->title;
        $datas = Tagihan::with('pelanggan')->where(['pelanggan_id'=>$request->id])->where('status', 1)->get();
        // $tagihans = Tagihan::where('pelanggan_id', Auth::user()->pelanggan->id)->where('status', 1)->orWhere('status', 5)->get();
        $hariLibur = hariLibur::select('tanggal')->get();
        foreach($datas as $tagihan){
            $hlArr = [];
            foreach($hariLibur as $hl){
                array_push($hlArr, $hl->tanggal);
            }
            if($tagihan->pembayaran){
                $this->cekDendaPenetapan(2, $tagihan->pembayaran->tanggal, $tagihan, $hlArr);
            }
        }
        $sektor = Auth::user()->pelanggan;
        return view($this->viewName.'.index',compact('route','title', 'sektor'));
    }

    public function datatable(Request $request)
    {
        
        if(Auth::user()->name != 'Admin'){
            $datas = Tagihan::with('pelanggan')->where(['pelanggan_id'=>$request->sektor]);
        }else if(Auth::user()->name == 'Admin'){
            $datas = Tagihan::with('pelanggan');
        }
        $jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();
        try {
            //code...
            $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('meter_penggunaan', function($data){
                if($data->meter_penggunaan_awal != null){
                    $penggunaan = $data->meter_penggunaan - $data->meter_penggunaan_awal;
                }else if($data->meter_penggunaan_awal == null){
                    $penggunaan = $data->meter_penggunaan;
                }
                return number_format($penggunaan);
                
            })
            ->editColumn('name',function($data){
                return $data->pelanggan->name;
            })
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return "Rp. ".number_format($jumlah, 2);
                }
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F').'-'.$data->tanggal->format('Y');
            })
            ->editColumn('tanggal_akhir',function($data){
                return date("F", strtotime($data->tanggal_akhir)).'-'.date("Y", strtotime($data->tanggal_akhir));
            })
            ->editColumn('status_pemb', function ($data){
                if ($data->status == 0) {
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                }elseif($data->status == 1 || $data->status == 4 || $data->status == 5 || $data->status == 6){
                    return '<h6 class="text-warning">Penetapan</h6>';
                } elseif($data->status == 3){
                    return '<h6 class="text-warning">Menunggu Konfirmasi</h6>';
                }
                elseif($data->status == 2){
                    return '<h6 class="text-success">Dibayarkan</h6>';
                }
            })->rawColumns(['status_pemb', 'jumlah_pembayaran', 'total_tagihan', 'denda_admin', 'denda_Keterlambatan'])
            ->addColumn('denda_Keterlambatan',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_harian, 2);
                }
            })
            ->addColumn('total_tagihan',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_harian + $data->denda_admin + $data->jumlah_pembayaran, 2);
                }
            })
            ->addColumn('denda_admin',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_admin, 2);
                }
            })
            ->addColumn('pembayaran', function ($data) {
                if($data->status == 1 || $data->status == 5){
                    return view('layouts.includes.table-action-pembayaran', compact('data'));   
                } else {
                    return "-";
                }
            })
            ->addColumn('action', function ($data) {
                $route = 'tagihan';
                $url2 = $data->file_path.''.$data->file_name;
                $url = '-';
                if($data->status == 3 || $data->status == 2){
                    $url = $data->pembayaran->file_path.''.$data->pembayaran->file_name;   
                }
                    return view('layouts.includes.table-action',compact('data','route', 'url', 'url2'));   
            });

        return $datatables->make(true);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        
    }

    public function data(Request $request){
        $datas = Tagihan::find($request->id);
        if($datas->meter_penggunaan_awal != null){
            $meter_sebelumnya = $datas->meter_penggunaan_awal;
            $meter_sekarang = $datas->meter_penggunaan;
            $pemakaian = $meter_sekarang - $meter_sebelumnya;

            // $jumlah_pembayaran = $pemakaian * 11500;
        }else if($datas->meter_penggunaan_awal == null){
            $pemakaian = $datas->meter_penggunaan;
        }


        // $total_pemakaian = $datas->meter_penggunaan - $datas->meter_penggunaan_awal;

        $data = [
            'name' => $datas->pelanggan->name,
            'kategori_industri' => $datas->pelanggan->kategori_industri->nama_industri,
            'no_telepon' => $datas->pelanggan->no_telepon,
            'alamat' => $datas->pelanggan->alamat,
            'total_pemakaian' => number_format($pemakaian),
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
        if(Tagihan::with('pelanggan')->where(['pelanggan_id'=>$request->category])->where(function($w){
            $w->where('status',0)->orWhere('status',1)->orWhere('status',3);
        })->first()){
            return redirect()->back()->with(['error'=>'Mohon Lunasi Tagihan Terlebih Dahulu Sebelum Melaporkan Penggunaan Kembali']);
        }
        $start = \Carbon\Carbon::now()->subYear()->startOfYear();
        $end = \Carbon\Carbon::now()->subYear()->endOfYear();
        $months_to_render = $start->diffInMonths($end);
    
        $dates = [];
    
        for ($i = 0; $i <= $months_to_render; $i++) {
            $dates[] = $start->isoFormat('MMMM');
            $start->addMonth();
        }

        $pelanggans = [];

        if(Auth::user()->name != 'Admin'){
            $pelanggans = Auth::user()->load(['pelanggan'=>function($query){
                $query->with('kategori_npa');
            }])->load('daerah');
        }
        

        // $pelanggans =  Auth::user()->pelanggan;

        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        // $sektor = Auth::user()->pelanggan;
        // dd($dates);
        // dd(Carbon::now()->format('D MMMM Y, H:i:s'));
        $present = Carbon::now()->addMonth(-1);
        $sektor = $request->category;
        $nama_sektor = Pelanggan::findOrFail($sektor)->kategori_npa->kategori;
        // dd($nama_sektor, $sektor, Pelanggan::findOrFail($sektor)->first());
        
        return view($this->viewName.'.create',compact('route','title','dates','years','pelanggans', 'present', 'sektor', 'nama_sektor'));
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        try {

            // $i = Carbon::make($request->tanggal_awal);
            $count = [];
            $key = 0;
            DB::beginTransaction();

            foreach($request->periode as $key => $periode){
                
                $this->cekTunggakan(Auth::user()->id, $periode,$request);
                $denda_admin = $this->cekDendaAdmin(Auth::user()->id, $periode,$request);
                if($request->has('file')){
                    $validator = $request->validate([
                        'file' => 'max:5000',
                    ]);   
                }
                //appPass = ATBBDGLJbPvstqk3W5xGXcMgGun44FF0AD5E;
                if ($request->has('file') && array_key_exists($key, $request->file('file'))) {
                $file=$request->file('file')[$key];
                $direktori=public_path().'/storage/image/';          
                $nama_file=str_replace(' ','-',$request->file[$key]->getClientOriginalName());
                $file_format= $request->file[$key]->getClientOriginalExtension();
                $uploadSuccess = $request->file[$key]->move($direktori,$nama_file);
                }

                $kategori_npa = 4;

                if(Auth::user()->name != "Admin"){
                    $kategori_npa = Pelanggan::where('id', $request->kategori)->first()->kategori_npa->npa->first();
                }
                $pembayaran = null;
                $harga = null;

                if ($kategori_npa->volume_akhir) {//jika pengguna bukan BUMN dan BUMD
                    $list_harga = NPA::whereHas('kategori.pelanggan',function($query){
                        $query->where(['user_id'=>Auth::user()->id]);
                    })->whereHas('wilayah.pelanggan',function($query){
                        $query->where(['daerah_id'=>Auth::user()->daerah_id]);
                    })->with('kategori')
                    ->get();
                    // 
                    if ($list_harga->count() > 0) { // jika pengguna berada pada list harga
                        $counter_volume = $request->pemakaian[$key];
                        foreach ($list_harga as $keys => $value){
                            if ($counter_volume >= 0 && $list_harga[$keys]->volume_akhir == 50){
                                if($counter_volume - 50 > 0){
                                    $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                                    $pembayaran += ($list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga) * 10/100; 
                                    $counter_volume -= $list_harga[$keys]->volume_akhir;
                                } else {
                                    $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                                    $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                                    break;
                                }
                            } else if ($counter_volume >= 0 && $list_harga[$keys]->volume_akhir == 500){
                                if($counter_volume - 450 > 0){
                                    $harga += 450 * $list_harga[$keys]->harga;
                                    $pembayaran += (450 * $list_harga[$keys]->harga) * 10/100; 
                                    $counter_volume -= 450;
                                } else {
                                    $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                                    $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                                    break;
                                }
                            } else if($counter_volume > 0 && $list_harga[$keys]->volume_akhir == 1000){
                                if($counter_volume - 500 > 0){
                                    $harga += 500 * $list_harga[$keys]->harga;
                                    $pembayaran += (500 * $list_harga[$keys]->harga) * 10/100; 
                                    $counter_volume -= 500;
                                } else {
                                    $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                                    $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                                    break;
                                }
                            } else if($counter_volume > 0 && $list_harga[$keys]->volume_akhir == 2500){
                                if($counter_volume - 1500 > 0){
                                    $harga += 1500 * $list_harga[$keys]->harga;
                                    $pembayaran += (1500 * $list_harga[$keys]->harga) * 10/100; 
                                    $counter_volume -= 1500;
                                } else {
                                    $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                                    $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                                    break;
                                }
                            } else if($counter_volume > 0 && $list_harga[$keys]->volume_awal == 2501){
                                    $harga += $counter_volume * $list_harga[$keys]->harga;
                                    $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                                    break;
                            }
                        }

                       
                    }else{
                        return redirect()->back()->with(['error'=>'Maaf area anda belum terdaftar pada kategori NPA kami']);
                    }
                    
                    }else{//jika pengguna adalah BUMD atau BUMN
                        $harga = $kategori_npa->harga;
                        $pembayaran = ($request->pemakaian[$key] * $harga)*10/100;
                    }
                $denda_Keterlambatan = $this->cekDendaKeterlambatan(Auth::user()->id,$periode,$pembayaran);
                $date_formated = Carbon::createFromFormat('Y-m-d',$periode);
                $number = rand(0,1000);
                $txt = date("Ymdhis").''.$number;
                $id = $txt.$number;
                $request['id_tagihan'] = $txt;
                $request['pelanggan_id'] = $request->kategori;
                $request['tanggal'] = $date_formated;
                $request['tanggal_akhir'] = $date_formated;
                $request['meter_penggunaan_awal'] = $request->meter_sebelumnya[$key];
                $request['meter_penggunaan'] = $request->meter_sekarang[$key] !=0?$request->meter_sekarang[$key]:$request->pemakaian[$key];
                $request['jumlah_pembayaran'] = $pembayaran;
                $request['tarif'] = $harga;
                $request['file_name'] = isset($request->file[$key])?$nama_file:null;
                $request['file_path'] = isset($request->file[$key])?'/storage/image/':null;
                $request['pesan'] = null;
                $request['status'] = 0;
                $request['denda_harian'] = $denda_Keterlambatan;
                $request['denda_admin'] = $denda_admin;
                $tagihan = Tagihan::create($request->all());
                $surat = Surat::where("daerah_id", Pelanggan::where('id', $request->kategori)->first()->daerah->id)->first();
                $penetapan = Penetapan::where("daerah_id", Pelanggan::where('id', $request->kategori)->first()->daerah->id)->first();
                $lunas = Lunas::where("daerah_id", Pelanggan::where('id', $request->kategori)->first()->daerah->id)->first();
                $nomor_tagihan = $surat->awalan_surat . "/" . $surat->urutan . "/" . $surat->kode_wilayah . "/" . $surat->tahun;
                $nomor_penetapan = $penetapan->awalan_surat . "/" . $penetapan->urutan . "/" . $penetapan->kode_wilayah . "/" . $penetapan->tahun;
                $nomor_lunas = $lunas->awalan_surat . "/" . $lunas->urutan . "/" . $lunas->kode_wilayah . "/" . $lunas->tahun;
                $tagihan->update([
                    'nomor_surat_tagihan' => $nomor_tagihan,
                    'nomor_surat_penetapan' => $nomor_penetapan,
                    'nomor_surat_setoran' => $nomor_lunas,
                ]);
                $surat->update([
                    'urutan' => $surat->urutan + 1,
                ]);
                $penetapan->update([
                    'urutan' => $penetapan->urutan + 1,
                ]);
                $lunas->update([
                    'urutan' => $lunas->urutan + 1,
                ]);
                
                $vars  = array(
                    // '{id_pelanggan}' => Auth::user()->pelanggan->id,
                    '{nama_pelanggan}' => Pelanggan::where('id', $request->kategori)->first()->name,
                    '{alamat}' => Pelanggan::where('id', $request->kategori)->first()->alamat,
                    '{tanggal}' => strtoupper($date_formated),
                    '{meter_penggunaan}' => $request["meter_penggunaan"],
                    '{jumlah_pembayaran}' => $request["jumlah_pembayaran"],
                );
                $msg = "Pelanggan atas nama {nama_pelanggan} telah melakukan pelaporan untuk periode tagihan {tanggal}";    
                $msg1 = strtr($msg, $vars);
                $operator = User::role("Operator")->where("daerah_id", '=',Pelanggan::where('id', $request->kategori)->first()->daerah_id)->first();
                Helper::sendWa($operator->no_telepon,$msg1);
                Helper::sendWa(Auth::user()->no_telepon, $msg1);
                Mail::to($operator->email)->send(new Emailing(Pelanggan::where('id', $request->kategori)->first(), false, $operator, $date_formated));
                Mail::to(Auth::user()->email)->send(new Emailing(Pelanggan::where('id', $request->kategori)->first(), false, $operator, $date_formated));
                // dd(Auth::user());
                Log::create([
                    'pengguna' => Auth::user()->name,
                    'kegiatan' => "Melaporkan Penggunaan periode ". $date_formated ." dengan jumlah pembayaran sebesar Rp. ".$pembayaran
                ]);

            }
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Tagihan']);
            // for($i; $i->format('n') <= Carbon::make($request->tanggal_akhir)->format('n'); $i->addMonth(1)){
            //     if($i->format('n') == 1 && Carbon::make($request->tanggal_akhir)->format('n') == 12 && Carbon::now()->format('n') >= 1){
            //         break;
            //     }

            //     // dd(Auth::user()->id);
            
                    
            //     // return $denda_harian;
            //     // return $kategori_npa.' => pemakaian = '.$request->pemakaian.' x '.$harga.' = '.number_format($pembayaran);
               
            //     if($key <= array_key_last($request->pemakaian)){
            //         $key++;
            //     }
            // }
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage(), $key, $request->all(), $request->pemakaian[$key], Auth::user());
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Tagihan : '.$e->getMessage()])->withErrors($request->all());
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
        $years = collect();
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        $month = [];
        $carbon = Carbon::now();
        foreach (range($carbon->startOfYear()->format('m'),$carbon->endOfYear()->format('m')) as $value) {
            $month[] = [
                'month'=>Carbon::create($carbon->format('Y').'-'.$value.'-01')->isoFormat('MMMM'),
                'value'=>Carbon::create($carbon->format('Y').'-'.$value.'-01')->format('m'),
            ];
        }
        // return Auth::user()->pelanggan->id;
        $tagihan = Tagihan::where(['id'=>$id])->firstOrFail();
        
        if ($tagihan->status !== 0) {
            return redirect()->back()->with(['error'=>'data sudah tidak dapat diubah karena telah diverifikasi']);
        }

        $start = \Carbon\Carbon::now()->subYear()->startOfYear();
        $end = \Carbon\Carbon::now()->subYear()->endOfYear();
        $months_to_render = $start->diffInMonths($end);
    
        $dates = [];
    
        for ($i = 0; $i <= $months_to_render; $i++) {
            $dates[] = $start->isoFormat('MMMM');
            $start->addMonth();
        }

        $pelanggans = [];

        if(Auth::user()->name != 'Admin'){
            $pelanggans = Auth::user()->load(['pelanggan'=>function($query){
                $query->with('kategori_npa');
            }])->load('daerah');
        }
        

        // $pelanggans =  Auth::user()->pelanggan;

        $years = [];
        for ($year=2020; $year <= date('Y'); $year++) $years[$year] = $year;

        
        // dd($dates);
        // dd(Carbon::now()->format('D MMMM Y, H:i:s'));
        $present = Carbon::now()->addMonth(-1);

        $data = [
            'title'=>$this->title,
            'route'=>$this->routeName,
            'tagihan'=>$tagihan,
            'month'=>collect($month)->pluck('month','value'),
            'selected_month'=>$carbon->create($tagihan->tanggal)->format('m'),
            'year'=>$years,
            'selected_year'=>$carbon->create($tagihan->tanggal)->format('Y'),
            'pelanggan'=>Auth::user()->pelanggan,
            'present' => $present,
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
       $tagihan = Tagihan::findOrFail($id);
       $rules = [];
       // return $request->all();
        if ($request->meteran == 1) { // kondisi jika menggunakan meteran
            $rules=[
                'meter_sebelumnya'=>'numeric|required|digits_between:1,100',
                'meter_sekarang'=>'numeric|required|digits_between:1,100',
            ];
        }elseif($request->meteran == 0){ //kondisi jika tidak menggunakan meteran
            $rules = [
                'pemakaian'=>'numeric|required|digits_between:1,100',
            ];
        }

        $other_rules = [
            'bulan' => 'numeric|required|digits_between:1,2',
            'tahun' => 'numeric|required|digits_between:4,4',
        ];

        $validator = $request->validate(array_merge($rules,$other_rules));

        //$this->cekTunggakan(Auth::user()->id,$request->tahun.'-'.$request->bulan.'-10',$request);
       
        
        $kategori_npa = $tagihan->pelanggan->kategori_npa->npa->first();
        $pembayaran = null;
        $harga = null;
        // $list_harga = null;
        // dd($kategori_npa);
        if ($kategori_npa->volume_akhir) {//jika pengguna bukan BUMN dan BUMD
            $list_harga = NPA::whereHas('kategori.pelanggan',function($query){
                $query->where(['user_id'=>Auth::user()->id]);
            })->whereHas('wilayah.pelanggan',function($query){
                $query->where(['daerah_id'=>Auth::user()->daerah_id]);
            })->with('kategori')
            ->get();
            // 
            
            if ($list_harga->count() > 0) { // jika pengguna berada pada list harga
                $counter_volume = $request->pemakaian;
                foreach ($list_harga as $keys => $value){
                    if ($counter_volume >= 0 && $list_harga[$keys]->volume_akhir == 50){
                        if($counter_volume - 50 > 0){
                            $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                            $pembayaran += ($list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga) * 10/100; 
                            $counter_volume -= $list_harga[$keys]->volume_akhir;
                        } else {
                            $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                            $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                            break;
                        }
                    } else if ($counter_volume >= 0 && $list_harga[$keys]->volume_akhir == 500){
                        if($counter_volume - 450 > 0){
                            $harga += 450 * $list_harga[$keys]->harga;
                            $pembayaran += (450 * $list_harga[$keys]->harga) * 10/100; 
                            $counter_volume -= 450;
                        } else {
                            $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                            $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                            break;
                        }
                    } else if($counter_volume > 0 && $list_harga[$keys]->volume_akhir == 1000){
                        if($counter_volume - 500 > 0){
                            $harga += 500 * $list_harga[$keys]->harga;
                            $pembayaran += (500 * $list_harga[$keys]->harga) * 10/100; 
                            $counter_volume -= 500;
                        } else {
                            $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                            $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                            break;
                        }
                    } else if($counter_volume > 0 && $list_harga[$keys]->volume_akhir == 2500){
                        if($counter_volume - 1500 > 0){
                            $harga += 1500 * $list_harga[$keys]->harga;
                            $pembayaran += (1500 * $list_harga[$keys]->harga) * 10/100; 
                            $counter_volume -= 1500;
                        } else {
                            $harga += $list_harga[$keys]->volume_akhir * $list_harga[$keys]->harga;
                            $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                            break;
                        }
                    } else if($counter_volume > 0 && $list_harga[$keys]->volume_awal == 2501){
                            $harga += $counter_volume * $list_harga[$keys]->harga;
                            $pembayaran += ($counter_volume * $list_harga[$keys]->harga) * 10/100; 
                            break;
                    }
                }
               
            }else{
                return redirect()->back()->with(['error'=>'Maaf area anda belum terdaftar pada kategori NPA kami']);
            }
            
        }else{//jika pengguna adalah BUMD atau BUMN
            $harga = $kategori_npa->harga;
            $pembayaran = ($request->pemakaian * $harga)*10/100;
        }
        // dd($pembayaran, $request->pemakaian * $harga, $harga);
        if ($tagihan->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($tagihan->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->cekDendaKeterlambatan(Auth::user()->id,$tanggal,$pembayaran,$date);
        $denda_admin = $this->cekDendaAdmin(Auth::user()->id,$request->tahun.'-'.$request->bulan.'-10',$request);
        // return $denda_admin;
        if ($request->has('file')) {
            // return 'halo';
            $request->validate([
                'file' => 'max:5000',
            ]);

            $file=$request->file('file');
            $direktori=public_path().'/storage/image/';          
            $nama_file=str_replace(' ','-',$request->file->getClientOriginalName());
            File::delete($direktori.$tagihan->file_name);
            $file_format= $request->file->getClientOriginalExtension();
            $uploadSuccess = $request->file->move($direktori,$nama_file);
        }
        try{
            DB::beginTransaction();
            // $number = rand(0,1000);
            // $txt = date("Ymdhis").''.$number;
            // $id = $txt.$number;
            $request['id_tagihan'] = $tagihan->id_tagihan;
            $request['pelanggan_id'] = $tagihan->pelanggan_id;
            $request['tanggal'] = $request->tahun.'-'.$request->bulan.'-20';
            $request['meter_penggunaan_awal'] = $request->meter_sebelumnya;
            $request['meter_penggunaan'] = $request->meter_sekarang !=0?$request->meter_sekarang:$request->pemakaian;
            $request['jumlah_pembayaran'] = $pembayaran;
            $request['tarif'] = $harga;
            $request['file_name'] = isset($request->file)?$nama_file:$tagihan->file_name;
            $request['file_path'] = isset($request->file)?'/storage/image/':$tagihan->file_path;
            $request['pesan'] = null;
            $request['status'] = 0;
            $request['denda_harian'] = $denda_Keterlambatan;
            $request['denda_admin'] = $denda_admin;
            
            $tagihan->update($request->all());
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Edit Penggunaan periode ".$request->tahun.'-'.$request->bulan." menjadi " . $pembayaran,
            ]);
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Tagihan : '.$tagihan->id_tagihan]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Tagihan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $query = Tagihan::findOrFail($id);
            if ($query->status !== 0) {
                return redirect()->back()->with(['error'=>'data sudah tidak dapat dihapus karena telah diverifikasi']);
            }
            File::delete(public_path().'/storage/image/'.$query->file_name);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus Penggunaan dengan jumlah pembayaran sebesar Rp. ".$query->jumlah_pembayaran,
            ]);
            $query->delete();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Tagihan : '.$query->id_tagihan]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Tagihan : '.$e->getMessage()]);
        }
    }

    public function show_file($id)
    {
        $datas = Tagihan::find($id);

        $url = $datas->file_path.''.$datas->file_name;

        // dd($url);
        return response()->download(asset($url));
    }

    public function nota($id)
    {
        $datas = Tagihan::find($id);
        if ($datas->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($datas->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$datas->jumlah_pembayaran,$date);

        $data = [
            'datas'=>$datas,
            'denda_keterlambatan'=>$denda_Keterlambatan,
        ];
        return view('tagihan.nota')->with($data);
    }
    public function surat($id)
    {
        $datas = Tagihan::find($id);
        if ($datas->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($datas->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$datas->jumlah_pembayaran,$date);
        $jabatanKepala = Jabatan::where('jabatan', 'LIKE', '%'.'Kepala'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();
        $jabatanBendahara = Jabatan::where('jabatan', 'LIKE', '%'.'Bendahara'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();


        $jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();
        $counter = 0;
		if($jenis_denda){
			if($jenis_denda->tanggal_jt == 30 || $jenis_denda->tanggal_jt == 31){
			$diff = Carbon::create($datas->tanggal->format("Y-m"))->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff == 0){
					if(Carbon::now()->format("d") == Carbon::now()->endOfMonth()->format('d')){
						$counter = $diff * 2;
					}
				}
				else if($diff > 15){
					$counter = 15 * 2;
    			} 
    			else if($diff > 0) {
					$counter = $diff * 2;
				}
			} else {
				$diff = Carbon::create($datas->tanggal->format('Y-m'))->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff > 15){
					$counter = 15 * 2;
				} else if($diff == 0){
				if(Carbon::now()->addMonth(-1)->format("d") > $jenis_denda->tanggal_jt){
					$counter= $diff * 2;
				} 
				} else if($diff > 0){
					if(Carbon::now()->format("d") > $jenis_denda->tanggal_jt){
						$counter= $diff * 2;
					} else {
						$counter = $diff * 2;
                    }
                }
            }
        }
    //     $hariLibur = hariLibur::select('tanggal')->get();
    //     $hlArr = [];
    //         foreach($hariLibur as $hl){
    //             array_push($hlArr, $hl->tanggal);
    //         }
    //         $counter = 0;
	// $i = Carbon::make($datas->pembayaran->tanggal);

	// for ($i;  $i < Carbon::now(); $i->addDay(1)) { 
	// 	if(in_array($i->format("Y-m-d"), $hlArr)){
	// 		continue;
	// 	}
	// 	if(Carbon::make($tanggal) < Carbon::now()){
	// 		$counter++;
	// 	}
	// }

    $hlArr = [];

    $hariLibur = hariLibur::select('tanggal')->get();
    foreach($hariLibur as $hl){
         array_push($hlArr, $hl->tanggal);
    }

    $i = Carbon::make($datas->pembayaran->tanggal);
    $counter_libur = 0;
    $limit = Carbon::now()->addDay(15);
    for ($i;  $i < $limit; $i->addDay(1)) {
		if(in_array($i->format("Y-m-d"), $hlArr)){
           $counter_libur += 1;
		}
	}
    $deadline = Carbon::now()->addDay(15 + $counter_libur)->format("d-M-Y");
        $data = [
            'datas'=>$datas,
            'denda_keterlambatan'=>$denda_Keterlambatan,
            'awalan_surat' => Surat::where("daerah_id", '=', Auth::user()->daerah_id)->first(),
            'counter' => $counter,
            'deadline' => $deadline,
            'kepala'=>$jabatanKepala,
            'bendahara'=>$jabatanBendahara
        ];
        return view('tagihan.surat')->with($data);
    }
    public function lunas($id)
    {
        $datas = Tagihan::find($id);
        $jabatanKepala = Jabatan::where('jabatan', 'LIKE', '%'.'Kepala'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();
        $jabatanBendahara = Jabatan::where('jabatan', 'LIKE', '%'.'Bendahara'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();
        if ($datas->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($datas->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$datas->jumlah_pembayaran,$date);
        $digit = new NumberFormatter('id', NumberFormatter::SPELLOUT);

        $data = [
            'datas'=>$datas,
            'denda_keterlambatan'=>$denda_Keterlambatan,
            'awalan_surat' => Lunas::where("daerah_id", '=', Auth::user()->daerah_id)->first(),
            'word'=>$digit->format($datas->jumlah_pembayaran + $datas->denda_admin + $datas->denda_keterlambatan),
            'kepala'=>$jabatanKepala,
            'bendahara'=>$jabatanBendahara
        ];
        return view('tagihan.lunas')->with($data);
    }
    public function pemberitahuan($id)
    {
        // dd(Auth::user()->pelanggan->daerah);
        $datas = Tagihan::find($id);
        $jabatanKepala = Jabatan::where('jabatan', 'LIKE', '%'.'Kepala'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();
        $jabatanBendahara = Jabatan::where('jabatan', 'LIKE', '%'.'Bendahara'."%")->where('daerah_id', $datas->pelanggan->daerah->id)->first();
        if ($datas->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($datas->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$datas->jumlah_pembayaran,$date);
        $digit = new NumberFormatter('id', NumberFormatter::SPELLOUT);

        $data = [
            'datas'=>$datas,
            'denda_keterlambatan'=>$denda_Keterlambatan,
            'awalan_surat' => Lunas::where("daerah_id", '=', Auth::user()->daerah_id)->first(),
            'word'=>$digit->format($datas->jumlah_pembayaran + $datas->denda_admin + $datas->denda_keterlambatan),
            'kepala'=>$jabatanKepala,
            'bendahara'=>$jabatanBendahara
        ];
        return view('tagihan.pemberitahuan')->with($data);
    }

    public function penetapan($id)
    {
        try {
            //code...
            $datas = Tagihan::find($id);
        if ($datas->tanggal->format('m') == Carbon::now()->format('m')){
            $tanggal = Carbon::now()->format('Y-m-d');
        }else{
            $tanggal = Carbon::create($datas->tanggal->format('Y-m').'-20')->format('Y-m-d');
        }
        $date = Carbon::now()->format('Y-m-d');
                // return $tanggal;
        $denda_Keterlambatan = $this->refreshDendaKeterlambatan(Auth::user()->id,$tanggal,$datas->jumlah_pembayaran,$date);

        $jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();
        $counter = 0;
		if($jenis_denda){
			if($jenis_denda->tanggal_jt == 30 || $jenis_denda->tanggal_jt == 31){
			$diff = Carbon::create($datas->tanggal->format("Y-m"))->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff == 0){
					if(Carbon::now()->format("d") == Carbon::now()->endOfMonth()->format('d')){
						$counter = $diff * 2;
					}
				}
				else if($diff > 15){
					$counter = 15 * 2;
    			} 
    			else if($diff > 0) {
					$counter = $diff * 2;
				}
			} else {
				$diff = Carbon::create($datas->tanggal->format("Y-m"))->diffInMonths(Carbon::now()->format('Y-m'));
				if($diff > 15){
					$counter = 15 * 2;
				} else if($diff == 0){
				if(Carbon::now()->addMonth(-1)->format("d") > $jenis_denda->tanggal_jt){
					$counter= $diff * 2;
				} 
				} else if($diff > 0){
					if(Carbon::now()->format("d") > $jenis_denda->tanggal_jt){
						$counter= $diff * 2;
					} else {
						$counter = $diff * 2;
                    }
                }
            }
        }
        // dd($datas);
        $data = [
            'datas'=>$datas,
            'denda_keterlambatan'=>$denda_Keterlambatan,
            'awalan_surat' => Penetapan::where("daerah_id", '=', Auth::user()->daerah_id)->first(),
            'counter' => $counter
        ];
        return view('tagihan.penetapan')->with($data);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function tagihan_telat()
    {
        try {
            $datas = Tagihan::doesntHave('pembayaran')->orderBy('created_at', 'DESC')->get();

            $tagihan = [];

            foreach($datas as $d){
                if($d->tanggal->format('Y-m-d') < date('Y-m-d')){
                    $diff = $d->tanggal->diffInDays(Carbon::now()->format('Y-m-d'));
                    $tagihan[] = [
                        'id' => $d->id,
                        'no_tagihan' => $d->id_tagihan,
                        'no_pelanggan' => $d->pelanggan->id_pelanggan,
                        'nama' => $d->pelanggan->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'hari' => $diff.' Hari'
                    ];
                }
            }

            $data = [
                'status' => 200,
                'data' => $tagihan,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Tagihan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
    }

    // public function checkRunggakan(){

    // }
    public function upload(Request $request){
        $route = $this->routeName;
        $title = $this->title;
        $datas = Tagihan::where("id", "=", $request->id)->first();
        return view('tagihan.upload', compact('route', 'title', 'datas'));
    }
    public function bukti(Request $request, $id){
        $direktori=public_path().'/storage/image/';          
        $nama_file=str_replace(' ','-',$request->file->getClientOriginalName());
        $file_format= $request->file->getClientOriginalExtension();
        $tagihan = Tagihan::findOrFail($id);

        DB::beginTransaction();
        try{
            $request['file_path'] = '/storage/image/';
            $request['file_name'] = $nama_file;
            $tagihan->update(['status' => 3]);
            if($tagihan->pembayaran->file_name == null){
                $uploadSuccess = $request->file->move($direktori,$nama_file);
                $tagihan->pembayaran()->update($request->except(['_token', "file"]));
                Log::create([
                    'pengguna' => Auth::user()->name,
                    'kegiatan' => "Upload Bukti Pembayaran untuk penggunaan periode ".$tagihan->tanggal." dengan jumlah Rp. ".$tagihan->jumlah_pembayaran,
                ]);
            } else {
                File::delete($direktori.$tagihan->pembayaran->file_name);
                $uploadSuccess = $request->file->move($direktori,$nama_file);
                $tagihan->pembayaran()->update($request->except(['_token', "file"]));
                Log::create([
                    'pengguna' => Auth::user()->name,
                    'kegiatan' => "Edit Bukti Pembayaran"
                ]);
            }
            $operator = User::role("Operator")->where("daerah_id", '=', $tagihan->pelanggan->daerah_id)->first();
            $admin = User::role("Admin")->first();
            $user = $tagihan->pelanggan->name;
            $periode = $tagihan->tanggal->isoFormat("MMMM-Y");
            $msg1 = "Pelanggan atas nama $user telah mengupload bukti pembayaran untuk tagihan periode $periode";
            Helper::sendWa($operator->no_telepon,$msg1);
            Helper::sendWa($admin->no_telepon,$msg1);
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Bukti Pembayaran : ']);
        } catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    

    public function va(Request $request, $id){
        try {
            $tagihan = Tagihan::where(['id'=>$id])->firstOrFail();
            $amount = $tagihan->jumlah_pembayaran+$tagihan->denda_harian+$tagihan->denda_admin;
            $code = null;
            $institution = null;
            $qrisUsername = null;
            $vaUsername = null;
            if($tagihan->pelanggan->daerah_id == 9){
                $code = '1118';
                $vaUsername = 'PAPWILBPP';
                $institution = '230302013';
                $qrisUsername = 'PAP.WIL.BPP';
            } else if($tagihan->pelanggan->daerah_id == 13){
                $code = '1117';
                $vaUsername = 'PAPWILSMD';
                $institution = '230302017';
                $qrisUsername = 'PAP.WIL.SMD';
            } else if($tagihan->pelanggan->daerah_id == 10){
                $code = '1119';
                $vaUsername = 'PAPWILBONTANG';
                $institution = '230302014';
                $qrisUsername = 'PAP.WIL.BONTANG';
            } else if($tagihan->pelanggan->daerah_id == 14){
                $code = '1126';
                $vaUsername = 'PAPWILPASER';
                $institution = '230302016';
                $qrisUsername = 'PAP.WIL.PASER';
            } else if($tagihan->pelanggan->daerah_id == 15){
                $code = '1125';
                $vaUsername = 'PAPWILPPU';
                $institution = '230302015';
                $qrisUsername = 'PAP.WIL.PPU';
            } else if($tagihan->pelanggan->daerah_id == 16){
                $code = '1122';
                $vaUsername = 'PAPWILKUBAR';
                $institution = '230302019';
                $qrisUsername = 'PAP.WIL.KUBAR';
            } else if($tagihan->pelanggan->daerah_id == 18){
                $code = '1121';
                $vaUsername = 'PAPWILKUTIM';
                $institution = '230302021';
                $qrisUsername = 'PAP.WIL.KUTIM';
            } else if($tagihan->pelanggan->daerah_id == 19){
                $code = '1120';
                $vaUsername = 'PAPWILKUKAR';
                $institution = '230302020';
                $qrisUsername = 'PAP.WIL.KUKAR';
            } else if($tagihan->pelanggan->daerah_id == 20){
                $code = '1124';
                $vaUsername = 'PAPWILBERAU';
                $institution = '230302018';
                $qrisUsername = 'PAP.WIL.BERAU';
            }
            if ($tagihan->status != 2) {
                //pengecekan jika sudah pernah melakukan request va atau qris
                if ($tagihan->waktu_token) {
                    //pengecekan status pebayaran
                    if ($this->cekStatus($tagihan, $code, $vaUsername, $institution, $qrisUsername)) {
                        $response = [
                            'html'=>'<div class="response-pesan"><div class="alert alert-success"><h2>Tagihan ini telah lunas</h2></div></div>',
                        ];
                    }else{
                        //pengecekan waktu generate va atau qris
                        if (Carbon::now()->diffInMinutes($tagihan->waktu_token) > 60 ){
                            if ($tagihan->metode == 'Virtual Account'){
                                $number = $code.substr($tagihan->id_tagihan,-15);
                                // $this->deleteVa($number, $code, $vaUsername, $institution, $qrisUsername);
                            }
                            if ($request->types == 'Virtual Account') {
                                $response = $this->requestVA($tagihan, $code, $vaUsername, $institution, $qrisUsername);
                                Log::create([
                                    'pengguna' => Auth::user()->name,
                                    'kegiatan' => "Me-request kode VA dengan tagihan sebesar ".$tagihan->jumlah_pembayaran
                                ]);
                            }elseif($request->types == 'QRIS'){
                                if ($amount > 10000000) {
                                    $response = [
                                        'html'=>'<div class="response-pesan"><div class="alert alert-danger"><h4>Tagihan maksimal untuk metode pembayaran QRIS adalah Rp 10.000.000 silakan gunakan metode Virtual Account untuk menyelesaikan pembayaran!</h4></div></div>',
                                    ];
                                    return response()->json(array_merge($response,['status'=>200]),200);  
                                }else{
                                    $response = $this->requestQRIS($tagihan, $code, $vaUsername, $institution, $qrisUsername);
                                    Log::create([
                                        'pengguna' => Auth::user()->name,
                                        'kegiatan' => "Me-request kode QRIS dengan tagihan sebesar ".$tagihan->jumlah_pembayaran
                                    ]);
                                }
                            }
                            $tagihan->update([
                                'waktu_token' => Carbon::now(),
                                'metode' => $request->types,
                                'qris'=>isset($response['qris'])?$response['qris']:null,
                                'kd_tagihan'=>(string)$code.substr($tagihan->id_tagihan,-15),
                            ]);
                        }else{
                            $times = 60 - Carbon::now()->diffInMinutes($tagihan->waktu_token);
                            $code = $code;
                            $html = view('layouts.includes.response-has-va-or-qris',compact('tagihan','times', 'code'))->render();
                            if ($tagihan->metode == 'Virtual Account') {
                                // dd($this->updateVA($tagihan, $code, $vaUsername, $institution, $qrisUsername));
                                $this->updateVA($tagihan, $code, $vaUsername, $institution, $qrisUsername);
                                Log::create([
                                    'pengguna' => Auth::user()->name,
                                    'kegiatan' => "Mengupdate kode VA dengan tagihan sebesar ".$tagihan->jumlah_pembayaran
                                ]);
                            }
                            $response = [
                                'html'=>$html,
                            ];
                        }
                    }    
                }else{
                    
                    if ($request->types == 'Virtual Account') {
                        $response = $this->requestVA($tagihan, $code, $vaUsername, $institution, $qrisUsername);
                        Log::create([
                            'pengguna' => Auth::user()->name,
                            'kegiatan' => "Me-request kode VA dengan tagihan sebesar ".$tagihan->jumlah_pembayaran
                        ]);
                    }elseif($request->types == 'QRIS'){
                        //jika tagihan di atas 10 jt maka akan ditolak
                        if ($amount > 10000000) {
                            $response = [
                                'html'=>'<div class="response-pesan"><div class="alert alert-danger"><h4>Tagihan maksimal untuk metode pembayaran QRIS adalah Rp 10.000.000 silakan gunakan metode Virtual Account untuk menyelesaikan pembayaran!</h4></div></div>',
                            ];
                            return response()->json(array_merge($response,['status'=>200]),200);  
                        }else{
                            $response = $this->requestQRIS($tagihan, $code, $vaUsername, $institution, $qrisUsername);
                            Log::create([
                                'pengguna' => Auth::user()->name,
                                'kegiatan' => "Me-request kode QRIS dengan tagihan sebesar ".$tagihan->jumlah_pembayaran
                            ]);
                        }
                    }
                    $tagihan->update([
                        'waktu_token' => Carbon::now(),
                        'metode' => $request->types,
                        'qris'=>isset($response['qris'])?$response['qris']:null,
                        'kd_tagihan'=>(string)$code.substr($tagihan->id_tagihan,-15),
                    ]);
                }
            }else{
                $response = [
                    'html'=>'<div class="response-pesan"><div class="alert alert-success"><h2>Tagihan ini telah lunas</h2></div></div>',
                ];
            }

            return response()->json(array_merge($response,['status'=>200]),200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return response()->json(['status'=>500,'message'=>'terjadi kesalahan'],500);
        }
    }
}
