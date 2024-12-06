<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Tagihan;

use App\Models\Pelanggan;
use App\Models\Pelunasan;
use App\Models\UptDaerah;
use App\Models\Pembayaran;
use App\Models\KategoriNPA;
use Illuminate\Http\Request;
use App\Exports\ExportPembayaran;
use App\Models\TagihanPemasangan;
use App\Models\PembayaranPemasangan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    protected $routeName = 'laporan';
    protected $viewName = 'laporan';
    protected $title = 'Laporan';
    
    
    public function pembayaran(Request $request)
    {
        
        $route = $this->routeName;
        $title = $this->title.' Pembayaran';
        $wilayah = UptDaerah::all();
        $kategori = KategoriNPA::all()->where('aktif', 1)->groupBy('sektor');
        $klasifikasi = KategoriNPA::all()->where('aktif', 1);
        return view($this->viewName.'.pembayaran',compact('route','title', 'wilayah', 'kategori', 'klasifikasi'));
    }

    public function datatable_pembayaran(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        $wilayah = $request->wilayah;

        // $datas = Pembayaran::join('tagihans','tagihans.id','=','pembayarans.tagihan_id')->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('pembayarans.id','pembayarans.id_pembayaran','tagihans.tanggal','pelanggans.id','pelanggans.name','tagihans.jumlah_pembayaran', 'tagihans.denda_harian', 'tagihans.tanggal_penerimaan', 'tagihans.meter_penggunaan')->whereBetween('tagihans.tanggal',[$date1, $date2])->get();
        
        
        if (Auth::user()->roles->first()->name =='Admin') {
            $datas = Tagihan::where('status', 2)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->select('tagihans.tanggal','pelanggans.id','pelanggans.name', 'kategori_npa.sektor', 'kategori_npa.kategori','tagihans.jumlah_pembayaran','tagihans.status', 'tagihans.denda_harian', 'tagihans.denda_admin', "tagihans.id", 'tagihans.meter_penggunaan', 'tagihans.tanggal_penerimaan', 'tagihans.tanggal_akhir', 'upt_daerahs.nama_daerah', 'upt_daerahs.id', 'tagihans.metode', 'tagihans.tarif')->whereBetween('tagihans.tanggal_penerimaan',[$date1, $date2]);
            // $datas = Pembayaran::doesntHave('pelunasan')->whereHas('tagihan.pelanggan.daerah',function($query){
            //     $query->where(['nama_daerah'=>Auth::user()->daerah->nama_daerah]);
            // })
            if($wilayah){
                $datas->where('upt_daerahs.id', $wilayah);
            }
            if($request->sektor){
                $datas->where('kategori_npa.sektor', $request->sektor);
            }
            if($request->klasifikasi){
                $datas->where('kategori_npa.kategori', $request->klasifikasi);
            }
            if($request->tipe){
                $datas->where("tagihans.metode", $request->tipe);
            }
            } else {
               $datas = Tagihan::where('status', 2)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->select('tagihans.tanggal','pelanggans.id','pelanggans.name', 'kategori_npa.sektor', 'kategori_npa.kategori','tagihans.jumlah_pembayaran','tagihans.status', 'tagihans.denda_harian', 'tagihans.denda_admin', "tagihans.id", 'tagihans.meter_penggunaan', 'tagihans.tanggal_penerimaan', 'tagihans.tanggal_akhir', 'upt_daerahs.nama_daerah', 'upt_daerahs.id', 'tagihans.metode', 'tagihans.tarif')->whereBetween('tagihans.tanggal_penerimaan',[$date1, $date2]);
                
            if($wilayah){
                $datas->where('upt_daerahs.id', $wilayah);
            }

            if($request->sektor){
                $datas->where('kategori_npa.sektor', $request->sektor);
            }
            if($request->klasifikasi){
                $datas->where('kategori_npa.kategori', $request->klasifikasi);
            }
            if($request->tipe){
                $datas->where("tagihans.metode", $request->tipe);
            }
        
        }
        // $datas = Tagihan::all();
        
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('id_pembayaran', function($data){
                return $data->id;
            })
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('tarif',function($data){
                $tarif = $data->tarif;
                return "Rp. ".number_format($tarif);
            })
            ->editColumn('denda',function($data){
                $jumlah = $data->denda_harian;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('total_bayar',function($data){
                $jumlah = $data->jumlah_pembayaran + $data->denda_harian;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('npa',function($data){
                $jumlah = $data->meter_penggunaan;
                return number_format($jumlah);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F-Y');
            })
            ->editColumn('tanggal_akhir',function($data){
                 return date('F-Y', strtotime($data->tanggal_akhir));
            })
            ->editColumn('tanggal_penerimaan',function($data){
                return date('d-F-Y', strtotime($data->tanggal_penerimaan));
            })
            ->editColumn('sektor',function($data){
                if($data->sektor){
                    return $data->sektor;
                } else {
                    return "-";
                }
            })
            ->editColumn('metode', function($data){
                if($data->metode){
                    return $data->metode;
                } else {
                    return "-";
                }
            })
            ->editColumn('kategori',function($data){
                if($data->kategori){
                    return $data->kategori;
                } else {
                    return "-";
                }
            })
            ;

        return $datatables->make(true);
    }

    public function exportPembayaran(Request $request){
        // dd(0);
        return Excel::download(new ExportPembayaran($request->date1, $request->date2, $request->wilayah, $request->sektor, $request->klasifikasi, $request->metode), 'Pembayaran.xlsx');
    }
    
    public function total(Request $request){
       try {

            if(isset($request->date1) && isset($request->date2)){
               $datasJumlahPembayaran = Tagihan::where('status', 2)->whereBetween('tagihans.tanggal',[$request->date1, $request->date2])->sum('jumlah_pembayaran');
               $datasTotalDenda = Tagihan::where('status', 2)->whereBetween('tagihans.tanggal',[$request->date1, $request->date2])->sum('denda_harian');
            }else{
                $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('tagihans.id','id_tagihan','pelanggans.name')->get();
            }

            $data = [
                'status' => 200,
                'data' => $datasJumlahPembayaran,
                'denda' => $datasTotalDenda
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => $th->getMessage(),
                'data' => null,
            ];
        }
        return response()->json($data, 200);
    }

    public function pelanggan()
    {
        $route = $this->routeName;
        $title = $this->title. ' Pelanggan';
        $wilayah = UptDaerah::all();
        $kategori = KategoriNPA::all()->where('aktif', 1)->groupBy('sektor');
        $klasifikasi = KategoriNPA::all()->where('aktif', 1);
        // dd($kategori);
        // dd(User::with('pelanggans')->count());
        // dd(User::join('upt_daerahs', 'users.daerah_id', '=', 'upt_daerahs.id')->where('email', 'blue@gmail.com')->first()->pelanggan);
        return view($this->viewName.'.pelanggan',compact('route','title', 'wilayah', 'kategori', 'klasifikasi'));
    }

    public function datatable_pelanggan(Request $request)
    {
        // $date1 = $request->date1;
        // $date2 = $request->date2;
        if(Auth::user()->roles->first()->name == "Admin"){
            // $datas = Pelanggan::join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            // ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            // ->select('no_pelanggan','name','no_telepon','pelanggans.created_at','pelanggans.id','nik', 'upt_daerahs.id', 'upt_daerahs.nama_daerah', 'kategori_npa.kategori', 'kategori_npa.sektor');  
            $datas = User::with('daerah')->with('pelanggan');

            if($request->wilayah){
                $datas->where('daerah_id', $request->wilayah);
            }
        } else {
            $datas = User::with('daerah')->with('pelanggan');
            if($request->wilayah){
                $datas->where('daerah_id', $request->wilayah);
            }
    
        }
        if($request->sektor){
            $datas->whereHas('pelanggan.kategori_npa', function (Builder $query) use ($request){
                $query->where('sektor', $request->sektor);
            });
            // dd($datas->toSql());
            
        }

        if($request->klasifikasi){
            $datas->whereHas('pelanggan.kategori_npa', function (Builder $query) use ($request){
                $query->where('kategori', $request->klasifikasi);
            });
        }
        
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('sektor',function($data){
                // dd(User::first()->pelanggan);
                if ($data->pelanggan->count() > 0) {
                    return $data->pelanggan->map(function($pelanggan){
                        if($pelanggan->kategori_npa == null){
                            return 'Belum Ada Sektor';
                        }
                        return '<li>'.$pelanggan->kategori_npa->sektor.'</li>';
                    })->implode("");
                }else{
                    return '-';
                }
            })
            ->addColumn('kategori',function($data){
                // dd(User::first()->pelanggan);
                if ($data->pelanggan->count() > 0) {
                    return $data->pelanggan->map(function($pelanggan){
                        if($pelanggan->kategori_npa == null){
                            return 'Belum Ada Klasifikasi';
                        }
                        return '<li>'.$pelanggan->kategori_npa->kategori.'</li>';
                    })->implode("");
                }else{
                    return '-';
                }
            })
            ->addColumn('nama_daerah', function($data){
                return $data->daerah->nama_daerah;
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['sektor', 'kategori']);

        return $datatables->make(true);
    }

    public function pembayaran_pemasangan()
    {
        $route = $this->routeName;
        $title = $this->title.' Pembayaran Pemasangan';
        return view($this->viewName.'.pembayaran_pemasangan',compact('route','title'));
    }

    public function datatable_pembayaran_pemasangan(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;

        $datas = PembayaranPemasangan::join('tagihan_pemasangans','tagihan_pemasangans.id','=','pembayaran_pemasangans.tagihan_pemasangan_id')->join('pelanggans','pelanggans.id','=','tagihan_pemasangans.pelanggan_id')->select('pembayaran_pemasangans.id','pembayaran_pemasangans.id_pembayaran_pemasangans','pembayaran_pemasangans.created_at','pelanggans.id','pelanggans.name','pembayaran_pemasangans.jumlah_pembayaran')->whereHas('tagihan_pemasangan', function($q)use($date1,$date2){
            $q->whereBetween('tagihan_pemasangans.tanggal',[$date1,$date2]);
        });

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('d F Y');
            });

        return $datatables->make(true);
    }

    public function tagihan()
    {
        $route = $this->routeName;
        $title = $this->title.' Tagihan';
        $kategori = KategoriNPA::all()->where('aktif', 1)->groupBy('sektor');
        $klasifikasi = KategoriNPA::all()->where('aktif', 1);
        $wilayah = UptDaerah::all();
        return view($this->viewName.'.tagihan',compact('route','title', 'wilayah', 'kategori', 'klasifikasi'));
    }
    public function kategori()
    {
        $route = $this->routeName;
        $title = $this->title.' kategori';
        $kategori = KategoriNPA::all()->where('aktif', 1)->groupBy('sektor');
        $klasifikasi = KategoriNPA::all()->where('aktif', 1);
        $wilayah = UptDaerah::all();
        if(Auth::user()->roles->first()->name == "Admin"){
            $sumKosong = Tagihan::join("pelanggans", 'tagihans.pelanggan_id', '=', 'pelanggans.id')
        ->where('kategori_industri_id', null)->sum("tagihans.jumlah_pembayaran");
        } else {
            $sumKosong = Tagihan::join("pelanggans", 'tagihans.pelanggan_id', '=', 'pelanggans.id')
        ->where('kategori_industri_id', null)->where('pelanggans.daerah_id', Auth::user()->daerah_id)->sum("tagihans.jumlah_pembayaran");
        }
        // dd(KategoriNPA::selectRaw('sum(`tagihans`.`jumlah_pembayaran`) as jumlah, `kategori_npa`.`kategori`, `kategori_npa`.`id`')->join('pelanggans', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')->leftJoin('tagihans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')->groupBy('kategori_npa.id')->get());
        return view($this->viewName.'.kategori',compact('route','title', 'kategori', 'klasifikasi', 'wilayah', 'sumKosong'));
    }

    public function datatable_kategori(Request $request){
        if(Auth::user()->roles->first()->name == "Admin"){

        
        $datas = KategoriNPA::selectRaw('sum(`tagihans`.`jumlah_pembayaran`) as total, `kategori_npa`.`kategori`, `kategori_npa`.`id`, `kategori_npa`.`sektor`', )
        ->leftJoin('pelanggans', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
        ->leftJoin('tagihans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
        ->groupBy('kategori_npa.id');

        if($request->wilayah){
            $datas->where('daerah_id', $request->wilayah);
        }
    } else {
        $datas = KategoriNPA::selectRaw('sum(`tagihans`.`jumlah_pembayaran`) as total, `kategori_npa`.`kategori`, `kategori_npa`.`id`, `kategori_npa`.`sektor`', )
        ->leftJoin('pelanggans', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
        ->leftJoin('tagihans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
        // ->where('pelanggans.daerah_id', Auth::user()->daerah_id)
        ->groupBy('kategori_npa.id');
    }
    if($request->wilayah){
        $datas->where('daerah_id', $request->wilayah);
    }
        if($request->sektor){
            $datas->where('kategori_npa.sektor', $request->sektor);
        }
        if($request->klasifikasi){
            $datas->where('kategori_npa.kategori', $request->klasifikasi);
        }
        if($request->date1 && $request->date2){
            $datas->whereBetween('tagihans.tanggal_penerimaan', [$request->date1, $request->date2]);
        }

        $datatables = DataTables::of($datas)
        ->addIndexColumn()
        ->addColumn('kategori', function($data){
            return $data->kategori;   
        })
        ->editColumn('jumlah', function($data){
            return "Rp. ".number_format($data->total);
        });

        return $datatables->make(true);
    }

    public function datatable_tagihan(Request $request)
    {
        $date1 = $request->date1;
        $date2 = $request->date2;
        
        if(Auth::user()->roles->first()->name == "Admin"){

        
        if($request->status_pembayaran == '2'){
            $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan', 'kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }else if($request->status_pembayaran == '1'){
            $datas = Tagihan::where('status', 2)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }else if($request->status_pembayaran == '0'){
            $datas = Tagihan::where('status', 0)->orWhere('status', 1)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }
        
        if($request->wilayah){
            $datas->where("upt_daerahs.id", $request->wilayah);
        }
    } else {
        if($request->status_pembayaran == '2'){
            $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            // ->where('pelanggans.daerah_id', Auth::user()->daerah_id)
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan', 'kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }else if($request->status_pembayaran == '1'){
            $datas = Tagihan::where('status', 2)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            // ->where('pelanggans.daerah_id', Auth::user()->daerah_id)
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }else if($request->status_pembayaran == '0'){
            $datas = Tagihan::where('status', 0)->orWhere('status', 1)
            ->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            ->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')
            ->leftJoin('kategori_npa', 'pelanggans.kategori_industri_id', '=', 'kategori_npa.id')
            // ->where('pelanggans.daerah_id', Auth::user()->daerah_id)
            ->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','kategori_npa.sektor', 'kategori_npa.kategori','pelanggans.name', 'tagihans.status','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'upt_daerahs.id', 'upt_daerahs.nama_daerah')->whereBetween('tagihans.created_at',[$date1,$date2]);
        }
        if($request->wilayah){
            $datas->where("upt_daerahs.id", $request->wilayah);
        }
    }
        if($request->sektor){
            $datas->where('kategori_npa.sektor', $request->sektor);
        }
        if($request->klasifikasi){
            $datas->where('kategori_npa.kategori', $request->klasifikasi);
        }

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F');
            })
            ->addColumn('tahun', function ($data) {
                return $data->tanggal->format('Y');
            })
            ->addColumn('status', function ($data){
                if($data->status == 1 || $data->status == 0 || $data->status == 3){
                    return "Belum Lunas";
                } else if($data->status == 2){
                    return "lunas";
                }
            })
            ->editColumn('sektor',function($data){
                if($data->sektor){
                    return $data->sektor;
                } else {
                    return "-";
                }
            })
            ->editColumn('kategori',function($data){
                if($data->kategori){
                    return $data->kategori;
                } else {
                    return "-";
                }
            })
            ;

        return $datatables->make(true);
    }

    public function tagihan_pemasangan()
    {
        $route = $this->routeName;
        $title = $this->title.' Tagihan Pemasangan';
        return view($this->viewName.'.tagihan_pemasangan',compact('route','title'));
    }

    public function datatable_tagihan_pemasangan(Request $request)
    {
        $datas = TagihanPemasangan::join('pelanggans','pelanggans.id','=','tagihan_pemasangans.pelanggan_id')->select('tagihan_pemasangans.id','id_tagihan_pemasangan','tanggal','pelanggans.name','tagihan_pemasangans.jumlah_pembayaran')->get();

        // dd($datas);

        $tagihan = [];

        
        foreach($datas as $d){
            // dd($d->jumlah_pembayaran);
            $jumlah = $d->pembayaran->sum('jumlah_pembayaran');

            if($request->status_pembayaran == '2'){
                    $tagihan[] = [
                        'id' => $d->id,
                        'id_tagihan_pemasangan' => $d->id_tagihan_pemasangan,
                        'tanggal' => $d->tanggal->format('d F Y'),
                        'name' => $d->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'status' => $d->status
                    ];
            }else if($request->status_pembayaran == '1'){
                if($jumlah >= $d->jumlah_pembayaran){
                    $tagihan[] = [
                        'id' => $d->id,
                        'id_tagihan_pemasangan' => $d->id_tagihan_pemasangan,
                        'tanggal' => $d->tanggal->format('d F Y'),
                        'name' => $d->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'status' => $d->status
                    ];
                }else if($jumlah < $d->jumlah_pembayaran){
                    // return "Sudah Lunas";
                }else{
                    $tagihan[] = [
                        'id' => $d->id,
                        'id_tagihan_pemasangan' => $d->id_tagihan_pemasangan,
                        'tanggal' => $d->tanggal->format('d F Y'),
                        'name' => $d->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'status' => $d->status
                    ];
                }
            }else if($request->status_pembayaran == '0'){
                if($jumlah < $d->jumlah_pembayaran){
                    $tagihan[] = [
                        'id' => $d->id,
                        'id_tagihan_pemasangan' => $d->id_tagihan_pemasangan,
                        'tanggal' => $d->tanggal->format('d F Y'),
                        'name' => $d->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'status' => $d->status
                    ];
                }else if($jumlah >= $d->jumlah_pembayaran){
                    // return "Sudah Lunas";
                }else{
                    $tagihan[] = [
                        'id' => $d->id,
                        'id_tagihan_pemasangan' => $d->id_tagihan_pemasangan,
                        'tanggal' => $d->tanggal->format('d F Y'),
                        'name' => $d->name,
                        'jumlah_pembayaran' => $d->jumlah_pembayaran,
                        'status' => $d->status
                    ];
                }
            }
 
        }

        $datatables = DataTables::of($tagihan)
            ->addIndexColumn();
            // ->editColumn('jumlah_pembayaran',function($data){
            //     $jumlah = $data->jumlah_pembayaran;
            //     return "Rp. ".number_format($jumlah);
            // })
            // ->editColumn('tanggal',function($data){
            //     return $data->tanggal->format('d F Y');
            // });
            // ->addColumn('tahun', function ($data) {
            //     return $data->tanggal->format('Y');
            // })
            // ->addColumn('status', function ($data){
            //     return $data->status;
            // })

        return $datatables->make(true);
    }
    
    
}
