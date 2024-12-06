<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\JenisDenda;
use DB;

class DendaController extends Controller
{

    protected $routeName = 'jenis-denda';
    protected $viewName = 'jenis-denda';
    protected $title = 'Jenis Denda';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'=>$this->title,
            'route'=>$this->routeName,
        ];
        return view($this->viewName.'.index')->with($data);
    }

    public function datatable(){
        $model = JenisDenda::all();
        return DataTables::of($model)
            ->editColumn('nominal_denda',function($data){
                if ($data->jenis_pengali == 'rupiah') {
                    return 'Rp.'.number_format($data->nominal_denda);
                }elseif($data->jenis_pengali == 'persen'){
                    return $data->nominal_denda.'% dari tagihan';
                }
            })
            ->editColumn('tanggal_jt',function($data){
                return 'tanggal '.$data->tanggal_jt;
            })
            ->addColumn('action',function($data){
                $route = $this->routeName;
                return view('layouts.includes.table-action',compact('data','route'));
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'=>$this->title,
            'route'=>$this->routeName,
        ];
        return view($this->viewName.'.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'=>'required',
            'tanggal_jt'=>'required|numeric',
            'jenis_pengali'=>'required',
            'nominal_denda'=>'required',
        ],[
            'type.required'=>'jenis denda tidak boleh kosong',
            'tanggal_jt.required'=>'tanggal jatuh tempo tidak boleh kosong',
            'jenis_pengali.required'=>'bentuk denda tidak boleh kosong',
            'nominal_denda.required'=>'nominal denda tidak boleh kosong',
        ]);

        try {
            JenisDenda::create($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'berhasil mendambah jenis denda:'.$request->type]);
        } catch (\Exception $e) {
            return redirect()->route($this->routeName.'.index')->with(['error'=>'gagal mendambah jenis denda:'.$request->type]);
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
        $data = [
            'title'=>$this->title,
            'route'=>$this->routeName,
            'denda'=>JenisDenda::findOrFail($id),
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
         $request->validate([
            'type'=>'required',
            'tanggal_jt'=>'required|numeric',
            'jenis_pengali'=>'required',
            'nominal_denda'=>'required',
        ],[
            'type.required'=>'jenis denda tidak boleh kosong',
            'tanggal_jt.required'=>'tanggal jatuh tempo tidak boleh kosong',
            'jenis_pengali.required'=>'bentuk denda tidak boleh kosong',
            'nominal_denda.required'=>'nominal denda tidak boleh kosong',
        ]);

        try {
            JenisDenda::findOrFail($id)->update($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'berhasil mengubah jenis denda:'.$request->type]);
        } catch (\Exception $e) {
            return redirect()->route($this->routeName.'.index')->with(['error'=>'gagal mengubah jenis denda:'.$request->type]);
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
            JenisDenda::destroy($id);
            return redirect()->route($this->routeName.'.index')->with(['success'=>'berhasil menghapus jenis denda']);
        } catch (\Exception $e) {
             return redirect()->route($this->routeName.'.index')->with(['error'=>'gagal menghapus jenis denda']);
        }
    }
}
