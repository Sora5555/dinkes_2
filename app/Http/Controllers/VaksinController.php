<?php

namespace App\Http\Controllers;

use App\Models\Vaksin;
use Illuminate\Http\Request;

class VaksinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Vaksin';
    protected $viewName = 'vaksin';
    protected $title = 'Vaksin';
    public function index(Request $request)
    {

        $vaksin = Vaksin::all();
        $vaksin_tersedia = Vaksin::where('status', 1)->count();
        $total_vaksin = Vaksin::count();

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'vaksin' =>  $vaksin,
            'vaksin_tersedia' => $vaksin_tersedia,
            'total_vaksin' => $total_vaksin,
        ];

        return view($this->viewName.'.index')->with($data);
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
        $vaksin = Vaksin::where('id', $request->id)->first();
        $err = "";
        if($request->name == "diatas_80" && $vaksin->status == 0){
            $vaksin->update([
                'status' => 1,
            ]);
        } else if($request->name == "diatas_80" && $vaksin->status == 1){
            $vaksin->update([
                'status' => 0,
            ]);
        } else if($request->name == "dibawah_80" && $vaksin->status == 0){
            $vaksin->update([
                'status' => 2,
            ]);
        } else if($request->name == "dibawah_80" && $vaksin->status == 2){
            $vaksin->update([
                'status' => 0,
            ]);
        } else {
            $err = "Hanya Satu kondisi yang boleh di tentukan";
        }

        return response()->json([
            'status' => 'success',
            'err' => $err,
        ]);
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
    }
    public function VaksinNew(Request $request)
    {
        try {
            Vaksin::create($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Vaksin']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->routeName.'.index')->with(['failure'=>$th->getMessage()]);
        }
        //
    }
}
