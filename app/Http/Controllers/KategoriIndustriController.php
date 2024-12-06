<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\KategoriIndustri;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KategoriIndustriController extends Controller
{
    protected $routeName = 'kategori_industri';
    protected $viewName = 'kategori_industri';
    protected $title = 'Kategori Industri';

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

    public function datatable(){
        $datas = KategoriIndustri::select('nama_industri','created_at','kategori_industris.id');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) {
                $route = 'kategori_industri';
                return view('layouts.includes.table-action',compact('data','route'));
            });

        return $datatables->make(true);
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
        
        return view($this->viewName.'.create',compact('route','title'));
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
            'nama_industri' => 'required|string|max:100'
        ]);
        
        try {
            $query = KategoriIndustri::create([
                'nama_industri' => $request->nama_industri
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menambah Kategori Industri"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Kategori Industri : '.$query->name]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Kategori Industri : '.$e->getMessage()])->withErrors($request->all());
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
        $datas = KategoriIndustri::findOrFail($id);
        $title = $this->title;
        $route = $this->routeName;
        return view($this->viewName.'.edit', compact('datas','route','id','title'));
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
            'nama_industri' => 'required|string|max:100'
        ]);
        
        try {
            $query = KategoriIndustri::find($id);
            $query->update([
                'nama_industri' => $request->nama_industri
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengubah Kategori Industri"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Kategori Industri : '.$query->name]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Kategori Industri : '.$e->getMessage()])->withErrors($request->all());
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

        try {
            $query = KategoriIndustri::find($id);
            $query->delete();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengubah Kategori Industri"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Kategori Industri : '.$query->name]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Kategori Industri : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
