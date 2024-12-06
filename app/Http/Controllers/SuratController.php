<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\UptDaerah;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuratController extends Controller
{
    protected $routeName = 'surat';
    protected $title = 'surat';
    protected $viewName = 'surat';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = $this->title;
        $route = $this->routeName;
        return view($this->viewName.'.index', compact('title', 'route'));
    }

    public function datatable(){
        $data = Surat::all();
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
            //code...
            $surat = UptDaerah::findOrFail($request->daerah_id)->surat;
            if(!$surat){
            $surat = Surat::create($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Surat : '.$surat->id]);
            } else {
                    //throw $th;
            return redirect()->back()->with(['error'=>"Awalan Surat untuk wilayah ini sudah ada"]);
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
        $surat = Surat::where("id", '=', $id)->first();
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
            $surat2 = Surat::findOrFail($id);
            $surat = UptDaerah::findOrFail($request->daerah_id)->surat;
            if(isset($surat)){
                if($surat->daerah_id == $surat2->daerah_id){
                    $surat2->update($request->all());
                     return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Surat : '.$surat2->id]);
               }
            }
            if(!$surat){
            $surat2->update($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Surat : '.$surat2->id]);
            } else {
                    //throw $th;
            return redirect()->back()->with(['error'=>"Awalan Surat untuk wilayah ini sudah ada"]);
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
        //
        $surat = Surat::findOrFail($id);
        try {
        $surat->delete();
        return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Hapus Data Surat : '.$surat->id]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error'=>$th->getMessage()]);
        }
    }
}
