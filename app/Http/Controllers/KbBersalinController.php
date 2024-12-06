<?php

namespace App\Http\Controllers;

use App\Exports\KbBersalinExport;
use App\Models\Desa;
use App\Models\IbuHamilDanBersalin;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class KbBersalinController extends Controller
{
    protected $routeName = 'KbBersalin';
    protected $viewName = 'kb_bersalin';
    protected $title = 'Peserta KB Pasca Bersalin';
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
        $IbuBersalin = IbuHamilDanBersalin::where('id', $request->id)->first();
        $IbuBersalin->update([
            $request->name => $request->value,
        ]);
        $kondom = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->kondom/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $pil = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->pil/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $suntik = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->suntik/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $mop = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->mop/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $mow = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->mow/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $akdr = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->akdr/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $implan = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->implan/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $mal = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->mal/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $efek_samping = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->efek_samping/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $komplikasi = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->komplikasi/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $kegagalan = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->kegagalan/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $dropout = $IbuBersalin->jumlah_ibu_bersalin>0?number_format($IbuBersalin->dropout/$IbuBersalin->jumlah_ibu_bersalin*100, 2):0;
        $jumlah = $IbuBersalin->kondom + $IbuBersalin->pil + $IbuBersalin->suntik + $IbuBersalin->mop + $IbuBersalin->mow + $IbuBersalin->akdr + $IbuBersalin->implan + $IbuBersalin->mal;
        $persen_jumlah = $IbuBersalin->jumlah_ibu_bersalin>0?number_format((($IbuBersalin->kondom + $IbuBersalin->pil + $IbuBersalin->suntik + $IbuBersalin->akdr + $IbuBersalin->mop + $IbuBersalin->mow + $IbuBersalin->implan + $IbuBersalin->mal)/$IbuBersalin->jumlah_ibu_bersalin) * 100, 2):0;

        return response()->json([
            'status' => 'success',
            'kondom' => $kondom,
            'pil' => $pil,
            'suntik' => $suntik,
            'mop' => $mop,
            'mow' => $mow,
            'akdr' => $akdr,
            'implan' => $implan,
            'mal' => $mal,
            'efek_samping' => $efek_samping,
            'komplikasi' => $komplikasi,
            'kegagalan' => $kegagalan,
            'dropout' => $dropout,
            'jumlah' => $jumlah,
            'persen_jumlah' => $persen_jumlah,
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
            return Excel::download(new KbBersalinExport, 'Kb Bersalin_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
