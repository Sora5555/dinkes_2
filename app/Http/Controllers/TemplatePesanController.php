<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\TemplatePesan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TemplatePesanController extends Controller
{
    protected $routeName = 'template_pesan';
    protected $viewName = 'template_pesan';
    protected $title = 'Template Pesan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        return view($this->viewName.'.index',compact('route'));
    }

    public function datatable()
    {
        $datas = TemplatePesan::select('id','nama_pesan','isi_pesan');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $route = 'template_pesan';
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
            'nama_pesan' => 'required|string|max:100',
            'isi_pesan'=>'string|required|max:255',
        ]);

        try{
            $query = TemplatePesan::create([
                'nama_pesan' => $request->nama_pesan,
                'isi_pesan' => $request->isi_pesan,
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menambah Template Pesan"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Template Pesan : '.$query->name]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Template Pesan : '.$e->getMessage()])->withErrors($request->all());
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
        $title = $this->title;
        $route = $this->routeName;

        $datas = TemplatePesan::find($id);
        return view($this->viewName.'.edit', compact('title','route','id','datas'));
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
        $datas = TemplatePesan::find($id);
        $validator = $request->validate([
            'nama_pesan' => 'required|string|max:100',
            'isi_pesan'=>'string|required|max:255',
        ]);
        try {
            $datas->update([
                'nama_pesan' => $request->nama_pesan,
                'isi_pesan' => $request->isi_pesan,
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Edit Template Pesan"
            ]);

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Template Pesan : '.$datas->nama_pesan   ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Template Pesan : '.$e->getMessage()])->withErrors($request->all());
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
            $query = TemplatePesan::findOrFail($id);
            $query->delete();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Hapus Template Pesan"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Template Pesan : '.$query->id_tagihan]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Template Pesan : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
