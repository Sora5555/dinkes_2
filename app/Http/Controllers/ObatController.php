<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Obat';
    protected $viewName = 'obat';
    protected $title = 'Obat';
    public function index(Request $request)
    {

        $obat = Obat::all();
        $obat_tersedia = Obat::where('status', 1)->count();
        $total_obat = Obat::count();

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'obat' =>  $obat,
            'obat_tersedia' => $obat_tersedia,
            'total_obat' => $total_obat,
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
        $obat = Obat::where('id', $request->id)->first();
        $err = "";
        if($request->name == "diatas_80" && $obat->status == 0){
            $obat->update([
                'status' => 1,
            ]);
        } else if($request->name == "diatas_80" && $obat->status == 1){
            $obat->update([
                'status' => 0,
            ]);
        } else if($request->name == "dibawah_80" && $obat->status == 0){
            $obat->update([
                'status' => 2,
            ]);
        } else if($request->name == "dibawah_80" && $obat->status == 2){
            $obat->update([
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
    public function ObatNew(Request $request)
    {
        try {
            Obat::create($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Obat']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->routeName.'.index')->with(['failure'=>$th->getMessage()]);
        }
        //
    }
}
