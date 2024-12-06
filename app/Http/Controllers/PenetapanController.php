<?php

namespace App\Http\Controllers;

use App\Models\Penetapan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\UptDaerah;

class PenetapanController extends Controller
{
    protected $routeName = 'penetapan';
    protected $title = 'Penetapan';
    protected $viewName = 'Penetapan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            //code...
            $title = $this->title;
        $route = $this->routeName;
        return view($this->viewName.'.index', compact('title', 'route'));
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function datatable(){
        $data = Penetapan::all();
        $datatable = DataTables::of($data)
        ->editColumn('nama_daerah', function($data){
            return $data->daerah->nama_daerah;
        })->editColumn('urutan', function($data){
            return $data->urutan;
        })->editColumn("kode_wilayah", function($data){
            return $data->kode_wilayah;
        })->editColumn("tahun", function($data){
            return $data->tahun;
        })->editColumn('action', function($data){
            $route = $this->routeName;
            return view('layouts.includes.table-action',compact('data','route'));
        });
        return $datatable->make('true');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = UptDaerah::pluck('nama_daerah', 'id');
        $title = $this->title;
        $route = $this->routeName;
        return view($this->viewName.".create", compact("data", 'title', 'route'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'awalan_surat' => 'required',
            'daerah_id' => 'required',
        ]);
        
        $lunas = UptDaerah::findOrFail($request->daerah_id)->penetapan;
        
        if(!$lunas){
            $surat = Penetapan::create($request->all());
            return redirect(route('penetapan.index'))->with(['success'=>'Berhasil Menambah Data Surat : '.$surat->id]);
            //throw $th;
        } else {
            return redirect()->back()->with(['error'=>'Awalan surat untuk wilayah ini sudah ada']);
        //
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
        $data = UptDaerah::pluck('nama_daerah', 'id')->toArray();
        $surat = Penetapan::where("id", '=', $id)->first();
        return view($this->viewName.'.edit', compact('data', 'title', 'route', 'surat'));
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
        $request->validate([
            'awalan_surat' => 'required',
            'daerah_id' => 'required',
        ]);
        $lunas2 = Penetapan::findOrFail($id);
        $lunas = UptDaerah::findOrFail($request->daerah_id)->penetapan;
        if(isset($lunas)){
            if($lunas->daerah_id == $lunas2->daerah_id){
                $lunas2->update($request->all());
                 return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Surat : '.$lunas2->id]);
           }
        }
            if(!$lunas){
            $lunas2->update($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Surat : '.$lunas2->id]);
            } else {
                    //throw $th;
            return redirect()->back()->with(['error'=>"Awalan Surat untuk wilayah ini sudah ada"]);
            }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $penetapan = Penetapan::find($id);

            $penetapan->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Hapus Data Surat : '.$penetapan->id]);            
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
}
