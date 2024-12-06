<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\TemplateEmail;
use App\Models\TemplatePesan;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TemplateEmailController extends Controller
{
    protected $routeName = 'template_email';
    protected $viewName = 'template_email';
    protected $title = 'Template Email';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $route = $this->routeName;
        return view($this->viewName.'.index',compact('route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {
        $datas = TemplateEmail::select('id','nama_email','isi_email');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $route = 'template_pesan';
                return view('layouts.includes.table-action',compact('data','route'));
            });

        return $datatables->make(true);
    }

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
        //
        $validator = $request->validate([
            'nama_email' => 'required|string|max:100',
            'isi_email'=>'string|required|max:255',
        ]);

        try{
            $query = TemplateEmail::create([
                'nama_email' => $request->nama_email,
                'isi_email' => $request->isi_email,
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menambah Template Email"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Template Email : '.$query->name]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Template Email : '.$e->getMessage()])->withErrors($request->all());
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
        try{
            $query = TemplateEmail::findOrFail($id);
            $query->delete();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus Template Email"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Template Email : '.$query->id_tagihan]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Template Pesan : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
