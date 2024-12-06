<?php

namespace App\Http\Controllers;

use App\Models\KelompokUmur;
use App\Models\MelekHuruf;
use Illuminate\Http\Request;

class MelekHurufController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'MelekHuruf';
    protected $viewName = 'melek_huruf';
    protected $title = 'Melek Huruf';
    public function index()
    {
        //
        $MelekHuruf = MelekHuruf::all();
        $KelompokUmur = KelompokUmur::where('batas_bawah', '>=', 15)->get();
        $laki_laki = $KelompokUmur->sum('laki_laki');
        $perempuan = $KelompokUmur->sum('perempuan');
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'MelekHuruf' => $MelekHuruf,
            'KelompokUmur' => $KelompokUmur,
            'laki_laki' => $laki_laki,
            'perempuan' => $perempuan,
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
        $MelekHuruf = MelekHuruf::where('id', $request->id)->first();
        $KelompokUmur = KelompokUmur::where('batas_bawah', '>=', 15)->get();
        $laki_laki = $KelompokUmur->sum('laki_laki');
        $perempuan = $KelompokUmur->sum('perempuan');
        $MelekHuruf->update([
            $request->name => $request->value,
        ]);
        $total_laki_laki_perempuan = $MelekHuruf->laki_laki + $MelekHuruf->perempuan;
        $persen_laki_laki = $laki_laki>0?number_format($MelekHuruf->laki_laki/$laki_laki * 100, 2):0;
        $persen_perempuan = $perempuan>0?number_format($MelekHuruf->perempuan/$perempuan * 100, 2):0;
        $persen_laki_laki_perempuan = $perempuan + $laki_laki>0?number_format(($MelekHuruf->perempuan + $MelekHuruf->laki_laki)/($perempuan + $laki_laki) * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'total_laki_laki_perempuan' => $total_laki_laki_perempuan,
            'persen_laki_laki' => $persen_laki_laki,
            'persen_perempuan' => $persen_perempuan,
            'persen_laki_laki_perempuan' => $persen_laki_laki_perempuan,
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
}
