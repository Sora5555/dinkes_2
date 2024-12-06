<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PembayaranPemasangan;
use App\Models\TagihanPemasangan;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PembayaranPemasanganController extends Controller
{
    protected $routeName = 'pembayaran_pemasangan';
    protected $viewName = 'pembayaran_pemasangan';
    protected $title = 'Pembayaran Pemasangan';

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
        $datas = PembayaranPemasangan::join('tagihan_pemasangans','tagihan_pemasangans.id','=','pembayaran_pemasangans.tagihan_pemasangan_id')->join('pelanggans','pelanggans.id','=','tagihan_pemasangans.pelanggan_id')->select('pembayaran_pemasangans.id','pembayaran_pemasangans.id_pembayaran_pemasangan','pembayaran_pemasangans.created_at','pelanggans.id_pelanggan','pelanggans.name','pembayaran_pemasangans.jumlah_pembayaran');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('d F Y');
            })
            ->addColumn('action', function ($data) {
                $route = 'pembayaran_pemasangan';
                return view('layouts.includes.table-action-nota',compact('data','route'));
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

        $tagihan_pemasangans = TagihanPemasangan::all();

        return view($this->viewName.'.create',compact('route','title','tagihan_pemasangans','request'));
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
            'id_tagihan_pemasangan' => 'required|string|max:100',
            'jumlah_pembayaran' => 'required|numeric|digits_between:1,11'
        ]);

        $datas = TagihanPemasangan::find($request->id_tagihan_pemasangan);
        try{
            $number = rand(0,1000);
            $txt = date("Ymdhis").''.$number;
            
            $id = $txt.$number;
            $query = PembayaranPemasangan::create([
                'id_pembayaran_pemasangan' => $txt,
                'tagihan_pemasangan_id' => $datas->id,
                'jumlah_pembayaran' => $request->jumlah_pembayaran,
            ]);

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Pembayaran : '.$query->id_pembayaran_pemasangan]);
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
        $datas = PembayaranPemasangan::findOrFail($id);

        $tagihan_pemasangans = TagihanPemasangan::all();

        $route = $this->routeName;
        return view($this->viewName.'.edit', compact('datas','route','title','id','tagihan_pemasangans'));
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
            'id_tagihan_pemasangan' => 'required|string|max:100',
            'jumlah_pembayaran' => 'required|numeric|digits_between:1,11'
        ]);

        $datas = TagihanPemasangan::find($request->id_tagihan_pemasangan);

        try{

            $query = PembayaranPemasangan::find($id);

            $query->update([
                'tagihan_pemasangan_id' => $datas->id,
                'jumlah_pembayaran' => $request->jumlah_pembayaran,
            ]);

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Pembayaran : '.$query->id_pembayaran_pemasangan]);
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
    public function destroy($id)
    {
        try{
            $query = PembayaranPemasangan::findOrFail($id);
            $query->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Pembayaran Pemasangan : '.$query->id_pembayaran_pemasangan]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Pembayaran Pemasangan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    public function nota($id)
    {
        $datas = PembayaranPemasangan::findOrFail($id);
        return view('pembayaran_pemasangan.nota', compact('datas'));
    }
}
