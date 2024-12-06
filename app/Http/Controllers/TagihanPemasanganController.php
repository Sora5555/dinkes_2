<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pelanggan;
use App\Models\TagihanPemasangan;
use App\Models\PembayaranPemasangan;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

use Auth;

class TagihanPemasanganController extends Controller
{
    protected $routeName = 'tagihan_pemasangan';
    protected $viewName = 'tagihan_pemasangan';
    protected $title = 'Tagihan Pemasangan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if (Auth::user()->role->nama_role == 'Kasir') {
            return redirect(route('cek_tagihan.tagihan_pemasangan'));
        }

        $route = $this->routeName;
        $title = $this->title;
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function datatable()
    {
        $datas = TagihanPemasangan::join('pelanggans','pelanggans.id','=','tagihan_pemasangans.pelanggan_id')->select('tagihan_pemasangans.id','id_tagihan_pemasangan','tanggal','pelanggans.name','tagihan_pemasangans.jumlah_pembayaran');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('d F Y');
            })
            // ->addColumn('tahun', function ($data) {
            //     return $data->tanggal->format('Y');
            // })
            ->addColumn('status', function ($data){
                return $data->status;
            })
            ->addColumn('action', function ($data) {
                $route = 'tagihan_pemasangan';
                $status = $data->status;
                return view('layouts.includes.table-action-alt-2',compact('data','route','status'));
            });

        return $datatables->make(true);
    }

    public function data(Request $request)
    {
        $datas = TagihanPemasangan::find($request->id);

        $pembayaran_pemasangan = PembayaranPemasangan::where('tagihan_pemasangan_id', $datas->id);

        $total = $pembayaran_pemasangan->sum('jumlah_pembayaran');

        $pembayaran = $pembayaran_pemasangan->count();

        $jumlah_pembayaran = 3300000 - $total;

        $type = $datas->tipe_pembayaran;
        
        if($type == 0){
            $tipe_pembayaran = 'Cash';
        }else if($type == 1){
            $tipe_pembayaran = 'Angsuran';
        }else{
            $tipe_pembayaran = 'Cash';
        }

        $data = [
            'name' => $datas->pelanggan->name,
            'no_telepon' => $datas->pelanggan->no_telepon,
            'alamat' => $datas->pelanggan->alamat,
            'jumlah_pembayaran' => $jumlah_pembayaran,
            'tipe_pembayaran' => $tipe_pembayaran,
            'pembayaran' => $pembayaran
        ];

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->routeName;
        $title = $this->title;

        $pelanggans = Pelanggan::all();

        return view($this->viewName.'.create',compact('route','title','pelanggans'));
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
            'id_pelanggan' => 'required|string|max:100',
            'tipe_pembayaran' => 'required|numeric|between:0,1'
        ]);
        // dd($request->tipe_pembayaran);
        $datas = Pelanggan::find($request->id_pelanggan);
        $jumlah_pembayaran = 3300000;



        try{
            $number = rand(0,1000);
            $txt = date("Ymdhis").''.$number;
            
            $id = $txt.$number;
            $query = TagihanPemasangan::create([
                'id_tagihan_pemasangan' => $txt,
                'tanggal' => date('Y-m-d'),
                'pelanggan_id' => $datas->id,
                'jumlah_pembayaran'=> $jumlah_pembayaran,
                'tipe_pembayaran' => $request->tipe_pembayaran
            ]);

            if (isset($request->tipe_pembayaran)) {
                $number = rand(0,1000);
                $txt = date("Ymdhis").''.$number;
                $id = $txt.$number;

                if ($request->tipe_pembayaran == 0) {    
                    $query2 = PembayaranPemasangan::create([
                        'id_pembayaran_pemasangan' => $txt,
                        'tagihan_pemasangan_id' => $query->id,
                        'jumlah_pembayaran' => $jumlah_pembayaran,
                    ]);
                }else if($request->tipe_pembayaran == 1){
                    $query2 = PembayaranPemasangan::create([
                        'id_pembayaran_pemasangan' => $txt,
                        'tagihan_pemasangan_id' => $query->id,
                        'jumlah_pembayaran' => 1300000,
                    ]);
                }
            }

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Tagihan Pemasangan : '.$query->id_tagihan_pemasangan]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Tagihan Pemasangan : '.$e->getMessage()])->withErrors($request->all());
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
        $datas = TagihanPemasangan::findOrFail($id);
        $route = $this->routeName;
        $title = $this->title;

        $pelanggans = Pelanggan::all();
        //dd($datas->tanggal->format("n"));

        return view($this->viewName.'.edit', compact('datas','route','title','id','pelanggans'));
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
        $validator = $request->validate([
            'id_pelanggan' => 'required|string|max:100',
            'tipe_pembayaran' => 'required|numeric|between:0,1'
        ]);

        $datas = Pelanggan::find($request->id_pelanggan);
        try{
            $query = TagihanPemasangan::find($id);
            $query->update([
                'pelanggan_id' => $datas->id,
                'tipe_pembayaran' => $request->tipe_pembayaran
            ]);

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Tagihan Pemasangan : '.$query->id_pembayaran]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Tagihan Pemasangan : '.$e->getMessage()])->withErrors($request->all());
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
            $query = TagihanPemasangan::findOrFail($id);
            $query->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Tagihan Pemasangan : '.$query->id_tagihan_pemasangan]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Tagihan Pemasangan : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
