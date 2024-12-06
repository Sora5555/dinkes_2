<?php

namespace App\Http\Controllers;

use App\Exports\Pus4TExport;
use App\Models\Desa;
use App\Models\Pus;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Pus4TController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Pus4T';
    protected $viewName = 'pus_4_t';
    protected $title = 'Pasangan Usia Subur Empat Terlalu';
    public function index(Request $request)
    {
        $unit_kerja = UnitKerja::all();
        // $desa = Desa::all();
        // foreach ($desa as $key => $value) {
        //     # code...
        //     Pus::create([
        //         'desa_id' => $value->id,
        //     ]);
        // }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
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
        $pus = Pus::where('id', $request->id)->first();
        $pus->update([
            $request->name => $request->value,
        ]);
        $pus_4_t = $pus->jumlah>0?number_format($pus->pus_4_t/$pus->jumlah * 100, 2):0;
        $pus_4_t_kb = $pus->jumlah>0?number_format($pus->pus_4_t_kb/$pus->jumlah * 100, 2):0;
        $pus_alki = $pus->jumlah>0?number_format($pus->pus_alki/$pus->jumlah * 100, 2):0;
        $pus_alki_kb = $pus->jumlah>0?number_format($pus->pus_alki_kb/$pus->jumlah * 100, 2):0;

        return response()->json([
            'status' => 'success',
            'pus_4_t' => $pus_4_t,
            'pus_4_t_kb' => $pus_4_t_kb,
            'pus_alki' => $pus_alki,
            'pus_alki_kb' => $pus_alki_kb,
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
    public function exportExcel()
    {
        try {
            return Excel::download(new Pus4TExport, 'PUS 4T_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
