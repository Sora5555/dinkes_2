<?php

namespace App\Http\Controllers;

use App\Models\visiRpjmd;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisiRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'visi_rpjmd';
    protected $viewName = 'visi_rpjmd';
    protected $title = 'Visi RPJMD';
    public function index()
    {
        //
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
        ];
        return view($this->routeName.'.index')->with($data);
    }

    public function datatable(Request $request){

        $datas = visiRpjmd::get();

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('nama',function($data){
                return $data->nama;
            })
            ->editColumn('tahun_awal',function($data){
                return $data->tahun_awal;
            })
            ->editColumn('tahun_akhir',function($data){
                return $data->tahun_akhir;
            })
            ->addColumn('action', function ($data) {
                $route = 'visi_rpjmd';
                return view('layouts.includes.table-action-jabatan',compact('data','route'));
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
        //
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
       try {
        visiRpjmd::create($request->all());

        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Visi RPJMD: '.$request->nama]);
       } catch (\Throwable $th) {
        //throw $th;
        dd($th->getMessage());
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

        $visiRpjmd = visiRpjmd::where('id', $id)->first();
        try {
            //code...
            $visiRpjmd->update($request->all());

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Visi RPJMD: '.$request->nama]);
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
    public function destroy($id)
    {
        //
        $visiRpjmd = visiRpjmd::where('id', $id)->first();
        
        try {
            //code...
            $visiRpjmd->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menghapus Data Visi RPJMD']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function apiEdit($id){
        $visiRpjmd = visiRpjmd::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $visiRpjmd,
        ]);
    }
}
